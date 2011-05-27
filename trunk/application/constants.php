<?php 
	$configs = parse_ini_file(dirname($_SERVER['SCRIPT_FILENAME']).'/application/configs/resources.ini');
	
	//Define our site URL
	define("BASE_PATH", $configs['domain']);
	
	//Define our basepath
	define("CONTEXT", $configs['context']);
?>