<?php
namespace App\Classes;

use Sammy\Location\Models\Location;
use Sammy\Location\Models\EmployeeLocation;
use Sammy\EmployeeManage\Models\Employee;
use Sammy\AssetModal\Models\AssetModal;
use Sammy\AssetManage\Models\Asset;
use Sentinel;
use DB;
use Response;

class UserLocationFilter{
  
    /**
    * Generate Dynamic Menu Function
    *
    * @param  Integer $parent        Parent
    * @param  Array   $menu          Arranged menu array
    * @param  Integer $level         Menu Level
    * @param  Integer $currentUrlId  Id of Current Route Url
    * @param  Integer $userId        Logged in User Id
    * @return String                 Generated html string
    */
    static function getLocations(){
        $usr = Sentinel::getUser()->employee_id;

        if($usr){
            $employee=Employee::find($usr);
            if($employee && $employee->employee_type_id==1){
                return Location::get();
            }else{
                $emp_loc=EmployeeLocation::where('employee_id',$employee->id)->whereNull('deleted_at')->first();
                $location=Location::find($emp_loc->location_id);
                return $location->getDescendantsAndSelf();
            }
        }

    }

    static function getLocationsOfLocation($loc){
        $usr = Sentinel::getUser()->employee_id;

        if($usr){
            $employee=Employee::find($usr);
            if($employee && $employee->employee_type_id==1){
                return Location::get();
            }else{
                $emp_loc=EmployeeLocation::where('employee_id',$employee->id)->whereNull('deleted_at')->first();
                $location=Location::find($emp_loc->location_id);
                return $location->getDescendantsAndSelf();
            }
        }

    }

    static function getLocationOfUser(){
        $usr = Sentinel::getUser()->employee_id;

        if($usr){
            $employee=Employee::find($usr);
            if($employee && $employee->employee_type_id==1){
                return array_flatten(Location::select('id')->get()->pluck('id'));
            }else{
                $emp_loc=EmployeeLocation::where('employee_id',$employee->id)->whereNull('deleted_at')->first();
                $location=Location::find($emp_loc->location_id);
                return array_flatten([$location->id]);
            }
        }

    }

    static function getLocationsId(){
        $usr = Sentinel::getUser()->employee_id;

        if($usr){
            $employee=Employee::find($usr);
            if($employee && $employee->employee_type_id==1){
                $loc=Location::get();
            }else{
                $emp_loc=EmployeeLocation::where('employee_id',$employee->id)->whereNull('deleted_at')->first();
                $location=Location::find($emp_loc->location_id);
                $loc=$location->getDescendantsAndSelf();
            }

            return EmployeeLocation::whereIn('location_id',$loc->pluck('id'))->whereNull('deleted_at')->get()->pluck('employee_id');
        }

    }

    static function getLocationUsers($loc_id){        
        if($loc_id){

            $empType=Employee::find($loc_id);

            if($empType->employee_type_id!=1){
                $loc_id=EmployeeLocation::where('employee_id',$empType->id)->first()->location_id;
            }else{
                $loc_id=Location::where('type',1)->first()->id;
            }

            $emp=EmployeeLocation::where('location_id',$loc_id)
                    ->with(array('employee'=>function($query){
                        $query->select(DB::raw('CONCAT(first_name," ",last_name) as name'),'id')->where('status',1);
                    }))->whereNull('deleted_at')
                    ->get();
            $emp=$emp->pluck('employee');

            $tmp=[];

            foreach ($emp as $value) {
                if($value['id']){
                    $tmp[$value['id']]=$value['name'];
                }
            }

            return $tmp;

        }else{
            return [];
        }
    }

    static function getLocationUsersExceptLogged($loc_id){        
        if($loc_id){

            $tmp_id=$loc_id;

            $empType=Employee::find($loc_id);

            if($empType->employee_type_id!=1){
                $loc_id=EmployeeLocation::where('employee_id',$empType->id)->first()->location_id;
            }else{
                $loc_id=Location::where('type',1)->first()->id;
            }

            $emp=EmployeeLocation::where('location_id',$loc_id)
                    ->with(array('employee'=>function($query){
                        $query->select(DB::raw('CONCAT(first_name," ",last_name) as name'),'id')->where('status',1);
                    }))->whereNull('deleted_at')
                    ->whereNotIn('employee_id',[$tmp_id])->get();
            $emp=$emp->pluck('employee');

            $tmp=[];

            foreach ($emp as $value) {
                if($value['id']){
                    $tmp[$value['id']]=$value['name'];
                }
            }

            return $tmp;

        }else{
            return [];
        }
    }

