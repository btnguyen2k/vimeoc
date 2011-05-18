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
			if ($_SERVER['REQUEST_METHOD'] == 'GET'){
				$this->tmpl->assign("loginForm", $this->loadMessages('auth.login.title'));
				$this->tmpl->assign("email",$this->loadMessages('auth.login.username'));
				$this->tmpl->assign("password", $this->loadMessages('auth.login.password'));
				$this->tmpl->assign("submit", $this->loadMessages('auth.login.submit'));
				$this->loadTemplate('view_login');
			} 
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				// check username & password
				if(true)
				{
					$this->redirect('/vimeoc/user');
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
	}
?>