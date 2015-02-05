@if (count($suppliers) === 0)
	<div>There is no record for suppliers, you can sync to get the latest data! </div>
@else

{{ Form::open(array('url'=>'suppliers/batch-amend')) }}

<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> id </th>
			<th> erplyID </th>
			<th> supplierID </th>
			<!-- <th> supplierType </th> -->
			<th> fullName </th>
			<th> companyName </th>
			<!-- <th> groupID </th>
			<th> groupName </th>-->
			<th> erplyLastModified </th>
			<th> erplyAdded </th> 
			<!-- <th> created_at </th>
			<th> updated_at </th> -->
			<th> Manageable </th>
			<th> Action</th>
		</tr>
	</thead>
	<tbody>
	@foreach($suppliers as $supplier)
	    <tr @if($supplier->manageable == 'Yes') class="success" @endif>
	    	<td>{{ $supplier->id }}</td>
	    	<td>{{ $supplier->erplyID }}</td>
	    	<td>{{ $supplier->supplierID }}</td>
	    	<!-- <td>{{ $supplier->supplierType }}</td> -->
	    	<td>{{ $supplier->fullName }}</td>
	    	<td>{{ $supplier->companyName }}</td>
	    	<!-- <td>{{ $supplier->groupID }}</td>
	    	<td>{{ $supplier->groupName }}</td> -->
	    	<td>{{ $supplier->erplyLastModified }}</td>
	    	<td>{{ $supplier->erplyAdded }}</td>
	    	<!-- <td>{{ $supplier->created_at }}</td>
	    	<td>{{ $supplier->updated_at }}</td> -->
	    	<td> {{ Form::select('manageable['.$supplier->id.']',array('Yes'=>'Yes','No'=>'No'),$supplier->manageable, array('class'=>'form-control'))}} 

	    	{{ Form::hidden('erplyID['.$supplier->id.']', $supplier->erplyID) }}
	    	</td>
	    	<td class="action-button">
				<a href="suppliers/{{$supplier-> id}}/edit" target="_blank"><span class="glyphicon glyphicon-edit" aria-hidden="true" data-toggle="tooltip" title="Amend"></span></a>
				<a href="suppliers/{{$supplier-> id}}" target="_blank"><span class="glyphicon glyphicon glyphicon-new-window" aria-hidden="true"  data-toggle="tooltip" title="Detail"></span></a>
			</td>
	    </tr>
	@endforeach
	</tbody>
</table>

{{ Form::submit('Save Amendment', array('class'=>'btn btn-large btn-primary center-block'))}}


{{ Form::close() }}
 @endif



