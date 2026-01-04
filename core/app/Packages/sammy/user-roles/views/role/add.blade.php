@extends('layouts.sammy_new.master') @section('title','Add Role')
@section('css')
	<style type="text/css">

		.panel.panel-bordered {
			border: 1px solid #ccc;
		}

		.btn-primary {
			color: white;
			background-color:#CC1A6C;
			border-color: #CC1A6C;
		}

		.chosen-container {
			font-family: 'FontAwesome', 'Open Sans', sans-serif;
		}
		b, strong {
			font-weight: bold;
		}
		.repeat:hover {
			background-color:#EFEFEF;
		}
		#scrollArea {
			height: 200px;
			overflow: auto;
		}
		.switch.switch-sm{
			width: 30px;
			height: 16px;
		}
		.switch :checked + span {

			border-color: #689A07;
			-webkit-box-shadow: #689A07 0px 0px 0px 21px inset;
			-moz-box-shadow: #2ecc71 0px 0px 0px 21px inset;
			box-shadow: #689A07 0px 0px 0px 21px inset;
			-webkit-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
			-moz-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
			-o-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
			transition: border 300ms, box-shadow 300ms, background-color 1.2s;
			background-color: #689A07;

		}

		.bootstrap-tagsinput.error{
			border-color: #d96557;
		}
	</style>
@stop
@section('content')

	<ol class="breadcrumb">
		<li>
			<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
		</li>
		<li>
			<a href="{{{url('user/list')}}}">User</a>
		</li>
		<li>
			<a href="{{{url('role/list')}}}">Role</a>
		</li>
		<li class="active">Add</li>
	</ol>

	<section ng-app="permissionApp" ng-controller="permissionController">
		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-bordered">
					<div class="panel-heading border">
						<strong>Add Role</strong>
					</div>
					<div class="panel-body">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<label class=" control-label required" >Role Name</label>
								<input class="form-control" type="text" name="roleName" placeholder="Role Name" id="roleName" ng-model="roleName"/>
								<label class="error" for="roleNameError" id="roleNameError"></label>
								</div>
							</div>

							<label class="control-label required">Groups</label>
							<div class="row">                            
	                            <div class="col-sm-5">
	                                <input class="form-control" type="text" name="searchText" placeholder="Search.." ng-model="searchText">
	                            </div>
	                            <label id="label-error" class="error col-sm-offset-1" for="label" ng-bind = "permissionsError">
	                            </label> 
	                        </div>


	                        <div class="row" style="margin-top:10px;">
	                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
	                            	<div class="well" style="padding-top:0px;padding-left:0px;padding-right:0px;padding-bottom:0px">
		                                <div id="scrollArea" ng-controller="ScrollController">
		                                    <ul class="example-animate-container list-group">
			                                        <li style="height:30px;" class="animate-repeat list-group-item repeat" 
			                                        ng-repeat="listItem in permissionList | filter:searchText as results" ng-click="push(listItem,permissionList,selectedPermissionList)"
			                                        data-toggle="tooltip" 
			                                        data-placement="top" 
			                                        title="@{{listItem.name}}">
		                                       	 	@{{listItem.name | cut:true:50:' ...'}}
		                                        </li>
		                                        <li  style="list-style: none" ng-if="results.length===0"><span class="label label-danger col-sm-12">No results found...</span></li>
		                                    </ul>
		                                </div>
		                            </div>
	                            </div>
	                            
	                            <div class="col-sm-2" style="position:relative;display:block;">
	                                <div style="margin-top:60%;" class="text-center">
	                                   <h5>
	                                   	<i class="fa fa-exchange fa-2x" aria-hidden="true"></i>
									   </h5>
	                                </div>
	                            </div>

	                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
		                            	<div class="well" style="padding-top:0px;padding-left:0px;padding-right:0px;padding-bottom:0px">
		                                <div id="scrollArea" ng-controller="ScrollController">
		                                    <ul class="list-group">
		                                        <li style="height:30px;" class="list-group-item repeat" 
			                                        ng-repeat="selectedItem in selectedPermissionList" ng-click="push(selectedItem,selectedPermissionList,permissionList) | orderBy : selectedItem"
			                                        data-toggle="tooltip" 
			                                        data-placement="top" 
			                                        title="@{{selectedItem.name}}">
			                                        @{{selectedItem.name | cut:true:50:' ...'}}
		                                        </li>
		                                        <li style="list-style: none" ng-if="selectedPermissionList.length===0"><span class="label label-info col-sm-12">Add permissions here..</span></li>
		                                    </ul>
		                                </div>
		                            </div>
	                            </div>
	                        </div>

							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<button class="pull-right btn btn-primary" class="btn btn-primary"
									 ng-click="savePermissionGroup()"><i class="fa fa-floppy-o"></i> Save</button>
								</div>
							</div>


						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