    static function getAssetLocationEmployee($loc_id){        
        if($loc_id){

            $tmp_id=Sentinel::getUser()->employee_id;

            $emp=EmployeeLocation::where('location_id',$loc_id)
                ->with(array('employee'=>function($query){
                    $query->select(DB::raw('CONCAT(first_name," ",last_name) as name'),'id')->where('status',1);
                }))->whereNull('deleted_at')
                ->whereNotIn('employee_id',[$tmp_id])->get();
            
            $emp=$emp->pluck('employee');

            $tmp=[];

            foreach ($emp as $value) {
                if($value['id']){
                    $tmp[$value['id']]=$value['name'];
                }
            }

            return $tmp;

        }else{
            return [];
        }
    }

    static function num($val){
        if($val <= 9){
            return "00000" . $val;
        }else if($val > 9 && $val <= 99){
            return "0000" . $val;
        }else if($val > 9 && $val > 99 && $val <= 999){
            return "000" . $val;
        }else if($val > 9 && $val > 99 && $val > 999 && $val <= 9999){
            return "00" . $val;
        }else if($val > 9 && $val > 99 && $val > 999 && $val > 9999 && $val <= 99999){
            return "0" . $val;
        }else if($val > 9 && $val > 99 && $val > 999 && $val > 9999 && $val > 99999 && $val <= 999999){
            return $val;
        }
    }

    static function inventoryNo($modal){
            
        $modal=AssetModal::find($modal);

        if($modal->code!="" || $modal->code!=null){
            
            $last_id=Asset::where('asset_model_id',$modal->id)->orderBy('id','DESC')->limit(1)->first();
            
            if($last_id){
                $num=explode('/', $last_id->inventory_no)[2]+1;
                return 'RDB/'.$modal->code.'/'.self::num($num);
            }else{
                return 'RDB/'.$modal->code.'/000001';
            }

        }else{
            return 1;
        }
    }

    /**
     * Get the category List.
     *
     * @return Response
     */
    static function getLocationHierarchy() {
        
        $mainData = Location::where('parent', '=', null)
            ->with(['parentLocation'])->first();

        $mainData1 = $mainData->getSiblingsAndSelf()->toHierarchy();

        $ss = '';
        $ss .= '<option value="0" selected>ALL</option>';

        foreach ($mainData1 as $mainCategory) {

            $name = '';
            for ($j = 1; $j < $mainCategory->depth; $j++) {
                $name .= '--';
            }

            $name .= '' . $mainCategory->name;

            $ss .= '<option value="' . $mainCategory->id . '">' . $name . '</option>';

            $sub = Location::where('parent',$mainCategory->id)->get();

            foreach ($sub as $nested) {
                
                $name = '--';
                for ($j = 1; $j < $nested->depth; $j++) {
                    $name .= '--';
                }

                $name .= '' . $nested->name;

                $ss .= '<option value="' . $nested->id . '">' . $name . '</option>';

                $child = Location::where('parent',$nested->id)->get();

                foreach ($child as $baby) {

                    $name = '--';
                    for ($j = 1; $j < $baby->depth; $j++) {
                        $name .= '--';
                    }

                    $name .= '' . $baby->name;

                    $ss .= '<option value="' . $baby->id . '">' . $name . '</option>';

                    $leaves = $baby->getDescendants();

                    foreach ($leaves as $children) {

                        $name = '--';
                        for ($j = 1; $j < $children->depth; $j++) {
                            $name .= '--';
                        }

                        $name .= '' . $children->name;

                        $ss .= '<option value="' . $children->id . '">' . $name . '</option>';
                    }
                }
            }
        }

        return Response::json(array('data' => $ss));
    }

    static function locationHierarchyList(){
        $data = Location::with(['parentLocation'])->first()->getDescendantsAndSelf();
        $jsonList = array();
        $i=1;
        $jsonList[0]="Root";
        foreach ($data as $key => $location) {
            $label = '--';
            for($j=0; $j < $location->depth; $j++) {
                $label .= '--';
            }

            $label .= ' '.$location->name;
            $jsonList[$location->id]=$label;
        }

        return $jsonList;
    }

