<nav>
  <ul class="pager">
    <li><a href="{{ URL::to( 'products/' . $previous ) }}" class="">Previous</a></li>
    <li><a href="{{ URL::to( 'products/' . $next ) }}">Next</a></li>
  </ul>
</nav>
<table class="table table-striped table-bordered table-hover table-condensed">
	<tbody>
		<tr>
			<td> <label> ID </label></td>
			<td> {{ $product -> productID }} </td>
			<td><label>  Product Name  </label></td>
			<td> {{ $product -> name }}</td>
		</tr>
		<tr>
			<td><label> EAN </label></td>
			<td>{{ $product -> ean }} </td>
			<td><label> Name CN </label></td>
			<td>{{ $product -> nameCN }} </td>
		</tr>
		<tr>
			<td><label> supplierID </label></td>
			<td> {{ $product -> supplierID }} </td> 
			<td><label> supplierName </label></td>
			<td> {{ $product -> supplierName }} </td>
		</tr>
		<tr>
			<td><label> groupID </label></td>
			<td> {{ $product -> groupID }} </td>
			<td><label> Group </label></td>
			<td> {{ $product -> groupName }} </td>
		</tr>
		<tr>
			<td><label> categoryID </label></td>
			<td> {{ $product -> categoryID }} </td>
			<td><label> Category</label></td>
			<td> {{ $product -> categoryName }} </td>
		</tr>
		<tr>
			<td><label> seriesID </label></td>
			<td> {{ $product -> seriesID }} </td>
			<td><label> seriesName </label></td>
			<td> {{ $product -> seriesName }} </td>
		</tr>
		<tr>
			<td><label> unitID </label></td>
			<td> {{ $product -> unitID }} </td>
			<td><label> Unit </label></td>
			<td> {{ $product -> unitID }} </td>
		</tr>
		<tr>
			<td><label> Price(VAT), Price, Cost</label></td>
			<td> 
				<div> {{ $product -> priceWithVat }}</div>
				<div> {{ $product -> price }} </div>
				<div> {{ $product -> cost }} </div>
			</td>
			<td><label> Status </label></td>
			<td> {{ $product -> status }} </td>
		</tr>
		<tr>
			<td><label> active </label></td>
			<td> {{ $product -> active }} </td>
			<td><label> eShop </label></td>
			<td> {{ $product -> displayedInWebshop }} </td>
		</tr>
		<tr>
			<td><label> vatrate </label></td>
			<td> {{ $product -> vatrate }} </td>
			<td><label> countryOfOriginID </label></td>
			<td> {{ $product -> countryOfOriginID }} </td>
		</tr>
		<tr>
			<td><label> brandName </label></td>
			<td> {{ $product -> brandName }} </td>
			<td><label> netWeight </label></td>
			<td> {{ $product -> netWeight }} </td>
		</tr>
		<tr>
			<td><label> Gross Weight </label></td>
			<td> {{ $product -> grossWeight }} </td>
			<td><label> VOL </label></td>
			<td> {{ $product -> volume }} </td>
		</tr>
		<tr>
			<td><label> Desc </label></td>
			<td colspan="3"> {{ $product -> longdesc }} </td>
			
		</tr>
		<tr>
			<td><label> erplyAdded </label></td>
			<td> {{ $product -> erplyAdded }} </td>
			<td><label> erply Last Modified </label></td>
			<td> {{ $product -> erplyLastModified }} </td>
		</tr>
		@if(is_null($product -> productStocks()-> first()))
		<tr>
			<td colspan="4"> No Stock information for this item </td>
		</tr>
		@else
		<tr>
			<td colspan="4"><label> Stock information:</label></td>
		</tr>
		<tr>
			<td><label>Amount In Stock</label></td>
			<td> {{ $product -> productStocks()-> first()->amountInStock }} </td>
			<td><label>Amount Reserved</label> </td>
			<td> {{$product -> productStocks()-> first()->amountReserved}}</td>
		</tr>
		<tr>
			<td><label>firstPurchaseDate</label></td>
			<td>
				@if($product -> productStocks()-> first()->firstPurchaseDate !=0)
				 {{ $product -> productStocks()-> first()->firstPurchaseDate }} 
				@endif
			</td>
			<td><label>lastPurchaseDate</label> </td>
			<td> 
				@if($product -> productStocks()-> first()->lastPurchaseDate !=0)
				{{$product -> productStocks()-> first()->lastPurchaseDate}}
				@endif
			</td>
		</tr>
		<tr>
			<td><label>lastSoldDate</label></td>
			<td colspan="3"> 
				@if($product -> productStocks()-> first()->lastSoldDate !=0)
				{{ $product -> productStocks()-> first()->lastSoldDate }} 
				@endif
			</td>
		</tr>
		@endif
		
	</tbody>
</table>




<nav>
  <ul class="pager">
    <li><a href="{{ URL::to( 'products/' . $previous ) }}" class="">Previous</a></li>
    <li><a href="{{ URL::to( 'products/' . $next ) }}">Next</a></li>
  </ul>
</nav>

