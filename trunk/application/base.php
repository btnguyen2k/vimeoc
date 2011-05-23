<?php if (!defined('BASE_PATH')) exit('Not allowed.');
	define("ROLE_ADMIN", "ROLE_ADMIN");
	define("ROLE_USER", "ROLE_USER");
	
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
			$this->tmpl->template_dir =  __DIR__ . '/templates/';
	     	$this->tmpl->compile_dir = __DIR__ . '/templates_c/';
	      	$this->tmpl->config_dir = __DIR__ . '/configs/';
	      	$this->tmpl->cache_dir = __DIR__ . '/cache/';
	     
	      	$this->tmpl->caching = false; 
		}
		
		/**
		 * 
		 * Get current context path
		 */
		function ctx()
		{
			return CONTEXT;
		}
		
		/**
		 * 
		 * Load a controller
		 * @param $class
		 */
		function loadController($class)
		{
			$file = "application/controller/".$this->uri['controller'].".php";
				
			if(!file_exists($file)) die();
				
			require_once($file);

			$controller = new $class($this->tmpl);
			
			if(method_exists($controller, $this->uri['method']))
			{			 	
				if(method_exists($controller, $this->uri['method'].'MessagesSource'))
				{
					$controller->{$this->uri['method'].'MessagesSource'}();
				}
			 	$controller->{$this->uri['method']}($this->uri['var']);
			} else {
				$controller->index();	
			}
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
			$this->tmpl->assign("base_dir_decorator", __DIR__ . '/templates/decorator/');
			$this->tmpl->assign("base_dir_templates", __DIR__ . '/templates/');
			$this->tmpl->assign('body_code', $template.'.tpl');
			$this->tmpl->assign('ctx', $this->ctx());
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
				$this->emailConfiguration = parse_ini_file(__DIR__.'/configs/mail.ini');
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
		   					  'Subject' => $subject);
		 	
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
		   		echo("<p>" . $mail->getMessage() . "</p>");
		  	} 
		  	else 
		  	{
		   		echo("<p>Message successfully sent!</p>");
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
		function loadMessages($code)
		{
			if($this->messages === null){
				$this->messages = parse_ini_file(__DIR__.'/configs/messages.ini');
			}
			
			return $this->messages[$code];
		}
		
		/**
		 * 
		 * Get the logged in user
		 */
		function getLoggedUser()
		{
			session_start();
			
			if (!isset($_SESSION['USER_SESSION'])){
				return null;
			}
			
			return $_SESSION['USER_SESSION'];
		}
		
		/**
		 * 
		 * Set session value
		 * @param $name
		 * @param $value
		 */
		function setSessionValue($name, $value){
			session_start();
			
			$_SESSION[$name] = $value;
		}
		
		/**
		 * 
		 * Is logged in user an administrator?
		 */
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
			$ini_array = parse_ini_file(__DIR__."/configs/db.ini");
			$this->url = $ini_array['driver']."://".$ini_array['username'].":".$ini_array['password']."@".$ini_array['host']."/".$ini_array['database'];
		}
		
		/**
		 * 
		 * Get MDB2 instance
		 */
		function connect() 
		{
		    $conn = MDB2::factory($this->url);
		    if(PEAR::isError($conn)) {
		        die("Error while connecting : " . $con->getMessage());
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