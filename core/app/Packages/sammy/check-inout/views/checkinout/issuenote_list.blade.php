@extends('layouts.sammy_new.master') @section('title','Check-In - Asset')
@section('css')
 <link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/file/bootstrap-fileinput-master/css/fileinput.css')}}"media="all" />
 <link rel="stylesheet" type="text/css" href="{{asset('assets/sammy_new/vendor/bootstrap3-wysihtml5/dist/bootstrap3-wysihtml5.min.css')}}"
 media="all" />
<style type="text/css">
.panel.panel-bordered {
	border: 1px solid #ccc;
}

.btn-primary {
	color: white;
	background-color: #005C99;
	border-color: #005C99;
}

.chosen-container{
	font-family: 'FontAwesome', 'Open Sans',sans-serif;
}

ul.wysihtml5-toolbar>li{
	margin: 0;
}

.wysihtml5-sandbox{
	border-style: solid!important;
	border-width: 1px!important;
	border-top: 0 none!important;
}

ul.wysihtml5-toolbar .btn{
	border-bottom: 0;
}

ul.wysihtml5-toolbar{
	border: 1px solid #e4e4e4;
}

.disabled-result{
	color:#515151!important;
	font-weight: bold!important;
}

.ms-container {
	width: 100% !important;
}
</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li class="active">Check-In Asset - Asset Management</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered" id="panel-search">
			<form role="form" class=" form-validation" method="get" enctype="multipart/form-data">
          	<div class="panel-body">
				<div class="form-group col-md-4">
					<label class="control-label">Asset Location</label>
					<select name="location" id="location" class="form-control chosen" required="required">
						@foreach($locations as $key=>$location)
							<option value="{{$key}}" @if($key==$old['location']) selected @endif>{{$location}}</option>
						@endforeach
					</select>
				</div>
                <div class="form-group col-md-5">
            		<label class="control-label">Issue Note NO</label>
            		<input type="text" name="no" id="no" class="form-control" value="{{$old['no']}}">
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                	<div class="pull-right" style="margin-top:23px">
	                	<button type="submit" class="btn btn-primary btn-search">
	                		<i class="fa fa-check"></i> search
	                	</button>
	                </div>
                </div>
          	</div>
			</form>
        </div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered" id="panel-search">
			<div class="panel-body">

				<table class="table table-hover">
					<thead>
					<tr>
						<th>#</th>
						<th>Issue Note No</th>
						<th>Assets</th>
						<th>Date</th>
						<th>From</th>
						<th>To</th>
						<th>Created By</th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
						<?php $i=1 ?>
						@foreach($notes as $note)
						<tr>
							<td>{{$i}}</td>
							<td>
								{{$note->issue_note_no}}
							</td>
							<td>Total: {{$note->details->count()}}</td>
							<td>{{$note->created_at->format('Y-m-d')}}</td>
							<td>{{$note->fromlocation->name}}</td>
							<td>{{$note->tolocation->name}}</td>
							<td>
								@if(isset($note->employee))
									{{$note->employee->first_name}} {{$note->employee->last_name}}
								@else
									-
								@endif	
							</td>
							<td>
								<a href="{{url('check-inout/issuenote/details')}}/{{$note->id}}" type="button" class="btn btn-info btn-xs">View</a>
								<a href="{{url('check-inout/print/issuenote')}}/{{$note->id}}" class="btn btn-info btn-xs">Print</a>
							</td>
						    <?php $i++ ?>
						</tr>
						@endforeach
					</tbody>
				</table>
				<?php echo $notes->appends(Input::except('page'))->render()?>
			</div>
		</div>
	</div>
</div>

@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/bootstrap3-wysihtml5/dist/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script src="{{asset('assets/sammy_new/file/bootstrap-fileinput-master/js/fileinput.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">
	var t=0;
	$(document).ready(function(){





	});
</script>
@stop
