<?php 
	define("ADMIN_TEMPLATE_DIR","admin/");
	
	/**
	 * 
	 * Administrator controller
	 * @author Tri
	 *
	 */
	class Admin extends Application {
		/**	
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{				
			$this->tmpl = &$tmpl;		
		}
		
		function userList()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/auth/login');
			}	
		}
		
		function disableAccount()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/auth/login');
			}	
		}
		
		function enableAccount()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/auth/login');
			}
		}
		
		function deleteAccount()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/auth/login');
			}
		}
		
		function createNewAccount()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/auth/login');
			}
		}
		
		function editAccount()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/auth/login');
			}
		}
		
		function disableLoginForm()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/auth/login');
			}
		}
		
		function enableLoginForm()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/auth/login');
			}
		}
		
		function disableRegistrationForm()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/auth/login');
			}
		}
		
		function enableRegistrationForm()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/auth/login');
			}
		}
	}
?>

