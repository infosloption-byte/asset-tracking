@extends('layouts.sammy_new.master') @section('title','Asset List')
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
  	<li class="active">Assets List</li>
</ol>
<div ng-app="ngApp" ng-controller="ReportManageController">
	
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-bordered" id="panel-search">
				<div class="panel-heading border">
					<h4><strong>Depreciation Report</strong></h4>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-4">
							<label class="control-label">Asset Location</label>
							<select name="location" id="location" class="form-control chosen" required="required">
								<option value="0">-ALL-</option>
								@foreach($locations as $location)
									<option value="{{$location->id}}" @if($location->id==$old['location']) selected @endif>{{$location->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Inventory NO</label>
							<input type="text" name="inv_no" id="inv_no" class="form-control" value="{{$old['inv_no']}}">
						</div>

						<div class="form-group col-md-4">
							<label class="control-label">Serial NO</label>
							<input type="text" name="ser_no" id="ser_no" class="form-control" value="{{$old['ser_no']}}">
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-4">
							<label class="control-label">Asset Status</label>
							<select name="status" id="status" class="form-control chosen" required="required">
								<option value="0">-ALL-</option>
								@foreach($status as $stat)
									<option value="{{$stat->id}}" @if($stat->id==$old['status']) selected @endif>{{$stat->name}}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group col-md-4">
							<label class="control-label">Asset Model</label>
							<select name="model" id="model" class="form-control chosen" required="required">
								<option value="0">-ALL-</option>
								@foreach($asset_models as $asset_model)
									<option value="{{$asset_model->id}}" @if($asset_model->id==$old['model']) selected @endif>{{$asset_model->name}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="pull-right" style="margin-left:8px">
								<button type="button" class="btn btn-danger btn-pdf disabled" ng-click="loadPdf()">
									<i class="fa fa-download"></i> PDF
								</button>
							</div>

							<div class="pull-right" style="margin-left:8px">
								<button type="button" class="btn btn-warning btn-excel disabled">
									<i class="fa fa-download"></i> Excel
								</button>
							</div>
							<div class="pull-right" style="margin-left:8px">
								<button type="button" class="btn btn-primary" ng-click="find(1)">
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
		<div class="col-xs-12">
			<div class="panel panel-bordered">
	          	<div class="panel-body">
					<table class="table table-bordered" style="width:100%">
						<thead style="background:#ddd">
							<tr>
								<th width="5%">#</th>
								<th >Asset SerialNo</th>
								<th >Asset InvNo</th>
								<th >Asset Model</th>
								<th >Asset Location</th>
								<th >Purchased Value</th>
								<th >Warranty</th>
								<th width="10%">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="asset in asset_data.data track by $index">
								<td>@{{$index+1}}</td>
								<td>
									<a href="{{url('asset/view/')}}/@{{asset.id}}" style="text-decoration: underline;color:blue">#@{{asset.asset_no}}</a> <br>
										
									<span ng-show="asset.transaction.length>0 && asset.transaction[0].status.id==1" class="badge" style="font-size: 10px;background-color: #dda30c">@{{asset.transaction[0].status.name}}</span>
								
									<span ng-show="asset.transaction.length>0 && asset.transaction[0].status.id==6" class="badge" style="font-size: 10px;background-color: #dd1144">@{{asset.transaction[0].status.name}}</span>
								
									<span ng-show="asset.transaction.length>0 && asset.transaction[0].status.id==5" class="badge" style="font-size: 10px;background-color: #74dd00">@{{asset.transaction[0].status.name}}</span>
								
									<span ng-show="asset.transaction.length>0 && asset.transaction[0].status.id==2" class="badge" style="font-size: 10px;background-color: #3e3aff">@{{asset.transaction[0].status.name}}</span>
								</td>
								<td>
									#@{{asset.inventory_no}}
								</td>
								<td>
									@{{asset.assetmodel.name}}
								</td>
								<td>
									<span ng-show="asset.transaction.length>0">@{{asset.transaction[0].location.name}}</span>
								</td>
								<td>{{CURRENCY}} @{{asset.purchased_value | number:2}}</td>
								<td>@{{asset.warranty_period}} months</td>
								<td>
									@if(Sentinel::hasAnyAccess(['report.depreciation', 'admin']))
										<a href="{{url('reports/depreciation/')}}/@{{asset.id}}" class="btn  btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="View Item">depreciation</a>
									@else
										<a href="#" class="disabled btn-actions" data-toggle="tooltip" data-placement="top" title="View Disabled">depreciation</a>
									@endif
								</td>
		                	</tr>
		            	</tbody>
		            </table>
		        </div>
		        <paging page="asset_data.current_page" page-size="asset_data.per_page" total="asset_data.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(page)"></paging>
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

	$('.btn-excel').click(function(e){
		e.preventDefault();

    	location = $('#location').val();
		inventory_no = $('#inv_no').val();
		ser_no = $('#ser_no').val();
		status = $('#status').val();
		model = $('#model').val();

    	window.location.href = '{{url('reports/depreciation/asset/download/excel')}}?location='+location+'&inventory_no='+inventory_no+'&ser_no='+ser_no+'&status='+status+'&model='+model;

	});

	$('.btn-pdf').click(function(e){
		// console.log('djkfnjskf');
		// e.preventDefault();

		// location = $('#location').val();
		// inventory_no = $('#inv_no').val();
		// ser_no = $('#ser_no').val();
		// status = $('#status').val();
		// model = $('#model').val();

		// window.location.href = '{{url('reports/depreciation/asset/download/excel')}}?location='+location+'&inventory_no='+inventory_no+'&ser_no='+ser_no+'&status='+status+'&model='+model;

		// window.open('{{url("reports/depreciation/asset/download/pdf")}}?location='+location+'&inventory_no='+inventory_no+'&ser_no='+ser_no+'&status='+status+'&model='+model,'_blank');

  //   	location = $('#location').val();
		// inventory_no = $('#inv_no').val();
		// ser_no = $('#ser_no').val();
		// status = $('#status').val();
		// model = $('#model').val();

  //   	window.open('{{url('reports/depreciation/asset/download/pdf')}}?location='+location+'&inventory_no='+inventory_no+'&ser_no='+ser_no+'&status='+status+'&model='+model,'_blank');

	});

	//initialize angular app
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
    	$scope.asset_data = [];

    	$scope.page = 1;

    	$scope.find = function (page)
	    {
	    	$scope.page = page;

            $.ajax({
	            url: "{{url('reports/depreciation/asset/json')}}",
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

	                $scope.asset_data = data;
	                $scope.$apply();
	            },
	            error:function(data) {
	              $('.dialog-loader').hide();
	            }
	        });
	    }

	    $scope.loadPdf = function()
	    {
	    	loc = $('#location').val();
			inventory_no = $('#inv_no').val();
			ser_no = $('#ser_no').val();
			status = $('#status').val();
			model = $('#model').val();

			console.log('{{url('reports/depreciation/asset/download/pdf')}}?loc='+loc+'&inventory_no='+inventory_no+'&ser_no='+ser_no+'&status='+status+'&model='+model);

			// window.location.href = '{{url('reports/depreciation/asset/download/pdf')}}?loc='+location+'&inventory_no='+inventory_no+'&ser_no='+ser_no+'&status='+status+'&model='+model;

			// window.open('{{url('reports/depreciation/asset/download/pdf')}}?location='+location+'&inventory_no='+inventory_no+'&ser_no='+ser_no+'&status='+status+'&model='+model,'_blank');

			window.open('{{url('reports/depreciation/asset/download/pdf')}}?loc='+loc+'&inventory_no='+inventory_no+'&ser_no='+ser_no+'&status='+status+'&model='+model,'_blank');
	    }

    });//end controller	
</script>
@stop
