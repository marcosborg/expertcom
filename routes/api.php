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

    // Cronómetro de condução (custom endpoints)
    Route::post('drive/start',  'DrvDriveController@start');   // inicia sessão + 1º segmento drive
    Route::post('drive/pause',  'DrvDriveController@pause');   // fecha drive aberto e abre pause
    Route::post('drive/resume', 'DrvDriveController@resume');  // fecha pause aberto e abre drive
    Route::post('drive/finish', 'DrvDriveController@finish');  // fecha segmento aberto e encerra sessão

    // Vista diária (para autoridade): ?date=YYYY-MM-DD (fuso Europe/Lisbon)
    Route::get('drive/logs', 'DrvDriveController@dailyLogs');

    Route::get('drive/status', 'DrvDriveController@status');
});
