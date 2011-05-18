<?php
 /** The Submit succeed controller
	 *
	 */
	class submitsucceed extends Application 
	{
		/**
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{			
			$this->loadModel('model_submitsucceed');	
			$this->tmpl = &$tmpl;		
		}
	
		/**
		 * 
		 * Default action
		 */
		function index()
		{
			$articles = $this->model_submitsucceed->select();
			//$data['articles'] = $articles;
			$this->tmpl->assign("sent", "We sent you a link. Check your email, even your spam folder");
			$this->loadTemplate('view_submitsucceed',$data);
		}
	}
?>