<?php
 /** The invalid controller
	 *
	 */
	class invalid extends Application 
	{
		/**
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{			
			$this->loadModel('model_invalid');	
			$this->tmpl = &$tmpl;		
		}
	
		/**
		 * 
		 * Default action
		 */
		function index()
		{
			$articles = $this->model_invalid->select();
			//$data['articles'] = $articles;
			$this->tmpl->assign("reset", "Invalid password reset link!");
			$this->tmpl->assign("try", "[Try again]");
			$this->loadView('view_invalid',$data);
		}
	}
?>