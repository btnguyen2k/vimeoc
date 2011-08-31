<?php 
	$configs = parse_ini_file(dirname($_SERVER['SCRIPT_FILENAME']).'/application/configs/resources.ini');
	
	//Define our site URL
	define("BASE_PATH", $configs['domain']);
	
	//Define our basepath
	define("CONTEXT", $configs['context']);
	
	define("COMPONENT_VIDEO_TYPE", 1);
	
	define("COMPONENT_ALBUM_TYPE", 2);
	
	define("COMPONENT_CHANNEL_TYPE", 3);
	
	define("CONTENT_SYSTEM_TYPE", 1);
	
	define("CONTENT_USER_TYPE", 2);
	
	//Define Reset_Key
	define("RESETKEY_USER", NULL);
?>