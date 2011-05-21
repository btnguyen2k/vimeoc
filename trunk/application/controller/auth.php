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
			unset($_SESSION['USER_SESSION']); 			
		}
		
		/** 
		 * 
		 * function check password and email validate. Then submit it.
		 */
		function login()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$this->tmpl->assign("loginForm", $this->loadMessages('auth.login.title'));
				$this->tmpl->assign("email",$this->loadMessages('auth.login.username'));
				$this->tmpl->assign("password", $this->loadMessages('auth.login.password'));
				$this->tmpl->assign("submit", $this->loadMessages('auth.login.submit'));
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
					$this->setSessionValue("USER_SESSION", $username);
					$this->redirect($this->ctx().'/user');
				}				
				else 
				{	
					$this->tmpl->assign("loginForm", $this->loadMessages('auth.login.title'));
					$this->tmpl->assign("email",$this->loadMessages('auth.login.username'));
					$this->tmpl->assign("password", $this->loadMessages('auth.login.password'));
					$this->tmpl->assign("submit", $this->loadMessages('auth.login.submit'));
					
					$this->tmpl->assign("errorMessage", $this->loadMessages('auth.login.error'));
					$this->tmpl->assign("username", $username);
					$this->loadTemplate('view_login');
				}				
			}
		}
		/**
		 * Connect to database , sign up account and add to database.
		 */
		function signup()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$this->tmpl->assign("fullname",$this->loadMessages('auth.signup.fullname'));
				$this->tmpl->assign("title", $this->loadMessages('auth.signup.title'));
				$this->tmpl->assign("password", $this->loadMessages('auth.signup.password'));
				$this->tmpl->assign("email", $this->loadMessages('auth.signup.email'));
				$this->tmpl->assign("rpassword", $this->loadMessages('auth.signup.rpassword'));
				$this->tmpl->assign("understand", $this->loadMessages('auth.signup.understand'));
				$this->tmpl->assign("term", $this->loadMessages('auth.signup.term'));
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
					$this->tmpl->assign("fullname",$this->loadMessages('auth.signup.fullname'));
					$this->tmpl->assign("title", $this->loadMessages('auth.signup.title'));
					$this->tmpl->assign("password", $this->loadMessages('auth.signup.password'));
					$this->tmpl->assign("email", $this->loadMessages('auth.signup.email'));
					$this->tmpl->assign("rpassword", $this->loadMessages('auth.signup.rpassword'));
					$this->tmpl->assign("understand", $this->loadMessages('auth.signup.understand'));
					$this->tmpl->assign("term", $this->loadMessages('auth.signup.term'));
					
					$this->tmpl->assign("errorMessage", $this->loadMessages('auth.signup.errors'));
					$this->loadTemplate('view_signup');
				}
				else 
				{
					$params = array($fullName, $username, $this->encodePassword($password), $username);
					$result = $this->model_user->addNewUser($params);					
					$this->redirect($this->ctx().'/auth/login');
				}
			}
		}
		/**
		 * This page lets the user choose another password
		 */
		function resetpassword()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$this->tmpl->assign("password",$this->loadMessages('auth.resetpassword.password'));
				$this->tmpl->assign("title", $this->loadMessages('auth.resetpassword.title'));
				$this->loadTemplate('view_resetpassword');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
					if(true)
					{
						$this->redirect('/vimeoc/user');
					}
					else 
					{
						$this->tmpl->assign("password",$this->loadMessages('auth.resetpassword.password'));
						$this->tmpl->assign("title", $this->loadMessages('auth.resetpassword.title'));
						$this->loadTemplate('view_resetpassword');
					}
			}
		}	
		/**
		 * 
		 * Load a Submitsucceed page to notice "Submit successfully"
		 * 
		 */
		function submitsucceed()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$this->tmpl->assign("sent",$this->loadMessages('auth.submitsucceed.sent'));
				$this->loadTemplate('view_submitsucceed');
			}
			elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				if(true)
				{
					$this->redirect('/vimeoc/auth/login');
				}
				else 
				{
					$this->tmpl->assign("sent",$this->loadMessages('auth.submitsucceed.sent'));
					$this->loadTemplate('view_submitsucceed');
				}
			}
		}
		/**
		 * Load thankyou page to notice that your account is created successfully."
		 * 
		 */
		function thankyou()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$this->tmpl->assign("success",$this->loadMessages('auth.thankyou.success'));
				$this->tmpl->assign("login",$this->loadMessages('auth.thankyou.login'));
				$this->loadTemplate('view_thankyou');
			}
			elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				if(true)
				{
					$this->redirect('/vimeoc/user');
				}
				else 
				{
					$this->tmpl->assign("success",$this->loadMessages('auth.thankyou.success'));
					$this->tmpl->assign("login",$this->loadMessages('auth.thankyou.login'));
					$this->loadTemplate('view_thankyou');
				}

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
				$this->tmpl->assign("reset",$this->loadMessages('auth.valid.reset'));
				$this->tmpl->assign("login",$this->loadMessages('auth.valid.login'));
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
					$this->tmpl->assign("success",$this->loadMessages('auth.valid.reset'));
					$this->tmpl->assign("login",$this->loadMessages('auth.valid.login'));
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
				$this->tmpl->assign("reset",$this->loadMessages('auth.invalid.reset'));
				$this->tmpl->assign("try",$this->loadMessages('auth.invalid.try'));
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
					$this->tmpl->assign("reset",$this->loadMessages('auth.invalid.reset'));
					$this->tmpl->assign("try",$this->loadMessages('auth.invalid.try'));
					$this->loadTemplate('view_invalid');
				}
			}
		}			
	}	
?>