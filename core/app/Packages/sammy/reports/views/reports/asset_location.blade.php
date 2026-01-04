@extends('layouts.sammy_new.master') @section('title','Add Menu')
@section('css')
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
</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li class="active">Asset Details In Location</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border" >
				<h4><strong>Asset Details In Location</strong></h4>
      		</div>
          	<div class="panel-body">
          		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          				<!-- Name -->
      				<div class="row">
      					<div class="col-xs-6 col-sm-6 col-md-6">
		      				<div class="form-group">
		      					<label for="" class="required">Location</label>
		      					<select name="location" id="location" class="form-control chosen" required="required">
									@foreach($locations as $key=>$location)
										<option value="{{$key}}" @if($key==$old['location']) selected @endif>{{$location}}</option>
									@endforeach
								</select>
		            		</div>
		            	</div>
		            	<div class="col-xs-2 col-sm-2 col-md-2">
		            		<div class="form-group" style="margin-top: 30px">
		      					<label class="control-label">With Sub Location</label>
								<input type="checkbox" name="sub_loc" id="sub_loc" style="margin-top: 5px">
		            		</div>
	      				</div>
	      				<div class="col-xs-4 col-sm-4 col-md-4">
		            		<div class="pull-right" style="margin-top:30px;margin-left:8px">
								<button type="button" class="btn btn-danger btn-pdf disabled">
									<i class="fa fa-download"></i> PDF
								</button>
							</div>
							
							<div class="pull-right" style="margin-top:30px;margin-left:8px">
								<button type="button" class="btn btn-warning btn-excel disabled">
									<i class="fa fa-download"></i> Excel
								</button>
							</div>

							<div class="pull-right" style="margin-top:30px">
								<button type="submit" class="btn btn-primary btn-search">
									<i class="fa fa-search"></i> Search
								</button>
							</div>
	      				</div>
	      			</div>

	      			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	      				<hr>
	      			</div>

	      			<hr>	
	      			<table class="table table-bordered bordered table-striped table-condensed datatable">
		              	<thead>
			                <tr>
				                <th  class="text-center" width="5%">#</th>
			                    <th  class="text-left" style="font-weight:normal;">Asset Model</th>
			                    <th  class="text-right" style="font-weight:normal;">Total</th>
			                    <th  class="text-right" style="font-weight:normal;">Total Value</th>
			                    <th  class="text-right" style="font-weight:normal;">Deployed</th>
			                    <th  class="text-right" style="font-weight:normal;">Un-Deployed</th>
			                    <th  class="text-right" style="font-weight:normal;">In Service</th>
			                    <th  class="text-right" style="font-weight:normal;">Disposed</th>
			                </tr>
		              	</thead>
		              	<tbody id="data-body">
		              	</tbody>
		            </table>
		      	</div>			
          	</div>
        </div>
	</div>
</div>
@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.form-validation').validate();
		$('#permissions').multiSelect();

		var langs = JSON.parse('{!!json_encode($old)!!}');

		sub_loc=langs.sub_loc;

		if(sub_loc==1){
			$('#sub_loc').prop('checked',true);
		}

		if(sub_loc==0){
			$('#sub_loc').prop('checked',false);
		}

		$('.btn-search').on('click', function(){
			$('#data-body').html('');
			$('.panel').addClass('panel-refreshing');
			var id = $('#location').val();
			if($('#sub_loc').is(":checked")){
				var sub = 'on';
			}else{
				var sub = 'off';
			}

			console.log(id);

			$.ajax({
                url: "{{url('reports/asset_location/json/getAssetDataInLocation')}}" ,
                type: 'get',
                data: { 'id':id,'sub_loc':sub },
                success: function(data) {

                	if(data.data.length>0){
                		$('.btn-pdf').removeClass('disabled');
                		$('.btn-excel').removeClass('disabled');
                	}else{
                		$('.btn-pdf').addClass('disabled');
                		$('.btn-excel').addClass('disabled');
                	}

	                $.each(data.data,function(key,value){
	                	$('#data-body').append(
	                		'<tr>'
	                			+'<td>'+value[0]+'</td>'
	                			+'<td>'+value[1]+'</td>'
	                			+'<td style="text-align: right">'+value[2]+'</td>'
	                			+'<td style="text-align: right">'+value[3]+'</td>'
	                			+'<td style="text-align: right">'+value[4]+'</td>'
	                			+'<td style="text-align: right">'+value[5]+'</td>'
	                			+'<td style="text-align: right">'+value[6]+'</td>'
	                			+'<td style="text-align: right">'+value[7]+'</td>'
	                		+'</tr>'
	                	);
	                });
	                $('.panel').removeClass('panel-refreshing');
                },
                error: function(xhr, textStatus, thrownError) {
                    console.log(thrownError);
                }
            });

		});

		$('.btn-excel').click(function(e){
			e.preventDefault();

        	loc = $("#location").val();
        	sub_loc = $("#sub_loc").val();

        	window.location.href = '{{url('reports/asset-location/download/excel')}}?location='+loc+'&sub_loc='+sub_loc;

		});

		$('.btn-pdf').click(function(e){
			e.preventDefault();

        	loc = $("#location").val();
        	sub_loc = $("#sub_loc").val();

        	window.open('{{url('reports/asset-location/download/pdf')}}?location='+loc+'&sub_loc='+sub_loc,'_blank');

		});

	});
</script>
@stop
