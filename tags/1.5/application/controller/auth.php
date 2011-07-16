<?php
	/** The Authentication controller
	 * @author Tri
	 *
	 */
	class Auth extends Application 
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
			$this->redirect($this->ctx()."/home");
		}
		
		/**
		 * 
		 * Logout
		 */
		function logout()
		{
			session_destroy();
			$this->sessionDefaults(); 			
	
			$this->redirect($this->ctx().'/home');	
		}
		
		/**
		 * 
		 * Load login form default messages
		 */
		
		function loginMessagesSource()
		{
			$this->assign("title", $this->loadMessages('auth.login.title'));
			$this->assign("loginForm", $this->loadMessages('auth.login.title'));
			$this->assign("email",$this->loadMessages('auth.login.username'));
			$this->assign("password", $this->loadMessages('auth.login.password'));
			$this->assign("submit", $this->loadMessages('auth.login.submit'));
			
			$this->assign('passwordInvalid', $this->loadErrorMessage('error.password.invalid'));
			$this->assign('emailInvalid', $this->loadErrorMessage('error.email.invalid'));
		}

		/** 
		 * 
		 * function check password and email validate. Then submit it.
		 */
		
		
		function login()
		{
			$this->loadModel('model_user');
			$value=$this->model_user->getValueConfigurationLogin();			
			$login=$value['value'];
			if($login==0)
			{
				$this->loadTemplate('view_site_maintain');
				return;
			}
			
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
			
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$this->loadTemplate('view_login');
			} 
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadModel('model_user');				
				$username = $_POST['email'];
				$password = $_POST['password'];
				$params = array($username, $this->encodePassword($password));		
				$valid = $this->model_user->checkUsernameAndPassword($params);			
				if($valid)
				{
					$user=$this->model_user->getEnabledUserByUsername(array($username));
					if($user != null)
					{
						$this->setSessionValue("uid", $user['id']);
						$this->setSessionValue("username", $user['username']);
						$this->setSessionValue("fullname", $user['full_name']);
						$this->setSessionValue("logged", true);
						$this->setSessionValue("cookie", 0);
						$this->setSessionValue("remember", false);
						$isAdmin= $this->model_user->isAdmin(array($user['id'],"ROLE_ADMIN"));
						if($isAdmin==1)
							$this->setSessionValue("admin", true);
						else
							$this->setSessionValue("admin", false);
						//video......................
						if($this->model_user->userSettingExist(array($user['id'],'VIDEO_LIST_MODE')))
						{
							$_video_search_obj->mode=$this->model_user->getUserSetting(array($user['id'],'VIDEO_LIST_MODE'));
						}
						
						if ($this->model_user->userSettingExist(array($user['id'],'VIDEO_LIST_SORT')))
						{
							$_video_search_obj->sort=$this->model_user->getUserSetting(array($user['id'],'VIDEO_LIST_SORT'));
						}
						
						if ($this->model_user->userSettingExist(array($user['id'],'VIDEO_LIST_PSIZE')))
						{
							$_video_search_obj->psize=$this->model_user->getUserSetting(array($user['id'],'VIDEO_LIST_PSIZE'));
						}
						
						if ($this->model_user->userSettingExist(array($user['id'],'VIDEO_LIST_TERM')))
						{
							$_video_search_obj->term = $this->model_user->getUserSetting(array($user['id'],'VIDEO_LIST_TERM'));
						}						
						$_SESSION['VIDEO_SEARCH'] = serialize($_video_search_obj);
						
						//album .....................
						if ($this->model_user->userSettingExist(array($user['id'],'ALBUM_LIST_SORT')))
						{
							$_album_search_obj->sort=$this->model_user->getUserSetting(array($user['id'],'ALBUM_LIST_SORT'));
						}
						
						if ($this->model_user->userSettingExist(array($user['id'],'ALBUM_LIST_PSIZE')))
						{
							$_album_search_obj->psize=$this->model_user->getUserSetting(array($user['id'],'ALBUM_LIST_PSIZE'));
						}
						
						if ($this->model_user->userSettingExist(array($user['id'],'ALBUM_LIST_TERM')))
						{
							$_album_search_obj->term = $this->model_user->getUserSetting(array($user['id'],'ALBUM_LIST_TERM'));
						}						
						$_SESSION['ALBUM_SEARCH'] = serialize($_album_search_obj);
						
						//channel.................
						if ($this->model_user->userSettingExist(array($user['id'],'CHANNEL_LIST_SORT')))
						{
							$_channel_search_obj->sort=$this->model_user->getUserSetting(array($user['id'],'CHANNEL_LIST_SORT'));
						}
						
						if ($this->model_user->userSettingExist(array($user['id'],'CHANNEL_LIST_PSIZE')))
						{
							$_channel_search_obj->psize=$this->model_user->getUserSetting(array($user['id'],'CHANNEL_LIST_PSIZE'));
						}
						
						if ($this->model_user->userSettingExist(array($user['id'],'CHANNEL_LIST_TERM')))
						{
							$_channel_search_obj->term = $this->model_user->getUserSetting(array($user['id'],'CHANNEL_LIST_TERM'));
						}						
						$_SESSION['CHANNEL_SEARCH'] = serialize($_channel_search_obj);					
						
						//user list.....................
						
						if ($this->model_user->userSettingExist(array($user['id'],'ADMIN_USER_LIST_SORT')))
						{
							$_admin_user_search_obj->sort=$this->model_user->getUserSetting(array($user['id'],'ADMIN_USER_LIST_SORT'));
						}
						
						if ($this->model_user->userSettingExist(array($user['id'],'ADMIN_USER_LIST_PSIZE')))
						{
							$_admin_user_search_obj->psize=$this->model_user->getUserSetting(array($user['id'],'ADMIN_USER_LIST_PSIZE'));
						}
						
						if ($this->model_user->userSettingExist(array($user['id'],'ADMIN_USER_LIST_TERM')))
						{
							$_admin_user_search_obj->term = $this->model_user->getUserSetting(array($user['id'],'ADMIN_USER_LIST_TERM'));
						}						
						$_SESSION['ADMIN_USER_SEARCH'] = serialize($_admin_user_search_obj);	
						
						//content list...............
						if ($this->model_user->userSettingExist(array($user['id'],'ADMIN_CONTENT_LIST_SORT')))
						{
							$_admin_content_search_obj->sort=$this->model_user->getUserSetting(array($user['id'],'ADMIN_CONTENT_LIST_SORT'));
						}
						
						if ($this->model_user->userSettingExist(array($user['id'],'ADMIN_CONTENT_LIST_PSIZE')))
						{
							$_admin_content_search_obj->psize=$this->model_user->getUserSetting(array($user['id'],'ADMIN_CONTENT_LIST_PSIZE'));
						}
						
						if ($this->model_user->userSettingExist(array($user['id'],'ADMIN_CONTENT_LIST_TERM')))
						{
							$_admin_content_search_obj->term = $this->model_user->getUserSetting(array($user['id'],'ADMIN_CONTENT_LIST_TERM'));
						}						
						$_SESSION['ADMIN_CONTENT_SEARCH'] = serialize($_admin_content_search_obj);
						
						$this->redirect($this->ctx().'/user');
					}
					else 
					{
						$this->assign("errorDisable", $this->loadMessages('admin.login.errorenable'));
						$this->loadTemplate('view_login');
					}
				}				
				else 
				{	
					$this->assign("errorMessage", $this->loadMessages('auth.login.error'));
					$this->assign("username", $username);
					$this->loadTemplate('view_login');
				}				
			}
		}
		
		/**
		 * Load default message of Signup form
		 * 
		 */
		
		function signupMessagesSource()
		{
			$this->assign("fullname",$this->loadMessages('auth.signup.fullname'));
			$this->assign("title", $this->loadMessages('auth.signup.title'));
			$this->assign("password", $this->loadMessages('auth.signup.password'));
			$this->assign("email", $this->loadMessages('auth.signup.email'));
			$this->assign("rpassword", $this->loadMessages('auth.signup.rpassword'));
			$this->assign("understand", $this->loadMessages('auth.signup.understand'));
			$this->assign("term", $this->loadMessages('auth.signup.term'));
			
			$this->assign('passwordInvalid', $this->loadErrorMessage('error.password.invalid'));
			$this->assign('mathpasswordInvalid', $this->loadErrorMessage('error.mathpassword.invalid'));
			$this->assign('termInvalid', $this->loadErrorMessage('error.term.invalid'));
			$this->assign('retypepasswordInvalid', $this->loadErrorMessage('error.retypepassword.invalid'));
			$this->assign('fullnameInvalid', $this->loadErrorMessage('error.fullname.invalid'));
			$this->assign('emailInvalid', $this->loadErrorMessage('error.email.invalid'));
			$this->assign('repasswordlength', $this->loadErrorMessage('error.retypepassword.length'));
			$this->assign('fullnamelength', $this->loadErrorMessage('error.fullname.length'));
			$this->assign('emaillength', $this->loadErrorMessage('error.email.length'));
			$this->assign('passwordless', $this->loadErrorMessage('error.password.lesslength'));
			$this->assign('repasswordless', $this->loadErrorMessage('error.rpassword.lesslength'));
		}
		
		/**
		 * Connect to database , sign up account and add to database.
		 * 
		 */
		
		function signup()
		{
			$this->loadModel('model_user');
			$value=$this->model_user->getValueConfigurationSignup();			
			$signup=$value['value'];
			if($signup==0)
			{
				$this->loadTemplate('view_site_maintain');
				return;
			}
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
			
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$this->loadTemplate('view_signup');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadModel('model_user');
				
				$fullName = $_POST['fullname'];
				$username = $_POST['email'];
				$password = $_POST['password'];
				
				if ($this->model_user->isExists(array($username)) == true)
				{
					$this->assign("username",$username);
					$this->assign("errorMessage", $this->loadMessages('auth.signup.errors'));
					$this->assign('fullname_',$fullName);
					$this->assign('username_',$username);
					$this->loadTemplate('view_signup');
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
					$user['domain']=BASE_PATH . CONTEXT;
					$this->sendingEmailWithSmarty('mail_welcome', 'user', $user, null, $user['email']);
					$this->assign("success",$this->loadMessages('auth.thankyou.success'));
					$this->assign("login",$this->loadMessages('auth.thankyou.login'));
					$this->loadTemplate('view_thankyou');
				}
			}
		}
		/**
		 * Load default messages of ForgotPassword Form
		 */
		
		function forgotPasswordMessagesSource() 
		{
			$this->assign("title",$this->loadMessages('auth.forgotpassword.title'));
			$this->assign("email",$this->loadMessages('auth.forgotpassword.email'));
			
			$this->assign('emailInvalid', $this->loadErrorMessage('error.email.invalid'));
		}
		
		/**
		 * This page lets the user find lost password
		 * 
		 */
		
		function forgotPassword()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				
				$this->loadTemplate('view_forgotpassword');
				
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadModel('model_user');	
				$username= $_POST['email'];
				if ($username=="")
				{
					$this->assign("errorNull", $this->loadMessages('auth.forgotpassword.errornull'));
				}
				
				if ($this->model_user->isExists(array($username)) == false)
				{
					
					$this->assign("error", $this->loadMessages('auth.forgotpassword.errorvalid'));
					$this->loadTemplate('view_forgotpassword');
				}
				else 
				{	
					$salt=$this->loadResources('salt');
					$code = $this->encodeUsername($email,$salt);
					$params = array($username);
					// sending forgotpassword mail
					$user = $this->model_user->getUsersByUsername($params);
					$user['code']=$code;
					$user['email']=$username;
					$user['domain']=BASE_PATH . CONTEXT;
					$this->sendingEmailWithSmarty('mail_forgotpassword', 'user', $user, null, $user['email']);
					$this->assign("sent",$this->loadMessages('auth.submitsucceed.sent'));
					$this->loadTemplate('view_sent_resetpassword_result');
				}		
			}
		}
		
		/**
		 * Load default messages of ResetPassword form
		 */
		
		function resetPasswordMessagesSource()
		{
			$this->assign("title",$this->loadMessages('auth.resetpassword.title'));
			$this->assign("password",$this->loadMessages('auth.resetpassword.password'));
			$this->assign('passwordInvalid', $this->loadErrorMessage('error.password.lesslength'));
		}
		
		/**
		 * This page lets the user choose another password
		 * 
		 */
		
		function resetPassword()
		{
			$this->loadModel('model_user');	
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$email=$_GET['email'];		
				$this->assign("email",$email);		
				$code=$_GET['secret'];
				$salt=$this->loadResources('salt');
				$ecode=$this->encodeUsername($email,$salt);
				if($code==$ecode)
				{
					$this->loadTemplate('view_resetpassword');
				}
				else 
				{
					$this->assign("reset",$this->loadMessages('auth.invalid.reset'));
					$this->assign("try",$this->loadMessages('auth.invalid.try'));
					$this->loadTemplate('view_invalid');
				}	
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$password=$_POST['password'];
				$emails=$_POST['email'];
				$params=array($this->encodePassword($password),$emails);
				$this->model_user->updatePassword($params);
				$this->assign("title",$this->loadMessages('auth.valid.title'));
				$this->assign("success",$this->loadMessages('auth.valid.reset'));
				$this->assign("login",$this->loadMessages('auth.valid.login'));
				$this->loadTemplate('view_valid');
			}			
		}	
		
		/**
		 * Load a valid page if a valid password reset link is clicked
		 * 
		 */
		
		function valid()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$this->assign("reset",$this->loadMessages('auth.valid.reset'));
				$this->assign("login",$this->loadMessages('auth.valid.login'));
				$this->loadTemplate('view_valid');
			}
			elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				if(true)
					{
						$this->redirect($this->ctx().'/user');
					}
					else 
					{
						$this->assign("success",$this->loadMessages('auth.valid.reset'));
						$this->assign("login",$this->loadMessages('auth.valid.login'));
						$this->loadTemplate('view_valid');
					}
			}
		}
		/**
		 * Load an invalid page if an invalid password reset link is clicked.
		 * 
		 */
		function invalid()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$this->assign("reset",$this->loadMessages('auth.invalid.reset'));
				$this->assign("try",$this->loadMessages('auth.invalid.try'));
				$this->loadTemplate('view_invalid');
			}
			elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				if(true)
				{
					$this->redirect($this->ctx().'/user');
				}
				else 
				{
					$this->assign("reset",$this->loadMessages('auth.invalid.reset'));
					$this->assign("try",$this->loadMessages('auth.invalid.try'));
					$this->loadTemplate('view_invalid');
				}
			}
		}
		
	}	
?>