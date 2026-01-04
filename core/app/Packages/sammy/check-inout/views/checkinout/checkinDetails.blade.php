@extends('layouts.sammy_new.master') @section('title','Check-In - Asset')

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
				<table class="table table-bordered " id="tableIn">
					<thead style="background-color: #5e9acc;color: #fff">
						<tr>
							<th width="5%">#</th>
							<th width="5%" style="text-align:center">Check<input type="checkbox" id="checkAllCheckIn"></th>
							<th width="5%" style="text-align:center">Reject<input type="checkbox" id="checkAllReject"></th>
							<th width="25%" style="text-align:center">Reject Reason</th>
							<th>Asset No</th>
							<th>Inventory No</th>
							<th>Model</th>
							<th>Supplier</th>
						</tr>
					</thead>
					<tbody id="tbody">
					<?php $i=1 ?>
					@foreach($note->detailsWithoutUpgrade as $asset)
						<tr>
							<td width="5%">
								{{$i}}
							</td>
							<td style="text-align:center">
								@if($asset->status==0)
									<input type="checkbox" name="checkinBox" id="checkinBox-{{$i}}" data-id="{{$asset->asset_id}}">
								@endif
							</td>
							<td style="text-align:center">
								@if($asset->status==0)
									<input type="checkbox" name="rejectBox" id="rejectBox-{{$i}}" data-id="{{$asset->asset_id}}">
								@endif
							</td>
							<td style="text-align:center">
								@if($asset->status==0)
									<input class="form-control" type="text" name="rejectReason" id="reject_reason_{{$i}}" data-id="{{$asset->asset_id}}"/>
								@elseif($asset->status==2)
									{{$asset->reason}}
								@endif
							</td>
							<td>
								{{$asset->asset->asset_no}}
								@if($asset && $asset->asset->transaction!=null && count($asset->asset->transaction)>0)
									@if($asset->status==2)
										<br><span class="badge" style="background-color: red">{{$asset->asset->transaction[0]->status->name}}</span>
									@elseif($asset->status==1)
										<br><span class="badge" style="background-color: green">{{$asset->asset->transaction[0]->status->name}}</span>
									@else
										<br><span class="badge">{{$asset->asset->transaction[0]->status->name}}</span>
									@endif
								@endif
							</td>
							<td>{{($asset && $asset->asset)?$asset->asset->inventory_no:'-'}}</td>
							<td>{{($asset && $asset->asset)?$asset->asset->assetmodel->name:'-'}}</td>
							<td>
								@if($asset && $asset->asset->supplier)
									{{$asset->asset->supplier->name}} 
								@else 
									- 
								@endif
							</td>
						</tr>
						<?php $i++ ?>
					@endforeach
					</tbody>
				</table>
				<div class="row" style="margin-bottom:10px">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
					@if($checkinPermission)
						<button class="btn btn-primary" id="btnSave">CHECK-IN</button>
						<button class="btn btn-danger" id="btnReject">REJECT</button>
					@else
						<button class="btn btn-primary" id="btnSave" disabled>CHECK-IN</button>
						<button class="btn btn-danger" id="btnReject" disabled>REJECT</button>
					@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop

