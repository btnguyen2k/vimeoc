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
			if (!isset($_SESSION['uid']) ) 
			{
				$this->sessionDefaults();
			} 
			else 
			{
				if($_SESSION['uid'] > 0)
				{
					$this->redirect($this->ctx().'/user');
					return;
				}
			}
			$this->tmpl->assign('title', $this->loadMessages('home.title'));
			$this->loadTemplate('view_home');
		}
	}
?>