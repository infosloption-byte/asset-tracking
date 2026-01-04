@extends('layouts.sammy_new.master') @section('title','Dynamic Report')
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
  	<li class="active">Dynamic</li>
</ol>

<form role="form" class="form-validation search-form" method="get">
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered" id="panel-search">
			<div class="panel-heading border">
				<h4><strong>Warranty Report</strong></h4>
			</div>
				<div class="panel-body">
					<div class="row">
						
						<div class="form-group col-md-3">
							<label class="control-label">Asset Location</label>
							<select name="location" id="location" class="form-control chosen" required="required">
								@foreach($locations as $key=>$location)
									<option value="{{$key}}" @if($key==$old['location']) selected @endif>{{$location}}</option>
								@endforeach
							</select>
							<label class="control-label">With Sub Location</label>
							<input type="checkbox" name="sub_loc" id="sub_loc" style="margin-top: 5px">
						</div> 

						<div class="form-group col-md-3">
							<label class="control-label">Asset Model</label>
							<select name="model" id="model" class="form-control chosen" required="required">
								<option value="0">--Select Model--</option>
								@foreach($asset_models as $asset_model)
									<option value="{{$asset_model->id}}" @if($asset_model->id==$old['model']) selected @endif>{{$asset_model->name}}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group col-md-2">
							<label class="control-label">Status</label>
							<select name="status" id="status" class="form-control chosen" required="required">
								<option value="0">-ALL-</option>
								@foreach($status as $stat)
									<option value="{{$stat->id}}" @if($stat->id==$old['status']) selected @endif>{{$stat->name}}</option>
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

						<div class="form-group col-md-12">
							<label class="control-label">Asset Model Field - Basic</label>
							<select name="modal-field-basic[]" id="modal-field-basic" class="form-control chosen" multiple required="required">
								<option value="0">-ALL-</option>								
								@if(count($old['basic_field'])==0)
									@foreach($fields_basic as $key=>$field_basic)
										<option value="{{$key}}" selected data-name="{{$field_basic}}">{{$field_basic}}</option>
									@endforeach
								@else
									@foreach($fields_basic as $key=>$field_basic)
										<option value="{{$key}}" @if(in_array($key,$old['basic_field'])) selected @endif data-name="{{$field_basic}}">{{$field_basic}}</option>
									@endforeach
								@endif
							</select>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							
							<div class="pull-right" style="margin-left:8px">
								<button type="button" class="btn btn-danger btn-pdf @if(!count($data)>0) disabled @endif">
									<i class="fa fa-download"></i> PDF
								</button>
							</div>
							
							<div class="pull-right" style="margin-left:8px">
								<button type="button" class="btn btn-warning btn-excel @if(!count($data)>0) disabled @endif">
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
          	<div class="panel-body">
				<table class="table table-bordered" style="display: block;max-height: 400px;overflow-y: auto;overflow-x: auto;white-space: nowrap;">
					<thead style="background:#ddd">
						<tr width="100%">
							<th>Location</th>
						@foreach($selected_col as $value)
							@if($value=='make')
								<th>Manufacturer</th>
							@elseif($value=='supplier_id')
								<th>Supplier</th>
							@else
								<th><?php echo ucwords(str_replace('_',' ',$value)); ?></th>
							@endif
						@endforeach
						</tr>
					</thead>
					<tbody>
					@foreach($data as $detail)
						<tr>
							<td><span>{{$detail->transaction[0]->location->name}}</span></td>
	                    	@foreach($selected_col as $value)
	                    		@if($value=='make')
				                	<td>{{$detail['manufacturerName']->name}}</td>
	                    		@elseif($value=='supplier_id')
				                	<td>{{($detail['supplierName'])?$detail['supplierName']->name:'-'}}</td>
	                    		@else
				                	<td>{{$detail[$value]}}</td>
				                @endif			

							@endforeach				

						</tr>
					@endforeach
					</tbody>
				</table>
				@if(count($data)>0)
					<?php echo $data->appends(Input::except('page'))->render()?>
				@endif
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

	specs=langs.spec_field;
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

        	loc = $("#location").val();
        	model = $("#model").val();
        	status = $("#status").val();
        	sub_loc = $("#sub_loc").val();
        	modal_field_basic = $("#modal-field-basic").val();
        	from_date = $("#from_date").val();
        	to_date = $("#to_date").val();

        	window.location.href = '{{url('reports/dynamic/download/excel')}}?location='+loc+'&model='+model+'&status='+status+'&modal-field-basic='+modal_field_basic+'&sub_loc='+sub_loc+'&from_date='+from_date+'&to_date='+to_date;

		});

		$('.btn-pdf').click(function(e){
			e.preventDefault();

        	loc = $("#location").val();
        	model = $("#model").val();
        	status = $("#status").val();
        	sub_loc = $("#sub_loc").val();
        	modal_field_basic = $("#modal-field-basic").val();
        	from_days = $("#from-days").val();
        	to_days = $("#to-days").val();
        	middle_date = $("#middle_date").val();

        	window.open('{{url('reports/dynamic/download/pdf')}}?location='+loc+'&model='+model+'&status='+status+'&modal-field-basic='+modal_field_basic+'&sub_loc='+sub_loc+'&from_date='+from_date+'&to_date='+to_date,'_blank');

		});

	});

</script>
@stop
