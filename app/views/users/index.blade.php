<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> id </th>
			<th> Name </th>
			<!-- <th> status </th> -->
			<th> email </th>
			<th> created_at </th>
			<th> updated_at </th>
			<th> supplierID </th>
			<th style="width:100px;"> Action </th>
		</tr>
	</thead>
	<tbody>
	@foreach($users as $user)
	    <tr>
	    	<td>{{ $user-> id }}</td>
			<td><a href="{{URL::to('users/'.$user-> id)}}" target="_blank">{{ $user-> lastname }} {{ $user-> firstname }}</a></td>
			<!-- <td>{{ $user-> status }}</td> -->
			<td>{{ $user-> email }}</td>
			<td>{{ $user-> created_at }}</td>
			<td>{{ $user-> updated_at }}</td>
			<td>
				{{ Form::select('supplierID', $suppliers, $user-> supplierID , array('class'=>'form-control')) }}
			</td>
			<td class="action-button">
				<a href="users/{{$user-> id}}/edit" target="_blank"><span class="glyphicon glyphicon-edit" aria-hidden="true" data-toggle="tooltip" title="Amend"></span></a>
				<a href="users/{{$user-> id}}" target="_blank"><span class="glyphicon glyphicon-new-window" aria-hidden="true"  data-toggle="tooltip" title="Detail"></span></a>
				
				{{ Form::open(array('route'=>array('users.destroy',$user->id),'method'=>'delete')) }}
				<a href="#" class="submit"><span class="glyphicon glyphicon-trash" aria-hidden="true"  data-toggle="tooltip" title="Delete"></span></a>
				{{ Form::close()}}
				

				
			</td>
	    </tr>
	@endforeach
	</tbody>
</table>