<?php
Class Helpers{
	public static function syncChangeFromParser($option=array()){
		$data = $option['data'];
		if(array_key_exists('days',$data)){
			//If sync from last time
			if($data['days']=='auto'){
				if(Property::qget('AutoSyncTimesLog',$option['module'])!=null){
					$returnDate = Property::qget('AutoSyncTimesLog',$option['module'])->value;
				}
			}elseif(is_numeric($data['days'])){
				$returnDate = strtotime("-".$data['days']." days");
			}
		}
		if(isset($returnDate)==false){
			$returnDate = strtotime("-7 days");
		}
		return $returnDate;
	}

}
?>