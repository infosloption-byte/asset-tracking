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
			<a href="{{{url('asset-modal/list')}}}">Asset-Modal Management Check</a>
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
					<form role="form" class="form-validation" method="post" enctype="multipart/form-data">
						{!!Form::token()!!}
						<div class="form-group">
							<label class="control-label required">Barcode Type</label>
							@if($errors->has('type'))
								{!! Form::select('type',$types, Input::old('type'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Choose barcode type']) !!}
								<label id="label-error" class="error" for="label">{{$errors->first('category')}}</label>
							@else
								{!! Form::select('type',$types, Input::old('type'),['class'=>'chosen','id'=>'type','style'=>'width:100%;','required','data-placeholder'=>'Choose barcode type']) !!}
							@endif
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
	<script type="text/javascript">
        var t=0;
        $(document).ready(function(){

            $('.form-validation').validate();

            $('input[name="device-field-0"]').tagsinput({
                freeInput: true
            });

        });

	</script>
@stop
