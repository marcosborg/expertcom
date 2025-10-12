<?php

use App\Http\Controllers\Api\V1\PanelController;
use App\Http\Controllers\Api\V1\FormCommunicationController;

Route::post('login', 'Api\\AuthController@login');

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    Route::post('panel', [PanelController::class, 'index']);
    Route::post('receipts', [PanelController::class, 'receipts']);
    Route::get('forms', [FormCommunicationController::class, 'index']);
    Route::get('forms/{id}', [FormCommunicationController::class, 'show']);
    Route::post('forms/media', [FormCommunicationController::class, 'storeMedia']);
    Route::post('forms/submit', [FormCommunicationController::class, 'submit']);

    // Drv Sessions
    Route::apiResource('drv-sessions', 'DrvSessionsApiController');

    // Drv Segments
    Route::apiResource('drv-segments', 'DrvSegmentsApiController');

    // Drv Timesheets
    Route::apiResource('drv-timesheets', 'DrvTimesheetsApiController');
});
