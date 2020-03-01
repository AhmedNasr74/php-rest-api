<?php
$app->get('/test/services' , function($requet , $response){
    $json = $this->json;
    $response->getBody()->write($json->encode(['name' => 'ahdsdsdsmed']));
});