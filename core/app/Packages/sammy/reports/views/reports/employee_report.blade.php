@extends('layouts.sammy_new.master') @section('title','Employee List')
@section('css')
<style type="text/css">
	.pagination{
		padding-left: 15px;
	}
</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li class="active">Employee List</li>
</ol>
<div ng-app="ngApp" ng-controller="ReportManageController">
	<div class="row">
		<div class="col-xs-12">
			
			<div class="panel panel-bordered" id="panel-search">
				<div class="panel-heading border">
					<h4><strong>Employee Summary Report</strong></h4>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-sm-4 col-md-3 col-lg-3 col-xl-3">
							<label class="control-label">Search</label>
							<input type="text" name="keyword" id="keyword" placeholder="Enter Keyword" class="form-control" value="{{$old['keyword']}}">
						</div>

						<div class="form-group col-sm-2 col-md-2 col-lg-2 col-xl-2">
							<label class="control-label">Employee Code</label>
							<input type="text" name="code" id="code" placeholder="Enter Employee Code" class="form-control" value="{{$old['code']}}">
						</div>

						<div class="form-group col-sm-4 col-md-3 col-lg-3 col-xl-3">
							<label class="control-label">Name</label>
							<input type="text" name="name" id="name" placeholder="Enter Employee Name" class="form-control" value="{{$old['name']}}">
						</div>

						<div class="form-group col-sm-2 col-md-2 col-lg-2 col-xl-2">
							<label class="control-label">Role</label>
							<select name="type" id="type" class="form-control chosen" required="required">
								<option value="0">-ALL-</option>
								@foreach($types as $type)
									<option value="{{$type->id}}" @if($type->id==$old['type']) selected @endif>{{$type->name}}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group col-sm-2 col-md-2 col-lg-2 col-xl-2">
							<label class="control-label">Status</label>
							<select name="status" id="status" class="form-control chosen" required="required">
								@foreach($status as $key=>$status)
									<option value="{{$key}}">{{$status}}</option>
								@endforeach
							</select>
						</div>
					</div>
					
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="pull-left" style="margin-top:8px">
								<select name="location" id="location" class="form-control chosen" required="required">
									@foreach($locations as $key=>$location)
										<option value="{{$key}}" @if($key==$old['location']) selected @endif>{{$location}}</option>
									@endforeach
								</select>
							</div>

							<div class="pull-left" style="margin-top:15px;margin-left: 10px">
								<div class="form-group">
									<input type="checkbox" name="sub_loc" id="sub_loc" value="1" @if($old['sub_loc'] == 1) checked @endif>
			      					<label class="control-label">With Sub Location</label>
			            		</div>
							</div>

							<div class="pull-right" style="margin-top:8px;margin-left:8px">
								<button type="button" class="btn btn-danger btn-pdf disabled">
									<i class="fa fa-download"></i> PDF
								</button>
							</div>
							
							<div class="pull-right" style="margin-top:8px;margin-left:8px">
								<button type="button" class="btn btn-warning btn-excel disabled">
									<i class="fa fa-download"></i> Excel
								</button>
							</div>
							<div class="pull-right" style="margin-top:8px">
								<button type="button" class="btn btn-primary btn-search" ng-click="find(1)">
									<i class="fa fa-check"></i> search
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-bordered">
	      		<div class="panel-body" style="overflow-x:scroll">
	      			<table class="table table-bordered mb-0">
	          			<thead style="background:#ddd">
		                  	<th class="text-center" width="2%">#</th>
		                  	<th class="text-center">Type</th>
		                  	<th class="text-center">Code</th>
		                  	<th class="text-center">Name</th>
		                  	<th class="text-center">NIC</th>
		                  	<th class="text-center">Address</th>
		                  	<th class="text-center">Mobile</th>
		                  	<th class="text-center">Email</th>
		                  	<th class="text-center">Location</th>
		                  	<th class="text-center">Superior</th>
		                  	<th class="text-center">Status</th>
		                  	<th class="text-center">Created By</th>
		                  	<th class="text-center" width="15%">Created Date</th>
		                  	<th class="text-center">Verified User</th>
		                  	<th class="text-center" width="15%">Verified Date</th>
	          			</thead>
	          			<tbody>
		              		<tr ng-repeat="employee in employees.data track by $index">
		              			<td class="text-center">@{{(employees.current_page-1)*employees.per_page+$index+1}}</td>
		              			<td>@{{employee.type.name!=null?employee.type.name:'-'}}</td>
		              			<td>@{{employee.code}}</td>
		              			<td>
		              				@{{employee.first_name}} @{{employee.last_name}} <br>
		              				<span ng-show="employee.branch_user==1" class="badge" style="font-size: 10px;background-color: navy">Branch User</span>
		              			</td>
		              			<td>@{{employee.nic}}</td>
		              			<td>@{{employee.address}}</td>
		              			<td>@{{employee.mobile!=null?employee.mobile:'-'}}</td>
		              			<td>@{{employee.email!=null?employee.email:'-'}}</td>
		              			<td>
		              				<span ng-show="employee.location!=null">@{{employee.location.location.name}}</span>
		              				<span ng-show="employee.location==null">-</span>
		              			</td>
		              			<td>@{{(employee.parentEmployee)?employee.parentEmployee.full_name:'-'}}</td>
		              			<td>
		              				<span ng-show="employee.status==1" class="label label-success">Activated</span>
		              				<span ng-show="employee.status==2" class="label label-warning">Rejected</span>
		              				<span ng-show="employee.status==0" class="label label-danger">Deactivated</span>
		              			</td>

		              			<td class="text-center">
									<span ng-show="employee.createdBy && employee.createdBy.employee.length > 0">@{{employee.createdBy.employee[0].first_name}} @{{employee.createdBy.employee[0].last_name}}</span>
									<span ng-show="!employee.createdBy || employee.createdBy.employee.length < 0">-</span>
								</td>

								<td class="text-center">
									<span ng-show="employee.created_at">@{{employee.created_at}}</span>
									<span ng-show="!employee.createdBy || employee.createdBy.employee.length < 0">-</span>
								</td>

								<td class="text-center">
									<span ng-show="employee.verifiedby">@{{employee.verifiedby.first_name}} @{{employee.verifiedby.last_name}}</span>
									<span ng-show="!employee.verifiedby">-</span>
								</td>

								<td class="text-center">
									<span ng-show="employee.verified_date">@{{employee.verified_date}}</span>
									<span ng-show="!employee.verified_date">-</span>
								</td>
		              		</tr>
		              	</tbody>
	          		</table>
	      		</div>
	      		<paging page="employees.current_page" page-size="employees.per_page" total="employees.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(page)"></paging>
	      	</div>	
		</div>
	</div>
