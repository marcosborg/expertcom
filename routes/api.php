<?php

use App\Http\Controllers\Api\V1\PanelController;

Route::post('login', 'Api\\AuthController@login');

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    Route::post('panel', [PanelController::class, 'index']);
    Route::post('receipts', [PanelController::class, 'receipts']);
});
