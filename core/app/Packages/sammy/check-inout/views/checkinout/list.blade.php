@extends('layouts.sammy_new.master') @section('title','List - Asset')
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

.datatable{
	margin-bottom: 0;
}

.dataTables_wrapper{
	margin-top: 20px;
}

.disabled-result{
	color:#515151!important;
	font-weight: bold!important;
}

.value{
    font-weight: 800;
}

.close {
    font-weight: 800;
    font-size: 30px;
    margin-top: -10px;
    margin-right: -5px;
}

</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li>
    	<a href="javascript:;">Asset-Modal Management</a>
  	</li>
  	<li class="active">Asset-Modal List</li>
</ol>

<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
                <a href="{{{url('asset-modal/add')}}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> New</a>
        		<strong>Asset-Modal List</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
                    <div class="form-group">
	                	<div class="col-sm-12">
		                	<table class="table table-bordered bordered table-striped table-condensed datatable">
				              	<thead>
					                <tr>
                                        <th rowspan="2" class="text-center" width="4%">#</th>
                                        <th rowspan="2" class="text-center" width="18%" style="font-weight:normal;">Asset Modal</th>
					                  	<th rowspan="2" class="text-center" width="18%" style="font-weight:normal;">Category</th>
					                  	<th colspan="2" class="text-center" width="4%" style="font-weight:normal;">Action</th>
					                </tr>
					                <tr style="display: none;">
					                	<th style="display: none;" width="2%"></th>
					                	<th style="display: none;" width="2%"></th>
					                </tr>
				              	</thead>
				            </table>
				    	</div>
	                </div>
            	</form>
          	</div>
        </div>
	</div>
</div>
@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
	var table = '';
	$(document).ready(function(){

		$(".panel").addClass('panel-refreshing');
        table = generateTable('.datatable', '{{url('asset-modal/json/list')}}',[],[0,1,2],[],[],[0,"asc"]);
	    $(".panel").removeClass('panel-refreshing');

	});

</script>
@stop
