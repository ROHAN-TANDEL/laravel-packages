<?php

require "vendor/autoload.php";

$client = new GuzzleHttp\Client;
$url = 'http://localhost:4200'; 
$client_id = 2;
$client_secret = 'rskKTECsIYAApZXsaEV09R4CmMGObjnlQmCksCeI';
$email = 'fa@fa.com';
$password = 'asdasd';
try {
    $response = $client->post($url.'/oauth/token', [
        'form_params' => [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'password',
            'username' => $email,
            'password' => $password,
            'scope' => '*',
        ]
    ]);

    // You'd typically save this payload in the session
    $auth = json_decode( (string) $response->getBody() );

    $response = $client->get($url.'/api/todos', [
        'headers' => [
            'Authorization' => 'Bearer '.$auth->access_token,
        ]
    ]);

    $todos = json_decode( (string) $response->getBody() );

    $todoList = "";
    foreach ($todos as $todo) {
        $todoList .= "<li>{$todo->task}".($todo->done ? '✅' : '')."</li>";
    }

    echo "<ul>{$todoList}</ul>";
    echo "<ul>{$auth->access_token}</ul>";

} catch (GuzzleHttp\Exception\BadResponseException $e) {
    echo "Unable to retrieve access token.";
}