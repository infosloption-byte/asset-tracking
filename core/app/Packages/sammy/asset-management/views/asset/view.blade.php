@extends('layouts.sammy_new.master') @section('title','Asset Management - Asset Detail')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/styles/adminLte.min.css')}}">
<style type="text/css">
	.panel.panel-bordered {
	    border: 1px solid #ccc;
	}

	.btn-primary {
	    color: white;
	    background-color: #005C99;
	    border-color: #005C99;
	}

	.chosen-container{
		font-family: 'FontAwesome', 'Open Sans',sans-serif;
	}

	#barcode_wrapper_empty{
		border: 1px solid #ddd;
		padding-bottom: 35px;
		padding-top: 35px;
	}

	#barcode_category_chosen{
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
    	<a href="{{URL::to('asset/list')}}">Asset List</a>
  	</li>
  	<li class="active">Asset Details</li>
</ol>
<div class="row">
	<div class="col-xs-8 col-md-8 pull-left">
		<div class="panel panel-bordered">
      		<div class="panel-heading border" >
      			<div class="row" id="btn-panel">
      				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
	        			<h4 style="font-weight: 600">Asset ({{$details->asset_no}}) Details</h4>
	        		</div>
	        		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-right">
	        			
	        			@if($user->hasAnyAccess(['asset.edit', 'admin']))
							<a href="{{url('asset/edit')}}/{{$details->id}}" class="btn btn-sm btn-info" data-id="{{$details->id}}" data-toggle="tooltip" data-placement="top" title="Edit Asset">Edit</a>
						@else
							<a href="{{url('asset/edit')}}/{{$details->id}}" class="btn btn-sm btn-info disabled" data-toggle="tooltip" data-placement="top" title="Edit Asset Disabled">Edit</a>
						@endif

	        			@if($details->barcode==null)
	        				<button type="button" class="btn btn-sm btn-info btn-genarate">Genarate Barcode</button>
	        			@else
	        				<a href="{{url('barcode/print/')}}/{{$details->id}}" class="btn btn-sm btn-primary btn-print-barcode">Print Barcode</a>
	        			@endif

	        			@if ($user->hasAnyAccess(['asset.upgrade.add', 'admin']))
							<a href="{{url('asset/upgrade/add')}}/{{$details->id}}" class="red btn  btn-sm btn-warning" data-id="{{$details->id}}" data-toggle="tooltip" data-placement="top" title="upgrade Asset">upgrade</a>
							<a href="{{url('asset/upgrade/history')}}/{{$details->id}}" class="red btn  btn-sm btn-warning" data-id="{{$details->id}}" data-toggle="tooltip" data-placement="top" title="Asset upgrade history">upgrade history </a>
						@else
							<a href="#" class="red btn  btn-default btn-sm btn-warning" data-id="{{$details->id}}" data-toggle="tooltip" data-placement="top" title="upgrade Asset">
							upgrade
							</a>
						@endif

						@if($user->hasAnyAccess(['asset.damage', 'admin']) && $timeline[0]->status->id!=6)
							<a class="btn-dispose red btn  btn-sm btn-warning" data-id="{{$details->id}}" data-toggle="tooltip" data-placement="top" title="Dispose Asset">Dispose</a>
						@else
							<a  class="disabled red btn  btn-sm btn-warning" data-id="{{$details->id}}" data-toggle="tooltip" data-placement="top" title="Dispose Asset Disabled">Dispose</a>
						@endif
					</div>
      			</div>
			</div>
          	<div class="panel-body">
          		<div class="row" id="print-details">	          		
          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center visible-print" style="margin-bottom: 20px">
	          				<h4 style="font-weight: 600">Asset ({{$details->asset_no}}) Details</h4>
	          			</div>

	          			<div class="col-xs-6 col-sm-6 col-md-7 col-lg-7 pull-left">
	          				<h5 style="font-weight: 600">Inventory No  : {{$details->inventory_no}}</h5>
	          				<h5 style="font-weight: 600">Manufacturer  : {{$details->manufacturer->name}}</h5>
	          				<h5 style="font-weight: 600">Model  	   : {{$details->model}}</h5>
	          				<h5 style="font-weight: 600">Purcahse Date : {{$details->purchased_date}}</h5>
	          				<h5 style="font-weight: 600">Warranty Begin : {{$details->warranty_from}} - End :{{$details->warranty_to}}</h5>
	          			</div>

          				<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 text-left">
	          				<h5 style="font-weight: 600">Manual No  : {{$details->manual_no}}</h5>
	          				<h5 style="font-weight: 600">Account Code  : {{$details->account_code}}</h5>
	          				<h5 style="font-weight: 600">PO Number No  : {{$details->po_number}}</h5>
		      				<h5 style="font-weight: 600">Purchased Value  : {{$details->purchased_value}}</h5>
		      				<h5 style="font-weight: 600">Scrap Value  : {{$details->scrap_value}}</h5>
		      			</div>
          			</div>

          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	          			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
		      				@if($details->barcode!=null)
                                <?php echo DNS1D::getBarcodeSVG($details->inventory_no, $details->barcode->barcodetype->name,1.5,60) ?>
								<i style="font-size: 9px;">{{$details->inventory_no}}</i>
		      				@else
		      					<div id="barcode_wrapper_empty" data-barcodeType="0" class="text-center" >
		      						<h5>barcode not genarated</h5>
		      					</div>
		      				@endif
		      			</div>
	          		</div>

          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          				<hr>
          			</div>

          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left">
          					@if($details->supplier)
		          				<h5 style="font-weight: 600">Supplier : {{$details->supplier->name}} ({{$details->supplier->country}} - {{$details->supplier->city}})</h5>
		          				<h5 >Address : {{$details->supplier->address}}</h5>
		          				<h5 >Contact No : {{$details->supplier->phone}}</h5>
		          				<h5 >Email : {{$details->supplier->email}}</h5>
		          			@else
		          				<h5 style="font-weight: 600">Supplier : No Details</h5>
		          			@endif
	          			</div>
          			</div>

          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          				<hr>
          			</div>

          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          				<h4>Upgraded Assets</h4>

          				<table class="table table-bordered">
							<thead>
								<tr>
									<th >Serial No</th>
									<th >Inventory No</th>
									<th >Model</th>
									<th >Purchased Value</th>
									<th >Begin</th>
									<th >End</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1 ?>
								@foreach($details->upgradehistory as $history)
								<tr>
									<td>
										<a href="{{url('asset/view/')}}/{{$history->upgrade_asset_id}}" style="text-decoration: underline;color:blue">{{$history->asset->asset_no}}</a>
									</td>
									<td>
										@if($history->asset->inventory_no!=null)
											{{$history->asset->inventory_no}}
										@else
											-
										@endif										
									</td>
									<td>
										@if($history->asset->assetmodel!=null)
											{{$history->asset->assetmodel->name}}
										@else
											-
										@endif										
									</td>
									<td>{{CURRENCY}}{{number_format($history->asset->purchased_value,2,'.',',')}}</td>
									<td style="text-align: center">{{$history->asset->warranty_from}}</td>
									<td style="text-align: center">{{$history->asset->warranty_to}}</p></td>
								    <?php $i++ ?>
								</tr>
								@endforeach
							</tbody>
						</table>
          			</div>

          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          				<h4>Upgraded Into</h4>
          				<table class="table table-bordered">
							<thead>
								<tr>
									<th >Serial No</th>
									<th >Inventory No</th>
									<th >Model</th>
									<th >Purchased Value</th>
									<th >Begin</th>
									<th >End</th>
								</tr>
							</thead>
							<tbody>
								@if(count($assignto)>0)
								<tr>
									<td>
										<a href="{{url('asset/view/')}}/{{$assignto->id}}" style="text-decoration: underline;color:blue">{{$assignto->asset_no}}</a>
									</td>
									<td>
										@if($assignto->inventory_no!=null)
											{{$assignto->inventory_no}}
										@else
											-
										@endif										
									</td>
									<td>
										@if($assignto->assetmodel!=null)
											{{$assignto->assetmodel->name}}
										@else
											-
										@endif										
									</td>
									<td>{{CURRENCY}}{{number_format($assignto->purchased_value,2,'.',',')}}</td>
									<td style="text-align: center">{{$assignto->warranty_from}}</td>
									<td style="text-align: center">{{$assignto->warranty_to}}</p></td>
								</tr>
								@endif
							</tbody>
						</table>
          			</div>

          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          				<hr>
          			</div>

          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          				<h4>Assigned software details</h4>
          				<table class="table table-bordered">
							<thead>
								<tr>
									<th >Name</th>
									<th >Category</th>
									<th >Description</th>
									<th >Expiry</th>
									<th >Manufacturer</th>
									<th >Supplier</th>
									<th >Reference</th>
								</tr>
							</thead>
							<tbody>
								@if(count($license)>0)
									@foreach($license as $value)
										<tr>
											<td>{{$value->name}}</td>
											<td>{{$value->category}}</td>
											<td>{{$value->description}}</td>
											<td>{{$value->license_to}}</td>
											<td>{{$value['manufacture']->name}}</td>
											<td>{{$value['supplier']->name}}</td>
											<td>{{$value->reference_no}}</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="7">Nothing Assinged yet</td>
									</tr>
								@endif
							</tbody>
						</table>
          			</div>

          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          				<hr>
          			</div>

          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left">
	          				<h5>Description</h5>
          					<h6>{{$details->description}}</h6>
	          			</div>
          			</div>

	          		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          				<hr>
          			</div>

          			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">   
          				<h4>Details</h4>

      					@foreach($assetDetails as $deviceModel)
      						<div class="row">
          						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			          				<h5 style="font-weight: bold">{{$deviceModel['modal']}}</h5>
			          				@foreach($deviceModel['value'] as $key=>$fieldset)
			          					<div class="row">
          									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          										<h5 style="margin:5px">{{$key}} : {{$fieldset}}</h5>
          									</div>
          								</div>
      								@endforeach
			          			</div>
			          		</div>
      					@endforeach
          			</div>
          		</div>
          	</div>
        </div>
	</div>

	<div class="col-md-4">
	    <div class="panel panel-bordered">
	      	<div class="panel-heading border">
	        	<h4><i class="fa fa-list" style="margin-right:10px"></i>Asset Timeline</h4>
	      	</div>
	      	<div class="panel-body">
	        	<div class="scrollable ps-container ps-active-y" style="height: 633px" id="time_container" name="time_container">
	          		<ul class="timeline" id="timeline" name="timeline">
			          	<?php $lk=0;?>
			          	@foreach($timeline as $data)
							<li class="time-label">
								<span class="bg-red">{{date_format($data->created_at, 'D-M-d-Y')}}</span>
							</li>
							<li>
							@if($lk==count($timeline)-1)
								<i class="fa fa-arrow-up bg-blue"></i>
								<div class="timeline-item">
									<span class="time"><i class="fa fa-clock-o"> {{date_format($data->created_at, 'h:i:s')}}</i></span>
									<h3 class="timeline-header"><a href="#">Asset Upload</a></h3>
									<div class="timeline-body">							
										<p><strong>Upload to : {{$data->location->name}}</strong></p>							
									</div>
									<div class="timeline-footer">
										<p><strong>Action By : {{$data->user->first_name}} {{$data->user->last_name}} - Code : @if(isset($data->user->code)){{$data->user->code}}@endif</strong></p>
									</div>
								</div>
							@elseif($lk==count($timeline)-2)
								<i class="fa fa-share bg-blue"></i>
								<div class="timeline-item">
									<span class="time"><i class="fa fa-clock-o"> {{date_format($data->created_at, 'h:i:s')}}</i></span>
									<h3 class="timeline-header"><a href="#">Asset Acknolwdgement</a></h3>
									<div class="timeline-body">
										<p><strong>Asset Check-In to : {{$data->location->name}}</strong>
										@if($data->type == 'Rejected Back To')
											<br/><span class="text-danger"><strong>Remark: </strong>{{$data->checkin_text}}</span>
										@endif
										</p>
									</div>
									<div class="timeline-footer">
										<p><strong>Action By : {{$data->user->first_name}} {{$data->user->last_name}} - Code : @if(isset($data->user->code)){{$data->user->code}}@endif</strong></p>
									</div>
								</div>
							@else
								@if($data->status->id==ASSET_UNDEPLOY)
									<i class="fa fa-reply bg-blue"></i>
								@elseif($data->status->id==ASSET_DISPOSED)
									<i class="fa fa-times bg-red"></i>
								@elseif($data->status->id==ASSET_INSERVICE)
									<i class="fa fa-wrench bg-green"></i>
								@elseif($data->status->id==ASSET_DEPLOY)
									<i class="fa fa-share bg-blue"></i>
								@else
									<i class="fa fa-share bg-blue"></i>
								@endif
								<div class="timeline-item">
									<span class="time"><i class="fa fa-clock-o"> {{date_format($data->created_at, 'h:i:s')}}</i></span>
									<h3 class="timeline-header"><a href="#">{{$data->status->name}}</a></h3>
									<div class="timeline-body">
										
									@if($data->status->id==ASSET_UNDEPLOY)
										<p style="margin-bottom: 0;"><strong>{{$data->type}} : {{$data->location->name}}</strong>
										@if($data->type == 'Rejected Back To')
											<br/><span class="text-danger"><strong>Remark: </strong>{{$data->checkin_text}}</span>
										@endif
										</p>
									@elseif($data->status->id==ASSET_DEPLOY)							
										<p><strong>{{$data->type}} : @if($data->employee){{$data->employee->first_name}} {{$data->employee->last_name}}@endif - {{$data->location->name}}</strong></p>
									@else
										<p><strong>{{$data->type}} : {{$data->location->name}}</strong></p>
									@endif
									</div>
									<div class="timeline-footer">
										<p><strong>Action By : {{$data->user->first_name}} {{$data->user->last_name}} - Code : @if(isset($data->user->code)){{$data->user->code}}@endif</strong></p>
									</div>
								</div>
							@endif
							</li>
							<?php $lk++; ?>
			          	@endforeach
	          		</ul>
	          		<div style="left: 0px; bottom: -727px;" class="ps-scrollbar-x-rail">
	          			<div style="left: 0px; width: 0px;" class="ps-scrollbar-x"></div>
	          		</div>
	          		<div style="top: 730px; height: 130px; right: 0px;" class="ps-scrollbar-y-rail">
	          			<div style="top: 111px; height: 19px;" class="ps-scrollbar-y"></div>
	          		</div>
	        	</div>
	      	</div>
	    </div>
  	</div>
