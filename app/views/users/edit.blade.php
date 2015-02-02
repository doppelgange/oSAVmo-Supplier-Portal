{{ Form::open(array('url'=>'users/'.$user->id, 'class'=>'form-new form-horizontal')) }}
    <input type="hidden" name="_method" value="PUT" />
    <h2 class="form-signup-heading text-center">The user information:</h2>
 
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

    <div class="form-group">
    {{ Form::label('firstname', 'First Name',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::text('firstname', $user->firstname, array('class'=>'form-control','placeholder'=>'First Name')) }}
        </div>
    </div>

    <div class="form-group">
    {{ Form::label('lastname', 'Last Name',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::text('lastname', $user->lastname, array('class'=>'form-control', 'placeholder'=>'Last Name')) }}
        </div>
    </div>

    <div class="form-group">
    {{ Form::label('suppliername', 'Supplier Name',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::select('supplierID', $suppliers, $user-> supplierID , array('class'=>'form-control')) }}
        </div>
    </div>


    <div class="form-group">
    {{ Form::label('email', 'Email',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::text('email', $user->email, array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
        </div>
    </div>
    {{ form::hidden('id', $user->id)}}
    {{ Form::submit('amend', array('class'=>'btn btn-large btn-primary center-block'))}}



{{ Form::close() }}