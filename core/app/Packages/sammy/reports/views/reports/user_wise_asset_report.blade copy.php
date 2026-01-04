@extends('layouts.sammy_new.master') @section('title','User List')
@section('css')
<style type="text/css">

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
  	<li class="active">User Wise Asset Report</li>
</ol>

<div class="row">
	<div class="col-xs-12">
		<form role="form" class="form-validation" method="get">
			<div class="panel panel-bordered" id="panel-search">
				<div class="panel-heading border">
					<h4><strong>User Wise Asset Report</strong></h4>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-3">
							<label class="control-label">Employee</label>
							<select class="form-control chosen" name="employee" id="employee">
								@foreach($employees as $key => $employee)
									<option value="{{$key}}" @if($key == $old->employee) selected @endif>{{$employee}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-3">
							<label class="control-label">Username</label>
							<input type="text" name="username" id="username" class="form-control" value="{{$old['username']}}" placeholder="Username">
						</div>
						<div class="form-group col-md-3">
                            <label class="control-label">Search Keyword</label>
                            <input type="text" name="search_keyword" id="search_keyword" class="form-control" value="{{$old['search_keyword']}}" placeholder="Serial No, Inventory No">
							{{--<div class="form-group" style="margin-top:0px">
								<label class="control-label">Location</label>
								<select name="location" id="location" class="form-control chosen" required="required">
									@foreach($locations as $key=>$location)
										<option value="{{$key}}" @if($key==$old['location']) selected @endif>{{$location}}</option>
									@endforeach
								</select>
							</div>--}}
						</div>
						<div class="form-group col-md-3">
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-3">
							<div class="form-group" style="margin-top:0px">
								<label class="control-label">Location</label>
								<select name="location" id="location" class="form-control chosen" required="required">
									@foreach($locations as $key=>$location)
										<option value="{{$key}}" @if($key==$old['location']) selected @endif>{{$location}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group col-md-3">
							<div class="pull-left" style="margin-top:15px;margin-left: 10px">
								<div class="form-group" style="margin-bottom: 0; margin-top: 15px;">
									<input type="checkbox" name="sub_loc" id="sub_loc" value="1" @if($old['sub_loc'] == 1) checked @endif>
									<label class="control-label">With Sub Location</label>
								</div>
							</div>
						</div>
						<div class="form-group col-md-3">
						</div>
						<div class="form-group col-md-3">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="pull-right" style="margin-top:8px;margin-left:8px">
										<button type="button" class="btn btn-danger btn-pdf">
											<i class="fa fa-download"></i> PDF
										</button>
									</div>

									<div class="pull-right" style="margin-top:8px;margin-left:8px">
										<button type="button" class="btn btn-warning btn-excel">
											<i class="fa fa-download"></i> Excel
										</button>
									</div>
									<div class="pull-right" style="margin-top:8px">
										<button type="submit" class="btn btn-primary btn-search">
											<i class="fa fa-check"></i> search
										</button>
									</div>

								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</form>	
	</div>
</div>


<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-bordered">
      		<div class="panel-body" style="overflow-x:scroll">
      			<table class="table table-bordered">
          			<thead style="background:#ddd">
	                  	<th class="text-center" width="2%">#</th>
	                  	<th class="text-center">User ID</th>
	                  	<th class="text-center" width="15%">First Name</th>
	                  	<th class="text-center">Last Name</th>
						<th class="text-center">Location</th>
	                  	<th class="text-center">Asset Model</th>
	                  	<th class="text-center">Manufacturer</th>
	                  	<th class="text-center">Model</th>
	                  	<th class="text-center">Serial No</th>
	                  	<th class="text-center">Inventory No</th>
	                  	<th class="text-center">Puchased Value</th>
          			</thead>
          			<tbody>
						@if(count($data) > 0)
							<?php $i=1; ?>
							@foreach($data as $item)
								<tr>
									<td class="text-center">{{$i}}</td>
									@if(count($item->transaction) > 0 && $item->transaction[0]->employee)
									<td class="text-center">
										{{$item->transaction[0]->employee->user->username}}
									</td>
									<td class="text-center">
										{{$item->transaction[0]->employee->first_name}}
									</td>
									<td class="text-center">
										{{$item->transaction[0]->employee->last_name}}
									</td>
									@else
										<td class="text-center"> - </td>
										<td class="text-center"> - </td>
										<td class="text-center"> - </td>
									@endif
									<td class="text-center">
										@if(count($item->transaction) > 0 && $item->transaction[0]->location)
											{{$item->transaction[0]->location->name}}
										@else
											-
										@endif
									</td>
									<td class="text-center">
										@if($item->assetmodel!=null)
											{{$item->assetmodel->name}}
										@else
											-
										@endif
									</td>
									<td class="text-center">{{($item->manufacturer)?$item->manufacturer->name:'-'}}</td>
									<td class="text-center">{{$item->model}}</td>
									<td class="text-center">{{$item->asset_no}}</td>
									<td class="text-center">{{$item->inventory_no}}</td>

									<td class="text-left">
										{{CURRENCY}}{{number_format($item->purchased_value,2,'.',',')}}
									</td>
								</tr>
							<?php $i++; ?>
							@endforeach
						@endif
          			</tbody>
          		</table>
				@if(count($data) > 0)
          			<?php echo $data->appends(Input::except('page'))->render()?>
				@endif
                <br>
                <?php echo "Total Row Count : ".$row_count?>
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
		$('.btn-excel').click(function(e){
			e.preventDefault();

        	username = $("#username").val();
        	search_keyword = $("#search_keyword").val();
        	employee = $("#employee").val();
        	locationR = $("#location").val();
        	sub_loc = $("#sub_loc").val();


        	window.location.href = '{{url('reports/user-wise-asset-report/download/excel')}}?employee='+employee+'&username='+username+'&search_keyword='+search_keyword+'&location='+locationR+'&sub_loc='+sub_loc;

		});

		$('.btn-pdf').click(function(e){
			e.preventDefault();

            username = $("#username").val();
            search_keyword = $("#search_keyword").val();
			employee = $("#employee").val();
			locationR = $("#location").val();
			sub_loc = $("#sub_loc").val();

        	window.open('{{url('reports/user-wise-asset-report/download/pdf')}}?employee='+employee+'&username='+username+'&search_keyword='+search_keyword+'&location='+locationR+'&sub_loc='+sub_loc,'_blank');

		});
	});

	function pageReload(){
		window.location.href = window.location.href;
	}
</script>
@stop