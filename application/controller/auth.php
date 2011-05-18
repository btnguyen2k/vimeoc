<?php
	/* The Authentication controller
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
				$flag=false;
				if($flag)
				{
					$this->redirect(BASE_PATH.'/vimeoc/auth/login');
				}
				else 
				{
					$this->tmpl->assign("title", $this->loadMessages('auth.login.title'));
					$this->tmpl->assign("email",$this->loadMessages('auth.login.username'));
					$this->tmpl->assign("password", $this->loadMessages('auth.login.password'));
					$this->tmpl->assign("submit", $this->loadMessages('auth.login.submit'));
					$this->tmpl->assign("error", $this->loadMessages('auth.login.error'));
					$this->loadTemplate('view_login');
				}
			}
		}
		
		
		
		
		
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
			elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
			if(true)
				{
					$this->redirect('/vimeoc/user');
				}
				else 
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

			}
		}
		
		
		
		
		
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

		
		
		
		
		
		function submitsucceed()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$this->tmpl->assign("sent",$this->loadMessages('auth.submitsucceed.sent'));
				$this->loadTemplate('view_submitsucceed');
				$this->redirect('/vimeoc/auth/login');
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