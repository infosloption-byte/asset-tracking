<style type="text/css">

    td{
        font-weight: 400;
        font-size: 8px;
    }

    th {
        text-align: left;
    }


    .border{
        border-width:1px;
        border-style:solid;
    }

    .border-left{
        border-left-style:solid;
        border-width:1px;
    }

    .border-right{
        border-right-style:solid;
        border-width:1px;
    }

    .border-top{
        border-top-style:solid;
        border-width:1px;
    }

    .border-bottom {
        border-bottom-style:solid;
        border-width:1px;
    }

</style>


<div style="width:100%;margin:5px;padding:5px;text-align:center;">
    <strong>SERVICE DETAILS </strong>
    <strong><h5>#{{$service->service_no}}</h5></strong>
</div>

<table width="100%">
    <tbody>


    <tr>
        <td style="line-height: 2">

        </td>
    </tr>


    <tr>
        <td style="line-height: 1.3">
            <span style="margin: 0;font-weight:800"><strong>No : #{{$service->service_no}}</strong></span><br>
            <span style="margin: 0"><strong>Service Type : {{$service->type->name}}</strong></span><br>
            <span style="margin: 0">Created Date : {{$service->created_at->format('Y-m-d')}}</span><br>
            <br>
            <span style="margin: 0;font-weight:800">Asset Serial NO : #{{$service->asset->asset_no}}</span><br>
            <span style="margin: 0;font-weight:800">Inventory No : #{{$service->asset->inventory_no}}</span><br>
            <span style="margin: 0">Supplier : {{$service->asset->supplier->name}}</span><br>
            <span style="margin: 0">Supplier Contact : {{$service->asset->supplier->phone}}</span><br>
        </td>
    </tr> 

    <tr>
        <td style="line-height: 1.3">
            @if($service->asset->barcode==null)
                <span>barcode not genarated</span>
            @else
             <?php echo '<img style="" src="data:image/png;base64,' . DNS1D::getBarcodePNG($service->asset->asset_no, $service->asset->barcode->barcodetype->name,1,25) . '" alt="barcode"   />' ?> <br>
                <i style="font-size: 9px;width: 100%;" class="text-center">{{$service->asset->asset_no}}</i>
            @endif
        </td>
    </tr>

    <tr>
        <td style="line-height: 2">

        </td>
    </tr>

    <tr>
        <td width="100%">
            <table border="1px" style="width:100%">
                    <thead>
                        <tr style="line-height:2">
                            <th width="5%"> #</th>
                            <th width="15%"> Service No</th>
                            <th width="15%"> In Date</th>
                            <th width="15%"> Start Date</th>
                            <th width="15%"> Completed Date</th>
                            <th width="15%"> Days In Service</th>
                            <th width="20%"> Serviced By</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <tr style="line-height:2">
                            <td> 1</td>
                            <td> #{{$service->service_no}}</td>
                            <td>
                                @if($service->service_in_date!=null)
                                    {{$service->service_in_date}}
                                @else
                                    not in
                                @endif
                            </td>
                            <td>
                                @if($service->start_date!=null)
                                    {{$service->start_date}}
                                @else
                                    not started
                                @endif
                            </td>

                            <td>
                                @if($service->completed_date!=null)
                                    {{$service->completed_date}}
                                @else
                                    not completed
                                @endif
                            </td>

                            <td>
                                @if($service->service_days!=null)
                                    {{$service->service_days}} days
                                @else
                                    not specified
                                @endif
                            </td>

                            <td>
                                @if($service->serviced_by!=null)
                                    {{$service->serviced_by}}
                                @else
                                    not specified
                                @endif
                            </td>
                            
                        </tr>
                    </tbody>
                </table>
        </td>
    </tr>

    <tr>
        <td style="line-height: 1">

        </td>
    </tr>

    <tr>
        <td> <span style="margin: 0;font-size:7px">Print Date : {{date('Y-m-d')}}</span></td>
    </tr>

    <tr>
        <td style="text-align:right">
            <h3>Service Cost - {{CURRENCY}}{{number_format($service->cost,2,'.',',')}}</h3>
        </td>
    </tr>

    <tr>
        <td style="line-height: 8">

        </td>
    </tr>


    <tr>
        <td style="line-height: 2">
            --------------------------------------------- <br>
            Checked By -  
        </td>
    </tr>



    </tbody>
</table>
