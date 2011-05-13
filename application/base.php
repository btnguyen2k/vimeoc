<?php if (!defined('BASE_PATH')) exit('Not allowed.');
	
	class Application
	{
		var $uri;
		var $model;
		var $tmpl;
		
		function __construct($uri)
		{
			$this->uri = $uri;
			$this->tmpl = new Smarty();
			$this->tmpl->template_dir =  __DIR__ . '/templates/';
	     	$this->tmpl->compile_dir = __DIR__ . '/templates_c/';
	      	$this->tmpl->config_dir = __DIR__ . '/configs/';
	      	$this->tmpl->cache_dir = __DIR__ . '/cache/';
	     
	      	$this->tmpl->caching = true; 
		}
		
		function loadController($class)
		{
			$file = "application/controller/".$this->uri['controller'].".php";
				
			if(!file_exists($file)) die();
				
			require_once($file);

			$controller = new $class($this->tmpl);

			if(method_exists($controller, $this->uri['method']))
			{			 	
			 	$controller->{$this->uri['method']}($this->uri['var']);
			} else {
				$controller->index();	
			}
		}
		
		function loadView($view,$vars="")
		{
			if(is_array($vars) && count($vars) > 0)
				extract($vars, EXTR_PREFIX_SAME, "wddx");
			//require_once('view/'.$view.'.php');
			$this->tmpl->display($view.'.tpl');
		}
		
		function loadModel($model)
		{
			require_once('model/'.$model.'.php');
			$this->$model = new $model;
		}
	}
	
	class Model
	{
		var $url;
		
		function __construct()
		{
			$ini_array = parse_ini_file(__DIR__."/configs/db.ini");
			$this->url = $ini_array['driver']."://".$ini_array['username'].":".$ini_array['password']."@".$ini_array['host']."/".$ini_array['database'];
		}
		
		function connect() {
		    $conn = MDB2::factory($this->url);
		    if(PEAR::isError($conn)) {
		        die("Error while connecting : " . $con->getMessage());
		    }
		    return $conn;
		}
		
		function execute_query($sql, $values=array()) {
		    $con = connect();
		    $results = array();
		    if(sizeof($values) > 0) {
		        $statement = $con->prepare($sql, TRUE, MDB2_PREPARE_RESULT);
		        $resultset = $statement->execute($values);
		        $statement->free();
		    }
		    else {
		        $resultset = $con->query($sql);
		    }
		    if(PEAR::isError($resultset)) {
		        die('DB Error... ' . $resultset->getMessage());
		    }
		
		    while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {
		        $results[] = $row;
		    }
		    return $results;
		}
	}

?>