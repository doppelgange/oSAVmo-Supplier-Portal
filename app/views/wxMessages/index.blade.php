@if (count($wxMessages) === 0)
<div>There is no record for wxMessages, you can sync to get the latest data! </div>
@else
<div>
	Total {{$wxMessages->getTotal()}} records are found. 
	{{$wxMessages->count()}} records in this page.

</div>
{{$wxMessages->links()}}
<table class='table table-striped table-bordered table-hover table-condensed'>
	<thead>
		<tr>
			<th> ToUserName </th>
			<th> FromUserName </th>
			<th> CreateTime </th>
			<th> MsgType </th>
			<th> Content </th>
			<th> MsgId </th>
			<th> PicUrl </th>
			<th> MediaId </th>
			<th> ThumbMediaId </th>
			<th> Url </th>
			<th> Title </th>
			<th> Description </th>
		</tr>
	</thead>
	<tbody>
		@foreach($wxMessages as $wxMessage )
		<tr>
			<td> {{ $wxMessage->toUserName }} </td>
			<td> {{ $wxMessage->fromUserName }} </td>
			<td> {{ $wxMessage->createTime }} </td>
			<td> {{ $wxMessage->msgType }} </td>
			<td> {{ $wxMessage->content }} </td>
			<td> {{ $wxMessage->msgId }} </td>
			<td> {{ $wxMessage->picUrl }} </td>
			<td> {{ $wxMessage->mediaId }} </td>
			<td> {{ $wxMessage->thumbMediaId }} </td>
			<td> {{ $wxMessage->url }} </td>
			<td> {{ $wxMessage->title }} </td>
			<td> {{ $wxMessage->description }} </td>
		</tr>
		@endforeach
	</tbody>
</table>
{{$wxMessages->links()}}
@endif