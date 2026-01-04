@extends('layouts.sammy_new.master') @section('title','Edit Role')
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
            <a href="{{{url('user/role/list')}}}">Role</a>
		</li>
		<li class="active">Edit</li>
	</ol>

	<div class="row" ng-app="permissionApp" ng-controller="permissionController">
		<div class="col-xs-12">
			<div class="panel panel-bordered">

				<div class="panel-heading border">
					<strong>Edit Role</strong>
				</div>

				<div class="panel-body">
					<div class="form-group" style="margin-bottom:0">
						<label class="control-label" >Role Name</label>
						<input class="form-control" type="text" name="roleName" id="roleName" placeholder="Role Name" 
                         value="{{$role->name}}" />
						<label class="error" for="roleNameError" id="roleNameError"></label>
					</div>

					<div class="form-group" style="margin-bottom:0">
                        <label class="control-label">Search Groups   <br>	<i style="font-size:9px">*note - search group to automaticly filter the groups</i></label>
                        <input class="form-control" type="text" name="searchText" placeholder="Search.." ng-model="searchText">
                        <label id="label-error" class="error col-sm-offset-1" for="label" ng-bind = "permissionsError">
                        </label> <br>
                      
                    </div><br>

                    <div class="form-group">
                        <div class="well col-sm-5" style="padding-top:0px;padding-left:0px;padding-right:0px;padding-bottom:0px">
                            <div id="scrollArea" ng-controller="ScrollController">
                                <ul class="example-animate-container list-group">
                                    <li style="height:30px;" class="animate-repeat list-group-item repeat" 
                                    ng-repeat="listItem in permissionList | filter:searchText as results" ng-click="push(listItem,permissionList,selectedPermissionList)">@{{listItem.name}}</li>
                                    <li  style="list-style: none" ng-if="results.length===0"><span class="label label-danger col-sm-12">No results found...</span></li>
                                </ul>
                            </div>
                        </div>
                            
                        <div class="col-sm-2" style="position:relative;display:block;">
                            
                        </div>

                        <div class="well col-sm-5" style="padding-top:0px;padding-left:0px;padding-right:0px;padding-bottom:0px">
                                <div id="scrollArea" ng-controller="ScrollController">
                                    <ul class="list-group">
                                        <li style="height:30px;" class="list-group-item repeat" 
                                        ng-repeat="selectedItem in selectedPermissionList" ng-click="push(selectedItem,selectedPermissionList,permissionList) | orderBy : selectedItem">@{{selectedItem.name | cut:true:50:' ...'}}</li>
                                        <li style="list-style: none" ng-if="selectedPermissionList.length===0"><span class="label label-info col-sm-12">	.</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

						<div class="row">
							<div class="col-sm-12">
								<button class="pull-right btn btn-primary" class="btn btn-primary" id="save" ng-click="savePermissionGroup()"><i class="fa fa-floppy-o"></i> Save</button>
							</div>
						</div>

				</div>
			</div>
		</div>
	</div>

@stop
@section('js')
	<script src="{{asset('/assets/angular/vendor/angular/angular.min.js')}}"></script>
	<script type="text/javascript">
	
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

    //scope variables

    $scope.groupNameError = "";
    $scope.persmissionsError = "";
    //permission list
    $scope.permissionList = [];
    //user selected permission list
    $scope.selectedPermissionList = [];

    $(".panel").addClass('panel-refreshing');

    $.ajax({
        url: '{{url('user/role/json/groupsEditJsonList')}}',
        type: 'post',
        data: {id:{{$role->id}}},
        success: function(response){
            $(".panel").removeClass('panel-refreshing');
            $scope.permissionList = response.data;
            $scope.$digest();

        },
        error: function(Response){              
        }
    }); 

    $.ajax({
        url: '{{url('user/role/json/getSelectedPer')}}',
        type: 'post',
        data: {id:{{$role->id}}},
        success: function(response){
            $(".panel").removeClass('panel-refreshing');
            $scope.selectedPermissionList = response.data;
            $scope.$digest();
        },
        error: function(Response){              
        }
    });

    //functions

    //save permissoin group
    $scope.savePermissionGroup = function(){
        $(".panel").addClass('panel-refreshing');
        $.ajax({
            url: '{{url('user/role/edit')}}/{{$role->id}}',
            type: 'POST',
            data: {roleName:$('#roleName').val(),permissions:$scope.selectedPermissionList},
            success: function(Response){
                $(".panel").removeClass('panel-refreshing');
                window.location.reload();
                $scope.$digest();
                swal("success!", "Edit Successfully!", "success");
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
    


    
});//end controller

//scroll controller 
app.controller('ScrollController', ['$scope', '$location', '$anchorScroll',
    function($scope, $location, $anchorScroll){}
]);
	</script>
@stop
