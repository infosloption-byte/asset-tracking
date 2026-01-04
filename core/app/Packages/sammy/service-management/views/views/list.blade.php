@extends('layouts.sammy_new.master') @section('title','Service List')
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

</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li>
    	<a href="#">Service Management</a>
  	</li>
  	<li class="active">Services List</li>
</ol>

<div class="row">
	<div class="col-xs-12">
		<form role="form" class=" form-validation" method="get" enctype="multipart/form-data">
			<div class="panel panel-bordered" id="panel-search">
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-4">
							<label class="control-label">Asset Location</label>
							<select name="location" id="location" class="form-control chosen" required="required">
								<option value="0">-select location-</option>
								@foreach($locations as $location)
									<option value="{{$location->id}}">{{$location->name}}</option>
									@foreach($location->children as $children)
										<option value="{{$children->id}}">{{$children->name}}</option>
									@endforeach
								@endforeach
							</select>
						</div>

						<div class="form-group col-md-4">
							<label class="control-label">Serial No</label>
							<input type="text" name="serial_no" id="serial_no" class="form-control" placeholder="Search by serial no" value="">
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Service No</label>
							<input type="text" name="no" id="inv_no" class="form-control" placeholder="Search by service no" value="">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="pull-right">
								<button type="submit" class="btn btn-primary btn-search">
									<i class="fa fa-check"></i> search
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>



<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered service">
			<div class="panel-heading border" >
				<strong>Add Service</strong>
			</div>
			<div class="panel-body">
				<table class="table table-bordered table-hover" id="tableIn">
					<thead style="background-color: #747177;color: #fff">
					<tr>
						<th width="5%">#</th>
						<th>Service No</th>
						<th>Asset No</th>
						<th>In Date</th>
						<th>Start Date</th>
						<th>Completed Date</th>
						<th width="20%">Actions</th>
					</tr>
					</thead>
					<tbody id="tbody">
                    <?php $i=1 ?>
					@foreach($services as $service)
						<tr>
							<td width="5%">
								{{$i}}
							</td>
							<td>
								#{{$service->service_no}}
							</td>
							<td>
								{{$service->asset->asset_no}}<br>
								{{$service->asset->assetmodel->name}} <br>
								{{$service->asset->supplier->name}}
							</td>
							<td>{{date_create_from_format('Y-m-d', $service->service_in_date)->format('Y-m-d')}}</td>
							<td>
								@if($service->start_date!=null)
								{{date_create_from_format('Y-m-d', $service->start_date)->format('Y-m-d')}}
								@else
									-
								@endif
							</td>
							<td>
								@if($service->completed_date!=null)
								{{date_create_from_format('Y-m-d', $service->completed_date)->format('Y-m-d')}}
								@else
									-
								@endif
							</td>

							<td>
								@if($service->start_date==null)
									@if($user->hasAnyAccess(['admin','service.start']))
										<button data-toggle="modal" href="#modal-id" type="submit" class="btn btn-default btn-xs btn-start" data-id="{{$service->id}}">Start</button>
									@else
										<button data-toggle="modal" href="#modal-id" type="submit" class="btn btn-default btn-xs btn-start" disabled="">Start</button>
									@endif
									<a   class="btn btn-default btn-xs " href="{{url('service/view').'/'.$service->id}}">view</a>

									 <a  class="btn btn-default btn-xs " href="{{url('service/print').'/'.$service->id}}">print</a>
								@elseif($service->completed_date==null)
									@if($user->hasAnyAccess(['admin','service.complete']))
										<button data-toggle="modal" href="#modal-id" type="submit" class="btn btn-default btn-xs btn-complete" data-id="{{$service->id}}">Complete</button>
									@else
										<button data-toggle="modal" href="#modal-id" type="submit" class="btn btn-default btn-xs btn-complete" disabled="">Complete</button>
									@endif
									
									<a  class="btn btn-default btn-xs " href="{{url('service/view').'/'.$service->id}}">view</a>

									 <a  class="btn btn-default btn-xs " href="{{url('service/print').'/'.$service->id}}">print</a>
								@else
									 <a  class="btn btn-default btn-xs " href="{{url('service/view').'/'.$service->id}}">view</a>

									 <a  class="btn btn-default btn-xs " href="{{url('service/print').'/'.$service->id}}">print</a>
								@endif
							</td>
						</tr>
                        <?php $i++ ?>
					@endforeach

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
	var id = 0;

	$(document).ready(function(){
        $('.btn-start').click(function(){
            var id = $(this).data('id');
            $(".service").addClass('panel-refreshing');
            $.ajax({
                url: "{{url('service/json/start_service')}}",
                type: 'get',
                data: {
                    'id': id
                },
                success: function (data) {
                    $(".service").removeClass('panel-refreshing');
                    if(data.status>0){
                        swal("Success", 'Service started','success');
                        location.reload();
                    }else{
                        swal("Error", 'Something happend while processing','error');
                    }
                },
                error: function (xhr, textStatus, thrownError) {
                    console.log(thrownError);
                }
            });
        });

        $('.btn-complete').click(function(){
            var id = $(this).data('id');
            $(".service").addClass('panel-refreshing');
            $.ajax({
                url: "{{url('service/json/complete_service')}}",
                type: 'get',
                data: {
                    'id': id
                },
                success: function (data) {
                    $(".service").removeClass('panel-refreshing');
                    if(data.status>0){
                        swal("Success", 'Service Completed','success');
                        location.reload();
                    }else{
                        swal("Error", 'Something happend while processing','error');
                    }
                },
                error: function (xhr, textStatus, thrownError) {
                    console.log(thrownError);
                }
            });
        });
	});


</script>
@stop
