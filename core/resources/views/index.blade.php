@extends('layouts.sammy_new.master') @section('title','You are in Index Page.')
@section('content')
<div class="eq-col" style="background-color: white">
    <div class="container full-height">
        <div class="display-row">
        <!-- error wrapper -->
            <div class="center-wrapper error-page">
                <br><br><br><br><br><br>
                <div class="row">
                    <div class="col-md-10">
                        <div class="text-center" style="padding-left: 150px;width:100%">
                            <div class="error-number" style="font-size: 75px">
                                <span>Asset Tracking</span>
                            </div>
                            <div class="h5">Welcome to Asset Tracking. Nothing to worry about your assets.</div>
                            <p>We keep your asset in tracks</p>
                            @if($user->hasAnyAccess(['dashboard', 'admin']))
                            <a class="btn btn-primary" href="{{url('dashboard')}}" style="padding: 15px 15px;margin-right: 5%">
                                <span style="border: 1px solid;padding: 5px;"><i class="fa fa-tachometer"></i> Dashboard</span>
                            </a>
                            @endif
                            @if($user->hasAnyAccess(['asset.list', 'admin']))
                            <a class="btn btn-success" href="{{url('asset/list')}}" style="padding: 15px 15px;margin-right: 5%">
                                <span style="border: 1px solid;padding: 5px;"><i class="fa fa-barcode"></i> Asset List</span>
                            </a>
                            @endif
                            @if($user->hasAnyAccess(['checkInout.checkin', 'admin']))
                            <a class="btn btn-default" href="{{url('check-inout/checkin')}}" style="padding: 15px 15px;margin-right: 5%">
                                <span style="border: 1px solid;padding: 5px;"><i class="fa fa-check"></i>Check-In</span>
                            </a>
                            @endif
                            @if($user->hasAnyAccess(['checkInout.checkout', 'admin']))
                            <a class="btn btn-default" href="{{url('check-inout/checkout')}}" style="padding: 15px 15px">
                                <span style="border: 1px solid;padding: 5px;"><i class="fa fa-check"></i>Check-Out</span>
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="center-content text-center">

                        </div>
                    </div>
                </div>
                <!-- /error wrapper -->
            </div>
        </div>
    </div>
</div>
@stop
