@extends('layouts.sammy_new.master') @section('title','Add - Asset-Modal')
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
    	<a href="{{{url('asset-modal/list')}}}">Asset-Modal Management</a>
  	</li>
  	<li class="active">Add Asset-Modal - Asset-Modal</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Add Asset-Modal - Asset-Modal</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data" id="modal_form" name="modal_form">
          		{!!Form::token()!!}
          			<div class="form-group">
	            		<label class="col-sm-1 control-label required">Category</label>
	            		<div class="col-sm-11">
	            			@if($errors->has('category'))
	            				{!! Form::select('category',$category, Input::old('category'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Choose Parent Category']) !!}
	            				<label id="label-error" class="error" for="label">{{$errors->first('category')}}</label>
	            			@else
	            				{!! Form::select('category',$category, Input::old('category'),['class'=>'chosen','id'=>'category','style'=>'width:100%;','required','data-placeholder'=>'Choose Parent Category']) !!}
	            			@endif
	            		</div>
	                </div>
	                <div class="form-group">
	            		<label class="col-sm-1 control-label required">Asset-Modal</label>
	            		<div class="col-sm-5">
	            			<input type="text" class="form-control @if($errors->has('asset_modal')) error @endif" name="asset_modal" placeholder="Asset Modal Name" required value="{{Input::old('asset_modal')}}">
	            			@if($errors->has('asset_modal'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('asset_modal')}}</label>
	            			@endif
	            		</div>
	            		<label class="col-sm-1 control-label required">Code</label>
	            		<div class="col-sm-5">
	            			<input type="text" class="form-control @if($errors->has('code')) error @endif" name="code" placeholder="Enter Code" required value="{{Input::old('code')}}">
	            			@if($errors->has('code'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('code')}}</label>
	            			@endif
	            		</div>
	                </div>
	                <div class="row" id="device_field_row">
	                	<input type="hidden" id="row_count" name="row_count" value="1"/>
	                	<div class="form-group" id="field-row-0">
		            		<label class="col-sm-1 control-label required">Device Field</label>
		            		<div class="col-sm-2">
	            				<input type="text" class="form-control @if($errors->has('device-modal-0')) error @endif" name="device-modal-0" id="device-modal-0" placeholder="Device Modal Name" required value="{{Input::old('device-modal-0')}}">
		            			@if($errors->has('device-modal-0'))
		            				<label id="label-error" class="error" for="label">{{$errors->first('device-modal-0')}}</label>
		            			@endif
		            		</div>
		            		<div class="col-sm-8">
		            			<input type="text" class="form-control @if($errors->has('device-field')) error @endif" name="device-field-0" id="device-field-0" placeholder="Device Field" required value="{{Input::old('device-field')}}">
		            			@if($errors->has('device-field'))
		            				<label id="label-error" class="error" for="label">{{$errors->first('device-field')}}</label>
		            			@endif
		            		</div>
		            		<div class="col-sm-1">
		            			<a href="#" class="blue" onclick="add_feild_row()" data-toggle="tooltip" data-placement="top" title="Add Feild Row"><i class="fa fa-plus-circle" style="font-size: 30px;color: gray"></i></a>
		            			<a href="#" class="blue" onclick="" data-toggle="tooltip" data-placement="top" title="Remove Feild Row"><i class="fa fa-trash-o" style="font-size: 30px;color: grey"></i></a>
		            		</div>
						</div>
	                </div>
	                <div class="pull-right">
	                	<button type="button" onclick="checkForm()" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
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
	$(document).ready(function(){

		$('.form-validation').validate();

		$('input[name="device-field-0"]').tagsinput({
			freeInput: true
		});

	});

	function add_feild_row(){
		$("#device_field_row").append(
			'<div class="form-group" id="field-row-'+(t+1)+'">'+
	    		'<label class="col-sm-1 control-label required">Device Field</label>'+
	    		'<div class="col-sm-2">'+
					'<input type="text" class="form-control @if($errors->has("device-modal-'+(t+1)+'")) error @endif" name="device-modal-'+(t+1)+'" id="device-modal-'+(t+1)+'" placeholder="Device Modal Name" required value="{{Input::old("device-modal-'+(t+1)+'")}}">'+
	    			@if($errors->has("device-modal-'+(t+1)+'"))
	    				'<label id="label-error" class="error" for="label">{{$errors->first("device-modal-'+(t+1)+'")}}</label>'+
	    			@endif
	    		'</div>'+
	    		'<div class="col-sm-8">'+
	    			'<input type="text" class="form-control @if($errors->has("device-field")) error @endif" name="device-field-'+(t+1)+'" id="device-field-'+(t+1)+'" placeholder="Device Field" required value="{{Input::old("device-field")}}">'+
	    			@if($errors->has("device-field"))
	    				'<label id="label-error" class="error" for="label">{{$errors->first("device-field")}}</label>'+
	    			@endif
	    		'</div>'+
	    		'<div class="col-sm-1">'+
	    			'<a href="#" class="blue" onclick="add_feild_row()" data-toggle="tooltip" data-placement="top" title="Add Feild Row"><i class="fa fa-plus-circle" style="font-size: 30px;color: grey"></i></a>'+
	    			'<a href="#" class="blue" onclick="remove_feild_row('+(t+1)+')" data-toggle="tooltip" data-placement="top" title="Remove Feild Row"><i class="fa fa-trash-o" style="font-size: 30px;color: grey"></i></a>'+
	    		'</div>'+
			'</div>'
		);

		$('input[name="device-field-'+(t+1)+'"]').tagsinput({
			freeInput: true
		});

		t++;
		document.getElementById('row_count').value=t+1;
	}

	function remove_feild_row(id){
		document.getElementById("field-row-"+id).remove();
	}

	function checkForm(){
		j=0;
		for (var i = 0; i < t+1; i++) {
			if($("#device-field-"+i)){
				if($("#device-field-"+i).val()==""){
					j++;
				}
			}
		}

		if(j!=0){
			swal('Empty field','Device field values cannot be empty. Fill the fields or remove empty device field','warning');
		}else{
			$('#modal_form').submit();
		}
	}
</script>
@stop
