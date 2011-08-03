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
			$this->assign("title",$this->loadMessages('home.title'));	
			$this->assign("signin",$this->loadMessages('home.signin'));	
			$this->assign("register",$this->loadMessages('home.register'));
			$this->assign("or",$this->loadMessages('home.or'));	
			$this->assign("now",$this->loadMessages('home.now'));
			$this->loadTemplate('view_home');
		}
	}
?>