@extends('layouts.sammy_new.master') @section('title','Service Report')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/vendor/bootstrap-datetimepicker/dist/css/bootstrap-datetimepicker.css')}}"/>
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

.btn-actions {
    color: #1975D1;
}

.btn-actions:hover {
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
    	<a href="#">Report Management</a>
  	</li>
  	<li class="active">Service Report</li>
</ol>

<form role="form" class="form-validation search-form" method="get">
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered" id="panel-search">
			<div class="panel-heading border">
				<h4><strong>Service Report</strong></h4>
			</div>
				<div class="panel-body">
					<div class="row">

						<div class="form-group col-md-4">
							<label class="control-label">Location</label>
							<select name="location" id="location" class="form-control chosen" required="required">
								@foreach($locations as $key=>$location)
									@if($key!=0)
										<option value="{{$key}}" @if($key==$old['location']) selected @endif>{{$location}}</option>
									@endif
								@endforeach
							</select>
							<label class="control-label">With Sub Location</label>
							<input type="checkbox" name="sub_loc" id="sub_loc" style="margin-top: 5px">
						</div>

						<div class="form-group col-md-4">
							<label class="control-label">Service Type</label>
							<select name="type" id="type" class="form-control chosen" required="required">
								<option value="0">--All--</option>								
								@foreach($types as $type)
									<option value="{{$type->id}}" @if($type->id==$old['type']) selected @endif>{{$type->name}}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group col-md-2" style="text-align: center">
							<label class="control-label">From Date</label>
							<div class='input-group date' id='completed_datedatetimepicker'>
								<input type='text' id="from_date" name="from_date" class="form-control" style="text-align: center" value="{{$old['from_date']}}"/>
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>

						<div class="form-group col-md-2" style="text-align: center">
							<label class="control-label">To Date</label>
							<div class='input-group date' id='completed_datedatetimepicker'>
								<input type='text' id="to_date" name="to_date" class="form-control" style="text-align: center" value="{{$old['to_date']}}"/>
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>						

					</div>
					<div class="row">
						<div class="form-group col-md-4">
							<label class="control-label">Serial No</label>
							<input type='text' id="serial" name="serial" class="form-control" value="{{$old['serial']}}"/>
						</div>

						<div class="form-group col-md-4">
							<label class="control-label">Inventory No</label>
							<input type='text' id="inventory_no" name="inventory_no" class="form-control" value="{{$old['inventory_no']}}"/>
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Service Status</label>
							<select name="status" id="status" class="form-control chosen" required="required">
								<option value="0">--All--</option>
								<option value="1" @if(1==$old['status']) selected @endif>Service Started</option>
								<option value="2" @if(2==$old['status']) selected @endif>Service Completed</option>
								<option value="3" @if(3==$old['status']) selected @endif>Service Pending</option>
							</select>
						</div>

					</div>
					
					<div class="row">
						<div class="form-group col-md-12">
							
							<div class="pull-right" style="margin-left:8px">
								<button type="button" class="btn btn-danger btn-pdf">
									<i class="fa fa-download"></i> PDF
								</button>
							</div>
							
							<div class="pull-right" style="margin-left:8px">
								<button type="button" class="btn btn-warning btn-excel">
									<i class="fa fa-download"></i> Excel
								</button>
							</div>

							<div class="pull-right" style="">
								<button type="submit" class="btn btn-primary btn-search">
									<i class="fa fa-check"></i> Search
								</button>
							</div>

						</div>
						
					</div>

				</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
          	<div class="panel-body table-responsive">
				<table class="table table-bordered">
					<thead style="background:#ddd">
						<tr>
							<th>Location</th>
							<th>Serial No</th>
							<th>Inventory No</th>
							<th>Supplier</th>
							<th>Brand</th>
							<th>Model</th>
							<th>Service Type</th>
							<th>Service Cost</th>
							<th>Service Start Date</th>
							<th>Service End Date</th>
							<th>Service Status</th>
							<th>Service By</th>
							<th>Remark/Receiver Details</th>
						</tr>
					</thead>
					<tbody>
					@if(count($data)>0)
						@foreach($data as $detail)
							<tr>
								@foreach($detail as $_sub_detail)
									<td>{{$_sub_detail}}</td>
								@endforeach
							</tr>
						@endforeach
					@endif
					</tbody>
				</table>
				
          	</div>
        </div>
	</div>
</div>
</form>

@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/moment/moment.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/bootstrap-datetimepicker/dist/js/bootstrap-datetimepicker.js')}}"></script>
<script type="text/javascript">

	var langs = JSON.parse('{!!json_encode($old)!!}');

	sub_loc=langs.sub_loc;

	if(sub_loc==1){
		$('#sub_loc').prop('checked',true);
	}

	$(document).ready(function(){

		$("#from_date").datetimepicker({format:'YYYY-MM-DD'});
		$("#to_date").datetimepicker({format:'YYYY-MM-DD'});

		$('.btn-search').click(function(e){
			e.preventDefault();
            // $(".panel").addClass('panel-refreshing');
            $('.search-form').submit();            
		});		

		$('.btn-excel').click(function(e){
			e.preventDefault();

        	loc_type 	= $("#loc_type").val();
        	loc 		= $("#location").val();
        	model 		= $("#status").val();
        	sub_loc 	= $("#sub_loc").val();
        	from_date 	= $("#from_date").val();
        	to_date 	= $("#to_date").val();
        	type 		= $("#type").val();
        	serial 		= $("#serial").val();
        	inventory 		= $("#inventory_no").val();

        	window.location.href = '{{url('reports/service-report/download/excel')}}?inventory_no='+inventory+'&serial='+serial+'&type='+type+'&loc_type='+loc_type+'&location='+loc+'&status='+model+'&sub_loc='+sub_loc+'&from_date='+from_date+'&to_date='+to_date;

		});

		$('.btn-pdf').click(function(e){
			e.preventDefault();

			loc_type 	= $("#loc_type").val();
			loc 		= $("#location").val();
			model 		= $("#status").val();
			sub_loc 	= $("#sub_loc").val();
			from_date 	= $("#from_date").val();
			to_date 	= $("#to_date").val();
			type 		= $("#type").val();
			serial 		= $("#serial").val();
			inventory 		= $("#inventory_no").val();

        	window.open('{{url('reports/service-report/download/pdf')}}?inventory_no='+inventory+'&serial='+serial+'&type='+type+'&loc_type='+loc_type+'&location='+loc+'&status='+model+'&sub_loc='+sub_loc+'&from_date='+from_date+'&to_date='+to_date,'_blank');

		});

	});

</script>
@stop
