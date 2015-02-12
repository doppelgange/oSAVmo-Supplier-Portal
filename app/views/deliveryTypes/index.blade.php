
@if (count($deliveryTypes) === 0)
<div>There is no record for deliveryTypes, you can sync to get the latest data! </div>
@else
<div>
	Total {{$deliveryTypes->getTotal()}} records are found. 
	{{$deliveryTypes->count()}} records in this page.

</div>
{{$deliveryTypes->links()}}
<table class='table table-striped table-bordered table-hover table-condensed'>
	<thead>
		<tr>
			<th> deliveryTypeID </th>
			<th> code </th>
			<th> name </th>
			<th> added </th>
			<th> lastModified </th>
		</tr>
	</thead>
	<tbody>
		@foreach($deliveryTypes as $deliveryType )
		<tr>
			<td> {{ $deliveryType->deliveryTypeID }} </td>
			<td> {{ $deliveryType->code }} </td>
			<td> {{ $deliveryType->name }} </td>
			<td> {{ $deliveryType->added }} </td>
			<td> {{ $deliveryType->lastModified }} </td>
		</tr>
		@endforeach
	</tbody>
</table>
{{$deliveryTypes->links()}}
@endif