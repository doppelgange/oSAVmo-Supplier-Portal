{{ Form::open(array('url'=>'users/signin', 'class'=>'form-signin  form-horizontal')) }}
    <h2 class="form-signin-heading text-center">Please Login</h2>
 
 	<div class="form-group">
 	{{ Form::label('email', 'Email',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-6">
    	{{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
    	</div>
    </div>

    <div class="form-group">
 	{{ Form::label('password', 'Password',array('class'=>'col-sm-4 control-label'));}}
        <div class="col-sm-6">
    	{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
 		</div>
 	</div>
    <div class="form-group">
        <div class="col-sm-4"></div>
        <div class="col-sm-6">
            {{ Form::checkbox('rememberMe', 'true') }}
            {{ Form::label('rememberMe', 'Remember me')}}
        </div>
    </div>
 	<div class="text-center">
    {{ Form::submit('Login', array('class'=>'btn btn-large btn-primary '))}}
    </div>
{{ Form::close() }}