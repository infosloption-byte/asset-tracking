@extends('layouts.sammy_new.master') @section('title','Check-In - Asset')
@section('css')
	<link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/file/bootstrap-fileinput-master/css/fileinput.css')}}"media="all" />
	<link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/vendor/bootstrap3-wysihtml5/dist/bootstrap3-wysihtml5.min.css')}}"
		  media="all" />
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

		ul.wysihtml5-toolbar>li{
			margin: 0;
		}

		.wysihtml5-sandbox{
			border-style: solid!important;
			border-width: 1px!important;
			border-top: 0 none!important;
		}

		ul.wysihtml5-toolbar .btn{
			border-bottom: 0;
		}

		ul.wysihtml5-toolbar{
			border: 1px solid #e4e4e4;
		}

		.disabled-result{
			color:#515151!important;
			font-weight: bold!important;
		}

		.ms-container {
			width: 100% !important;
		}

		.chosen-container{
			width: 100%!important;
		}
	</style>
@stop
@section('content')
	<ol class="breadcrumb">
		<li>
			<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
		</li>
		<li class="active">Barcode Management</li>
	</ol>
	<div class="row">
		<div class="col-xs-12">
			<form role="form" class=" form-validation" method="get" enctype="multipart/form-data">
				<div class="panel panel-bordered" id="panel-search">
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
								<div class="pull-right" style="margin-top:8px">
									<button type="submit" class="btn btn-primary btn-search">
										<i class="fa fa-check"></i> search
									</button>
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
				<div class="panel-body">
					<form role="form" action="print" class=" form-validation" method="post"
					 enctype="multipart/form-data">
					{!!Form::token()!!}
					<table class="table table-bordered table-hover table-responsive" id="tableLoad">
						<thead style="background-color: #5e9acc;color: #fff">
						<tr>
							<th width="5%"><input type="checkbox" value="" id="checkAll"></th>
							<th >Asset SerialNo</th>
							<th >Asset InvNo</th>
							<th >Asset Model</th>
							<th>Asset Location</th>
							<th width="20%" class="text-center">Barcode</th>
							<th width="15%" class="text-center">Action</th>
						</tr>
						</thead>
						<tbody id="tbody">
                        <?php $i=1 ?>
							@foreach($assets as $item)
								<tr>
									<td>
										@if($item->barcode!=null)
											<input name="assets[]" type="checkbox" value="{{$item->id}}"></td>
										@endif
									<td>
										<a href="{{url('asset/view/')}}/{{$item->id}}" class="link" data-toggle="tooltip" data-placement="top" title="View Item" style="text-decoration:underline;color:blue">{{$item->asset_no}}</a><br>
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
										@else
											-
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
										@if($item->assetmodel!=null)
											{{$item->assetmodel->name}}
										@else
											-
										@endif										
									</td>
									<td>
										@if(count($item->transaction)>0)
											<span>{{$item->transaction[0]->location->name}}</span>
										@else
											-
										@endif
									</td>
									<td  class="text-center">
											@if($item->barcode==null)
											<span>barcode not genarated</span>
											@else
											<i style="font-size: 9px;width: 100%;" class="text-center">{{$item->inventory_no}}</i><br>
	                                        <?php echo DNS1D::getBarcodeSVG($item->inventory_no, $item->barcode->barcodetype->name,0.6,30) ?> <br>
											<i style="font-size: 9px;width: 100%;" class="text-center">{{$item->asset_no}}</i>
											{{--<img src="data:image/png,{{DNS1D::getBarcodePNG($item->asset_no, $item->barcode->barcodetype->name)}}" alt="barcode"   />--}}
										    @endif
									</td>
									<td>
										@if(Sentinel::hasAnyAccess(['barcode.print', 'admin']))
											{{--<a @if($item->barcode==null) disabled @endif href="{{url('barcode/print/')}}/{{$item->id}}" class="btn  btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="View Item">print</a>--}}
										@else
											{{--<a href="#" class="disabled btn-actions" data-toggle="tooltip" data-placement="top" title="View Disabled"><i class="fa fa-pencil"></i></a>--}}
										@endif
											@if(Sentinel::hasAnyAccess(['barcode.genarate', 'admin']))
											{{--<a @if($item->barcode!=null) disabled @endif  class="btn  btn-default btn-xs btn-gen" data-id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="View Item" >genarate</a>--}}
										@else
{{--											<a href="#" class="disabled btn-actions" data-toggle="tooltip" data-placement="top" title="View Disabled"><i class="fa fa-pencil"></i></a>--}}
										@endif
									</td>
	                                <?php $i++ ?>
							@endforeach
							</tbody>
						</table>
						<div class="row" style="margin-bottom:10px">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
								<button type="submit" class="btn btn-primary" id="btn-save">PRINT</button>
							</div>
						</div>
					</form>


					<?php echo $assets->appends(Input::except('page'))->render()?> <br>

					**NOTE - only the assets in this page will be printed cannot select the paging data
				</div>
			</div>
		</div>
	</div>


@stop
@section('js')
	<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
	<script src="{{asset('assets/sammy_new/vendor/bootstrap3-wysihtml5/dist/bootstrap3-wysihtml5.all.min.js')}}"></script>
	<script src="{{asset('assets/sammy_new/file/bootstrap-fileinput-master/js/fileinput.min.js')}}" type="text/javascript"></script>

	<script type="text/javascript">
        $(document).ready(function(){
            var assets = [];

            $('#checkAll').click(function(){
                $('td input:checkbox',$("#tableLoad")).prop('checked',this.checked);
            });
        });
	</script>
@stop
