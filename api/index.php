<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, PUT, POST, PATCH, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
    header("HTTP/1.1 200 OK");
    exit();
}

require_once __DIR__ . '/vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;

$headers = apache_request_headers();

$app = new Silex\Application();


$app->get('login/{password}', function (Application $app, $password, Request $request) {
    $response = CannedResponse::success(Player::login($password));
    return new Response(json_encode($response['body']), $response['httpStatusCode']);
});

$app->get('everything/{playerID}', function (Application $app,$playerID, Request $request) {
    $everything['players'] = Player::getAll($playerID);
    $everything['bars'] = Bar::get();
    $response = CannedResponse::success($everything);
    return new Response(json_encode($response['body']), $response['httpStatusCode']);
});


$app->put('/players/{playerID}/{barID}/{actionID}', function (Application $app, $playerID, $barID, $actionID, Request $request) {
    $response = PlayerAction::upsert($barID, $playerID, $actionID);
    return new Response(json_encode($response['body']), $response['httpStatusCode']);
});

$app->delete('/players/{playerID}/{barID}', function (Application $app, $playerID, $barID, Request $request) {
    $response = PlayerAction::delete($barID, $playerID);
    return new Response(json_encode($response['body']), $response['httpStatusCode']);
});

$app->post('/players/{name}', function (Application $app, $name, Request $request) {
    $response = Player::add($name);
    return new Response(json_encode($response['body']), $response['httpStatusCode']);
});

$app->run();


