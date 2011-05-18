<?php
 /** The Thank You controller
	 *
	 */
	class Thankyou extends Application 
	{
		/**
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{			
			$this->loadModel('model_thankyou');	
			$this->tmpl = &$tmpl;		
		}
	
		/**
		 * 
		 * Default action
		 */
		function index()
		{
			$articles = $this->model_thankyou->select();
			//$data['articles'] = $articles;
			$this->tmpl->assign("success", "Your account has been created successfully. Thank you for signing up.");
			$this->tmpl->assign("login", "Login");
			$this->loadTemplate('view_thankyou',$data);
		}
	}
?>