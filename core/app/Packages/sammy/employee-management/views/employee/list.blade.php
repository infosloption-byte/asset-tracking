@extends('layouts.sammy_new.master') @section('title','Employee List')
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
    	<a href="javascript:;">Employee Management</a>
  	</li>
	<li>
		<a href="javascript:;">Employee List</a>
	</li>
  	<li class="active">Employee List</li>
</ol>

<div class="row">
	<div class="col-xs-12">
		<form role="form" class="form-validation" method="get">
			<div class="panel panel-bordered" id="panel-search">			
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-4">
							<label class="control-label">Search</label>
							<input type="text" name="keyword" id="keyword" class="form-control" value="{{$old['keyword']}}" placeholder="Enter keyword">
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Employee Code</label>
							<input type="text" name="code" id="code" class="form-control" value="{{$old['code']}}" placeholder="Enter code">
						</div>

						<div class="form-group col-md-4">
							<label class="control-label">Name</label>
							<input type="text" name="name" id="name" class="form-control" value="{{$old['name']}}" placeholder="Enter name">
						</div>

						<div class="form-group col-md-4">
							<label class="control-label">Asset Location</label>
							<select name="location" id="location" class="form-control chosen" required="required">
								<option value="0">-ALL-</option>
								@foreach($locations as $key=>$location)
									<option value="{{$key}}" @if($key==$old['location']) selected @endif>{{$location}}</option>
								@endforeach
							</select>
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
								<option value="3" selected>--ALL--</option>
								@foreach($status as $key=>$status)
									<option value="{{$key}}" @if($key==$old['status']) selected @endif>{{$status}}</option>
								@endforeach
							</select>
						</div>

					</div>
					
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="pull-right" style="margin-top:8px">
								<button type="submit" class="btn btn-primary btn-search">
									<i class="fa fa-check"></i> search
								</button>
							</div>

							@if($user->hasAnyAccess(['employee.add', 'admin']))
								<div class="pull-right" style="margin-top:8px;margin-right:5px">
									<a href="{{url('employee/add')}}" class="btn btn-success" type="submit">
										<i class="fa fa-plus" style="width: 28px;"></i>Add
									</a>
								</div>
							@endif
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
	                  	<th class="text-center">Varification Status</th>
	                  	<th colspan="3" class="text-center" width="6%">Action</th>
          			</thead>
          			<tbody>
	              		@foreach($data as $key=>$employee)
	              			<tr>
		              			<td>{{$key+1}}</td>
		              			<td>{{$employee->type->name!=null?$employee->type->name:'-'}}</td>
		              			<td>{{$employee->code}}</td>
		              			<td>
		              				{{$employee->first_name}} {{$employee->last_name}} <br>
		              				@if($employee->branch_user==1)
										<span class="badge" style="font-size: 10px;background-color: navy">Branch User</span>
									@endif
		              			</td>
		              			<td>{{$employee->nic}}</td>
		              			<td>{{$employee->address}}</td>
		              			<td>{{$employee->mobile!=null?$employee->mobile:'-'}}</td>
		              			<td>{{$employee->email!=null?$employee->email:'-'}}</td>
		              			<td>
		              				@if($employee->location!=null)
		              					{{$employee->location->location->name}}
		              				@else
						               -
						            @endif
		              			</td>
		              			<td>{{$employee->parentEmployee->getFullNameAttribute()}}</td>
		              			<td>
		              				@if($employee->status==1)                
						                <span class="label label-success">Activated</span>
						            @elseif($employee->status==0 && $employee->varified_status == 0)
						                <span class="label label-warning">Not Verified</span>
						            @elseif($employee->status==0 && $employee->varified_status == 1)
						                <span class="label label-danger">Unauthorized</span>
						            @else
						                <span class="label label-danger">Deactivated</span>
						            @endif
		              			</td>

								<td class="text-center">
			              			@if($employee->varified_status == 0)
										@if(Sentinel::hasAnyAccess(['employee.varify','admin']))
											<a href="javascript:;" class="blue varify-employee" style="margin-right: 10px" data-id="{{$employee->id}}" data-toggle="tooltip" data-placement="top" title="Varify Employee">
												<i class="fa fa-check-square-o" style="color: blue"></i>
											</a>
										@else
											<a href="javascript:;" class="blue varify-employee disabled" style="margin-right: 10px" data-id="{{$employee->id}}" data-toggle="tooltip" data-placement="top" title="Varify Employee">
												<i class="fa fa-check-square-o" style="color: black"></i>
											</a>
										@endif

										@if(Sentinel::hasAnyAccess(['employee.reject','admin']))
											<a href="javascript:;" class="red reject-employee" data-id="{{$employee->id}}" data-toggle="tooltip" data-placement="top" title="Reject User">
												<i class="fa fa-close" style="color: red"></i>
											</a>
										@else
											<a href="javascript:;" class="red reject-employee disabled" data-id="{{$employee->id}}" data-toggle="tooltip" data-placement="top" title="Reject User">
												<i class="fa fa-close" style="color: black"></i>
											</a>
										@endif

									@elseif($employee->varified_status == 1)
										<label class="label label-success"><span>Varified</span></label>
									@elseif($employee->varified_status == 2)
										<label class="label label-danger"><span>Rejected</span></label>
									@endif
								</td>

		              			<td>
		              				@if(Sentinel::hasAnyAccess(['employee.edit','admin']))
						                <a href="{{url('employee/edit')}}/{{$employee->id}}" class="blue" data-toggle="tooltip" data-placement="top" title="Edit Type"><i class="fa fa-pencil" style="color: #3F51B5"></i></a>
						            @else
						                <a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>
						            @endif
		              			</td>

		              			<td>
		              				@if($employee->varified_status == 1)
							            @if(Sentinel::hasAnyAccess(['employee.status','admin']))
			              					@if($employee->status==1)    
							                    <label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Click to Deactivate"><input class="employee-activate" type="checkbox" checked 
							                    value="{{$employee->id}}">
							                    <span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span></label>
							                @else
							                    <label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Click to Activate"><input class="employee-activate" type="checkbox" value="{{$employee->id}}"><span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span></label>
							                @endif
							            @else
							                @if($employee->status==1)    
							                    <label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Deactivate Disabled"><input disabled class="employee-activate" type="checkbox" checked 
							                    value="{{$employee->id}}">
							                    <span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span></label>
							                @else
							                    <label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Activate Disabled"><input disabled class="employee-activate" type="checkbox" value="{{$employee->id}}"><span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span></label>
							                @endif
							            @endif
							        @else
							        	<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Activate Disabled"><input disabled class="employee-activate" type="checkbox" value="{{$employee->id}}"><span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span></label>
							        @endif
		              			</td>					           
				            </tr>
	              		@endforeach
	              	</tbody>
          		</table>
          		<?php echo $data->appends(Input::except('page'))->render()?>
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
		$('.employee-activate').change(function(){
			$('.panel').addClass('panel-refreshing');
			if($(this).prop('checked')==true){					
				ajaxRequest( '{{url('employee/status')}}' , { 'id' : $(this).val() , 'status' : 1 }, 'post', successFunc);
			}else{					
				ajaxRequest( '{{url('employee/status')}}' , { 'id' : $(this).val() , 'status' : 0 }, 'post', successFunc);
			}
		});

		$('.employee-delete').click(function(e){
			e.preventDefault();
			id = $(this).data('id');
			sweetAlertConfirm('Delete Employee', 'Are you sure?',2, deleteFunc);
		});

		$('.varify-employee').click(function(e){
			e.preventDefault();
			id = $(this).data('id');
			sweetAlertConfirm('Varify Employee', 'Are you sure?',1, varifyFunc);
		});

		$('.reject-employee').click(function(e){
			e.preventDefault();
			id = $(this).data('id');
			sweetAlertConfirm('Reject Employee', 'Are you sure?',1, rejectFunc);
		});

	});

	/**
	 * Delete the Employee
	 * Call to the ajax request employee/delete.
	 */
	function deleteFunc(){
		ajaxRequest( '{{url('employee/delete')}}' , { 'id' : id  }, 'post', handleData);
	}

	/**
	 * Varify employee
	 * Call to the ajax request employee/varify.
	 */
	function varifyFunc(){
		$('.panel').addClass('panel-refreshing');
		ajaxRequest( '{{url('employee/varify')}}' , { 'id' : id  }, 'post', handleDataVarify);
	}

	/**
	 * Reject Employee
	 * Call to the ajax request employee/reject.
	 */
	function rejectFunc(){
		$('.panel').addClass('panel-refreshing');
		ajaxRequest( '{{url('employee/reject')}}' , { 'id' : id  }, 'post', handleDataReject);
	}

	/**
	 * Delete the employee return function
	 * Return to this function after sending ajax request to the employee/delete
	 */
	function handleData(data){
		if(data.status=='success'){
			sweetAlert('Delete Success','Record Deleted Successfully!',0);
		}else if(data.status=='invalid_id'){
			sweetAlert('Delete Error','Employee Id doesn\'t exists.',3);
		}else if(data.status=='assinged'){
			sweetAlert('Cannot Deactivate','Employee Already has Asset .',3);
		}else{
			sweetAlert('Error Occured','Please try again!',3);
		}
	}

	/**
	 * Varify the employee return function
	 * Return to this function after sending ajax request to the employee/varify
	 */
	function handleDataVarify(data){
		
		$('.panel').removeClass('panel-refreshing');

		if(data.status=='success'){
			swal('Varification Success','Employee Varified Successfully!','success');
			pageReload();
		}else if(data.status=='invalid_id'){
			swal('Varification Error','Employee doesn\'t exists.','error');
		}else{
			swal('Error Occured','Please try again!','error');
		}		
	}

	/**
	 * Reject the employee return function
	 * Return to this function after sending ajax request to the employee/reject
	 */
	function handleDataReject(data){
		
		$('.panel').removeClass('panel-refreshing');

		if(data.status=='success'){
			swal('Rejection Completed','Employee Rejected Successfully!','success');
			pageReload();
		}else if(data.status=='invalid_id_employee'){
			swal('Varification Error','Employee doesn\'t exists.','error');
		}else{
			swal('Error Occured','Please try again!','error');
		}		
	}

	function successFunc(data){
		$('.panel').removeClass('panel-refreshing');
		if(data.status=='success'){
			sweetAlert('Success','Action Successfully Done!',0);
		}else if(data.status=='invalid_id'){
			sweetAlert('Delete Error','Employee Id doesn\'t exists.',3);
		}else if(data.status=='assinged'){
			sweetAlert('Cannot Deactivate','Employee Already has Asset .',3);
		}else{
			sweetAlert('Error Occured','Please try again!',3);
		}

		pageReload();
	}

	function pageReload(){
		window.location.href = window.location.href;
	}
</script>
@stop