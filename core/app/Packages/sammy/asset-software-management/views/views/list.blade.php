@extends('layouts.sammy_new.master') @section('title','Software List')
@section('css')
    <style type="text/css">
        .switch.switch-sm{
            width: 30px;
            height: 16px;
        }

        .switch.switch-sm span i::before{
            width: 16px;
            height: 16px;
        }

        .btn-success:hover, .btn-success:focus, .btn-success.focus, .btn-success:active, .btn-success.active, .open > .dropdown-toggle.btn-success {
            color: white;
            background-color: #D96557;
            border-color: #D96557;
        }
        .btn-success {
            color: white;
            background-color: #D96456;
            border-color: #D96456;
        }


        .btn-success::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            background-color: #BB493C;
            -moz-opacity: 0;
            -khtml-opacity: 0;
            -webkit-opacity: 0;
            opacity: 0;
            -ms-filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0 * 100);
            filter: alpha(opacity=0 * 100);
            -webkit-transform: scale3d(0.7, 1, 1);
            -moz-transform: scale3d(0.7, 1, 1);
            -o-transform: scale3d(0.7, 1, 1);
            -ms-transform: scale3d(0.7, 1, 1);
            transform: scale3d(0.7, 1, 1);
            -webkit-transition: transform 0.4s, opacity 0.4s;
            -moz-transition: transform 0.4s, opacity 0.4s;
            -o-transition: transform 0.4s, opacity 0.4s;
            transition: transform 0.4s, opacity 0.4s;
            -webkit-animation-timing-function: cubic-bezier(0.2, 1, 0.3, 1);
            -moz-animation-timing-function: cubic-bezier(0.2, 1, 0.3, 1);
            -o-animation-timing-function: cubic-bezier(0.2, 1, 0.3, 1);
            animation-timing-function: cubic-bezier(0.2, 1, 0.3, 1);
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
        }


        .switch :checked + span {
            border-color: #398C2F;
            -webkit-box-shadow: #398C2F 0px 0px 0px 21px inset;
            -moz-box-shadow: #2ecc71 0px 0px 0px 21px inset;
            box-shadow: #398C2F 0px 0px 0px 21px inset;
            -webkit-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
            -moz-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
            -o-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
            transition: border 300ms, box-shadow 300ms, background-color 1.2s;
            background-color: #398C2F;
        }

        .btn-actions {
            color: #1975D1;
        }

        .btn-actions:hover {
            color: #003366;
        }

    </style>
@stop
@section('content')
    <ol class="breadcrumb">
        <li>
            <a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
        </li>
        <li>
            <a href="#">Assets Management</a>
        </li>
        <li class="active">Assets List</li>
    </ol>

    <form role="form" class="form-validation" method="get">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-bordered" id="panel-search">
                    
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label class="control-label">Search</label>
                                    <input type="text" name="keyword" id="keyword" class="form-control" value="{{$old['keyword']}}" placeholder="Ex: Asset or Name">
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="control-label">Version</label>
                                    <input type="text" name="sversion" id="sversion" class="form-control" value="{{$old['sversion']}}" placeholder="Ex: 2.0.1">
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="control-label">Manufacturers</label>
                                    <select name="manufacturer" id="manufacturer" class="form-control chosen" required="required">
                                        <option value="0">-ALL-</option>
                                        @foreach($manufacturers as $manufacturer)
                                            <option value="{{$manufacturer->id}}" @if($manufacturer->id==$old['manufacturer']) selected @endif>{{$manufacturer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="control-label">Supplier</label>
                                    <select name="supplier" id="supplier" class="form-control chosen" required="required">
                                        <option value="0">-ALL-</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{$supplier->id}}" @if($supplier->id==$old['supplier']) selected @endif>{{$supplier->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="control-label">Category</label>
                                    <select name="category" id="category" class="form-control chosen" required="required">
                                        <option value="0">-ALL-</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" @if($category->id==$old['category']) selected @endif>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="pull-right" style="margin-top:8px">
                                        <button type="submit" class="btn btn-primary btn-search">
                                            <i class="fa fa-check"></i> search
                                        </button>
                                    </div>

                                    <a style="margin-top:8px;margin-right:8px" class="btn btn-success pull-right" href="{{URL::to("software/license/add")}}"  style="margin-right: 10px">
                                        <i class="fa fa-plus" style="width: 28px;"></i>Add
                                    </a>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-bordered">
                <div class="panel-heading border">
                    <div class="row">
                        <div class="col-xs-6">
                            <strong style="font-size:13px;font-weight: bold">Assets List</strong>
                        </div>                        
                    </div>
                </div>
                <div class="panel-body">
                   <table class="table table-bordered" style="width:100%">
                        <thead style="background:#ddd">
                            <tr>
                                <th width="5%">#</th>
                                <th>AssetNo</th>
                                <th>Software Name</th>
                                <th>Version</th>
                                <th>Manufacture</th>
                                <th>Supplier</th>
                                <th>Category</th>
                                <th>No Of Users</th>
                                <th>Used</th>
                                <th>License</th>
                                <th>Expire</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($data)>0)
                            @foreach($data as $key=>$item)
                            <tr @if($item->license_to!=NULL && $item->license_to <= date('Y-m-d')) style="background-color: red;color: #fff" @endif>
                                <td>{{$key+1}}</td>
                                <td>
                                    {{$item->asset_no}}
                                </td>
                                <td>
                                    {{$item->name}}
                                </td>
                                <td>
                                    {{$item->version}}
                                </td>
                                <td><span>{{$item->manufacture->name}}</span></td>
                                <td><span>{{$item->supplier->name}}</span></td>
                                <td>{{$item->category}}</td>
                                <td>{{$item->max_users>0?$item->max_users:"UNLIMITED"}}</td>
                                <td>{{$item->details->count()}}</td>
                                <td>
                                    @if($item->license_to != null)
                                        From - {{$item->license_from}}<br> To - {{$item->license_to}}
                                    @else
                                        NO EXPIRY
                                    @endif
                                </td>
                                    <td>
                                        @if($item->license_to != null)
                                    <?php
                                    $date1 = date("Y-m-d");
                                    $date2 = $item->license_to;

                                    $diff = abs(strtotime($date2) - strtotime($date1));

                                    $years = floor($diff / (365*60*60*24));
                                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                                    printf("%d years, %d months, %d days\n", $years, $months, $days); 
                                    ?>
                                        @else
                                            NO EXPIRY
                                        @endif
                                </td>
                                <td>
                                    @if(Sentinel::hasAnyAccess(['software.license.assign', 'admin']))
                                        <a href="{{url('software/license/assign/')}}/{{$item->id}}" class="btn  btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="View Item">assign</a>
                                        <a href="{{url('software/license/details/')}}/{{$item->id}}" class="btn  btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="View Item">view</a>
                                    @else
                                        <a href="#" class="disabled btn-actions" data-toggle="tooltip" data-placement="top" title="View Disabled"></a>
                                        <a href="#" class="disabled btn-actions" data-toggle="tooltip" data-placement="top" title="View Disabled"></a>
                                    @endif
                                </td>   
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="text-center">
                                   <h4>No Data Found</h4> 
                                   <p>sorry we couldnt found any data matching your filter</p> 
                                </td>
                            </tr>    
                        @endif
                        
                        </tbody>
                    </table>
                    @if(count($data)>0)
                        <?php echo $data->appends(Input::except('page'))->render()?>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
        var id = 0;
        var table = '';
        $(document).ready(function(){

        });



    </script>
@stop
