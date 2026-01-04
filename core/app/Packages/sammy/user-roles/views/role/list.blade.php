@extends('layouts.sammy_new.master') @section('title','User Roles List')
@section('css')
<style type="text/css">


.perm{
	font-size: 8px;
	margin: 2px;
	padding: 1px 10px 1px 10px;
	background-color: #b9b7b7;
}

</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li>
    	<a href="javascript:;">User Role Management</a>
  	</li>
  	<li class="active">Roles List</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
      			<div class="row">
      				<div class="col-xs-6">
      					<strong>Roles List</strong>
      				</div>
      				<div class="col-xs-6 text-right">
      				
      				</div>
      			</div>
      		</div>
          	<div class="panel-body">
          		<table class="table table-bordered bordered">
	              	<thead>
		                <tr>
		                  	<th class="text-center" width="5%">#</th>
		                  	<th class="text-center" style="font-weight:normal;" width="15%">Role Name</th>
		                  	<th style="font-weight:normal;" width="75%">Permissions</th>
		                  	<th colspan="2" class="text-center" width="5%" style="font-weight:normal;">Action</th>
		                </tr>		                
	              	</thead>
	              	<tbody>
	              		@foreach($data as $key=>$item)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$item->name}}</td>
								<td>
									@if($item->groups!=null)
										@foreach($item->groups as $key=>$aa)
											<span class="badge perm">{{$aa->name}}</span>
										@endforeach
									@else
										-
									@endif										
								</td>
								<td>
									@if($user->hasAnyAccess(['user.role.edit','admin']))
										<a href="{{url('user/role/edit/')}}/{{$item->id}}" class="blue"  data-toggle="tooltip" data-placement="top" title="Edit Role">
											<i class="fa fa-pencil"></i>
										</a>
									@else
										<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled">
											<i class="fa fa-pencil"></i>
										</a>
									@endif				
								</td>
								<td>
									{{--@if($user->hasAnyAccess(['user.role.delete','admin']))
										<a href="#" class="red role-delete" data-id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="Delete Role">
											<i class="fa fa-trash-o"></i>
										</a>
									@else
										<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Delete Disabled">
											<i class="fa fa-trash-o"></i>
										</a>
									@endi--}}

									-			
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
<script src="{{asset('assets/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
	var id = 0;
	var table = '';
	$(document).ready(function(){		
		$('.role-delete').click(function(e){
			e.preventDefault();
			id = $(this).data('id');
			sweetAlertConfirm('Delete Role', 'Are you sure?',2, deleteFunc);
		});
	});

	/**
	 * Delete the menu
	 * Call to the ajax request menu/delete.
	 */
	function deleteFunc(){
		ajaxRequest( '{{url('user/role/delete')}}' , { 'id' : id  }, 'post', handleData);
	}

	/**
	 * Delete the menu return function
	 * Return to this function after sending ajax request to the menu/delete
	 */
	function handleData(data){
		if(data.status=='success'){
			sweetAlert('Delete Success','Record Deleted Successfully!',0);
		}else if(data.status=='invalid_id'){
			sweetAlert('Delete Error','Role Id doesn\'t exists.',3);
		}else{
			sweetAlert('Error Occured','Please try again!',3);
		}
	}
</script>
@stop
