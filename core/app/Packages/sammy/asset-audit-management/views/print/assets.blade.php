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
    <strong>AUDIT REPORT - {{date('Y-m-d')}}</strong>
</div>

<table width="100%">
    <tbody>


    <tr>
        <td style="line-height: 2">

        </td>
    </tr>


    <tr>
        <td style="line-height: 2">
            <span>User - {{$user->first_name}} {{$user->last_name}} </span> <br>
            <span>Total Assets - {{count($assets)}}</span><br>
            <span>Audit Date - {{date('Y-m-d')}}</span>
        </td>
    </tr>

    <tr>
        <td style="line-height: 2">

        </td>
    </tr>

    <tr>
        <td width="100%">
            <table border="1px" width="100%">
                <thead >
                <tr style="line-height: 2">
                    <th width="5%"> #</th>
                    <th width="30%" style="text-align: center"><h4> Asset</h4></th>
                    <th width="10%"><h4> Status</h4></th>
                    <th width="18%"><h4> Inventory No</h4></th>
                    <th width="9%"><h4> Model</h4></th>
                    <th width="9%"><h4> Supplier</h4></th>
                    <th width="20%"><h4> Notes</h4></th>
                </tr>
                </thead>
                <tbody >
                <?php $i=1 ?>
                @foreach($assets as $asset)
                    <tr style="line-height: 2">
                        <td width="5%">
                            {{$i}}
                        </td>
                        <td width="30%" style="text-align: center;">
                         <i style="font-size: 7px;width: 100%;" class="text-center">{{$asset->inventory_no}}</i> <br>
                            <span style="width:100%;padding:5px">
                                <?php echo '<img style="" src="data:image/png;base64,' . DNS1D::getBarcodePNG($asset->inventory_no, $asset->barcode->barcodetype->name,0.8,20) . '" alt="barcode"  style="line-height:2" />' ?> <br>
                               
                            </span>
                        </td>
                        <td width="10%"> {{$asset->transaction[0]->status->name}}</td>
                        <td width="18%"> {{$asset->asset_no}}</td>
                        <td width="9%"> {{$asset->assetmodel->name}}</td>
                        <td width="9%"> {{$asset->supplier->name}}</td>
                        <td width="20%"></td>
                    </tr>
                    <?php $i++ ?>
                @endforeach
                </tbody>
            </table>
        </td>

    </tr>

    <tr>
        <td style="line-height: 8">

        </td>
    </tr>


    <tr>
        <td style="line-height: 2">
            --------------------------------------------- <br>
            Audit By -  
        </td>
    </tr>









    </tbody>
</table>
