<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Sync Control</h3>
  </div>
  <div class="panel-body">
    <a href="admin/init" class="btn btn-primary"> Initiate system</a>
	<a href="suppliers/sync" class="btn btn-primary"> Sync All Suppliers</a>
	<a class="btn btn-primary" href="products/sync" role="button">Sync Products for Current Supplier</a>
	<a href="products/sync/all" class="btn btn-primary"> Sync All Products</a>
	<a href="productStocks/sync" class="btn btn-primary"> Sync All Product Stocks</a>
	<a href="salesDocuments/sync" class="btn btn-primary"> Sync Sales Documents</a>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">User admin Control</h3>
  </div>
  <div class="panel-body">
    <a href="users/create" class="btn btn-primary"> Create User</a>
  </div>
</div>


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Other Control</h3>
  </div>
  <div class="panel-body">
    {{ HTML::link('salesDocumentItems', 'Order Item',array('class'=>'btn btn-primary')) }}
    {{ HTML::link('productStocks', 'Stocks') }}
    {{ HTML::link('suppliers', 'Suppliers') }}
    {{ HTML::link('actionLogs', 'Logs') }}
  </div>
</div>







