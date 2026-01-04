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

                    <table>
                        @if($details->supplier)
                            <tr>
                                <td colspan="3">Supplier : {{$details->supplier->name}} ({{$details->supplier->country}} - {{$details->supplier->city}})</td>
                            </tr>
                            <tr>
                                <td>Address : {{$details->supplier->address}}</td>
                                <td>Contact No : {{$details->supplier->phone}}</td>
                                <td>Email : {{$details->supplier->email}}</td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="2"> - No Supplier Detais - </td>
                            </tr>
                        @endif
                    </table>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <hr>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="6" align="left">
                                    <span style="font-weight:bold;font-size:12px;margin: 0;padding:0;">Upgraded Assets</span>
                                </th>
                            </tr>
                            <tr>
                                <th align="center" style="font-weight: bold;">Serial No</th>
                                <th align="center" style="font-weight: bold;">Inventory No</th>
                                <th align="center" style="font-weight: bold;">Model</th>
                                <th align="center" style="font-weight: bold;">Purchased Value</th>
                                <th align="center" style="font-weight: bold;">Begin</th>
                                <th align="center" style="font-weight: bold;">End</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=1 ?>
                        @foreach($details->upgradehistory as $history)
                            <tr>
                                <td>
                                    <a href="{{url('asset/view/')}}/{{$history->upgrade_asset_id}}" style="text-decoration: underline;color:blue">{{$history->asset->asset_no}}</a>
                                </td>
                                <td>
                                    @if($history->asset->inventory_no!=null)
                                        {{$history->asset->inventory_no}}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($history->asset->assetmodel!=null)
                                        {{$history->asset->assetmodel->name}}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{CURRENCY}}{{number_format($history->asset->purchased_value,2,'.',',')}}</td>
                                <td style="text-align: center">{{$history->asset->warranty_from}}</td>
                                <td style="text-align: center">{{$history->asset->warranty_to}}</p></td>
                                <?php $i++ ?>
                            </tr>
                        @endforeach
                        </tbody>
                    </table><br/><br/><br/>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="6" align="left">
                                    <span style="font-weight:bold;font-size:12px;margin: 0;padding:0;">Upgraded Into</span>
                                </th>
                            </tr>
                            <tr>
                                <th align="center" style="font-weight: bold;">Serial No</th>
                                <th align="center" style="font-weight: bold;">Inventory No</th>
                                <th align="center" style="font-weight: bold;">Model</th>
                                <th align="center" style="font-weight: bold;">Purchased Value</th>
                                <th align="center" style="font-weight: bold;">Begin</th>
                                <th align="center" style="font-weight: bold;">End</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($assignto)>0)
                            <tr>
                                <td>
                                    <a href="{{url('asset/view/')}}/{{$assignto->id}}" style="text-decoration: underline;color:blue">{{$assignto->asset_no}}</a>
                                </td>
                                <td>
                                    @if($assignto->inventory_no!=null)
                                        {{$assignto->inventory_no}}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($assignto->assetmodel!=null)
                                        {{$assignto->assetmodel->name}}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{CURRENCY}}{{number_format($assignto->purchased_value,2,'.',',')}}</td>
                                <td style="text-align: center">{{$assignto->warranty_from}}</td>
                                <td style="text-align: center">{{$assignto->warranty_to}}</p></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <hr>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th colspan="7" align="left">
                                <span style="font-weight:bold;font-size:12px;margin: 0;padding:0;">Assigned Software Details</span>
                            </th>
                        </tr>
                        <tr>
                            <th align="center" style="font-weight: bold;">Name</th>
                            <th align="center" style="font-weight: bold;">Category</th>
                            <th align="center" style="font-weight: bold;">Description</th>
                            <th align="center" style="font-weight: bold;">Expiry</th>
                            <th align="center" style="font-weight: bold;">Manufacturer</th>
                            <th align="center" style="font-weight: bold;">Supplier</th>
                            <th align="center" style="font-weight: bold;">Reference</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($license)>0)
                            @foreach($license as $value)
                                <tr>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->category}}</td>
                                    <td>{{$value->description}}</td>
                                    <td>{{$value->license_to}}</td>
                                    <td>{{$value['manufacture']->name}}</td>
                                    <td>{{$value['supplier']->name}}</td>
                                    <td>{{$value->reference_no}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" align="center"><br/><br/>Nothing Assinged yet</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <hr>
                    </div>
                    <table class="table table-bordered" width="100%">
                        <thead>
                        <tr>
                            <th align="left"><span style="font-weight:bold;font-size:12px;margin: 0;padding:0;">Description</span></th>
                        </tr>
                        <tr>
                            <th align="left">
                                {{$details->description}}
                            </th>
                        </tr>
                        </thead>
                    </table>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <hr>
                    </div>

                    <table class="table table-bordered" width="50%">
                        <thead>
                        <tr>
                            <th colspan="2" align="left">
                                <span style="font-weight:bold;font-size:14px;margin: 0;padding:0;">Details</span><br/>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($assetDetails)>0)
                            @foreach($assetDetails as $deviceModel)
                                <tr>
                                    <td colspan="2"><span style="font-weight: bold;">{{$deviceModel['modal']}}</span></td>
                                </tr>
                                @foreach($deviceModel['value'] as $key=>$fieldset)
                                    <tr>
                                        <td>
                                            {{$key}}
                                        </td>
                                        <td>
                                            {{$fieldset?:'-'}}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr><td></td></tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2" align="center"><br/><br/>No Details</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  
</div>