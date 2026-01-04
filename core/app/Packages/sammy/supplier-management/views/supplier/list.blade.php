@extends('layouts.sammy_new.master') @section('title','Supplier List')
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

.datatable a.blue {
    color: #1975D1;
}

.datatable a.blue:hover {
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
    	<a href="#">Supplier Management</a>
  	</li>
  	<li class="active">Supplier List</li>
</ol>
<div class="row">
    <div class="col-xs-12">
        <form role="form" class="form-validation" method="get">
            <div class="panel panel-bordered" id="panel-search">
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-md-3 col-sm-6 col-xs-12">
                            <label class="control-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{$old->name}}">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <div class="pull-right" style="margin-top:23px">
                                <button type="submit" class="btn btn-primary btn-search">
                                    <i class="fa fa-check"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
      			<div class="row"><div class="col-xs-6"><strong>Supplier List</strong></div>
      			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
      			    <!-- <a class="btn btn-success" href="{{URL::to("manufacturer/trash")}}"><i class="fa fa-trash-o" style="width: 28px;"></i>Trash</a> -->
      			    <a class="btn btn-success" href="{{URL::to("supplier/add")}}"  style="margin-right: 10px"><i class="fa fa-plus" style="width: 28px;"></i>Add</a>
      			</div>
      		</div>
          	<div class="panel-body" style="overflow-x:scroll">
                <table class="table table-bordered">
                    <thead style="background:#ddd">
                        <th class="text-center" width="2%">#</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">City/Country</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">Contact</th>
                        <th class="text-center">Remarks</th>
                        <th colspan="2" class="text-center" width="6%">Action</th>
                    </thead>
                    <tbody>
                        @foreach($data as $key=>$supplier)
                            <tr>
                                <td>{{$key+1}}</td>
                                @if($supplier->name!="")<td>{{$supplier->name}}</td>@else<td> - </td>@endif
                                
                                <?php $country=""; ?>
                                <?php $city=""; ?>
                                
                                @if($supplier->country!="")<?php $country.='Country - '.$supplier->country; ?>@else<?php $country.="Country - "; ?>@endif
                                @if($supplier->city!="")<?php $city.='City - '.$supplier->city; ?>@else<?php $city.="City - "; ?>@endif
                                
                                <td>
                                    <p>{{$country}}</p>
                                    <p>{{$city}}</p>
                                </td>

                                @if($supplier->address!="")<td>{{$supplier->address}}</td>@else<td> - </td>@endif

                                
                                <?php $phone=""; ?>
                                <?php $fax=""; ?>
                                <?php $email=""; ?>
                                
                                @if($supplier->phone!="")<?php $phone.="Phone - ".$supplier->phone; ?>@else<?php $phone.="Phone - "; ?>@endif
                                @if($supplier->fax!="")<?php $fax.="Fax - ".$supplier->fax; ?>@else<?php $fax.="Fax - "; ?>@endif
                                @if($supplier->email!="")<?php $email.="Emai - ".$supplier->email; ?>@else<?php $email.="Emai - "; ?>@endif

                                <td>
                                    <p>{{$phone}}</p>
                                    <p>{{$fax}}</p>
                                    <p>{{$email}}</p>
                                </td>

                                @if($supplier->remark!="")<td>{{$supplier->remark}}</td>@else<td> - </td>@endif

                                @if(Sentinel::hasAnyAccess(['supplier.edit','admin']))
                                    <td><a href="{{url('supplier/edit')}}/{{$supplier->id}}" data-toggle="tooltip" data-placement="top" title="Edit Supplier"><i class="fa fa-pencil" style="color: blue"></i></a></td>
                                @else
                                    <td><a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a></td>
                                @endif


                                @if(Sentinel::hasAnyAccess(['supplier.status','admin']))
                                    @if($supplier->status==1)
                                        <td>
                                            <label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Click to Deactivate">
                                                <input class="supplier-activate" type="checkbox" checked value="{{$supplier->id}}">
                                                <span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span>
                                            </label>
                                        </td>
                                    @else
                                        <td>
                                            <label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Click to Deactivate">
                                                <input class="supplier-activate" type="checkbox" value="{{$supplier->id}}">
                                                <span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span>
                                            </label>
                                        </td>
                                    @endif
                                @else
                                    @if($supplier->status==1)
                                        <td>
                                            <label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Deactivate Disabled">
                                                <input disabled class="supplier-activate" type="checkbox" checked value="{{$supplier->id}}">
                                                <span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span>
                                            </label>
                                        </td>
                                    @else
                                        <td>
                                            <label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Deactivate Disabled">
                                                <input disabled class="supplier-activate" type="checkbox" value="{{$supplier->id}}">
                                                <span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span>
                                            </label>
                                        </td>
                                    @endif
                                @endif
                                

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <?php echo $data->appends(Input::except('page'))->render()?>
                <br>
          		<?php echo "Total Row Count : ".$row_count;?>
          	</div>
        </div>
	</div>
</div>
@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
	
	$(document).ready(function(){
	   $('.supplier-activate').change(function(){
            $('.panel').addClass('panel-refreshing');
            if($(this).prop('checked')==true){                  
                ajaxRequest( '{{url('supplier/status')}}' , { 'id' : $(this).val() , 'status' : 1 }, 'post', successFunc);
            }else{                  
                ajaxRequest( '{{url('supplier/status')}}' , { 'id' : $(this).val() , 'status' : 0 }, 'post', successFunc);
            }
        });	
	});

	function successFunc(data){
        if(data.status=='success'){
            $('.panel').removeClass('panel-refreshing');
            sweetAlert('Success','Action Successfully Done!',0);
    		window.location.reload();
        }else{
            sweetAlert('Error Occured','Please try again!',3);
        }
	}
</script>
@stop
