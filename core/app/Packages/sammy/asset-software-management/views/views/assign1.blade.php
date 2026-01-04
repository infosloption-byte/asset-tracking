@extends('layouts.sammy_new.master') @section('title','Assign Software')
@section('css')
 <link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/file/bootstrap-fileinput-master/css/fileinput.css')}}"media="all" />
 <link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/vendor/bootstrap3-wysihtml5/dist/bootstrap3-wysihtml5.min.css')}}"/>
 <link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/vendor/bootstrap-datetimepicker/dist/css/bootstrap-datetimepicker.css')}}"/>
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
    	<a href="{{{url('software/license/list')}}}">Software Management</a>
  	</li>
  	<li class="active">Assign Software</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Assign Software License</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<h6 style="font-weight: 800">Asset {{$data->asset_no}} </h6>
							<h6>Name - {{$data->name}} </h6>
							<h6>Manufacture - {{$data->manufacture->name}} </h6>
							<h6>Max Users - {{$data->max_users}} </h6>

						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
							<h6>License  From - {{$data->license_from}}</h6>
							<h6>License  To - {{$data->license_to}}</h6>
								Expire In
                                    <?php
                                    $date1 = date("Y-m-d");
									$date2 = $data->license_to;

									$diff = abs(strtotime($date2) - strtotime($date1));

									$years = floor($diff / (365*60*60*24));
									$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
									$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

									printf("%d years, %d months, %d days\n", $years, $months, $days); 
                                    ?>
						</div>
					</div>

					<div class="form-group">
                        <div class="pull-right">
                            <button type="button" class="btn btn-warning pull-right upload" style="margin-bottom: 5px"><i class="fa fa-plus"></i> Add Asset</button>
                        </div>
                    </div>
                    {!! Form::open(['method'=>'POST','name'=>'upload_form','id'=>'upload_form','url' => [''],'style' => 'display:inline','enctype'=>'multipart/form-data']) !!}
						<table class="table table-bordered table-hover" id="tableIn" name="tableIn" style="margin-top: 30px">
							<thead style="background-color: #747177;color: #fff">
							<tr>
								<th>Serial No</th>
								<th style="width: 20%">Inventory No</th>
								<th>Reference No</th>
								<th style="width: 30%">Note</th>
								<th style="width: 5%">Actions</th>
							</tr>
							</thead>
							<tbody id="tbody">
								@if($data->details->count()>0)
									@foreach($data->details as $item)
										<tr>
											<td>{{$item->asset->asset_no}}</td>
											<td>{{$item->asset->inventory_no}}</td>
											<td>{{$item->reference_no}}</td>
											<td>{{$item->note}}</td>
											<td>
												<button type="button" class="btn btn-default btn-xs btn-delete exist-row" data-id="{{$item->id}}">Delete</button>
											</td>
										</tr>
									@endforeach							
								@endif
							</tbody>
						</table>

						<div class="form-group">
	                        <div class="pull-right">
	                            <button type="submit" class="btn btn-primary pull-right save"><i class="fa fa-floppy-o"></i> Save</button>
	                        </div>
	                    </div>
	                {!! Form::close() !!}
            	</form>
          	</div>
        </div>
	</div>
</div>

<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 1000px">
        <div class="modal-content" style="width: 1000px">            
            <div class="modal-header">              
                <center><h4>Asset Details</h4></center>
            </div>            
            <div class="modal-body" style="height: 500px !important;width: 1000px">
                {!! Form::open(['method'=>'POST','name'=>'save_form','id'=>'save_form','url' => [''],'style' => 'display:inline','enctype'=>'multipart/form-data']) !!}
                    <div class="row">
                        <div class="form-group">		            		
		            		<label class="col-sm-1 control-label required">Location</label>
		            		<div class="col-sm-4">
		            			{!! Form::select('location',$location, Input::old('location'),['class'=>'chosen oops','id'=>'location','style'=>'width:100%;','required','data-placeholder'=>'Choose Location']) !!}
		            		</div>

		            		<label class="col-sm-2 control-label required" style="text-align: right">Asset Modal</label>
		            		<div class="col-sm-3">
		            			{!! Form::select('modal',$modal, Input::old('modal'),['class'=>'chosen oops','id'=>'modal','style'=>'width:100%;','required','data-placeholder'=>'Choose request modal']) !!}
		            		</div>
		            		<div class="col-sm-2">
		            			<button type="button" class="btn btn-danger pull-right search"><i class="fa fa-search"></i> Search</button>
		            		</div>
		            	</div>
		            </div>

                    <div class="row" style="margin-top: 30px">

                    	<div class="col-sm-11" style="height: 350px; overflow: overlay; padding-left: 10px; width: 100%;">
			            	<table class="table table-bordered table-hover">
								<thead style="background-color: #747177;color: #fff">
									<tr>
										<th><input type="checkbox" name="checkAll" id="checkAll"></th>
										<th>Serial No</th>
										<th>Inventory No</th>
										<th>Manual No</th>
										<th>Category</th>
										<th>Manufacturer</th>
										<th>Model</th>
									</tr>
								</thead>
								<tbody id="tmp_tbody">
									
								</tbody>
							</table>
						</div>
                    </div>

                    <div class="row" style="margin-top: 5px">
                    	<div class="pull-right">
		                	<button type="button" class="btn btn-primary" onclick="check()"><i class="fa fa-plus"></i> Add</button>
		                </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/bootstrap3-wysihtml5/dist/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script src="{{asset('assets/sammy_new/file/bootstrap-fileinput-master/js/fileinput.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/sammy_new/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/moment/moment.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/bootstrap-datetimepicker/dist/js/bootstrap-datetimepicker.js')}}"></script>


