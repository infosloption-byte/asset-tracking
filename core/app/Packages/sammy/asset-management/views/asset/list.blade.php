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
    	<a href="#">Assets Management</a>
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

							<input @if($old['sub_loc'] == 1) checked @endif type="checkbox" name="sub_loc" id="sub_loc" style="margin-top: 5px">
							<label class="control-label">With Sub Location</label>
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Inventory NO</label>
							<input type="text" name="inv_no" id="inv_no" class="form-control" value="{{$old['inv_no']}}" placeholder="Enter inventory no">
						</div>

						<div class="form-group col-md-4">
							<label class="control-label">Serial NO</label>
							<input type="text" name="ser_no" id="ser_no" class="form-control" value="{{$old['ser_no']}}" placeholder="Enter serial no">
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
							<div class="pull-right" style="margin-top:8px">
								<button type="submit" class="btn btn-primary btn-search">
									<i class="fa fa-check"></i> search
								</button>
							</div>
							@if($user->hasAnyAccess(['asset.add', 'admin']))
							<a style="margin-top:8px;margin-right:8px" class="btn btn-warning pull-right" href="{{URL::to("asset/add")}}"  style="margin-right: 10px">
								<i class="fa fa-plus" style="width: 28px;"></i> Add
							</a>
							@endif
							@if($user->hasAnyAccess(['asset.delete', 'admin']))
							<a style="margin-top:8px;margin-right:8px" class="btn btn-danger pull-right" href="{{URL::to("asset/delete")}}"  style="margin-right: 10px">
								<i class="fa fa-trash" style="width: 28px;"></i> Delete
							</a>
							@endif
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
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%">
						<thead style="background:#ddd">
							<tr>
								<th width="5%">#</th>
								<th >Serial No</th>
								<th >Inventory No</th>
								<th >Manual No</th>
								<th >Model</th>
								<th >Location</th>
								<!-- <th >Account Code / PO Number</th> -->
								<th >Purchased Value</th>
								<th >Warranty(M)</th>
								<th >Begin</th>
								<th >End</th>
								<th >Recovery(M)</th>
								<th width="12%">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@foreach($data as $item)
								<tr>
									<td>{{$i}}</td>
									<td>
										<a href="{{url('asset/view/')}}/{{$item->id}}" style="text-decoration: underline;color:blue">{{$item->asset_no}}</a> <br>
										@if(count($item->transaction)>0)
											@if($item->transaction[0]->status->id==ASSET_UNDEPLOY)
												<span class="badge" style="font-size: 10px;background-color: #dda30c">{{$item->transaction[0]->status->name}}</span>
											@elseif($item->transaction[0]->status->id==ASSET_DISPOSED)
												<span class="badge" style="font-size: 10px;background-color: #dd1144">{{$item->transaction[0]->status->name}}</span>
											@elseif($item->transaction[0]->status->id==ASSET_INSERVICE)
												<span class="badge" style="font-size: 10px;background-color: #74dd00">{{$item->transaction[0]->status->name}}</span>
											@elseif($item->transaction[0]->status->id==ASSET_DEPLOY)
												<span class="badge" style="font-size: 10px;background-color: #3e3aff">{{$item->transaction[0]->status->name}}</span>
											@else
												<span class="badge" style="font-size: 10px;">{{$item->transaction[0]->status->name}}</span>
											@endif
										@endif
									</td>
									<td>
										@if($item->inventory_no!=null)
											{{$item->inventory_no}}
										@else
											-
										@endif
									</td>
									<td>
										@if($item->manual_no!=null)
											{{$item->manual_no}}
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
									<td>@if(count($item->transaction)>0)<span>{{$item->transaction[0]->location->name}}</span>@endif</td>
									<!-- <td>{{$item->account_code}} <br> {{$item->po_number}}</td> -->
									<td>{{CURRENCY}} {{number_format($item->purchased_value,2,'.',',')}}</td>
									<td style="text-align: center">{{$item->warranty_period}}</td>
									<td style="text-align: center">{{date('d/m/ Y',strtotime($item->warranty_from))}}</td>
									<td style="text-align: center">{{date('d/m/ Y',strtotime($item->warranty_to))}}</p></td>
									<td style="text-align: center">{{$item->recovery_period}}</td>
									<td style="text-align: center;padding: 10px 10px">
										@if($user->hasAnyAccess(['asset.view', 'admin']))
											<a href="{{url('asset/view/')}}/{{$item->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="View Item"><i class="fa fa-eye" style="color: blue"></i></a>
										@else
											<a href="#" class="disabled btn-actions" data-toggle="tooltip" data-placement="top" title="View Disabled"><i class="fa fa-eye"></i></a>
										@endif

										@if($user->hasAnyAccess(['asset.edit', 'admin']))
											<a href="{{url('asset/edit/')}}/{{$item->id}}" class="btn  btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Edit Item"><i class="fa fa-pencil" style="color: blue"></i></a>
										@else
											<a href="#" class="disabled btn-actions" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencile"></i></a>
										@endif

										@if ($user->hasAnyAccess(['asset.upgrade.add', 'admin']))
											<?php $tmp=0; ?>
											@foreach($notChecked as $tt)
												@if($tt==$item->id)
													<?php $tmp=1; ?>
												@endif
											@endforeach

											@if($tmp==0)
												<a href="{{url('asset/upgrade/add')}}/{{$item->id}}" class="red btn  btn-default btn-xs" data-id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="upgrade Asset"><i class="fa fa-level-up" aria-hidden="true" style="color: blue"></i></a>
											@else
												<a href="#" class="red btn  btn-default btn-xs disabled" data-id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="upgrade Asset"><i class="fa fa-level-up" aria-hidden="true"></i>
												</a>
											@endif
										@else
											<a href="#" class="red btn  btn-default btn-xs disabled" data-id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="upgrade Asset"><i class="fa fa-level-up" aria-hidden="true"></i>
											</a>
										@endif

										<a href="{{url('asset/upgrade/history')}}/{{$item->id}}" class="red btn  btn-default btn-xs" data-id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="upgrade history">
										<i class="fa fa-file-text-o" aria-hidden="true" style="color: blue"></i>

										</a>

									</td>
									<?php $i++ ?>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
                <?php echo $data->appends(Input::except('page'))->render()?>
                <br>
                <?php echo "Total Row Count : ".$row_count;?>
          	</div>
        </div>
	</div>
</div>
</form>

@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
	var id = 0;
	var table = '';
	$(document).ready(function(){

		$("#location").chosen({
		    search_contains: true,
		});

		$('.item-delete').click(function(e){
			e.preventDefault();
			id = $(this).data('id');
			sweetAlertConfirm('Delete Asset', 'Are you sure?',2, deleteFunc);
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

</script>
@stop
