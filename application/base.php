<?php if (!defined('BASE_PATH')) exit('Not allowed.');
	define("ROLE_ADMIN", "ROLE_ADMIN");
	define("ROLE_USER", "ROLE_USER");
	if (!defined("APP_DIR")) define("APP_DIR", dirname($_SERVER['SCRIPT_FILENAME']) . '/application');
	
	require_once 'utils.php';
	
	/**
	 * 
	 * Core controller
	 * @author Tri
	 *
	 */
	class Application
	{
		var $uri;
		var $model;
		var $tmpl;
		var $messages;
		var $errorMessages;
		var $resources;
		var $emailConfiguration;
		
		/**
		 * 
		 * Default constructor
		 * @param $uri
		 */
		function __construct($uri)
		{
			$this->uri = $uri;
			$this->tmpl = new Smarty();
			$this->tmpl->left_delimiter = '<:';
			$this->tmpl->right_delimiter = ':>';
			$this->tmpl->template_dir =  APP_DIR . '/templates/';
	     	$this->tmpl->compile_dir = APP_DIR . '/templates_c/';
	      	$this->tmpl->config_dir = APP_DIR . '/configs/';
	      	$this->tmpl->cache_dir = APP_DIR . '/cache/';
	     
	      	$this->tmpl->caching = false; 
		}
		/**
		 * Caculate time different
		 */
		function get_time_difference( $start, $end )
		{
		    $uts['start']      =    strtotime( $start );
		    $uts['end']        =    strtotime( $end );	
		    if( $uts['start']!==-1 && $uts['end']!==-1 )
		    {
		        if( $uts['end'] >= $uts['start'] )
		        {
		            $diff    =    $uts['end'] - $uts['start'];
		            if( $days=intval((floor($diff/86400))) )
		                $diff = $diff % 86400;
		            if( $hours=intval((floor($diff/3600))) )
		                $diff = $diff % 3600;
		            if( $minutes=intval((floor($diff/60))) )
		                $diff = $diff % 60;
		            $diff    =    intval( $diff );
		            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
		        }
		        else
		        {
		           return false;
		        }
		    }
		    else
		    {
		       return false;
		    }
		    return( false );
		}
		
		/**
		 * 
		 * Get current context path
		 */
		function ctx()
		{
			return CONTEXT;
		}
		
		function index()
		{
			$this->redirect($this->ctx().'/home');
		}
		
		/**
		 * 
		 * Load a controller
		 * @param $class
		 */
		function loadController($class)
		{
			$controllerName = $this->uri['controller'];
			if($controllerName == null || $controllerName == '')
			{
				$controllerName = $this->index();
				return;
			}
			
			$file = "application/controller/".$controllerName.".php";
			
			if(!file_exists($file)) {
				$file = "application/controller/route.php";
				$class = "route";	
				
				$_GET['userAlias'] = $controllerName;
				$_GET['videoAlias'] = $this->uri['method'];
				$_GET['albumAlias'] = $this->uri['method'];
				$this->uri['method'] = 'routing';
			}
				
			require_once($file);

			$controller = new $class($this->tmpl);
			
			if(method_exists($controller, $this->uri['method']))
			{			 	
				if(method_exists($controller, $this->uri['method'].'MessagesSource'))
				{
					$controller->{$this->uri['method'].'MessagesSource'}();
				}
			 	$controller->{$this->uri['method']}($this->uri['var']);			 	
			 	if(method_exists($controller, "onLoad")){
			 		$controller->onLoad();
			 	}
			} else {				
				if(method_exists($controller, "onLoad")){					
			 		$controller->onLoad();
			 	}
				$controller->index();	
			}
		}
		
		/**
		 * Get a controller
		 * @param $controller
		 */
		function getController($controllerName, $tmpl){
			$file = "application/controller/".$controllerName.".php";
			if(!file_exists($file)) die();
				
			require_once($file);
			
			$newController = new $controllerName($tmpl);
			
			return $newController;
		}
		
		/**
		 * 
		 * Load a view
		 * @param $view
		 * @param $vars
		 */
		function loadView($view,$vars="")
		{
			if(is_array($vars) && count($vars) > 0)
				extract($vars, EXTR_PREFIX_SAME, "wddx");
			require_once('view/'.$view.'.php');
		}
		
		/**
		 * 
		 * Load a template
		 * @param $view
		 */
		function loadTemplate($template)
		{			
			$this->tmpl->assign("base_dir_decorator", APP_DIR . '/templates/decorator/');
			$this->tmpl->assign("base_dir_templates", APP_DIR . '/templates/');
			$this->tmpl->assign('body_code', $template.'.tpl');
			$this->tmpl->assign('ctx', $this->ctx());
			$this->tmpl->assign('authorized', $this->getLoggedUser() > 0);
			if(isset($_SESSION['proxy']) && $_SESSION['proxy'] == true){
				$this->tmpl->assign('proxy', true);
			}else{
				$this->tmpl->assign('proxy', false);
			}
			$this->tmpl->display('decorator/default.tpl');
		}
		
		/**
		 * 
		 * Send email with smarty template 
		 * @param $templateName email template name. EX: mail_registerConfirm
		 * @param $modelName model name
		 * @param $model template model in array type
		 * @param $from from email address
		 * @param $to to email address
		 * @param $subject email subject
		 */
		function sendingEmailWithSmarty($templateName, $modelName, $model, $from, $to)
		{
			$this->tmpl->assign($modelName, $model);
			
			$body = $this->tmpl->fetch('mail/'.$templateName.'.tpl');
			
			// the subject is on the first line, so parse that out
	        $lines = explode("\n", $body);
	        $subject = trim(array_shift($lines));
	        $body = join("\n", $lines);
			
	        $this->sendingEmail($from, $to, $subject, $body);
		}
		
		/**
		 * 
		 * Send email
		 * @param $from
		 * @param $to
		 * @param $subject
		 * @param $body
		 */
		function sendingEmail($from, $to, $subject, $body)
		{
			require_once "Mail.php";
			
			if($this->emailConfiguration == null)
			{
				$this->emailConfiguration = parse_ini_file(APP_DIR.'/configs/mail.ini');
			}
			
			if($from == null)
			{
				$from = $this->emailConfiguration['mail.default.from'];
			}
			
			$host = $this->emailConfiguration['mail.smtp.host'];
		 	$port = $this->emailConfiguration['mail.ssl.port'];
		 	$ssl = $this->emailConfiguration['mail.ssl.use'];
			$username = $this->emailConfiguration['mail.username'];
		 	$password = $this->emailConfiguration['mail.password'];
		 
		 	$headers = array ('From' => $from,
							  'To' => $to,
		   					  'Subject' => $subject,
		 					  'Content-type' => 'text/html',
		 					  'charset' => 'utf-8');
		 	
		 	if($ssl == 'true')
		 	{
		 		$smtp = Mail::factory('smtp',
			   						  array ('host' => $host,
			     							 'port' => $port,
			     							 'auth' => true,
			     							 'username' => $username,
			     							 'password' => $password));
		 	}
		 	else
		 	{
		 		$smtp = Mail::factory('smtp',
   									  array ('host' => $host,
     								 		 'auth' => true,	
     										 'username' => $username,
     										 'password' => $password));
		 	}
		 
		 	$mail = $smtp->send($to, $headers, $body);
		 
		 	if (PEAR::isError($mail)) 
		 	{
		   		error_log($mail->getMessage(), 0);
		  	} 		  			
		}
		
		/**
		 * 
		 * Load a model
		 * @param $model
		 */
		function loadModel($model)
		{
			require_once('model/'.$model.'.php');
			$this->$model = new $model;
		}
		
		/**
		 * 
		 * Get a model
		 * @param $model
		 */
		function getModel($model){
			require_once('model/'.$model.'.php');
			$newModel = new $model;
			return $newModel;
		}
		
		/**
		 * 
		 * Redirect to $url
		 * @param $url
		 */
		function redirect($url)
		{
			header("Location: " . $url);	
		}
		
		/**
		 * 
		 * Load message source
		 * @param $code
		 */
		function loadMessages($code, $params=array())
		{
			if($this->messages === null){
				$this->messages = parse_ini_file(APP_DIR.'/configs/messages.ini');
			}
			if(sizeof($params) == 0)
				return $this->messages[$code];
			else
			{
				$msg = $this->messages[$code];
				for($i=0; $i<sizeof($params); $i++)
				{
					$search = '{' . $i . '}';
					$replaceStr = $params[$i];
					$msg = str_replace($search, $replaceStr, $msg);
				}
				
				return $msg;
			}
		}
		
		/**
		 * 
		 * Load error message source
		 * @param $code
		 */
		function loadErrorMessage($code, $params=array())
		{
			if($this->errorMessages === null){
				$this->errorMessages = parse_ini_file(APP_DIR.'/configs/errors.ini');
			}
			
			if(sizeof($params) == 0)
				return $this->errorMessages[$code];
			else
			{
				$msg = $this->errorMessages[$code];
				for($i=0; $i<count($params); $i++)
				{
					$search = '{' . $i . '}';
					$replaceStr = $params[$i];
					$msg = str_replace($search, $replaceStr, $msg);
				}
				return $msg;
			}
		}
		
		/**
		 * 
		 * Load resources configuration
		 * @param $code
		 */
		function loadResources($code)
		{
			if($this->resources === null)
			{
				$this->resources = parse_ini_file(APP_DIR.'/configs/resources.ini');
			}
			
			return $this->resources[$code];
		}
		
		/**
		 * 
		 * Get the logged in user
		 */
		function getLoggedUser()
		{
			if (!isset($_SESSION['uid']) ) 
			{
				$this->sessionDefaults();
			}
			
			return $_SESSION['uid'];
		}
		
		function sessionDefaults() {
			$_SESSION['logged'] = false;
			$_SESSION['uid'] = 0;
			$_SESSION['username'] = '';
			$_SESSION['cookie'] = 0;
			$_SESSION['remember'] = false;
		}
		
		/**
		 * 
		 * Set session value
		 * @param $name
		 * @param $value
		 */
		function setSessionValue($name, $value){
			$_SESSION[$name] = $value;
		}
		
		/**
		 * 
		 * Is logged in user an administrator?
		 */
		function isAdminLogged()
		{
			$loggedUser = $this->getLoggedUser();
			if($loggedUser == 0)
			{
				return false;
			}
			else
			{
				$params = array();
				$params[0] = $loggedUser;
				$params[1] = ROLE_ADMIN;
				$molde_user = $this->getModel('model_user');
				$result = $molde_user->isAdmin($params);
				
				return $result;
			}
		}
		
		/**
		 * 
		 * Encoding password
		 * @param $password
		 */
		function encodePassword($password)
		{
			return $this->createHash($password, '1dsat4', 'sha1');
		}
		
		/**
		 * 
		 * Encoding username with salt
		 * @param $username,$salt
		 */
		function encodeUsername($username,$salt)
		{
			return $this->createHash($username,$salt,'sha1');
			
		}


		
		/**
		 * 
		 * Hashcode the string
		 * @param unknown_type $inText
		 * @param unknown_type $saltHash
		 * @param unknown_type $mode
		 */
		function createHash($inText, $saltHash=NULL, $mode='sha1')
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
	    
	    /**
	     * 
	     * Assign key value to smarty template
	     * @param $name
	     * @param $value
	     */
	    function assign($name, $value)
	    {
	    	$this->tmpl->assign($name, $value);
	    }
	}
	
	
	/**
	 * 
	 * Core model
	 * @author Tri
	 *
	 */
	class Model
	{
		var $url;
		
		/**
		 * 
		 * Default constuctor
		 */
		function __construct()
		{
			$ini_array = parse_ini_file(APP_DIR."/configs/db.ini");
			$this->url = $ini_array['driver']."://".$ini_array['username'].":".$ini_array['password']."@".$ini_array['host'].($ini_array['port']?':'.$ini_array['port']:'')."/".$ini_array['database'];
		}
		
		/**
		 * 
		 * Get MDB2 instance
		 */
		function connect() 
		{
		    $conn = MDB2::factory($this->url);
		    if(PEAR::isError($conn)) {
		        die("Error while connecting : " . $conn->getMessage());
		    }
		    return $conn;
		}
		
		/**
		 * Help to get the latest generated ID 
		 * 
		 */
		function getLatestInsertId($tableName)
		{
			$conn = $this->connect();
			$conn->loadModule('Extended');
			return $conn->extended->getAfterID($id, $tableName);
		}
		
		/**
		 * 
		 * Execute query
		 * @param $sql
		 * @param $values
		 * @param $types
		 */
		function execute_query($sql, $values=array(), $types=array()) 
		{
		    $con = $this->connect();
		    $results = array();
		    if(sizeof($values) > 0) {
		        $statement = $con->prepare($sql, $types, MDB2_PREPARE_RESULT);
			    if(PEAR::isError($statement)) {
			         die('DB Error... ' . $statement->getDebugInfo(). 
			        	'<BR/>' . $statement->getMessage(). 
			        	'<BR/>' . $statement->getUserInfo());
			    }
		        $resultset = $statement->execute($values);
		        $statement->free();
		    }
		    else {
		        $resultset = $con->query($sql);
		    }
		    if(PEAR::isError($resultset)) {
		         die('DB Error... ' . $resultset->getDebugInfo(). 
		        	'<BR/>' . $resultset->getMessage(). 
		        	'<BR/>' . $resultset->getUserInfo());
		    }
		
		    while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {
		    	$results[] = $row;
		    }
		    
		    return $results;
		}
		
		/**
		 * Execute the update, delete and insert command
		 * 
		 * @param $sql
		 * @param $values
		 * @param $types
		 */
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