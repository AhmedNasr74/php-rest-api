<?php
// Define app routes

$app->get('/test/optional[/{id}]', function ( $request,  $response) {
    $id = $request->getAttribute("id");
    if (!is_null($id)) {
        $response->getBody()->write("Hello, the id is " . $id);
    } else {
        $response->getBody()->write("Hello, the id is empty");
    }
    return $response;
});

$app->get('/unlimited/params[/{params:.*}]', function ( $request,  $response, $args) {
    $params = explode('/', $args['params']);

    return $response->getBody()->write(json_encode($params));
});

$app->get('/rgx/{id:[0-9]+}', function ( $request,  $response) {
    return $response->getBody()->write('id passed reqular expression');
});

$app->group('/group', function ($app) {
    $app->get('/', function (Request $request, Response $response) {
        return $response->getBody()->write('Group Test');
    });
    $app->group('/nested', function ($app) {
        $app->get('/', function (Request $request, Response $response) {
            return $response->getBody()->write('Nested Group Test');
        });
    });
});
$app->get('/stat', function ( $request,  $response) {

    $newresponse = $response->withStatus(404);
     $newresponse->getBody()->write("HI");
     return $newresponse;
});