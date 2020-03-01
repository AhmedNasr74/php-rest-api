<?php
session_start();
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
require 'vendor/autoload.php';
require 'connect.php';
$app = new \Slim\App(new \Slim\Container(['settings' => ['displayErrorDetails' => true,],]));
RequireAll("services");
RequireAll("Middlewares");
RequireAll("src");
RequireAll("api");
$app->run();