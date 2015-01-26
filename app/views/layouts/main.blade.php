<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>oSAVmo - Management your online store</title>
    {{ HTML::style('packages/bootstrap/css/bootstrap.css') }}
    {{ HTML::style('css/main.css')}}
  </head>
 
  <body>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li>{{ HTML::link('users/register', 'Register') }}</li>
            <li>{{ HTML::link('users/login', 'Login') }}</li>  
            <li>{{ HTML::link('users/logout', 'Logout') }}</li>  
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

    <div class="container">
        @if(Session::has('message'))
            <p class="alert">{{ Session::get('message') }}</p>
        @endif
 
        {{ $content }}
    </div>
    
  </body>
</html>