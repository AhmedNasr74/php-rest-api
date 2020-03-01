<?php

// test api with DB
$app->post('/user/login', function ($request, $response) {
    $result = [];
    if (isset($_SESSION['user'])):
        $result['status'] = 'faild';
        $result['message'] = 'There is logged in user';
    else:
        $data = $request->getParsedBody();
        $inputs = [
            'username' => filter_var($data['username'], FILTER_SANITIZE_STRING),
            'password' => filter_var($data['password'], FILTER_SANITIZE_STRING),
        ];
        $db = new Database;
        $inputparams = [
            ':name' => $inputs['username'],
            ':password' => $inputs['password'],
        ];
        $user = $db->Fetch('select * from users where name =:name AND password =:password', $inputparams);
        if (!empty($user)):
            $result['status'] = 'ok';
            $result['message'] = 'Welecom , ' . $inputs['username'] . " You Are Logged In.";
            $_SESSION['user'] = $user;
        else:
            $result['status'] = 'faild';
            $result['message'] = 'Invalid Info';
        endif;
    endif;
    $response->getBody()->write(json_encode($result));
    return $response;
});
$app->get('/user/get', function ($request, $response) {
    if (isset($_SESSION['user'])) {
        $result = [];
        $result['status'] = 'ok';
        $result['data'] = $_SESSION['user'];
        $response->getBody()->write(json_encode($result));

    }
});
$app->get('/user/logout', function ($request, $response) {
    // $this->JWT = new \Firebase\JWT\JWT;
    $result = [];
    if (isset($_SESSION['user'])) {
        $result['status'] = 'ok';
        $result['message'] = "User Logged out successfully";
        unset($_SESSION['user']);
        session_destroy();
    } else {
        $result['status'] = 'faild';
        $result['message'] = "There is no logged in user to let him logout";
    }
    $response->getBody()->write(json_encode($result));
});
//end test api with DB
