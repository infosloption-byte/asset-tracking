@extends('layouts.sammy_new.master') @section('title','Manufacturer List')
@section('css')
<style type="text/css">

</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li>
    	<a href="#">Report Management</a>
  	</li>
  	<li class="active">Manufacturer Report</li>
</ol>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-bordered">
			<div class="panel-heading border">
				<h4><strong>Manufacturer Report</strong></h4>
			</div>
			<div class="panel-header" style="text-align: center">
				<form method="get">
					<h4 style="padding: 10px">Manufacturer Report</h4>
					<div class="container-fluid">
						<div class="row">
							<div class="form-group col-md-6 text-left">
								<label class="control-label">Keyword</label>
								<input type="text" class="form-control" name="keywords" value="{{$old->keywords}}">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="pull-right" style="margin-left:8px;margin-right: 15px">
									<button type="button" class="btn btn-danger btn-pdf">
										<i class="fa fa-download"></i> PDF
									</button>
								</div>

								<div class="pull-right" style="margin-left:8px">
									<button type="button" class="btn btn-warning btn-excel">
										<i class="fa fa-download"></i> Excel
									</button>
								</div>
								<div class="pull-right" style="margin-left:8px">
									<button type="submit" class="btn btn-primary btn-search">
										<i class="fa fa-check"></i> Search
									</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="panel panel-bordered">
				      		<div class="panel-body" style="overflow-x:scroll">
				      			<table class="table table-bordered">
				          			<thead style="background:#ddd">
					                  	<th class="text-center" width="2%">#</th>
					                  	<th class="text-center">Name</th>
				          			</thead>
				          			<tbody>
										@if(count($data) > 0)
											@foreach($data as $key => $row)
											<tr>
												<td width="4%">{{ (($data->currentPage()-1)*$data->perPage())+($key+1) }}</td>
												<td>{{ $row->name }}</td>
											</tr>
											@endforeach
										@else
											<tr>
												<td colspan="2" class="text-center"> - No Data - </td>
											</tr>
										@endif
				          			</tbody>
				          		</table>
				          		{!! $data->appends($old->except('page'))->render() !!}
				                <br>
				                <?php echo "Total Row Count : ".$data->total()?>
				      		</div>
				      	</div>	
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
	var id = 0;

	$(document).ready(function(){
		$('.btn-excel').click(function(e){
			e.preventDefault();

			var query = window.location.search;

        	window.location.href = '{{url('reports/manufacturer-report/download/excel')}}'+query;

		});

		$('.btn-pdf').click(function(e){
			e.preventDefault();

			var query = window.location.search;

        	window.open('{{url('reports/manufacturer-report/download/pdf')}}'+query,'_blank');

		});
	});

	function pageReload(){
		window.location.href = window.location.href;
	}
</script>
@stop