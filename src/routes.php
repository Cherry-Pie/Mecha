<?php

Route::group([
    'prefix'     => 'moe',
    'middleware' => [
        \Illuminate\Session\Middleware\StartSession::class,
    ]
], function () {
    Route::post('/file/open', 'Yaro\Mecha\MoeController@getFileContents');
    Route::post('/file/save', 'Yaro\Mecha\MoeController@doSaveFileContents');
    Route::post('/file/move', 'Yaro\Mecha\MoeController@doMoveFiles');
    Route::post('/file/copy', 'Yaro\Mecha\MoeController@doCopyFiles');
    Route::post('/file/remove', 'Yaro\Mecha\MoeController@doRemoveFile');
    Route::post('/file/create', 'Yaro\Mecha\MoeController@doCreateFile');
    Route::post('/dir/create', 'Yaro\Mecha\MoeController@doCreateDir');
    Route::post('/tree/connector', 'Yaro\Mecha\MoeController@getTreeContents');
    Route::post('/auth/check', 'Yaro\Mecha\MoeController@doAuthenticate');
});
