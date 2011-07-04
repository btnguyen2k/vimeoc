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
		
		function index(){
			$this->redirect($this->ctx().'/auth/login');
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
				return;
			}	
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$userId=$_GET['userId'];
				$this->model_user->updateDisableAccount(array($userId));
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_disableaccount');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_disableaccount');
			}
		}
		
		function enableAccount()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/auth/login');
			}
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$userId=$_GET['userId'];
				$this->model_user->updateEnableAccount(array($userId));
				echo $userId;
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_enableaccount');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_enableaccount');
			}		
		}
		
		function deleteAccount()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/auth/login');
			}
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$userId=$_GET['userId'];
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_deleteaccount');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_deleteaccount');
			}
		}
		
		function createNewAccountMessagesSource()
		{
			$this->assign("fullname",$this->loadMessages('admin.createnewaccount.fullname'));
			$this->assign("title", $this->loadMessages('admin.createnewaccount.title'));
			$this->assign("password", $this->loadMessages('admin.createnewaccount.password'));
			$this->assign("rpassword", $this->loadMessages('admin.createnewaccount.rpassword'));
			$this->assign("email", $this->loadMessages('admin.createnewaccount.email'));
		}
		
		function createNewAccount()
		{
			/*
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/auth/login');
			}*/
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_signup');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				
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
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
			
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				
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

