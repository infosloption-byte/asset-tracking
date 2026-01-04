@extends('layouts.sammy_new.master') @section('title','Edit User')
@section('css')
<style type="text/css">
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
    	<a href="{{{url('user/list')}}}">User Management</a>
  	</li>
  	<li>
    	<a href="{{{url('user/list')}}}">User List</a>
  	</li>
  	<li class="active">Edit User</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Edit User</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post">
          		{!!Form::token()!!}
	                <div class="form-group">
	            		<label class="col-sm-2 control-label">Role</label>
	            		<div class="col-sm-10">
	            			@if($errors->has('roles[]'))
	            				{!! Form::select('roles[]',$roles, $srole,['class'=>'chosen error','id'=>'roles','style'=>'width:100%;','required']) !!}
	            				<label id="label-error" class="error" for="label">{{$errors->first('roles[]')}}</label>
	            			@else
	            				{!! Form::select('roles[]',$roles,$srole,['class' => 'chosen','id'=>'roles','style'=>'width:100%;','required']) !!}
	            			@endif
	            		</div>
	                </div>
	                <div class="form-group">
	            		<label class="col-sm-2 control-label required">User Name</label>
	            		<div class="col-sm-10">
	            			<input type="text" class="form-control @if($errors->has('user_name')) error @endif" name="user_name" placeholder="User Name" required value="{{$curUser->username}}" readonly>
	            			@if($errors->has('user_name'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('user_name')}}</label>
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
<script type="text/javascript">
	$(document).ready(function(){
		$('.form-validation').validate();
		$('#permissions').multiSelect();
	});
</script>
@stop