@stop
@section('js')
	<script src="{{asset('/assets/angular/vendor/angular/angular.min.js')}}"></script>
	<script type="text/javascript">

		$(document).ready(function(){
			
		});

	    //initialize angular app
	    var app = angular.module("permissionApp",[]);

	   	app.filter('cut', function () {
	        return function (value, wordwise, max, tail) {
	            if (!value) return '';

	            max = parseInt(max, 10);
	            if (!max) return value;
	            if (value.length <= max) return value;

	            value = value.substr(0, max);
	            if (wordwise) {
	                var lastspace = value.lastIndexOf(' ');
	                if (lastspace !== -1) {
	                  //Also remove . and , so its gives a cleaner result.
	                  if (value.charAt(lastspace-1) === '.' || value.charAt(lastspace-1) === ',') {
	                    lastspace = lastspace - 1;
	                  }
	                  value = value.substr(0, lastspace);
	                }
	            }

	            return value + (tail || ' …');
	        };
	    });

	    //controller
	    app.controller("permissionController", function($scope,$http){

	        $scope.groupNameError = "";
	        $scope.persmissionsError = "";
	        //permission list
	        $scope.permissionList = [];
	        //user selected permission list
	        $scope.selectedPermissionList = [];

	        $(".panel").addClass('panel-refreshing');

	        
	        //save permissoin group
	        $scope.savePermissionGroup = function(){
	        	$(".panel").addClass('panel-refreshing');
	            $.ajax({
	                url: '{{url('user/role/add')}}',
	                type: 'POST',
	                data: {roleName:$scope.roleName,permissions:$scope.selectedPermissionList},
	                success: function(Response){
	                	 $(".panel").removeClass('panel-refreshing');
	                    //window.location.reload();
	                    swal("Success!", "Permission Group Added Successfully!", "success");
	                },
	                error: function(Response){            
	                }
	            });
	        }
	        //push item to list  and remove from other list
	        $scope.push = function (item,from,to){
	            var index = getIndex(from,item);
	            insertLast(item,to);
	            deleteItem(index,from);
	            //$scope.permissionList.splice(item,1);
	        }
	        
	        //add item to end of the list
	        function insertLast (item,to){
	            to.push(item);
	        }
	        //delete item from permission list
	        function deleteItem (index,from){
	            from.splice(index,1);
	        }
	        //get index of list
	        function getIndex(array,item){
	            return array.indexOf(item);
	        }
	       

	        $.ajax({
	            url: '{{url('user/role/groups/list')}}',
	            type: 'get',
	            success: function(reponse){
	            	 $(".panel").removeClass('panel-refreshing');
	                $scope.permissionList  = reponse.data;
	                $scope.$digest();
	            },
	            error: function(Response){               
	            }
	        });	
	    });//end controller

	    //scroll controller 
	    app.controller('ScrollController', ['$scope', '$location', '$anchorScroll',
	        function($scope, $location, $anchorScroll){}
	    ]);
		
	</script>
@stop
