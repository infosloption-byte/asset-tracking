@extends('layouts.sammy_new.master') @section('title','Edit Asset')
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
    	<a href="{{URL::to('asset/list')}}">Asset List</a>
  	</li>
  	<li class="active">Edit Asset</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border" >
        		<strong>Edit Asset </strong>
        		<div class="text-right pull-right">
        			<span class="required"></span>select asset modal and see below to fill the details
				</div>
			</div>
          	<div class="panel-body">
          		<form role="form" class="form-validation" method="post" id="form">
          			{!!Form::token()!!}          			
          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          				<!-- Name -->
          				<div class="row">
          					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			      				<div class="form-group">
			      					<label for="" class="required">Asset Model</label>
			      					{!! Form::select('asset_model',$asset_models, $asset->asset_model_id,['class'=>'chosen error','style'=>'width:100%;','required','id'=>'asset_model']) !!}
			            			@if($errors->has('asset_model'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('asset_model')}}</label>
			            			@endif
			      				</div>          					
		      				</div>
	          				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			      				<div class="form-group">
			      					<label for="" class="required">Inventory No</label>
			      					<input class="form-control" type="text" name="inventory_no" readonly id="inventory_no" value="{{$asset->inventory_no}}" required/>
			      					@if($errors->has('inventory_no'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('inventory_no')}}</label>
			            			@endif
			      				</div>
		      				</div>

		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			      				<div class="form-group">
			      					<label for="" class="required">Serial No</label>
			      					<input class="form-control" type="text" name="asset_no" id="asset_no" value="{{$asset->asset_no}}" required/>
			      					@if($errors->has('asset_no'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('asset_no')}}</label>
			            			@endif
			      				</div>
		      				</div> 
          				</div>

          				<div class="row">
          					<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
			      				<div class="form-group">
			      					<label for="" class="required">Loc Type</label>
			      					{!! Form::select('loc_type',$loc_type, $asset->assetTransaction->location->locationType->id,['class'=>'chosen error','style'=>'width:100%;','required','id'=>'loc_type']) !!}
			            			@if($errors->has('loc_type'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('loc_type')}}</label>
			            			@endif
			      				</div>          					
		      				</div>
		      				<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
			      				<div class="form-group">
			      					<label for="" class="required">Location</label>
			      					{!! Form::select('location',$locations, $asset->assetTransaction->location->id,['class'=>'chosen error','style'=>'width:100%;','required','id'=>'location']) !!}
			            			@if($errors->has('location'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('location')}}</label>
			            			@endif
			      				</div>          					
		      				</div>
		      				
	          				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			      				<div class="form-group">
			      					<label for="" class="required">Manufacturer</label>
			      					{!! Form::select('manufacturer',$manufacturer, $asset->make,['class'=>'chosen error','style'=>'width:100%;','required','id'=>'manufacturer']) !!}
			            			@if($errors->has('manufacturer'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('manufacturer')}}</label>
			            			@endif
			      				</div>
		      				</div>

		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			      				<div class="form-group">
			      					<label for="" class="required">Model</label>
			      					<input class="form-control" type="text" name="model" id="model" value="{{$asset->model}}" required/>
			      					@if($errors->has('model'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('model')}}</label>
			            			@endif
			      				</div>
		      				</div> 
          				</div>          				

		      			<div class="row">	
		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		      					<div class="form-group">
			      					<label for="">Asset Supplier</label>
			      					{!! Form::select('supplier',$suppliers, $asset->supplier_id,['class'=>'chosen error','style'=>'width:100%;','required','id'=>'supplier']) !!}
			            			@if($errors->has('supplier'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('supplier')}}</label>
			            			@endif
			      				</div>
		      				</div>

		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		      					<div class="form-group">
			      					<label for="">PO Number</label>
			      					<input class="form-control" type="text" name="po_number" id="po_number" value="{{$asset->po_number}}" />
			            			@if($errors->has('po_number'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('po_number')}}</label>
			            			@endif
			      				</div>
		      				</div>

		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		      					<div class="form-group">
			      					<label for="">Purchased Date</label>
			      					<div class='input-group date' id='purchased_date_datedatetimepicker'>
	                                    <input type='text' id="purchased_date_datedatetimepicker" name="purchased_date" class="form-control" value="{{$asset->purchased_date}}"/>
	                                    <span class="input-group-addon">
	                                        <span class="glyphicon glyphicon-calendar"></span>
	                                    </span>
	                                </div>
			            			@if($errors->has('purchased_date'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('purchased_date')}}</label>
			            			@endif
			      				</div>
		      				</div>
		      			</div>

		      			<div class="row">	
		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		      					<div class="form-group">
			      					<label for="">Account Code</label>
			      					<input class="form-control" type="text" name="account_code" id="account_code" value="{{$asset->account_code}}" />
			            			@if($errors->has('account_code'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('account_code')}}</label>
			            			@endif
			      				</div>
		      				</div>

		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		      					<div class="form-group">
			      					<label for="">Scrap Value</label>
			      					<div class="input-group">
			      						<span class="input-group-addon">Rs.</span>
			      						<input class="form-control" type="text" name="scrap_value" id="scrap_value" value="{{$asset->scrap_value}}" />
			            			</div>
			            			@if($errors->has('scrap_value'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('scrap_value')}}</label>
			            			@endif
			      				</div>
		      				</div>

		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		      					<div class="form-group">
			      					<label for="" class="required">Purchased Value</label>
			      					<div class="input-group">
			      						<span class="input-group-addon">Rs.</span>
			      						<input class="form-control" type="text" name="purchased_value" id="purchased_value" value="{{$asset->purchased_value}}" required/>
			            			</div>
			            			@if($errors->has('purchased_value'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('purchased_value')}}</label>
			            			@endif
			      				</div>
		      				</div>
		      			</div>

		      			<div class="row">	
		      				
		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		      					<div class="form-group">
			      					<label for="" class="required">Warranty Period</label>
			      					<div class="input-group">
			            				<span class="input-group-addon">Months</span>
			      						<input class="form-control" type="number" name="warranty_period" id="warranty_period" value="{{$asset->warranty_period}}" />
			            			</div>
			            			@if($errors->has('warranty_period'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('warranty_period')}}</label>
			            			@endif
			      				</div>
		      				</div>

		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		      					<div class="form-group">
			      					<label for="" class="required">Warranty From</label>
			      					<div class='input-group date' id='warranty_from_datedatetimepicker'>
	                                    <input type='text' id="warranty_from" name="warranty_from" class="form-control" value="{{$asset->warranty_from}}"/>
	                                    <span class="input-group-addon">
	                                        <span class="glyphicon glyphicon-calendar"></span>
	                                    </span>
	                                </div>
			            			@if($errors->has('warranty_from'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('warranty_from')}}</label>
			            			@endif
			      				</div>
		      				</div>

		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		      					<div class="form-group">
			      					<label for="" class="required">Recovery Period</label>
			      					<div class="input-group">
			            				<span class="input-group-addon">Months</span>
			      						<input class="form-control" type="number" name="recovery_period" id="recovery_period" value="{{$asset->recovery_period}}" />
			            			</div>
			            			@if($errors->has('recovery_period'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('recovery_period')}}</label>
			            			@endif
			      				</div>
		      				</div>

		      			</div>


	      				<div class="row">
		      				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			      				<div class="form-group">
			      					<label for="" class="">Manual Inventory No</label>
			      					<input class="form-control" type="text" name="manual_no" id="manual_no" value="{{$asset->manual_no}}" />
			      					@if($errors->has('manual_no'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('manual_no')}}</label>
			            			@endif
			      				</div>  
		      				</div>
	      				</div>

	      				<div class="row">
		      				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			      				<div class="form-group">
			      					<label for="" class="">Description</label>
			      					<input class="form-control" type="text" name="description" id="description" value="{{$asset->description}}" />
			      					@if($errors->has('description'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('description')}}</label>
			            			@endif
			      				</div>
		      				</div>
	      				</div>

	      				<hr>

	      				<div class="row">
	      					<div id="detail_fields">
	      						
	      						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">   
			          				<h4>Details</h4>   
			          				@foreach($asset_details as $deviceModel)
			      						<div class="row">
			          						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						          				<h5><strong style="font-weight: bold">{{$deviceModel->name}}</strong></h5>
						          				@foreach($deviceModel->fieldsets as $fieldset)
						          					<div class="row">
			          									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			          										<div class="form-group">
										      					<label for="" class="">{{$fieldset->name}}</label>
										      					<input class="form-control" type="text" name="field_id_{{$fieldset->id}}" id="field_id_{{$fieldset->id}}" value="@if(count($fieldset->values)>0){{$fieldset->values->value}}@endif" />
										      				</div>
			          									</div>
			          								</div>
			      								@endforeach
						          			</div>
						          		</div>
			      					@endforeach
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
<script src="{{asset('assets/sammy_new/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/moment/moment.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/bootstrap-datetimepicker/dist/js/bootstrap-datetimepicker.js')}}"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.form-validation').validate();

		$("#warranty_from_datedatetimepicker").datetimepicker({format:'YYYY-MM-DD'});
		$("#purchased_date_datedatetimepicker").datetimepicker({format:'YYYY-MM-DD'});
		
		$("#asset_model").prop('disabled',true).trigger("chosen:updated");
		$("#loc_type").prop('disabled',true).trigger("chosen:updated");
		$("#location").prop('disabled',true).trigger("chosen:updated");
		
	});

</script>
@stop
