
@if (count($productStocks) === 0)
	<div>There is no record for products, you can sync get the latest data! </div>
@else
{{ Form::open(array('url'=>'productStocks/batchAmend')) }}
<div>
	Total {{$productStocks->getTotal()}} records are found. 
	{{$productStocks->count()}} records in this page.

</div>
{{$productStocks->links()}}
<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> ID </th>
			<!-- <th> product ID </th> -->
			<th> Name </th>
			<th> EAN</th>
			<th> Amount In Stock </th>
			<th> Amount Reserved </th>
			<th> Suggested Purchase Price </th>
			<th> Average Purchase Price </th>
			<th> Average Cost </th>
			<th> First Purchase Date </th>
			<th> Last Purchase Date </th>
			<th> Last Sold Date </th>
		</tr>
	</thead>
	<tbody>
	@foreach($productStocks as $productStock)
	    <tr 
	    	@if($productStock->amountReserved > 0)
	    	class="warning" data-toggle="tooltip" title="This item has been reserved!"
	    	@endif
	    >
			<!-- <td>{{ $productStock-> id }}</td> -->
			<td>{{ $productStock-> productID }}</td>
			<td><label>EN:</label>{{ $productStock-> product->name}}<br/>
				<label>CN:</label>{{ $productStock-> product->nameCN}}
			</td>
			<td>{{ $productStock-> product->ean }}</td>
			<td>{{ number_format($productStock-> amountInStock,0, '', ',') }}</td>
			<td>{{ number_format($productStock-> amountReserved,0, '', ',') }}</td>
			<td>{{ money_format('NZD %=#4.2n', $productStock-> suggestedPurchasePrice) }}</td>
			<td>{{ money_format('NZD %=#4.2n', $productStock-> averagePurchasePrice) }}</td>
			<td>{{ money_format('NZD %=#4.2n', $productStock-> averageCost) }}</td>
			<td> 
				@if($productStock->firstPurchaseDate!=0)
				{{date('Y-m-d',strtotime($productStock->firstPurchaseDate))}}
				@endif
			</td>
			<td>
				@if($productStock->lastPurchaseDate!=0)
				{{ date('Y-m-d',strtotime($productStock->lastPurchaseDate))  }}
				@endif
			</td>
			<td>
				@if($productStock->lastSoldDate!=0)
				{{ date('Y-m-d',strtotime($productStock->lastSoldDate))  }}
				@endif
			</td>
	    </tr>
	@endforeach
	</tbody>
</table>
{{$productStocks->links()}}
{{ Form::submit('Save Amendment', array('class'=>'btn btn-large btn-primary center-block'))}}


{{ Form::close() }}
 @endif



