<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>oSAVmo - Management your online store</title>
    <link rel="shortcut icon" href='{{{ asset('images/common/favicon.png') }}}' sizes="16x16">
    {{ HTML::style('css/bootstrap.css') }}
    {{ HTML::style('css/main.css')}}
    {{ HTML::script('js/jquery-2.1.3.js') }}
    {{ HTML::script('js/bootstrap.js') }}
    {{ HTML::script('js/app.js') }}
  </head>
 
  <body>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">   
            <li>{{ HTML::link('products', 'Products') }}</li>
            <li>{{ HTML::link('supplierSalesDocuments', 'Supplier Order') }}</li>
            <li>{{ HTML::link('users', 'Users') }}</li>
            @if(Auth::check())
            <li>{{ HTML::link('users/'.Auth::user()->id, Auth::user()->lastname.' ('.(Auth::user()->supplierID==0?'All Suppliers':Auth::user()->supplier->fullName).')')}}</li>
            <li>{{ HTML::link('users/logout', 'Logout') }}</li>
            @else
            <li>{{ HTML::link('users/login', 'Login') }}</li> 
            @endif
            @if(Auth::check()&&!Auth::user()->isSupplier())
            <li>{{ HTML::link('admin', 'Admin') }}</li>
            <li>{{ HTML::link('suppliers', 'Suppliers') }}</li>
            <li>{{ HTML::link('properties', 'Property') }}</li>
            <li>{{ HTML::link('actionLogs', 'Logs') }}</li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Admin <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li class="divider"></li>
                <li>{{ HTML::link('priceListItems', 'Price') }}</li>
                <li>{{ HTML::link('salesDocuments', 'Order(Admin)') }}</li>
                <li>{{ HTML::link('salesDocumentItems', 'Order Item')}}</li>
                <li>{{ HTML::link('productStocks', 'Stocks') }}</li>
                <li class="divider"></li>
                <li>{{ HTML::link('admin/init', 'Initiate System') }}</li>
                <li>{{ HTML::link('priceListItems/sync', 'Sync Price List') }}</li>
                <li>{{ HTML::link('suppliers/sync', 'Sync Suppliers') }}</li>
                <li>{{ HTML::link('products/sync', 'Sync Products') }}</li>
                <li>{{ HTML::link('productStocks/sync', 'Sync Product Stocks') }}</li>
                <li>{{ HTML::link('salesDocuments/sync', 'Sync Orders of last week') }}</li>
                <li>{{ HTML::link('supplierSalesDocuments/sync', 'Sync Supplier Orders') }}</li>
                
              </ul>
            </li>
            @endif()
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>




    <div class="container">
      @if(isset($headline))
        <h1>{{$headline or ''}} <small>{{$subtext or ''}} </small></h1>
      @endif

    <!-- Message from session -->
    @if(Session::has('message'))
    <div class="alert  fade in
        {{Session::get('alertClass',function(){return 'alert-info';})}}
    " role="alert">
      {{ Session::get('message') }}

      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif





        {{$content}}
        
    </div>
    
  </body>
</html>