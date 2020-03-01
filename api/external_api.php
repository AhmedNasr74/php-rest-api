<?php
$app->get('/newsapi', function ( $request,  $response) {
    // echo $request['token'];
    // print_r($request);
    $Json = $this->json;
    $name = $request->getAttribute("name");
    $url = 'https://newsapi.org/v2/everything?q=bitcoin&apiKey=85626eadec2a4f178995ecfb19f50c23';
    $ch = curl_init();
    // set url
    curl_setopt($ch, CURLOPT_URL, $url);
    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
    // $output contains the output string
    $output = curl_exec($ch);
    // close curl resource to free up system resources
    curl_close($ch);
    $response->getBody()->write($Json->encode($output));
    return $response;
});