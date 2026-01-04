<?php
namespace App\Classes;

use Sammy\AssetModal\Models\AssetModal;
use Sammy\AssetManage\Models\Asset;
use App\Models\Devices;
use App\Models\DeviceModal;
use App\Models\FieldSet;
use App\Models\FieldSetValues;

use Sentinel;
use DB;
use Response;

class AssetCustom{
  
    static function getAssetDeviceField($asset){
        $device_id=Devices::where('asset_id',$asset->id)->first();
        $device_id = ($device_id)?$device_id->id:0;
        $tmp2=DeviceModal::where('asset_modal_id',$asset->asset_model_id)->with(['fieldsets'])->get();

        foreach ($tmp2 as $modal) {
            foreach ($modal->fieldsets as $field) {
                
                $data=FieldSetValues::where('device_id',$device_id)->where('fieldset_id',$field->id)->first();
                if($data){
                    $field['values']=$data;
                }else{
                    $field['values']=[];
                }

            }
        }

        return $tmp2;

    }

    static function getAssetDeviceFieldForView($asset){
        $device_id=Devices::where('asset_id',$asset->id)->first()->id;
        
        $tmp2=DeviceModal::where('asset_modal_id',$asset->asset_model_id)->with(['fieldsets'])->get();        

        $jsonList=[];

        foreach ($tmp2 as $modal) {
            $dd=[];
            $dd['modal']=$modal->name;
            $dd['value']=[];
            foreach ($modal->fieldsets as $field) {
                $data=FieldSetValues::where('device_id',$device_id)->where('fieldset_id',$field->id)->first();
                if($data){
                    $dd['value'][$field->name]=$data->value;
                }else{
                    $dd['value'][$field->name]="";                    
                }
            }

            array_push($jsonList, $dd);
        }

        return $jsonList;

    }

    static function getAssetDeviceFieldUsingModel($model){
        
        $tmp2=DeviceModal::where('asset_modal_id',$model)->with(['fieldsets'])->get();        

        $jsonList=[];

        foreach ($tmp2 as $modal) {
            $dd=[];
            foreach ($modal->fieldsets as $field) {                
                $dd['id']=$field->id;
                $dd['name']=$field->name;
                array_push($jsonList, $dd);
            }

        }

        return $jsonList;

    }

    
}
