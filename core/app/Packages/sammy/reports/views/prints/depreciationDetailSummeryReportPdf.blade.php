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
                                <h4 style="font-weight: 600;vertical-align: bottom;margin: 0;">Asset ({{$history->asset_no}}) Details</h4>
                            </td>
                            <td style="text-align: right;">
                                @if($history->barcode!=null)
                                    <?php echo '<img style="" src="data:image/png;base64,' . DNS1D::getBarcodePNG($history->inventory_no, $history->barcode->barcodetype->name,1,40) . '" alt="barcode"   />' ?>
                                    <br/><i style="font-size: 9px;">{{$history->inventory_no}}</i>
                                @else
                                    <div id="barcode_wrapper_empty" data-barcodeType="0" class="text-center" >
                                        <h5>barcode not genarated</h5>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Inventory No  : {{$history->inventory_no}}</span>
                            </td>
                            <td style="text-align: right;">
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Manual No  : {{$history->manual_no}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Manufacturer  : {{$history->manufacturer->name}}</span>
                            </td>
                            <td style="text-align: right;">
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Account Code  : {{$history->account_code}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Model         : {{$history->model}}</span>
                            </td>
                            <td style="text-align: right;">
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">PO Number No  : {{$history->po_number}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Purcahse Date : {{$history->purchased_date}}</span>
                            </td>
                            <td style="text-align: right;">
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Purchased Value  : {{$history->purchased_value}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Warranty Begin : {{$history->warranty_from}} - End :{{$history->warranty_to}}</span>
                            </td>
                            <td style="text-align: right;">
                                <span style="font-size: 0.83em;font-weight: 600;margin-top: 5px;margin-bottom: 5px;">Scrap Value  : {{$history->scrap_value}}</span>
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td style="line-height: 1">

                            </td>
                        </tr>
                    </table>

                    <table class="table table-bordered" border="1">
                        <thead>
                            <tr style="line-height: 2;text-align: left">
                                <th scope="col">&nbsp;&nbsp;&nbsp;Year</th>
                                <th scope="col">&nbsp;&nbsp;&nbsp;Book Value Year Start</th>
                                <th scope="col">&nbsp;&nbsp;&nbsp;Depreciation Percent</th>
                                <th scope="col">&nbsp;&nbsp;&nbsp;Depreciation Expense</th>
                                <th scope="col">&nbsp;&nbsp;&nbsp;Accumulated Depreciation</th>
                                <th scope="col">&nbsp;&nbsp;&nbsp;Book Value Year End</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($depriciations as $tmp)
                            <tr style="line-height: 2;text-align: left">
                                <td>&nbsp;&nbsp;&nbsp;{{$tmp['year']}}</td>
                                <td>&nbsp;&nbsp;&nbsp;{{number_format($tmp['book_value'],2)}}</td>
                                <td>&nbsp;&nbsp;&nbsp;</td>
                                <td>&nbsp;&nbsp;&nbsp;{{number_format($tmp['depreciation_expense'],2)}}</td>
                                <td>&nbsp;&nbsp;&nbsp;{{number_format($tmp['accumulated'],2)}}</td>
                                <td>&nbsp;&nbsp;&nbsp;{{number_format($tmp['book_value_year_end'],2)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  
</div>