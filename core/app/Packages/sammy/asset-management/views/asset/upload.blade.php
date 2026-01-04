@extends('layouts.sammy_new.master') @section('title','Upload Asset')
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

	.bs-callout-danger {
		border-left-color: #ce4844;
	}

	.bs-callout {
	    padding: 20px;
	    margin: 20px 0;
	    border: 1px solid #eee;
	    border-left-width: 5px;
	    border-radius: 3px;
	}

</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li>
    	<a href="{{URL::to('asset/list')}}">Asset Management</a>
  	</li>
  	<li class="active">Upload Asset</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border" >
        		<strong>Upload Asset </strong>
        		<div class="text-right pull-right">        			
				</div>
			</div>
          	<div class="panel-body">
          		<form role="form" class="form-validation" method="post" id="upload_form" name="upload_form" enctype="multipart/form-data">
          			{!!Form::token()!!}          			
          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          				<div class="row">
          					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
			      				<div class="form-group">
			      					<label for="">Location</label>
			      					{!! Form::select('location',$locations, Input::old('location'),['class'=>'chosen error','style'=>'width:100%;','required','id'=>'location']) !!}
			            			@if($errors->has('location'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('location')}}</label>
			            			@endif
			      				</div>
		      				</div>

          					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
			      				<div class="form-group">
			      					<label for="">Asset Model</label>
			      					{!! Form::select('asset_model',$asset_models, Input::old('asset_model'),['class'=>'chosen error','style'=>'width:100%;','required','id'=>'asset_model']) !!}
			            			@if($errors->has('asset_model'))
			            				<label id="label-error" class="error" for="label">{{$errors->first('asset_model')}}</label>
			            			@endif
			      				</div>          					
		      				</div>
		      				<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
		      					<div class="form-group">
				      				<button type="button" style="margin-top: 14%;margin-left: 26%" class="btn btn-warning" title="View Format" onclick="load_excel_format()"><i class="fa fa-download" style="padding-right: 10px"></i>Download</button>
		      					</div>
		      				</div>
          				</div>
          				<div class="row" id="excel_div" name="excel_div">
          				    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				                <div class="form-group">
				            		<label for="">Upload Product</label>
				            		<input id="input-ficons-1" name="inputficons1" multiple type="file" class="file-loading">				            		
				                </div>
				            </div>
				        </div>
          				<div class="row" id="save_div" name="save_div">
          				    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				            	<div class="form-group">
				            		<button type="submit" class="btn btn-primary pull-right">Save</button>
				            	</div>

				            </div>
          				</div>
          			</div>
            	</form>
          	</div>
          	<div class="panel-footer">
          		<div class="bs-callout bs-callout-danger" id="callout-popover-needs-tooltip" style="border-left-color: #ce4844 !important;"> 
          			<h5>Upload Rules</h5>
          			<p><i class="fa fa-asterisk" style="color: red" aria-hidden="true"></i>   Excel Format - .xls .</p>
          			<p><i class="fa fa-asterisk" style="color: red" aria-hidden="true"></i>   Prices - Without comma seperator .</p>
          			<p><i class="fa fa-asterisk" style="color: red" aria-hidden="true"></i>   Date Format - dd/mm/yyyy .</p>
          			<p><i class="fa fa-asterisk" style="color: red" aria-hidden="true"></i>   Mandatory Field - Manufacturer, Model, Asset No, Supplier, Purchased Date, Purchased Value, Warranty Begin, Warranty Period, Recovery Period.
          			</p>
          		</div>
          	</div>
        </div>
	</div>
</div>
<a href="" download id="download" name="download" hidden></a>
@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/sammy_new/file/bootstrap-fileinput-master/js/fileinput.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.form-validation').validate();

        $("#input-ficons-1").fileinput({
		    uploadUrl: "",
		    uploadAsync: true,
		    showUpload:false,
		    previewFileIcon: '<i class="fa fa-file"></i>',
		    allowedPreviewTypes: null, // set to empty, null or false to disable preview for all types
		    previewFileIconSettings: {
		        'docx': '<i class="fa fa-file-word-o text-primary"></i>',
		        'xlsx': '<i class="fa fa-file-excel-o text-success"></i>',
		        'pptx': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
		        'jpg': '<i class="fa fa-file-photo-o text-warning"></i>',
		        'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
		        'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
		    }
		});

		$("#location").chosen({
		    search_contains: true,
		});

		$('#upload_form').submit(function(e) {
			
			e.preventDefault();
			
			modal= $('#asset_model').val();
			loc= $('#location').val();
			file= $("#input-ficons-1").val();
			
			if(modal==0 || loc==0 || file==""){
				if(loc==0){
					swal('Error!','Select Loaction to continue','error');
				}else if(modal==0){
					swal('Error!','Select Modal to continue','error');
				}else if(file==""){
					swal('Error!','Select File to continue','error');
				}
			}else{
				$('.panel').addClass('panel-refreshing');
				var formData = new FormData(this);

				$.ajax({
	                type: "POST",
	                url: "{{url('asset/upload')}}",
	                data: formData,
	                async: false,
	                contentType: false,       
	                cache: false,             
	                processData:false,
	                success: function(data){
	                    $('.panel').removeClass('panel-refreshing');
	                    console.log(data);
	                    if(data==1){
							$('.panel').removeClass('panel-refreshing');
							swal({ 
								title: "Well Done!",
							   	text: "Successfully Created",
							    type: "success" 
							},function(){
							    window.location.href = "{{url('asset/upload')}}";
							});					
						}else if(data==11){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Modal Disabled. Please Activate disabled modal to upload','error');
						}else if(data==12){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Manufacturer Disabled. Please Activate disabled manufacturer to upload','error');
						}else if(data==13){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Supllier Disabled. Please Activate disabled supplier to upload','error');
						}else if(data==14){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Supllier & Manufacturer Disabled. Please Activate disabled supllier & manufacturer to upload','error');
						}else if(data==200){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Supplier Missing in Excel','error');
						}else if(data==201){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Manufacturer Missing in Excel','error');
						}else if(data==201){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Manufacturer Missing in Excel','error');
						}else if(data==202){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Model Missing in Excel','error');
						}else if(data==203){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Serial No Missing in Excel','error');
						}else if(data==204){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Purchased Date Missing in Excel','error');
						}else if(data==205){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Purchased Value Missing in Excel','error');
						}else if(data==206){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Warranty Begin Missing in Excel','error');
						}else if(data==207){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Warranty Period Missing in Excel','error');
						}else if(data==208){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Recovery Period Missing in Excel','error');
						}else if(data==300){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Serial Number duplicated. Remove Duplicates','error');
						}else if(data==500){
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Empty Row in excel. Remove Empty Row','error');
						}else{
							$('.panel').removeClass('panel-refreshing');
							swal('Error!','Something went wrong','error');
						}

	                },error: function(data){

	                }
	            });	
			}

		});
	});

	function load_excel_format(){

		modal= $('#asset_model').val();
		loc= $('#location').val();
		if(modal==0 || loc==0){
			if(loc==0){
				swal('Error!','Select Loaction to continue','error');
			}else if(modal==0){
				swal('Error!','Select Modal to continue','error');
			}
		}else{
			window.location.href = '{{url('asset/json/excel-detail')}}?modal='+modal+'&location='+loc;
		}

	}
	
</script>
@stop