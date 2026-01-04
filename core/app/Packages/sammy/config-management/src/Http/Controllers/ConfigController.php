<?php
namespace Sammy\ConfigManage\Http\Controllers;


use App\Classes\PdfTemplate;
use App\Http\Controllers\Controller;
use App\Models\AssetBarcode;
use App\Models\AssetTransaction;
use App\Models\BarcodeCategory;
use PhpSpec\Exception\Exception;
use Illuminate\Http\Request;
use Response;
use Sammy\AssetManage\Models\Asset;
use Sammy\AssetModal\Models\AssetModal;
use Sammy\ConfigManage\Models\AppConfig;
use Sammy\Location\Models\Location;
use Sammy\Permissions\Models\Permission;
use Sentinel;
use Sammy\ServiceManage\Models\Service;
use Sammy\ServiceTypeManage\Models\ServiceType;

use DB;
class ConfigController extends Controller {

	/*
	|--------------------------------------------------------------------------
	|  Manufacturers Controller
	|--------------------------------------------------------------------------
	|
	*/

    /**
     * Create a new controller instance.
     *
     * @return \Sammy\MenuManage\Http\Controllers\ManufacturersController
     */
	public function __construct()
	{
		//$this->middleware('guest');
	}

    /**
     * Show the list.
     *
     * @return Response
     */
    public function configView(Request $request){
        $barcode_category = BarcodeCategory::lists('name','id');
        return view('configManage::views.add')->with([
            'types'=>$barcode_category]);
    }

    /**
     * Show the list.
     *
     * @return Response
     */
    public function addConfig(Request $request){
        $aa   = AppConfig::create(['barcode_type_id'=>$request->type]);
        $barcode_category = BarcodeCategory::lists('name','id');

        return redirect('config/add')->with(['success' => true,
            'success.message' => 'Config added successfully!',
            'success.title' => 'Good Job!']);
    }





}
