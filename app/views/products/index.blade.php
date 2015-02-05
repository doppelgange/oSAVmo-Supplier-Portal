@if (count($products) === 0)
	<div>There is no record for products, you can sync to get the latest data! </div>
@else

{{ Form::open(array('url'=>'products/batchAmend')) }}
<div>
	Total {{$products->getTotal()}} records are found. 
	{{$products->count()}} records in this page.

</div>
{{$products->links()}}
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
			<th style="width: 60px;"> Action</th>
		</tr>
	</thead>
	<tbody>
	@foreach($products as $product)
	    <tr>
			<td> {{ $product -> productID }} </td>
			<td> 
				<div><label>EA:</label>{{ $product -> name }} </div>
				<div><label>CN:</label>{{ $product -> nameCN }} </div>
				<!-- <div><label>Code:</label> {{ $product -> code }} </div> -->
			</td>
			<td><a href="products/{{$product-> id}}/edit" target="_blank"> {{ $product -> ean }} </a></td>
			<td> {{ $product -> categoryName }} </td>
			<td> 
				<span class="text-primary" data-toggle="tooltip" title="Price with VAT"> {{ $product -> priceWithVat }}</span>
				<span class="text-muted"  data-toggle="tooltip" title="Price without VAT"> /  {{ $product -> price }} </span>
				<span class="text-muted"  data-toggle="tooltip" title="Cost">
				@if($product -> cost!=0)
				 / {{ $product -> cost }} 
				@else
				/ Not set
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
			<td class="text-right"> 
				@if(is_null($product -> productStocks()-> first())==false)
					@if($product -> productStocks()-> first()->amountInStock != 0)
					{{ number_format($product -> productStocks()-> first()->amountInStock,0, '', ',') }}
					@endif
				@endif
			</td>
			<td class="text-right"> 
				@if(is_null($product -> productStocks()-> first())==false)
					@if($product -> productStocks()-> first()->amountReserved != 0)
					<div class="text-warning">
					{{ number_format($product -> productStocks()-> first()->amountReserved,0, '', ',') }}	
					</div>
					@endif
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
{{$products->links()}}
<!--
{{ Form::submit('Save Amendment', array('class'=>'btn btn-large btn-primary center-block'))}}
-->

{{ Form::close() }}
 @endif



