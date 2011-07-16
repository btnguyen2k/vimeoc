<?php
	session_start();
	
	date_default_timezone_set('UTC');
	
	//Load constants variables
	require_once("application/constants.php");
	
	define("BASE_DIR", dirname($_SERVER['SCRIPT_FILENAME']));
	
	//Define Smarty lib path
	define("SMARTY_DIR", BASE_DIR . "/libs/smarty/");
		
	//Include Smarty 
	require_once(SMARTY_DIR.'Smarty.class.php');
	
	//Here, we will define what is what in the URL
	$array_uri['controller'] = $_REQUEST["controller"]; //a class
	$array_uri['method']	 = $_REQUEST["method"]; //a function
	
	//Load our base API
	require_once("application/base.php");
	
	//loads our controller
	$application = new Application($array_uri);
	$application->loadController($array_uri['controller']);
?>
