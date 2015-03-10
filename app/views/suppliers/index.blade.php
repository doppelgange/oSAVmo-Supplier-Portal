{{ Form::open(array('url'=>'suppliers','method' => 'get','class'=>'form-inline')) }}
	{{ Form::label('name', 'Name')}}
	{{Form::text('q',$q,array('class'=>'form-control','placeholder'=>'Input your query'))}}
	{{ Form::submit('Search', array('class'=>'btn btn-large btn-primary'))}}
{{ Form::close() }}

@if (count($suppliers) === 0)
	<div>There is no record for suppliers, you can sync to get the latest data! </div>
@else
Total {{$suppliers->getTotal()}} records are found. 
	{{$suppliers->count()}} records in this page.
	
{{ Form::open(array('url'=>'suppliers/batch-amend')) }}
{{$suppliers->appends(Request::input())->links()}}
<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> id </th>
			{{-- <th> supplierID </th> --}}
			<th> Type </th>
			<th> Name </th>
			<th> Manageable </th>
			{{-- <th> Action</th> --}}
		</tr>
	</thead>
	<tbody>
	@foreach($suppliers as $supplier)
	    <tr @if($supplier->manageable == 'Yes') class="success" @endif>
	    	<td>{{ $supplier->id }}</td>
	    	{{-- <td>{{ $supplier->supplierID }}</td> --}}
	    	<td>{{ $supplier->supplierType }}</td>
	    	<td>{{ $supplier->fullName }}</td>
	    	<td> {{ Form::select('manageable['.$supplier->id.']',array('Yes'=>'Yes','No'=>'No'),$supplier->manageable, array('class'=>'form-control'))}} 

	    	{{ Form::hidden('erplyID['.$supplier->id.']', $supplier->erplyID) }}
	    	</td>
	    	{{-- <td class="action-button">
				<a href="suppliers/{{$supplier-> id}}/edit" target="_blank"><span class="glyphicon glyphicon-edit" aria-hidden="true" data-toggle="tooltip" title="Amend"></span></a>
				<a href="suppliers/{{$supplier-> id}}" target="_blank"><span class="glyphicon glyphicon glyphicon-new-window" aria-hidden="true"  data-toggle="tooltip" title="Detail"></span></a>
			</td> --}}
	    </tr>
	@endforeach
	</tbody>
</table>
{{$suppliers->appends(Request::input())->links()}}
{{ Form::submit('Save Amendment', array('class'=>'btn btn-large btn-primary center-block'))}}


{{ Form::close() }}
 @endif



