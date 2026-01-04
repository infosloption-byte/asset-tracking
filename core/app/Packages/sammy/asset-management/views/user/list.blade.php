@extends('layouts.sammy_new.master') @section('title','Asset - Assign Un-Assign')
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

.chosen-container{
	width: 100% !important;
}


</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li>
    	<a href="{{URL::to('asset/list')}}">Assets Management</a>
  	</li>
  	<li class="active">Assets List</li>
</ol>

<form role="form" class="form-validation" method="get">
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered" id="panel-search">
			
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						<label class="control-label">Asset Location</label>
						<select name="location" id="location" class="form-control chosen" required="required">
							@foreach($locations as $key=>$location)
								<option value="{{$key}}" @if($key==$old['location']) selected @endif>{{$location}}</option>
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
						<label class="control-label">Asset Model</label>
						<select name="model" id="model" class="form-control chosen" required="required">
							<option value="0">-ALL-</option>
							@foreach($asset_models as $asset_model)
								<option value="{{$asset_model->id}}" @if($asset_model->id==$old['model']) selected @endif>{{$asset_model->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-4">
						<label class="control-label">Status</label>
						<select name="status" id="status" class="form-control chosen" required="required">
							<option value="0" @if($old['status']==0) selected @endif>-ALL-</option>
							<option value="1" @if($old['status']==1) selected @endif>Un-Deploy</option>
							<option value="2" @if($old['status']==2) selected @endif>Deploy</option>
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
				<table class="table table-bordered" style="width:100%" id="tableLoad">
					<thead style="background:#ddd">
					<tr>
						<th width="5%">#<input type="checkbox" value="" id="checkAll"></th>
						<th >Serial No</th>
						<th >Inventory No</th>
						<th >Asset Model</th>
						<th >Asset Location</th>
						<th >Employee</th>
						<th >Purchased Value</th>
						<th >Manufacturer</th>
						<th >Model No</th>
						<th >Action</th>
					</tr>
					</thead>
					<tbody>
                        <?php $i=1 ?>
						@foreach($data as $item)
							@if($item->transaction[0]->status->id==1 || $item->transaction[0]->status->id==2)
								<tr>
									<td>{{$i}}
										<input name="assets[]" type="checkbox" value="{{$item->id}}"></td>										
									</td>
									<td>
										<a href="{{url('asset/view/')}}/{{$item->id}}" style="text-decoration: underline;color:blue">#{{$item->asset_no}}</a> <br>	
										@if(count($item->transaction)>0)
											@if($item->transaction[0]->status->id==1)
												<span class="badge" style="font-size: 10px;background-color: #dda30c">{{$item->transaction[0]->status->name}}</span>
											@elseif($item->transaction[0]->status->id==2)
												<span class="badge" style="font-size: 10px;background-color: #3e3aff">{{$item->transaction[0]->status->name}}</span>
											@endif
										@endif								
									</td>
									<td>
										@if($item->inventory_no!=null)
											#{{$item->inventory_no}}
										@else
											-
										@endif										
									</td>
									<td>
										@if($item->assetmodel!=null)
											{{$item->assetmodel->name}}
										@else
											-
										@endif										
									</td>

									@if(count($item->transaction)>0)
										@if($item->transaction[0]->location_type=="location")
											<td><span>{{$item->transaction[0]->location->name}}</span></td>
											<td><span>Not Assigned</span></td>	
										@elseif($item->transaction[0]->location_type=="employee")
											<td>
												<span>
													{{($item->transaction[0] && $item->transaction[0]->location)?$item->transaction[0]->location->name:'-'}}
												</span>
											</td>
											<td>
												<span>
													@if($item->transaction[0] && $item->transaction[0]->employee)
														{{$item->transaction[0]->employee->first_name}}<br>{{$item->transaction[0]->employee->last_name}}
													@else
														-
													@endif
												</span>
											</td>
										@endif
									@else
										<td><span> - </span></td>
										<td><span> - </span></td>
									@endif

									
									<td>{{CURRENCY}}{{number_format($item->purchased_value,2,'.',',')}}</td>
									<td>{{$item->manufacturer->name}}</td>
									<td>{{$item->model}}</td>
									<td>
										@if(Sentinel::hasAnyAccess(['asset.user.assign', 'admin']))
											@if(count($item->transaction)>0)
												@if($item->transaction[0]->status->id==1)
													<a onclick="assign_asset({{$item->id}})" class="btn  btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Assign Asset"><i class="fa fa-plane" style="color: blue"></i></a>
												@elseif($item->transaction[0]->status->id==2 && $item->transaction[0]->location_type!="employee")
													<a onclick="assign_asset({{$item->id}})" class="btn  btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Assign Asset"><i class="fa fa-plane" style="color: blue"></i></a>
												@endif
											@else
												<a class="disabled btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Assign Disabled"><i class="fa fa-plane" style="color: black"></i></a>
											@endif											
										@else
											<a class="disabled btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Assign Disabled"><i class="fa fa-plane" style="color: black"></i></a>
										@endif

										@if(Sentinel::hasAnyAccess(['asset.user.unassign', 'admin']))
											@if($item->transaction[0]->location_type=="employee")
												<a onclick="unassign_asset({{$item->id}})" class="btn  btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Un-Assign Asset"><i class="fa fa-close" style="color: red"></i></a>
											@else
												<a class="disabled btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Un-Assign Disabled"><i class="fa fa-close" style="color: black"></i></a>
											@endif
										@else
											<a class="disabled btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Un-Assign Disabled"><i class="fa fa-close" style="color: black"></i></a>
										@endif									
									</td>
									<?php $i++ ?>
								</tr>
							@endif
						@endforeach
					</tbody>
				</table>
                <?php echo $data->appends(Input::except('page'))->render()?>
                <br>
                <?php echo "Total Row Count : ".$row_count;?>
                
				<div class="pull-right" style="margin-top:8px;margin-right: 7px">
					<button type="button" class="btn btn-warning btn-bulk-assign">
						<i class="fa fa-check"></i> Bulk Assign
					</button>
				</div>
				<div class="pull-right" style="margin-top:8px;margin-right: 7px">
					<button type="button" class="btn btn-danger btn-bulk-unassign">
						<i class="fa fa-check"></i> Bulk Un-Assign
					</button>
				</div>
          	</div>
        </div>
	</div>
</div>
</form>
<div class="modal fade" tabindex="-1" role="dialog" id="assignModal" name="assignModal">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title">Assign Asset To Employee</h4>
      		</div>
      		<div class="modal-body">
        		<div class="row">

					<div class="form-group">
						<label class="control-label col-md-2">Employee</label>
						<div class="col-md-10">
							{!! Form::select('employee',$employees, Input::old('employees'),['class'=>'chosen error','style'=>'width:100%;','required','id'=>'employee']) !!}
	            			@if($errors->has('employee'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('employee')}}</label>
	            			@endif
						</div>						
					</div>
        		
        		</div>
      		</div>
      		<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="button" onclick="assign()" class="btn btn-primary">Assign</button>
      		</div>
    	</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="bulkAssignModal" name="bulkAssignModal">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title">Assign Assets To Employee</h4>
      		</div>
      		<div class="modal-body">
        		<div class="row">

					<div class="form-group">
						<label class="control-label col-md-2">Employee</label>
						<div class="col-md-10">
							{!! Form::select('employee_bulk',$employees, Input::old('employees'),['class'=>'chosen error','style'=>'width:100%;','required','id'=>'employee_bulk']) !!}
	            			@if($errors->has('employee_bulk'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('employee_bulk')}}</label>
	            			@endif
						</div>						
					</div>
        		
        		</div>
      		</div>
      		<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="button" onclick="bulkAssign()" class="btn btn-primary">Assign</button>
      		</div>
    	</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div>

@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
	var id = 0;
	var table = '';
	var asset_id;
	var assets;
	$(document).ready(function(){

		var st= {!! json_encode($old['status']) !!};
		if(st){
			if(st==0){
            	$('.btn-bulk-assign').hide();
            	$('.btn-bulk-unassign').hide();
            }else if(st==1){
            	$('.btn-bulk-assign').show();
            	$('.btn-bulk-unassign').hide();
            }else if(st==2){
            	$('.btn-bulk-assign').hide();
            	$('.btn-bulk-unassign').show();
            }
		}else{
	    	$('.btn-bulk-assign').hide();
	    	$('.btn-bulk-unassign').hide();
	    }

		$('#checkAll').click(function(){
            $('td input:checkbox',$("#tableLoad")).prop('checked',this.checked);
        });

        $('#status').change(function(){
            if($(this).val()==0){
            	console.log($(this).val());
            	$('.btn-bulk-assign').hide();
            	$('.btn-bulk-unassign').hide();
            }else if($(this).val()==1){
            	console.log($(this).val());
            	$('.btn-bulk-assign').show();
            	$('.btn-bulk-unassign').hide();
            }else if($(this).val()==2){
            	console.log($(this).val());
            	$('.btn-bulk-assign').hide();
            	$('.btn-bulk-unassign').show();
            }
        });

		$("#location").chosen({
		    search_contains: true,
		});

		$('.item-delete').click(function(e){
			e.preventDefault();
			id = $(this).data('id');
			sweetAlertConfirm('Delete Asset', 'Are you sure?',2, deleteFunc);
		});

		$('.btn-bulk-assign').click(function(e){
			e.preventDefault();
			loc = $("#location").val();
			if(loc!=0){
				assets = $('input:checkbox:checked').map(function() {
					if(this.value!=0 && this.value!=''){
				    	return this.value;
					}
				}).get();

		  		if(assets.length>0){
					$('.panel').addClass('panel-refreshing');
					$('#employee_bulk').html('');
					$.ajax({
			            url: "{{url('asset/get-location-employee')}}",
			            type: 'GET',
			            data: {'loc': loc},
			            success: function(data) {
			            console.log(data);
							$('.panel').removeClass('panel-refreshing');
			                $.each(data,function(key,value){
			                    $('#employee_bulk').append('<option value="'+key+'">'+value+'</option>');
			                });
			                $('#employee_bulk').trigger("chosen:updated");
							$("#bulkAssignModal").modal('show');
			            },error: function(data){

			            }
			        });
		  		}else{
					swal('Warning!', 'Please select assets','error');		  			
		  		}
			}else{
				swal('Warning!', 'Please select location?','error');
			}
		});

		$('.btn-bulk-unassign').click(function(e){
			e.preventDefault();
			

			assets = $('input:checkbox:checked').map(function() {
				if(this.value!=0 && this.value!=''){
			    	return this.value;
				}
			}).get();

	  		if(assets.length>0){
				$('.panel').addClass('panel-refreshing');
				$.ajax({
		            url: "{{url('asset/user/unassign-bulk')}}",
		            type: 'POST',
		            data: {'assets': assets},
		            success: function(data) {                
		                if(data==1){
		                    $('.panel').removeClass('panel-refreshing');
		                    swal({ 
		                        title: "Well Done!",
		                        text: "Asset Successfully Un-Assigned from Employee",
		                        type: "success" 
		                    },function(){
		                        pageReload();
		                    });                 
		                }else{
		                    $('.panel').removeClass('panel-refreshing');
		                    swal('Error!','Something went wrong','error');
		                }
		            },error: function(data){

		            }
		        });
	  		}else{
				swal('Warning!', 'Please select assets','error');		  			
	  		}
			
		});

	});

	/**
	 * Delete the menu
	 * Call to the ajax request menu/delete.
	 */
	function deleteFunc(){
		ajaxRequest( '{{url('asset/delete')}}' , { 'id' : id  }, 'post', handleData);
	}

	/**
	 * Delete the menu return function
	 * Return to this function after sending ajax request to the menu/delete
	 */
	function handleData(data){
		if(data.status=='success'){
			sweetAlert('Delete Success','Record Deleted Successfully!',0);
			table.ajax.reload();
		}else if(data.status=='invalid_id'){
			sweetAlert('Delete Error','Record Id doesn\'t exists.',3);
		}else{
			sweetAlert('Error Occured','Please try again!',3);
		}
	} 

	function assign_asset(asset){
		asset_id=asset;

		$('.panel').addClass('panel-refreshing');
		$('#employee').html('');
		$.ajax({
            url: "{{url('asset/get-asset-location-employee')}}",
            type: 'GET',
            data: {'asset': asset_id},
            success: function(data) {                
				$('.panel').removeClass('panel-refreshing');
                $.each(data,function(key,value){
                    $('#employee').append('<option value="'+key+'">'+value+'</option>');
                });
                $('#employee').trigger("chosen:updated");
				$("#assignModal").modal('show');
            },error: function(data){

            }
        });
	}

	function assign(){

		emp_id=$('#employee').val();

		$("#assignModal").modal('toggle');

		$('.panel').addClass('panel-refreshing');

		$.ajax({
            url: "{{url('asset/user/assign')}}",
            type: 'POST',
            data: {'asset': asset_id,'employee': emp_id},
            success: function(data) {
            	console.log(data)                ;
                if(data==1){
                    $('.panel').removeClass('panel-refreshing');
                    swal({ 
                        title: "Well Done!",
                        text: "Asset Successfully assigned to Employee",
                        type: "success" 
                    },function(){
                        pageReload();
                    });                 
                }else{
                    $('.panel').removeClass('panel-refreshing');
                    swal('Error!','Something went wrong','error');
                }
            },error: function(data){

            }
        });
	}

	function unassign_asset(asset){

		$('.panel').addClass('panel-refreshing');

		$.ajax({
            url: "{{url('asset/user/unAssign')}}",
            type: 'POST',
            data: {'asset': asset},
            success: function(data) {                
                if(data==1){
                    $('.panel').removeClass('panel-refreshing');
                    swal({ 
                        title: "Well Done!",
                        text: "Asset Successfully Un-Assigned from Employee",
                        type: "success" 
                    },function(){
                        pageReload();
                    });                 
                }else{
                    $('.panel').removeClass('panel-refreshing');
                    swal('Error!','Something went wrong','error');
                }
            },error: function(data){

            }
        });
	}

	function pageReload(){
		window.location.href = window.location.href;
	}

	function bulkAssign(){

		emp_id=$('#employee_bulk').val();

		$("#bulkAssignModal").modal('toggle');

		$('.panel').addClass('panel-refreshing');

		$.ajax({
            url: "{{url('asset/user/assign-bulk')}}",
            type: 'POST',
            data: {'assets': assets,'employee': emp_id},
            success: function(data) {
            	console.log(data);
                if(data==1){
                    $('.panel').removeClass('panel-refreshing');
                    swal({ 
                        title: "Well Done!",
                        text: "Asset Successfully assigned to Employee",
                        type: "success" 
                    },function(){
                        pageReload();
                    });                 
                }else{
                    $('.panel').removeClass('panel-refreshing');
                    swal('Error!','Something went wrong','error');
                }
            },error: function(data){

            }
        });
	}
</script>
@stop