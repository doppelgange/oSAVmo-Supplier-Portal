	<div> <a class="btn btn-primary" href="products/sync" role="button">Sync Products from ERPLY</a> </div>
@if (count($products) === 0)
	<div>There is no record for products, you can sync from ERPLY to get the latest data! </div>
@else

{{ Form::open(array('url'=>'products/batchAmend')) }}
<div>
	Total {{$products->getTotal()}} records are found. 
	{{$products->count()}} records in this page.

</div>
<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> ID </th>
			<th> Product Name (EN/CN)</th>
			<th> EAN </th>
			<th> Category</th>
			<th> Price(VAT), Price, Cost</th>
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
	    <tr 
	    	@if($product->displayedInWebshop==0)
	    	class="warning" data-toggle="tooltip" title="{{$product -> name}} is not show in webstore"
	    	@endif
	    >
			<td> {{ $product -> productID }} </td>
			<td> 
				<div><label>EA:</label>{{ $product -> name }} </div>
				<div><label>CN:</label>{{ $product -> nameCN }} </div>
				<!-- <div><label>Code:</label> {{ $product -> code }} </div> -->
			</td>
			<td>{{ $product -> ean }} </td>
			<td> {{ $product -> categoryName }} </td>
			<td> 
				<div> {{ $product -> priceWithVat }}</div>
				<div> {{ $product -> price }} </div>
				<div> {{ $product -> cost }} </div>
			</td>
			<td> {{ $product -> displayedInWebshop }} </td>
			<!-- <td> {{ $product -> grossWeight }} </td> -->
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



