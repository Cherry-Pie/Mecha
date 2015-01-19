<?php

Route::post('/moe/file/open', 'Yaro\Mecha\MoeController@getFileContents');
Route::post('/moe/file/save', 'Yaro\Mecha\MoeController@doSaveFileContents');
Route::post('/moe/file/move', 'Yaro\Mecha\MoeController@doMoveFiles');
Route::post('/moe/file/copy', 'Yaro\Mecha\MoeController@doCopyFiles');
Route::post('/moe/file/remove', 'Yaro\Mecha\MoeController@doRemoveFile');
Route::post('/moe/tree/connector', 'Yaro\Mecha\MoeController@getTreeContents');
Route::post('/moe/auth/check', 'Yaro\Mecha\MoeController@doAuthenticate');