@section('js')
<script type="text/javascript">
	var t=0;
	$(document).ready(function(){
	    var assets = [];

        $('#checkAllCheckIn').click(function(){
            $('td input[name="checkinBox"]:checkbox',$("#tableIn")).prop('checked',this.checked);
            $('td input[name="rejectBox"]:checkbox',$("#tableIn")).prop('checked',false);
            $('#checkAllReject').prop('checked',false);
        });

        $('#checkAllReject').click(function(){
            $('td input[name="rejectBox"]:checkbox',$("#tableIn")).prop('checked',this.checked);
            $('td input[name="checkinBox"]:checkbox',$("#tableIn")).prop('checked',false);
            $('#checkAllCheckIn').prop('checked',false);
        });

        $('input[name="checkinBox"]:checkbox').click(function(){
        	if(!this.checked){
        		
        		$('#checkAllCheckIn').prop('checked',false);

        	}else{
        		
        		$('#checkAllReject').prop('checked',false);        		

        		$('#rejectBox-'+this.id.split('-')[1]).prop('checked',false);

        		if ($('input[name="checkinBox"]:checked').length == $('input[name="checkinBox"]').length) {

        			$('#checkAllCheckIn').prop('checked',true);

        			$('td input[name="rejectBox"]:checkbox',$("#tableIn")).prop('checked',false);

        		}
        	}
        });

        $('input[name="rejectBox"]:checkbox').click(function(){
        	if(!this.checked){
        		
        		$('#checkAllReject').prop('checked',false);
        		
        	}else{

				$('#reject_reason_'+this.id.split('-')[1]).focus();     		
        		
        		$('#checkAllCheckIn').prop('checked',false);

        		$('#checkinBox-'+this.id.split('-')[1]).prop('checked',false);

        		if ($('input[name="rejectBox"]:checked').length == $('input[name="rejectBox"]').length) {

        			$('#checkAllReject').prop('checked',true);

        			$('td input[name="checkinBox"]:checkbox',$("#tableIn")).prop('checked',false);

        		}
        	}
        });

		$('#btnSave').click(function(){
			var arrayCheckin = [];
			var from_location = $('#from_location').val();
			var to_location = $('#to_location').val();
			var issid = $('#issid').val();

			$('#tableIn').find('input[name="checkinBox"]:checked').each(function () {
		    	if($(this).data('id')!=null && $(this).data('id')>0 && $(this).data('id')!=undefined){
                	arrayCheckin.push($(this).data('id'));
		    	}
            });

			if(arrayCheckin.length>0){
                $(".panel").addClass('panel-refreshing');

                $.ajax({
                    url: "{{url('check-inout/json/check-in')}}",
                    type: 'post',
                    data: {
                        'assets': arrayCheckin,
						"from_location":from_location,
						"to_location":to_location,
						"issid":issid
                    },
                    success: function (data) {
                        $(".panel").removeClass('panel-refreshing');
						if(data.status==1){
                            swal("Success", 'Assets checked-In successfully. GRN created','success');
							location.reload();
						}else if(data.status==2){
							swal("Warning", 'Faild to complete GRN. Try Again.','error');
						}else if(data.status==3){
							swal("Warning", 'Cannot found issue note. Try Again.','error');
						}else if(data.status==4){
							swal("Warning", 'check-In Process Faild. Try Again.','error');
						}else if(data.status==5){
							swal("Warning", 'Faild to complete GRN. Try Again.','error');
						}else if(data.status==6){
							swal("Warning", 'Asset could not Transfer to new location. Try Again','error');
						}else if(data.status==7){
							swal("Warning", 'Asset issued(Check-In) user cannot do check-in same asset.','error');
						}
                    },
                    error: function (xhr, textStatus, thrownError) {
                        console.log(thrownError);
                    }
                });

			}else{
                swal("Really?", 'Are you sure you want to check-in zero assets','warning');
			}
        });

		$('#btnReject').click(function(){
			var arrayReject = [];
			var from_location = $('#from_location').val();
			var to_location = $('#to_location').val();
			var issid = $('#issid').val();

			$('#tableIn').find('input[name="rejectBox"]:checked').each(function () {
		    	if($(this).data('id')!=null && $(this).data('id')>0 && $(this).data('id')!=undefined){
		    		dd={};

		    		dd['id']=$(this).data('id');
		    		dd['reason']=$('#reject_reason_'+this.id.split('-')[1]).val();

                	arrayReject.push(dd);
		    	}
            });

			if(arrayReject.length>0){
                $(".panel").addClass('panel-refreshing');

                $.ajax({
                    url: "{{url('check-inout/json/reject')}}",
                    type: 'post',
                    data: {
                        'assets': arrayReject,
						"from_location":from_location,
						"to_location":to_location,
						"issid":issid
                    },
                    success: function (data) {
                        $(".panel").removeClass('panel-refreshing');
						if(data.status==3){
							swal("Warning", 'Cannot found issue note. Try Again.','error');
						}else if(data.status==4){
							swal("Warning", 'check-In Process Faild. Try Again.','error');
						}else if(data.status==7){
							swal("Warning", 'Asset issued(Check-In) user cannot do check-in same asset.','error');
						}else{
							location.reload();
						}
                    },
                    error: function (xhr, textStatus, thrownError) {
                        console.log(thrownError);
                    }
                });

			}else{
                swal("Really?", 'Are you sure you want to check-in zero assets','warning');
			}
        });
        
	});
</script>
@stop
