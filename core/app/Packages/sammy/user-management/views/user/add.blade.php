@extends('layouts.sammy_new.master') @section('title','Add User')
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
    	<a href="javascript:;">User Management</a>
  	</li>
  	<li class="active">User User</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Add User</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" id="role_form" name="role_form">
          		{!!Form::token()!!}          			
	                <div class="form-group">
	            		<label class="col-md-2 control-label">Employee</label>	            		
	            		<div class="col-md-9">
	            			<select name="emp" id="emp" class="chosen col-md-12">
								<option value="0">-Select Employee-</option>
								@foreach($employees as $emp)
									<option code="{{$emp->code}}" value="{{$emp->id}}" @if($emp->id==Input::old('emp')) selected @endif>{{$emp->code}}  -  {{$emp->first_name}} {{$emp->last_name}}
									@if($emp->codes!=null) ({{$emp->codes}}) @endif
									</option>
								@endforeach
							</select>
							<label id="label-error" class="error" for="label">{{$errors->first('emp')}}</label>
	            		</div>
	                </div>

	                <div class="form-group">
	            		<label class="col-sm-2 control-label">Role</label>	            		
	            		<div class="col-sm-9">
	            			@if($errors->has('roles'))
	            				{!! Form::select('roles',$roles, Input::old('roles'),['class'=>'chosen error', 'id'=>'roles','style'=>'width:100%;','required']) !!}
	            				<label id="label-error" class="error" for="label">{{$errors->first('roles')}}</label>
	            			@else
	            				{!! Form::select('roles',$roles, Input::old('roles'),['class' => 'chosen', 'id'=>'roles','style'=>'width:100%;','required']) !!}
	            			@endif
	            		</div>
	                </div>
	                        
	               
	                <div class="form-group">
	            		<label class="col-sm-2 control-label required">User Name</label>
	            		<div class="col-sm-9">
	            			<input type="text" class="form-control @if($errors->has('user_name')) error @endif" name="user_name" id="user_name" placeholder="User Name" required value="{{Input::old('user_name')}}">
	            			@if($errors->has('user_name'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('user_name')}}</label>
	            			@endif
	            		</div>
	            		
	                </div>
	                <div class="form-group">
	            		<label class="col-sm-2 control-label required">Password</label>
	            		<div class="col-sm-9">
	            			<input type="password" class="form-control @if($errors->has('password')) error @endif" name="password" placeholder="Password" required value="{{Input::old('password')}}">
	            			@if($errors->has('password'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('password')}}</label>
	            			@endif
	            		</div>
	            		
	                </div>
	                <div class="form-group">
	            		<label class="col-sm-2 control-label required">Confirm Password</label>
	            		<div class="col-sm-9">
	            			<input type="password" class="form-control @if($errors->has('confirmed')) error @endif" name="password_confirmation" placeholder="Confirm Password" required value="{{Input::old('confirmed')}}">
	            			@if($errors->has('confirmed'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('confirmed')}}</label>
	            			@endif
	            		</div>
	            		
	                </div>
	                <div class="pull-right">
	                	<button type="button" class="btn btn-primary" onclick="validate()"><i class="fa fa-floppy-o"></i> Save</button>
	                </div>


		          	
            	</form>
          	</div>
          	<div class="panel-footer">
                <div class="bs-callout bs-callout-danger" id="callout-popover-needs-tooltip" style="border-left-color: #ce4844 !important;"> 
                    <h5>Password Rules</h5>
                    <p><i class="fa fa-asterisk" style="color: red" aria-hidden="true"></i> - Must contain at-least 6 characters .</p>
                    <p><i class="fa fa-asterisk" style="color: red" aria-hidden="true"></i> - Must contain at-least one Upper case character .</p>
                    <p><i class="fa fa-asterisk" style="color: red" aria-hidden="true"></i> - Must contain at-least one Lower case character .</p>
                    <p><i class="fa fa-asterisk" style="color: red" aria-hidden="true"></i> - Must contain at-least one number .</p>
                    <p><i class="fa fa-asterisk" style="color: red" aria-hidden="true"></i> - Must contain at-least one special character(@#$) .</p>
                    <p><i class="fa fa-asterisk" style="color: red" aria-hidden="true"></i> - Ex: Admin@123 .</p>
                </div>
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

		$("#emp").change(function(e){
			$("#user_name").val(this.options[this.selectedIndex].getAttribute('code'));
		});

		$("#emp").chosen({
		    search_contains: true,
		});

	});
		
	function validate(){
		if($("#roles").val()==0){
			swal('Error!','Please select role','error');
		}else{
			$('#role_form').submit();
		}
	}
	
</script>
@stop
