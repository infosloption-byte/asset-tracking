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
	</style>
@stop
@section('content')
	<ol class="breadcrumb">
		<li>
			<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
		</li>
		<li class="active">Check-In Asset - Asset Management</li>
	</ol>
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-bordered" id="panel-search">
				<div class="panel-body">
					<div class="form-group col-md-4">
						<label class="control-label">Asset Location</label>
						{!! Form::select('location',[], Input::old('location'),['class'=>'chosen','id'=>'location','style'=>'width:100%;','data-placeholder'=>'Choose Location']) !!}
					</div>
					<div class="form-group col-md-3">
						<label class="control-label">Asset Modal</label>
						{!! Form::select('asset-modal',$asset_modal, Input::old('asset-modal'),['class'=>'chosen','id'=>'asset-modal','style'=>'width:100%;','required','data-placeholder'=>'Choose Asset Modal']) !!}
					</div>
					<div class="form-group col-md-3">
						<label class="control-label">Inv NO</label>
						<input type="text" name="" id="inv_no" class="form-control" value="">
					</div>
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
						<div class="pull-right" style="margin-top:23px">
							<button type="submit" class="btn btn-primary btn-search">
								<i class="fa fa-check"></i> search
							</button>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<hr>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<select name="assets" id="inputAssets" class="form-control" required="required" multiple>

										</select>
									</div>
								</div>
								<div class="row">
									<label></label>
								</div>
								<div class="row">
									<div class="col-md-12 text-right" >
										<button  id='select-all' class="btn btn-info">Select All</button>
										<button  id='deselect-all' class="btn btn-warning">Deselect All</button>
										<button id='btn-add' type="button" class="btn btn-primary" onclick="get_product()"><i class="fa fa-plus"></i> Add</button>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>



	<div class="row">
		<form id="myForm" onsubmit="return validateForm()" role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
			{!!Form::token()!!}
			<div class="col-xs-12">
				<div class="panel panel-bordered">
					<div class="panel-body">
						<div class="row" style="margin-bottom:10px">

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<select name="checkinloc" id="checkinloc" class="form-control chosen" required="required">
									<option value="0">-select check-in location-</option>
									@foreach($locations as $location)
										<option value="{{$location->id}}">{{$location->name}}</option>
									@endforeach
								</select>
								<h6><?php echo date('Y-m-d') ?></h6>
							</div>
							<div class="col-md-6 pull-right text-right">
								<img src="{{url('/assets/sammy_new/images/rdb.jpg')}}" width="15%">
								<h4 style="font-weight: bold">ISSUE NOTE</h4>
								<p>Asset Transfer Note</p>
							</div>
						</div>
						<table class="table table-bordered table-hover" id="tableLoad">
							<thead style="background-color: #5e9acc;color: #fff">
							<tr>
								<th width="5%">#</th>
								<th>Asset No</th>
								<th>Account Code</th>
								<th>Model</th>
								<th>Supplier</th>
							</tr>
							</thead>
							<tbody id="tbody">
                            <?php $i=1 ?>
							@foreach($assets as $asset)
								<tr>
									<td width="5%">
										<input type='hidden' name='assets[]' value='{{$asset->id}}'>{{$i}}
									</td>
									<td>{{$asset->asset_no}}</td>
									<td>{{$asset->account_code}}</td>
									<td>{{$asset->assetmodel->name}}</td>
									<td>{{$asset->supplier->name}}</td>
								</tr>
							@endforeach

							</tbody>
						</table>
						<div class="row" style="margin-bottom:10px">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
								<button type="submit" class="btn btn-primary">SAVE</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>


@stop
@section('js')
	<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
	<script src="{{asset('assets/sammy_new/vendor/bootstrap3-wysihtml5/dist/bootstrap3-wysihtml5.all.min.js')}}"></script>
	<script src="{{asset('assets/sammy_new/file/bootstrap-fileinput-master/js/fileinput.min.js')}}" type="text/javascript"></script>

	<script type="text/javascript">
        $(document).ready(function(){
			var assets = [];

			$("#panel-search").addClass('panel-refreshing');

			$('#inputAssets').multiSelect();

			$('#select-all').click(function(){
				$('#inputAssets').multiSelect('select_all');
				return false;
			});

			$('#deselect-all').click(function(){
				$('#inputAssets').multiSelect('deselect_all');
				return false;
			});

			$.ajax({
				url: "{{url('location/get-location')}}",
				type: 'GET',
				data: {'allCat': 'allCat' },
				success: function (data) {
					$("#location").html("").append('<option value="0">ALL</option>');
					$.each(data, function (index, value) {
						$("#location").append(value);

					});
					$("#location").trigger("chosen:updated");
					$("#panel-search").removeClass('panel-refreshing');
				},
				error: function (xhr, textStatus, thrownError) {
					console.log(thrownError);
				}
			});

			$('#panel-search').on('click','.btn-search',function(){
				$("#panel-search").addClass('panel-refreshing');
				var location = $("#location").val();
				var model = $("#asset-modal").val();
				var inv_no = $("#inv_no").val();

				$.ajax({
					url: "{{url('check-inout/json/get-assets')}}",
					type: 'GET',
					data: {'location': location,'model': model,'inv_no': inv_no},
					success: function (data) {
						$('#inputAssets').empty();
						$('#inputAssets').multiSelect('refresh');
						$.each( data.data, function( key, value ) {

							$('#inputAssets').append('<option value="'+value.id+'">#'+value.asset_no+value.id+" - "+value.assetmodel.name+' ('+value.location+')'+'</option>');
							$('#inputAssets').multiSelect('refresh');
						});

						$("#panel-search").removeClass('panel-refreshing');
					},
					error: function (xhr, textStatus, thrownError) {
						$("#panel-search").removeClass('panel-refreshing');
						console.log(thrownError);
					}
				});
			});

			$('#btn-add').click(function(){
				$.ajax({
					url: "{{url('check-inout/json/load-assets')}}",
					type: 'POST',
					data: {'assets': $('#inputAssets').val()},
					success: function (data) {
						var html = "";
						var i = 1;
						$.each( data.data, function( key, value ) {
							if(assets[value.id]==null){
								assets[value.id] = value;
								html += "<tr>";
								html += "<td><input type='hidden' name='assets[]' value='"+value.id+"'>"+i+"</td>";
								html += "<td>"+value.asset_no+"</td>";
								html += "<td>"+value.account_code+"</td>";
								html += "<td>"+value.assetmodel.name+"</td>";
								html += "<td>"+value.supplier.name+"</td>";
								html += "</tr>";
								i++;
							}
						});
						$('#tbody').append(html);
						$("#panel-search").removeClass('panel-refreshing');
					},
					error: function (xhr, textStatus, thrownError) {
						$("#panel-search").removeClass('panel-refreshing');
						console.log(thrownError);
					}
				});

			});
        });



        function validateForm() {
            var loc = $('#checkinloc').val();
            if (loc == 0) {
                swal("Oopz!", 'Please select check-out location where the assetes need to be transfer','error');
                return false;
            }
        }

	</script>
@stop
