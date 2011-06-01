<?php
	/** The Authentication controller
	 * @author Tri
	 *
	 */
	class Auth extends Application 
	{
		/**
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{				
			$this->tmpl = &$tmpl;		
		}
	
		/**
		 * 
		 * Default action
		 */
		function index()
		{
			$this->redirect("/vimeoc/home");
		}
		
		/**
		 * 
		 * Logout
		 */
		function logout()
		{
			$this->sessionDefaults(); 			
	
			$this->redirect($this->ctx().'/home');	
		}
		
		/**
		 * 
		 * Load login form default messages
		 */
		
		function loginMessagesSource()
		{
			$this->assign("title", $this->loadMessages('auth.login.title'));
			$this->assign("loginForm", $this->loadMessages('auth.login.title'));
			$this->assign("email",$this->loadMessages('auth.login.username'));
			$this->assign("password", $this->loadMessages('auth.login.password'));
			$this->assign("submit", $this->loadMessages('auth.login.submit'));
			
			$this->assign('passwordInvalid', $this->loadErrorMessage('error.password.invalid'));
			$this->assign('emailInvalid', $this->loadErrorMessage('error.email.invalid'));
		}

		/** 
		 * 
		 * function check password and email validate. Then submit it.
		 */
		
		
		function login()
		{
			if (!isset($_SESSION['uid']) ) 
			{
				$this->sessionDefaults();
			} 
			else 
			{
				if($_SESSION['uid'] > 0)
				{
					$this->redirect($this->ctx().'/user');
					return;
				}
			}
			
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$this->loadTemplate('view_login');
			} 
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadModel('model_user');
				
				$username = $_POST['email'];
				$password = $_POST['password'];
				$params = array($username, $this->encodePassword($password));
								
				$valid = $this->model_user->checkUsernameAndPassword($params);
				
				if($valid)
				{
					$user = $this->model_user->getUserByUsername(array($username));
					if($user != null)
					{
						$this->setSessionValue("uid", $user['id']);
						$this->setSessionValue("username", $user['username']);
						$this->setSessionValue("logged", true);
						$this->setSessionValue("cookie", 0);
						$this->setSessionValue("remember", false);
						$this->redirect($this->ctx().'/user');
					}
					else 
					{
						die ('Fail to login');
					}
				}				
				else 
				{	
					$this->assign("errorMessage", $this->loadMessages('auth.login.error'));
					$this->assign("username", $username);
					$this->loadTemplate('view_login');
				}				
			}
		}
		
		/**
		 * Load default message of Signup form
		 * 
		 */
		
		function signupMessagesSource()
		{
			$this->assign("fullname",$this->loadMessages('auth.signup.fullname'));
			$this->assign("title", $this->loadMessages('auth.signup.title'));
			$this->assign("password", $this->loadMessages('auth.signup.password'));
			$this->assign("email", $this->loadMessages('auth.signup.email'));
			$this->assign("rpassword", $this->loadMessages('auth.signup.rpassword'));
			$this->assign("understand", $this->loadMessages('auth.signup.understand'));
			$this->assign("term", $this->loadMessages('auth.signup.term'));
			
			$this->assign('passwordInvalid', $this->loadErrorMessage('error.password.invalid'));
			$this->assign('mathpasswordInvalid', $this->loadErrorMessage('error.mathpassword.invalid'));
			$this->assign('termInvalid', $this->loadErrorMessage('error.term.invalid'));
			$this->assign('retypepasswordInvalid', $this->loadErrorMessage('error.retypepassword.invalid'));
			$this->assign('fullnameInvalid', $this->loadErrorMessage('error.fullname.invalid'));
			$this->assign('emailInvalid', $this->loadErrorMessage('error.email.invalid'));
		}
		
		/**
		 * Connect to database , sign up account and add to database.
		 * 
		 */
		
		function signup()
		{
			if (!isset($_SESSION['uid']) ) 
			{
				$this->sessionDefaults();
			} 
			else 
			{
				if($_SESSION['uid'] > 0)
				{
					$this->redirect($this->ctx().'/user');
					return;
				}
			}
			
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$this->loadTemplate('view_signup');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadModel('model_user');
				
				$fullName = $_POST['fullname'];
				$username = $_POST['email'];
				$password = $_POST['password'];
				
				if ($this->model_user->isExists(array($username)) == true)
				{
					$this->assign("errorMessage", $this->loadMessages('auth.signup.errors'));
					$this->loadTemplate('view_signup');
				}
				else 
				{
					$password2=$_POST['password'];
					$params = array($fullName, $username, $this->encodePassword($password), $username);
					$userId = $this->model_user->addNewUser($params);					
					// sending welcome mail
					$params = array($userId);
					$user = $this->model_user->getUserByUserId($params);
					$user['password']=$password2;
					$this->sendingEmailWithSmarty('mail_welcome', 'user', $user, null, $user['email']);
					
					$this->assign("success",$this->loadMessages('auth.thankyou.success'));
					$this->assign("login",$this->loadMessages('auth.thankyou.login'));
					$this->loadTemplate('view_thankyou');
				}
			}
		}
		/**
		 * Load default messages of ForgotPassword Form
		 */
		
		function forgotPasswordMessagesSource() 
		{
			$this->assign("title",$this->loadMessages('auth.forgotpassword.title'));
			$this->assign("email",$this->loadMessages('auth.forgotpassword.email'));
			
			$this->assign('emailInvalid', $this->loadErrorMessage('error.email.invalid'));
		}
		
		/**
		 * This page lets the user find lost password
		 * 
		 */
		
		function forgotPassword()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				
				$this->loadTemplate('view_forgotpassword');
				
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadModel('model_user');	
				$username= $_POST['xemail'];
			
				if ($this->model_user->isExists(array($username)) == false)
				{
					$this->assign("error", $this->loadMessages('auth.forgotpassword.error'));
					$this->loadTemplate('view_forgotpassword');
				}
				else 
				{	
					$email=$_POST['xemail'];
					$salt=$this->loadResources('salt');
					$code = $this->encodeUsername($email,$salt);
					$params = array($username);
					// sending forgotpassword mail
					$user = $this->model_user->getUsersByUsername($params);
					$user['code']=$code;
					$user['email']=$email;
					$user['domain']=BASE_PATH . CONTEXT;
					$this->sendingEmailWithSmarty('mail_forgotpassword', 'user', $user, null, $user['email']);
					$this->assign("sent",$this->loadMessages('auth.submitsucceed.sent'));
					$this->loadTemplate('view_sent_resetpassword_result');
				}		
			}
		}
		
		/**
		 * Load default messages of ResetPassword form
		 */
		
		function resetPasswordMessagesSource()
		{
			$this->assign("title",$this->loadMessages('auth.resetpassword.title'));
			$this->assign("password",$this->loadMessages('auth.resetpassword.password'));
		}
		
		/**
		 * This page lets the user choose another password
		 * 
		 */
		
		function resetPassword()
		{
			$this->loadModel('model_user');	
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$email=$_GET['email'];		
				$this->assign("email",$email);		
				$code=$_GET['secret'];
				$salt=$this->loadResources('salt');
				$ecode=$this->encodeUsername($email,$salt);
				if($code==$ecode)
				{
					$this->loadTemplate('view_resetpassword');
				}
				else 
				{
					$this->assign("reset",$this->loadMessages('auth.invalid.reset'));
					$this->assign("try",$this->loadMessages('auth.invalid.try'));
					$this->loadTemplate('view_invalid');
				}	
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$password=$_POST['password'];
				$emails=$_POST['email'];
				$params=array($this->encodePassword($password),$emails);
				$this->model_user->updatePassword($params);
				$this->assign("title",$this->loadMessages('auth.valid.title'));
				$this->assign("success",$this->loadMessages('auth.valid.reset'));
				$this->assign("login",$this->loadMessages('auth.valid.login'));
				$this->loadTemplate('view_valid');
			}			
		}	
		
		/**
		 * Load a valid page if a valid password reset link is clicked
		 * 
		 */
		
		function valid()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$this->assign("reset",$this->loadMessages('auth.valid.reset'));
				$this->assign("login",$this->loadMessages('auth.valid.login'));
				$this->loadTemplate('view_valid');
			}
			elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				if(true)
					{
						$this->redirect('/vimeoc/user');
					}
					else 
					{
						$this->assign("success",$this->loadMessages('auth.valid.reset'));
						$this->assign("login",$this->loadMessages('auth.valid.login'));
						$this->loadTemplate('view_valid');
					}
			}
		}
		/**
		 * Load an invalid page if an invalid password reset link is clicked.
		 * 
		 */
		function invalid()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$this->assign("reset",$this->loadMessages('auth.invalid.reset'));
				$this->assign("try",$this->loadMessages('auth.invalid.try'));
				$this->loadTemplate('view_invalid');
			}
			elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				if(true)
				{
					$this->redirect('/vimeoc/user');
				}
				else 
				{
					$this->assign("reset",$this->loadMessages('auth.invalid.reset'));
					$this->assign("try",$this->loadMessages('auth.invalid.try'));
					$this->loadTemplate('view_invalid');
				}
			}
		}
		
	}	
?>