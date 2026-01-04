<style type="text/css">

    td{
        font-weight: 400;
        font-size: 8px;
    }

    .details , .details> th ,  .details> td {
        border-collapse: collapse;
        padding: 5px;
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

<div style="margin:0px;padding:0px"></div>

<div style="width:100%;margin:5px;padding:5px;text-align:center;">
    <strong>ASSET BARCODE</strong>
</div>

<table width="100%">
    <tbody>
        <tr>
            <td>
                <h3>ASSET - {{$asset->asset_no}}</h3>
                <span>Asset Status - {{$asset->transaction[0]->status->name}}<br>Asset Location - {{$asset->transaction[0]->location->name}}</span>
            </td>
        </tr>

        <tr>
            <td style="line-height: 2">

            </td>
        </tr>

        <tr>
            <td width="100%">
                <table style="margin:0px auto"; width="100%"; align="center" >
                    <tr>
                        <td width="100%">
                            <table style="width:100%">
                                <tr>
                                    <td>
                                        <i style="font-size: 9px;width: 100%" class="text-center">Inventory : {{$asset->inventory_no}}</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span style="width:100%">
                                            <?php echo '<img style="" src="data:image/png;base64,' . DNS1D::getBarcodePNG($asset->inventory_no, $asset->barcode->barcodetype->name,1,40) . '" alt="barcode"   />' ?> <br>
                                        </span>        
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        {{($asset->supplier)?$asset->supplier->name.' / '.$asset->supplier->phone:'-'}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i style="font-size: 9px;width: 100%;" class="text-center">SN : {{$asset->asset_no}}</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i style="font-size: 9px;width: 100%;" class="text-center">W: {{date('d/m/y',strtotime($asset->warranty_from)).' - '.date('d/m/y',strtotime($asset->warranty_to))}}</i>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="line-height: 2">

            </td>
        </tr>
    </tbody>
</table>