</div>
@stop
@section('js')

<script src="{{asset('/assets/dist/angular/angular/angular.min.js')}}"></script>
<script src="{{asset('assets/dist/moment/moment.js')}}"></script>
<script src="{{asset('assets/dist/angular-moment/angular-moment.min.js')}}"></script>
<script src="{{asset('/assets/dist/ng-multiselect/dualmultiselect.js')}}"></script>
<script src="{{asset('assets/dist/ng-image/angular.img-fallback.js')}}"></script>
<script src="{{asset('assets/dist/angular/angular-bootstrap/ui-bootstrap-0.14.3.min.js')}}"></script>
<script src="{{asset('assets/dist/angular/angular-bootstrap/ui-bootstrap-tpls-0.14.3.min.js')}}"></script>
<script src="{{asset('assets/dist/angular/angular/angular-sanitize.min.js')}}"></script>
<script src="{{asset('assets/dist/ng-pagination/dist/paging.js')}}"></script>

<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript">

	var id = 0;

	$(document).ready(function(){
		
		$('.btn-excel').click(function(e){
			e.preventDefault();

        	loc = $("#location").val();
			sub_loc = ($("#sub_loc:checked").length > 0)?$("#sub_loc:checked").val():0;
        	code = $("#code").val();
        	status = $("#status").val();
        	name = $("#name").val();
        	keyword = $("#keyword").val();
        	type = $("#type").val();


        	window.location.href = '{{url('reports/employee-summery-report/download/excel')}}?location='+loc+'&sub_loc='+sub_loc+'&code='+code+'&status='+status+'&name='+name+'&keyword='+keyword+'&type='+type;

		});

		$('.btn-pdf').click(function(e){
			e.preventDefault();

        	loc = $("#location").val();
			sub_loc = ($("#sub_loc:checked").length > 0)?$("#sub_loc:checked").val():0;
        	code = $("#code").val();
        	status = $("#status").val();
        	name = $("#name").val();
        	keyword = $("#keyword").val();
        	type = $("#type").val();

        	window.open('{{url('reports/employee-summery-report/download/pdf')}}?location='+loc+'&sub_loc='+sub_loc+'&code='+code+'&status='+status+'&name='+name+'&keyword='+keyword+'&type='+type,'_blank');

		});
	});

	function pageReload(){
		window.location.href = window.location.href;
	}

	var app = angular.module("ngApp",['angularMoment','dualmultiselect','angularImgFallback','ui.bootstrap','ngSanitize','bw.paging']);

    app.config(['$tooltipProvider', function ($tooltipProvider) {
        $tooltipProvider.options({
            appendToBody: true, // 
            appendToBody: true, // 
            placement:'bottom' // Set Default Placement
        });
    }]);

    //controller
    app.controller("ReportManageController", function($scope)
    {
    	$scope.employees = [];

    	$scope.page = 1;

    	$scope.find = function (page)
	    {
	    	$scope.page = page;

            $.ajax({
	            url: "{{url('reports/get-employee-summery-data')}}",
	            type: 'GET',
	            data: {
	            	page: page,
	            	location : $('#location').val(),
					inventory_no : $('#inv_no').val(),
					ser_no : $('#ser_no').val(),
					status : $('#status').val(),
					model : $('#model').val()
	            },
	            success: function (data) {

	            	if(data.data.length>0){
	            		$('.btn-pdf').removeClass('disabled');
                		$('.btn-excel').removeClass('disabled');
                	}else{
                		$('.btn-pdf').addClass('disabled');
                		$('.btn-excel').addClass('disabled');
                	}

	                $scope.employees = data;
	                $scope.$apply();

	            },
	            error:function(data) {
	              $('.dialog-loader').hide();
	            }
	        });
	    }
    });

</script>
@stop