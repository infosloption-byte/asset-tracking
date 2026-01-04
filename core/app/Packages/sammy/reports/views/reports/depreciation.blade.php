@extends('layouts.sammy_new.master') @section('title','Depreciation Report')
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
  	<li>
    	<a href="#">Report Management</a>
  	</li>
  	<li class="active">Depreciation Report</li>
</ol>


<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">			

      		<div class="panel-heading border text-center" >
      			<div class="row">
      				<div class="col-md-4"></div>
      				<div class="col-md-4">
      					<h4><strong>Depreciation Report</strong></h4>
        				<h5 style="font-weight: 600">Asset ({{$asset->asset_no}})</h5>
      				</div>
      				<div class="col-md-4">
      					<div class="pull-right" style="margin-top:8px;margin-left:8px">
							<button type="button" class="btn btn-primary btn-pdf">
								<i class="fa fa-download"></i> PDF
							</button>
						</div>
      				</div>
      			</div>
      		</div>

      		<div class="row">
      			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
      					<h6 style="font-weight: 600">Inventory No  : {{$asset->inventory_no!=null?$asset->inventory_no:'-'}}</h6>
	      				<h6 style="font-weight: 600">Purchased Value  : {{CURRENCY}}{{$asset->purchased_value}}</h6>
	      				<h6>Scrap Value  : {{$asset->scrap_value}}</h5>

	      				<div class="text-left">
		      				@if($asset->barcode!=null)
					            <?php echo DNS1D::getBarcodeSVG($asset->asset_no, $asset->barcode->barcodetype->name,1.5,40) ?><br>
							@else
								<div id="barcode_wrapper_empty" data-barcodeType="0" class="text-center" >
									<h5>barcode not genarated</h5>
								</div>
							@endif
						</div>

	      			</div>

          			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
          				<h6 style="font-weight: 600">Supplier : {{$asset->supplier->name}} ({{$asset->supplier->country}} - {{$asset->supplier->city}})</h6>
          				<h6 >Address : {{$asset->supplier->address}}</h6>
          				<h6 >Contact No : {{$asset->supplier->phone}}</h6>
          				<h6 >Email : {{$asset->supplier->email}}</h6>
          			</div>      				
      			</div>

      		</div>


  			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  				<hr>
  			</div>


          	<div class="panel-body">
          		<div class="row"> 		
	      			<table class="table table-bordered" id="table">
						<thead>
							<tr>
								<th scope="col">Year</th>
								<th scope="col">Book Value Year Start</th>
								<th scope="col">Depreciation Percent</th>
								<th scope="col">Depreciation Expense</th>
								<th scope="col">Accumulated Depreciation</th>
								<th scope="col">Book Value Year End</th>
							</tr>	
						</thead>
						<tbody>	
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
		      	</div>			
          	</div>
        </div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
	    <div class="panel panel-bordered">
	        <div class="panel-heading border">
	            <div class="row">
	                <div class="col-xs-6">
	                    <strong style="font-size:13px;font-weight: bold">Assets Upgrades</strong>
	                </div>
	            </div>
	        </div>
	        <div class="panel-body">
	           <form role="form" class=" form-validation" method="post" enctype="multipart/form-data">
	            {!!Form::token()!!}
	            @if($errors->has('asset'))
	                <label id="label-error" class="error" for="label">{{$errors->first('asset')}}</label>
	            @endif

	            <table class="table table-bordered table-hover" >
	                <thead style="background-color: #5e9acc;color: #fff">
	                <tr>
	                    <th width="5%"#</th>
	                    <th >Serial No</th>
	                    <th >Inventory No</th>
	                    <th >Asset Status</th>
	                    <th >Purchased Date</th>
	                    <th >Recovery Period</th>
	                    <th >Asset Model</th>
	                    <th>Asset Location</th>
	                </tr>
	                </thead>
	                <tbody id="tbody">
	                <?php $i=1 ?>
	                    @foreach($history->upgradehistory as $key=>$item)
	                    	@if($item->ended_at==null)
	                        <tr>
	                            <td>{{$key+1}}</td>
	                            <td>
	                                <a href="{{url('asset/view/')}}/{{$item->id}}" class="link" data-toggle="tooltip" data-placement="top" title="View Item" style="text-decoration:underline;color:blue">#{{$item->asset->asset_no}}</a> 
	                            </td>
	                            <td>
	                                @if($item->asset->inventory_no!=null)
	                                    #{{$item->asset->inventory_no}}
	                                @else
	                                    -
	                                @endif                                      
	                            </td>
	                            <td>
	                                @if(count($item->asset->transaction)>0)
	                                    @if($item->asset->transaction[0]->status->id==ASSET_UNDEPLOY)
	                                        <span class="badge" style="font-size: 10px;background-color: #dda30c">{{$item->asset->transaction[0]->status->name}}</span>
	                                    @elseif($item->asset->transaction[0]->status->id==ASSET_DISPOSED)
	                                        <span class="badge" style="font-size: 10px;background-color: #dd1144">{{$item->asset->transaction[0]->status->name}}</span>
	                                    @elseif($item->asset->transaction[0]->status->id==ASSET_INSERVICE)
	                                        <span class="badge" style="font-size: 10px;background-color: #74dd00">{{$item->asset->transaction[0]->status->name}}</span>
	                                    @elseif($item->asset->transaction[0]->status->id==ASSET_DEPLOY)
	                                        <span class="badge" style="font-size: 10px;background-color: #3e3aff">{{$item->asset->transaction[0]->status->name}}</span>
	                                    @else
	                                        <span class="badge" style="font-size: 10px;">{{$item->asset->transaction[0]->status->name}}</span>
	                                    @endif
	                                @else
	                                    -
	                                @endif
	                            </td>
	                            <td>
	                                @if($item->asset->purchased_date!=null)
	                                    {{$item->asset->purchased_date}}
	                                @else
	                                    -
	                                @endif                                      
	                            </td>
	                            <td>
	                                @if($item->asset->recovery_period!=null)
	                                    {{$item->asset->recovery_period}}
	                                @else
	                                    -
	                                @endif                                      
	                            </td>
	                            <td>@if($item->asset->assetmodel!=null)
	                                    {{$item->asset->assetmodel->name}}
	                                @else
	                                    -
	                                @endif</td>
	                            <td>
	                                @if(count($item->asset->transaction)>0)
	                                    <span>{{$item->asset->transaction[0]->location->name}}</span>
	                                @else
	                                    -
	                                @endif
	                            </td>
	                        @endif    
	                    @endforeach
	                    </tbody>
	                </table>

	            </form>
	        </div>
	    </div>
	</div>
	</div>

