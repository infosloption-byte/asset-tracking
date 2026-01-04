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
    <strong>Asset Request Summery Report </strong>
</div>

<table width="100%">
    <tbody>

        <tr>
            <td style="line-height: 2">

            </td>
        </tr>

        <tr>
            <td width="100%">
                {!! $data !!}
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
