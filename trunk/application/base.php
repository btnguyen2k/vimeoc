<?php if (!defined('BASE_PATH')) exit('Not allowed.');
	define("ROLE_ADMIN", "ROLE_ADMIN");
	define("ROLE_USER", "ROLE_USER");
	
	class Application
	{
		var $uri;
		var $model;
		var $tmpl;
		var $messages;
		
		function __construct($uri)
		{
			$this->uri = $uri;
			$this->tmpl = new Smarty();
			$this->tmpl->template_dir =  __DIR__ . '/templates/';
	     	$this->tmpl->compile_dir = __DIR__ . '/templates_c/';
	      	$this->tmpl->config_dir = __DIR__ . '/configs/';
	      	$this->tmpl->cache_dir = __DIR__ . '/cache/';
	     
	      	$this->tmpl->caching = false; 
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
			require_once('view/'.$view.'.php');
		}
		
		function loadTemplate($view)
		{			
			$this->tmpl->assign("base_dir_decorator", __DIR__ . '/templates/decorator/');
			$this->tmpl->assign('body_code', $view.'.tpl');
			$this->tmpl->display('decorator/default.tpl');
		}
		
		function loadModel($model)
		{
			require_once('model/'.$model.'.php');
			$this->$model = new $model;
		}
		
		function redirect($url)
		{
			header("Location: " . $url);	
		}
		
		function loadMessages($code)
		{
			if($this->messages === null){
				$this->messages = parse_ini_file(__DIR__.'/configs/messages.ini');
			}
			
			return $this->messages[$code];
		}
		
		function getLoggedUser()
		{
			session_start();
			
			if (!isset($_SESSION['USER_SESSION'])){
				return null;
			}
			
			return $_SESSION['USER_SESSION'];
		}
		
		function setSessionValue($name, $value){
			session_start();
			
			$_SESSION[$name] = $value;
		}
		
		function isAdminLogged()
		{
			$loggedUser = $this->getLoggedUser();
			if($loggedUser == null)
			{
				return false;
			}
			else
			{
				$params = array();
				$params[0] = $loggedUser['id'];
				$params[1] = ROLE_ADMIN;
				$sql = "Select count(1) From user_role ur, role r where ur.role_id = r.id and ur.user_id = ? and r.name = ?";
				$result = $this->model->execute_query($sql, $params);
				
				return sizeof($resuls) > 0;
			}
		}
		
		function encodePassword($password)
		{
			return $this->createHash($password, '1dsat4', 'sha1');
		}
		
		private function createHash($inText, $saltHash=NULL, $mode='sha1')
		{
	        // hash the text //
	        $textHash = hash($mode, $inText);
	        // set where salt will appear in hash //
	        $saltStart = strlen($inText);
	        // if no salt given create random one //
	        if($saltHash == NULL) {
	            $saltHash = hash($mode, uniqid(rand(), true));
	        }
	        // add salt into text hash at pass length position and hash it //
	        if($saltStart > 0 && $saltStart < strlen($saltHash)) {
	            $textHashStart = substr($textHash,0,$saltStart);
	            $textHashEnd = substr($textHash,$saltStart,strlen($saltHash));
	            $outHash = hash($mode, $textHashEnd.$saltHash.$textHashStart);
	        } elseif($saltStart > (strlen($saltHash)-1)) {
	            $outHash = hash($mode, $textHash.$saltHash);
	        } else {
	            $outHash = hash($mode, $saltHash.$textHash);
	        }
	        // put salt at front of hash //
	        $output = $saltHash.$outHash;
	        return $output;
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
		
		function connect() 
		{
		    $conn = MDB2::factory($this->url);
		    if(PEAR::isError($conn)) {
		        die("Error while connecting : " . $con->getMessage());
		    }
		    return $conn;
		}
		
		function execute_query($sql, $values=array()) 
		{
		    $con = $this->connect();
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
		        die('DB Error... ' . $resultset->getDebugInfo(). '<BR/>' . $resultset->getMessage());
		    }
		
		    while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {
		        $results[] = $row;
		    }
		    return $results;
		}
		
		function execute_command($sql, $values, $types)
		{
			$con = $this->connect();
			
		    $statement = $con->prepare($sql, $types, MDB2_PREPARE_MANIP);
	        $affectRows = $statement->execute($values);
	        //$statement->free();	   
	        
		    if(PEAR::isError($affectRows)) {
		        die('DB Error... ' . $affectRows->getDebugInfo(). 
		        	'<BR/>' . $affectRows->getMessage(). 
		        	'<BR/>' . $affectRows->getUserInfo());
		    }		

		    return $affectRows;
		}
	}

?>