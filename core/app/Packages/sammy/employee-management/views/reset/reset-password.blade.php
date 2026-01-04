@extends('layouts.sammy_new.master') @section('title','Reset Password - Web Account')
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
  	<li class="active">Reset Password</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered refresh_panel">
      		<div class="panel-heading border">
        		<strong>Reset Password - Web Account</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post">
          		{!!Form::token()!!}
          			<div class="row">
		                <div class="form-group">
		            		<label class="col-sm-2 control-label">Employee Type</label>
		            		<div class="col-sm-4">
		            			@if($reset_multiple)
									@if($errors->has('empType'))
										{!! Form::select('empType',$empTypeList, [],['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Choose empType type','id'=>'empType']) !!}
										<label id="label-error" class="error" for="label">{{$errors->first('empType')}}</label>
									@else
										{!! Form::select('empType',$empTypeList, [],['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Choose damage empType','id'=>'empType']) !!}
									@endif
								@else
									@if($errors->has('empType1'))
										{!! Form::select('empType1',$empTypeList,$logged_employee_type,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Choose empType type','disabled'=>'disabled']) !!}
										<label id="label-error" class="error" for="label">{{$errors->first('empType1')}}</label>
									@else
										{!! Form::select('empType1',$empTypeList,$logged_employee_type,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Choose damage empType','disabled'=>'disabled']) !!}
									@endif
									<input type="hidden" name="empType" id="empType" value="{{$logged_employee_type}}">
								@endif
							</div>
							<div class="col-sm-4">
								@if($reset_multiple)
									{!! Form::select('employee',$employeeList, [],['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Choose employee','id'=>'employee']) !!}
								@else
									{!! Form::select('employee1',$employeeList, $logged_employee,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Choose employee','disabled'=>'disabled','id'=>'employee']) !!}
									<input type="hidden" name="employee" id="employee" value="{{$logged_employee}}">
								@endif
							</div>

							<div class="col-sm-2">
	                            <button type="button" class="btn btn-info" onclick="load_data()"><i class="fa fa-search"></i> Find
	                            </button>	                        
		                    </div>
		                </div>
	                </div>

	                <div class="row">

	                	<div class="web" hidden>
                			<div class="col-md-5 col-md-offset-1">
                				<div class="panel panel-bordered">
						      		<div class="panel-heading border">
						        		<strong>Web Credential</strong>
						      		</div>
						          	<div class="panel-body">
		        						<div class="row web-msg" hidden>
						          			<label class="col-sm-5 control-label">No credential for web</label>
						          		</div>
						          		<div class="row web-content" hidden style="padding-left: 9px;padding-right: 9px;">
			                                <div class="form-group">
			                                    <label class="col-sm-2 control-label required">User Name</label>
			                                    <div class="col-sm-10">
			                                        <input type="text" class="form-control @if($errors->has('user_name')) error @endif" readonly="true" name="user_name" id="user_name" placeholder="User Name" value="{{Input::old('user_name')}}" required >
			                                        @if($errors->has('user_name'))
			                                            <label id="label-error" class="error" for="label">{{$errors->first('user_name')}}</label>
			                                        @endif
			                                        <p id="uName_error" style="display:none;"></p>
			                                    </div>
			                                </div>
			                                <div class="form-group">
			                                    <label class="col-sm-2 control-label required">Password</label>
			                                    <div class="col-sm-10">
			                                        <input type="password" class="form-control @if($errors->has('password')) error @endif" name="password" id="password" placeholder="Password" value="{{Input::old('password')}}" required>
			                                        @if($errors->has('password'))
			                                            <label id="label-error" class="error" for="label">{{$errors->first('password')}}</label>
			                                        @endif
			                                    </div>
			                                </div>
			                                <div class="form-group">
			                                	<label class="col-sm-2 control-label required">Confirm</label>
			                                    <div class="col-sm-10">
			                                        <input type="password" class="form-control @if($errors->has('confirm_Password')) error @endif " name="confirm_Password" id="confirm_Password" placeholder="Confirm Password" value="{{Input::old('confirm_Password')}}" required>
			                                        @if($errors->has('confirm_Password'))
			                                            <label id="label-error" class="error" for="label">{{$errors->first('confirm_Password')}}</label>
			                                        @endif
			                                    </div>
			                                </div>
			                                <div class="col-sm-1 col-md-offset-11 btn-save" hidden>
						                        <div class="pull-right">
						                            <button type="button" style="margin-left: 20%" class="btn btn-primary" onclick="saveData()"><i class="fa fa-floppy-o"></i> Save
						                            </button>
						                        </div>
						                    </div>
			                            </div>
		                            </div>
		                        </div>
                            </div>
                            <div>
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
            	</form>
          	</div>
        </div>
	</div>
</div>
@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
	var type;
	var employee;

	var password;
	var confirm_Password;

	$(document).ready(function(){
		$('.form-validation').validate();

		type = $('#empType');
		employee = $('#employee');

		type.change(function (e) {
            loadEmployee();
        });

        password = $('input[name="password"]'); //password for web login
        confirm_Password = $('input[name="confirm_Password"]'); //confirm password for web login

        password.val('');
        
        confirm_Password.keyup(function(e){
            confirm_Password.parent().removeClass("has-error has-feedback").removeClass("has-success has-feedback");
            $('span.glyphicon').remove();
            $('sr-only').remove();
            if(confirm_Password.val().length > 0 && password.val().length > 0) {
                changeMsg();
            }
        });

        password.keyup(function(e){
            confirm_Password.parent().removeClass("has-error has-feedback").removeClass("has-success has-feedback");
            $('span.glyphicon').remove();
            $('sr-only').remove();
            
            if(confirm_Password.val().length > 0 && password.val().length > 0) {
                changeMsg();
            }
        });
	});

    /*
    * Load parent employee for new employee,
    * Load employee according to selected employee type
    */
    function loadEmployee(i) {
        
        $('.refresh_panel').addClass('panel-refreshing');
        employee.html("");

        $.ajax({
			url: "{{url('employee/reset/load-employee')}}",
			type: 'GET',
			data: {'type': type.val()},
			success: function(data) {	

				$.each(data, function( key, value ) {					
					employee.append('<option value="'+key+'">'+value+'</option>');
				});
				employee.trigger("chosen:updated");
				$('.refresh_panel').removeClass('panel-refreshing');
			},error: function(data){

			}
		});
    }

    function load_data(){

    	$('.refresh_panel').addClass('panel-refreshing');
    	$.ajax({
			url: "{{url('employee/reset/load-data')}}",
			type: 'GET',
			data: {'type': type.val(),'employee': employee.val()},
			success: function(data) {
				if(data.user.length==0){
					$('.web').show();
					$('.web-msg').show();
					$('.web-content').hide();

					$('.btn-save').hide();

				}else if(data.user.length!=0){
					$('.web').show();
					$('.web-msg').hide();
					$('.web-content').show();
					$('#user_name').val(data.user[0].username);

					$('.btn-save').show();

				}
				$('.refresh_panel').removeClass('panel-refreshing');
			},error: function(data){

			}
		});	
    }

    function changeMsg(){
        var password = $('input[name="password"]');
        var confirm_Password = $('input[name="confirm_Password"]');            

        if(isMatch(password.val(),confirm_Password.val())){
            confirm_Password.parent().addClass( "has-success has-feedback" ).append('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="right: 10px"></span><span id="inputSuccess2Status" class="sr-only">(success)</span>');
            $('#submit').prop('disabled', false);
            confirm_Password.parent().removeClass( "has-error has-feedback" );

        }else{
            $('#submit').prop('disabled', true);
            confirm_Password.parent().addClass( "has-error has-feedback" ).append('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="right: 10px"></span><span id="inputError2Status" class="sr-only">(error)</span>');
        }
    }

    function isMatch(val1, val2){
        return val1 === val2;
    }

    function saveData() {
        
        dd={};

        k=0;

		if($('.web').css('display') != 'none' && $('.web-content').css('display') != 'none'){
			
			if(password.val()!=""){
				if(password.val()==confirm_Password.val()){

					var re = /^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=\S*[\W]).{6,})\S$/;
					if (re.test(password.val())) {
						dd['web_password']=password.val();
					} else {
						swal('Error!','Password not secure. Follow the rules','error');
						k++;
					}

				}else{
					swal('Error!','Confirmed Password not matched','error');
					k++;
				}
			}else{
				password.addClass('error');
				k++;
			}

		}

		if(k==0){
			$('.web').addClass('panel-refreshing');        
	        
	        $.ajax({
				url: "{{url('employee/reset/reset-password')}}",
				type: 'POST',
				data: {'detail': dd,'employee': employee.val()},
				success: function(data) {
					if(data==1){
                        $('.web').removeClass('panel-refreshing');
                        swal({ 
                            title: "Well Done!",
                            text: "Password Reset Successfully Done",
                            type: "success" 
                        },function(){
                            window.location.href = "{{url('employee/reset/reset-password')}}";
                        });                 
                    }else{
                        $('.web').removeClass('panel-refreshing');
                        swal('Error!','Something went wrong','error');
                    }
				},error: function(data){

				}
			});
		}
    }
</script>
@stop
