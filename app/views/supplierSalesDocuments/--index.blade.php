@if (count($supplierSalesDocuments) === 0)
<div>There is no record for supplierSalesDocuments, you can sync to get the latest data! </div>
@else
<div>
	Total {{$supplierSalesDocuments->getTotal()}} records are found. 
	{{$supplierSalesDocuments->count()}} records in this page.

</div>
{{$supplierSalesDocuments->links()}}
<table class='table table-striped table-bordered table-hover table-condensed'>
	<thead>
		<tr>
			<th> supplierID </th>
			<th> salesDocumentID </th>
			<th> status </th>
			<th> amount </th>
			<th> netTotal </th>
			<th> vatTotal </th>
			<th> total </th>
			<th> supplierNotes </th>
			<th> lastModified </th>
			<th> lastModifierUsername </th>
		</tr>
	</thead>
	<tbody>
		@foreach($supplierSalesDocuments as $supplierSalesDocument )
		<tr>
			<td> {{ $supplierSalesDocument->supplierID }} </td>
			<td> {{ $supplierSalesDocument->salesDocumentID }} </td>
			<td> {{ $supplierSalesDocument->status }} </td>
			<td> {{ $supplierSalesDocument->amount }} </td>
			<td> {{ $supplierSalesDocument->netTotal }} </td>
			<td> {{ $supplierSalesDocument->vatTotal }} </td>
			<td> {{ $supplierSalesDocument->total }} </td>
			<td> {{ $supplierSalesDocument->supplierNotes }} </td>
			<td> {{ $supplierSalesDocument->lastModified }} </td>
			<td> {{ $supplierSalesDocument->lastModifierUsername }} </td>
		</tr>
		@endforeach
	</tbody>
</table>
{{$supplierSalesDocuments->links()}}
@endif
