<?php 
	/**
	 * The forgotpasswordpages controller
	 */
	class ForgotPassword extends Application 
	{
		/**
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{			
			$this->loadModel('model_forgotpassword');	
			$this->tmpl = &$tmpl;		
		}
	
		/**
		 * 
		 * Default action
		 */
		function index()
		{
			$articles = $this->model_forgotpassword->select();
			//$data['articles'] = $articles;
			$this->tmpl->assign("title", "Forgot Password");
			$this->tmpl->assign("email", "Email:");
			$this->loadView('view_forgotpassword',$data);
		}
	}
?>