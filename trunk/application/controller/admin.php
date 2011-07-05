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
//			if(!$this->isAdminLogged()){
//				$this->redirect($this->ctx().'/auth/login');
//				return;
//			}	
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
//			if(!$this->isAdminLogged()){
//				$this->redirect($this->ctx().'/auth/login');
//			}
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$userId=$_GET['userId'];
				$this->model_user->updateEnableAccount(array($userId));
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_enableaccount');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_enableaccount');
			}		
		}
		
		function deleteAccount()
		{
//			if(!$this->isAdminLogged()){
//				$this->redirect($this->ctx().'/auth/login');
//			}
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$userId=$_GET['userId'];
				$this->model_user->dropVideoByUserId(array($userId));
				$this->model_user->dropAlbumByUserId(array($userId));
				$this->model_user->dropChannelByUserId(array($userId));
				$this->model_user->dropRoleByUserId(array($userId));
				$this->model_user->dropUserByUserId(array($userId));
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
			$this->assign("understand", $this->loadMessages('auth.signup.understand'));
			$this->assign("term", $this->loadMessages('auth.signup.term'));
			$this->assign("role", $this->loadMessages('admin.createnewaccount.role'));
			
			$this->assign('passwordInvalid', $this->loadErrorMessage('error.password.invalid'));
			$this->assign('mathpasswordInvalid', $this->loadErrorMessage('error.mathpassword.invalid'));
			$this->assign('termInvalid', $this->loadErrorMessage('error.term.invalid'));
			$this->assign('retypepasswordInvalid', $this->loadErrorMessage('error.retypepassword.invalid'));
			$this->assign('fullnameInvalid', $this->loadErrorMessage('error.fullname.invalid'));
			$this->assign('emailInvalid', $this->loadErrorMessage('error.email.invalid'));
			$this->assign('passwordlength', $this->loadErrorMessage('error.password.length'));
			$this->assign('repasswordlength', $this->loadErrorMessage('error.retypepassword.length'));
			$this->assign('fullnamelength', $this->loadErrorMessage('error.fullname.length'));
			$this->assign('emaillength', $this->loadErrorMessage('error.email.length'));
			$this->assign('passwordless', $this->loadErrorMessage('error.password.lesslength'));
			$this->assign('repasswordless', $this->loadErrorMessage('error.rpassword.lesslength'));
		}
		
		function createNewAccount()
		{
//			if(!$this->isAdminLogged()){
//				$this->redirect($this->ctx().'/auth/login');
//			}
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_signup');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$fullName = $_POST['fullname'];
				$username = $_POST['email'];
				$password = $_POST['password'];
				$role = $_POST['role'];
				$this->loadModel('model_user');
				if ($this->model_user->isExists(array($username)) == true)
				{
					$this->assign("username",$username);
					$this->assign("errorMessage", $this->loadMessages('auth.signup.errors'));
					$this->assign('fullname_',$fullName);
					$this->assign('username_',$username);
					$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_signup');
				}
				else 
				{
					$password2=$_POST['password'];
					$params = array($fullName, $username, $this->encodePassword($password), $username);
					$userId = $this->model_user->addNewUser($params);
					$userAlias = 'user'.$userId;
					$this->model_user->updateUserAlias(array($userAlias, $userId));					
					$params = array($userId);
					$user = $this->model_user->getUserByUserId($params);
					$user['password']=$password2;
					if($role=='Admin')
					{
						$this->model_user->updateUserRole(array($userId));
					}
					$this->sendingEmailWithSmarty('mail_welcome', 'user', $user, null, $user['email']);
					$this->assign("success",$this->loadMessages('auth.thankyou.success'));
					$this->assign("login",$this->loadMessages('auth.thankyou.login'));
					$this->loadTemplate('view_thankyou');
				}
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

