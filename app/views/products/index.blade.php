	<div> <a class="btn btn-primary" href="sync" role="button">Sync Products from ERPLY</a> </div>
@if (count($products) === 0)
	<div>There is no record for products, you can sync from ERPLY to get the latest data! </div>
@else

{{ Form::open(array('url'=>'products/amend')) }}

<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th> ID </th>
			<th> Name </th>
			<th> Code </th>
			<th> EAN </th>
			<th> Name CN </th>
			<!-- <th> supplierID </th>
			<th> supplierName </th> -->
			<!-- <th> groupID </th>
			<th> Group </th>
			<th> categoryID </th> -->
			<th> Category</th>
			<!-- <th> seriesID </th>
			<th> seriesName </th>
			<th> unitID </th> -->
			<th> Unit </th>
			<th> Price(VAT), Price, Cost</th>
			<th> Status </th>
			<!-- <th> active </th> -->
			<th> Webshop </th>
			<!-- <th> vatrate </th>
			<th> countryOfOriginID </th>
			<th> brandName </th>
			<th> netWeight </th> -->
			<th> grossWeight </th>
			<!-- <th> VOL </th> -->
			<th> Desc </th>
			<!-- <th> erplyAdded </th> -->
			<th> erply Last Modified </th>
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
			<!-- <td> {{ $product -> supplierID }} </td> 
			<td> {{ $product -> supplierName }} </td>
			<td> {{ $product -> groupID }} </td>
			<td> {{ $product -> groupName }} </td>
			<td> {{ $product -> categoryID }} </td> -->
			<td> {{ $product -> categoryName }} </td>
			<!-- <td> {{ $product -> seriesID }} </td>
			<td> {{ $product -> seriesName }} </td>
			<td> {{ $product -> unitID }} </td> -->
			<td> {{ $product -> unitName }} </td>
			<td> 
				<div> {{ $product -> priceWithVat }}</div>
				<div> {{ $product -> price }} </div>
				<div> {{ $product -> cost }} </div>
			</td>
			<td> {{ $product -> status }} </td>
			<!-- <td> {{ $product -> active }} </td> -->
			<td> {{ $product -> displayedInWebshop }} </td>
			<!-- <td> {{ $product -> vatrate }} </td>
			<td> {{ $product -> countryOfOriginID }} </td>
			<td> {{ $product -> brandName }} </td>
			<td> {{ $product -> netWeight }} </td> -->
			<td> {{ $product -> grossWeight }} </td>
			<!-- <td> {{ $product -> volume }} </td> -->
			<td> {{ $product -> longdesc }} </td>
			<!-- <td> {{ $product -> erplyAdded }} </td> -->
			<td> {{ $product -> erplyLastModified }} </td>
	    </tr>
	@endforeach
	</tbody>
</table>
{{ Form::submit('Save Amendment', array('class'=>'btn btn-large btn-primary center-block'))}}


{{ Form::close() }}
 @endif



