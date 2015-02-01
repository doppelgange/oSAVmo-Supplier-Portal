<?php
class SyncHelper {
	public static function syncSuppliers(){
		$api = new EAPI();
		$erplySuppliers = json_decode(
			$api->sendRequest(
				"getSuppliers", 
				array(
				    "recordsOnPage" =>100,
				    "responseMode" => "detail",
				    //"displayedInWebshop" => 1,
				    //"productID" => 2306	
				)
			), 
			true
		)['records'];
		if(is_null($erplySuppliers)){
			return false;
		}else{
			foreach ($erplySuppliers as $erplySupplier) {
				$supplier = Supplier::where('supplierID', '=', $erplySupplier['supplierID'])->first();
				if (is_null($supplier)){
					$supplier = new Supplier;
					$supplier->supplierID = $erplySupplier['supplierID'];
				}
				$supplier->erplyID = $erplySupplier['id'];
			    $supplier->supplierType = $erplySupplier['supplierType'];
			    $supplier->fullName = $erplySupplier['fullName'];
			    $supplier->companyName = $erplySupplier['companyName'];
			    $supplier->groupID = $erplySupplier['groupID'];
			    $supplier->erplyAdded = date('y-m-d h:i:s',$erplySupplier['added']) ;
			    $supplier->erplyLastModified = date('y-m-d h:i:s',$erplySupplier['lastModified']); 
			    $supplier->save();
			}
			return true;	
		}
	}

	//Sync Products only sync the first 100 products now!
	public static function syncProducts($supplierID){
		$api = new EAPI();
		$supplierIDstr= $supplierID==null?'':'"supplierID"=>'.$supplierID;


		$pageNo=1;
		$erplyProducts = json_decode(
			$api->sendRequest(
				"getProducts", 
				array(
				    "getStockInfo"=>1,
					"recordsOnPage" =>100,
					//"active"=>1,
					$supplierIDstr,
					"pageNo"=>$pageNo
				)
			), 
			true
		)['records'];
		if(is_null($erplyProducts)){
			return false;
		}else{
			foreach ($erplyProducts as $erplyProduct) {
				$product = Product::where('productID', '=', (int)$erplyProduct['productID'])->first();
				if (is_null($product)){
					$product = new Product;
					$product->productID = $erplyProduct['productID'];
				}
				//$product->productID = $erplyProduct['productID'];
				$product->name = $erplyProduct['name'];
				$product->code = $erplyProduct['code'];
				$product->ean = $erplyProduct['code2'];
				$product->nameCN = $erplyProduct['code3'];
				$product->supplierID = $erplyProduct['supplierID'];
				$product->supplierName = $erplyProduct['supplierName'];
				$product->groupID = $erplyProduct['groupID'];
				$product->groupName = $erplyProduct['groupName'];
				$product->categoryID = $erplyProduct['categoryID'];
				$product->categoryName = $erplyProduct['categoryName'];
				$product->seriesID = $erplyProduct['seriesID'];
				$product->seriesName = $erplyProduct['seriesName'];
				$product->unitID = $erplyProduct['unitID'];
				$product->unitName = $erplyProduct['unitName'];
				$product->price = $erplyProduct['price'];
				$product->priceWithVat = $erplyProduct['priceWithVat'];
				$product->cost = $erplyProduct['cost'];
				$product->status = $erplyProduct['status'];
				$product->active = $erplyProduct['active'];
				$product->displayedInWebshop = $erplyProduct['displayedInWebshop'];
				$product->vatrate = $erplyProduct['vatrate'];
				$product->countryOfOriginID = $erplyProduct['countryOfOriginID'];
				$product->brandName = $erplyProduct['brandName'];
				$product->netWeight = $erplyProduct['netWeight'];
				$product->grossWeight = $erplyProduct['grossWeight'];
				$product->volume = $erplyProduct['volume'];
				$product->longdesc = $erplyProduct['longdesc'];
				$product->erplyAdded = date('y-m-d h:i:s',$erplyProduct['added']) ;
			    $product->erplyLastModified = date('y-m-d h:i:s',$erplyProduct['lastModified']); 
			    $product->save();
			}
			return true;	
		}
	}




}

?>