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
	@foreach($supplierSalesDocuments as $supplierSalesDocument )
	    <tr @if($supplierSalesDocument->status!='Completed') class='danger' @else class='success' @endif>
			<td> 
				<a href="supplierSalesDocuments/{{$supplierSalesDocument->salesDocument->id}}/edit" target="_blank"> 
				{{ $supplierSalesDocument->salesDocument->number }} 
				</a>
			</td>
			<td nowrap> {{ $supplierSalesDocument->salesDocument->clientName }} 
				<a href="mailto:{{ $supplierSalesDocument->salesDocument->clientEmail }}" data-toggle="tooltip" title="{{ $supplierSalesDocument -> clientEmail }}">
					<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
				</a>
			</td>
			<td>
			<div>
				<span class="text-primary" data-toggle="tooltip" title="Order Total Amount">
					<strong> {{ $supplierSalesDocument->total }} </strong>
				</span>
				<span class="text-muted" data-toggle="tooltip" title="NET Total Amount"> ({{ $supplierSalesDocument->netTotal }} + </span>
				<span class="text-muted" data-toggle="tooltip" title="VAT Amount"> {{ $supplierSalesDocument->vatTotal }} )</span>
			</div>
			</td>
			<td>
			 {{ $supplierSalesDocument->status }}
			</td>
			<td> {{ $supplierSalesDocument->salesDocument->internalNotes }} </td>
			<td> {{ $supplierSalesDocument->salesDocument->date }} </td>
			<td class="action-button">
				<a href="supplierSalesDocuments/{{$supplierSalesDocument->salesDocument-> id}}/edit" target="_blank" class=""><span class="glyphicon glyphicon-edit" aria-hidden="true" data-toggle="tooltip" title="Amend"></span></a>
				<a href="supplierSalesDocuments/{{$supplierSalesDocument->salesDocument-> id}}/fulfill" class="submit"><span class="glyphicon glyphicon-bed" aria-hidden="true"  data-toggle="tooltip" title="Fulfill"></span></a>
			</td>
	    </tr>
	@endforeach
	</tbody>
</table>
{{$supplierSalesDocuments->links()}}
 @endif



