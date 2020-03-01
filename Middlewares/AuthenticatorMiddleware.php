<?php
use \Slim\Middleware\HttpBasicAuthentication\AuthenticatorInterface as Authenticator;
class AuthenticatorClass implements Authenticator
{
    public function __invoke($arguments = [])
    {
        $inputs = [
            'username' => filter_var($arguments['user']     , FILTER_SANITIZE_STRING),
            'password' => filter_var($arguments['password'] , FILTER_SANITIZE_STRING),
        ];
        $db = new Database;
        $inputparams = [
            ':name' =>      $inputs['username'],
            ':password' =>  $inputs['password'],
        ];
        $user = $db->Fetch('select * from users where name =:name AND password =:password', $inputparams);
        if (!empty($user)):
            return true;
        else:
            return false;
        endif; 
    }
}
$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    'path' => ['/JWTToken'],
    'Authenticator' => new AuthenticatorClass(),
    "error" => function ($rs , $response, $arguments) {
        $data = [];
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        $body = $response->getBody();
        $body->write(json_encode($data, JSON_UNESCAPED_SLASHES));
        return $response->withBody($body);
    }
    
]));