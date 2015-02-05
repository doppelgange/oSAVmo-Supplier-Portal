<nav>
  <ul class="pager">
    <li><a href="{{ URL::to( 'salesDocuments/' . $previous ) }}" class="">Previous</a></li>
    <li><a href="{{ URL::to( 'salesDocuments/' . $next ) }}">Next</a></li>
  </ul>
</nav>

<table  class="table table-striped table-bordered table-hover table-condensed">
  <tbody>
    <tr>
      <td><label> id  </label></td>
      <td> {{ $salesDocument -> id }} </td>
      <td><label> salesDocumentID  </label></td>
      <td> {{ $salesDocument -> salesDocumentID }} </td>
      <td><label> type  </label></td>
      <td> {{ $salesDocument -> type }} </td>
    </tr>
    <tr>
      <td><label> source  </label></td>
      <td> {{ $salesDocument -> source }} </td>
      <td><label> exportInvoiceType  </label></td>
      <td> {{ $salesDocument -> exportInvoiceType }} </td>
      <td><label> currencyCode  </label></td>
      <td> {{ $salesDocument -> currencyCode }} </td>
    </tr>
    <tr>
      <td><label> currencyRate  </label></td>
      <td> {{ $salesDocument -> currencyRate }} </td>
      <td><label> warehouseID  </label></td>
      <td> {{ $salesDocument -> warehouseID }} </td>
      <td><label> warehouseName  </label></td>
      <td> {{ $salesDocument -> warehouseName }} </td>
    </tr>
    <tr>
      <td><label> pointOfSaleID  </label></td>
      <td> {{ $salesDocument -> pointOfSaleID }} </td>
      <td><label> pointOfSaleName  </label></td>
      <td> {{ $salesDocument -> pointOfSaleName }} </td>
      <td><label> pricelistID  </label></td>
      <td> {{ $salesDocument -> pricelistID }} </td>
    </tr>
    <tr>
      <td><label> number  </label></td>
      <td> {{ $salesDocument -> number }} </td>
      <td><label> date  </label></td>
      <td> {{ $salesDocument -> date }} </td>
      <td><label> clientID  </label></td>
      <td> {{ $salesDocument -> clientID }} </td>
    </tr>
    <tr>
      <td><label> clientName  </label></td>
      <td> {{ $salesDocument -> clientName }} </td>
      <td><label> clientEmail  </label></td>
      <td> {{ $salesDocument -> clientEmail }} </td>
      <td><label> clientCardNumber  </label></td>
      <td> {{ $salesDocument -> clientCardNumber }} </td>
    </tr>
    <tr>
      <td><label> addressID  </label></td>
      <td> {{ $salesDocument -> addressID }} </td>
      <td><label> address  </label></td>
      <td> {{ $salesDocument -> address }} </td>
      <td><label> clientPaysViaFactoring  </label></td>
      <td> {{ $salesDocument -> clientPaysViaFactoring }} </td>
    </tr>
    <tr>
      <td><label> payerID  </label></td>
      <td> {{ $salesDocument -> payerID }} </td>
      <td><label> payerName  </label></td>
      <td> {{ $salesDocument -> payerName }} </td>
      <td><label> payerAddressID  </label></td>
      <td> {{ $salesDocument -> payerAddressID }} </td>
    </tr>
    <tr>
      <td><label> payerAddress  </label></td>
      <td> {{ $salesDocument -> payerAddress }} </td>
      <td><label> payerPaysViaFactoring  </label></td>
      <td> {{ $salesDocument -> payerPaysViaFactoring }} </td>
      <td><label> contactID  </label></td>
      <td> {{ $salesDocument -> contactID }} </td>
    </tr>
    <tr>
      <td><label> contactName  </label></td>
      <td> {{ $salesDocument -> contactName }} </td>
      <td><label> employeeID  </label></td>
      <td> {{ $salesDocument -> employeeID }} </td>
      <td><label> employeeName  </label></td>
      <td> {{ $salesDocument -> employeeName }} </td>
    </tr>
    <tr>
      <td><label> projectID  </label></td>
      <td> {{ $salesDocument -> projectID }} </td>
      <td><label> invoiceState  </label></td>
      <td> {{ $salesDocument -> invoiceState }} </td>
      <td><label> paymentType  </label></td>
      <td> {{ $salesDocument -> paymentType }} </td>
    </tr>
    <tr>
      <td><label> paymentTypeID  </label></td>
      <td> {{ $salesDocument -> paymentTypeID }} </td>
      <td><label> paymentDays  </label></td>
      <td> {{ $salesDocument -> paymentDays }} </td>
      <td><label> paymentStatus  </label></td>
      <td> {{ $salesDocument -> paymentStatus }} </td>
    </tr>
    <tr>
      <td><label> previousReturnsExist  </label></td>
      <td> {{ $salesDocument -> previousReturnsExist }} </td>
      <td><label> confirmed  </label></td>
      <td> {{ $salesDocument -> confirmed }} </td>
      <td><label> notes  </label></td>
      <td> {{ $salesDocument -> notes }} </td>
    </tr>
    <tr>
      <td><label> internalNotes  </label></td>
      <td> {{ $salesDocument -> internalNotes }} </td>
      <td><label> netTotal  </label></td>
      <td> {{ $salesDocument -> netTotal }} </td>
      <td><label> vatTotal  </label></td>
      <td> {{ $salesDocument -> vatTotal }} </td>
    </tr>
    <tr>
      <td><label> rounding  </label></td>
      <td> {{ $salesDocument -> rounding }} </td>
      <td><label> total  </label></td>
      <td> {{ $salesDocument -> total }} </td>
      <td><label> paid  </label></td>
      <td> {{ $salesDocument -> paid }} </td>
    </tr>
    <tr>
      <td><label> externalNetTotal  </label></td>
      <td> {{ $salesDocument -> externalNetTotal }} </td>
      <td><label> externalVatTotal  </label></td>
      <td> {{ $salesDocument -> externalVatTotal }} </td>
      <td><label> externalRounding  </label></td>
      <td> {{ $salesDocument -> externalRounding }} </td>
    </tr>
    <tr>
      <td><label> externalTotal  </label></td>
      <td> {{ $salesDocument -> externalTotal }} </td>
      <td><label> taxExemptCertificateNumber  </label></td>
      <td> {{ $salesDocument -> taxExemptCertificateNumber }} </td>
      <td><label> packerID  </label></td>
      <td> {{ $salesDocument -> packerID }} </td>
    </tr>
    <tr>
      <td><label> referenceNumber  </label></td>
      <td> {{ $salesDocument -> referenceNumber }} </td>
      <td><label> cost  </label></td>
      <td> {{ $salesDocument -> cost }} </td>
      <td><label> reserveGoods  </label></td>
      <td> {{ $salesDocument -> reserveGoods }} </td>
    </tr>
    <tr>
      <td><label> reserveGoodsUntilDate  </label></td>
      <td> {{ $salesDocument -> reserveGoodsUntilDate }} </td>
      <td><label> deliveryDate  </label></td>
      <td> {{ $salesDocument -> deliveryDate }} </td>
      <td><label> deliveryTypeID  </label></td>
      <td> {{ $salesDocument -> deliveryTypeID }} </td>
    </tr>
    <tr>
      <td><label> deliveryTypeName  </label></td>
      <td> {{ $salesDocument -> deliveryTypeName }} </td>
      <td><label> packingUnitsDescription  </label></td>
      <td> {{ $salesDocument -> packingUnitsDescription }} </td>
      <td><label> triangularTransaction  </label></td>
      <td> {{ $salesDocument -> triangularTransaction }} </td>
    </tr>
    <tr>
      <td><label> purchaseOrderDone  </label></td>
      <td> {{ $salesDocument -> purchaseOrderDone }} </td>
      <td><label> transactionTypeID  </label></td>
      <td> {{ $salesDocument -> transactionTypeID }} </td>
      <td><label> transactionTypeName  </label></td>
      <td> {{ $salesDocument -> transactionTypeName }} </td>
    </tr>
    <tr>
      <td><label> transportTypeID  </label></td>
      <td> {{ $salesDocument -> transportTypeID }} </td>
      <td><label> transportTypeName  </label></td>
      <td> {{ $salesDocument -> transportTypeName }} </td>
      <td><label> deliveryTerms  </label></td>
      <td> {{ $salesDocument -> deliveryTerms }} </td>
    </tr>
    <tr>
      <td><label> deliveryTermsLocation  </label></td>
      <td> {{ $salesDocument -> deliveryTermsLocation }} </td>
      <td><label> euInvoiceType  </label></td>
      <td> {{ $salesDocument -> euInvoiceType }} </td>
      <td><label> deliveryOnlyWhenAllItemsInStock  </label></td>
      <td> {{ $salesDocument -> deliveryOnlyWhenAllItemsInStock }} </td>
    </tr>
    <tr>
      <td><label> lastModified  </label></td>
      <td> {{ $salesDocument -> lastModified }} </td>
      <td><label> lastModifierUsername  </label></td>
      <td> {{ $salesDocument -> lastModifierUsername }} </td>
      <td><label> added  </label></td>
      <td> {{ $salesDocument -> added }} </td>
    </tr>
    <tr>
      <td><label> invoiceLink  </label></td>
      <td> 
          <a href="{{ $salesDocument -> invoiceLink }}">
          <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
          </a>
       </td>
      <td><label> receiptLink  </label></td>
      <td>
          <a href="{{ $salesDocument -> receiptLink }}">
          <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
          </a>
      </td>
    </tr>
  </tbody>
</table>
<nav>
  <ul class="pager">
    <li><a href="{{ URL::to( 'salesDocuments/' . $previous ) }}" class="">Previous</a></li>
    <li><a href="{{ URL::to( 'salesDocuments/' . $next ) }}">Next</a></li>
  </ul>
</nav>