@if (count($actionLogs) === 0)
	<div>There is no record for actionLogs, you can sync to get the latest data! </div>
@else

<div>
	Total {{$actionLogs->getTotal()}} records are found. 
	{{$actionLogs->count()}} records in this page.

</div>
{{$actionLogs->appends(Request::input())->links()}}
<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> ID </th>
			<th> Module</th>
			<th> Type </th>
			<th> From Value</th>
			<th> To Value</th>
			<th> Notes </th>
			<th> Action by </th>
			<th> Action Date </th>
		</tr>
	</thead>
	<tbody>
	@foreach($actionLogs as $actionLog)
	    <tr>
			<td> {{ $actionLog -> id }} </td>
			<td> {{ $actionLog -> module }} </td>
			<td> {{ $actionLog -> type }} </td>
			<td> {{ $actionLog -> from }} </td>
			<td> {{ $actionLog -> to }} </td>
			<td> {{ $actionLog -> notes }} </td>
			<td> {{ $actionLog -> user }} </td>
			<td> {{ $actionLog -> created_at }} </td>
	    </tr>
	@endforeach
	</tbody>
</table>
{{$actionLogs->appends(Request::input())->links()}}
 @endif