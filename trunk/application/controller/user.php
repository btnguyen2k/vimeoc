<?php 

	/**
	 * 
	 * User controller
	 * @author Tri
	 *
	 */
	class User extends Application
	{
	/**
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{				
			$this->tmpl = &$tmpl;		
		}
		
		/**
		 * 
		 * Default action
		 */
		function index()
		{
			$loggedUser = $this->getLoggedUser();
			if($loggedUser == null){
				$this->redirect('/vimeoc/auth/login/');
			}
			
			$this->loadTemplate('view_user_home');
		}
	}
?>