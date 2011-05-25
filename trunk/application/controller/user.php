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
			$userId = $this->getLoggedUser();
			if($userId == 0){
				$this->redirect($this->ctx().'/auth/login/');
			}
			
			$this->loadModel('model_album');
			$model_album = $this->model_album;
			$this->tmpl->assign('album_count', $model_album->countAlbumByUserId($userId));
			
			$model_video = $this->loadModel('model_video');
			$model_video = $this->model_video;
			$this->tmpl->assign('video_count', $model_video->countVideoByUserId($userId));
			
			$videos = $model_video->selectVideoByUserId($userId, 2, 0, 'creation_date', 'DESC');
			$this->tmpl->assign('recent_videos', $videos);
			
			$this->userHomeMessagesSource();
			$this->loadTemplate('view_user_home');
		}
		
		/**
		 * 
		 * Load messages source for all user features
		 */
		function defaultUserMessagesSource()
		{
			$userId = $this->getLoggedUser();
			if($userId > 0)
			{
				$this->loadModel('model_user');
				$user = $this->model_user->getUserByUserId($userId);
				$this->tmpl->assign('userAvatar', $user['avatar']);
			}
			
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
		 * Load messages source for profile shortcut page
		 */
		function profileShortcutMessagesSource()
		{
			$this->defaultUserMessagesSource();
			
			$this->tmpl->assign("title", $this->loadMessages('user.shortcut.title'));
			$this->tmpl->assign("profileShortcut", $this->loadMessages('user.shortcut.profileShortcut'));
			$this->tmpl->assign("domain", BASE_PATH . CONTEXT);
		}
		
		/**
		 * 
		 * Profile shortcut action
		 */
		function profileShortcut()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			
			$this->loadModel('model_user');
			
			if($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$user = $this->model_user->getUserByUserId($userId);
				$this->tmpl->assign('alias', $user['profile_alias']);
				$this->loadTemplate('view_user_shortcut');
			}
			else if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$user = $this->model_user->getUserByUserId($userId);
				
				$alias = $_POST['alias'];
				// check alias format
				
				if($this->model_user->existsAlias(array($alias, $userId)))
				{
					$this->tmpl->assign('errorMessage', $this->loadErrorMessage('error.user.shortcut.duplicated', array($alias)));
					$this->tmpl->assign('alias', $user['profile_alias']);
					$this->loadTemplate('view_user_shortcut');
				}
				else 
				{
					$this->model_user->updateUserAlias(array($alias, $userId));
					$this->tmpl->assign('successMessage', $this->loadMessages('user.information.update.success', array("profile shortcut's URL")));
					$this->tmpl->assign('alias', $alias);
					$this->loadTemplate('view_user_shortcut');
				}
			}
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
					
					$user = $this->model_user->getUserByUserId(array($userId));
					
					if($type != 'image/jpeg' && $type != 'image/png' && $type != 'image/gif')
					{
						$this->tmpl->assign('errorMessage', $this->loadErrorMessage('error.user.portrait.notsupport'));
						$this->tmpl->assign('avatar', $user['avatar']);	
						$this->loadTemplate('view_user_portrait');
						return;
					}
					
					if($size > 5)
					{
						$this->tmpl->assign('errorMessage', 'Maximum file size is 5MB.');
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
						$this->tmpl->assign('successMessage', $this->loadMessages('user.information.update.success', array("portrait")));
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
			$this->tmpl->assign("fullNameTitle", $this->loadMessages('user.personalInfo.fullName'));
			$this->tmpl->assign("emailTitle", $this->loadMessages('user.personalInfo.email'));
			$this->tmpl->assign("yourWebsiteTitle", $this->loadMessages('user.personalInfo.website'));
			
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
					$this->tmpl->assign('successMessage', $this->loadMessages('user.information.update.success', array("personal info")));
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
						$this->tmpl->assign('successMessage', $this->loadMessages('user.information.update.success', array("password")));
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
		
		/**
		 * 
		 * Default messages source for user/home page
		 */
		function userHomeMessagesSource()		
		{
			$this->defaultUserMessagesSource();
		}
		
		/**
		 * 
		 * Default messages source for user/home page
		 */
		function userVideoMessagesSource()		
		{
			$this->defaultUserMessagesSource();
		}
		
		/**
		 * 
		 * Display user video page
		 */
		function video(){
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			
			$videos = array();
			$pagination = '';
			$limit = 2;
			$page = $_GET['page'] ? $_GET['page'] : 1;
			if(!is_numeric($page)){
				$this->redirect($this->ctx().'/user/video/');
			}else{
				$page = intval($page);
			}
			$this->loadModel('model_video');
			$model_video = $this->model_video;
			$video_count = $model_video->countVideoByUserId($userId);
			if($video_count > 0){
				if($limit && ($page > ceil($video_count / $limit))){
					$this->redirect($this->ctx().'/user/video/');
				}
				$videos = $model_video->selectVideoByUserId($userId, $limit, ($page - 1) * $limit);
				//var_dump($videos);
				//paging
				//$video_count = 30;
				$adjacents = 2;
				$targetpage = $_SERVER['REDIRECT_URL'];
				if(!($targetpage[strlen($targetpage) - 1] == '/')){
					$targetpage .= '/';
				}
				if ($page == 0){
					$page = 1;					//if no page var is given, default to 1.
				}
				$prev = $page - 1;							//previous page is page - 1
				$next = $page + 1;							//next page is page + 1
				$lastpage = ceil($video_count / $limit);		//lastpage is = total pages / items per page, rounded up.
				$lpm1 = $lastpage - 1;						//last page minus 1
				
				/* 
					Now we apply our rules and draw the pagination object. 
					We're actually saving the code to a variable in case we want to draw it more than once.
				*/
				$pagination = "";
				if($lastpage > 1)
				{
					$pagination .= "<div class=\"pagination\">";
					//previous button
					if ($page > 1) 
						$pagination.= "<a href=\"$targetpage?page=$prev\">« Previous</a>";
					else
						$pagination.= "<span class=\"disabled\">« Previous</span>";	
					
					//pages	
					if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
					{	
						for ($counter = 1; $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
						}
					}
					elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
					{
						//close to beginning; only hide later pages
						if($page < 1 + ($adjacents * 2))		
						{
							for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
							{
								if ($counter == $page)
									$pagination.= "<span class=\"current\">$counter</span>";
								else
									$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
							}
							$pagination.= "...";
							$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
							$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
						}
						//in middle; hide some front and some back
						elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
						{
							$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
							$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
							$pagination.= "...";
							for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
							{
								if ($counter == $page)
									$pagination.= "<span class=\"current\">$counter</span>";
								else
									$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
							}
							$pagination.= "...";
							$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
							$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
						}
						//close to end; only hide early pages
						else
						{
							$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
							$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
							$pagination.= "...";
							for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
							{
								if ($counter == $page)
									$pagination.= "<span class=\"current\">$counter</span>";
								else
									$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
							}
						}
					}
					
					//next button
					if ($page < $counter - 1){
						$pagination.= "<a href=\"$targetpage?page=$next\">Next »</a>";
					}else{
						$pagination.= "<span class=\"disabled\">Next »</span>";
					}
					$pagination.= "</div>\n";		
				}
			}else{
				$this->tmpl->assign('message', 'You have no video');
			}
			
			$this->tmpl->assign('videos', $videos);
			$this->tmpl->assign('pagination', $pagination);
			
			$this->userVideoMessagesSource();
			$this->loadTemplate('view_user_video');
		}
	}
?>