</div>

@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/sammy_new/js-barcode/JsBarcode.all.min.js')}}"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.btn-genarate').click(function(){
            $(".panel").addClass('panel-refreshing');
		 	$.ajax({
                url: "{{url('barcode/generate')}}" ,
                 type: 'post',
                 data: {'asset_id' :  "{{$details->id}}"},
                 success: function(data) {
                     $(".panel").removeClass('panel-refreshing');
                     if(data.status=="success"){
                         swal("Success", 'Barcode generated','success');
                         location.reload();
                     }else{
                         swal("Error!", 'Something happend while processing','error');
					 }
                 },
                 error: function(xhr, textStatus, thrownError) {
                     console.log(thrownError);
                 }
             });
		});

		$('.btn-dispose').click(function(){
			$(".panel").addClass('panel-refreshing');
		 	$.ajax({
                url: "{{url('asset/checkForDispose')}}" ,
                type: 'get',
                async: false,
                data: {'asset_id' :  "{{$details->id}}"},
                success: function(data) {
                	$(".panel").removeClass('panel-refreshing');
                	if(data.status==1){
			            swal({
						  title: "Are you sure?",
						  text: "This will Dispose the asset from the system permanently !",
						  type: "warning",
						  showCancelButton: true,
						  confirmButtonColor: "#DD6B55",
						  confirmButtonText: "Yes, dispose it!",
						  closeOnConfirm: false
						},
						function(){				
			            	$(".panel").addClass('panel-refreshing');
						    $.ajax({
				                url: "{{url('asset/putToDamage')}}" ,
				                type: 'post',
				                async: false,
				                data: {'asset_id' :  "{{$details->id}}"},
				                success: function(data_res) {
				                     $(".panel").removeClass('panel-refreshing');
				                     if(data_res.status=="success"){
				                         swal("Success", 'Disposed successfully','success');
				                         location.reload();
				                     }else{
				                         swal("Error!", 'Something happend while processing','error');
									 }
				                },
				                error: function(xhr, textStatus, thrownError) {
				                     console.log(thrownError);
				                }
				            });
						});
					}else{
						$(".panel").removeClass('panel-refreshing');
						swal('Error!','Cannot dispose without dispose request and request must be approve','error');
					}
				},
                error: function(xhr, textStatus, thrownError) {
                     console.log(thrownError);
                }
            });

		});

		$('#time_container').perfectScrollbar();
	});
</script>
@stop
