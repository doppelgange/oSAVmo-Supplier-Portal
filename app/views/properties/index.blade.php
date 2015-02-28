@if (count($properties) === 0)
 <div>There is no record for propertis,please <a href="properties/create">add new properties.</a> </div>
@else
<div>
 Total {{$properties->getTotal()}} records are found. 
 {{$properties->count()}} records in this page.

</div>
{{$properties->appends(Request::input())->links()}}
<table class='table table-striped table-bordered table-hover table-condensed'>
 <thead>
  <tr>
    <th> name </th>
<th> key </th>
<th> value </th>
<th> remarks </th>
</tr>
 </thead>
 <tbody>
 @foreach($properties as $property )
     <tr>
          <td> {{ $property->name }} </td>
<td> {{ $property->key }} </td>
<td> {{ $property->value }} </td>
<td> {{ $property->remarks }} </td>
     </tr>
 @endforeach
 </tbody>
</table>
{{$properties->appends(Request::input())->links()}}
 @endif