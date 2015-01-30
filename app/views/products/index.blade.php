	<div> <a class="btn btn-primary" href="sync" role="button">Sync Products from ERPLY</a> </div>
@if (count($products) === 0)
	<div>There is no record for products, you can sync from ERPLY to get the latest data! </div>
@else

{{ Form::open(array('url'=>'products/amend')) }}

<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> productID </th>
			<th> name </th>
			<th> code </th>
			<th> ean </th>
			<th> nameCN </th>
			<th> supplierID </th>
			<th> supplierName </th>
			<th> groupID </th>
			<th> groupName </th>
			<th> categoryID </th>
			<th> categoryName </th>
			<th> seriesID </th>
			<th> seriesName </th>
			<th> unitID </th>
			<th> unitName </th>
			<th> price </th>
			<th> priceWithVat </th>
			<th> cost </th>
			<th> status </th>
			<th> active </th>
			<th> displayedInWebshop </th>
			<th> vatrate </th>
			<th> countryOfOriginID </th>
			<th> brandName </th>
			<th> netWeight </th>
			<th> grossWeight </th>
			<th> volume </th>
			<th> longdesc </th>
			<th> erplyAdded </th>
			<th> erplyLastModified </th>
		</tr>
	</thead>
	<tbody>
	@foreach($products as $product)
	    <tr>
			<td> {{ $product -> productID }} </td>
			<td> {{ $product -> name }} </td>
			<td> {{ $product -> code }} </td>
			<td> {{ $product -> ean }} </td>
			<td> {{ $product -> nameCN }} </td>
			<td> {{ $product -> supplierID }} </td>
			<td> {{ $product -> supplierName }} </td>
			<td> {{ $product -> groupID }} </td>
			<td> {{ $product -> groupName }} </td>
			<td> {{ $product -> categoryID }} </td>
			<td> {{ $product -> categoryName }} </td>
			<td> {{ $product -> seriesID }} </td>
			<td> {{ $product -> seriesName }} </td>
			<td> {{ $product -> unitID }} </td>
			<td> {{ $product -> unitName }} </td>
			<td> {{ $product -> price }} </td>
			<td> {{ $product -> priceWithVat }} </td>
			<td> {{ $product -> cost }} </td>
			<td> {{ $product -> status }} </td>
			<td> {{ $product -> active }} </td>
			<td> {{ $product -> displayedInWebshop }} </td>
			<td> {{ $product -> vatrate }} </td>
			<td> {{ $product -> countryOfOriginID }} </td>
			<td> {{ $product -> brandName }} </td>
			<td> {{ $product -> netWeight }} </td>
			<td> {{ $product -> grossWeight }} </td>
			<td> {{ $product -> volume }} </td>
			<td> {{ $product -> longdesc }} </td>
			<td> {{ $product -> erplyAdded }} </td>
			<td> {{ $product -> erplyLastModified }} </td>
	    </tr>
	@endforeach
	</tbody>
</table>
{{ Form::submit('Save Amendment', array('class'=>'btn btn-large btn-primary center-block'))}}


{{ Form::close() }}
 @endif



