<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/home', 'TodoController@store')->name('home.store');

Route::post('/search', 'TodoController@search')->name('search');

Route::get('/home/{lang?}', 'HomeController@localLang');

Route::get('/sendemail','TodoController@sendTodoEmail');

Route::get('/todo/{todo}/delete','TodoController@delete');

Route::get('/sendsms/{todo}','TodoController@sendSms');

Route::get('/markAsRead',function(){

    auth()->user()->unreadNotifications->markAsRead();

    return back();
    
})->name('markAsRead');