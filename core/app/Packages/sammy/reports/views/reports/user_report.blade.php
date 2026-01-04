@extends('layouts.sammy_new.master') @section('title','User List')
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
  	<li>
    	<a href="#">Report Management</a>
  	</li>
  	<li class="active">User Summery List</li>
</ol>
<div ng-app="ngApp" ng-controller="ReportManageController">
	<div class="row">
		<div class="col-xs-12">

			<div class="panel panel-bordered" id="panel-search">
				<div class="panel-heading border">
					<h4><strong>User Summary Report</strong></h4>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-4">
							<label class="control-label">Search Keyword</label>
							<input type="text" name="search_keyword" id="search_keyword" class="form-control" value="{{$old['search_keyword']}}" placeholder="Enter Username, First Name, Last Name, Code">
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Type</label>
							<select name="type" id="type" class="form-control chosen" required="required">
								<option value="0">-ALL-</option>
								@foreach($types as $type)
									<option value="{{$type->id}}" @if($type->id==$old['type']) selected @endif>{{$type->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Status</label>
							<select name="status" id="status" class="form-control chosen" required="required">
								@foreach($status as $key=>$status)
									<option value="{{$key}}">{{$status}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-3">
							<div class="form-group" style="margin-top:8px">
								<label class="control-label">Location</label>
								<select name="location" id="location" class="form-control chosen" required="required">
									@foreach($locations as $key=>$location)
										<option value="{{$key}}" @if($key==$old['location']) selected @endif>{{$location}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group col-md-6">
							<div class="pull-left" style="margin-top:15px;margin-left: 10px">
								<div class="form-group" style="margin-bottom: 0; margin-top: 15px;">
									<input type="checkbox" name="sub_loc" id="sub_loc" value="1" @if($old['sub_loc'] == 1) checked @endif>
									<label class="control-label">With Sub Location</label>
								</div>
							</div>
						</div>
						<div class="form-group col-md-3">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
			
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-bordered">
	      		<div class="panel-body" style="overflow-x:scroll">
	      			<table class="table table-bordered" style="margin-bottom: 0px">
	          			<thead style="background:#ddd">
		                  	<th class="text-center" width="2%">#</th>
		                  	<th class="text-center">User Name</th>
		                  	<th class="text-center" width="15%">First Name</th>
		                  	<th class="text-center">Last Name</th>
		                  	<th class="text-center">User Role</th>
		                  	<th class="text-center">Location</th>
		                  	<th class="text-center">Email</th>
		                  	<th class="text-center" width="15%">Last Login</th>
		                  	<th class="text-center">Created By</th>
		                  	<th class="text-center" width="15%">Created Date</th>
		                  	<th class="text-center">Verified User</th>
		                  	<th class="text-center" width="15%">Verified Date</th>
		                  	<th class="text-center">Varification Status</th>
		                  	<th class="text-center">Status</th>
	          			</thead>
	          			<tbody>
	          				<tr ng-repeat="user in users.data track by $index">
          						<td class="text-center">@{{(users.current_page-1)*users.per_page+$index+1}}</td>
								<td class="text-center">
									<span ng-show="user.username != '' ">@{{user.username}}</span>
									<span ng-show="user.username == '' ">-</span>
								</td>
								
								<td class="text-center">
									<span ng-show="user.employee[0].first_name != '' ">@{{user.employee[0].first_name}}</span>
									<span ng-show="user.employee[0].first_name == '' ">-</span>
								</td>

								<td class="text-center">
									<span ng-show="user.employee[0].last_name != '' ">@{{user.employee[0].last_name}}</span>
									<span ng-show="user.employee[0].last_name == '' ">-</span>
								</td>

								<td class="text-center">
									<span ng-show="user.user_role">@{{user.user_role[0].name}}</span>
									<span ng-show="!user.user_role">-</span>
								</td>
								<td class="text-center">
									<span ng-show="user.employee[0].location">@{{user.employee[0].location.location.name}}</span>
									<span ng-show="!user.employee[0].location">-</span>
								</td>

								<td class="text-center">
									<span ng-show="user.employee[0].email != '' ">@{{user.employee[0].email}}</span>
									<span ng-show="user.employee[0].email == '' ">-</span>
								</td>

								<td class="text-center">
									<span ng-show="user.last_login != ''">@{{user.last_login}}</span>
									<span ng-show="user.last_login == ''">-</span>
								</td>

								<td class="text-center">
									<span ng-show="user.createdBy">@{{user.createdBy.employee[0].first_name}} @{{user.createdBy.employee[0].last_name}}</span>
									<span ng-show="!user.createdBy">-</span>
								</td>

								<td class="text-center">
									<span ng-show="user.created_at">@{{user.created_at}}</span>
									<span ng-show="!user.created_at">-</span>
								</td>

								<td class="text-center">
									<span ng-show="user.verifiedby">@{{user.verifiedby.first_name}} @{{user.verifiedby.last_name}}</span>
									<span ng-show="!user.verifiedby">-</span>
								</td>

								<td class="text-center">
									<span ng-show="user.verified_date">@{{user.verified_date}}</span>
									<span ng-show="!user.verified_date">-</span>
								</td>

								<td>
									<label ng-show="user.varified_status == 0" class="label label-danger"><span>Not Verified</span></label>
									<label ng-show="user.varified_status == 1" class="label label-success"><span>Verified</span></label>
									<label ng-show="user.varified_status == 2" class="label label-danger"><span>Rejected</span></label>
								</td>

								<td>
									<label ng-show="user.status == 1" class="label label-success"><span>Active</span></label>
									<label ng-show="user.status != 1" class="label label-danger"><span>Deactive</span></label>
								</td>
          					</tr>
	          			</tbody>
	          		</table>
	      		</div>
	      		<paging page="users.current_page" page-size="users.per_page" total="users.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(page)"></paging>
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
        	search_keyword = $("#search_keyword").val();
        	status = $("#status").val();
        	type = $("#type").val();
        	sub_loc = ($("#sub_loc:checked").length > 0)?$("#sub_loc:checked").val():0;


        	window.location.href = '{{url('reports/user-summery-report/download/excel')}}?location='+loc+'&search_keyword='+search_keyword+'&status='+status+'&type='+type+'&sub_loc='+sub_loc;

		});

		$('.btn-pdf').click(function(e){
			e.preventDefault();

        	loc = $("#location").val();
        	search_keyword = $("#search_keyword").val();
        	status = $("#status").val();
        	type = $("#type").val();
			sub_loc = ($("#sub_loc:checked").length > 0)?$("#sub_loc:checked").val():0;

        	window.open('{{url('reports/user-summery-report/download/pdf')}}?location='+loc+'&search_keyword='+search_keyword+'&status='+status+'&type='+type+'&sub_loc='+sub_loc,'_blank');

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
    	$scope.users = [];

    	$scope.page = 1;

    	$scope.find = function (page)
	    {
	    	$scope.page = page;

            $.ajax({
	            url: "{{url('reports/user-summery-report-data')}}",
	            type: 'GET',
	            data: {
	            	page: page,
	            	loc : $("#location").val(),
		        	search_keyword : $("#search_keyword").val(),
		        	status : $("#status").val(),
		        	type : $("#type").val(),
					sub_loc : ($("#sub_loc:checked").length > 0)?$("#sub_loc:checked").val():0
	            },
	            success: function (data) {

	            	if(data.data.length>0){
	            		$('.btn-pdf').removeClass('disabled');
                		$('.btn-excel').removeClass('disabled');
                	}else{
                		$('.btn-pdf').addClass('disabled');
                		$('.btn-excel').addClass('disabled');
                	}

	                $scope.users = data;
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