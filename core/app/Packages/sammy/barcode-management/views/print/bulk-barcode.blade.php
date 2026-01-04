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

<table width="100%" style="padding-top: 30px">
    <tbody>
        <?php $i=1; ?>
            @foreach($assets as $key => $asset)
                @if($i == 1)
                    <tr>
                @endif
                @if(count($assets) >= 3)
                    <td>
                        <table style="width:100%" border="1">
                            <tr>
                                <td>
                                    <i style="font-size: 9px;width: 100%" class="text-center">Inventory : {{$asset->inventory_no}}</i>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%">
                                        <tr>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="20%">
                                                <img style="width: 25px;padding-top: 20px" src="{{asset('assets/sammy_new/images/rdb.jpg')}}">
                                            </td>
                                            <td width="79%">
                                                <span style="width:100%">
                                                    <?php echo '<img style="" src="data:image/png;base64,' . DNS1D::getBarcodePNG($asset->inventory_no, $asset->barcode->barcodetype->name,1,40) . '" alt="barcode"   />' ?> <br>
                                                </span>
                                            </td>
                                            <td width="1%"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" align="left">
                                                @if($asset->supplier)
                                                    @if(strlen($asset->supplier->name.' / '.$asset->supplier->phone) > 80)
                                                        {{str_limit($asset->supplier->name,65).' / '.$asset->supplier->phone}}
                                                    @else
                                                        @if(strlen($asset->supplier->name.' / '.$asset->supplier->phone) < 46)
                                                            <?php $d = $asset->supplier->name.' / '.$asset->supplier->phone."<br/>"; ?>
                                                            {!! $d !!}
                                                        @else
                                                            {{$asset->supplier->name.' / '.$asset->supplier->phone}}
                                                        @endif
                                                    @endif
                                                @else
                                                    {{'-'}}
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i style="font-size: 9px;width: 100%;" class="text-center">SN : {{$asset->asset_no}}</i>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i style="font-size: 9px;width: 100%;" class="text-center">Warranty: {{date('d/m/Y',strtotime($asset->warranty_from)).' - '.date('d/m/Y',strtotime($asset->warranty_to))}}</i>
                                </td>
                            </tr>
                        </table>
                    </td>
                @else
                    @if(count($assets) == 1)
                        <td>
                            <table style="width:100%" border="1">
                                <tr>
                                    <td>
                                        <i style="font-size: 9px;width: 100%" class="text-center">Inventory : {{$asset->inventory_no}}</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%">
                                            <tr>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td width="20%">
                                                    <img style="width: 25px;padding-top: 20px" src="{{asset('assets/sammy_new/images/rdb.jpg')}}">
                                                </td>
                                                <td width="79%">
                                            <span style="width:100%">
                                                <?php echo '<img style="" src="data:image/png;base64,' . DNS1D::getBarcodePNG($asset->inventory_no, $asset->barcode->barcodetype->name,1,40) . '" alt="barcode"   />' ?> <br>
                                            </span>
                                                </td>
                                                <td width="1%"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="left">
                                                    @if($asset->supplier)
                                                        @if(strlen($asset->supplier->name.' / '.$asset->supplier->phone) > 80)
                                                            {{str_limit($asset->supplier->name,65).' / '.$asset->supplier->phone}}
                                                        @else
                                                            @if(strlen($asset->supplier->name.' / '.$asset->supplier->phone) < 46)
                                                                <?php $d = $asset->supplier->name.' / '.$asset->supplier->phone."<br/>"; ?>
                                                                {!! $d !!}
                                                            @else
                                                                {{$asset->supplier->name.' / '.$asset->supplier->phone}}
                                                            @endif
                                                        @endif
                                                    @else
                                                        {{'-'}}                                                            
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i style="font-size: 9px;width: 100%;" class="text-center">SN : {{$asset->asset_no}}</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i style="font-size: 9px;width: 100%;" class="text-center">Warranty: {{date('d/m/Y',strtotime($asset->warranty_from)).' - '.date('d/m/Y',strtotime($asset->warranty_to))}}</i>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td></td>
                        <td></td>
                        <?php $i = 3 ?>
                    @else
                        <td>
                            <table style="width:100%" border="1">
                                <tr>
                                    <td>
                                        <i style="font-size: 9px;width: 100%" class="text-center">Inventory : {{$asset->inventory_no}}</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%">
                                            <tr>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td width="20%">
                                                    <img style="width: 25px;padding-top: 20px" src="{{asset('assets/sammy_new/images/rdb.jpg')}}">
                                                </td>
                                                <td width="79%">
                                            <span style="width:100%">
                                                <?php echo '<img style="" src="data:image/png;base64,' . DNS1D::getBarcodePNG($asset->inventory_no, $asset->barcode->barcodetype->name,1,40) . '" alt="barcode"   />' ?> <br>
                                            </span>
                                                </td>
                                                <td width="1%"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="left">
                                                    @if($asset->supplier)
                                                        @if(strlen($asset->supplier->name.' / '.$asset->supplier->phone) > 80)
                                                            {{str_limit($asset->supplier->name,65).' / '.$asset->supplier->phone}}
                                                        @else
                                                            @if(strlen($asset->supplier->name.' / '.$asset->supplier->phone) < 46)
                                                                <?php $d = $asset->supplier->name.' / '.$asset->supplier->phone."<br/>"; ?>
                                                                {!! $d !!}
                                                            @else
                                                                {{$asset->supplier->name.' / '.$asset->supplier->phone}}
                                                            @endif
                                                        @endif
                                                    @else
                                                        {{'-'}}
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i style="font-size: 9px;width: 100%;" class="text-center">SN : {{$asset->asset_no}}</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i style="font-size: 9px;width: 100%;" class="text-center">Warranty: {{date('d/m/Y',strtotime($asset->warranty_from)).' - '.date('d/m/Y',strtotime($asset->warranty_to))}}</i>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        @if($i == 2)
                            <td></td>
                            <?php $i = 3 ?>
                        @endif
                    @endif
                @endif
                @if($i==3 || count($assets) == $key+1)
                    </tr>
                    <?php $i=0; ?>
                @endif        
                <?php $i++; ?>
            @endforeach
    </tbody>
</table>
