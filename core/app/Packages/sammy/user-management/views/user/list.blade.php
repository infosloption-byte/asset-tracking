@extends('layouts.sammy_new.master') @section('title','User List')
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

.datatable a.blue {
    color: #1975D1;
}

.datatable a.blue:hover {
    color: #003366;
}

.datatable a.red {
    color: red;
}

.datatable a.red:hover {
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
    	<a href="javascript:;">User Management</a>
  	</li>
  	<li class="active">User List</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<form role="form" class="form-validation" method="get">
			<div class="panel panel-bordered" id="panel-search">			
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-4">
							<label class="control-label">Search Keyword</label>
							<input type="text" name="search_keyword" id="search_keyword" class="form-control" value="{{$old['search_keyword']}}" placeholder="Enter Username, First Name, Last Name, Code">
						</div>

						<div class="form-group col-md-2">
							<label class="control-label">Type</label>
							<select name="type" id="type" class="form-control chosen" required="required">
								<option value="0">-ALL-</option>
								@foreach($types as $type)
									<option value="{{$type->id}}" @if($type->id==$old['type']) selected @endif>{{$type->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Location</label>
							<select name="location" id="location" class="form-control chosen" required="required">
								<option value="0">-ALL-</option>
								@foreach($locations as $key=>$location)
									<option value="{{$key}}" @if($key==$old['location']) selected @endif>{{$location}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-2">
							<label class="control-label">Status</label>
							<select name="status" id="status" class="form-control chosen" required="required">
								@foreach($status as $key=>$status)
									<option value="{{$key}}" @if($key==$old['status']) selected @endif>{{$status}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-10"></div>
						<div class="form-group col-md-2">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									@if($user->hasAnyAccess(['user.add', 'admin']))
										<div class="pull-right" style="margin-top:24px;margin-right:5px">
											<a href="{{url('user/add')}}" class="btn btn-success" type="submit">
												<i class="fa fa-plus" style="width: 28px;"></i>Add
											</a>
										</div>
									@endif
									<div class="pull-right" style="margin-top:24px;padding-right: 5px">
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
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
      			<div class="row"><div class="col-xs-6"><strong>User List</strong></div>
      		</div>
          	<div class="panel-body">
          		<table class="table table-bordered">
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
	                  	<th class="text-center">Edit</th>
          			</thead>
          			<tbody>
          				<?php $i=1; ?>
          				@foreach($data as $userDetail)
          					<tr>
          						<td class="text-center">{{$i}}</td>
								<td class="text-center">@if($userDetail->username != ""){{$userDetail->username}} @else - @endif</td>
								<td class="text-center">@if($userDetail->employee[0]->first_name != ""){{$userDetail->employee[0]->first_name}}@else - @endif</td>
								<td class="text-center">@if($userDetail->employee[0]->last_name != ""){{$userDetail->employee[0]->last_name}}@else - @endif</td>
								<td class="text-center">@if(count($userDetail->UserRole)>0){{$userDetail->UserRole[0]->name}}@else - @endif</td>
								<td class="text-center">@if($userDetail->employee[0]->Location){{$userDetail->employee[0]->location->location->name}}@else - @endif</td>
								<td class="text-center">@if($userDetail->employee[0]->email != ""){{$userDetail->employee[0]->email}}@else - @endif</td>
								<td class="text-center">@if($userDetail->last_login != ""){{$userDetail->last_login}}@else - @endif</td>

								<td class="text-center">
									@if($userDetail['createdBy'])
										{{$userDetail['createdBy']['employee'][0]->first_name}} {{$userDetail['createdBy']['employee'][0]->last_name}}
									@else
										-
									@endif
								</td>

								<td class="text-center">
									@if($userDetail->created_at)
										{{$userDetail->created_at}}
									@else
										-
									@endif
								</td>

								<td class="text-center">
									@if($userDetail->verifiedby)
										{{$userDetail->verifiedby->first_name}} {{$userDetail->verifiedby->last_name}}
									@else
										-
									@endif
								</td>

								<td class="text-center">
									@if($userDetail->varified_date)
										{{$userDetail->varified_date}}
									@else
										-
									@endif
								</td>

								@if($userDetail->varified_status == 0)
									
									<td class="text-center">
										@if(Sentinel::hasAnyAccess(['user.varify','admin']))
											<a href="javascript:;" class="blue varify-user" style="margin-right: 10px" data-id="{{$userDetail->id}}" data-toggle="tooltip" data-placement="top" title="Varify User">
												<i class="fa fa-check-square-o" style="color: blue"></i>
											</a>
										@else										
											<a href="javascript:;" class="blue varify-user disabled" style="margin-right: 10px" data-id="{{$userDetail->id}}" data-toggle="tooltip" data-placement="top" title="Varify User">
												<i class="fa fa-check-square-o" style="color: black"></i>
											</a>
										@endif

										@if(Sentinel::hasAnyAccess(['user.reject','admin']))
											<a href="javascript:;" class="red reject-user" data-id="{{$userDetail->id}}" data-toggle="tooltip" data-placement="top" title="Reject User">
												<i class="fa fa-close" style="color: red"></i>
											</a>
										@else
											<a href="javascript:;" class="red reject-user disabled" data-id="{{$userDetail->id}}" data-toggle="tooltip" data-placement="top" title="Reject User">
												<i class="fa fa-close" style="color: black"></i>
											</a>
										@endif
									</td>
								@elseif($userDetail->varified_status == 1)
									<td class="text-center">
										<label class="label label-success"><span>Varified</span></label>
									</td>
								@elseif($userDetail->varified_status == 2)
									<td class="text-center">
										<label class="label label-danger"><span>Rejected</span></label>
									</td>
								@endif

								@if($userDetail->varified_status == 1)
									@if (Sentinel::hasAnyAccess(['user.status','admin']))
										@if($userDetail->status == 1)
											<td class="text-center">
												<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Click to Deactivate">
													<input class="user-activate" type="checkbox" checked value="{{$userDetail->id}}"/>
													<span style="position:inherit;">
														<i class="handle" style="position:inherit;"></i>
													</span>
												</label>
											</td>
										@else
											<td class="text-center">
												<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Click to Activate">
													<input class="user-activate" type="checkbox" value="{{$userDetail->id}}">
													<span style="position:inherit;">
														<i class="handle" style="position:inherit;"></i>
													</span>
												</label>
											</td>
										@endif
									@else
										@if($userDetail->status == 1)
											<td class="text-center">
												<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Deactivate Disabled">
													<input disabled class="user-activate" type="checkbox" checked value="{{$userDetail->id}}"/>
													<span style="position:inherit;">
														<i class="handle" style="position:inherit;"></i>
													</span>
												</label>
											</td>
										@else
											<td class="text-center">
												<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Activate Disabled">
													<input disabled class="user-activate" type="checkbox" value="{{$userDetail->id}}">
													<span style="position:inherit;">
														<i class="handle" style="position:inherit;"></i>
													</span>
												</label>
											</td>
										@endif
									@endif
								@else
									<td class="text-center">
										<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Activate Disabled">
											<input disabled class="user-activate" type="checkbox" value="{{$userDetail->id}}">
											<span style="position:inherit;">
												<i class="handle" style="position:inherit;"></i>
											</span>
										</label>
									</td>
								@endif

								@if (Sentinel::hasAnyAccess(['user.edit','admin']))
									<td class="text-center">
										<a href="{{url('user/edit')}}/{{$userDetail->id}}" class="blue" data-toggle="tooltip" data-placement="top" title="Edit User">
											<i class="fa fa-pencil" style="color: blue"></i>
										</a>
									</td>
								@else
									<td class="text-center">
										<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled">
											<i class="fa fa-pencil"></i>
										</a>
									</td>
								@endif

          					</tr>
          				<?php $i++; ?>
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
	var table = '';
	$(document).ready(function(){
		table = generateTable('.datatable', '{{url('user/json/list')}}',[0,6,7],[0,1,2,3,4,5,6,7,8],[],[],[0,"desc"]);


		$('.user-activate').change(function(){
			$('.panel').addClass('panel-refreshing');
			if($(this).prop('checked')==true){
				ajaxRequest( '{{url('user/status')}}' , { 'id' : $(this).val() , 'status' : 1 }, 'post', successFunc);
			}else{
				ajaxRequest( '{{url('user/status')}}' , { 'id' : $(this).val() , 'status' : 0 }, 'post', successFunc);
			}
		});

		$('.user-delete').click(function(e){
			e.preventDefault();
			id = $(this).data('id');
			sweetAlertConfirm('Delete Menu', 'Are you sure?',1, deleteFunc);
		});

		$('.varify-user').click(function(e){
			e.preventDefault();
			id = $(this).data('id');
			sweetAlertConfirm('Varify User', 'Are you sure?',1, varifyFunc);
		});

		$('.reject-user').click(function(e){
			e.preventDefault();
			id = $(this).data('id');
			sweetAlertConfirm('Reject User', 'Are you sure?',1, rejectFunc);
		});
	});

	/**
	 * Delete the menu
	 * Call to the ajax request menu/delete.
	 */
	function deleteFunc(){
		ajaxRequest( '{{url('user/delete')}}' , { 'id' : id  }, 'post', handleData);
	}

	/**
	 * Varify user
	 * Call to the ajax request user/varify.
	 */
	function varifyFunc(){
		$('.panel').addClass('panel-refreshing');
		ajaxRequest( '{{url('user/varify')}}' , { 'id' : id  }, 'post', handleDataVarify);
	}

	/**
	 * Reject user
	 * Call to the ajax request user/reject.
	 */
	function rejectFunc(){
		$('.panel').addClass('panel-refreshing');
		ajaxRequest( '{{url('user/reject')}}' , { 'id' : id  }, 'post', handleDataReject);
	}

	/**
	 * Delete the menu return function
	 * Return to this function after sending ajax request to the menu/delete
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
	 * Varify the user return function
	 * Return to this function after sending ajax request to the user/varify
	 */
	function handleDataVarify(data){
		
		$('.panel').removeClass('panel-refreshing');

		if(data.status=='success'){
			swal('Varification Success','User Varified Successfully!','success');
			window.location.reload();
		}else if(data.status=='invalid_id'){
			swal('Varification Error','User doesn\'t exists.','error');
		}else if(data.status=='invalid_id_employee'){
			swal('Varification Error','Employee doesn\'t exists.','error');
		}else{
			swal('Error Occured','Please try again!','error');
		}		
	}

	/**
	 * Reject the user return function
	 * Return to this function after sending ajax request to the user/reject
	 */
	function handleDataReject(data){
		
		$('.panel').removeClass('panel-refreshing');

		if(data.status=='success'){
			swal('Rejection Completed','User Rejected Successfully!','success');
			window.location.reload();
		}else if(data.status=='invalid_id'){
			swal('Varification Error','User doesn\'t exists.','error');
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
			window.location.reload();
		}else if(data.status=='invalid_id'){
			sweetAlert('Delete Error','Employee Id doesn\'t exists.',3);
		}else if(data.status=='assinged'){
			sweetAlert('Cannot Deactivate','Employee Already has Asset .',3);
		}else{
			sweetAlert('Error Occured','Please try again!',3);
		}

	}
</script>
@stop