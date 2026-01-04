@extends('layouts.sammy_new.master') @section('title','Delete Assets')
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
  	<li class="active">Delete Asset</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border" >
        		<strong>Delete Asset </strong>
        		<div class="text-right pull-right">        			
				</div>
			</div>
          	<div class="panel-body">
          		<form role="form" class="form-validation" method="post" id="delete_form" name="delete_form" enctype="multipart/form-data">
          			{!!Form::token()!!}          			
          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
				            		<button type="submit" class="btn btn-danger pull-right">Delete</button>
				            	</div>

				            </div>
          				</div>
          			</div>
            	</form>
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

		$('#delete_form').submit(function(e) {
			
			e.preventDefault();
			
			file= $("#input-ficons-1").val();
			
			$('.panel').addClass('panel-refreshing');
			var formData = new FormData(this);

			$.ajax({
                type: "POST",
                url: "{{url('asset/delete')}}",
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
						   	text: "Successfully Deleted",
						    type: "success" 
						},function(){
						    window.location.href = "{{url('asset/delete')}}";
						});					
					}else{
						$('.panel').removeClass('panel-refreshing');
						swal('Error!','Something went wrong','error');
					}

                },error: function(data){

                }
            });

		});
	});
	
</script>
@stop