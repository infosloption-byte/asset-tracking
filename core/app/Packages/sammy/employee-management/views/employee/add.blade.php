@extends('layouts.sammy_new.master') @section('title','Add Employee')
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
            width: 100% !important;
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
        <li class="active">Add Employee</li>
    </ol>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-bordered">
                <div class="panel-heading border">
                    <strong>Add Employee</strong>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal form-validation" method="post">
                        {!!Form::token()!!}

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="required">Designation</label>
                                    @if($errors->has('empType'))
                                        {!! Form::select('empType',$typeList, [],['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Choose Employee Parent','id'=>'empType']) !!}
                                        <label id="label-error" class="error" for="label">{{$errors->first('empType')}}</label>
                                    @else
                                        {!! Form::select('empType',$typeList, [],['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Choose Employee Parent','id'=>'empType']) !!}
                                    @endif
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="required">First Name</label>
                                    <input type="text" class="form-control @if($errors->has('fName')) error @endif" name="fName" placeholder="First Name" required value="{{Input::old('fName')}}">
                                    @if($errors->has('fName'))
                                        <label id="label-error" class="error" for="label">{{$errors->first('fName')}}</label>
                                    @endif
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="required">Last Name</label>
                                    <input type="text" class="form-control @if($errors->has('lName')) error @endif" name="lName" placeholder="Last Name" value="{{Input::old('lName')}}" required>
                                    @if($errors->has('lName'))
                                        <label id="label-error" class="error" for="label">{{$errors->first('lName')}}</label>
                                    @endif
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="required">Code</label>
                                    <input type="text" class="form-control @if($errors->has('code')) error @endif" name="code" id="code" placeholder="Employee Code" value="{{Input::old('code')}}" required>
                                    @if($errors->has('code'))
                                        <label id="label-error" class="error" for="label">{{$errors->first('code')}}</label>
                                    @endif
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="required" style="margin-top: 6px">NIC</label>
                                    <input type="text" class="form-control @if($errors->has('nic')) error @endif" name="nic" placeholder="NIC" value="{{Input::old('nic')}}" required>
                                    @if($errors->has('nic'))
                                        <label id="label-error" class="error" for="label">{{$errors->first('nic')}}</label>
                                    @endif

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                                        
                                    <label class="" style="margin-top: 6px">Address </label>
                                    <input type="text" class="form-control @if($errors->has('address')) error @endif" name="address" placeholder="Address" value="{{Input::old('address')}}">
                                    @if($errors->has('address'))
                                        <label id="label-error" class="error" for="label">{{$errors->first('address')}}</label>
                                    @endif

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="" style="margin-top: 6px">Email</label>
                                    <input type="text" class="form-control @if($errors->has('email')) error @endif" name="email" placeholder="Email" value="{{Input::old('email')}}">
                                    @if($errors->has('email'))
                                        <label id="label-error" class="error" for="label">{{$errors->first('email')}}</label>
                                    @endif

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="required">Mobile </label>
                                    <input type="text" class="form-control @if($errors->has('mobile')) error @endif" name="mobile" placeholder="Mobile" value="{{Input::old('mobile')}}" required>
                                    @if($errors->has('mobile'))
                                        <label id="label-error" class="error" for="label">{{$errors->first('mobile')}}</label>
                                    @endif

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="required">Parent Employee</label>
                                    {!! Form::select('parent',$parentList, Input::old('parent'),['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Choose parent','id'=>'parent']) !!}

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="required">Location Type</label>
                                    @if($errors->has('locationType'))
                                        {!! Form::select('locationType',$locationTypeList, [],['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Choose locationType','id'=>'locationType']) !!}
                                        <label id="label-error" class="error" for="label">{{$errors->first('locationType')}}</label>
                                    @else
                                        {!! Form::select('locationType',$locationTypeList, [],['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Choose locationType','id'=>'locationType']) !!}
                                    @endif

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label class="required">Location</label>
                                    @if($errors->has('location'))
                                        {!! Form::select('location',$location, [],['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Choose location','id'=>'location']) !!}
                                        <label id="label-error" class="error" for="label">{{$errors->first('location')}}</label>
                                    @else
                                        {!! Form::select('location',$location, [],['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Choose location','id'=>'location']) !!}
                                    @endif

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    
                                    <label style="margin-top: 10%" class="required">Branch User</label>
                                    <input type="checkbox" name="br_usr" id="br_usr" title="Check to select as branch user">
                                    <input type="hidden" name="branch_user" id="branch_user" value="0">
                                    <button type="submit" style="margin-top: 10%" id="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
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
    
    var type = $('select[name="empType"]');
    var locType = $('select[name="locationType"]');
    
    $(document).ready(function () {

        $('.form-validation').validate();

        type.change(function (e) {
            changeParent();
        });

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

</script>
@stop
