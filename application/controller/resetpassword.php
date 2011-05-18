<?php 
	/**
	 * The resetpassword controller
	 */
	class resetpassword extends Application 
	{
		/**
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{			
			$this->loadModel('model_resetpassword');	
			$this->tmpl = &$tmpl;		
		}
	
		/**
		 * 
		 * Default action
		 */
		function index()
		{
			$articles = $this->model_resetpassword->select();
			//$data['articles'] = $articles;
			$this->tmpl->assign("title", "Choose a new password");
			$this->tmpl->assign("password", "Password:");
			$this->loadTemplate('view_resetpassword',$data);
		}
	}
?>