<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'auth'], function() {
    //
    Route::post('login', 'AuthController@login')->name('api.login');
    Route::post('signup', 'AuthController@signup')->name('api.signup');
    Route::get('signup/activate/{token}', 'AuthController@signupActivate')->name('api.activate');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('stories', 'StoryController@create');
    Route::put('stories/{story_id}', 'StoryController@update');
    Route::get('stories', 'StoryController@getAll');
    Route::get('stories/{story_id}', 'StoryController@getOne');
    Route::delete('stories/{story_id}', 'StoryController@delete');
    Route::get('stories/{story_id}/withComments', 'StoryController@getStoryWithComment');
    Route::post('stories/{story_id}/comments', 'CommentController@new');
    Route::get('stories/popular', 'StoryController@popular');
    Route::get('stories/tag/{tag_id}', 'StoryController@getStoryByTag');
    Route::post('stories/{story_id}/views', 'StoryController@newView');
    Route::get('stories/{story_id}/views', 'StoryController@getViews');
    Route::post('stories/{story_id}/claps', 'StoryController@newClap');
    Route::get('stories/{story_id}/claps', 'StoryController@getClaps');
});

Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});
