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

<table width="100%">
    <tbody>

        <tr>
            <td style="line-height: 2">

            </td>
        </tr>

        <tr>
            <td width="100%">
                <table border="1px" width="100%">
                    <thead>
                        <tr style="line-height: 2;text-align: left">
                            @foreach($headers as $value)
                                <th>&nbsp;{{ $value }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody id="tbody">
                    @foreach($data as $detail)
                        <tr style="line-height: 2;text-align: left">
                            @foreach($detail as $value)
                                <td>&nbsp;{{$value}}</td>
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
