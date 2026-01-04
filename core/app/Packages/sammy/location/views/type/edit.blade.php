@extends('layouts.sammy_new.master') @section('title','Edit Location Type')
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
    	<a href="{{{url('location/type/list')}}}">Location Type Management</a>
  	</li>
  	<li class="active">Edit Location Type</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Edit Location Type</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}
          			<div class="form-group">
	            		<label class="col-sm-2 control-label required">Location Type Name</label>
	            		<div class="col-sm-10">
	            			<input type="text" class="form-control @if($errors->has('label')) error @endif" name="name" placeholder="Location Type Name" required value="{{$type->name}}">
	            			@if($errors->has('name'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('name')}}</label>
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
<script type="text/javascript">	
	$(document).ready(function(){
		$('.form-validation').validate();	
	});
</script>
@stop
