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

    // Client Renewal Report V2 (AJAX version with year selection)
    Route::get('/client-renewal-report2', 'KsrtcInvoiceController@clientrenewalreport2')
        ->middleware('role:root|client')
        ->name('client.renewal.report2');
    
    // AJAX endpoint for renewal report data
    Route::get('/client-renewal-report2/data', 'KsrtcInvoiceController@clientrenewalreportData')
        ->middleware('role:root|client')
        ->name('client.renewal.report2.data');

    // Period details page for renewal report
    Route::get('/client-renewal-report2/period', 'KsrtcInvoiceController@clientrenewalreportPeriod')
        ->middleware('role:root|client')
        ->name('client.renewal.report2.period');
    // export period renewal/service CSVs
    Route::get('/client-renewal-report2/period/export-renewal', 'KsrtcInvoiceController@clientrenewalreportPeriodExportRenewal')
        ->middleware('role:root|client')
        ->name('client.renewal.report2.period.export_renewal');
    Route::get('/client-renewal-report2/period/export-service', 'KsrtcInvoiceController@clientrenewalreportPeriodExportService')
        ->middleware('role:root|client')
        ->name('client.renewal.report2.period.export_service');

    // All vehicles list page
    Route::get('/client-renewal-report2/all-vehicles', 'KsrtcInvoiceController@allVehiclesList')
        ->middleware('role:root|client')
        ->name('client.renewal.report2.all-vehicles');
    // export all vehicles CSV
    Route::get('/client-renewal-report2/all-vehicles/export', 'KsrtcInvoiceController@allVehiclesExport')
        ->middleware('role:root|client')
        ->name('client.renewal.report2.all-vehicles.export');

    // Vehicles with certificate list page
    Route::get('/client-renewal-report2/vehicles-with-certificate', 'KsrtcInvoiceController@vehiclesWithCertificate')
        ->middleware('role:root|client')
        ->name('client.renewal.report2.vehicles-with-certificate');
    // export vehicles with certificate CSV
    Route::get('/client-renewal-report2/vehicles-with-certificate/export', 'KsrtcInvoiceController@vehiclesWithCertificateExport')
        ->middleware('role:root|client')
        ->name('client.renewal.report2.vehicles-with-certificate.export');

    // Vehicles replaced by uni140 list page
    Route::get('/client-renewal-report2/replaced-by-uni140', 'KsrtcInvoiceController@replacedByUni140List')
        ->middleware('role:root|client')
        ->name('client.renewal.report2.replaced-by-uni140');
    // export replaced-by-uni140 CSV
    Route::get('/client-renewal-report2/replaced-by-uni140/export', 'KsrtcInvoiceController@replacedByUni140Export')
        ->middleware('role:root|client')
        ->name('client.renewal.report2.replaced-by-uni140.export');

    // Service report page
    Route::get('/client-renewal-report2/service-report', 'KsrtcInvoiceController@serviceReportList')
        ->middleware('role:root|client')
        ->name('client.renewal.report2.service-report');
    // export service report CSV
    Route::get('/client-renewal-report2/service-report/export', 'KsrtcInvoiceController@serviceReportExport')
        ->middleware('role:root|client')
        ->name('client.renewal.report2.service-report.export');

    // Not paid vehicles list page
    Route::get('/client-renewal-report2/not-paid', 'KsrtcInvoiceController@notPaidList')
        ->middleware('role:root|client')
        ->name('client.renewal.report2.not-paid');
    // export not paid vehicles CSV
    Route::get('/client-renewal-report2/not-paid/export', 'KsrtcInvoiceController@notPaidExport')
        ->middleware('role:root|client')
        ->name('client.renewal.report2.not-paid.export');

    // CLIENT view
    Route::get('/ksrtc/cmc-report', 'KsrtcInvoiceController@cmcReportClient')
        ->middleware('role:root|client')
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