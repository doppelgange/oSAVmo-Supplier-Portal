
{{ Form::open(array('url'=>'products','method' => 'get','class'=>'form-inline')) }}
<div class="row">
	<div class="col-md-4">
		{{ Form::label('name', 'Name/EAN/Code',array('class'=>'fi-col-4'))}}
		{{Form::text('queries',$q['queries'],array('class'=>'form-control'))}}
	</div>
	<div class="col-md-4">
	{{ Form::label('eshop', 'eShop',array('class'=>'fi-col-3'))}}
	{{Form::select('eshop',array(''=>'All','1'=>'Yes','0'=>'No'),$q['eshop'],array('class'=>'form-control'))}}
	</div>
	<div class="col-md-4">
	{{ Form::label('supplier', 'Supplier',array('class'=>'fi-col-3'))}}
	{{ Form::select('supplier', $supplierList, $q['supplier'] , array('class'=>'form-control')) }}
	</div>
</div>

<div class="row" style="margin-top:5px;">
	<div class="col-md-4">
		{{ Form::label('priceRange', 'Price Range',array('class'=>'fi-col-4'))}}
		{{Form::number('priceFrom',$q['priceFrom'],array('class'=>'form-control fi-col-2','step'=>'0.01'))}} ~ 
		{{Form::number('priceTo',$q['priceTo'],array('class'=>'form-control fi-col-2','step'=>'0.01'))}}
	</div>
	<div class="col-md-4">
		{{ Form::label('stockRange', 'Stock Range',array('class'=>'fi-col-3'))}}
		{{Form::number('stockFrom',$q['stockFrom'],array('class'=>'form-control fi-col-2','step'=>'1'))}} ~
		{{Form::number('stockTo',$q['stockTo'],array('class'=>'form-control fi-col-2','step'=>'1'))}} 
	</div>
	<div class="col-md-4">
		{{ Form::label('hasImage', 'Has Image',array('class'=>'fi-col-3'))}}
		{{Form::select('hasImage',array(''=>'All','1'=>'Yes','0'=>'No'),$q['hasImage'],array('class'=>'form-control fi-col-2','step'=>'1'))}}
	</div>
	<div class="col-md-4">
	{{ Form::submit('Search', array('class'=>'btn btn-large btn-primary'))}}
	</div>
</div>
	
{{ Form::close() }}

@if (count($products) === 0)
	<div>There is no record for products, you can sync to get the latest data! </div>
@else
<div>
	Total {{$products->getTotal()}} records are found. 
	{{$products->count()}} records in this page.

</div>
{{$products->appends(Request::input())->links()}}

{{ Form::open(array('url'=>'products/inventoryAdjustment','method' => 'put')) }}
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



