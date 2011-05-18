<?php
 /** The SignUp controller
	 *
	 */
	class Signup extends Application 
	{
		/**
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{			
			$this->loadModel('model_signup');	
			$this->tmpl = &$tmpl;		
		}
	
		/**
		 * 
		 * Default action
		 */
		function index()
		{
			$articles = $this->model_signup->select();
			//$data['articles'] = $articles;
			$this->tmpl->assign("title", "Membership Signup");
			$this->tmpl->assign("email","Email");
			$this->tmpl->assign("password","Password");
			$this->tmpl->assign("fullname","Full Name");
			$this->tmpl->assign("rpassword","Retype Password");
			$this->loadTemplate('view_signup',$data);
		}
	}
?>