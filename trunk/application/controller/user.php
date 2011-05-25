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
				$this->tmpl->assign('avatar', $user['avatar']);
				$this->loadTemplate('view_user_portrait');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				if($_FILES['portrait']['error'] > 0)
				{
					echo $_FILES['portrait']['error'];
				}
				else 
				{
					$type = $_FILES['portrait']['type'];
					$size = $_FILES['portrait']['size'] / (1024*1024);
					$tmpName = $_FILES['portrait']['tmp_name'];
					$fileName = $_FILES['portrait']['name'];
					
					if($type != 'image/jpeg' && $type != 'image/png' && $type != 'image/gif')
					{
						$this->tmpl->assign('errorMessage', 'We only support GIF, PNG and JPEG image.');
						$user = $this->model_user->getUserByUserId(array($userId));
						$this->tmpl->assign('avatar', $user['avatar']);	
						$this->loadTemplate('view_user_portrait');
						return;
					}
					
					if($size > 5)
					{
						$this->tmpl->assign('errorMessage', 'Maximum file size is 5MB.');
						$user = $this->model_user->getUserByUserId(array($userId));
						$this->tmpl->assign('avatar', $user['avatar']);	
						$this->loadTemplate('view_user_portrait');
						return;
					}
					
					$fileInfo = utils::getFileType($fileName);
					$name = utils::genRandomString(32) . '.' . $fileInfo[1];
					$target = BASE_DIR . $this->loadResources('image.upload.path') . $name;
					
					$rimg = new RESIZEIMAGE($tmpName);
				    $rimg->resize_limitwh(300, 300, $target);				    
				    $rimg->close(); 
				    
				    $ret = $this->model_user->updateUserAvatar(array($name, $userId));
				    
					if($ret == 0)
					{
						$this->tmpl->assign('errorMessage', 'Error');
					}
					else 
					{
						$this->tmpl->assign('successMessage', 'Success');
						$this->tmpl->assign('avatar', $name);
						$this->loadTemplate('view_user_portrait');
					}
				}
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
		
		/**
		 * Default messages source for password page
		 * 
		 */
		function passwordpagesMessagesSource()
		{
			$this->defaultUserMessagesSource();
			
			$this->tmpl->assign("title", $this->loadMessages('user.password.title'));
			$this->tmpl->assign("currentpassword", $this->loadMessages('user.password.currentpassword'));
			$this->tmpl->assign("newpassword", $this->loadMessages('user.password.newpassword'));
			$this->tmpl->assign("repassword", $this->loadMessages('user.password.retypepassword'));
			
		}
		
		/**
		 * Display password pages
		 * 
		 */
		
		function passwordpages()
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
				$this->loadTemplate('view_user_password');
			} 
			else if ($_SERVER['REQUEST_METHOD'] == 'POST') 
			{
				$currentpassword = $_POST['currentpassword'];
				$newpassword = $_POST['newpassword'];
				$params = array($this->encodePassword($newpassword),$userId);
				$valid = $this->model_user->checkPassword(array($this->encodePassword($currentpassword),$userId));
				if($valid)
				{
					
					$res=$this->model_user->updateUserPassword($params);
					echo "The password has been update";
					if($res == 0)
					{
						$this->tmpl->assign('errorMessage', 'Error');
					}
					else 
					{
						$this->tmpl->assign('successMessage', 'Success');
					}
				}
				else 
				{
					die('fail');
					$this->loadTemplate('view_user_password');
				}
			}
		}
		/**
		 * Default messages source for user profile
		 * 
		 */
		function userprofileMessagesSource()
		{
			$this->tmpl->assign("title", $this->loadMessages('user.profile.title'));
		}
		
		/**
		 * Display userprofile pages
		 * 
		 */
		function userprofile()
		{
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$id=$_GET['userId'];
				$params=array($id);
				$fullname=$this->model_user->getFullNamebyUserId($params);
				$this->tmpl->assign("fullname",$fullname['full_name']);
				$this->loadTemplate('view_user_profile');
				
			} 
			else if ($_SERVER['REQUEST_METHOD'] == 'POST') 
			{
				$this->loadTemplate('view_user_profile');
			}
		}
	}
?>