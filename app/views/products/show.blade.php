<table class="table table-striped table-bordered table-hover table-condensed">
	<tbody>
		<tr>
			<td> <label> Product Name </label></td>
			<td> 
				{{ $product -> name }}<br/>
				{{ $product -> nameCN }} ({{ $product -> productID }})
			</td>
			<td><label> EAN </label></td>
			<td>
				{{ $product -> ean }}
			</td>
			<td><label> Status </label></td>
			<td> {{ $product -> status }} </td>
		</tr>
		<tr>
			<td><label> Group </label></td>
			<td> {{ $product -> groupName }} </td>
			<td><label> Category</label></td>
			<td> {{ $product -> categoryName }} </td>
			<td><label> Supplier Name <br/> Brand Name <br/> Series Name</label></td>
			<td> 
				{{ $product -> supplierName }} <br/>
				{{ $product -> brandName }} <br/>
				{{ $product -> seriesName }}
			</td>
		</tr>
		<tr>
			<td><label> Normal Price(VAT), Price </label></td>
			<td>
				{{ $product -> priceWithVat }}/ {{ $product -> price }} 
			</td>
			<td><label> Online Price(VAT), Price</label></td>
			<td>
			@if($product->priceListItems!= null) 
				{{ $product->priceListItems->first()->priceWithVat }}
				/  {{ number_format($product->priceListItems->first()->price , 2, '.', '')}}
			@endif
			</td>
			<td><label> Cost</label></td>
			<td> {{ $product -> cost }} </td>
			
		</tr>
		<tr>
			<td><label> Net Weight / Gross Weight </label></td>
			<td> {{ $product -> netWeight }} / {{ $product -> grossWeight }} </td>
			<td><label> VOL </label></td>
			<td> {{ $product -> volume }} </td>
			<td><label> Last Modified / Added </label></td>
			<td> {{ $product -> erplyLastModified }} <br/> {{ $product -> erplyAdded }} </td>
			
		</tr>
		<tr>
			<td><label> Desc </label></td>
			<td colspan="5"> {{ $product -> longdesc }} </td>
		</tr>
		@if(is_null($product -> productStocks()-> first()))
		<tr>
			<td colspan="6"> No Stock information for this item </td>
		</tr>
		@else
		<tr>
			<td colspan="6"><label> Stock information:</label></td>
		</tr>
		<tr>
			<td><label>Amount In Stock /Reserved</label></td>
			<td>
				{{ $product -> productStocks()-> first()->amountInStock }} / 
				{{$product -> productStocks()-> first()->amountReserved}}
			</td>
			<td><label>First /Last Purchase Date</label></td>
			<td>
				@if($product -> productStocks()-> first()->firstPurchaseDate !=0)
				 {{ $product -> productStocks()-> first()->firstPurchaseDate }} 
				@endif
				<br/>
				@if($product -> productStocks()-> first()->lastPurchaseDate !=0)
				{{$product -> productStocks()-> first()->lastPurchaseDate}}
				@endif
			</td>
			<td><label>Last Sold Date</label></td>
			<td colspan="3"> 
				@if($product -> productStocks()-> first()->lastSoldDate !=0)
				{{ $product -> productStocks()-> first()->lastSoldDate }} 
				@endif
			</td>
		</tr>
		@endif
		
	</tbody>
</table>

