<?php

Route::post('/moe/file/open', 'Yaro\Mecha\MoeController@getFileContents');
Route::post('/moe/file/save', 'Yaro\Mecha\MoeController@doSaveFileContents');
Route::post('/moe/tree/connector', 'Yaro\Mecha\MoeController@getTreeContents');
Route::post('/moe/auth/check', 'Yaro\Mecha\MoeController@doAuthenticate');

