@if (count($priceListItems) === 0)
	<div>There is no record for priceListItems, you can sync to get the latest data! </div>
@else
<div>
	Total {{$priceListItems->getTotal()}} records are found. 
	{{$priceListItems->count()}} records in this page.

</div>
{{$priceListItems->links()}}
<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> priceListID </th>
			<th> type </th>
			<th> price </th>
			<th> priceWithVat </th>
			<th> productID </th>
			<th> ruleID </th>
			<th> amount </th>
		</tr>
	</thead>
	<tbody>
	@foreach($priceListItems as $priceListItem )
	    <tr>
			<td> {{ $priceListItem->priceListID }} </td>
			<td> {{ $priceListItem->type }} </td>
			<td> {{ $priceListItem->price }} </td>
			<td> {{ $priceListItem->priceWithVat }} </td>
			<td> {{ $priceListItem->productID }} </td>
			<td> {{ $priceListItem->ruleID }} </td>
			<td> {{ $priceListItem->amount }} </td>
	    </tr>
	@endforeach
	</tbody>
</table>
{{$priceListItems->links()}}
 @endif



