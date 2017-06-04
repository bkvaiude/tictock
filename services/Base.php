<?php

Class BaseService
{
	public $layout;
	public $mysqli;

	function __construct()
	{
		$db = Database::getInstance();
		$this->mysqli = $db->getConnection(); 

	}

	protected function requireToVar($file, $viewdata=null){
	    ob_start();
	    if(!empty($viewdata))extract($viewdata);
	    require($file);
	    return ob_get_clean();
	}

}
?>