    static function locationHierarchyListWithoutRoot(){
        $data = Location::with(['parentLocation'])->first()->getDescendantsAndSelf();
        $jsonList = array();
        $i=1;
        $jsonList[0]="Select Check-In Location";
        foreach ($data as $key => $location) {
            $label = '--';
            for($j=0; $j < $location->depth; $j++) {
                $label .= '--';
            }

            $label .= ' '.$location->name;
            $jsonList[$location->id]=$label;
        }

        return $jsonList;
    }

    static function locationHierarchyListHierarchy(){
        $data = Location::with(['parentLocation'])->first()->getDescendantsAndSelf();
        $jsonList = array();
        $i=1;
        $jsonList[0]="Select Check-In Location";
        foreach ($data as $key => $location) {
            $label = '--';
            for($j=0; $j < $location->depth; $j++) {
                $label .= '--';
            }

            $label .= ' '.$location->name;
            $jsonList[$location->id]=$label;
        }

        return $jsonList;
    }

    static function locationHierarchy(){

        $only=array_flatten(self::getLocations()->pluck('id'));

        $data = Location::with(['parentLocation'])->first()->getDescendantsAndSelf();
        $jsonList = array();
        $i=1;
        $jsonList[0]="ALL";
        foreach ($data as $key => $location) {
            $label = '--';
            for($j=0; $j < $location->depth; $j++) {
                $label .= '--';
            }

            if(in_array($location->id, $only)){
                $label .= ' '.$location->name;
                $jsonList[$location->id]=$label;
            }

        }

        return $jsonList;
    }

    static function locationHierarchyOption(){

        $only=array_flatten(self::getLocations()->pluck('id'));

        $data = Location::with(['parentLocation'])->first()->getDescendantsAndSelf();
        $jsonList = array();
        $i=1;
        $jsonList[0]="Select Location...";
        foreach ($data as $key => $location) {
            $label = '--';
            for($j=0; $j < $location->depth; $j++) {
                $label .= '--';
            }

            if(in_array($location->id, $only)){
                $label .= ' '.$location->name;
                $jsonList[$location->id]=$label;
            }

        }

        return $jsonList;
    }

    static function freeLocationHierarchy(){

        $only=array_flatten(self::getLocations()->pluck('id'));

        $data = Location::with(['parentLocation'])->first()->getDescendantsAndSelf();
        $jsonList = array();
        $i=1;
        foreach ($data as $key => $location) {
            $label = '--';
            for($j=0; $j < $location->depth; $j++) {
                $label .= '--';
            }

            if(in_array($location->id, $only)){
                $label .= ' '.$location->name;
                $jsonList[$location->id]=$label;
            }

        }

        return $jsonList;
    }

    static function locationHierarchyToCheckout(){

        $only=array_flatten(self::getLocations()->pluck('id'));

        $data = Location::with(['parentLocation'])->first()->getDescendantsAndSelf();
        $jsonList = array();
        $i=1;
        $jsonList[0]="Select Check-out location";
        foreach ($data as $key => $location) {
            $label = '--';
            for($j=0; $j < $location->depth; $j++) {
                $label .= '--';
            }

            if(in_array($location->id, $only)){
                $label .= ' '.$location->name;
                $jsonList[$location->id]=$label;
            }

        }

        return $jsonList;
    }

    static function getSubLocations($loc, $type=null){
        
        if($loc==0){
            if($type) {
                return $data = Location::where('id',1)->first()->descendantsAndSelf()->where('type',$type)->get()->pluck('id');
            }else{
                return $data = Location::find(1)->getDescendantsAndSelf()->pluck('id');
            }
        }else{
            if($type) {
                return $data = Location::where('id',$loc)->first()->descendantsAndSelf()->where('type',$type)->get()->pluck('id');
            }else{
                return $data = Location::find($loc)->getDescendantsAndSelf()->pluck('id');
            }
        }

    }

    static function getEmployees($loc){

        $emp=EmployeeLocation::whereIn('location_id',$loc)
                ->with(array('employee'=>function($query){
                    $query->select(DB::raw('CONCAT(first_name," ",last_name) as name'),'id')->where('status',1);
                }))->whereNull('deleted_at')->get();

                $emp=$emp->pluck('employee');

        $tmp=[];

        foreach ($emp as $value) {
            if($value['id']){
                $tmp[]=$value['id'];
            }
        }

        return $tmp;
                
    }

}
