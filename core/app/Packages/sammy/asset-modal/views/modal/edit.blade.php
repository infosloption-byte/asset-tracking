@extends('layouts.sammy_new.master') @section('title','Edit - Asset-Modal')
@section('css')
 <link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/file/bootstrap-fileinput-master/css/fileinput.css')}}"media="all" />
 <link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/vendor/bootstrap3-wysihtml5/dist/bootstrap3-wysihtml5.min.css')}}"
 media="all" />
<style type="text/css">
.panel.panel-bordered {
	border: 1px solid #ccc;
}

.btn-primary {
	color: white;
	background-color: #005C99;
	border-color: #005C99;
}

.chosen-container{
	font-family: 'FontAwesome', 'Open Sans',sans-serif;
}

ul.wysihtml5-toolbar>li{
	margin: 0;
}

.wysihtml5-sandbox{
	border-style: solid!important;
	border-width: 1px!important;
	border-top: 0 none!important;
}

ul.wysihtml5-toolbar .btn{
	border-bottom: 0;
}

ul.wysihtml5-toolbar{
	border: 1px solid #e4e4e4;
}

.disabled-result{
	color:#515151!important;
	font-weight: bold!important;
}
</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li>
    	<a href="{{{url('asset-modal/list')}}}">Asset Modal Management</a>
  	</li>
  	<li class="active">Edit Asset-Modal - Asset-Modal</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Edit Asset-Modal - Asset-Modal</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}
          			<div class="form-group">
	            		<label class="col-sm-1 control-label required">Category</label>
	            		<div class="col-sm-11">
	            			@if($errors->has('category'))
	            				{!! Form::select('category',$category, $select_category,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Choose Category']) !!}
	            				<label id="label-error" class="error" for="label">{{$errors->first('category')}}</label>
	            			@else
	            				{!! Form::select('category',$category, $select_category,['class'=>'chosen','id'=>'category','style'=>'width:100%;','required','data-placeholder'=>'Choose Category']) !!}
	            			@endif
	            		</div>
	                </div>
	                <div class="form-group">
	            		<label class="col-sm-1 control-label required">Asset-Modal</label>
	            		<div class="col-sm-5">
	            			<input type="text" class="form-control @if($errors->has('asset_modal')) error @endif" name="asset_modal" placeholder="Asset-Modal Name" required value="{{$assetModal->name}}">
	            			@if($errors->has('asset_modal'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('asset_modal')}}</label>
	            			@endif
	            		</div>
	            		<label class="col-sm-1 control-label required">Code</label>
	            		<div class="col-sm-5">
	            			<input type="text" readonly="true" class="form-control @if($errors->has('code')) error @endif" name="code" placeholder="Enter Code" required value="{{$assetModal->code}}">
	            			@if($errors->has('code'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('code')}}</label>
	            			@endif
	            		</div>
	                </div>
	                <div class="row" id="device_field_row">
	                <input type="hidden" id="row_count" name="row_count" value="1"/>

		        	</div>
	                <div class="pull-right">
	                	<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
	                </div>
            	</form>
          	</div>
        </div>
	</div>
</div>
@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/bootstrap3-wysihtml5/dist/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script src="{{asset('assets/sammy_new/file/bootstrap-fileinput-master/js/fileinput.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">

var t=0;

$("#category").prop('disabled',true);

$(document).ready(function(){
	$('.form-validation').validate();
	var langs = JSON.parse('{!!json_encode($deviceModal)!!}');
	var field="";
	document.getElementById('row_count').value=langs.length;
	$.each(langs,function(index,value){
		$("#device_field_row").append(
			'<div class="form-group" id="field-row-'+t+'">'+
	    		'<label class="col-sm-1 control-label required">Device Field</label>'+
	    		'<div class="col-sm-2">'+
					'<input type="text" class="form-control @if($errors->has("device-modal-'+t+'")) error @endif" name="device-modal-'+t+'" id="device-modal-'+t+'" placeholder="DeviceModal Name" required value="'+value.name+'"  readonly="true">'+
	    			@if($errors->has("device-modal-'+t+'"))
	    				'<label id="label-error" class="error" value="'+value.name+'"  readonly="true" for="label">{{$errors->first("device-modal-'+t+'")}}</label>'+
	    			@endif
	    		'</div>'+
	    		'<div class="col-sm-4">'+
	    			'<input type="text" class="form-control @if($errors->has("device-field-old")) error @endif" name="device-field-old-'+t+'" id="device-field-old-'+t+'" disabled placeholder="" value="'+value.field+'"/>'+
	    		'</div>'+
	    		'<div class="col-sm-4">'+
	    			'<input type="text" class="form-control @if($errors->has("device-field")) error @endif" name="device-field-'+t+'" id="device-field-'+t+'" placeholder="New Device Field" required/>'+
	    			@if($errors->has("device-field"))
	    				'<label id="label-error" class="error" for="label">{{$errors->first("device-field")}}</label>'+
	    			@endif
	    		'</div>'+
	    		'<div class="col-sm-1">'+
	    			'<a href="#" class="blue" onclick="add_feild_row()" data-toggle="tooltip" data-placement="top" title="Add Feild Row"><i class="fa fa-plus-circle" style="font-size: 30px;color: green"></i></a>'+
	    		'</div>'+
			'</div>'
		);

		$('input[name="device-field-'+t+'"]').tagsinput({
			freeInput: true
		});

		$('input[name="device-field-old-'+t+'"]').tagsinput({
			freeInput: true
		});

		t++;

	});	

});

function add_feild_row(){
	$("#device_field_row").append(
		'<div class="form-group" id="field-row-'+t+'">'+
    		'<label class="col-sm-1 control-label required">Device Field</label>'+
    		'<div class="col-sm-2">'+
				'<input type="text" class="form-control @if($errors->has("device-modal-'+t+'")) error @endif" name="device-modal-'+t+'" id="device-modal-'+t+'" placeholder="DeviceModal Name" required value="{{Input::old("device-modal-'+t+'")}}">'+
    			@if($errors->has("device-modal-'+t+'"))
    				'<label id="label-error" class="error" for="label">{{$errors->first("device-modal-'+t+'")}}</label>'+
    			@endif
    		'</div>'+
    		'<div class="col-sm-8">'+
    			'<input type="text" class="form-control @if($errors->has("device-field")) error @endif" name="device-field-'+t+'" id="device-field-'+t+'" placeholder="Device Field" required value="{{Input::old("device-field")}}">'+
    			@if($errors->has("device-field"))
    				'<label id="label-error" class="error" for="label">{{$errors->first("device-field")}}</label>'+
    			@endif
    		'</div>'+
    		'<div class="col-sm-1">'+
    			'<a href="#" class="blue" onclick="add_feild_row()" data-toggle="tooltip" data-placement="top" title="Add Feild Row"><i class="fa fa-plus-circle" style="font-size: 30px;color: green"></i></a>'+
    			'<a href="#" class="blue" onclick="remove_feild_row('+t+')" data-toggle="tooltip" data-placement="top" title="Remove Feild Row"><i class="fa fa-trash-o" style="font-size: 30px;color: red"></i></a>'+
    		'</div>'+
		'</div>'
	);

	$('input[name="device-field-'+t+'"]').tagsinput({
		freeInput: true
	});

	t++;
	document.getElementById('row_count').value=t;
}

function remove_feild_row(id){
	document.getElementById("field-row-"+id).remove();
}
</script>
@stop
