@extends('layouts.sammy_new.master') @section('title','Asset Upgrade History')
@section('css')
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

        .btn-actions {
            color: #1975D1;
        }

        .btn-actions:hover {
            color: #003366;
        }

    </style>
@stop
@section('content')
    <ol class="breadcrumb">
        <li>
            <a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
        </li>
        <li>
            <a href="{{{url('asset/list')}}}">Asset List</a>
        </li>
        <li class="active">Asset Upgrade</li>
    </ol>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-bordered" id="panel-search">
                <form role="form" class="form-validation" method="get">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <h5 style="font-weight: 600">Asset ({{$asset->asset_no}}) upgrade history</h5>
                                <h5 style="font-weight: 600">{{$asset->assetmodel->name}}</h5>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                <h6 style="font-weight: 600">
                                    current location  - ({{count($asset->transaction[0])>0?$asset->transaction[0]->location->name:'unknown'}})
                                </h6>
                            </div>
                        </div>

                        <div class="row">  
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left">
                                <h6>Account Code  : {{$asset->account_code}}</h6>
                                <h6>PO Number No  : {{$asset->po_number}}</h6>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                <h6 style="font-weight: 600">Purchased Value  : {{$asset->purchased_value}}</h6>
                                <h6>Scrap Value  : {{$asset->scrap_value}}</h6>
                                <h6>Markup Value  : {{$asset->markup_value}}</h6>
                            </div>
                        </div>

                        <div class="row">
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="pull-left">
                                    @if($asset->barcode!=null)
                                        <div class="text-center">
                                            <?php echo DNS1D::getBarcodeSVG($asset->asset_no, $asset->barcode->barcodetype->name,1.5,40) ?>
                                            <div style="font-size: 9px;">{{$asset->asset_no}}</div>
                                        </div>
                                    @else
                                        <div id="barcode_wrapper_empty" data-barcodeType="0" class="text-center" >
                                            <h5>barcode not genarated</h5>
                                        </div>
                                    @endif
                                </div>
                           </div>
                       </div>


                        <div class="row">
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="pull-right">
                                    @if($asset->barcode==null)
                                        <button type="button" class="btn btn-sm btn-info btn-genarate">Genarate Barcode</button>
                                    @else
                                        <a href="{{url('barcode/print/')}}/{{$asset->id}}" class="btn btn-sm btn-primary btn-print-barcode">Print Barcode</a>
                                    @endif
                                </div>
                           </div>
                       </div>

                    </div>
                </form>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-bordered">
                <div class="panel-heading border">
                    <div class="row">
                        <div class="col-xs-6">
                            <strong style="font-size:13px;font-weight: bold">Assets List</strong>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                   <form role="form" class=" form-validation" method="post" enctype="multipart/form-data">
                    {!!Form::token()!!}
                    @if($errors->has('asset'))
                        <label id="label-error" class="error" for="label">{{$errors->first('asset')}}</label>
                    @endif

                    <table class="table table-bordered table-hover" id="tableLoad">
                        <thead style="background-color: #5e9acc;color: #fff">
                        <tr>
                            <th width="5%"#</th>
                            <th >Serial No</th>
                            <th >Inventory No</th>
                            <th >Asset Status</th>
                            <th >Purchased Date</th>
                            <th >Recovery Period</th>
                            <th >Asset Model</th>
                            <th>Asset Location</th>
                            <th width="18%">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="tbody">
                        <?php $i=1 ?>
                            @foreach($asset->upgradehistory as $key=>$item)
                                <tr>
                                    <td>
                                        {{$key+1}}
                                    <td>
                                        <a href="{{url('asset/view/')}}/{{$item->upgrade_asset_id}}" class="link" data-toggle="tooltip" data-placement="top" title="View Item" style="text-decoration:underline;color:blue">{{$item->asset->asset_no}}</a> 
                                    </td>
                                    <td>
                                        @if($item->asset->inventory_no!=null)
                                            {{$item->asset->inventory_no}}
                                        @else
                                            -
                                        @endif                                      
                                    </td>
                                    <td>
                                        @if(count($item->asset->transaction)>0)
                                            @if($item->asset->transaction[0]->status->id==ASSET_UNDEPLOY)
                                                <span class="badge" style="font-size: 10px;background-color: #dda30c">{{$item->asset->transaction[0]->status->name}}</span>
                                            @elseif($item->asset->transaction[0]->status->id==ASSET_DISPOSED)
                                                <span class="badge" style="font-size: 10px;background-color: #dd1144">{{$item->asset->transaction[0]->status->name}}</span>
                                            @elseif($item->asset->transaction[0]->status->id==ASSET_INSERVICE)
                                                <span class="badge" style="font-size: 10px;background-color: #74dd00">{{$item->asset->transaction[0]->status->name}}</span>
                                            @elseif($item->asset->transaction[0]->status->id==ASSET_DEPLOY)
                                                <span class="badge" style="font-size: 10px;background-color: #3e3aff">{{$item->asset->transaction[0]->status->name}}</span>
                                            @else
                                                <span class="badge" style="font-size: 10px;">{{$item->asset->transaction[0]->status->name}}</span>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->asset->purchased_date!=null)
                                            {{$item->asset->purchased_date}}
                                        @else
                                            -
                                        @endif                                      
                                    </td>
                                    <td>
                                        @if($item->asset->recovery_period!=null)
                                            {{$item->asset->recovery_period}}
                                        @else
                                            -
                                        @endif                                      
                                    </td>
                                    <td>@if($item->asset->assetmodel!=null)
                                            {{$item->asset->assetmodel->name}}
                                        @else
                                            -
                                        @endif</td>
                                    <td>
                                        @if(count($item->asset->transaction)>0)
                                            <span>{{$item->asset->transaction[0]->location->name}}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                       @if($item->ended_at!=null)
                                             un-assigned <br>   
                                            {{$item->ended_at}}
                                       @else
                                           @if($user->hasAnyAccess(['admin','asset.upgrade.unassign']))
                                             <button 
                                             data-id="{{$item->id}}" 
                                             data-assetid="{{$item->asset->id}}" 
                                             type="button" class="btn btn-xs btn-default btn-unassign">unassign</button>
                                           @else
                                                -
                                           @endif
                                       @endif
                                    </td>
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
    <script type="text/javascript">
        var id = 0;
        var asset_id = 0;
        $(document).ready(function(){
           $('.btn-unassign').click(function(){
                id = $(this).data('id');
                asset_id = $(this).data('assetid');
                sweetAlertConfirm("Are You Sure?", 'are you sure you want to unassign this asset from the current asset',1,doUnAssign);
                
            });

           function doUnAssign() {
                if(id>0){
                   $(".panel").addClass('panel-refreshing');
                   $.ajax({
                        url: "{{url('asset/upgrade/unassign')}}" ,
                        type: 'post',
                        data: {'id' :  id,'asset_id':asset_id},
                        success: function(data) {
                            $(".panel").removeClass('panel-refreshing');
                            if(data.status=="success"){
                                swal("Success!", 'Unassigned from the asset','success');
                                location.reload();
                            }else{
                                swal("Oopz!", 'Something happend while processing','error');
                            }
                        },
                        error: function(xhr, textStatus, thrownError) {
                            console.log(thrownError);
                        }
                    });
                }
           }

        });
    </script>
@stop
