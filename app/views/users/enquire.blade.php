<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> id </th>
			<th> firstname </th>
			<th> lastname </th>
			<th> status </th>
			<th> email </th>
			<th> created_at </th>
			<th> updated_at </th>
			<th> supplierID </th>
			<th> Action </th>
		</tr>
	</thead>
	<tbody>
	@foreach($users as $user)
	    <tr>
	    	<td>{{ $user-> id }}</td>
			<td>{{ $user-> firstname }}</td>
			<td>{{ $user-> lastname }}</td>
			<td>{{ $user-> status }}</td>
			<td>{{ $user-> email }}</td>
			<td>{{ $user-> created_at }}</td>
			<td>{{ $user-> updated_at }}</td>
			<td>
				{{ Form::select('supplierID', $suppliers, $user-> supplierID , array('class'=>'form-control')) }}
			</td>
			<td>
				<a href="../users/enquire/{{$user-> id}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
				<a href="../users/amend/{{$user-> id}}"><span class="glyphicon glyphicon-share" aria-hidden="true"></span></a>
			</td>
	    </tr>
	@endforeach
	</tbody>
</table>