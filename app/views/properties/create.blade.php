{{ Form::open(array('url'=>'properties', 'class'=>'container form-inline')) }}
    <!--<h2 class="form-signup-heading text-center">Please Add the property information:</h2>-->
 
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

    <div class="form-group">
        {{ Form::label('name', 'Name');}}
        {{ Form::text('name', null, array('class'=>'form-control','placeholder'=>'Property Name')) }}
        {{ Form::label('key', 'Key',array('class'=>'control-label'));}}
        {{ Form::text('key', null, array('class'=>'form-control', 'placeholder'=>'Property Key')) }}
        {{ Form::label('value', 'Value',array('class'=>'control-label'));}}
        {{ Form::text('value', null, array('class'=>'form-control', 'placeholder'=>'Property Value')) }}
        {{ Form::label('remarks', 'Remarks',array('class'=>'control-label'));}}
        {{ Form::text('remarks', null, array('class'=>'form-control', 'placeholder'=>'Remarks')) }}
        {{ Form::submit('Add', array('class'=>'btn btn-large btn-primary'))}}
    </div>

    
{{ Form::close() }}

@if (count($properties) === 0)
 <div>There is no record for propertis.</div>
@else

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
 @endif