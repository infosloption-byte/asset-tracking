@extends('layouts.sammy_new.master') @section('title','Location List')
@section('css')

<style type="text/css">
	.switch.switch-sm{
		width: 30px;
    	height: 16px;
	}

	.switch.switch-sm span i::before{
		width: 16px;
    	height: 16px;
	}

.btn-success:hover, .btn-success:focus, .btn-success.focus, .btn-success:active, .btn-success.active, .open > .dropdown-toggle.btn-success {
    color: white;
    background-color: #D96557;
    border-color: #D96557;
}
.btn-success {
    color: white;
    background-color: #D96456;
    border-color: #D96456;
}


.btn-success::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    z-index: -1;
    width: 100%;
    height: 100%;
    background-color: #BB493C;
    -moz-opacity: 0;
    -khtml-opacity: 0;
    -webkit-opacity: 0;
    opacity: 0;
    -ms-filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0 * 100);
    filter: alpha(opacity=0 * 100);
    -webkit-transform: scale3d(0.7, 1, 1);
    -moz-transform: scale3d(0.7, 1, 1);
    -o-transform: scale3d(0.7, 1, 1);
    -ms-transform: scale3d(0.7, 1, 1);
    transform: scale3d(0.7, 1, 1);
    -webkit-transition: transform 0.4s, opacity 0.4s;
    -moz-transition: transform 0.4s, opacity 0.4s;
    -o-transition: transform 0.4s, opacity 0.4s;
    transition: transform 0.4s, opacity 0.4s;
    -webkit-animation-timing-function: cubic-bezier(0.2, 1, 0.3, 1);
    -moz-animation-timing-function: cubic-bezier(0.2, 1, 0.3, 1);
    -o-animation-timing-function: cubic-bezier(0.2, 1, 0.3, 1);
    animation-timing-function: cubic-bezier(0.2, 1, 0.3, 1);
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
}


.switch :checked + span {
    border-color: #398C2F;
    -webkit-box-shadow: #398C2F 0px 0px 0px 21px inset;
    -moz-box-shadow: #2ecc71 0px 0px 0px 21px inset;
    box-shadow: #398C2F 0px 0px 0px 21px inset;
    -webkit-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
    -moz-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
    -o-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
    transition: border 300ms, box-shadow 300ms, background-color 1.2s;
    background-color: #398C2F;
}

.datatable a.blue {
    color: #1975D1;
}

.datatable a.blue:hover {
    color: #003366;
}

.modal-dialog {
	margin-top: 15%;
}

.modal-body {
	padding: 30px;
}
</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li>
    	<a href="javascript:;">Location Management</a>
  	</li>
  	<li class="active">Location List</li>
</ol>

<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
                <a href="{{{url('location/add')}}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> New</a>
        		<strong>Location List</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          			<div class="form-group">

	                	<div class="col-sm-12">
		                	<table class="table table-bordered bordered table-striped table-condensed datatable">
				              	<thead>
					                <tr>
					                  	<th rowspan="2" class="text-center" width="2%">#</th>
                                        <th rowspan="2" class="text-center" style="font-weight:normal;">Name</th>
                                        <th rowspan="2" class="text-center" style="font-weight:normal;">Code</th>
                                        <th rowspan="2" class="text-center" style="font-weight:normal;">Type</th>
                                        <th rowspan="2" class="text-center" style="font-weight:normal;">Parent</th>
                                        <th rowspan="2" class="text-center" style="font-weight:normal;">Email</th>
                                        <th rowspan="2" class="text-center" style="font-weight:normal;">Contact</th>
					                  	<th rowspan="2" class="text-center" style="font-weight:normal;">Address</th>
					                  	<th colspan="2" class="text-center" width="4%" style="font-weight:normal;">Action</th>
					                </tr>
					                <tr style="display: none;">
					                	<th style="display: none;" width="2%"></th>
					                	<th style="display: none;" width="2%"></th>
					                </tr>
				              	</thead>

                                <tbody>
                                    @foreach($locations as $location)
                                        <tr>
                                            <td>{{$location['num']}}</td>
                                            <td>{{$location['name']}}</td>
                                            <td>{{$location['code']}}</td>
                                            <td>{{$location['loc_type']}}</td>
                                            <td>{{$location['loc_parent']}}</td>
                                            <td>{{$location['email']}}</td>
                                            <td>{{$location['contact']}}</td>
                                            <td>{{$location['address']}}</td>
                                            

                                            <td>
                                                @if (Sentinel::hasAnyAccess(['location.edit', 'admin']))
                                                    <a href="#" class="blue" onclick="window.location.href=('edit/{{$location['id']}}')" data-toggle="tooltip" data-placement="top" title="Edit Location"><i class="fa fa-pencil"></i></a>
                                                @else
                                                    <a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>
                                                @endif
                                            </td>

                                            <td>
                                                @if(Sentinel::hasAnyAccess(['location.status', 'admin']))
                                                    @if($location['status']==1)
                                                        <label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Click to Deactivate">
                                                            <input class="location-activate" type="checkbox" checked value="{{$location['id']}}">
                                                            <span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span>
                                                        </label>
                                                    @else
                                                        @<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Click to Activate">
                                                            <input class="location-activate" type="checkbox" value="{{$location['id']}}">
                                                            <span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span>
                                                        </label>
                                                    @endif
                                                @else 
                                                    @if($location['status']==1)
                                                        <label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Click to Deactivate" disabled>
                                                            <input class="location-activate" type="checkbox" checked value="{{$location['id']}}">
                                                            <span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span>
                                                        </label>
                                                    @else
                                                        <label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Click to Activate" disabled>
                                                            <input class="location-activate" type="checkbox" value="{{$location['id']}}">
                                                            <span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span>
                                                        </label>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

				            </table>
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
	var table = '';
	$(document).ready(function(){
        // table = generateTable('.datatable', '{{url('location/json/list')}}',[],[0,2,3,4,5,6,7,8],[],[],[0,"asc"]);

        // table.on('draw.dt',function(){
        //     $("[data-toggle=tooltip]").tooltip();

            $('.location-activate').change(function(){
                $('.panel').addClass('panel-refreshing');
                if($(this).prop('checked')==true){                  
                    ajaxRequest( '{{url('location/status')}}' , { 'id' : $(this).val() , 'status' : 1 }, 'post', successFunc);
                }else{                  
                    ajaxRequest( '{{url('location/status')}}' , { 'id' : $(this).val() , 'status' : 0 }, 'post', successFunc);
                }
            });
        // });
	});

    function successFunc(data){
        if(data.status=='success'){
            $('.panel').removeClass('panel-refreshing');
            sweetAlert('Success','Action Successfully Done!',0);
            window.location.reload();
        }else{
            sweetAlert('Error Occured','Please try again!',3);
        }
    }
</script>
@stop
