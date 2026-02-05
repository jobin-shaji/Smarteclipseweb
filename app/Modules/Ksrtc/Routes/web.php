<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Ksrtc Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for the Ksrtc module.
| These routes are loaded by the ModulesServiceProvider.
|
*/



Route::group(['middleware' => ['web','auth'],'namespace'  => 'App\Modules\Ksrtc\Controllers'], function () {

    // Client Renewal Report (moved from Gps module)
    Route::get('/client-renewal-report', 'KsrtcInvoiceController@clientrenewalreport')
        ->middleware('role:root|client')
        ->name('client.renewal.report');

    // Client Renewal Report V2 (AJAX version with year selection)
    Route::get('/client-renewal-report2', 'KsrtcInvoiceController@clientrenewalreport2')
        ->middleware('role:root|client')
        ->name('client.renewal.report2');
    
    // AJAX endpoint for renewal report data
    Route::get('/client-renewal-report2/data', 'KsrtcInvoiceController@clientrenewalreportData')
        ->middleware('role:root|client')
        ->name('client.renewal.report2.data');

    // CLIENT view
    Route::get('/ksrtc/cmc-report', 'KsrtcInvoiceController@cmcReportClient')
        ->name('ksrtc.cmc.client');

    // Download invoice (root + client)
    Route::get('/ksrtc/cmc-report/invoice/download/{id}', 'KsrtcInvoiceController@cmcInvoiceDownload')
        ->name('ksrtc.cmc.invoice.download');

    // ROOT routes
    Route::group(['middleware' => ['role:root']], function () {

        Route::get('/ksrtc/cmc-report/root', 'KsrtcInvoiceController@cmcReportRoot')
            ->name('ksrtc.cmc.root');

        Route::post('/ksrtc/cmc-report/invoice/upload', 'KsrtcInvoiceController@cmcInvoiceUpload')
            ->name('ksrtc.cmc.invoice.upload');

        Route::delete('/ksrtc/cmc-report/invoice/delete/{id}', 'KsrtcInvoiceController@cmcInvoiceDelete')
            ->name('ksrtc.cmc.invoice.delete');
    });
    
    // Devices per period (root OR KSRTC client users)
    Route::get('/ksrtc/devices', 'KsrtcInvoiceController@devicesPage')
        ->name('ksrtc.cmc.devices');
    Route::get('/ksrtc/devices/list', 'KsrtcInvoiceController@devicesList')
        ->name('ksrtc.cmc.devices.list');
    Route::get('/ksrtc/devices/export', 'KsrtcInvoiceController@devicesExport')
        ->name('ksrtc.cmc.devices.export');
    Route::get('/ksrtc/devices/export-multiple', 'KsrtcInvoiceController@devicesExportMultiple')
        ->name('ksrtc.cmc.devices.export_multiple');
    Route::get('/ksrtc/devices/export-all', 'KsrtcInvoiceController@devicesExportAll')
        ->name('ksrtc.cmc.devices.export_all');
    Route::get('/ksrtc/devices/summary', 'KsrtcInvoiceController@devicesSummary')
        ->name('ksrtc.cmc.devices.summary');
    Route::get('/ksrtc/period/download-bills', 'KsrtcInvoiceController@downloadPeriodBills')
        ->name('ksrtc.cmc.period.download_bills');
});