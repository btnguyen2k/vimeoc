<?php 
	/**
	 * 
	 * The homepage controller
	 * @author Tri
	 *
	 */
	class Home extends Application 
	{
		/**
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{			
			$this->loadModel('model_home');	
			$this->tmpl = &$tmpl;		
		}
	
		/**
		 * 
		 * Default action
		 */
		function index()
		{
			$this->tmpl->assign('title', $this->loadMessages('home.title'));
			$this->loadTemplate('view_home');
		}
	}
?>