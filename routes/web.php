<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
date_default_timezone_set('Asia/Taipei');

$app->get('/', function () use ($app) {
    return $app->version();
});
$app->group(['prefix' => 'api/'], function ($app) {
    $app->post('signup/','UsersController@signup');
    $app->post('login/','UsersController@authenticate');
    $app->get('refreshtoken/','UsersController@refreshtoken');
    $app->get('tokenstatus/','UsersController@tokenstatus');
    $app->post('todo/','TodoController@store');
    $app->get('todo/', 'TodoController@index');
    $app->delete('todo/all/', 'TodoController@destroyall');
    $app->post('todo/{id}/', 'TodoController@update');
    $app->get('todo/{id}/', 'TodoController@show');
    $app->delete('todo/{id}/', 'TodoController@destroy');
});