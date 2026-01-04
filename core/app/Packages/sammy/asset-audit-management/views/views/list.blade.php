@extends('layouts.sammy_new.master') @section('title','Asset Audit')
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
            <a href="#">Assets Management</a>
        </li>
        <li class="active">Assets List</li>
    </ol>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-bordered" id="panel-search">
                <form role="form" class="form-validation" method="get">
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
                    <table class="table table-bordered table-hover" id="tableLoad">
                        <thead style="background-color: #5e9acc;color: #fff">
                        <tr>
                            <th width="5%"><input type="checkbox" value="" id="checkAll"></th>
                            <th >Asset SerialNo</th>
                            <th >Asset InvNo</th>
                            <th >Asset Model</th>
                            <th>Asset Location</th>
                            <th width="20%" class="text-center">Barcode</th>
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
                                            <i style="font-size: 9px;width: 100%;" class="text-center">{{$item->asset_no}}</i><br/>
                                            <?php echo DNS1D::getBarcodeSVG($item->inventory_no, $item->barcode->barcodetype->name,0.6,30) ?> <br>
                                            <i style="font-size: 9px;width: 100%;" class="text-center">{{$item->inventory_no}}</i>
                                            {{--<img src="data:image/png,{{DNS1D::getBarcodePNG($item->asset_no, $item->barcode->barcodetype->name)}}" alt="barcode"   />--}}
                                            @endif
                                    </td>
                                    <?php $i++ ?>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row" style="margin-bottom:10px">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                                <button class="btn btn-primary" id="btn-save">PRINT</button>
                            </div>
                        </div>
                        <?php echo $assets->appends(Input::except('page'))->render()?> <br>

                        **NOTE - only the assets in this page will be printed cannot select the paging data
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
        var table = '';
        $(document).ready(function(){
            var assets = [];

            $('#checkAll').click(function(){
                $('td input:checkbox',$("#tableLoad")).prop('checked',this.checked);
            });

        });



    </script>
@stop
