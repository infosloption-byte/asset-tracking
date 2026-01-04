@extends('layouts.sammy_new.master') @section('title','Software Detail')
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
  	<li class="active">Software License Detail</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Software License Detail</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}

					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<h6 style="font-weight: 800">Asset {{$data->asset_no}} </h6>
							<h6>Name - {{$data->name}} </h6>
							<h6>Manufacture - {{$data->manufacture->name}} </h6>
							<h6>Max Users - {{$data->max_users>0?$data->max_users:"UNLIMITED"}} </h6>
							@if($data->details!=null)
								<h6>Installed Users - {{$data->details->count()}} </h6>
							@endif
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
							<h6>License  From - {{$data->license_from}}</h6>
							<h6>
								@if($data->license_to != null)
								License  To - {{$data->license_to}}
								@else
								NO EXPIRY
								@endif
							</h6>
							<span class="badge" style="background-color: #00acd6">
								@if($data->license_to != null)
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
								@else
									NO EXPIRY
								@endif
							</span>
						</div>
					</div>


					<table class="table table-bordered table-hover" id="tableIn" style="margin-top: 30px">
						<thead style="background-color: #747177;color: #fff">
						<tr>
							<th>Reference No</th>
							<th>Location</th>
							<th>Mac Address</th>
							<th>IP Address</th>
						</tr>
						</thead>
						<tbody id="tbody">
							@foreach($data->details as $item)
								<tr>
									<td>{{$item->reference_no}}</td>
									<td>{{$item['asset']['transaction'][0]['location']->name}}</td>
									<td>{{$item->mac_address}}</td>
									<td>{{$item->note}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
            	</form>
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
	$(document).ready(function(){
		var max_users = <?php echo $data->max_users?>;

		$('.form-validation').validate();

        $("#from").datetimepicker({format:'YYYY-MM-DD'});
        $("#to").datetimepicker({format:'YYYY-MM-DD'});

		$('#unlimited').click(function () {
			var aa = $(this).val();
			if($(this).is(':checked'))
                $("#users").attr('disabled',true);  // checked
            else
                $("#users").attr('disabled',false);

        });

		$("#tableIn").on('click','.btn-add',function () {
            if($('#tableIn tr').length-1==max_users){
                sweetAlert('Exceed', 'Max License count is exceded?',2);
            }else{
                var elm = getRow();
                $("#tbody").append(elm);
            }
        });

		$("#tableIn").on('click','.btn-delete',function () {
            $(this).closest ('tr').remove ();
        });



	});

	function getRow() {
		var html='';
		html += '<tr>';
        html += '<td><input type="text" name="mac_address[]" id="inputID" class="form-control"></td>';
        html += '<td><input type="text" name="reference_no[]" id="inputID" class="form-control"></td>';
        html += '<td><input type="text" name="note[]" id="inputID" class="form-control"></td>';
        html += '<td>';
        html += '<button type="button" class="btn btn-default btn-xs btn-add">Add</button>';
        html += '<button type="button" class="btn btn-default btn-xs btn-delete">Delete</button>';
        html += '</td>';
        html += '</tr>';
        return html;
    }


</script>
@stop
