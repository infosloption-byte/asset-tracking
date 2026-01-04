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
		<li>Asset</li>
		<li class="active">Check-Out</li>
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
									@foreach($locations as $key=>$location)
										<option value="{{$key}}" @if($key==$location_id) selected @endif>{{$location}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Inv NO</label>
								<input type="text" name="no" id="inv_no" class="form-control" value="">
							</div>
							<div class="col-xs-4 col-sm-4 col-md-2 col-lg-4">
								<div class="pull-right" style="margin-top:23px">
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
					<div class="row" style="margin-bottom:10px">

						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<select name="checkinloc" id="checkinloc" class="form-control chosen" required="required">
								@foreach($checkin_location as $key=>$location)
									<option value="{{$key}}">{{$location}}</option>
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
							<th width="5%"><input type="checkbox" value="" id="checkAll"></th>
							<th width="5%">#</th>
							<th>Asset No</th>
							<th>Inventory No</th>
							<th>Location</th>
							<th>Account Code</th>
							<th>Model</th>
							<th>Supplier</th>
						</tr>
						</thead>
						<tbody id="tbody">
						<?php $i=1 ?>
						@foreach($assets as $asset)
							<tr>
								<td><input type="checkbox" data-id="{{$asset->id}}"></td>
								<td width="5%">
									<input type='hidden' name='assets[]' value='{{$asset->id}}'>
									{{$i}}
								</td>
								<td>
									{{$asset->asset_no}}
								</td>
								<td>
									{{$asset->inventory_no!=null?$asset->inventory_no:'-'}}
								</td>
								<td>
									{{$asset->location}}
								</td>
								<td>{{$asset->account_code}}</td>
								<td>{{$asset->assetmodel->name}}</td>
								<td>{{($asset->supplier)?$asset->supplier->name:'-'}}</td>
							</tr>
							<?php $i++ ?>
						@endforeach
						</tbody>
					</table>
					<div class="row" style="margin-bottom:10px">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
							<button class="btn btn-primary" id="btn-save">SAVE</button>
						</div>
					</div>
					<i style="font-size:9px">Note * You can only move one location assets to another Issue note canot be mixed with assets in deferent locations 
					<br>Assets with inventory no can not be moved and will not load to this view</i>
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

        	$("#location,checkinloc").chosen({
			    search_contains: true,
			});

			var assets = [];

            $('#checkAll').click(function(){
                $('td input:checkbox',$("#tableLoad")).prop('checked',this.checked);
            });

            $('#btn-save').click(function(){
				var array = [];
                var checkinloc = $('#checkinloc').val();
                $('#tableLoad').find('input[type="checkbox"]:checked').each(function () {
                    if($(this).data('id')!=null && $(this).data('id')>0 && $(this).data('id')!=undefined){
	                	array.push($(this).data('id'));
			    	}
                });
				if(checkinloc>0){
					if(array.length>0){
						//ajax
						$(".panel").addClass('panel-refreshing');

						$.ajax({
							url: "{{url('check-inout/checkout')}}",
							type: 'post',
							data: {
								'assets': array,
								"checkinloc":checkinloc,
								'asset_loc': $('#location').val()
							},
							success: function (data) {
								// console.log(data);
								if(data.status==1){
									swal("Success", 'all assets check-out successfully Issue Note saved , view GRN list','success');
									location.reload();
								}else if(data.status==2){
									swal("Error", 'You have no permission to Check-Out','error');
								}else{
									swal("Error", 'Something happend while processing','error');									
								}
								$(".panel").removeClass('panel-refreshing');
							},
							error: function (xhr, textStatus, thrownError) {
								console.log(thrownError);
							}
						});

					}else{
						//show error
						swal("Really?", 'Cannt create a issue note to zero assets','warning');
					}
                }else{
                    swal("Really?", 'Please select check-out location where you want to transfer the assets','warning');
				}
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
