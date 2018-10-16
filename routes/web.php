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

use Laravel\Socialite\Facades\Socialite;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'user'], function() use ($router){
    
    $router->get('new', ['uses' => 'UserController@loginUser']);
    $router->get('profile', ['uses' => 'UserController@getUserProfile']);
    
    $router->get('photos', ['uses' => 'UserController@showPhotos']);
    $router->post('create', ['uses' => 'UserController@createUser']);
    $router->get('me', ['uses' => 'UserController@getMe', 'middleware' => 'auth']);
    $router->get('facebook', ['uses' => 'UserController@getFacebookURI']);
    $router->get('facebookCallback', ['uses' => 'UserController@facebookCallback']);
});