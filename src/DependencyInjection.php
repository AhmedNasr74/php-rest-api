<?php
use \Firebase\JWT\JWT;
$container = $app->getContainer();
$container['json'] = function($container)
{
    return new JsonService();
};

$container['JWT'] = function($container)
{
    
    return new JWT();
};