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
			if($loggedUser == 0){
				$this->redirect($this->ctx().'/auth/login/');
			}
			$this->loadTemplate('view_user_home');
		}
		
		/**
		 * 
		 * Load messages source for all user features
		 */
		function defaultUserMessagesSource()
		{
			$this->tmpl->assign("menuUploadVideo", $this->loadMessages('user.menu.link.uploadVideo'));
			$this->tmpl->assign("menuVideos", $this->loadMessages('user.menu.link.videos'));
			$this->tmpl->assign("menuAlbums", $this->loadMessages('user.menu.link.albums'));
			$this->tmpl->assign("menuPersonalInfo", $this->loadMessages('user.menu.link.personalInfo'));
			$this->tmpl->assign("menuPortrait", $this->loadMessages('user.menu.link.portrait'));
			$this->tmpl->assign("menuPassword", $this->loadMessages('user.menu.link.password'));
			$this->tmpl->assign("menuShortcutURL", $this->loadMessages('user.menu.link.shortcutURL'));
			$this->tmpl->assign("menuLogout", $this->loadMessages('user.menu.link.logout'));
		}
		
		/**
		 * 
		 * Load messages source for portrait page
		 */
		function portraitMessagesSource()
		{
			$this->defaultUserMessagesSource();
			
			$this->tmpl->assign('title', $this->loadMessages('user.portrait.title'));
			$this->tmpl->assign('currentPortrait', $this->loadMessages('user.portrait.current'));
			$this->tmpl->assign('uploadNew', $this->loadMessages('user.portrait.upload'));					
		}
		
		/**
		 * 
		 * user portrait action
		 */
		function portrait()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			
			$this->loadModel('model_user');
			
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$user = $this->model_user->getUserByUserId(array($userId));
				$this->tmpl->assign('fileName', $user['avatar']);
				$this->loadTemplate('view_user_portrait');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				
			}
		}
		
		/**
		 * 
		 * Default messages source for personalInfo page
		 */
		function personalInfoMessagesSource()		
		{
			$this->defaultUserMessagesSource();
			
			$this->tmpl->assign("title", $this->loadMessages('user.personalInfo.title'));
			$this->tmpl->assign("fullName", $this->loadMessages('user.personalInfo.fullName'));
			$this->tmpl->assign("email", $this->loadMessages('user.personalInfo.email'));
			$this->tmpl->assign("yourWebsite", $this->loadMessages('user.personalInfo.website'));
			
			$this->tmpl->assign('emailInvalid', $this->loadErrorMessage('error.email.invalid'));
			$this->tmpl->assign('urlInvalid', $this->loadErrorMessage('error.url.invalid'));
			$this->tmpl->assign('requiredField', $this->loadErrorMessage('error.field.required'));
		}
		
		/**
		 * 
		 * Display personal information page
		 */
		function personalInfo()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			
			$this->loadModel('model_user');
			
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$user = $this->model_user->getUserByUserId(array($userId));
				$this->tmpl->assign('fullName', $user['full_name']);
				$this->tmpl->assign('email', $user['email']);
				$this->tmpl->assign('website', $user['website']);
				
				$this->loadTemplate('view_user_info');
			} 
			else if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$fullName = $_POST['fullName'];
				$email = $_POST['email'];
				$website = $_POST['website'];
				
				$params = array($fullName, $email, $website, $userId);
				$ret = $this->model_user->updateUserInformation($params);

				if($ret == 0)
				{
					$this->tmpl->assign('errorMessage', 'Error');
				}
				else 
				{
					$this->tmpl->assign('successMessage', 'Success');
				}
				
				$user = $this->model_user->getUserByUserId(array($userId));
				$this->tmpl->assign('fullName', $user['full_name']);
				$this->tmpl->assign('email', $user['email']);
				$this->tmpl->assign('website', $user['website']);
				$this->loadTemplate('view_user_info');
			}
		}
	}
?>