<script type="text/javascript">
	var t=0;

	det = JSON.parse('{!!json_encode($data)!!}');

	max=det.max_users;

	used=det.details.length;

	balance=max-used;

	tmp=1;

	save_table=[];

	$.each(det.details,function(key,value){
		save_table.push(value.asset_id);
	});

	$(document).ready(function(){

		$('.form-validation').validate();

        $('.upload').on('click',function(){
            $('#uploadModal').modal();
        });

		$('.search').on('click', function(e){

			modal 	= $('#modal').val();
			loc 	= $('#location').val();

			$('.panel').addClass('panel-refreshing');
			$('#tmp_tbody').html('');
			$.ajax({
                url: "{{url('software/license/getAsset')}}/"+det.id ,
                type: 'GET',
                data: { 'modal': modal,'loc':loc },
                success: function(data) {
                    
                    i=1;

	                $.each(data,function(key,value){

	                    $('#tmp_tbody').append(
	                    	'<tr>'
								+'<td><input type="checkbox" data-id="'+value.id+'" data-asset="'+value.asset_no+'" data-inv="'+value.inventory_no+'"></td>'
								+'<td>'+value.asset_no+'</td>'
								+'<td>'+value.inventory_no+'</td>'
								+'<td>'+value.manual_no+'</td>'
								+'<td>'+value.assetmodel.name+'</td>'
								+'<td>'+value.manufacturer.name+'</td>'
								+'<td>'+value.model+'</td>'
							+'</tr>'
	                    );
	                    i++;
	                });

	                $('.panel').removeClass('panel-refreshing');
                },
                error: function(xhr, textStatus, thrownError) {
                    console.log(thrownError);
                }
            });
		});

		$('#checkAll').click(function(){
            $('input[type="checkbox"]',$("#tmp_tbody")).prop('checked',this.checked);
        });

        $("#tableIn").on('click','.temp-row',function () {
            $(this).closest ('tr').remove ();

            var index = save_table.indexOf($(this).data('id'));
			save_table.splice(index, 1);

			tmp--;

        });

        $("#tableIn").on('click','.exist-row',function () {
        	$('.refresh').addClass('panel-refreshing');
            ajaxRequest( '{{url('software/license/unassign')}}' , { 'id' : $(this).data('id')}, 'post', resultFuncActivate);
            $(this).closest ('tr').remove ();
        });

	});

	function resultFuncActivate(data){
        $('.refresh').removeClass('panel-refreshing');
        if(data.status=='success'){
            swal('Success','Successfully License removed','success');
        }else if(data.status=='invalid_id'){
            swal('Error!','Cannot find valid license','error');
        }else if(data.status=='not_ajax'){
            swal('Error!','Try Again','error');
        }
    }
	
	function check()
	{
		$('#tmp_tbody').find('input[type="checkbox"]:checked').each(function () {
	    	if(tmp<=balance || balance <= -1){
		        if(!save_table.includes($(this).data('id'))){
		            $('#tableIn').append(
		            	'<tr>'
							+'<td><input type="hidden" name="asset_id[]" id="inputID" value="'+$(this).data('id')+'">'+$(this).data('asset')+'</td>'
							+'<td>'+$(this).data('inv')+'</td>'
							+'<td><input type="text" name="reference_no[]" id="inputID" class="form-control"></td>'
							+'<td><input type="text" name="note[]" id="inputID" class="form-control"></td>'
							+'<td>'
								+'<button type="button" class="btn btn-default btn-xs btn-delete temp-row" data-id="'+$(this).data('id')+'">Delete</button>'
							+'</td>'
						+'</tr>'
		            );

		            save_table.push($(this).data('id'));

		            tmp++;
		        }
	        }else{
	        	swal('Warning','Exceed max license user count. cannot add more than max user count','error');
	        }

        });

    	$('#uploadModal').modal('toggle');

	}

</script>
@stop
