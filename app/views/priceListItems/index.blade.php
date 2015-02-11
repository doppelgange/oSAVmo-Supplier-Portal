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
			<!-- <th> priceListID </th> -->

			<th> Product ID </th>
			<th> Name </th>
			<th> Type </th>
			<th> Price </th>
			<th> Price With VAT </th>
			<th> RuleID </th>
			<th> Amount </th>
		</tr>
	</thead>
	<tbody>
	@foreach($priceListItems as $priceListItem )
	    <tr>
			<!-- <td> {{ $priceListItem->priceListID }} </td> -->
			<td> {{ $priceListItem->productID }} </td>
			<td> 
				<a href="products/{{$priceListItem->product-> id}}/edit" target="_blank">  
					<div>{{ $priceListItem->product->name }} </div>
					<div>{{ $priceListItem->product->nameCN }} </div>
				</a>

			</td>
			<td> {{ $priceListItem->type }} </td>
			<td> {{ $priceListItem->price }} </td>
			<td @if($priceListItem->priceWithVat==0) class="danger" @endif> {{ $priceListItem->priceWithVat }} </td>
			
			<td> {{ $priceListItem->ruleID }} </td>
			<td> {{ $priceListItem->amount }} </td>
	    </tr>
	@endforeach
	</tbody>
</table>
{{$priceListItems->links()}}
 @endif



