@extends('layouts.sammy_new.master') @section('title','Add Employee Type')
@section('css')
<style type="text/css">
	.panel.panel-bordered {
	    border: 1px solid #ccc;
	}

	.btn-primary {
	    color: white;
	    background-color: #C51C6A;
	    border-color: #C51C6A;
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
    	<a href="javascript:;">Employee Management</a>
  	</li>
  	<li class="active">Add Employee Type</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Add Type</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post">
          		{!!Form::token()!!}

						<div class="form-group">
		            		<label class="col-sm-2 control-label required">Type</label>
		            		<div class="col-sm-8">
		            			<input type="text" class="form-control @if($errors->has('name')) error @endif" name="name" placeholder="Enter Type Name" required value="{{Input::old('name')}}">
		            			@if($errors->has('label'))
		            				<label id="label-error" class="error" for="label">{{$errors->first('name')}}</label>
		            			@endif
		            		</div>
		                </div>

		                <div class="form-group">
		            		<label class="col-sm-2 control-label required">Parent</label>
		            		<div class="col-sm-8">
								@if($errors->has('parent'))
									{!! Form::select('parent',$parentList, [],['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Choose damage parent']) !!}
									<label id="label-error" class="error" for="label">{{$errors->first('parent')}}</label>
								@else
									{!! Form::select('parent',$parentList, [],['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Choose damage parent']) !!}
								@endif
							</div>
		                </div>
			               
	               	<div class="col-sm-1 col-md-offset-9" style="padding-left:0px;padding-right:0px;">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" style="width:19px;"></i> Save
                            </button>
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
	});
</script>
@stop
