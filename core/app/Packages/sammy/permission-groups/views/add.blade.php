@extends('layouts.sammy_new.master') @section('title','Add Permission Group')
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
    </style>
@stop
@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
        </li>
        <li>
            <a href="javascript:;">Permission</a>
        </li>
        <li>
            <a href="javascript:;">Groups</a>
        </li>
        <li class="active">Add</li>
    </ol>

    <div class="row" ng-app="permissionApp" ng-controller="permissionController">
        <div class="col-xs-12">
            <div class="panel panel-bordered">
                <div class="panel-heading border">
                    <strong>Add Group</strong>
                </div>
                <div class="panel-body">
                    <form role="form" name="form" class="form-horizontal form-validation" method="post">
                        {!!Form::token()!!}<br>

                        <div class="form-group" >
                            <label class="col-sm-3 control-label required" style="padding-right:15px;" required>Group Name</label>
                            <div class="col-sm-7" style="padding-left:3px;padding-right:0px;">
                                <input name="groupName" type="text" class="form-control" placeholder="Group Name" ng-model="groupName" novalidate>
                                    <label id="label-error" class="error"
                                           for="label" ng-bind = "groupNameError">
                                    </label> 
                            </div>
                        </div> 
                        
                        <div class="row">
                            <label class="col-sm-3 control-label required" style="padding-right:15px;">Permissions</label>
                            <div class="col-sm-3" style="padding-right:0px;padding-left:0px;">
                                <input class="form-control" type="text" name="searchText" placeholder="Search.." ng-model="searchText">
                            </div>
                            <label id="label-error" class="error col-sm-offset-1" for="label" ng-bind = "permissionsError">
                            </label> 
                        </div><br>

                        <div class="form-group">
                            <div class="well col-sm-3 col-sm-offset-3" style="padding-top:0px;padding-left:0px;padding-right:0px;padding-bottom:0px">
                                <div id="scrollArea" ng-controller="ScrollController">
                                    <ul class="example-animate-container list-group">
                                        <li style="height:30px;" class="animate-repeat list-group-item repeat" 
                                        ng-repeat="listItem in permissionList | filter:searchText as results" ng-click="push(listItem,permissionList,selectedPermissionList)">@{{listItem.name}}</li>
                                        <li  style="list-style: none" ng-if="results.length===0"><span class="label label-danger col-sm-12">No results found...</span></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="col-sm-1" style="position:relative;display:block;">
                                <div style="position:absolute;margin-top:100%;margin-left:25%">
                                    <img src="{{asset('assets/images/switch.png')}}" alt=""> 
                                </div>
                            </div>

                            <div class="well col-sm-3" style="padding-top:0px;padding-left:0px;padding-right:0px;padding-bottom:0px">
                                <div id="scrollArea" ng-controller="ScrollController">
                                    <ul class="list-group">
                                        <li style="height:30px;" class="list-group-item repeat" 
                                        ng-repeat="selectedItem in selectedPermissionList" ng-click="push(selectedItem,selectedPermissionList,permissionList) | orderBy : selectedItem">@{{selectedItem.name}}</li>
                                        <li style="list-style: none" ng-if="selectedPermissionList.length===0"><span class="label label-info col-sm-12">Add permissions here..</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-offset-9">
                            <div class="col-sm-5">
                                <button class="pull-right btn btn-primary" class="btn btn-primary" ng-click="savePermissionGroup()"><i class="fa fa-floppy-o"></i> Save</button>
                            </div> 
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
@section('js')
    <script src="{{asset('/assets/angular/vendor/angular/angular.min.js')}}"></script>
    <script type="text/javascript">
   
    /**
     * Angular
     */

    //initialize angular app
    var app = angular.module("permissionApp",[]);

    //controller
    app.controller("permissionController", function($scope,$http){

        //scope variables

        $scope.groupNameError = "";
        $scope.persmissionsError = "";
        //permission list
        $scope.permissionList = [];
        //user selected permission list
        $scope.selectedPermissionList = [];


         $.ajax({
            url: '{{url('permission/groups/permission/list')}}',
            type: 'get',
            success: function(response){
                $scope.permissionList = response.data;
                $scope.$digest();
            },
            error: function(Response){              
            }
        });

        //functions

        //save permissoin group
        $scope.savePermissionGroup = function(){
            $.ajax({
                url: '{{url('permission/groups/add')}}',
                type: 'POST',
                data: {groupName:$scope.groupName,permissions:$scope.selectedPermissionList},
                success: function(Response){
                    window.location.reload();
                    $scope.$digest();
                    swal("Good Job!", "Permission Group Added Successfully!", "success");
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
        // get permissions list - not using
        function getPermissionList(){
            $.ajax({
                url:'{{url('permission/groups/list')}}',
                type: 'GET',
                data: {},
                success : function(Response){
                    console.log("GET permission list success");
                    createList(Response,$scope.permissionList);
                },
                error: function(Response){
                    console.log("GET permission list failed");
                }
            });
        }

        
    });//end controller

    //scroll controller 
    app.controller('ScrollController', ['$scope', '$location', '$anchorScroll',
        function($scope, $location, $anchorScroll){}
    ]);
    </script>
@stop
