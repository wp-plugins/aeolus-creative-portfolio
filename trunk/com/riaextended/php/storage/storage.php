<?php

/**
 * storage class
 */
class RXStorage {
	
	private $data;
	function __construct() {
		$this->data = array();
	}
	
	private static $instance;
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new RXStorage();
		}
		return self::$instance;		
	}
	
	public function addData($identifier, $data){
		array_push($this->data, array('identifier'=>$identifier, 'data'=>$data));
	}
	
	public function getData($identifier){
		$out = null;
		for ($i=0; $i < sizeof($this->data); $i++) { 
			if($this->data[$i]['identifier']==$identifier){
				$out = $this->data[$i]['data'];
				break;
			}
		}
		return $out;
	}
}


?>