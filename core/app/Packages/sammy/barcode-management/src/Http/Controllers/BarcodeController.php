<?php
namespace Sammy\BarcodeManage\Http\Controllers;


use App\Classes\PdfBarcodeTemplate;
use App\Classes\PdfTemplate;
use App\Classes\UserLocationFilter;
use App\Http\Controllers\Controller;
use App\Models\AssetBarcode;
use App\Models\AssetTransaction;
use App\Models\Status;
use Elibyy\TCPDF\TCPdf;
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
class BarcodeController extends Controller {

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
    public function listView(Request $request){
        $asset_models = AssetModal::all();
        $status = Status::all();
        $locations = UserLocationFilter::getLocations();

        $location  = $request->location==null?0:$request->location;
        $data = Asset::selectRaw("*,
            TIMESTAMPDIFF(MONTH,warranty_from,warranty_to) warranty_period
            ")->with(['depreciationtype','transaction.status','transaction.location','assetmodel']);

        $data  = $data->whereIn('id',function($aa) use($locations)
        {
            $aa->select('asset_id')->from('asset_transaction')
            ->whereIn('location_id',$locations->lists('id'))
            ->whereNull('deleted_at');
        });



        if($location!=null && $location>0){
            $data  = $data->whereIn('id',function($aa) use($location)
            {
                $aa->select('asset_id')->from('asset_transaction')->where('location_id',$location)->whereNull('deleted_at');
            });
        }

        $inv_no = $request->inv_no;
        if($inv_no!=null && $inv_no!=""){
            $data = $data->where('inventory_no', 'like', '%' .$inv_no. '%');
        }

        $ser_no = $request->ser_no;
        if($ser_no!=null && $ser_no!=""){
            $data = $data->where('asset_no', 'like', '%' .$ser_no. '%');
        }

        $stat = $request->status;
        if($stat!=null && $stat!="" && $stat>0){
            $data  = $data->whereIn('id',function($aa) use($stat)
            {
                $aa->select('asset_id')->from('asset_transaction')->where('status_id',$stat)->whereNull('deleted_at');
            });
        }

        $model = $request->model;
        if($model!=null && $model!="" && $model>0){
            $data  = $data->where('asset_model_id',$model);
        }

        $model = $request->model;
        if($model!=null && $model!="" && $model>0){
            $data  = $data->where('asset_model_id',$model);
        }

        $data = $data->paginate(30);

        return view('barcodeManage::views.list')->with([
            'data'=>$data,
            'asset_models'=>$asset_models,
            'locations'=>$locations,
            'status'=>$status,
            'old'=>['ser_no'=>$ser_no,'inv_no'=>$inv_no,'location'=>$location,'status'=>$stat,'model'=>$model]
        ]);
    }


    /**
     * Show the list.
     *
     * @return Response
     */
    public function printView(Request $request,$id){
        $asset  = Asset::with(['depreciationtype','transaction.status','transaction.location','barcode.barcodetype'])->find($id);

        // create new PDF document
        if($asset){
            $page1 =  view('barcodeManage::print.barcode')->with(['asset'=>$asset])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf   = new PdfTemplate($asset);
        $pdf->SetMargins(5, 10, 5);
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 35);
        $pdf->AddPage();
        $pdf->writeHtml($page1);
        $pdf->output($asset->inventory_no.".pdf", 'I');
    }

    /**
     * Show the list.
     *
     * @return Response
     */
    public function bulkPrintView(Request $request){

        $asset_models = AssetModal::all();
        $status = Status::all();
        $locations = UserLocationFilter::getLocations();

        $location  = $request->location==null?0:$request->location;
        $data = Asset::selectRaw("*,
            TIMESTAMPDIFF(MONTH,warranty_from,warranty_to) warranty_period
            ")->with(['depreciationtype','transaction.status','transaction.location','assetmodel']);

        $data  = $data->whereIn('id',function($aa) use($locations)
        {
            $aa->select('asset_id')->from('asset_transaction')
            ->whereIn('location_id',$locations->lists('id'))
            ->whereNull('deleted_at');
        });



        if($location!=null && $location>0){
            $data  = $data->whereIn('id',function($aa) use($location)
            {
                $aa->select('asset_id')->from('asset_transaction')->where('location_id',$location)->whereNull('deleted_at');
            });
        }

        $inv_no = $request->inv_no;
        if($inv_no!=null && $inv_no!=""){
            $data = $data->where('inventory_no', 'like', '%' .$inv_no. '%');
        }

        $ser_no = $request->ser_no;
        if($ser_no!=null && $ser_no!=""){
            $data = $data->where('asset_no', 'like', '%' .$ser_no. '%');
        }

        $stat = $request->status;
        if($stat!=null && $stat!="" && $stat>0){
            $data  = $data->whereIn('id',function($aa) use($stat)
            {
                $aa->select('asset_id')->from('asset_transaction')->where('status_id',$stat)->whereNull('deleted_at');
            });
        }

        $model = $request->model;
        if($model!=null && $model!="" && $model>0){
            $data  = $data->where('asset_model_id',$model);
        }

        $model = $request->model;
        if($model!=null && $model!="" && $model>0){
            $data  = $data->where('asset_model_id',$model);
        }

        $data = $data->paginate(30);

        return view('barcodeManage::views.bulkprint')->with([
            'assets'=>$data,
            'asset_models'=>$asset_models,
            'locations'=>$locations,
            'status'=>$status,
            'old'=>['ser_no'=>$ser_no,'inv_no'=>$inv_no,'location'=>$location,'status'=>$stat,'model'=>$model]
        ]);

    }

    /**
     * Show the list.
     *
     * @return Response
     */
    // public function bulkPrint(Request $request){

    //     $assets  = Asset::whereIn('id',$request->assets)->get();

    //     // create new PDF document
    //     if(!count($assets)>0){
    //         return redirect('barcode/bulk/print')->with(['error' => true,
    //             'error.message' => 'Please Select Assets',
    //             'error.title' => 'Ops!']);
    //     }

    //     $pdf = new TCPDF('p', 'mm', 'A4', true, 'UTF-8', false);
    //     $pdf->SetCreator(PDF_CREATOR);
    //     $pdf->SetAuthor('RDB');
    //     $pdf->SetTitle('BarCodeLabels');
    //     $pdf->SetSubject('');
    //     $pdf->SetKeywords('');
    //     $pdf->setPrintHeader(false);
    //     $pdf->setPrintFooter(false);
    //     $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    //     $pdf->setTopMargin(13.0);
    //     $pdf->SetRightMargin(6.0);
    //     $pdf->setHeaderMargin(13);
    //     $pdf->SetFooterMargin(13.0);
    //     $pdf->SetAutoPageBreak(TRUE, 13.0);
    //     $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    //     $pdf->SetFont('helvetica', '', 11);
    //     $pdf->AddPage();
    //     $pdf->SetFont('helvetica', '', 10);

    //     $style = array(
    //         'position' => '',
    //         'align' => 'R',
    //         'stretch' => false,
    //         'fitwidth' => false,
    //         'cellfitalign' => '',
    //         'border' => true,
    //         'hpadding' => 'auto',
    //         'vpadding' => 'auto',
    //         'fgcolor' => array(0,0,0),
    //         'bgcolor' => false, //array(255,255,255),
    //         'text' => true,
    //         'font' => 'helvetica',
    //         'fontsize' => 7,
    //         'stretchtext' => 0
    //     );

    //     $counter = 1;

    //     for($i=0; $i < count($assets) ; $i++)
    //     {

    //         $x = $pdf->GetX();
    //         $y = $pdf->GetY();
    //         $pdf->setCellMargins(0.2,0,2.5,0);
    //         // The width is set to the the same as the cell containing the name.
    //         // The Y position is also adjusted slightly.
    //         $pdf->SetXY($x,$y);
    //         $pdf->image(url('assets/sammy_new/images/rdb.jpg'), $x-2.8, $y-6, 14, '', '', '', '', false, 50);

    //         $pdf->write1DBarcode($assets[$i]->inventory_no , $assets[$i]->barcode->barcodetype->name, $x-2.5, $y-6.5, 63.5, 18, 0.18, $style, 'C');
    //         //Reset X,Y so wrapping cell wraps around the barcode's cell.
    //         $pdf->SetXY($x,$y);
    //         $pdf->Cell(63.5, 22, '', 0, 0, 'L', FALSE, '', 0, FALSE, 'C', 'B');

    //         if($counter == 3){
    //             $pdf->Ln(20.9);
    //             $counter = 1;
    //         }else{
    //             $counter++;
    //         }

    //     }

    //     $pdf->Output('barcodes.pdf', 'I');
    // }

    /**
     * Show the list.
     *
     * @return Response
     */
    public function printBulk(Request $request)
    {

        $assets  = Asset::with(['supplier'])->whereIn('id',$request->assets)->get();
        
        if($assets){
            $page1 =  view('barcodeManage::print.bulk-barcode')->with(['assets'=>$assets])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf   = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Asset Bulk Barcode Print']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("Print - Asset Bulk Barcode Print");
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage();
        $pdf->writeHtml($page1);
        $pdf->output("bulk.pdf", 'I');
    }


    /**
     * Show the list.
     *
     * @return Response
     */
    public function genarateBarcode(Request $request){
        if ($request->ajax()) {
            $user       = Sentinel::getUser();
            $id         = $request->get('asset_id');

            try {
                $aa = AssetBarcode::create([
                    'asset_id'        => $id,
                    'status'          => 1,
                    'barcode_type_id' => BARCODE_TYPE_ID,
                    'user_id'         => $user->id,
                ]);
                return response()->json(['status' => 'success']);
            } catch (Exception $ex) {
                return response()->json(['status' => 'error']);
            }
        } else {
            return response()->json(['status' => 'not_ajax']);
        }
    }



}
