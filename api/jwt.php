<?php
use \Firebase\JWT\JWT;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
$app->post('/JWTToken', function ($req, $res) {
    $MyJWT = $this->JWT;
    $Json = $this->json;
    $now = new DateTime();
    $future = new DateTime("now -1 minutes");
    $server = $req->getServerParams();
    $payload = [
        "iat" => $now->getTimeStamp(),
        // "exp" => $future->getTimeStamp(),
        "sub" => $server['PHP_AUTH_USER'],
    ];
    $secret = "supersecretkey";
    $token = $MyJWT->encode($payload, $secret, "HS512");
    $data["status"] = "ok";
    $data["token"] = $token;
    $_SESSION["token"] = $token;
    $data["payload"] = $payload;
    return $res->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->write($Json->encode($data));
});
$app->get('/token/destroy', function ($req, $res) 
{
    unset($_SESSION["token"]);
});