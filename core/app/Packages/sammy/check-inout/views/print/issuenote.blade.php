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
    <strong>ISSUE NOTE</strong>
    <strong><h5>{{$note->issue_note_no}}</h5></strong>
</div>

<table width="100%">
    <tbody>

        <tr>
            <td style="line-height: 2">

            </td>
        </tr>


        <tr>
            <td style="line-height: 1.3">
                <span style="margin: 0;font-weight:900"> <strong>Issue Note No : {{$note->issue_note_no}}</strong> </span> <br>
                <span style="margin: 0"> Date : {{$note->created_at->format('Y-m-d')}}</span><br>
                <span style="margin: 0"> From : {{$note->fromlocation->name}}</span><br>
                <span style="margin: 0"> To : {{$note->tolocation->name}}</span><br>
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
                        <tr  style="line-height: 3">
                            <th style="text-align: center" width="5%"> #</th>
                            <th style="text-align: center" width="16%"> Asset SerialNo</th>
                            <th style="text-align: center" width="16%"> Asset InventoryNo</th>
                            <th style="text-align: center" width="16%"> Status</th>
                            <th style="text-align: center" width="16%"> Model</th>
                            <th style="text-align: center" width="16%"> Supplier</th>
                            <th style="text-align: center" width="15%"> Note</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                    <?php $i=1 ?>
                    @foreach($note->details as $asset)
                        <tr  style="line-height: 2;text-align: center">
                            <td width="5%">
                                 {{$i}}
                            </td>
                            <td style="text-align: center">
                                {{$asset->asset->asset_no}}
                            </td>
                            <td style="text-align: center">@if($asset->asset->inventory_no!=null){{$asset->asset->inventory_no}}@else-@endif</td>
                            <td style="text-align: center">                            
                                @if(count($asset->asset->transaction)>0)
                                     {{$asset->asset->transaction[0]->status->name}}
                                @else
                                    -
                                @endif
                            </td>
                            <td style="text-align: center"> {{$asset->asset->assetmodel->name}}</td>
                            <td style="text-align: center"> {{$asset->asset->supplier->name}}</td>
                            <td style="text-align: center">  </td>
                        </tr>
                        <?php $i++ ?>
                    @endforeach

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
