<?php
/**
 * manufacturer management ROUTES
 *
 * @version 1.0.0
 * @author Yasith Samarawickrama <yazith11@gmail.com>
 * @copyright 2015 Yasith Samarawickrama
 */

/**
 * USER AUTHENTICATION MIDDLEWARE
 */
Route::group(['middleware' => ['auth']], function()
{
    Route::group(['prefix' => 'reports', 'namespace' => 'Sammy\Reports\Http\Controllers'], function(){
      /**
       * GET Routes
       */

        Route::get('depreciation/list', [
            'as' => 'report.depreciation', 'uses' => 'ReportsController@depreciationList'
        ]);

        Route::get('depreciation/download/excel', [
            'as' => 'report.depreciation', 'uses' => 'ReportsController@downloadDepreciationListReportExcel'
        ]);

        Route::get('depreciation/download/pdf', [
            'as' => 'report.depreciation', 'uses' => 'ReportsController@downloadDepreciationListReportPdf'
        ]);

        Route::get('depreciation/asset/list', [
            'as' => 'report.depreciation', 'uses' => 'ReportsController@depreciationList'
        ]);

        Route::get('depreciation/asset/json', [
            'as' => 'report.depreciation', 'uses' => 'ReportsController@depreciationAssetJson'
        ]);

        Route::get('depreciation/asset/download/excel', [
            'as' => 'report.depreciation', 'uses' => 'ReportsController@depreciationAssetExcel'
        ]);
       
        Route::get('depreciation/asset/download/pdf', [
            'as' => 'report.depreciation', 'uses' => 'ReportsController@depreciationAssetPdf'
        ]);

        Route::get('depreciation/{id}', [
            'as' => 'report.depreciation', 'uses' => 'ReportsController@depreciation'
        ]);

        Route::get('depreciation/details/pdf', [
            'as' => 'report.depreciation', 'uses' => 'ReportsController@depreciationDetailsPdf'
        ]);
	  
	    Route::get('depreciation/json/getAssetData', [
            'as' => 'report.depreciation', 'uses' => 'ReportsController@getAssetData'
        ]);

        Route::get('asset_location', [
            'as' => 'report.location_asset', 'uses' => 'ReportsController@asset_location'
        ]);
       
        Route::get('asset_location/json/getAssetDataInLocation', [
            'as' => 'report.location_asset', 'uses' => 'ReportsController@getAssetDataInLocation'
        ]);
       
        Route::get('asset-location/download/excel', [
            'as' => 'report.asset-location', 'uses' => 'ReportsController@downloadAssetLocationExcel'
        ]);
       
        Route::get('asset-location/download/pdf', [
            'as' => 'report.asset-location', 'uses' => 'ReportsController@downloadAssetLocationPdf'
        ]);
       
        Route::get('custom', [
            'as' => 'report.custom', 'uses' => 'ReportsController@customReportView'
        ]);
       
        Route::get('json/get_specs', [
            'as' => 'report.custom', 'uses' => 'ReportsController@getSpecField'
        ]);
       
        Route::get('download/excel', [
            'as' => 'report.custom', 'uses' => 'ReportsController@downloadExcel'
        ]);
       
        Route::get('download/pdf', [
            'as' => 'report.custom', 'uses' => 'ReportsController@downloadPdf'
        ]);
       
        Route::get('dynamic', [
            'as' => 'report.dynamic', 'uses' => 'ReportsController@dynamicReportView'
        ]);

        Route::get('dynamic/download/excel', [
            'as' => 'report.dynamic', 'uses' => 'ReportsController@downloadDynamicExcel'
        ]);
       
        Route::get('dynamic/download/pdf', [
            'as' => 'report.dynamic', 'uses' => 'ReportsController@downloadDynamicPdf'
        ]);

        Route::get('json/get_location', [
            'as' => 'report.request-summery', 'uses' => 'ReportsController@getLocation'
        ]);

        Route::get('request-summery', [
            'as' => 'report.request-summery', 'uses' => 'ReportsController@requestSummeryReportView'
        ]);

        Route::get('request-summery/download/excel', [
            'as' => 'report.request-summery', 'uses' => 'ReportsController@downloadRequestSummeryExcel'
        ]);
       
        Route::get('request-summery/download/pdf', [
            'as' => 'report.request-summery', 'uses' => 'ReportsController@downloadRequestSummeryPdf'
        ]);

        Route::get('asset-summery', [
            'as' => 'report.asset-summery', 'uses' => 'ReportsController@assetSummeryReportView'
        ]);

        Route::get('asset-summery/download/excel', [
            'as' => 'report.asset-summery', 'uses' => 'ReportsController@downloadAssetSummeryExcel'
        ]);
       
        Route::get('asset-summery/download/pdf', [
            'as' => 'report.asset-summery', 'uses' => 'ReportsController@downloadAssetSummeryPdf'
        ]);

        Route::get('asset-request-summery', [
            'as' => 'report.asset-request-summery', 'uses' => 'ReportsController@assetRequestSummeryReportView'
        ]);
       
        Route::get('asset-request-summery/download/pdf', [
            'as' => 'report.asset-request-summery', 'uses' => 'ReportsController@downloadAssetRequestSummeryPdf'
        ]);
       
        Route::get('asset-request-summery/download/excel', [
            'as' => 'report.asset-request-summery', 'uses' => 'ReportsController@downloadAssetRequestSummeryExcel'
        ]);

        Route::get('employee-summery-report', [
            'as' => 'report.employee-summery-report', 'uses' => 'ReportsController@employeeSummeryReportView'
        ]);

        Route::get('get-employee-summery-data', [
            'as' => 'report.get-employee-summery-data', 'uses' => 'ReportsController@getEmployeeSummeryReportData'
        ]);
       
        Route::get('employee-summery-report/download/pdf', [
            'as' => 'report.employee-summery-report', 'uses' => 'ReportsController@downloadEmployeeSummeryPdf'
        ]);
       
        Route::get('employee-summery-report/download/excel', [
            'as' => 'report.employee-summery-report', 'uses' => 'ReportsController@downloadEmployeeSummeryExcel'
        ]);

        Route::get('asset-detail-summery-report', [
            'as' => 'report.asset-detail-summery-report', 'uses' => 'ReportsController@assetDetailSummeryReportView'
        ]);
       
        Route::get('asset-detail-summery-report/download/pdf', [
            'as' => 'report.asset-detail-summery-report', 'uses' => 'ReportsController@downloadAssetDetailSummeryPdf'
        ]);
       
        Route::get('asset-detail-summery-report/timeline/download/pdf', [
            'as' => 'report.asset-detail-summery-report', 'uses' => 'ReportsController@downloadAssetDetailTimelineSummeryPdf'
        ]);
       
        Route::get('asset-detail-summery-report/download/excel', [
            'as' => 'report.asset-detail-summery-report', 'uses' => 'ReportsController@downloadAssetDetailSummeryExcel'
        ]);

        Route::get('user-summery-report', [
            'as' => 'report.user-summery-report', 'uses' => 'ReportsController@userSummeryReportView'
        ]);

        Route::get('user-summery-report-data', [
            'as' => 'report.user-summery-report-data', 'uses' => 'ReportsController@userSummeryData'
        ]);

        Route::get('service-report', [
            'as' => 'report.service-report', 'uses' => 'ReportsController@serviceReportView'
        ]);

        Route::get('service-report/download/pdf', [
            'as' => 'report.service-report', 'uses' => 'ReportsController@downloadServiceReportPdf'
        ]);

        Route::get('service-report/download/excel', [
            'as' => 'report.service-report', 'uses' => 'ReportsController@downloadServiceReportExcel'
        ]);

        Route::get('audit-trail-report', [
            'as' => 'report.audit-trail-report', 'uses' => 'ReportsController@auditReportView'
        ]);

        Route::get('audit-trail-data', [
            'as' => 'report.audit-trail-report', 'uses' => 'ReportsController@auditReportData'
        ]);

        Route::get('audit-trail-report/download/pdf', [
            'as' => 'report.audit-trail-report', 'uses' => 'ReportsController@downloadAuditTrailPdf'
        ]);

        Route::get('audit-trail-report/download/excel', [
            'as' => 'report.audit-trail-report', 'uses' => 'ReportsController@downloadAuditTrailExcel'
        ]);

        Route::get('user-wise-asset-report', [
            'as' => 'report.user-wise-asset-report', 'uses' => 'ReportsController@userAssetReportView'
        ]);

        Route::get('user-wise-asset-report/download/pdf', [
            'as' => 'report.user-wise-asset-report', 'uses' => 'ReportsController@downloadUserAssetPdf'
        ]);

        Route::get('user-wise-asset-report/download/excel', [
            'as' => 'report.user-wise-asset-report', 'uses' => 'ReportsController@downloadUserAssetExcel'
        ]);
       
        Route::get('user-summery-report/download/pdf', [
            'as' => 'report.user-summery-report', 'uses' => 'ReportsController@downloadUserSummeryPdf'
        ]);
       
        Route::get('user-summery-report/download/excel', [
            'as' => 'report.user-summery-report', 'uses' => 'ReportsController@downloadUserSummeryExcel'
        ]);

        Route::get('software-summery-report', [
            'as' => 'report.software-summery-report', 'uses' => 'ReportsController@SoftwareSummeryReportView'
        ]);

        Route::get('software-summery-report-data', [
            'as' => 'report.software-summery-report-data', 'uses' => 'ReportsController@SoftwareSummeryData'
        ]);

        Route::get('software-detail-data', [
            'as' => 'report.software-detail-data', 'uses' => 'ReportsController@SoftwareDetailData'
        ]);
       
        Route::get('software-summery-report/download/excel', [
            'as' => 'report.software-summery-report', 'uses' => 'ReportsController@downloadSoftwareSummeryExcel'
        ]);
       
        Route::get('software-summery-report/download/pdf', [
            'as' => 'report.software-summery-report', 'uses' => 'ReportsController@downloadSoftwareSummeryPdf'
        ]);

        Route::get('software-report', [
            'as' => 'report.software-report', 'uses' => 'ReportsController@SoftwareReportView'
        ]);

        Route::get('software-report-data', [
            'as' => 'report.software-report', 'uses' => 'ReportsController@SoftwareReportData'
        ]);
       
        Route::get('software-report/download/excel', [
            'as' => 'report.software-report', 'uses' => 'ReportsController@downloadSoftwareReportExcel'
        ]);
       
        Route::get('software-report/download/pdf', [
            'as' => 'report.software-report', 'uses' => 'ReportsController@downloadSoftwareReportPdf'
        ]);

        Route::get('supplier-report', [
            'as' => 'report.supplier-report', 'uses' => 'ReportsController@supplierReportView'
        ]);

        Route::get('supplier-report/download/excel', [
            'as' => 'report.supplier-report', 'uses' => 'ReportsController@downloadSupplierReportExcel'
        ]);

        Route::get('supplier-report/download/pdf', [
            'as' => 'report.supplier-report', 'uses' => 'ReportsController@downloadSupplierReportPdf'
        ]);

        Route::get('manufacturer-report', [
            'as' => 'report.manufacturer-report', 'uses' => 'ReportsController@manufacturerReportView'
        ]);

        Route::get('manufacturer-report/download/excel', [
            'as' => 'report.manufacturer-report', 'uses' => 'ReportsController@downloadManufacturerReportExcel'
        ]);

        Route::get('manufacturer-report/download/pdf', [
            'as' => 'report.manufacturer-report', 'uses' => 'ReportsController@downloadManufacturerReportPdf'
        ]);

    });
});