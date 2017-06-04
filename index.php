<?php
	require_once "services/Base.php";
	require_once "config.php";
	require_once "services/Page.php";
	require_once "services/Database.php";
	$layout = file_get_contents("layout/twitter.html");
	$pageObject = new PageService($layout);
	$pageMethod = isset($_REQUEST['page']) && !empty($_REQUEST['page']) ? $_REQUEST['page'] : "signup";// signup and attendance
	$pageMethod = "get_".$pageMethod."_page";
	try
	{
		if(method_exists($pageObject,$pageMethod))
			$pageObject->$pageMethod();
		else
			throw new Exception('Page not found!');
	}
	catch(Exception $e)
	{
		echo file_get_contents("404.html");
	}
	
?>