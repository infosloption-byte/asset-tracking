<?php
namespace Sammy\CategoryManage\Http\Controllers;

use App\Classes\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\Category;

use Illuminate\Http\Request;
use PhpSpec\Exception\Exception;

use Sammy\CategoryManage\Http\Requests\CategoryRequest;
use Sammy\Permissions\Models\Permission;

use Sentinel;
use Response;
use DB;

class CategoryController extends Controller {

	/*
		|--------------------------------------------------------------------------
		|  Manufacturers Controller
		|--------------------------------------------------------------------------
		|
	*/

    private $auditLogger;

	/**
	 * Create a new controller instance.
	 *
	 * @return \Sammy\MenuManage\Http\Controllers\ManufacturersController
	 */
	public function __construct(AuditLogger $auditLogger) {
	    $this->auditLogger = $auditLogger;
		//$this->middleware('guest');
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function addView() {
		return view('categoryManage::category.add');
	}

	/**
	 * Add new entity to database
	 *
	 * @param ManufacturerRequest $request
	 * @return Redirect to menu add
	 */
	public function add(CategoryRequest $request) {
		$user = Sentinel::getUser();

		$service = Category::create([
			'name' => $request->get('name'),
		]);

        $this->auditLogger->addLog('Category', 'Add Entry', $service->id, null, $service->toJson());

		return redirect('category/add')->with([
			'success' => true,
			'success.message' => 'Service added successfully!',
			'success.title' => 'Well Done!',
		]);
	}

	/**
	 * Show the list.
	 *
	 * @return Response
	 */
	public function listView() {

		$data = Category::where('deleted_at', '=', NULL);
		$data=$data->paginate(20);
		$count=$data->total();
		return view('categoryManage::category.list')->with(['data'=>$data,'row_count'=>$count]);
	}

	/**
	 * Activate or Deactivate
	 * @param  Request $request id
	 * @return json
	 */
	public function status(Request $request)
	{
        if ($request->ajax()) {
            $id = $request->input('id');
            $status = $request->input('status');
            $category = Category::find($id);
            $old = $category->replicate();

            if ($category) {

                $category->status=$status;                   
                $category->save();

                $this->auditLogger->addLog('Category', 'Status Change', $category->id, $old->toJson(), $category->toJson());

                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'invalid_id']);
            }
        } else {
            return response()->json(['status' => 'not_ajax']);
        }
	}

	/**
	 * Delete
	 * @param  Request $request id
	 * @return Json
	 */
	public function delete(Request $request) {
		if ($request->ajax()) {
			$id = $request->input('id');
			$category = Category::find($id);
			if ($category) {
				$category->delete();
				return response()->json(['status' => 'success']);
			} else {
				return response()->json(['status' => 'invalid_id']);
			}
		} else {
			return response()->json(['status' => 'not_ajax']);
		}
	}

	/**
	 * Show the list.
	 *
	 * @return Response
	 */
	public function trashListView() {

		return view('manufacturerManage::manufacturer.trash');
	}

	/**
	 * RESTORE
	 * @param  Request $request id
	 * @return Json
	 */
	public function restore(Request $request) {
		if ($request->ajax()) {
			$id = $request->input('id');
			try {
				$manufact = ServiceType::withTrashed()->find($id)->restore();
				return response()->json(['status' => 'success']);
			} catch (Exception $ex) {
				return response()->json(['status' => 'error']);
			}
		} else {
			return response()->json(['status' => 'not_ajax']);
		}
	}

	/**
	 * show edit view.
	 *
	 * @return Response
	 */
	public function jsonTrashList(Request $request) {
		if ($request->ajax()) {
			$data = ServiceType::onlyTrashed()->get();

			$jsonList = array();
			$i = 1;
			foreach ($data as $key => $val) {
				$dd = array();
				array_push($dd, $i);

				if ($val->name != '') {
					array_push($dd, $val->name);
				} else {
					array_push($dd, "-");
				}

				array_push($dd, '<a href="#" class="red item-trash" data-id="' . $val->id . '" data-toggle="tooltip" data-placement="top" title="Restore Manufacturer"><i class="fa fa-reply"></i></a>');

				array_push($jsonList, $dd);
				$i++;
			}
			return Response::json(array('data' => $jsonList));

			return Response::json(array('data' => $jsonList));
		} else {
			return Response::json(array('data' => []));
		}
	}

	/**
	 * show edit view.
	 *
	 * @return Response
	 */
	public function editView($id) {
		$category=Category::find($id);
        return view( 'categoryManage::category.edit')->with(['category'=>$category]);
	}

	/**
	 * save edit
	 *
	 * @return Redirect to menu add
	 */
	public function edit(Request $request, $id) {
		try {
            DB::transaction(function () use ($request,$id) {
                $category=Category::find($id);
                $old = $category->replicate();

                if($category){
                    $category->name=$request->get('name');

                    $category->save();

                    $this->auditLogger->addLog('Category', 'Edit Entry', $category->id, $old->toJson(), $category->toJson());
                }else{
                	throw new TransactionException('Something wrong.Category wasn\'t found', 100);
                }
            });
            return redirect('category/list')->with(['success' => true,
                'success.message' => 'Category Updated successfully!',
                'success.title' => 'Well Done!']);
        } catch (TransactionException $e) {
        	Log::info($e);
            return redirect('category/edit/'.$id)->with(['error' => true,
                'error.message' => 'Category not updated!',
                'error.title' => 'Error!']);
        } catch (Exception $e) {
        	Log::info($e);
            return redirect('category/edit/'.$id)->with(['error' => true,
                'error.message' => 'Category not updated!',
                'error.title' => 'Error!']);
        }
	}
}
