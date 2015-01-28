{{ Form::open(array('url'=>'users/create', 'class'=>'form-new form-horizontal')) }}
    <h2 class="form-signup-heading text-center">Please input the user information:</h2>
 
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

    <div class="form-group">
    {{ Form::label('firstname', 'First Name',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::text('firstname', null, array('class'=>'form-control','placeholder'=>'First Name')) }}
        </div>
    </div>

    <div class="form-group">
    {{ Form::label('lastname', 'Last Name',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::text('lastname', null, array('class'=>'form-control', 'placeholder'=>'Last Name')) }}
        </div>
    </div>

    <div class="form-group">
    {{ Form::label('suppliername', 'Supplier Name',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::select('supplierID', $suppliers, null, array('class'=>'form-control')) }}
        </div>
    </div>


    <div class="form-group">
    {{ Form::label('email', 'Email',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
        </div>
    </div>

    <div class="form-group">
    {{ Form::label('password', 'Password',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
        </div>
    </div>

    <div class="form-group">
    {{ Form::label('password_confirmation', 'Confirm Password',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
        </div>
    </div>
    <div>

    </div>

    {{ Form::submit('Create', array('class'=>'btn btn-large btn-primary center-block'))}}



{{ Form::close() }}