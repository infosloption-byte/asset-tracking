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
    <strong>ASSET DETAILS</strong>
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









    </tbody>
</table>
