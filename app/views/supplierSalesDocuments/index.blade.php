{{ Form::open(array('url'=>'supplierSalesDocuments','method' => 'get','class'=>'form-inline')) }}
@if(!Auth::user()->isSupplier())
	{{ Form::label('supplier', 'Supplier')}}
    {{ Form::select('supplierID', $supplierList, $supplierID , array('class'=>'form-control')) }}
@endif
    {{ Form::label('status', 'Status')}}
    {{ Form::select('status', $statusList, $q['status'] , array('class'=>'form-control')) }}
    {{ Form::label('username', 'User Name')}}
	{{Form::text('clientName',$q['clientName'],array('class'=>'form-control','placeholder'=>'Input your query'))}}
	{{ Form::label('number', 'Number')}}
	{{Form::text('number',$q['number'],array('class'=>'form-control','placeholder'=>'Input your query'))}}
	{{ Form::submit('Search', array('class'=>'btn btn-large btn-primary'))}}
{{ Form::close() }}
@if (count($supplierSalesDocuments) === 0)
	<div>There is no record for salesDocuments, you can sync to get the latest data! </div>
@else
<div>
	Total {{$supplierSalesDocuments->getTotal()}} records are found. 
	{{$supplierSalesDocuments->count()}} records in this page.

</div>
{{$supplierSalesDocuments->appends(Request::input())->links()}}
<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> No.</th>
			<th> Customer Name </th>
			<th> Total Price</th>
			<th> Status </th>
			<th> Customer Notes </th>
			<th style="width:85px"> Order Date </th>
			<!-- <th style="width:85px"> Last Modified </th> -->
			<th> Action </th>
		</tr>
	</thead>
	<tbody>
	@foreach($supplierSalesDocuments as $supplierSalesDocument )
	    <tr 
	    @if($supplierSalesDocument->status=='') class='danger' 
		@elseif($supplierSalesDocument->status=='Partial') class='warning'
	    @else class='success' 
	    @endif
	    >
			<td> 
				<a href="supplierSalesDocuments/{{$supplierSalesDocument->id}}/edit?supplierID={{$supplierID}}" target="_blank"> 
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
			<td class="col-md-3"> {{ $supplierSalesDocument->salesDocument->internalNotes }} </td>
			<td> {{ $supplierSalesDocument->salesDocument->date }} </td>
			<td class="action-button">
				<a href="supplierSalesDocuments/{{$supplierSalesDocument-> id}}/edit" target="_blank" class=""><span class="glyphicon glyphicon-edit" aria-hidden="true" data-toggle="tooltip" title="Amend"></span></a>
				<a href="supplierSalesDocuments/{{$supplierSalesDocument->id}}/fulfill" class="submit"><span class="glyphicon glyphicon-bed" aria-hidden="true"  data-toggle="tooltip" title="Fulfill"></span></a>
			</td>
	    </tr>
	@endforeach
	</tbody>
</table>
{{$supplierSalesDocuments->appends(Request::input())->links()}}
 @endif