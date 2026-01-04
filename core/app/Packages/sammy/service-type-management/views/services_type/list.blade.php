@extends('layouts.sammy_new.master') @section('title','Service List')
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
    	<a href="#">Service Type Management</a>
  	</li>
  	<li class="active">Service Type List</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
      			<div class="row"><div class="col-xs-6"><strong>Service Type List</strong></div>
      			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
      			    <!-- <a class="btn btn-success" href="{{URL::to("service/type/trash")}}"><i class="fa fa-trash-o" style="width: 28px;"></i>Trash</a> -->
      			    <a class="btn btn-success" href="{{URL::to("service/type/add")}}"  style="margin-right: 10px"><i class="fa fa-plus" style="width: 28px;"></i>Add</a>
      			</div>
      		</div>
          	<div class="panel-body" style="overflow-x:scroll">
                <table class="table table-bordered">
                    <thead style="background:#ddd">
                        <th class="text-center" width="2%">#</th>
                        <th class="text-center">Name</th>
                        <th colspan="2" class="text-center" width="6%">Action</th>
                    </thead>
                    <tbody>
                        @foreach($data as $key=>$type)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$type->name}}</td>

                                @if(Sentinel::hasAnyAccess(['service.type.edit','admin']))
                                    <td><a href="{{url('service/type/edit')}}/{{$type->id}}" data-toggle="tooltip" data-placement="top" title="Edit Service Type"><i class="fa fa-pencil" style="color: blue"></i></a></td>
                                @else
                                    <td><a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a></td>
                                @endif


                                @if(Sentinel::hasAnyAccess(['service.type.status','admin']))
                                    @if($type->status==1)
                                        <td>
                                            <label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Click to Deactivate">
                                                <input class="type-activate" type="checkbox" checked value="{{$type->id}}">
                                                <span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span>
                                            </label>
                                        </td>
                                    @else
                                        <td>
                                            <label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Click to Deactivate">
                                                <input class="type-activate" type="checkbox" value="{{$type->id}}">
                                                <span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span>
                                            </label>
                                        </td>
                                    @endif
                                @else
                                    @if($type->status==1)
                                        <td>
                                            <label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Deactivate Disabled">
                                                <input disabled class="type-activate" type="checkbox" checked value="{{$type->id}}">
                                                <span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span>
                                            </label>
                                        </td>
                                    @else
                                        <td>
                                            <label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Deactivate Disabled">
                                                <input disabled class="type-activate" type="checkbox" value="{{$type->id}}">
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
                <?php echo "Total Row Count : ".$row_count?>
            </div>
        </div>
	</div>
</div>
@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
       $('.type-activate').change(function(){
            $('.panel').addClass('panel-refreshing');
            if($(this).prop('checked')==true){                  
                ajaxRequest( '{{url('service/type/status')}}' , { 'id' : $(this).val() , 'status' : 1 }, 'post', successFunc);
            }else{                  
                ajaxRequest( '{{url('service/type/status')}}' , { 'id' : $(this).val() , 'status' : 0 }, 'post', successFunc);
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
