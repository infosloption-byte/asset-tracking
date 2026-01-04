@extends('layouts.sammy_new.master') @section('title','Edit Location')
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
  	<li class="active">Edit Location</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Edit Location</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          			{!!Form::token()!!}
					<div class="form-group">
						<label class="col-sm-1 control-label required">Parent</label>
						<div class="col-sm-11">
							@if($errors->has('location'))
								{!! Form::select('parent',[], Input::old('parent'),['class'=>'chosen error','id' => 'parent','style'=>'width:100%;','required','data-placeholder'=>'Choose Parent Location']) !!}
								<label id="label-error" class="error" for="label">{{$errors->first('parent')}}</label>
							@else
								{!! Form::select('parent',[], $curLocation->parent,['class'=>'chosen','id'=>'parent','style'=>'width:100%;','required','data-placeholder'=>'Choose Parent Location']) !!}
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label required">Location Order</label>
						<div class="col-sm-11">
							@if($errors->has('location'))
								{!! Form::select('location_order',[], Input::old('location_order'),['class'=>'chosen error','id' => 'location_order','style'=>'width:100%;','required','data-placeholder'=>'Choose Location Order']) !!}
								<label id="label-error" class="error" for="label">{{$errors->first('location_order')}}</label>
							@else
								{!! Form::select('location_order',[], Input::old('location_order'),['class'=>'chosen','id'=>'location_order','style'=>'width:100%;','required','data-placeholder'=>'Choose Location Order']) !!}
							@endif
						</div>
					</div>
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
						<label class="col-sm-1 control-label required">Sub Location</label>
						<div class="col-sm-11">
							<input type="text" class="form-control @if($errors->has('label')) error @endif" name="location" placeholder="Location Name" required value="{{ $curLocation->name }}">
							@if($errors->has('location'))
								<label id="label-error" class="error" for="label">{{$errors->first('location')}}</label>
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
	load_parent();
	$(document).ready(function(){
		$('.form-validation').validate();

		$("#sbu").bind("click select change",function (event) {
			load_parent();
		});
	});

	function load_parent() {
		$(".panel").addClass('panel-refreshing');
		$.ajax({
			url: "{{url('location/get-location')}}",
			type: 'GET',
			data: {'selected' : {{ ($curLocation->parent)?$curLocation->parent:0 }}, 'allCat': 'allCat' },
			success: function (data) {
				$("#parent").html("").append('<option>Root</option>');
				$.each(data, function (index, value) {
					$("#parent").append(value);
				});
				$("#parent").trigger("chosen:updated");
				$(".panel").removeClass('panel-refreshing');

				load_location_order();
			},
			error: function (xhr, textStatus, thrownError) {
				console.log(thrownError);
			}
		});
	}

	function load_location_order() {
		$(".panel").addClass('panel-refreshing');
		$.ajax({
			url: "{{url('location/get-location')}}",
			type: 'GET',
			data: {'allCat': 'allCat'},
			success: function (data) {
				$("#location_order").html("").append('<option>Root</option>');
				$.each(data, function (index, value) {
					$("#location_order").append(value);
				});
				$("#location_order").trigger("chosen:updated");
				$(".panel").removeClass('panel-refreshing');
			},
			error: function (xhr, textStatus, thrownError) {
				console.log(thrownError);
			}
		});
	}
</script>
@stop
