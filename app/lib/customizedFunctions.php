<?php
Class Helpers{
	public static function key_valid(&$key,&$array){
	if(array_key_exists($key,$array)==true){
		if(trim($array($key))==''||$array($key)==null){
			$array($key)='';
			return false;
		} 
		else return true;
	}else{
		$array($key)='';
		return false;
	}
}

}
?>