@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
	var withoutAssign = false;

	$(document).ready(function(){

		$('.form-validation').validate();
		$('#permissions').multiSelect();
		var id = {{$asset->id}};
		

		$('.btn-pdf').click(function(e){
			e.preventDefault();

        	window.open('{{url('reports/depreciation/details/pdf')}}?id='+id,'_blank');

		});

		$('.panel').addClass('panel-refreshing');

		loadData(id);

		window.depri = (function () {

	        var straight_line_depreciation_percent = function (usefull_life) {
	                return (100/usefull_life);
	            },
	            depreciation_rate = function (factor,usefull_life) {
	                return factor*(straight_line_depreciation_percent(usefull_life));
	            };
	        return {
	            decliningFirst: function (begin,factor,usefull_life,month) {
	            	var rest_of = 12-month;
	                return (rest_of/12)*depreciation_rate(factor,usefull_life);	
	            },
	            depreciation_rate: function (factor,usefull_life) {
	            	 return factor*(straight_line_depreciation_percent(usefull_life));	
	            },
	            generateDecliningSchedule: function (begin,factor,usefull_life,month,year) {	 
	            	var result =[];
	            	var a = 0;            	
	            	var first_year_rate   = this.decliningFirst(begin,factor,usefull_life,month);
	            	var depreciation_rate = this.depreciation_rate(factor,usefull_life);
	            	var last_year_rate    = depreciation_rate-this.decliningFirst(begin,factor,usefull_life,month);

	            	result.push({
						year 				: year,
						book_value 			: begin,
						depreciation_expense: ((first_year_rate)/100*begin).toFixed(0),
						depreciation_rate 	: first_year_rate,
						accumulated 		: ((first_year_rate)/100*begin).toFixed(0),
						book_value_year_end : begin-((first_year_rate)/100*begin).toFixed(0),
                    });

	                for (i = 0; i < usefull_life; i++) {
	                	a=i;
	                	var accumulated = 0;
	                	if(i>0 && i<usefull_life){
	                		result.push({
		                        year 				: year+i,
								book_value 			: result[i-1].book_value_year_end,
								depreciation_expense: ((depreciation_rate)/100*result[i-1].book_value_year_end).toFixed(0),
								depreciation_rate 	: depreciation_rate,
								accumulated 		: parseFloat(((depreciation_rate)/100*result[i-1].book_value_year_end).toFixed(0))+parseFloat(result[i-1].accumulated),
								book_value_year_end : result[i-1].book_value_year_end-((depreciation_rate)/100*result[i-1].book_value_year_end).toFixed(0),
		                    });
	                	}    
	                }

	                result.push({
						year 				: year+a+1,
						book_value 			: result[a].book_value_year_end,
						depreciation_expense: ((last_year_rate)/100*parseFloat(result[a].book_value_year_end)).toFixed(0),
						depreciation_rate 	: depreciation_rate-first_year_rate,
						accumulated 		: parseFloat(((last_year_rate)/100*result[a].book_value_year_end).toFixed(0))+parseFloat(result[a].accumulated),
						book_value_year_end : result[a].book_value_year_end-((last_year_rate)/100*result[a].book_value_year_end).toFixed(0),
                    });


	                return result;
	            },
	            generateStraightSchedule: function (cost,salvage,life,month,year) {	 
					var result                     = [];
					var a                          = 0;					
					var rest_of                    = 12-month;	
					var depreciation_in_any_period = ((cost - salvage)/life);
					var depreciation_in_first_year = (rest_of/ 12)*((cost - salvage)/life);
					var depreciation_in_last_year  = ((12 - rest_of) / 12) * ((cost - salvage) / life);

	            	result.push({
						year 				: year,
						book_value 			: cost,
						depreciation_expense: depreciation_in_first_year.toFixed(0),
						accumulated 		: depreciation_in_first_year.toFixed(0),
						book_value_year_end : cost-depreciation_in_first_year.toFixed(0),
                    });

	                for (i = 0; i < life; i++) {
	                	a=i;
	                	var accumulated = 0;
	                	if(i>0 && i<life){
	                		result.push({
		                        year 				: year+i,
								book_value 			: parseFloat(result[i-1].book_value_year_end).toFixed(0),
								depreciation_expense: depreciation_in_any_period.toFixed(0),
								accumulated 		: (depreciation_in_any_period+parseFloat(result[i-1].accumulated)).toFixed(0),
								book_value_year_end : (result[i-1].book_value_year_end-depreciation_in_any_period).toFixed(0),
		                    });
	                	}    
	                }

	                result.push({
						year 				: year+a+1,
						book_value 			: parseFloat(result[a].book_value_year_end).toFixed(0),
						depreciation_expense: (depreciation_in_last_year).toFixed(0),
						accumulated 		: (depreciation_in_last_year+parseFloat(result[a].accumulated)).toFixed(0),
						book_value_year_end : (result[a].book_value_year_end-depreciation_in_last_year).toFixed(0),
                    });


	                return result;
	            },
	        };
	    }());

	});

	function loadData(id) {
		$.ajax({
            url: "{{url('reports/depreciation/json/getAssetData')}}" ,
            type: 'GET',
            data: {'id' :  id},
            success: function(data) {           
            	$('.panel').removeClass('panel-refreshing');
				//depreciationtype=2 MEANS DECLINED	
				if(data.data.depreciationtype.id==2){
					if(data.data.depreciationtype!=null){
                		$('#depreciation_type').html('');
                		$('#depreciation_type').append('<h5>Depreciation Type : '+data.data.depreciationtype.name+' ('+data.data.depreciationtype.rate+')</h5>');
                	}

					var begin_value 	= data.data.purchased_value;
					var rate        	= data.data.depreciationtype.rate;
					var years          	= data.data.recovery_period/12;
					var purchased_date  = new Date(data.data.purchased_date);

					//begin,factor,usefull_life,month,year
                	var data = depri.generateDecliningSchedule(begin_value,rate,years,purchased_date.getMonth(),purchased_date.getFullYear());

						
					$('#table tbody').html('');
					$.each(data, function(index,value) {
						var aa = "<tr>"+
									"<td>"+value.year+"</td>"+
									"<td>"+value.book_value+"</td>"+
									"<td>"+value.depreciation_rate+"</td>"+	
									"<td>"+value.depreciation_expense+"</td>"+
									"<td>"+value.accumulated+"</td>"+
									"<td>"+value.book_value_year_end+"</td>"+
								"</tr>";
					  	$('#table tbody').append(aa);	
					});
				}else{
					if(data.data.depreciationtype!=null){
                		$('#depreciation_type').html('');
                		$('#depreciation_type').append('<h5>Depreciation Type : '+data.data.depreciationtype.name+'</h5>');
                	}
					var cost 			 = data.data.purchased_value;
					var salvage        	 = data.data.scrap_value;
					var life          	 = data.data.recovery_period/12;
					var purchased_date   = new Date(data.data.purchased_date);
					var assign_assets    = data.data.upgrade;
					var assign_asset_dep = [];
					//cost,salvage,life,month,year
                	var aa = depri.generateStraightSchedule(cost,salvage,life,purchased_date.getMonth(),purchased_date.getFullYear());
                	
                	$.each(assign_assets, function(index,value) {                		
                		if(value.ended_at==null){
	                		var cost 			 = value.asset.purchased_value;
							var salvage        	 = value.asset.scrap_value;
							var life          	 = value.asset.recovery_period/12;
							var purchased_year   = value.upgrade_year;
							var purchased_month   = value.upgrade_month;

		                	assign_asset_dep.push({
		                		"year":purchased_year,
		                		"depri":depri.generateStraightSchedule(cost,salvage,life,purchased_month,purchased_month)
		                	});
                		}
	                });

	                console.log(assign_asset_dep);

					
					$('#table tbody').html('');

					var onwords					 = false;
					$.each(aa, function(index,value) {
						var year                 = value.year;

						var book_value           = value.book_value;
						var depreciation_expense = value.depreciation_expense;
						var accumulated          = value.accumulated;
						var book_value_year_end  = value.book_value_year_end;

						var book_value_str           = "";
						var depreciation_expense_str = "";
						var accumulated_str          = "";
						var book_value_year_end_str  = "";

						if(!withoutAssign){							
							$.each(assign_asset_dep, function(kk,assign) {	
								if(year==assign.year){
									onwords = true;
								}

								if (onwords) {
									console.log(assign.depri);
									book_value_str           += assign.depri[index].book_value+" <br>";
									depreciation_expense_str += assign.depri[index].depreciation_expense+"  <br>";
									accumulated_str          += assign.depri[index].accumulated+"  <br>";
									book_value_year_end_str  += assign.depri[index].book_value_year_end+"  <br>";

									book_value           = parseFloat(book_value)+parseFloat(assign.depri[index].book_value);
									depreciation_expense = parseFloat(depreciation_expense)+parseFloat(assign.depri[index].depreciation_expense);
									accumulated          = parseFloat(accumulated)+parseFloat(assign.depri[index].accumulated);
									book_value_year_end  = parseFloat(book_value_year_end)+parseFloat(assign.depri[index].book_value_year_end);
								}							
							});
						}

						var aa = "<tr>"+
									"<td>"+year+"</td>"+
									"<td>"+book_value_str+" "+book_value+"</td>"+
									"<td>-</td>"+	
									"<td>"+depreciation_expense_str+" "+depreciation_expense+"</td>"+
									"<td>"+accumulated_str+" "+accumulated+"</td>"+
									"<td>"+book_value_year_end_str+" "+book_value_year_end+"</td>"+
								"</tr>";
					  	$('#table tbody').append(aa);	
					});
				}

				
				
            },
            error: function(xhr, textStatus, thrownError) {
                console.log(thrownError);
            }
        });	
	}
</script>
@stop
