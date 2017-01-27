<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function(){

    
    Route::get('/', 'HomeController@home')->name('main');
    
    Route::auth();
    
    Route::group(['middleware' => 'auth'], function(){
        
        Route::get('/settings', function()
        {
            return view('pages.set');
        })->name('set');
        
        Route::get('/repost/{id}', 'HomeController@repost')->name('repost');
        
        Route::get('/profile/{id}', 'HomeController@index')->name('profile');
        
        Route::post('/post', 'HomeController@post')->name('post');
        
        Route::post('/Search', 'HomeController@search')->name('search');
        
        Route::post('/edit', 'HomeController@edit')->name('edit');
        
        Route::post('/info', 'HomeController@info')->name('info');
        
        Route::get('/delete', 'HomeController@delete')->name('delete');
        
        Route::post('/prof', 'HomeController@prof')->name('prof-pic');
        
        Route::post('/comment', 'HomeController@comment')->name('comment');
        
        Route::post('/follow', 'HomeController@follow')->name('follow');
        
        Route::post('/unfollow', 'HomeController@unfollow')->name('unfollow');
    });
    
});