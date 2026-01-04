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
		<div class="panel panel-bordered">
			<div class="panel-body">
				<div class="row" style="margin-bottom:10px">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<p style="margin: 0">No : {{$note->issue_note_no}}</p>
						<p style="margin: 0">Date : {{$note->created_at->format('Y-m-d')}}</p>
						<p style="margin: 0">From : {{$note->fromlocation->name}}</p>
						<p style="margin: 0">To : {{$note->tolocation->name}}</p>

						<input type='hidden' id='from_location' value='{{$note->fromlocation->id}}'>
						<input type='hidden' id='to_location' value='{{$note->tolocation->id}}'>
						<input type='hidden' id='issid' value='{{$note->id}}'>
					</div>
					<div class="col-md-6 pull-right text-right">
						<img src="{{url('/assets/sammy_new/images/rdb.jpg')}}" width="15%">
						<h4 style="font-weight: bold">ISSUE NOTE</h4>
						<p>Asset Transfer Note</p>
					</div>
				</div>
				<table class="table table-bordered table-hover" id="tableIn">
					<thead style="background-color: #5e9acc;color: #fff">
						<tr>
							<th width="5%">#</th>
							<th>Asset No</th>
							<th>Inventory No</th>
							<th>Model</th>
							<th>Supplier</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody id="tbody">
					@foreach($note->details as $key=>$asset)
						<tr>
							<td>
								{{$key+1}}
							</td>
							<td>
								{{$asset->asset->asset_no}}								
							</td>
							<td>{{$asset->asset->inventory_no}}</td>
							<td>{{$asset->asset->assetmodel->name}}</td>
							<td>{{$asset->asset->supplier->name}}</td>
							<td>
								@if($asset->status==1)
									<span class="badge" style="background-color: green">Checked</span>
								@elseif($asset->status==2)
									<span class="badge" style="background-color: red">Rejected</span>
									<br>
									{{$asset->reason}}
								@else
									<span class="badge">Rejected</span>
								@endif
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
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
	var t=0;
	$(document).ready(function(){
	    var assets = [];

        $('#checkAll').click(function(){
            $('td input:checkbox',$("#tableIn")).prop('checked',this.checked);
        });

		$('#btnSave').click(function(){
			var array = [];
			var from_location = $('#from_location').val();
			var to_location = $('#to_location').val();
			var issid = $('#issid').val();

		    $('#tableIn').find('input[type="checkbox"]:checked').each(function () {
                array.push($(this).data('id'));
            });
		    console.log(array);
			if(array.length>0){
			    //ajax
                $("#panel-search").addClass('panel-refreshing');

                $.ajax({
                    url: "{{url('check-inout/json/check-in')}}",
                    type: 'post',
                    data: {
                        'assets': array,
						"from_location":from_location,
						"to_location":to_location,
						"issid":issid
                    },
                    success: function (data) {
						// if(data.status>0){
      //                       sweetAlert("Success", 'all assets check-in successfully GRN created , view GRN list',1);
						// 	location.reload();
						// }
      //                   $("#panel-search").removeClass('panel-refreshing');
                    },
                    error: function (xhr, textStatus, thrownError) {
                        console.log(thrownError);
                    }
                });

			}else{
			    //show error
                sweetAlert("Really?", 'Are you sure you want to check-in zero assets',2);
			}
        });







	});
</script>
@stop
