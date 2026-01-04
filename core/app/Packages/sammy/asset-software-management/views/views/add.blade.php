@extends('layouts.sammy_new.master') @section('title','Add Software')
@section('css')
 <link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/file/bootstrap-fileinput-master/css/fileinput.css')}}"media="all" />
 <link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/vendor/bootstrap3-wysihtml5/dist/bootstrap3-wysihtml5.min.css')}}"/>
 <link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/vendor/bootstrap-datetimepicker/dist/css/bootstrap-datetimepicker.css')}}"/>
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
    	<a href="{{{url('software/license/list')}}}">Software Management</a>
  	</li>
  	<li class="active">Add Software</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Add Software</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}
					<div class="row">
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								<label class="control-label ">Name</label>
								@if($errors->has('name'))
									<input placeholder="ex:office 365,adobe photoshop"   type="text" name="name" id="name" class="form-control" >
									<label id="label-error" class="error" for="label">{{$errors->first('name')}}</label>
								@else
									<input placeholder="ex:office 365,adobe photoshop"  type="text" name="name" id="name" class="form-control" >
								@endif
							</div>
						</div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
							<div class="form-group">
								<label for="" class="">From</label>
								<div class='input-group date' id='completed_datedatetimepicker'>
									<input type='text' id="from" name="from" class="form-control" placeholder="Start date"/>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
								@if($errors->has('from'))
		            				<label id="label-error" class="error" for="label">
		            					{{$errors->first('from')}}
		            				</label>
		            			@endif
							</div>
						</div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
							<div class="form-group">
								<label for="" class="">Warranty Period(months)</label>
								@if($errors->has('perior'))
									<input placeholder="ex:36,12"   type="text" name="period" id="period" class="form-control" >
									<label id="label-error" class="error" for="label">{{$errors->first('period')}}</label>
								@else
									<input  placeholder="ex:36,12"  type="text" name="period" id="period" class="form-control" >
								@endif
								@if($errors->has('period'))
		            				<label id="label-error" class="error" for="label">
		            					{{$errors->first('period')}}
		            				</label>
		            			@endif
							</div>
						</div>
						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
							<div class="form-group">
								<div class="checkbox" style="margin-top: 30px">
									<label>
										<input type="checkbox" name="unlimited_time" value="0" id="unlimited_time"> Unlimited
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
							<div class="form-group">
								<label class="control-label ">Manufacture</label>
		      					{!! Form::select('manufacturer',$manufacturers, Input::old('manufacturer'),['class'=>'chosen error','style'=>'width:100%;','required']) !!}
		            			@if($errors->has('manufacturer'))
		            				<label id="label-error" class="error" for="label">
		            					{{$errors->first('manufacturer')}}
		            				</label>
		            			@endif
							</div>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
							<div class="form-group">
								<label class="control-label ">Supplier</label>
		      					{!! Form::select('supplier',$suppliers, Input::old('manufature'),['class'=>'chosen error','style'=>'width:100%;','required']) !!}
		            			@if($errors->has('supplier'))
		            				<label id="label-error" class="error" for="label">
		            					{{$errors->first('supplier')}}
		            				</label>
		            			@endif
							</div>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
							<div class="form-group">
								<label class="control-label ">Category</label>
								{!! Form::select('category',$categories, Input::old('category'),['class'=>'chosen error','style'=>'width:100%;','required']) !!}
		            			@if($errors->has('category'))
		            				<label id="label-error" class="error" for="label">
		            					{{$errors->first('category')}}
		            				</label>
		            			@endif
							</div>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
							<div class="form-group">
								<label class="control-label ">Version</label>
								@if($errors->has('version'))
									<input placeholder="ex:1.1.2" type="text" name="version" id="version" class="form-control" >
									<label id="label-error" class="error" for="label">{{$errors->first('version')}}</label>
								@else
									<input placeholder="ex:1.1.2"  type="text" name="version" id="version" class="form-control" >
								@endif
							</div>
						</div>						
					</div>

					<div class="row">
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
							<div class="form-group">
								<label class="control-label ">No of user license</label>
								@if($errors->has('users'))
									<input type="number" step="1" name="users" id="users" class="form-control" placeholder="Enter user count">
									<label id="label-error" class="error" for="label">{{$errors->first('users')}}</label>
								@else
									<input type="number" step="1" name="users" id="users" class="form-control" placeholder="Enter user count">
								@endif
							</div>
						</div>

						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
							<div class="form-group">
								<div class="checkbox" style="margin-top: 30px">
									<label>
										<input type="checkbox" name="unlimited" value="0" id="unlimited"> Unlimited
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="row" style="margin-bottom: 20px">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label for="" class="">Remark</label>
							<textarea class="form-control" type="text" name="notes" id="notes" placeholder="Enter remark..."></textarea>
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
<script src="{{asset('assets/sammy_new/vendor/bootstrap3-wysihtml5/dist/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script src="{{asset('assets/sammy_new/file/bootstrap-fileinput-master/js/fileinput.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/sammy_new/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/moment/moment.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/bootstrap-datetimepicker/dist/js/bootstrap-datetimepicker.js')}}"></script>


<script type="text/javascript">
	var t=0;
	$(document).ready(function(){

		$('.form-validation').validate();

        $("#from").datetimepicker({format:'YYYY-MM-DD'});
        $("#to").datetimepicker({format:'YYYY-MM-DD'});

		$('#unlimited').click(function () {
			var aa = $(this).val();
			if($(this).is(':checked'))
                $("#users").attr('disabled',true);  // checked
            else
                $("#users").attr('disabled',false);

        });

		$('#unlimited_time').click(function () {
			var aa = $(this).val();
			if($(this).is(':checked')) {
				$("#period").val(0);
				$("#period").attr('readonly', true); // checked
			}else
				$("#period").attr('readonly',false);

		});

	});


</script>
@stop
