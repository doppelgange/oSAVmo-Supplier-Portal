@if (count($salesDocuments) === 0)
	<div>There is no record for salesDocuments, you can sync to get the latest data! </div>
@else
<div>
	Total {{$salesDocuments->getTotal()}} records are found. 
	{{$salesDocuments->count()}} records in this page.

</div>
{{$salesDocuments->links()}}
<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> id </th>
			<th> No. (Status)</th>
			<th> Customer Name </th>
			<th> Total Price / Paid </th>
			<th> Delivery </th>
			<th> Address </th>
			<th> Customer Notes </th>
			<th style="width:85px"> Order Date </th>
			<th style="width:85px"> Last Modified </th>
			<th> Last Update by </th>
			<th> Invoice Receipt</th>
			<th> Action </th>
		</tr>
	</thead>
	<tbody>
	@foreach($salesDocuments as $salesDocument )
	    <tr 
	    @if($salesDocument -> deliveryTypeName == '') class="danger" @endif  
	    data-toggle="popover" title="Order {{ $salesDocument -> number }} Detail" data-content="@foreach(SalesDocumentItem::where('salesDocumentID','=',$salesDocument -> salesDocumentID)->get() as $salesDocumentItem )
@if(Auth::user()->supplierID==0&&$salesDocumentItem->productID!=0||($salesDocumentItem->productID!=0&&$salesDocumentItem->product->supplierID == Auth::user()->supplierID))
 - {{ $salesDocumentItem->itemName }} ({{$salesDocumentItem->product->nameCN}}) * {{ number_format($salesDocumentItem->amount)}} 
@endif
@endforeach
">

			<td> {{ $salesDocument -> id }} </td>
			<td> {{ $salesDocument -> number }} ({{ $salesDocument -> invoiceState }})</td>
			<td nowrap> {{ $salesDocument -> clientName }} 
				<a href="mailto:{{ $salesDocument -> clientEmail }}" data-toggle="tooltip" title="{{ $salesDocument -> clientEmail }}">
					<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
				</a>
			</td>
			<td>
			<div style="width:100px;">
				<span class="text-primary" data-toggle="tooltip" title="Order Total Amount">
					<strong> {{ $salesDocument -> total }} </strong>
				</span>
				@if($salesDocument -> total > $salesDocument -> paid)
				<span class="text-danger"  data-toggle="tooltip" title="Paid Amount which is smaller than Order Total Amount ! ">
					<strong>{{  $salesDocument -> paid }} </strong>
				</span>
				@elseif($salesDocument -> total < $salesDocument -> paid)
				<span class="text-success" data-toggle="tooltip" title="Paid Amount which is bigger than Order Total Amount ! ">
					<strong>{{  $salesDocument -> paid }} </strong>
				</span>
				@endif
			</div>
			<div>
				<span class="text-muted" data-toggle="tooltip" title="NET Total Amount"> ({{ $salesDocument -> netTotal }} + </span>
				<span class="text-muted" data-toggle="tooltip" title="VAT Amount"> {{ $salesDocument -> vatTotal }} )</span>
			</div>
			<div>
				<span class="text-warning" data-toggle="tooltip" title="Total Cost">{{ $salesDocument -> cost }}</span>
			</div>
			</td>
			<td> {{ $salesDocument -> deliveryTypeName }} </td>
			<td> {{ $salesDocument -> address }} </td>
			<td> {{ $salesDocument -> internalNotes }} </td>
			<td> {{ $salesDocument -> date }} </td>
			<td> {{ $salesDocument -> lastModified }} </td>
			<td> {{ $salesDocument -> lastModifierUsername }} </td>
			<td>
				<a href="{{ $salesDocument -> invoiceLink }}" data-toggle="tooltip" title="Invoice" target="_blank">
					<span class="glyphicon glyphicon-file" aria-hidden="true"></span>
				</a>
				<a href="{{ $salesDocument -> receiptLink }}" data-toggle="tooltip" title="Receipt"  target="_blank">
					<span class="glyphicon glyphicon-file" aria-hidden="true"></span>
				</a>
			</td>
			<td>
				<a href="salesDocuments/{{$salesDocument-> id}}/edit" target="_blank"><span class="glyphicon glyphicon-edit" aria-hidden="true" data-toggle="tooltip" title="Amend"></span></a>
				<a href="salesDocuments/{{$salesDocument-> id}}" target="_blank"><span class="glyphicon glyphicon glyphicon-new-window" aria-hidden="true"  data-toggle="tooltip" title="Detail"></span></a>
			</td>
	    </tr>
	@endforeach
	</tbody>
</table>
{{$salesDocuments->links()}}
 @endif



