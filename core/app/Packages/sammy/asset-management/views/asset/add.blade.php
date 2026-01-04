@extends('layouts.sammy_new.master') @section('title','Add Asset')
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
  	<li class="active">Add Asset</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border" >
        		<strong>Add Asset </strong>
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
			      					{!! Form::select('asset_model',$asset_models, Input::old('asset_model'),['class'=>'chosen error','style'=>'width:100%;','required','id'=>'asset_model']) !!}
			            			@if($errors->has('asset_model'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('asset_model')}}</label>
			            			@endif
			      				</div>          					
		      				</div>	          				

		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			      				<div class="form-group">
			      					<label for="" class="required">Serial No</label>
			      					<input class="form-control" type="text" name="asset_no" id="asset_no" value="{{Input::old('asset_no')}}" required/>
			      					@if($errors->has('asset_no'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('asset_no')}}</label>
			            			@endif
			      				</div>
		      				</div>

		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			      				<div class="form-group">
			      					<label for="" class="">Manual Inventory No</label>
			      					<input class="form-control" type="text" name="manual_no" id="manual_no" value="{{Input::old('manual_no')}}" />
			      					@if($errors->has('manual_no'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('manual_no')}}</label>
			            			@endif
			      				</div>
		      				</div> 
          				</div>

          				<div class="row">
          					<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
			      				<div class="form-group">
			      					<label for="" class="required">Loc Type</label>
			      					{!! Form::select('loc_type',$loc_type, Input::old('loc_type'),['class'=>'chosen error','style'=>'width:100%;','required','id'=>'loc_type']) !!}
			            			@if($errors->has('loc_type'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('loc_type')}}</label>
			            			@endif
			      				</div>          					
		      				</div>
		      				<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
			      				<div class="form-group">
			      					<label for="" class="required">Location</label>
			      					{!! Form::select('location',[], Input::old('location'),['class'=>'chosen error','style'=>'width:100%;','required','id'=>'location']) !!}
			            			@if($errors->has('location'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('location')}}</label>
			            			@endif
			      				</div>          					
		      				</div>
		      				
	          				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			      				<div class="form-group">
			      					<label for="" class="required">Manufacturer</label>
			      					{!! Form::select('manufacturer',$manufacturer, Input::old('manufacturer'),['class'=>'chosen error','style'=>'width:100%;','required','id'=>'manufacturer']) !!}
			            			@if($errors->has('manufacturer'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('manufacturer')}}</label>
			            			@endif
			      				</div>
		      				</div>

		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			      				<div class="form-group">
			      					<label for="" class="required">Model</label>
			      					<input class="form-control" type="text" name="model" id="model" value="{{Input::old('model')}}" required/>
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
			      					{!! Form::select('supplier',$suppliers, Input::old('supplier'),['class'=>'chosen error','style'=>'width:100%;','required']) !!}
			            			@if($errors->has('supplier'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('supplier')}}</label>
			            			@endif
			      				</div>
		      				</div>

		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		      					<div class="form-group">
			      					<label for="">PO Number</label>
			      					<input class="form-control" type="text" name="po_number" id="po_number" value="{{Input::old('po_number')}}" />
			            			@if($errors->has('po_number'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('po_number')}}</label>
			            			@endif
			      				</div>
		      				</div>

		      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		      					<div class="form-group">
			      					<label for="" class="required">Purchased Date</label>
			      					<div class='input-group date' id='purchased_date_datedatetimepicker'>
	                                    <input type='text' id="purchased_date_datedatetimepicker" required name="purchased_date" class="form-control" />
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
			      					<input class="form-control" type="text" name="account_code" id="account_code" value="{{Input::old('account_code')}}" />
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
			      						<input class="form-control" type="text" name="scrap_value" id="scrap_value" value="{{Input::old('scrap_value')}}" />
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
			      						<input class="form-control" type="text" name="purchased_value" id="purchased_value" value="{{Input::old('purchased_value')}}" required/>
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
			      						<input class="form-control" type="number" min="0" name="warranty_period" id="warranty_period" value="{{Input::old('warranty_period')}}" />
			            				<span class="input-group-addon">Months</span>
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
	                                    <input type='text' id="warranty_from" name="warranty_from" class="form-control" />
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
			      						<input class="form-control" type="number" name="recovery_period" min="0" id="recovery_period" value="{{Input::old('recovery_period')}}" />
			            				<span class="input-group-addon">Months</span>
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
			      					<label for="" class="">Description</label>
			      					<input class="form-control" type="text" name="description" id="description" value="{{Input::old('description')}}" />
			      					@if($errors->has('description'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('description')}}</label>
			            			@endif
			      				</div>  
		      				</div>
	      				</div>

	      				<hr>
	      				<h4><strong>Details</strong></h4>

	      				<div class="row">
	      					<div id="detail_fields"></div>
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
		$('#permissions').multiSelect();

		$("#warranty_from_datedatetimepicker").datetimepicker({format:'YYYY-MM-DD'});
		$("#warranty_to_datetimepicker").datetimepicker({format:'YYYY-MM-DD'});
		$("#purchased_date_datedatetimepicker").datetimepicker({format:'YYYY-MM-DD'});

		$('#asset_model').on('change', function(){
			$('.panel').addClass('panel-refreshing');
			var id = $(this).val();
			$.ajax({
                url: "{{url('asset/json/getFieldSet')}}" ,
                type: 'GET',
                data: {'id' :  id},
                success: function(data) {
                    buildForm(data);

                    if(data.inventory==1){	                    
	                	swal('Warning!','No modal code. Cannot create inventory no','error');
	                }
                    $('.panel').removeClass('panel-refreshing');
                },
                error: function(xhr, textStatus, thrownError) {
                    console.log(thrownError);
                }
            });
		});

		function buildForm(data) {
			var elm_ = $('#detail_fields');
			elm_.html('');
			var html = "";
			$.each(data.data.device_models, function(index, value) {
			  	html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			  	html +=  '<h5>'+value.name+'</h5>';
				  	$.each(value.fieldsets, function(indx, val) {
				  		html += addField(val.name,val.id,value.id);
				  	});	
			  	html += '</div>';
			});
			elm_.append(html); 
		}


		function addField(name,id,device_id) {
			var aa ='<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">'+
	      				'<div class="form-group">'+
	      					'<label for="">'+name+'</label>'+
	      					'<input data-id='+id+' class="form-control custom-fields" type="text" name="fields['+device_id+']['+id+'][]"/>'+
	      				'</div>'+  
      				'</div>';

			return aa;
		}

		$("#loc_type").change(function (e) {
            changeLocation();
        });
	});

    /*
    * Load Location for new employee,
    * Load location according to selected location type
    */
    function changeLocation() {
        
        $('.panel').addClass('panel-refreshing');
        $('#location').html("");
        $.ajax({
            url: "{{url('asset/json/getLocation')}}",
            type: 'GET',
            data: {'type': $("#loc_type").val()},
            success: function(data) {                
                $('#location').append('<option value="0">Select Location</option>');
                $.each(data,function(key,value){
                    $('#location').append('<option value="'+key+'">'+value+'</option>');
                });
                $('#location').trigger("chosen:updated");
                $('.panel').removeClass('panel-refreshing');
            },error: function(data){

            }
        });
    }
</script>
@stop
