<nav>
  <ul class="pager">
    <li><a href="{{ URL::to( 'salesDocuments/' . $previous ) }}" class="">Previous</a></li>
    <li><a href="{{ URL::to( 'salesDocuments/' . $next ) }}">Next</a></li>
  </ul>
</nav>

<table  class="table table-striped table-bordered table-hover table-condensed">
  <tbody>
    <tr>
      <td><label> number  </label></td>
      <td> 
        {{ $salesDocument -> number }} 
        <a href="{{ $salesDocument -> invoiceLink }}" target="_blank"  data-toggle="tooltip" title="Invoice"><span class="glyphicon glyphicon-file" aria-hidden="true"></span></a>
        <a href="{{ $salesDocument -> receiptLink }}" target="_blank" data-toggle="tooltip" title="Receipt"><span class="glyphicon glyphicon-file" aria-hidden="true"></span></a>
      </td>
      <td><label>Order Date  </label></td>
      <td> {{ $salesDocument -> date }} </td>
      <td><label> Type  </label></td>
      <td> {{ $salesDocument -> type }} </td>
    </tr>
    <tr>
      <td><label> Source  </label></td>
      <td> {{ $salesDocument -> source }} </td>
      <td><label> Warehouse Name  </label></td>
      <td> {{ $salesDocument -> warehouseName }} </td>
      <td><label> Delivery  </label></td>
      <td> {{ $salesDocument -> deliveryTypeName }} </td>
    </tr>
    <!-- <tr>
      <td><label> Invoice State  </label></td>
      <td> {{ $salesDocument -> invoiceState }} </td>
      <td><label> PaymentType  </label></td>
      <td> {{ $salesDocument -> paymentType }} </td>
      <td><label> paymentStatus  </label></td>
      <td> {{ $salesDocument -> paymentStatus }} </td>
    </tr> -->
    <tr>
      <td><label> Custoemr Name  </label></td>
      <td> {{ $salesDocument -> clientName }} </td>
      <td><label> Customer Email  </label></td>
      <td> {{ $salesDocument -> clientEmail }} </td>
      <td><label> Notes  </label></td>
      <td><span data-toggle="tooltip" title="Customer Notes">{{ $salesDocument -> notes }} </span>
          <span data-toggle="tooltip" title="Internal Notes">{{ $salesDocument -> internalNotes }}</span>
      </td>
    </tr>
    <tr>
      <td><label> Address  </label></td>
      <td colspan="5"> {{ $salesDocument -> address }} </td>
    </tr>
    <tr>
      <td><label> Net Total  </label></td>
      <td> {{ $salesDocument -> netTotal }} </td>
      <td><label> VAT Total  </label></td>
      <td> {{ $salesDocument -> vatTotal }} </td>
      <td><label> Rounding  </label></td>
      <td> {{ $salesDocument -> rounding }} </td>
    </tr>
    <tr>
      
      <td><label> Total  </label></td>
      <td> {{ $salesDocument -> total }} </td>
      <td><label> Paid  </label></td>
      <td> {{ $salesDocument -> paid }} </td>
      <td><label> cost  </label></td>
      <td> {{ $salesDocument -> cost }} </td>
      
    </tr>
    <tr>
      <td><label> Create Date  </label></td>
      <td> {{ $salesDocument -> added }} </td>
      <td><label> Last Modified Date </label></td>
      <td> {{ $salesDocument -> lastModified }} </td>
      <td><label> Last Modified by </label></td>
      <td> {{ $salesDocument -> lastModifierUsername }} </td>
      
    </tr>
  </tbody>
</table>
<!-- below is order items -->

@if(count($salesDocument->salesDocumentItems) === 0)
No Order items
@else
<table class="table table-striped table-bordered table-hover table-condensed">
  <thead>
    <tr>
      <th> Line# </th>
      <!-- <th> productID </th>-->
      <th> Name </th>
      <th> code </th>
      <th> EAN </th>
      <th> Supplier </th>
      <th> Amount </th>
      <th> Price </th>
      <th> Net Price </th>
      <th> Price With VAT </th>
      <th> Net Total </th>
      <th> VAT </th>
      <th> Total </th>
    </tr>
  </thead>
  <tbody>
  @foreach($salesDocument->salesDocumentItems as $salesDocumentItem )
      <tr>
        <td> {{ $salesDocumentItem->line+1 }} </td>
        <!-- <td> {{ $salesDocumentItem->productID }} </td>-->
        <td> {{ $salesDocumentItem->itemName }} <br/> 
        @if($salesDocumentItem->productID!=0)
          <a href="../products/{{$salesDocumentItem->product->id}}" target="_blank"> 
          {{$salesDocumentItem->product->nameCN}}
          </a>
        </td>
        <td> 
          {{ $salesDocumentItem->product->code }} 
        </td>
        <td>
          {{ $salesDocumentItem->product->ean }} 
        </td>
        <td>
          {{ $salesDocumentItem->product->supplier }} 
        </td>
        @else
        </td>
        <td></td><td></td><td></td>
        @endif
        <td> {{ number_format($salesDocumentItem->amount)}} </td>
        <td class="text-right"> {{ $salesDocumentItem->price }} </td>
        <td class="text-right"> {{ $salesDocumentItem->finalNetPrice }} </td>
        <td class="text-right"> {{ $salesDocumentItem->finalPriceWithVAT }} </td>
        <td class="text-right"> {{ $salesDocumentItem->rowNetTotal }} </td>
        <td class="text-right"> {{ $salesDocumentItem->rowVAT }} </td>
        <td class="text-right"> {{ $salesDocumentItem->rowTotal }} </td>
      </tr>
  @endforeach
      <tr class="">
        <td colspan="9">  </td>
        <td class="text-right"> <strong>{{ $salesDocument ->netTotal  }} </strong></td>
        <td class="text-right"><strong> {{ $salesDocument ->vatTotal }}</strong></td>
        <td class="text-right"><strong> {{ $salesDocument ->total }}  </strong></td>
      </tr>
  </tbody>
</table>
@endif

<nav>
  <ul class="pager">
    <li><a href="{{ URL::to( 'salesDocuments/' . $previous ) }}" class="">Previous</a></li>
    <li><a href="{{ URL::to( 'salesDocuments/' . $next ) }}">Next</a></li>
  </ul>
</nav>