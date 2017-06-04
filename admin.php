<?php
	session_start();
	require_once "config.php";
	require_once "services/Base.php";
	require "vendor/autoload.php";
	require_once "services/Admin.php";
	require_once "services/Database.php";
	$layout = "layout/twitter-admin.html";
	$pageObject = new AdminService($layout);
	$pageMethod = isset($_REQUEST['landing_page']) && !empty($_REQUEST['landing_page']) ? $_REQUEST['landing_page'] : "login";

	if(!isset($_SESSION['is_login']) || $_SESSION['is_login']!=true)
	{
		$pageMethod	= "login";
	}


	// signup and attendance
	$_GET['page'] = isset($_REQUEST['page']) && !empty($_REQUEST['page']) ? $_REQUEST['page'] : 1;
	$_GET['search_key'] = isset($_REQUEST['search_key']) && !empty($_REQUEST['search_key']) ? $_REQUEST['search_key'] : "";
	$_GET['last_x_days'] = isset($_REQUEST['last_x_days']) && !empty($_REQUEST['last_x_days']) ? $_REQUEST['last_x_days'] : 30;
	$pageMethod = "get_".$pageMethod."_page";
	try
	{
		if(method_exists($pageObject,$pageMethod))
		{
			$pageObject->$pageMethod();
		}
		else
			throw new Exception('Page not found!');
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		echo file_get_contents("404.html");
	}
	
?>