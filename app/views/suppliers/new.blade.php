{{ Form::open(array('url'=>'users/create', 'class'=>'form-register form-horizontal')) }}
    <h2 class="form-signup-heading text-center">Please Input Supplier Info</h2>
 
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

    <div class="form-group">
    {{ Form::label('erplyID', 'erplyID',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::text('erplyID', null, array('class'=>'form-control','placeholder'=>'erplyID')) }}
        </div>
    </div>

    <div class="form-group">
    {{ Form::label('supplierID', 'supplierID',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::text('supplierID', null, array('class'=>'form-control', 'placeholder'=>'supplierID')) }}
        </div>
    </div>

    <div class="form-group">
    {{ Form::label('supplierType', 'supplierType',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::text('suppliername', null, array('class'=>'form-control', 'placeholder'=>'supplierType')) }}
        </div>
    </div>

    <div class="form-group">
    {{ Form::label('fullName', 'fullName',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::text('fullName', null, array('class'=>'form-control', 'placeholder'=>'fullName')) }}
        </div>
    </div>

    <div class="form-group">
    {{ Form::label('companyName', 'companyName',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::text('companyName',null,  array('class'=>'form-control', 'placeholder'=>'companyName')) }}
        </div>
    </div>

    <div class="form-group">
    {{ Form::label('groupID', 'groupID',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::text('groupID',null,  array('class'=>'form-control', 'placeholder'=>'groupID')) }}
        </div>
    </div>

    <div>
test
    {{Form::select('size', array('L' => 'Large', 'S' => 'Small'));}}

{{Form::select('animal', array(
    'Cats' => array('leopard' => 'Leopard'),
    'Dogs' => array('spaniel' => 'Spaniel'),
));}}


{{Form::selectRange('number', 10, 20);}}


{{Form::selectMonth('month');}}

    </div>

    {{ Form::submit('Register', array('class'=>'btn btn-large btn-primary btn-block'))}}



{{ Form::close() }}