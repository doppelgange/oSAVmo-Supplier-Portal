@if (count($supplierSalesDocuments) === 0)
	<div>There is no record for salesDocuments, you can sync to get the latest data! </div>
@else
<div>
	Total {{$supplierSalesDocuments->getTotal()}} records are found. 
	{{$supplierSalesDocuments->count()}} records in this page.

</div>
{{$supplierSalesDocuments->links()}}
<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> No.</th>
			<th> Customer Name </th>
			<th> Total Price</th>
			<th> Delivery </th>
			<th> Customer Notes </th>
			<th style="width:85px"> Order Date </th>
			<!-- <th style="width:85px"> Last Modified </th> -->
			<th> Action </th>
		</tr>
	</thead>
	<tbody>
	@foreach($supplierSalesDocuments as $salesDocument )
	    <tr @if($salesDocumentItem)>
			<td> 
				<a href="supplierSalesDocuments/{{$salesDocument->salesDocument->id}}/edit" target="_blank"> 
				{{ $salesDocument->salesDocument->number }} 
				</a>
			</td>
			<td nowrap> {{ $salesDocument->salesDocument->clientName }} 
				<a href="mailto:{{ $salesDocument->salesDocument->clientEmail }}" data-toggle="tooltip" title="{{ $salesDocument -> clientEmail }}">
					<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
				</a>
			</td>
			<td>
			<div>
				<span class="text-primary" data-toggle="tooltip" title="Order Total Amount">
					<strong> {{ $salesDocument->total }} </strong>
				</span>
				<span class="text-muted" data-toggle="tooltip" title="NET Total Amount"> ({{ $salesDocument->netTotal }} + </span>
				<span class="text-muted" data-toggle="tooltip" title="VAT Amount"> {{ $salesDocument->vatTotal }} )</span>
			</div>
			</td>
			<td>
			 {{ $salesDocument->status }}
			</td>
			<td> {{ $salesDocument->salesDocument->internalNotes }} </td>
			<td> {{ $salesDocument->salesDocument->date }} </td>
			<!-- <td data-toggle="tooltip" title="{{ $salesDocument->lastModifierUsername }}"> {{ $salesDocument->lastModified }} </td> -->
			<td class="action-button">
				<a href="salesDocuments/{{$salesDocument->salesDocument-> id}}/edit" target="_blank"><span class="glyphicon glyphicon-edit" aria-hidden="true" data-toggle="tooltip" title="Amend"></span></a>
				<a href="salesDocuments/{{$salesDocument->salesDocument-> id}}" target="_blank"><span class="glyphicon glyphicon glyphicon-new-window" aria-hidden="true"  data-toggle="tooltip" title="Detail"></span></a>
			</td>
	    </tr>
	@endforeach
	</tbody>
</table>
{{$salesDocuments->links()}}
 @endif



