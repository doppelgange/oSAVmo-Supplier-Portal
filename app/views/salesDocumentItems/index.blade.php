

@if (count($salesDocumentItems) === 0)
	<div>There is no record for salesDocumentItems, you can sync to get the latest data! </div>
@else
<div>
	Total {{$salesDocumentItems->getTotal()}} records are found. 
	{{$salesDocumentItems->count()}} records in this page.

</div>
{{$salesDocumentItems->appends(Request::input())->links()}}
<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> productID </th>
			<th> serviceID </th>
			<th> itemName </th>
			<th> code </th>
			<th> vatrateID </th>
			<th> amount </th>
			<th> price </th>
			<th> discount </th>
			<th> finalNetPrice </th>
			<th> finalPriceWithVAT </th>
			<th> rowNetTotal </th>
			<th> rowVAT </th>
			<th> rowTotal </th>
			<th> deliveryDate </th>
			<th> returnReasonID </th>
			<th> employeeID </th>
			<th> campaignIDs </th>
			<th> containerID </th>
			<th> containerAmount </th>
			<th> originalPriceIsZero </th>
		</tr>
	</thead>
	<tbody>
	@foreach($salesDocumentItems as $salesDocumentItem )
	    <tr>
			<td> {{ $salesDocumentItem->productID }} </td>
			<td> {{ $salesDocumentItem->serviceID }} </td>
			<td> {{ $salesDocumentItem->itemName }} </td>
			<td> {{ $salesDocumentItem->code }} </td>
			<td> {{ $salesDocumentItem->vatrateID }} </td>
			<td> {{ $salesDocumentItem->amount }} </td>
			<td> {{ $salesDocumentItem->price }} </td>
			<td> {{ $salesDocumentItem->discount }} </td>
			<td> {{ $salesDocumentItem->finalNetPrice }} </td>
			<td> {{ $salesDocumentItem->finalPriceWithVAT }} </td>
			<td> {{ $salesDocumentItem->rowNetTotal }} </td>
			<td> {{ $salesDocumentItem->rowVAT }} </td>
			<td> {{ $salesDocumentItem->rowTotal }} </td>
			<td> {{ $salesDocumentItem->deliveryDate }} </td>
			<td> {{ $salesDocumentItem->returnReasonID }} </td>
			<td> {{ $salesDocumentItem->employeeID }} </td>
			<td> {{ $salesDocumentItem->campaignIDs }} </td>
			<td> {{ $salesDocumentItem->containerID }} </td>
			<td> {{ $salesDocumentItem->containerAmount }} </td>
			<td> {{ $salesDocumentItem->originalPriceIsZero }} </td>
	    </tr>
	@endforeach
	</tbody>
</table>
{{$salesDocumentItems->appends(Request::input())->links()}}
 @endif



