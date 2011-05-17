<?php
 /** The valid controller
	 *
	 */
	class valid extends Application 
	{
		/**
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{			
			$this->loadModel('model_valid');	
			$this->tmpl = &$tmpl;		
		}
	
		/**
		 * 
		 * Default action
		 */
		function index()
		{
			$articles = $this->model_valid->select();
			//$data['articles'] = $articles;
			$this->tmpl->assign("reset", "Password has been reset!");
			$this->tmpl->assign("login", "[Login]");
			$this->loadView('view_valid',$data);
		}
	}
?>