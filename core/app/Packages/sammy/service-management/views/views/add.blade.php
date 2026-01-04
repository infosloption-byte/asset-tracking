@extends('layouts.sammy_new.master') @section('title','Add Service')
@section('css')
	<link rel="stylesheet" href="{{asset('assets/sammy_new/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}">
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
	</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li>
    	<a href="{{URL::to('service/list')}}">Service List</a>
  	</li>
  	<li class="active">Add Service</li>
</ol>

<div class="row">
	<div class="col-xs-12">
		<form role="form" class=" form-validation" method="get" enctype="multipart/form-data">
			<div class="panel panel-bordered" id="panel-search">
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-3">
							<label class="control-label">Asset Modal</label>
							{!! Form::select('asset_modal',$asset_modal, $old['modal'],['class'=>'chosen','id'=>'asset_modal','style'=>'width:100%;','required','data-placeholder'=>'Choose Asset Modal']) !!}
						</div>
						<div class="form-group col-md-3">
							<label class="control-label">Asset Location</label>
							<select name="location" id="location" class="form-control chosen" required="required">
								<option value="0">-select location-</option>
								@foreach($locations as $location)
									<option value="{{$location->id}}">{{$location->name}}</option>
									@foreach($location->children as $children)
										<option value="{{$children->id}}">{{$children->name}}</option>
									@endforeach
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-3">
							<label class="control-label">Serial No</label>
							<input type="text" name="serial_no" id="serial_no" class="form-control" placeholder="Search by serial no" value="{{$old['serial_no']}}">
						</div>
						<div class="form-group col-md-3">
							<label class="control-label">Inv NO</label>
							<input type="text" name="inv_no" id="inv_no" class="form-control" placeholder="Search by inv no" value="{{$old['inventory']}}">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-3">
							<label class="control-label">Date From</label>
							<input type="text" name="date_from" id="date_from" class="form-control" placeholder="Select Date" value="{{$old['date_from']}}">
						</div>
						<div class="form-group col-md-3">
							<label class="control-label">Date To</label>
							<input type="text" name="date_to" id="date_to" class="form-control" placeholder="Select Date" value="{{$old['date_to']}}">
						</div>

						<div class="form-group col-md-6">
							<div class="pull-right" style="margin-top: 23px">
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
      		<div class="panel-heading border" >
        		<strong>Add Service</strong>
      		</div>
          	<div class="panel-body">
				<table class="table table-bordered table-hover" id="tableIn">
					<thead style="background-color: #747177;color: #fff">
					<tr>
						<th width="5%">#</th>
						<th>Asset No</th>
						<th>Inventory_no No</th>
						<th>Account Code</th>
						<th>Model</th>
						<th>Supplier</th>
						<th width="10%">Actions</th>
					</tr>
					</thead>
					<tbody id="tbody">
                    <?php $i=1 ?>
					@foreach($assets as $asset)
						<tr>
							<td width="5%">{{$i}}</td>
							<td>{{$asset->asset_no}}</td>
							<td>{{$asset->inventory_no}}</td>
							<td>{{$asset->account_code}}</td>
							<td>{{$asset->assetmodel->name}}</td>
							<td>{{$asset->supplier->name}}</td>
							<td>
								@if($asset->transaction[0]->status_id!=5)
								<button data-toggle="modal" href="#modal-id" type="submit" class="btn btn-default btn-xs btn-addservice" data-id="{{$asset->id}}">Add Service</button>
								@else
									In-Service
								@endif
							</td>
						</tr>
                        <?php $i++ ?>
					@endforeach

					</tbody>
				</table>
          	</div>
        </div>
	</div>
</div>


<div class="modal fade" id="modal-id">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Service</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<label for="" class="required">Service</label>
									{!! Form::select('type',$types, [],['class'=>'form-control','style'=>'width:100%;','required','id'=>'type']) !!}
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<label for="" class="required">Service Cost</label>
									<input class="form-control" type="text" name="cost" id="cost" />
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<label for="" class="required">Service Date</label>
									<div class='input-group date' id='completed_datedatetimepicker'>
										<input type='text' id="service_date" name="service_date" class="form-control" />
										<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									</div>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label for="" class="required">Serviced By</label>
									<input class="form-control" type="text" name="serviced_by" 
									id="serviced_by" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group">
									<label for="">Notes</label>
									<textarea class="form-control" type="text" name="notes" id="notes" ></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="btn-save">Add Service</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/moment/moment.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/bootstrap-datetimepicker/dist/js/bootstrap-datetimepicker.js')}}"></script>

<script type="text/javascript">
	$(document).ready(function(){
        var asset_id=0;

		$('.form-validation').validate();
		$('#permissions').multiSelect();

		$("#date_from").datepicker({format:'yyyy-mm-dd'});
		$("#date_to").datepicker({format:'yyyy-mm-dd'});

		$("#completed_datedatetimepicker").datetimepicker({format:'YYYY-MM-DD'});
		$("#next_datedatetimepicker").datetimepicker({format:'YYYY-MM-DD'});


        $('#btn-save').click(function(){
			if(asset_id>0){
                $(".fade").addClass('panel-refreshing');
                $.ajax({
                    url: "{{url('service/add')}}",
                    type: 'post',
                    data: {
						'asset': asset_id,
						'type': $('#type').val(),
						'cost': $('#cost').val(),
						'serviced_by': $('#serviced_by').val(),
						'service_date': $('#service_date').val(),
						'notes': $('#notes').val()
                    },
                    success: function (data) {
                    	$(".fade").removeClass('panel-refreshing');
                        if(data.status>0){
                            sweetAlert("Success", 'Service added',1);
                            location.reload();
                        }else{
                            sweetAlert("Error", 'Something happend while processing',2);
                        }
                        $(".panel").removeClass('panel-refreshing');
                    },
                    error: function (xhr, textStatus, thrownError) {
                        console.log(thrownError);
                    }
                });
			}
    	});

        $('.btn-addservice').click(function(){
            asset_id = $(this).data('id');
    	});

	});
</script>
@stop
