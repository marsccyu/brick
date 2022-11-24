<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('home');
    $router->get('users', 'UsersController@index');
    $router->get('users/{id}/edit', 'UsersController@edit');
    $router->put('users/{id}', 'UsersController@update');

    $router->get('about', 'AboutController@index');
    $router->get('about/{id}/edit', 'AboutController@edit');
    $router->put('about/{id}', 'AboutController@update');

    $router->get('lessons', 'LessonsController@index');
    $router->get('lessons/create', 'LessonsController@create');
    $router->post('lessons', 'LessonsController@store');
    $router->get('lessons/{id}/edit', 'LessonsController@edit');
    $router->put('lessons/{id}', 'LessonsController@update');
    $router->delete('lessons/{id}', 'LessonsController@destroy');
    $router->get('api/lessons', 'LessonsController@apiIndex');

    $router->get('lesson_cards', 'LessonCardsController@index');
    $router->get('lesson_cards/{id}/edit', 'LessonCardsController@edit');
    $router->put('lesson_cards/{id}', 'LessonCardsController@update');

    $router->get('contactUs', 'ContactController@index');
    $router->get('contactUs/{id}/edit', 'ContactController@edit');
    $router->put('contactUs/{id}', 'ContactController@update');

    $router->get('point_tasks', 'PointTaskController@index');
    $router->get('point_tasks/create', 'PointTaskController@create');
    $router->post('point_tasks', 'PointTaskController@store');
    $router->get('point_tasks/{id}/edit', 'PointTaskController@edit');
    $router->put('point_tasks/{id}', 'PointTaskController@update');
    $router->delete('point_tasks/{id}', 'PointTaskController@destroy');

    $router->get('classes', 'ClassesController@index');
    $router->get('classes/create', 'ClassesController@create');
    $router->post('classes', 'ClassesController@store');
    $router->get('classes/{id}/edit', 'ClassesController@edit');
    $router->put('classes/{id}', 'ClassesController@update');
    $router->delete('classes/{id}', 'ClassesController@destroy');

    $router->get('site_config', 'SiteConfigController@index');
    $router->get('site_config/{id}/edit', 'SiteConfigController@edit');
    $router->put('site_config/{id}', 'SiteConfigController@update');

    $router->get('course', 'CourseController@index');
    $router->get('course/{id}/edit', 'CourseController@edit');
    $router->put('course/{id}', 'CourseController@update');

    $router->get('sign_in', 'SignInController@index');
    $router->get('sign_in/create', 'SignInController@create');
    $router->post('sign_in', 'SignInController@store');
//    $router->get('sign_in/{id}/edit', 'SignInController@edit');
//    $router->put('sign_in/{id}', 'SignInController@update');

    $router->get('point_history', 'PointHistoriesController@index');
    $router->get('point_history/create', 'PointHistoriesController@create');
    $router->post('point_history', 'PointHistoriesController@store');
    $router->get('point_history/{id}/edit', 'PointHistoriesController@edit');
    $router->put('point_history/{id}', 'PointHistoriesController@update');
    $router->delete('point_history/{id}', 'PointHistoriesController@destroy');
});
