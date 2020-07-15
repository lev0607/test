<?php


use App\Database\DB;
use App\Http\JsonResponse;
use App\Http\Request;
use App\Models\Author;
use App\Models\Message;
use App\Repositories\DbAuthorRepository;
use App\Repositories\DbMessageRepository;


require '../vendor/autoload.php';

$request = new Request();
$database = new DB();
$conn = $database->getConnection();
$authorRepository = new DbAuthorRepository($conn);
$messageRepository = new DbMessageRepository($conn);

function hasLimitTime($time){
    $limitTime = 10;
    $lastMessageTime = strtotime($time);
    $currentTime = time();
    $difference = $currentTime - $lastMessageTime;

    return $difference < $limitTime;
}

$reqParams = [$request->getUri(), $request->getType(), $request->getMethod()];

$routeStore = ['/api/webhook', 'application/json', 'POST'];
$routeIndex = ['/api/messages', 'application/json', 'GET'];

if ($reqParams === $routeStore) {
    $data = $request->getJsonData();
    try {
        $countAddedMessages = 0;
        foreach ($data['messages'] as ['message' => $content, 'phone' => $phone]) {
            $authorId = $authorRepository->getId($phone);

            if (empty($authorId)) {
                $author = new Author($phone);
                $authorRepository->create($author);

                $message = new Message($authorRepository->getId($phone), $content);
                $messageRepository->create($message);
                $countAddedMessages++;
            } else {
                $time = $authorRepository->getLastMessageTime($phone);
                $oldContent = $messageRepository->find($authorId);

                if ($oldContent === $content && hasLimitTime($time)) {
                    continue;
                }

                $authorRepository->update($phone);

                $message = new Message($authorRepository->getId($phone), $content);
                $messageRepository->create($message);
                $countAddedMessages++;
            }
        }
        $body = ['status' => 'ok', 'body' => 'added ' . $countAddedMessages, 'code' => 200];
        $header = 'Content-Type: application/json';
        $response = new JsonResponse($body, $header);

        header($response->getHeader());
        echo $response->getBody();
    }
    catch(\PDOException $e) {
        $body = ["status" => "error", "body" => "not all added", "code" => 500];
        $header = 'Content-Type: application/json';
        $response = new JsonResponse($body, $header);

        header($response->getHeader());
        echo $response->getBody();
    }
}

if ($reqParams === $routeIndex) {

    $body = $messageRepository->findAll();
    $header = 'Content-Type: application/json';
    $response = new JsonResponse($body, $header);

    header($response->getHeader());
    echo $response->getBody();
}
