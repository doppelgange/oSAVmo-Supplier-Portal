{{ Form::open(array('url'=>'products','method' => 'get','class'=>'form-inline')) }}
	{{ Form::label('name', 'Name/EAN/Code')}}
	{{Form::text('q',$q,array('class'=>'form-control','placeholder'=>'Input your query'))}}
	{{ Form::submit('Search', array('class'=>'btn btn-large btn-primary'))}}
{{ Form::close() }}
@if (count($products) === 0)
	<div>There is no record for products, you can sync to get the latest data! </div>
@else
<div>
	Total {{$products->getTotal()}} records are found. 
	{{$products->count()}} records in this page.

</div>
{{$products->appends(Request::input())->links()}}

{{ Form::open(array('url'=>'products/inventoryAdjustment','method' => 'get')) }}
<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> ID </th>
			<th> Product Name (EN/CN)</th>
			<th> EAN </th>
			<th> Category</th>
			<th> Price(VAT)<br/> / Price / Cost</th>
			<th> eShop </th>
			<!-- <th> Gross Weight </th> -->
			<th> In stock</th>
			<th> Lay-by</th>
			<th> erply Last Modified </th>
			<th class="col-md-1"> Action</th>
		</tr>
	</thead>
	<tbody>
	@foreach($products as $product)
	    <tr>
			<td> {{ $product -> id }}<!--{{ $product -> productID }}--></td>
			<td>
				<a href="products/{{$product-> id}}/edit" target="_blank">  
				<div>{{ $product -> name}} </div>
				<div>{{ $product -> nameCN}} </div>
				 </a>
				<!-- <div><label>Code:</label> {{ $product -> code }} </div> -->
			</td>
			<td>{{ $product -> ean}}</td>
			<td> {{ $product -> categoryName}} </td>
			<td> 
				<!-- Use Price List first -->
				<!--{{$priceListItem = $product->priceListItems()->where('priceListID','=','8')->first()}}-->
				@if($priceListItem!= null)
				
					<span class="text-primary bg-success" data-toggle="tooltip" title="Price with VAT for eShop"> 
						{{ $product->priceListItems()->first()->priceWithVat }}
					</span>
					<span class="text-muted bg-success"  data-toggle="tooltip" title="Price without VAT for eShop"> 
						/  {{ number_format($product->priceListItems()->first()->price , 2, '.', '')}}
					</span>
				@else
					<span class="text-primary" data-toggle="tooltip" title="Price with VAT"> 
						{{ $product -> priceWithVat }}
					</span>
					<span class="text-muted"  data-toggle="tooltip" title="Price without VAT"> 
						/  {{ $product -> price }}
					</span>
				@endif

				<span class="text-muted"  data-toggle="tooltip" title="Cost">
				@if($product -> cost!=0)
					 / {{ $product -> cost }} 
				@else
					/ N/A
				@endif
				</span>
			</td>

	    	@if($product->displayedInWebshop==0)
	    	<td  class="warning">
	    		<div data-toggle="tooltip" title="{{$product -> name}} is not show in webstore">No</div>
	    	</td>
	    	@else 
			<td> Yes </td>
	    	@endif
			<td class="text-right col-md-1"> 
				@if(is_null($product -> productStocks()-> first())==false)
					{{Form::number('toAmount[]',$product -> productStocks()-> first()->amountInStock,
					array('class'=>'form-control focus-select-all','step'=>'1','tabindex'=>1))}}
					{{Form::hidden('fromAmount[]',$product -> productStocks()-> first()->amountInStock)}}
					{{Form::hidden('productID[]',$product ->productID)}}
				@else
					{{Form::number('toAmount[]',0,
					array('class'=>'form-control focus-select-all','step'=>'1','tabindex'=>1))}}
					{{Form::hidden('fromAmount[]',0)}}
					{{Form::hidden('productID[]',$product ->productID)}}
				@endif
			</td>
			<td class="text-right"> 
				@if(is_null($product -> productStocks()-> first())==false)
					<div>
					{{ number_format($product -> productStocks()-> first()->amountReserved,0, '', ',') }}	
					</div>
				@endif
				
			</td>

			<td> {{ $product -> erplyLastModified }} </td>
			<td class="action-button">
				<a href="products/{{$product-> id}}/edit" target="_blank"><span class="glyphicon glyphicon-edit" aria-hidden="true" data-toggle="tooltip" title="Amend"></span></a>
				<a href="products/{{$product-> id}}" target="_blank"><span class="glyphicon glyphicon glyphicon-new-window" aria-hidden="true"  data-toggle="tooltip" title="Detail"></span></a>
			</td>
	    </tr>
	@endforeach
	</tbody>
</table>
{{$products->appends(Request::input())->links()}}

{{ Form::submit('Submit', array('class'=>'btn btn-large btn-primary center-block'))}}


{{ Form::close() }}
 @endif



