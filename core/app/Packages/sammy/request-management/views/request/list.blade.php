@extends('layouts.sammy_new.master') @section('title','Request List')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/vendor/bootstrap-datetimepicker/dist/css/bootstrap-datetimepicker.css')}}"/>
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

.datatable a.blue {
    color: #1975D1;
}

.datatable a.blue:hover {
    color: #003366;
}

.modal-dialog {
	margin-top: 15%;
}

.modal-body {
	padding: 30px;
}

tr.header{
    cursor:pointer;
}
</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li>
    	<a href="javascript:;">Request Management</a>
  	</li>
  	<li class="active">Request List</li>
</ol>
<form role="form" class="form-validation" method="get">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-bordered" id="panel-search">
                
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Request Type</label>
                                <select name="type" id="type" class="form-control chosen">
                                    @foreach($typeList as $key=>$type)
                                        <option value="{{$key}}" @if($key==$old['type']) selected @endif>{{$type}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Request Status</label>
                                <select name="status" id="status" class="form-control chosen">
                                    @foreach($statusList as $key=>$status)
                                        <option value="{{$key}}" @if($key==$old['status']) selected @endif>{{$status}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2" style="text-align: center">
                                <label class="control-label">From Date</label>
                                <div class='input-group date' id='completed_datedatetimepicker'>
                                    <input type='text' id="from_date" name="from_date" class="form-control" style="text-align: center" value="{{$old['from_date']}}"/>
                                    <span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
                                </div>
                            </div>

                            <div class="form-group col-md-2" style="text-align: center">
                                <label class="control-label">To Date</label>
                                <div class='input-group date' id='completed_datedatetimepicker'>
                                    <input type='text' id="to_date" name="to_date" class="form-control" style="text-align: center" value="{{$old['to_date']}}"/>
                                    <span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12" style="margin: 0px;padding-top: 1.25%">
                                <div class="pull-right" style="margin-top:8px">
                                    <button type="submit" class="btn btn-primary btn-search">
                                        <i class="fa fa-check"></i> search
                                    </button>
                                </div>

                                <a style="margin-top:8px;margin-right:8px" class="btn btn-success pull-right" href="{{URL::to("request/add")}}"  style="margin-right: 10px">
                                    <i class="fa fa-plus" style="width: 28px;"></i>Add
                                </a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="row">
    	<div class="col-xs-12">
    		<div class="panel panel-bordered">
                <div class="panel-body" style="overflow-x:scroll;margin: 1px !important">
                    <table class="table table-bordered">
                        <thead style="background:#ddd">
                            <th class="text-center" width="4%">#</th>
                            <th class="text-center">Requested By</th>
                            <th class="text-center">Requested Date</th>
                            <th class="text-center">Location</th>
                            <th class="text-center">Request Type</th>
                            <th class="text-center">Remark</th>
                            <th class="text-center">Request Status</th>
                            <th class="text-center">Asset Modal</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Approved Qty</th>
                            <th class="text-center">Serial No</th>
                            <th colspan="2" class="text-center">Action</th>
                        </thead>
                        <tbody>
                            @foreach($data as $key=>$detail)
                                <tr class="header" data-color="#fee0e0">
                                    <td>{{$key+1}}</td>
                                    <td>{{$detail->employee->first_name}} {{$detail->employee->last_name}}</td>
                                    <td class="text-center">
                                        {{$detail->created_at->format('j M Y')}}
                                        <br>
                                        {{ $detail->created_at->diffForHumans() }}
                                    </td>

                                    <td>@if($detail->employee->Location){{$detail->employee->Location->location->name}}@else - @endif</td>
                                    <td>{{$detail->requestType->name}}</td>
                                    <td>{{$detail->remark}}</td>
                                    <?php $tmp=""; ?>

                                    @if($detail->requestStatus->name=="Pending")
                                        <?php $tmp="<td class='text-center'><label class='badge label-warning'>{$detail->requestStatus->name}</label></td>"; ?>
                                    @elseif($detail->requestStatus->name=="Approved")
                                        <?php $tmp="<td class='text-center'><label class='badge label-success'>{$detail->requestStatus->name}</label>"; ?>
                                        @if($detail->detail)
                                            <?php $tmp.= "<br/>".$detail->detail->reason."</td>"; ?>
                                        @endif
                                    @elseif($detail->requestStatus->name=="Rejected")
                                        <?php $tmp="<td class='text-center'><label class='badge label-danger'>{$detail->requestStatus->name}</label>"; ?>
                                        @if($detail->detail)
                                           <?php $tmp.= "<br/>".$detail->detail->reason."</td>"; ?>
                                        @endif
                                    @elseif($detail->requestStatus->name=="Service")
                                        <?php $tmp="<td class='text-center'><label class='badge label-info'>{$detail->requestStatus->name}</label></td>"; ?>
                                    @endif

                                    <?php echo $tmp; ?>

                                    <td>{{$detail->requestModal->name}}</td>

                                    @if($detail->asset != NULL)
                                        <td class="text-right"> - </td>
                                        <td class="text-right"> - </td>
                                        <td>{{$detail->asset->asset_no}}</td>
                                    @else
                                        <td class="text-right">{{$detail->quantity}}</td>
                                        <td class="text-right">@if($detail->approved_quantity != NULL){{$detail->approved_quantity}}@else - @endif</td>
                                        <input type="hidden" value="{{$detail->quantity}}" name="hidden_quantity_{{$detail->id}}" id="hidden_quantity_{{$detail->id}}">
                                        <td> - </td>
                                    @endif

                                    @if($detail->requestStatus->name=="Pending")
                                        @if(Sentinel::hasAnyAccess(['request.approve','admin']))
                                            @if($detail->employee->id!=$logged &&
                            $detail->employeeApproveLatest->approved_location_id == $logged_employee->employee_location->location_id)
                                                <td class="text-center">
                                                    <a class="btn btn-default btn-xs request-approve" data-toggle="modal" data-target="#myModal" data-toggle="tooltip" data-placement="top" data-id="{{$detail->id}}" data-type="{{$detail->requestType->id}}" {{--onclick="approveFunc({{$detail->id}},{{$detail->requestType->id}})"--}} title="Approve"><i class="fa fa-check"></i> Approve
                                                    </a>
                                                </td>
                                            @elseif($detail->employee->id!=$logged && $detail->employeeApproveLatest->approved_employee_id == $logged)
                                                <td class="text-center">
                                                    <a class="btn btn-default btn-xs request-approve" data-toggle="modal" data-target="#myModal" data-toggle="tooltip" data-placement="top" data-id="{{$detail->id}}" data-type="{{$detail->requestType->id}}" {{--onclick="approveFunc({{$detail->id}},{{$detail->requestType->id}})"--}} title="Approve"><i class="fa fa-check"></i> Approve
                                                    </a>
                                                </td>
                                            @else
                                                <td class="text-center">
                                                    <a class="btn btn-default btn-xs request-approve disabled" data-toggle="modal" data-target="#myModal" data-toggle="tooltip" data-placement="top" data-id="{{$detail->id}}" data-type="{{$detail->requestType->id}}" {{--onclick="approveFunc({{$detail->id}},{{$detail->requestType->id}})"--}} title="Approve"><i class="fa fa-check"></i> Approve
                                                    </a>
                                                </td>
                                            @endif
                                        @else
                                            <td class="text-center">
                                                <a class="btn btn-default btn-xs request-approve disabled" data-toggle="modal" data-target="#myModal" data-toggle="tooltip" data-placement="top" data-id="{{$detail->id}}" data-type="{{$detail->requestType->id}}" {{--onclick="approveFunc({{$detail->id}},{{$detail->requestType->id}})"--}} title="Approve"><i class="fa fa-check"></i> Approve
                                                </a>
                                            </td>
                                        @endif
                                    @else
                                        <td class="text-center">
                                            <a class="btn btn-default btn-xs request-approve disabled" data-toggle="modal" data-target="#myModal" data-toggle="tooltip" data-placement="top" data-id="{{$detail->id}}" data-type="{{$detail->requestType->id}}" {{--onclick="approveFunc({{$detail->id}},{{$detail->requestType->id}})"--}} title="Approve"><i class="fa fa-check"></i> Approve
                                            </a>
                                        </td>
                                    @endif

                                    @if($detail->requestStatus->name=="Pending")
                                        @if($detail->employee->id!=$logged &&
                            $detail->employeeApproveLatest->approved_location_id == $logged_employee->employee_location->location_id)
                                            <td class="text-center">
                                                <a class="btn btn-default btn-xs request-reject" data-toggle="modal" data-target="#myModalReject" data-toggle="tooltip" data-placement="top" data-id="{{$detail->id}}" {{--onclick="rejectFunc({{$detail->id}})"--}} title="Reject"><i class="fa fa-trash-o"></i> Reject
                                                </a>
                                            </td>
                                        @elseif(Sentinel::hasAnyAccess(['request.reject','admin']) && $detail->employeeApproveLatest->approved_employee_id == $logged)
                                            <td class="text-center">
                                                <a class="btn btn-default btn-xs request-reject" data-toggle="modal" data-target="#myModalReject" data-toggle="tooltip" data-placement="top" data-id="{{$detail->id}}" {{--onclick="rejectFunc({{$detail->id}})"--}} title="Reject"><i class="fa fa-trash-o"></i> Reject
                                                </a>
                                            </td>
                                        @else
                                            <td class="text-center">
                                                <a class="btn btn-default btn-xs request-reject disabled" data-toggle="modal" data-target="#myModalReject" data-toggle="tooltip" data-placement="top" data-id="{{$detail->id}}" {{--onclick="rejectFunc({{$detail->id}})"--}} title="Reject"><i class="fa fa-trash-o"></i> Reject
                                                </a>
                                            </td>
                                        @endif

                                    @else
                                        <td class="text-center">
                                            <a class="btn btn-default btn-xs request-reject disabled" data-toggle="modal" data-target="#myModalReject" data-toggle="tooltip" data-placement="top" data-id="{{$detail->id}}" {{--onclick="rejectFunc({{$detail->id}})" --}}title="Reject"><i class="fa fa-trash-o"></i> Reject
                                            </a>
                                        </td>
                                    @endif

                                </tr>
                                <tr style="display: none;background-color: #ffdfdf;">
                                    <td colspan="13">
                                        <strong style="font-weight: bolder;">APPROVAL TIMELINE</strong>
                                        <br/>
                                        <br/>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Approval Person</th>
                                                    <th>Status</th>
                                                    <th>Timestamp</th>
                                                    <th>Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($detail->employeeApprove) > 0)
                                                    @foreach($detail->employeeApprove as $empA)
                                                        <tr>
                                                            <td>
                                                                {{($empA->employeeApprove)?$empA->employeeApprove->full_name:''}}<br/>
                                                                {{($empA->approve_location)?'Location: '.$empA->approve_location->name:'-'}}
                                                            </td>
                                                            <td>{{$empA->status->name}}</td>
                                                            <td>{{($empA->approved_date)?$empA->approved_date:'-'}}</td>
                                                            <td>{{($empA->reason)?$empA->reason:'-'}}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4" style="text-align: center"> - No Data - </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <?php echo $data->appends(Input::except('page'))->render()?>
                    <br>
                    <?php echo "Total Row Count : ".$row_count;?>
                </div>
              	
            </div>
    	</div>
    </div>
</form>

<div class="modal fade" id="assetRequestModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
            <div class="modal-header">              
                <center><h4>Request Detail</h4></center>
            </div>
            
            <div class="modal-body">
                <center>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">                                
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    
                                    <label class="pull-right" style="padding-top: 7px">Requested Quantity</label>
                                    <input type="text" style="text-align: right;" readonly="true" class="form-control @if($errors->has('requested_qty')) error @endif" name="requested_qty" id="requested_qty">
                                    <input type="hidden" name="total_val" id="total_val">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    
                                    <label class="required pull-right">Submit Quantity</label>
                                    <input type="number" min="0" style="text-align: right;" class="form-control @if($errors->has('submit_qty')) error @endif" name="submit_qty" id="submit_qty" placeholder="Enter Quantity" required>                                    
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    
                                    <label class="pull-right" style="padding-top: 7px">Balance Quantity</label>
                                    <input type="text" style="text-align: right;" readonly="true" class="form-control @if($errors->has('balance_qty')) error @endif" name="balance_qty" id="balance_qty">
                                </div>                                
                            </div>
                            
                                <div class="row" style="margin-top: 2%">
                                    <div class="col-sm-1 col-md-offset-11">
                                        <div class="pull-right" style="margin-right: 0;padding-right:0;">
                                            <button type="button" class="btn btn-primary" onclick="setReplacement()"><i class="fa fa-floppy-o"></i> Submit</button>
                                        </div>
                                    </div>      
                                </div>             
                        </div>
                    </div>
                </center>
            </div>

        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Approve Request</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve?</p>
                <p>Approve Reason</p>
                <input type="text" class="form-control" name="approve_reason" >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="approveFunc()">Approve</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="dismissF()">Close</button>
            </div>
        </div>

    </div>
</div>

<div id="myModalReject" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reject Request</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reject?</p>
                <p>Reject Reason</p>
                <input type="text" class="form-control" name="reject_reason" >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="rejectFunc()">Reject</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="dismissF()">Close</button>
            </div>
        </div>

    </div>
</div>
@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/moment/moment.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/bootstrap-datetimepicker/dist/js/bootstrap-datetimepicker.js')}}"></script>
<script type="text/javascript">

    var t="";
    var approveId = "";
    var approveType = "";
    var rejectId = "";
    var reason = "";

	$(document).ready(function(){
        $("#from_date").datetimepicker({format:'YYYY-MM-DD'});
        $("#to_date").datetimepicker({format:'YYYY-MM-DD'});

        $('.header').click(function(){
            //$(this).find('span').text(function(_, value){return value=='-'?'+':'-'});
            var col = $(this).data('color');
            $(this).data('color',$(this).css('background-color'));
            $(this).css('background-color',col);

            $(this).nextUntil('tr.header').slideToggle(100, function(){
            });
        });

        $("#submit_qty").on('change',function(){
            tmp1=$("#total_val").val();
            tmp2=this.value;
            if((tmp1-tmp2)>=0){
                $("#balance_qty").val(tmp1-tmp2);
            }else{
                $("#balance_qty").val("");
                this.value="";
            }
        });

        $('.request-approve').click(function () {
            approveId = $(this).data('id');
            approveType = $(this).data('type');
        });

        $('.request-reject').click(function () {
            rejectId = $(this).data('id');
        });
    });

	function dismissF(){
	    approveId = "";
	    rejectId = "";
        approveType = "";
        reason = "";
        $('input[name="approve_reason"]').val('');
        $('input[name="reject_reason"]').val('');
    }

    /**
     * Reject Request
     * Call to the ajax request request/reject.
     */
    function rejectFunc(id=null){

        id = (id)?id:rejectId;
        reason = $('input[name="reject_reason"]').val();

        ajaxRequest( '{{url('request/reject')}}' , {
            'id' : id,
            'reason': reason
        }, 'post', handleData);
    }

    /**
     * Approve request
     * Call to the ajax request request/approve.
     */
    function approveFunc(id = null,type = null)
    {

        type = (type)?type:approveType;
        id = (id)?id:approveId;
        reason = $('input[name="approve_reason"]').val();

        if(type!=1){
            approve(id);
        }else{
            t=id;
            $("#requested_qty").val($('#hidden_quantity_'+id).val());
            $("#total_val").val($('#hidden_quantity_'+id).val());
            $('#assetRequestModal').modal('show');

            $("submit_qty").attr({
               "max" : $('#hidden_quantity_'+id).val(),
               "min" : 1
            });
        }
    }

    function approve(id)
    {
        $.ajax({
            url: "{{url('request/checkSoftwareAsset')}}" ,
            type: 'GET',
            data: {'id' : id},
            success: function(data)
            {
                if(data.status != 1)
                {
                    ajaxRequest( '{{url('request/approve')}}' , {
                        'id' : id,
                        'reason': reason
                    }, 'post', handleData);
                }else{
                    swal('Warning',data.asset+' Software assigned to this asset. Remove it to dispose this asset','error');
                }
            },
            error: function(xhr, textStatus, thrownError) {
                console.log(thrownError);
            }
        });
    }

    function setReplacement(){
        if($("#submit_qty").val()>0){
            ajaxRequest( '{{url('request/replace')}}' , {
                'id' : t,
                'submit_qty' : $("#submit_qty").val(),
                'reason' : reason
            }, 'post', handleData);
        }else{
            swal('Warning','Submit quantity cannot be zero!','error');
        }
    }

    /**
     * Service request
     * Call to the ajax request request/sent-to-request.
     */
    function serviceFuncFunc(){
        ajaxRequest( '{{url('request/sent-to-service')}}' , { 'id' : id  }, 'post', handleData);
    }

    /** 
     * Delete the employee return function
     * Return to this function after sending ajax request to the employee/delete
     */
    function handleData(data){

        if(data.status=='success'){
            swal('Well Done!','Successfully Done!','success');
            window.location.reload();
        }else if(data.status=='invalid_id'){
            swal('Error!','Request doesn\'t exists!','error');
        }else{
            swal('Error!','Please try again!','error');
        }
    }
</script>
@stop
