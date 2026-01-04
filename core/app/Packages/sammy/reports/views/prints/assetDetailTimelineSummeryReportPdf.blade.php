<style type="text/css">
    
</style>

<div class="row">
    <div class="col-xs-12 col-md-12 pull-left">
        <div class="panel panel-bordered">
            <div class="panel-body">
                <div class="row" id="print-details">

                    <table>
                        <tr>
                            <td style="vertical-align: bottom;">
                                <h4 style="font-weight: 600;vertical-align: bottom;margin: 0;">Asset ({{$details->asset_no}}) Details</h4>
                            </td>
                            <td>
                                @if($details->barcode!=null)
                                    <?php echo '<img style="" src="data:image/png;base64,' . DNS1D::getBarcodePNG($details->inventory_no, $details->barcode->barcodetype->name,1,40) . '" alt="barcode"   />' ?>
                                    <br/><i style="font-size: 9px;">{{$details->inventory_no}}</i>
                                @else
                                    <div id="barcode_wrapper_empty" data-barcodeType="0" class="text-center" >
                                        <h5>barcode not genarated</h5>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Inventory No  : {{$details->inventory_no}}</span>
                            </td>
                            <td>
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Manual No  : {{$details->manual_no}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Manufacturer  : {{$details->manufacturer->name}}</span>
                            </td>
                            <td>
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Account Code  : {{$details->account_code}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Model         : {{$details->model}}</span>
                            </td>
                            <td>
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">PO Number No  : {{$details->po_number}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Purcahse Date : {{$details->purchased_date}}</span>
                            </td>
                            <td>
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Purchased Value  : {{$details->purchased_value}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Warranty Begin : {{$details->warranty_from}} - End :{{$details->warranty_to}}</span>
                            </td>
                            <td>
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Scrap Value  : {{$details->scrap_value}}</span>
                            </td>
                        </tr>
                    </table>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <hr>
                    </div>

                    <table class="table table-bordered" border="1">
                        <thead>
                            <tr style="line-height: 2;text-align: left">
                                <th>&nbsp;&nbsp;&nbsp;Action Date</th>
                                <th>&nbsp;&nbsp;&nbsp;Action Title</th>
                                <th>&nbsp;&nbsp;&nbsp;Location</th>
                                <th>&nbsp;&nbsp;&nbsp;Employee Location</th>
                                <th>&nbsp;&nbsp;&nbsp;Action By</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $lk=0;?>
                            @foreach($timeline as $data)
                                <tr style="line-height: 2;text-align: left">
                                    <td>&nbsp;&nbsp;&nbsp;{{date_format($data->created_at, 'D-M-d-Y')}}<br>{{date_format($data->created_at, 'h:i:s')}}</td>
                                    @if($lk==count($timeline)-1)
                                        <td>&nbsp;&nbsp;&nbsp;{{$data->type}}</td>
                                        <td>&nbsp;&nbsp;&nbsp;{{$data->location->name}}</td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;&nbsp;{{$data->user->first_name}} {{$data->user->last_name}} <br> @if(isset($data->user->code)){{$data->user->code}}@endif</td>
                                    @elseif($lk==count($timeline)-2)
                                        <td>&nbsp;&nbsp;&nbsp;{{$data->type}}</td>
                                        <td>&nbsp;&nbsp;&nbsp;{{$data->location->name}}</td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;&nbsp;{{$data->user->first_name}} {{$data->user->last_name}} <br> @if(isset($data->user->code)){{$data->user->code}}@endif</td>
                                    @else
                                        <td>&nbsp;&nbsp;&nbsp;{{$data->type}}</td>
                                        @if($data->status->id==ASSET_UNDEPLOY)
                                            <td>&nbsp;&nbsp;&nbsp;{{$data->location->name}}</td>                         
                                            <td>&nbsp;&nbsp;&nbsp;</td>                         
                                        @elseif($data->status->id==ASSET_DEPLOY)                            
                                            <td>&nbsp;&nbsp;&nbsp;{{$data->location->name}}</td>
                                            <td>&nbsp;&nbsp;&nbsp;@if($data->employee){{$data->employee->first_name}} {{$data->employee->last_name}}@endif</td>
                                        @else
                                            <td>&nbsp;&nbsp;&nbsp;{{$data->location->name}}</td>
                                            <td>&nbsp;&nbsp;&nbsp;</td>
                                        @endif
                                        <td>&nbsp;&nbsp;&nbsp;{{$data->user->first_name}} {{$data->user->last_name}} <br> @if(isset($data->user->code)){{$data->user->code}}@endif</td>
                                    @endif
                                </tr>
                                <?php $lk++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  
</div>