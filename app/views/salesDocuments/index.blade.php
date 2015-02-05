@if (count($salesDocuments) === 0)
	<div>There is no record for salesDocuments, you can sync to get the latest data! </div>
@else

{{ Form::open(array('url'=>'salesDocuments/batchAmend')) }}
<div>
	Total {{$salesDocuments->getTotal()}} records are found. 
	{{$salesDocuments->count()}} records in this page.

</div>
{{$salesDocuments->links()}}
<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> id </th>
			<!-- <th> salesDocumentID </th> -->
			<th> No. (Status)</th>
			<!-- <th> Type </th>
			<th> Source </th>
			<th> exportInvoiceType </th> -->
			<!-- <th> Currency </th> -->
			<!-- <th> currencyRate </th>
			<th> warehouseID </th>
			<th> warehouseName </th>
			<th> pointOfSaleID </th>
			<th> pointOfSaleName </th>
			<th> pricelistID </th> -->
			<!-- <th> clientID </th> -->
			<th> Customer Name </th>
			<!-- <th> clientCardNumber </th>
			<th> addressID </th> -->
			<!-- <th> clientPaysViaFactoring </th>
			<th> payerID </th>
			<th> payerName </th>
			<th> payerAddressID </th>
			<th> payerAddress </th>
			<th> payerPaysViaFactoring </th>
			<th> contactID </th>
			<th> contactName </th>
			<th> employeeID </th>
			<th> employeeName </th>
			<th> projectID </th>  -->
			<!-- <th> invoiceState </th> -->
			<!-- <th> paymentType </th>
			<th> paymentTypeID </th>
			<th> paymentDays </th>
			<th> paymentStatus </th>
			<th> previousReturnsExist </th>
			<th> confirmed </th> -->
			<!-- <th> netTotal </th>
			<th> vatTotal </th>
			<th> rounding </th> -->
			<th> Total Price / Paid </th>
			<!-- <th> externalNetTotal </th>
			<th> externalVatTotal </th>
			<th> externalRounding </th>
			<th> externalTotal </th>
			<th> taxExemptCertificateNumber </th>
			<th> packerID </th> -->
			<!-- <th> Ref Number </th> -->
			<!-- <th> cost </th> -->
			<!-- <th> reserveGoods </th>
			<th> reserveGoodsUntilDate </th> -->
			<!-- <th> deliveryDate </th>
			<th> deliveryTypeID </th> -->
			<th> Delivery </th>
			<th> Address </th>
			<!-- <th> packingUnitsDescription </th>
			<th> triangularTransaction </th>
			<th> purchaseOrderDone </th>
			<th> transactionTypeID </th>
			<th> transactionTypeName </th>
			<th> transportTypeID </th>
			<th> transportTypeName </th>
			<th> deliveryTerms </th>
			<th> deliveryTermsLocation </th>
			<th> euInvoiceType </th>
			<th> deliveryOnlyWhenAllItemsInStock </th> -->
			<th> Customer Notes </th>
			<!-- <th> Notes </th> -->
			<th style="width:85px"> Order Date </th>
			<th style="width:85px"> Last Modified </th>
			<th> Last Update by </th>
			<!-- <th> added </th> -->
			<th> Invoice Receipt</th>
			<th> Action </th>
		</tr>
	</thead>
	<tbody>
	@foreach($salesDocuments as $salesDocument )
	    <tr @if($salesDocument -> deliveryTypeName == '') class="danger" @endif>
			<td> {{ $salesDocument -> id }} </td>
			<!-- <td> {{ $salesDocument -> salesDocumentID }} </td> -->
			<td> {{ $salesDocument -> number }} ({{ $salesDocument -> invoiceState }})</td>
			<!-- <td> {{ $salesDocument -> type }} </td>
			<td> {{ $salesDocument -> source }} </td>
			<td> {{ $salesDocument -> exportInvoiceType }} </td> -->
			<!-- <td> {{ $salesDocument -> currencyCode }} </td> -->
			<!-- <td> {{ $salesDocument -> currencyRate }} </td>
			<td> {{ $salesDocument -> warehouseID }} </td>
			<td> {{ $salesDocument -> warehouseName }} </td>
			<td> {{ $salesDocument -> pointOfSaleID }} </td>
			<td> {{ $salesDocument -> pointOfSaleName }} </td>
			<td> {{ $salesDocument -> pricelistID }} </td> -->
			<!-- <td> {{ $salesDocument -> clientID }} </td> -->
			<td nowrap> {{ $salesDocument -> clientName }} 
				<a href="mailto:{{ $salesDocument -> clientEmail }}" data-toggle="tooltip" title="{{ $salesDocument -> clientEmail }}">
					<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
				</a>
			</td>
			<!-- <td> {{ $salesDocument -> clientCardNumber }} </td>
			<td> {{ $salesDocument -> addressID }} </td> -->
			<!-- <td> {{ $salesDocument -> clientPaysViaFactoring }} </td>
			<td> {{ $salesDocument -> payerID }} </td>
			<td> {{ $salesDocument -> payerName }} </td>
			<td> {{ $salesDocument -> payerAddressID }} </td>
			<td> {{ $salesDocument -> payerAddress }} </td>
			<td> {{ $salesDocument -> payerPaysViaFactoring }} </td>
			<td> {{ $salesDocument -> contactID }} </td>
			<td> {{ $salesDocument -> contactName }} </td>
			<td> {{ $salesDocument -> employeeID }} </td>
			<td> {{ $salesDocument -> employeeName }} </td>
			<td> {{ $salesDocument -> projectID }} </td> -->
			<!-- <td> {{ $salesDocument -> invoiceState }} </td> -->
			<!-- <td> {{ $salesDocument -> paymentType }} </td>
			<td> {{ $salesDocument -> paymentTypeID }} </td>
			<td> {{ $salesDocument -> paymentDays }} </td>
			<td> {{ $salesDocument -> paymentStatus }} </td>
			<td> {{ $salesDocument -> previousReturnsExist }} </td>
			<td> {{ $salesDocument -> confirmed }} </td> -->
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
			<!-- <td> {{ $salesDocument -> rounding }} </td> -->
			<!-- <td> {{ $salesDocument -> externalNetTotal }} </td>
			<td> {{ $salesDocument -> externalVatTotal }} </td>
			<td> {{ $salesDocument -> externalRounding }} </td>
			<td> {{ $salesDocument -> externalTotal }} </td>
			<td> {{ $salesDocument -> taxExemptCertificateNumber }} </td>
			<td> {{ $salesDocument -> packerID }} </td> -->
			<!-- <td> {{ $salesDocument -> referenceNumber }} </td> -->
			<!-- <td> {{ $salesDocument -> reserveGoods }} </td>
			<td> {{ $salesDocument -> reserveGoodsUntilDate }} </td> -->
			<!-- <td> {{ $salesDocument -> deliveryDate }} </td>
			<td> {{ $salesDocument -> deliveryTypeID }} </td> -->
			<td> {{ $salesDocument -> deliveryTypeName }} </td>
			<td> {{ $salesDocument -> address }} </td>
			<!-- <td> {{ $salesDocument -> packingUnitsDescription }} </td>
			<td> {{ $salesDocument -> triangularTransaction }} </td>
			<td> {{ $salesDocument -> purchaseOrderDone }} </td>
			<td> {{ $salesDocument -> transactionTypeID }} </td>
			<td> {{ $salesDocument -> transactionTypeName }} </td>
			<td> {{ $salesDocument -> transportTypeID }} </td>
			<td> {{ $salesDocument -> transportTypeName }} </td>
			<td> {{ $salesDocument -> deliveryTerms }} </td>
			<td> {{ $salesDocument -> deliveryTermsLocation }} </td>
			<td> {{ $salesDocument -> euInvoiceType }} </td>
			<td> {{ $salesDocument -> deliveryOnlyWhenAllItemsInStock }} </td> -->
			
			<td> {{ $salesDocument -> internalNotes }} </td>
			<!-- <td> {{ $salesDocument -> notes }} </td> -->
			<td> {{ $salesDocument -> date }} </td>
			<td> {{ $salesDocument -> lastModified }} </td>
			<td> {{ $salesDocument -> lastModifierUsername }} </td>
			<!-- <td> {{ $salesDocument -> added }} </td> -->
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
<!--
{{ Form::submit('Save Amendment', array('class'=>'btn btn-large btn-primary center-block'))}}
-->

{{ Form::close() }}
 @endif



