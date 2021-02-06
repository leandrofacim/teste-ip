<?php

Route::resource('users', 'UserController');
Route::post('upload', 'UserController@uploadFile');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
