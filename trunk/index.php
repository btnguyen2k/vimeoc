<?php
	session_start();
	
	//Load constants variables
	require_once("application/constants.php");
	
	define("BASE_DIR", dirname($_SERVER['SCRIPT_FILENAME']));
	
	//Define Smarty lib path
	define("SMARTY_DIR", BASE_DIR . "/libs/smarty/");
		
	//Include Smarty 
	require_once(SMARTY_DIR.'Smarty.class.php');
	
	$smarty = new Smarty();
	$smarty->left_delimiter = "(:";
	$smarty->right_delimiter = ":)";
	
	//Take the initial PATH.
	$url = $_SERVER['REQUEST_URI'];
	$url = str_replace(CONTEXT,"",$url);
	
	//creates an array from the rest of the URL
	$array_tmp_uri = preg_split('[\\/]', $url, -1, PREG_SPLIT_NO_EMPTY);
	
	//Here, we will define what is what in the URL
	$array_uri['controller'] = isset($array_tmp_uri[0])?$array_tmp_uri[0]:NULL; //a class
	$array_uri['method']	 = isset($array_tmp_uri[1])?$array_tmp_uri[1]:NULL; //a function
	$array_uri['var']		 = isset($array_tmp_uri[2])?$array_tmp_uri[2]:NULL; //a variable
	
	//Load our base API
	require_once("application/base.php");
	
	//loads our controller
	$application = new Application($array_uri);
	$application->loadController($array_uri['controller']);
?>
