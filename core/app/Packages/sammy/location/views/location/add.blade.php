@extends('layouts.sammy_new.master') @section('title','Add Location')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/file/bootstrap-fileinput-master/css/fileinput.css')}}" media="all" />
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

	.disabled-result{
		color:#616161!important;
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
    	<a href="{{{url('location/list')}}}">Location Management</a>
  	</li>
  	<li class="active">Add Location</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Add Location</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}
          			<div class="form-group">
	            		<label class="col-sm-1 control-label required">Location Type</label>
	            		<div class="col-sm-11">
	            			@if($errors->has('locationType'))
	            				{!! Form::select('locationType',$locationType, Input::old('locationType'),['class'=>'chosen error','id' => 'locationType','style'=>'width:100%;','required','data-placeholder'=>'Choose Location Type']) !!}
	            				<label id="label-error" class="error" for="label">{{$errors->first('locationType')}}</label>
	            			@else
	            				{!! Form::select('locationType',$locationType, Input::old('locationType'),['class'=>'chosen','id'=>'locationType','style'=>'width:100%;','required','data-placeholder'=>'Choose Location Type']) !!}
	            			@endif
	            		</div>
	                </div>
          			<div class="form-group">
	            		<label class="col-sm-1 control-label required">Location Name</label>
	            		<div class="col-sm-5">
	            			<input type="text" class="form-control @if($errors->has('label')) error @endif" name="location" placeholder="Location Name" required value="{{Input::old('location')}}">
	            			@if($errors->has('location'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('location')}}</label>
	            			@endif
	            		</div>
	            		<label class="col-sm-1 control-label required">Location Code</label>
	            		<div class="col-sm-5">
	            			<input type="text" class="form-control @if($errors->has('label')) error @endif" name="code" placeholder="Location code" required value="{{Input::old('code')}}">
	            			@if($errors->has('code'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('code')}}</label>
	            			@endif
	            		</div>
	                </div>
	                <div class="form-group">
	            		<label class="col-sm-1 control-label required">Parent Location</label>
	            		<div class="col-sm-11">
	            			@if($errors->has('parent'))
	            				{!! Form::select('parent',$location, Input::old('parent'),['class'=>'chosen error','id' => 'parent','style'=>'width:100%;','required','data-placeholder'=>'Choose Parent Location']) !!}
	            				<label id="label-error" class="error" for="label">{{$errors->first('parent')}}</label>
	            			@else
	            				{!! Form::select('parent',$location, Input::old('parent'),['class'=>'chosen','id'=>'parent','style'=>'width:100%;','required','data-placeholder'=>'Choose Parent Location']) !!}
	            			@endif
	            		</div>
	                </div>
	                <div class="form-group">
	            		<label class="col-sm-1 control-label">Address</label>
	            		<div class="col-sm-11">
	            			<textarea class="form-control @if($errors->has('label')) error @endif" name="address" placeholder="Enter Address">{{Input::old('address')}}</textarea>
	            			@if($errors->has('address'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('address')}}</label>
	            			@endif
	            		</div>
	                </div>
          			<div class="form-group">
	            		<label class="col-sm-1 control-label">Email</label>
	            		<div class="col-sm-5">
	            			<input type="text" class="form-control @if($errors->has('label')) error @endif" name="email" placeholder="Enter Email" value="{{Input::old('email')}}">
	            			@if($errors->has('email'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('email')}}</label>
	            			@endif
	            		</div>
	            		<label class="col-sm-1 control-label required">Contact No</label>
	            		<div class="col-sm-5">
	            			<input type="text" class="form-control @if($errors->has('contact')) error @endif" name="contact" placeholder="Enter contact no" value="{{Input::old('contact')}}" required>
                           @if($errors->has('contact'))
                                 <label id="label-error" class="error" for="label">{{$errors->first('contact')}}</label>
                           @endif
	            		</div>
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
<script src="{{asset('assets/sammy_new/file/bootstrap-fileinput-master/js/fileinput.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.form-validation').validate();

		$("#parent").chosen({
		    search_contains: true,
		});		
	});
</script>
@stop
