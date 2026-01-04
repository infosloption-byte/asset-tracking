@extends('layouts.sammy_new.master') @section('title','Edit Supplier')
@section('css')
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
</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li>
    	<a href="{{URL::to("supplier/list")}}">Supplier List</a>
  	</li>
  	<li class="active">Edit Supplier</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border" >
        		<strong>Edit Supplier</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-validation" method="post">
          			{!!Form::token()!!}          			
          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          				<!-- Name -->
	      				<div class="row">
          					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			      				<div class="form-group">
			      					<label for="" class="required">Supplier Name</label>
			      					<input class="form-control" type="text" name="supplier_name" id="supplier_name" value="{{$supplier->name}}" required/>
			      					@if($errors->has('supplier_name'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('supplier_name')}}</label>
			            			@endif
			      				</div>          					
		      				</div>	          				
          				</div>

          				<div class="row">
		      				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			      				<div class="form-group">
			      					<label for="" class="required">Country</label>
			      					<input class="form-control" type="text" name="country" id="country" value="{{$supplier->country}}" required/>
			      					@if($errors->has('country'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('country')}}</label>
			            			@endif
			      				</div>
		      				</div>
          					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			      				<div class="form-group">
			      					<label for="" class="required">City</label>
			      					<input class="form-control" type="text" name="city" id="city" value="{{$supplier->city}}" required/>
			      					@if($errors->has('city'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('city')}}</label>
			            			@endif
			      				</div>
		      				</div>
          				</div>

          				<div class="row">
          					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			      				<div class="form-group">
			      					<label for="" class="required">Supplier Address</label>
			      					<input class="form-control" type="text" name="supplier_address" id="supplier_address" value="{{$supplier->address}}" required/>
			      					@if($errors->has('supplier_address'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('supplier_address')}}</label>
			            			@endif
			      				</div>
		      				</div>
          				</div>

          				<div class="row">
          					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			      				<div class="form-group">
			      					<label for="" class="required">Supplier Phone No.</label>
			      					<input class="form-control" type="text" name="supplier_phone" id="supplier_phone" value="{{$supplier->phone}}" required/>
			      					@if($errors->has('supplier_phone'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('supplier_phone')}}</label>
			            			@endif
			      				</div>
		      				</div>
		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			      				<div class="form-group">
			      					<label for="" class="required">Supplier Fax No.</label>
			      					<input class="form-control" type="text" name="supplier_fax" id="supplier_fax" value="{{$supplier->fax}}" required/>
			      					@if($errors->has('supplier_fax'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('supplier_fax')}}</label>
			            			@endif
			      				</div>
		      				</div>
		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			      				<div class="form-group">
			      					<label for="" class="required">Supplier Email</label>
			      					<input class="form-control" type="text" name="supplier_email" id="supplier_email" value="{{$supplier->email}}" required/>
			      					@if($errors->has('supplier_email'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('supplier_email')}}</label>
			            			@endif
			      				</div>
		      				</div>
          				</div>

          				<div class="row">
          					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			      				<div class="form-group">
			      					<label for="" class="">Remarks</label>
			      					<input class="form-control" type="text" name="remark" id="remark" value="{{$supplier->remark}}" />
			      				</div>
		      				</div>
          				</div>

	      				<div class="row">
	      					<button type="submit" class="btn btn-primary pull-right">Save</button>
	      				</div>
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
		$('#permissions').multiSelect();
	});
</script>
@stop
