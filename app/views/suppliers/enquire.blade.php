	<div> <a class="btn btn-primary" href="sync" role="button">Sync Suppliers from ERPLY</a> </div>
@if (count($suppliers) === 0)
	<div>There is no record for suppliers, you can sync from ERPLY to get the latest data! </div>
@else

{{ Form::open(array('url'=>'suppliers/amend')) }}

<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> id </th>
			<th> erplyid </th>
			<th> supplierID </th>
			<!-- <th> supplierType </th> -->
			<th> fullName </th>
			<th> companyName </th>
			<!-- <th> groupID </th>
			<th> groupName </th>
			<th> erplyLastModified </th>
			<th> erplyAdded </th> -->
			<th> created_at </th>
			<th> updated_at </th>
			<th> Manageable </th>
		</tr>
	</thead>
	<tbody>
	@foreach($suppliers as $supplier)
	    <tr>
	    	<td>{{ $supplier->id }}</td>
	    	<td>{{ $supplier->erplyid }}</td>
	    	<td>{{ $supplier->supplierID }}</td>
	    	<!-- <td>{{ $supplier->supplierType }}</td> -->
	    	<td>{{ $supplier->fullName }}</td>
	    	<td>{{ $supplier->companyName }}</td>
	    	<!-- <td>{{ $supplier->groupID }}</td>
	    	<td>{{ $supplier->groupName }}</td>
	    	<td>{{ $supplier->erplyLastModified }}</td>
	    	<td>{{ $supplier->erplyAdded }}</td> -->
	    	<td>{{ $supplier->created_at }}</td>
	    	<td>{{ $supplier->updated_at }}</td>
	    	<td> {{ Form::select('manageable['.$supplier->id.']',array('Yes'=>'Yes','No'=>'No'),$supplier->manageable)}} 

	    	{{ Form::hidden('erplyid['.$supplier->id.']', $supplier->erplyid) }}
	    	</td>
	    </tr>
	@endforeach
	</tbody>
</table>
{{ Form::submit('Save Amendment', array('class'=>'btn btn-large btn-primary center-block'))}}


{{ Form::close() }}
 @endif



