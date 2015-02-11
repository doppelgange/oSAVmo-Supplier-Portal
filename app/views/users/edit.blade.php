{{ Form::open(array('url'=>'users/'.$user->id, 'class'=>'form-new form-horizontal')) }}
    <input type="hidden" name="_method" value="PUT" />
    <h2 class="form-signup-heading text-center">Amend User Basic Information:</h2>
 
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
    {{ Form::submit('Save Change', array('class'=>'btn btn-large btn-primary center-block'))}}
{{ Form::close() }}

{{ Form::open(array('url'=>'users/changePassword/'.$user->id, 'class'=>'form-new form-horizontal')) }}
    <input type="hidden" name="_method" value="PUT" />
    <h2 class="form-signup-heading text-center">Change Password:</h2>
    <div class="form-group">
    {{ Form::label('password', 'New Password',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
        </div>
    </div>

    <div class="form-group">
    {{ Form::label('password_confirmation', 'Confirm New Password',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-8">
        {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
        </div>
    </div>
    {{ Form::submit('Change Password', array('class'=>'btn btn-large btn-primary center-block'))}}

{{ Form::close() }}

