@extends('layouts.sammy_new.master') @section('title','Edit Employee')
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

        .chosen-container {
            font-family: 'FontAwesome', 'Open Sans', sans-serif;
        }

        b, strong {
            font-weight: bold;
        }

    </style>
@stop
@section('content')
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/')}}"><i class="fa fa-home mr5"></i>Home</a>
        </li>
        <li>
            <a href="{{url('employee/list')}}">Employee Management</a>
        </li>
        <li class="active">Edit Employee</li>
    </ol>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-bordered">
                <div class="panel-heading border">
                    <strong>Edit Employee</strong>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal form-validation" method="post" id="edit_form" name="edit_form">
                        {!!Form::token()!!}

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">

                                        <input type="hidden" name="hidden_emp_id" id="hidden_emp_id" value="{{$employee->id}}">
                                    
                                        <label class="required">Designation</label>
                                        @if($errors->has('empType'))
                                            {!! Form::select('empType',$typeList, $employee->employee_type_id,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Choose Employee Parent','id'=>'empType']) !!}
                                            <label id="label-error" class="error" for="label">{{$errors->first('empType')}}</label>
                                        @else
                                            {!! Form::select('empType',$typeList, $employee->employee_type_id,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Choose Employee Parent','id'=>'empType']) !!}
                                        @endif
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                        <label class="required">First Name</label>
                                        <input type="text" class="form-control @if($errors->has('fName')) error @endif" name="fName" placeholder="First Name" required value="{{$employee->first_name}}">
                                        @if($errors->has('fName'))
                                            <label id="label-error" class="error" for="label">{{$errors->first('fName')}}</label>
                                        @endif
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                        <label class="required">Last Name</label>
                                        <input type="text" class="form-control @if($errors->has('lName')) error @endif" name="lName" placeholder="Last Name" value="{{$employee->last_name}}" required>
                                        @if($errors->has('lName'))
                                            <label id="label-error" class="error" for="label">{{$errors->first('lName')}}</label>
                                        @endif
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                        <label class="required">Code</label>
                                        <input type="text" class="form-control @if($errors->has('code')) error @endif" name="code" placeholder="Employee Code" value="{{$employee->code}}" required>
                                        @if($errors->has('code'))
                                            <label id="label-error" class="error" for="label">{{$errors->first('code')}}</label>
                                        @endif
                                </div>

                            </div>

                            <div class="row">


                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="required" style="margin-top: 6px">NIC</label>
                                    <input type="text" class="form-control @if($errors->has('nic')) error @endif" name="nic" placeholder="NIC" value="{{$employee->nic}}" required>
                                    @if($errors->has('nic'))
                                        <label id="label-error" class="error" for="label">{{$errors->first('nic')}}</label>
                                    @endif

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                                        
                                    <label class="" style="margin-top: 6px">Address </label>
                                    <input type="text" class="form-control @if($errors->has('address')) error @endif" name="address" placeholder="Address" value="{{$employee->address}}">
                                    @if($errors->has('address'))
                                        <label id="label-error" class="error" for="label">{{$errors->first('address')}}</label>
                                    @endif

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="" style="margin-top: 6px">Email</label>
                                    <input type="text" class="form-control @if($errors->has('email')) error @endif" name="email" placeholder="Email" value="{{$employee->email}}">
                                    @if($errors->has('email'))
                                        <label id="label-error" class="error" for="label">{{$errors->first('email')}}</label>
                                    @endif

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="required">Mobile </label>
                                    <input type="text" class="form-control @if($errors->has('mobile')) error @endif" name="mobile" placeholder="Mobile" value="{{$employee->mobile}}" required>
                                   @if($errors->has('mobile'))
                                         <label id="label-error" class="error" for="label">{{$errors->first('mobile')}}</label>
                                   @endif

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="required">Parent Employee</label>
                                    @if($errors->has('parent'))
                                        {!! Form::select('parent',$parentList, $employee->parent,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Choose employee parent','id'=>'parent']) !!}
                                        <label id="label-error" class="error" for="label">{{$errors->first('parent')}}</label>
                                    @else
                                        {!! Form::select('parent',$parentList, $employee->parent,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Choose employee parent','id'=>'parent']) !!}
                                    @endif

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="required">Location Type</label>
                                    {!! Form::select('locationType',$locationTypeList, $selectedLocType,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Choose locationType']) !!}

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="col-sm-2 control-label required">Location</label>
                                    {!! Form::select('location',$location, $selectedLoc,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Choose location','id'=>'location']) !!}

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    <label style="margin-top: 10%" class="required">Branch User</label>
                                    <input type="checkbox" name="br_usr" id="br_usr" title="Check to select as branch user" @if($employee->branch_user==1)checked @endif>
                                    <input type="hidden" name="branch_user" id="branch_user" value="{{$employee->branch_user}}">
                                    <button type="button" style="margin-top: 6%" onclick="validateAsset()" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
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

    var locType = $('select[name="locationType"]');
    var type = $('select[name="empType"]');

    $(document).ready(function () {

        $('.form-validation').validate();
        var type = $('select[name="empType"]');

        $('input[name="br_usr"]:checkbox').click(function(){
            if(this.checked){
                $("#branch_user").val(1);
            }else{
                $("#branch_user").val(0);              
            }
        });

        locType.change(function (e) {
            changeLocation();
        });

        type.change(function (e) {
            changeParent();
        });

       // var password = $('input[name="password"]');
        //var cPassword = $('input[name="cPassword"]');
    });

    /*
    * Load Location for new employee,
    * Load location according to selected location type
    */
    function changeLocation() {
        
        $('.panel').addClass('panel-refreshing');
        $('#location').html("");
        $.ajax({
            url: "{{url('employee/getLocation')}}",
            type: 'GET',
            data: {'type': locType.val()},
            success: function(data) {                
                $('#location').append('<option value="0">Select Location</option>');
                $.each(data,function(key,value){
                    $('#location').append('<option value="'+key+'">'+value+'</option>');
                });
                $('#location').trigger("chosen:updated");
                $('.panel').removeClass('panel-refreshing');
            },error: function(data){

            }
        });
    }    

    /*
    * Load employee for new employee,
    * Load employee according to selected emp type
    */
    function changeParent() {
        
        $('.panel').addClass('panel-refreshing');
        $('#parent').html("");
        $.ajax({
            url: "{{url('employee/getParent')}}",
            type: 'GET',
            data: {'type': type.val()},
            success: function(data) {                
                $.each(data,function(key,value){
                    $('#parent').append('<option value="'+key+'">'+value+'</option>');
                });
                $('#parent').trigger("chosen:updated");
                $('.panel').removeClass('panel-refreshing');
            },error: function(data){

            }
        });
    }

    /*
    * Check employee assigned asset,
    * 
    */
    function validateAsset() {
        
        $('.panel').addClass('panel-refreshing');
        $.ajax({
            url: "{{url('employee/getAsset')}}",
            type: 'GET',
            data: {'employee': $('#hidden_emp_id').val(),'location': $('#location').val()},
            success: function(data) {                
                $('.panel').removeClass('panel-refreshing');
                if(data==1){
                    swal('Error!','This user has assigned asset. Unassign it before change location','warning');
                }else{
                    $("#edit_form").submit();
                }
            },error: function(data){
                $('.panel').removeClass('panel-refreshing');
            }
        });
    }



</script>
@stop
