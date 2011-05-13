<?php
	define("BASE_DIR", __DIR__);
	
	//Define our site URL
	define("BASE_PATH", "http://localhost");
	
	//Define Smarty lib path
	define("SMARTY_DIR", __DIR__ . "/libs/smarty/");
	
	//Include Smarty 
	require_once(SMARTY_DIR.'Smarty.class.php');
	
	$smarty = new Smarty();
	
	//Define our basepath
	$path = "/vmc";
	
	//Take the initial PATH.
	$url = $_SERVER['REQUEST_URI'];
	$url = str_replace($path,"",$url);
	
	//creates an array from the rest of the URL
	$array_tmp_uri = preg_split('[\\/]', $url, -1, PREG_SPLIT_NO_EMPTY);
	
	//Here, we will define what is what in the URL
	$array_uri['controller'] = $array_tmp_uri[0]; //a class
	$array_uri['method']	 = $array_tmp_uri[1]; //a function
	$array_uri['var']		 = $array_tmp_uri[2]; //a variable
	
	//Load our base API
	require_once("application/base.php");
	
	//loads our controller
	$application = new Application($array_uri);
	$application->loadController($array_uri['controller']);
?>
