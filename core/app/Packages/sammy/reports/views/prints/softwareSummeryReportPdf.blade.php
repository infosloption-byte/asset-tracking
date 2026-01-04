<style type="text/css">

    td{
        font-weight: 400;
        font-size: 8px;
    }th {
        text-align: left;
    }.border{
        border-width:1px;
        border-style:solid;
    }.border-left{
        border-left-style:solid;
        border-width:1px;
    }.border-right{
        border-right-style:solid;
        border-width:1px;
    }.border-top{
        border-top-style:solid;
        border-width:1px;
    }.border-bottom {
        border-bottom-style:solid;
        border-width:1px;
    }

</style>
@if($basic)
<table width="100%">
    <tbody>
        <tr>
            <td>
                <table border="1px">
                    <thead>
                        <tr style="line-height: 2;text-align: left">
                            <td>No of License</td>
                            <td>Usage of License</td>
                            <td>Remaining License</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="line-height: 2;text-align: left">
                            <td>{{($basic)?$basic->max_users:'-'}}</td>
                            <td>{{($used_count)?$used_count:'-'}}</td>
                            <td>{{($used_count && $basic)?($basic->max_users-$used_count):'-'}}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td width="33%"></td>
            <td>
                <table border="1px">
                    <thead>
                        <tr style="line-height: 2;text-align: left">
                            <td>Supplier</td>
                            <td>License Start Date</td>
                            <td>License End Date</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="line-height: 2;text-align: left">
                            <td>{{$basic['supplier']->name}}</td>
                            <td>{{$basic->license_from}}</td>
                            <td>{{$basic->license_to}}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
@endif

<table width="100%">
    <tbody>

        <tr>
            <td style="line-height: 3">

            </td>
        </tr>

        <tr>
            <td width="100%">
                <table border="1px" width="100%">
                    <tbody id="tbody">
                    @foreach($data as $detail)
                        <tr style="line-height: 2;text-align: center">
                            @foreach($detail as $value)
                                <td>{{$value}}</td>
                            @endforeach
                        </tr>
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