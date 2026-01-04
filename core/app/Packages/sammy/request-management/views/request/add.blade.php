++@extends('layouts.sammy_new.master') @section('title','Add Request')
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
    	<a href="{{{url('location/list')}}}">Request Management</a>
  	</li>
  	<li class="active">Add Request</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Add Request</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" name="request_form" id="request_form" enctype="multipart/form-data">
          		{!!Form::token()!!}
          			<div class="form-group">
	            		<label class="col-sm-1 control-label required">Type</label>
	            		<div class="col-sm-5">
	            			<select class="chosen" id="type" name="type" style="width: 100%" required>
	            				<option value="0">Please Select...</option>
	            				@foreach($type as $id=>$value)
	            				<option value="{{$id}}">{{$value}}</option>
	            				@endforeach
	            			</select>
	            		</div>

	            		
	                </div>
	                <div>
		                <div class="form-group">
		                	<label class="col-sm-1 control-label required">Asset Modal</label>
		            		<div class="col-sm-5">
		            			@if($errors->has('modal'))
		            				{!! Form::select('modal',$modal, Input::old('modal'),['class'=>'chosen error','id' => 'modal','style'=>'width:100%;','required','data-placeholder'=>'Choose request modal']) !!}
		            				<label id="label-error" class="error" for="label">{{$errors->first('modal')}}</label>
		            			@else
		            				{!! Form::select('modal',$modal, Input::old('modal'),['class'=>'chosen','id'=>'modal','style'=>'width:100%;','required','data-placeholder'=>'Choose request modal']) !!}
		            			@endif
		            		</div>
		            	</div>
		            	<div class="form-group">
		            		<label class="col-sm-1 control-label required serial-display" style="display: none">Serial No</label>
		            		<div class="col-sm-5">
		            			<input class="form-control serial-display @if($errors->has('serial_no')) error @endif" id="serial_no" name="serial_no" placeholder="Search by serial no" style="display: none"/>
		            		</div>
		            	</div>
		            	<div class="form-group">
		            		<label class="col-sm-1 control-label required asset-request" style="display: none">Quantity</label>
		            		<div class="col-sm-5 asset-request" style="display: none">
		            			<input type="number" min="1" class="form-control @if($errors->has('quantity')) error @endif" name="quantity" id="quantity" placeholder="Enter quantity" value="{{Input::old('quantity')}}">
		            			@if($errors->has('quantity'))
		            				<label id="label-error" class="error" for="label">{{$errors->first('quantity')}}</label>
		            			@endif
		            		</div>
		            		<label class="col-sm-1 control-label required asset-no">Asset</label>
		            		<div class="col-sm-5 asset-no">
		            			@if($errors->has('asset'))
		            				{!! Form::select('asset',[], Input::old('asset'),['class'=>'chosen error','id' => 'asset','style'=>'width:100%;','required','data-placeholder'=>'Please Select...']) !!}
		            				<label id="label-error" class="error" for="label">{{$errors->first('asset')}}</label>
		            			@else
		            				{!! Form::select('asset',[], Input::old('asset'),['class'=>'chosen','id'=>'asset','style'=>'width:100%;','required','data-placeholder'=>'Please Select...']) !!}
		            			@endif
		            			<input type="hidden" name="asset_no" id="asset_no">
		            		</div>
		                </div>
		            </div>
	                <div class="form-group">
	            		<label class="col-sm-1 control-label">Remark</label>
	            		<div class="col-sm-5">
	            			<textarea class="form-control @if($errors->has('remark')) error @endif" style="height: 180px" name="remark" placeholder="Enter remark">{{Input::old('remark')}}</textarea>
	            			@if($errors->has('remark'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('remark')}}</label>
	            			@endif
	            		</div>
	                </div>
	                
	                <div class="pull-right">
	                	<button type="button" class="btn btn-primary" onclick="validate()"><i class="fa fa-plane"></i> Send</button>
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

		$('#type').on('change', function(){
			if($(this).val()!=1){
				$('.asset-no').show();
				$('.asset-request').hide();
				
				$('.serial-display').css('display','inline-block');

			}else{

				$('.serial-display').css('display','none');
				$('.asset-no').hide();
				$('.asset-request').show();
			}
		});

		$('#asset').on('change', function()
		{
			$('#asset_no').val($(this).val());
		});

		$('#modal').on('change', function(e)
		{
			if(($('#type').val())!=1)
			{
				modal = $('#modal').val();
				
				$('.panel').addClass('panel-refreshing');
				$('#asset').html('');

				$.ajax({
					url: "{{url('request/getAsset')}}" ,
					type: 'GET',
	                data: {'modal': modal},
	                success: function(data)
	                {
	                    $('#asset').append('<option value="0">Select Asset</option>');

	                    $.each(data,function(key,value)
	                    {
		                	if(value.manufacturer_name&&value.model)
		                	{
		                		lbl = value.inventory_no+" - Brand : "+value.manufacturer_name.name+" - Model : "+value.model+" - Serial No : "+value.asset_no;
		                	}else{
		                		lbl = value.inventory_no;
		                	}

		                    $('#asset').append('<option value="'+value.id+'">'+lbl+'</option>');
		                });

		                $('#asset').trigger("chosen:updated");
		                $('.panel').removeClass('panel-refreshing');
	                },
	                error: function(xhr, textStatus, thrownError) {
	                    console.log(thrownError);
	                }
	            });
			}
		});


		$('#serial_no').keydown(function(e)
		{
			console.log($(this).val());

			if(e.which == 13)
			{
				if(($('#type').val())!=1)
				{
					modal = $('#modal').val();
					serial_no = $(this).val();
					
					$('.panel').addClass('panel-refreshing');
					$('#asset').html('');

					$.ajax({
						url: "{{url('request/getAsset')}}" ,
						type: 'GET',
		                data: {
		                	'modal': modal,
		                	'serial_no': serial_no
		                },
		                success: function(data)
		                {
		                    $('#asset').append('<option value="0">Select Asset</option>');

		                    $.each(data,function(key,value)
		                    {
			                	if(value.manufacturer_name&&value.model)
			                	{
			                		lbl = value.inventory_no+" - Brand : "+value.manufacturer_name.name+" - Model : "+value.model+" - Serial No : "+value.asset_no;
			                	}else{
			                		lbl = value.inventory_no;
			                	}

			                    $('#asset').append('<option value="'+value.id+'">'+lbl+'</option>');
			                });

			                $('#asset').trigger("chosen:updated");
			                $('.panel').removeClass('panel-refreshing');
		                },
		                error: function(xhr, textStatus, thrownError) {
		                    console.log(thrownError);
		                }
		            });
				}
		        
		    }
		});

	});

	function validate(){

		if($("#modal").val()!=0){
			if($("#type").val()==1){
				if($("#quantity").val()!='' && $("#quantity").val()>0){
					$("#request_form").submit();
				}else{
					swal("Error!","Please enter valid quantity","error");
				}
			}else{
				if($("#asset_no").val()!='' && $("#asset_no").val()!=0){
					$("#request_form").submit();
				}else{
					swal("Error!","Please select asset","error");
				}
			}
		}else{
			swal("Error!","Please select asset modal","error");
		}
	}
</script>
@stop
