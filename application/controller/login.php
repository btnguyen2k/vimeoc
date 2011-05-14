<?php
 /** The Login controller
	 *
	 */
	class Login extends Application 
	{
		/**
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{			
			$this->loadModel('model_login');	
			$this->tmpl = &$tmpl;		
		}
	
		/**
		 * 
		 * Default action
		 */
		function index()
		{
			$articles = $this->model_login->select();
			//$data['articles'] = $articles;
			$this->tmpl->assign("title", "Login");
			$this->tmpl->assign("email","Email");
			$this->tmpl->assign("password","Password");
			$this->loadView('view_login',$data);
		}
	}
?>