@extends('layouts.sammy_new.master') @section('title','Software List')
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
  	<li class="active">Software Summery List</li>
</ol>
<div ng-app="ngApp" ng-controller="ReportManageController">
	<div class="row">
		<div class="col-xs-12">

			<div class="panel panel-bordered" id="panel-search">
				<div class="panel-heading border">
					<h4><strong>Software Summary Report</strong></h4>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-4">
							<label class="control-label">License</label>
							<select name="license" id="license" class="form-control chosen" required="required">
								<option value="0">---- Select License -----</option>
								@foreach($licenses as $license)
									<option value="{{$license->id}}" @if($license->id==$old['license_id']) selected @endif>{{$license->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Location</label>
							<select name="location" id="location" class="form-control chosen" required="required">
								@foreach($locations as $key=>$location)
									<option value="{{$key}}" @if($key==$old['location']) selected @endif>{{$location}}</option>
								@endforeach
							</select>
							<label class="control-label">With Sub Location</label>
							<input type="checkbox" name="sub_loc" id="sub_loc" @if($old['sub_loc']) checked @endif style="margin-top: 5px">
						</div>

						<div class="form-group col-md-4">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="pull-right" style="margin-top:25px;margin-left:8px">
										<button type="button" class="btn btn-danger btn-pdf disabled">
											<i class="fa fa-download"></i> PDF
										</button>
									</div>
									
									<div class="pull-right" style="margin-top:25px;margin-left:8px">
										<button type="button" class="btn btn-warning btn-excel disabled">
											<i class="fa fa-download"></i> Excel
										</button>
									</div>
									<div class="pull-right" style="margin-top:25px">
										<button type="submit" class="btn btn-primary btn-search" ng-click="find(1)">
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
				<div class="panel-header" style="text-align: center">
					<h4 style="padding: 10px">Software Asset Usage Report</h4>
				</div>

				<div class="panel-body">
					<div class="row">
						<div class="col-sm-6">
							
							<table class="table table-bordered" style="width: 60%">
								<tr>
									<td style="font-weight: bolder">No of License</td>
									<td style="font-weight: bolder">@{{software_details.max_users}}</td>
								</tr>
								<tr>
									<td style="font-weight: bolder">Usage of License</td>
									<td style="font-weight: bolder">@{{software_details.used_count}}</td>
								</tr>
								<tr>
									<td style="font-weight: bolder">Remaining License</td>
									<td style="font-weight: bolder">@{{software_details.max_users - software_details.used_count}}</td>
								</tr>
							</table>						
						</div>
						<div class="col-sm-6">
							<table class="table table-bordered pull-right" style="width: 60%">
								<tr>
									<td style="font-weight: bolder"><span>Supplier</span></td>
									<td style="font-weight: bolder"><span>@{{software_details.supplier.name}}</span></td>
								</tr>
								<tr>
									<td style="font-weight: bolder"><span>License Start Date</span></td>
									<td style="font-weight: bolder"><span>@{{software_details.license_from}}</span></td>
								</tr>
								<tr>
									<td style="font-weight: bolder"><span>License End Date</span></td>
									<td style="font-weight: bolder"><span>@{{software_details.license_to}}</span></td>
								</tr>
							</table>
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
		                  	<th class="text-center">Parent Location</th>
		                  	<th class="text-center">Location</th>
		                  	<th class="text-center">Inventory No</th>
		                  	<th class="text-center" width="15%">Serial No</th>
		                  	<th class="text-center">Manufacture</th>
		                  	<th class="text-center">Model</th>
		                  	<th class="text-center">IP Address</th>
		                  	<th class="text-center">Reference No</th>
		                  	<th class="text-center">Install Date</th>
		                  	<th class="text-center">Expiry Date</th>
	          			</thead>
	          			<tbody>
	          				<tr ng-repeat="software in softwares.data track by $index">
          						<td class="text-center">@{{(softwares.current_page-1)*softwares.per_page+$index+1}}</td>
								<td class="text-center">
									<label ng-show="software.asset.asset_transaction.location.parent_location">
										@{{software.asset.asset_transaction.location.parent_location.name}}
									</label>
									<label ng-show="!software.asset.asset_transaction.location.parent_location">
										-
									</label>
								</td>
								<td class="text-center">@{{software.asset.asset_transaction.location.name}}</td>
								<td class="text-center">@{{software.asset.inventory_no}}</td>
								<td class="text-center">@{{software.asset.asset_no}}</td>
								<td class="text-center">@{{software.asset.inventory_no}}</td>
								<td class="text-center">@{{software.asset.manufacturer.name}}</td>
								<td class="text-center">@{{software.asset.model}}</td>
								<td class="text-center">@{{software.asset.note}}</td>
								<td class="text-center">@{{software.asset.reference_no}}</td>
								<td class="text-center">@{{software.created_at}}</td>
								<td class="text-center">@{{software.license_no}}</td>
          					</tr>
	          			</tbody>
	          		</table>
	      		</div>
	      		<paging page="softwares.current_page" page-size="softwares.per_page" total="softwares.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(page)"></paging>
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
        	license = $("#license").val();
        	sub_loc = $("#sub_loc").val();

        	window.location.href = '{{url('reports/software-summery-report/download/excel')}}?location='+loc+'&license='+license+'&sub_loc='+sub_loc;

		});

		$('.btn-pdf').click(function(e){
			e.preventDefault();

        	loc = $("#location").val();
        	license = $("#license").val();
        	sub_loc = $("#sub_loc").val();

        	window.open('{{url('reports/software-summery-report/download/pdf')}}?location='+loc+'&license='+license+'&sub_loc='+sub_loc,'_blank');

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
    	$scope.softwares = [];
    	$scope.software_details = {};

    	$scope.page = 1;

    	$scope.find = function (page)
	    {
	    	$scope.page = page;

            $.ajax({
	            url: "{{url('reports/software-summery-report-data')}}",
	            type: 'GET',
	            data: {
	            	page: page,
	            	loc: $("#location").val(),
		        	license: $("#license").val(),
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

	                $scope.softwares = data;
	                $scope.$apply();
	            },
	            error:function(data) {
	              $('.dialog-loader').hide();
	            }
	        });

	        if($("#license").val()>0)
	        {
	        	$.ajax({
		            url: "{{url('reports/software-detail-data')}}",
		            type: 'GET',
		            data: {
		            	license: $("#license").val()
		            },
		            success: function (data) {

		            	$scope.software_details = data;
		                $scope.$apply();
		            },
		            error:function(data) {
		              $('.dialog-loader').hide();
		            }
		        });
	        }else{
	        	
	        }

	    }
    });

</script>
@stop