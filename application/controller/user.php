<?php 
	define("USER_TEMPLATE_DIR", "user/");
	include (BASE_DIR . '/application/uploader.php');
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
		
		function onLoad(){
			$model_content = $this->getModel('model_content');
			$contents = $model_content->loadPublishedContentByCategory(array(CONTENT_USER_TYPE));				
			$this->assign("contentLinkList", $contents);				
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
			
			$this->assign('title', $this->loadMessages('home.title'));
			
			$this->loadModel('model_album');
			$model_album = $this->model_album;
			$this->assign('album_count', $model_album->countAlbumByUserId($userId));
			
			$model_video = $this->loadModel('model_video');
			$model_video = $this->model_video;
			$this->assign('video_count', $model_video->countVideoByUserId($userId));
			
			$videos = $model_video->selectVideoByUserId($userId, 5, 0, '', 'creation_date', 'DESC');
			
			foreach($videos as &$video){
				$video['thumbnails_path'] = empty($video['thumbnails_path']) ? $this->ctx() . '/images/icon-video.gif' : ($this->ctx() . $this->loadResources('image.upload.path') . $video['thumbnails_path']);
			}
			$this->assign('recent_videos', $videos);
			
			$this->userHomeMessagesSource();
			$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_home');
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
				$this->assign('userAvatar', $user['avatar']);
				$this->assign('user_fullname', $user['full_name']);
				$this->assign('show_user_avatar', 1);
			}
			
			$this->assign("menuUploadVideo", $this->loadMessages('user.menu.link.uploadVideo'));
			$this->assign("menuVideos", $this->loadMessages('user.menu.link.videos'));
			$this->assign("menuAlbums", $this->loadMessages('user.menu.link.albums'));
			$this->assign("menuChannels", $this->loadMessages('user.menu.link.channels'));
			$this->assign("menuPersonalInfo", $this->loadMessages('user.menu.link.personalInfo'));
			$this->assign("menuPortrait", $this->loadMessages('user.menu.link.portrait'));
			$this->assign("menuPassword", $this->loadMessages('user.menu.link.password'));
			$this->assign("menuShortcutURL", $this->loadMessages('user.menu.link.shortcutURL'));
			$this->assign("menuLogout", $this->loadMessages('user.menu.link.logout'));
			
			$this->assign("requiredFields", $this->loadErrorMessage('error.field.required'));
		}
		
		
		/**
		 * 
		 * Load messages source for profile shortcut page
		 */
		function profileShortcutMessagesSource()
		{
			$this->defaultUserMessagesSource();
			
			$this->assign("title", $this->loadMessages('user.shortcut.title'));
			$this->assign("profileShortcut", $this->loadMessages('user.shortcut.profileShortcut'));
			$this->assign("hint", $this->loadMessages('user.shortcut.hint'));
			$this->assign("domain", BASE_PATH . CONTEXT);
			$this->assign("reservedUrl", $this->loadResources('shortcut.url.reserved.user'));
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
				$userAlias = $user['profile_alias'];
				$defaultAlias = 'user'.$user['id'];
				if($userAlias == null || $userAlias == ''){
					$userAlias = $defaultAlias;
				}
				$this->assign('defaultAlias', $defaultAlias);
				$this->assign('alias', $userAlias);
				$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_shortcut');
			}
			else if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$user = $this->model_user->getUserByUserId($userId);
				$alias = $_POST['alias'];
				// check alias format
				$regex = "/^[a-zA-Z0-9]{1,16}$/";
				$defaultRegex = '/^user[0-9]{1,12}$/';
				$defaultAlias = 'user'.$user['id'];
				$userAlias = $user['profile_alias'];
				
				if(preg_match($regex, $alias)){
					if(preg_match($defaultRegex, $alias) && ($alias != $defaultAlias)){
						if($userAlias == null || $userAlias == ''){
							$userAlias = $defaultAlias;
						}
						$this->assign('defaultAlias', $defaultAlias);
						$this->assign('errorMessage', $this->loadErrorMessage('error.user.shortcut.invalid', array($alias)));
						$this->assign('alias', $user['profile_alias']);
						$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_shortcut');
						return;	
					}
				}else{
					if($userAlias == null || $userAlias == ''){
						$userAlias = $defaultAlias;
					}
					$this->assign('defaultAlias', $defaultAlias);
					$this->assign('errorMessage', $this->loadErrorMessage('error.user.shortcut.invalid', array($alias)));
					$this->assign('alias', $user['profile_alias']);
					$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_shortcut');
					return;
				} 
				
				
				if($this->model_user->existsAlias(array($alias, $userId))) {
					if($userAlias == null || $userAlias == ''){
						$userAlias = $defaultAlias;
					}
					$this->assign('defaultAlias', $defaultAlias);
					$this->assign('errorMessage', $this->loadErrorMessage('error.user.shortcut.duplicated', array($alias)));
					$this->assign('alias', $userAlias);
					$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_shortcut');
				} else {
					$res=$this->model_user->updateUserAlias(array($alias, $userId));
					if($res!=0)
					{
						$this->assign('successMessage', $this->loadMessages('user.information.update.success', array("profile shortcut's URL")));
					}
					$this->assign('alias', $alias);
					$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_shortcut');
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
			
			$this->assign('title', $this->loadMessages('user.portrait.title'));
			$this->assign('currentPortrait', $this->loadMessages('user.portrait.current'));
			$this->assign('uploadNew', $this->loadMessages('user.portrait.upload'));	
			$this->assign('imageExtSupport', $this->loadResources('image.upload.ext.support'));		
			$this->assign('hint', $this->loadMessages('user.portrait.hint', array($this->loadResources('application.name'))));
			$this->assign('successMessage', $this->loadMessages('user.information.update.success', array("portrait")));
			$this->assign('maxSize', $this->loadResources('image.upload.maxsize')*1024*1024);
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
				$this->assign('avatar', $user['avatar']);
				$this->assign('sessionId', session_id());
				$this->assign('uid', $user['id']);
				$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_portrait');
			}
		}
		
		/**
		 * 
		 * Default messages source for personalInfo page
		 */
		function personalInfoMessagesSource()		
		{
			$this->defaultUserMessagesSource();
			
			$this->assign("title", $this->loadMessages('user.personalInfo.title'));
			$this->assign("fullNameTitle", $this->loadMessages('user.personalInfo.fullName'));
			$this->assign("emailTitle", $this->loadMessages('user.personalInfo.email'));
			$this->assign("yourWebsiteTitle", $this->loadMessages('user.personalInfo.website'));
			$this->assign("hint", $this->loadMessages('user.personalInfo.hint'));
			
			$this->assign('emailInvalid', $this->loadErrorMessage('error.email.invalid'));
			$this->assign('urlInvalid', $this->loadErrorMessage('error.url.invalid'));
			$this->assign('requiredField', $this->loadErrorMessage('error.field.required'));
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
				$this->assign('fullName', $user['full_name']);
				$this->assign('email', $user['email']);
				$this->assign('website', $user['website']);
				
				$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_info');
			} 
			else if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$fullName = $_POST['fullName'];
				$email = $_POST['email'];
				$website = $_POST['website'];
				
				$params = array($fullName, $email, $website, $userId);
				$ret = $this->model_user->updateUserInformation($params);
				if($ret!=0)
				{
					$this->assign('successMessage', $this->loadMessages('user.information.update.success', array("personal info")));
				}
				$user = $this->model_user->getUserByUserId(array($userId));
				$this->assign('fullName', $user['full_name']);
				$this->assign('email', $user['email']);
				$this->assign('website', $user['website']);
				$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_info');
			}
		}
		
		/**
		 * Default messages source for password page
		 * 
		 */
		function passwordpagesMessagesSource()
		{
			$this->defaultUserMessagesSource();
			
			$this->assign("title", $this->loadMessages('user.password.title'));
			$this->assign("currentpassword", $this->loadMessages('user.password.currentpassword'));
			$this->assign("newpassword", $this->loadMessages('user.password.newpassword'));
			$this->assign("repassword", $this->loadMessages('user.password.retypepassword'));
			$this->assign("hint", $this->loadMessages('user.password.hint'));
			
			$this->assign('cpassword', $this->loadErrorMessage('error.password.invalid'));
			$this->assign('mpassword', $this->loadErrorMessage('error.mathpassword.invalid'));
			$this->assign('lessnpassword', $this->loadErrorMessage('error.password.lesslength'));
			$this->assign('lessrpassword', $this->loadErrorMessage('error.rpassword.lesslength'));
			$this->assign('cpasswordinvalid', $this->loadErrorMessage('error.cpassword.invalid'));
			$this->assign('npasswordinvalid', $this->loadErrorMessage('error.npassword.invalid'));
			$this->assign('rpasswordinvalid', $this->loadErrorMessage('error.rpassword.invalid'));
			
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
				$this->assign('a',$userId);
				$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_password');
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
					
					if($res == 0)
					{
						$this->assign('FailMessage', $this->loadMessages('user.password.fail'));
						$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_password');
					}
					else 
					{
						$this->assign('successMessage', $this->loadMessages('user.password.success'));
						$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_password');
					}
				}
				else 
				{
					$this->assign("errorMessage", $this->loadMessages('user.password.error'));
					$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_password');
				}
			}
		}
		/**
		 * Default messages source for user profile
		 * 
		 */
		function userprofileMessagesSource()
		{
			$this->assign("title", $this->loadMessages('user.profile.title'));
		}
		
		/**
		 * Display userprofile pages
		 * 
		 */
		function userprofile($var=null)
		{
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$id=$_GET['userId'];
				$profileAlias=$_GET['profileAlias'];
				
				if(!empty($var)){
					$profileAlias = $var;
				}
				
				if(!empty($profileAlias)){
					if(stripos($profileAlias, 'user') == 0){
						$id = (int)str_replace('user', '', $profileAlias);						
					}
				}
				
				if($id > 0){
					$user = $this->model_user->getUserByUserId(array($id));
				}else if(!empty($profileAlias)){
					$user = $this->model_user->getUserByUserAlias(array($profileAlias));					
				}else{
					$this->loadTemplate('view_404');
					return;
				}
				
				if($user == null){
					$this->loadTemplate('view_404');
					return;
				}else{
					$this->assign("fullname",$user['full_name']);
					$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_profile');
				}
			} 
			else if ($_SERVER['REQUEST_METHOD'] == 'POST') 
			{
				$this->redirect($this->ctx().'/home');
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
			$this->assign('title', 'Video list');
		}
		
		/**
		 * 
		 * Display user video page
		 */
		function video(){
			$this->loadModel('model_user');
			$userId = $this->getLoggedUser();
			if($userId == 0){
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			
			$_search_obj = unserialize($_SESSION['VIDEO_SEARCH']);
			
			$_display_modes = array(1 => 'Thumbnail mode', 2 => 'Detail mode');
			
			$_sort_modes = array(
				1 => 'Newest video first',
				2 => 'Oldest video first',
				3 => 'Most played',
				4 => 'Most commented',
				5 => 'Most liked',
				6 => 'Alphabetical'
			);
			$_sort_columns = array(
				1 => 'creation_date',
				2 => 'creation_date',
				3 => 'play_count',
				4 => 'comment_count',
				5 => 'like_count',
				6 => 'video_title'
			);
			$_sort_orders = array(
				1 => 'DESC',
				2 => 'ASC',
				3 => 'DESC',
				4 => 'DESC',
				5 => 'DESC',
				6 => 'ASC'
			);
			$_page_sizes = array(				
				1 => 10,
				2 => 25,
				3 => 50,
				4 => 'All'
			);
			$_default_display_mode = 1;
			$_default_sort_mode = 1;
			$_default_page_size = 1;
			$_default_search_term = '';
			
			$videos = array();
			$pagination = '';
			$_reset = $_GET['reset'];// reset all value for display
			if($_reset){
				
			}else{
				if($_GET['mode']){
					$_display_mode = $_GET['mode'];
					if(!in_array($_display_mode, array_keys($_display_modes), false)){
						$_display_mode = $_default_display_mode;
					}
				}else{
					$_display_mode = $_search_obj->mode ? $_search_obj->mode : $_default_display_mode;
				}
				if($_GET['sort']){
					$_sort_mode = $_GET['sort'];
					if(!in_array($_sort_mode, array_keys($_sort_modes), false)){
						$_sort_mode = $_default_sort_mode;
					}
				}else{
					$_sort_mode = $_search_obj->sort ? $_search_obj->sort : $_default_sort_mode;
				}
				if($_GET['psize']){
					$_page_size = $_GET['psize'];
					if(!in_array($_page_size, array_keys($_page_sizes), false)){
						$_page_size = $_default_page_size;
					}
				}else{
					$_page_size = $_search_obj->psize ? $_search_obj->psize : $_default_page_size;
				}
				if(in_array('term', array_keys($_GET))){
					$_search_term = trim($_GET['term']);
				}else{
					$_search_term = $_search_obj->term ? $_search_obj->term : $_default_search_term;
				}
			}
			$page = $_GET['page'] ? $_GET['page'] : '1';			
			if(!ctype_digit($page)){
				$this->redirect($this->ctx().'/user/video/');
			}else{
				$page = intval($page);
			}
			
			$limit = is_int($_page_sizes[$_page_size]) ? $_page_sizes[$_page_size] : 0;
			$offset = ($page - 1) * $limit;
			$sort_column = $_sort_columns[$_sort_mode];
			$sort_order = $_sort_orders[$_sort_mode];
			
			if(!$this->model_user->userSettingExist(array($userId,'VIDEO_LIST_MODE')))
			{
				$this->model_user->addUserSetting(array($userId,'VIDEO_LIST_MODE',$_display_mode));
			}
			else 
			{
				$this->model_user->updateUserSetting(array($_display_mode,$userId,'VIDEO_LIST_MODE'));
			}
			
			if (!$this->model_user->userSettingExist(array($userId,'VIDEO_LIST_SORT')))
			{
				$this->model_user->addUserSetting(array($userId,'VIDEO_LIST_SORT',$_sort_mode));
			}
			else 
			{
				$this->model_user->updateUserSetting(array($_sort_mode,$userId,'VIDEO_LIST_SORT'));
			}
			
			if (!$this->model_user->userSettingExist(array($userId,'VIDEO_LIST_PSIZE')))
			{
				$this->model_user->addUserSetting(array($userId,'VIDEO_LIST_PSIZE',$_page_size));
			}
			else 
			{
				$this->model_user->updateUserSetting(array($_page_size,$userId,'VIDEO_LIST_PSIZE'));
			}
			
			if (!$this->model_user->userSettingExist(array($userId,'VIDEO_LIST_TERM')))
			{
				$this->model_user->addUserSetting(array($userId,'VIDEO_LIST_TERM',$_search_term));
			}
			else 
			{
				$this->model_user->updateUserSetting(array($_search_term,$userId,'VIDEO_LIST_TERM'));
			}
			
			$_search_obj->mode = $this->model_user->getUserSetting(array($userId,'VIDEO_LIST_MODE'));
			$_search_obj->sort = $this->model_user->getUserSetting(array($userId,'VIDEO_LIST_SORT'));
			$_search_obj->psize = $this->model_user->getUserSetting(array($userId,'VIDEO_LIST_PSIZE'));
			$_search_obj->term = $this->model_user->getUserSetting(array($userId,'VIDEO_LIST_TERM'));
			$_SESSION['VIDEO_SEARCH'] = serialize($_search_obj);
				
			
			$this->loadModel('model_video');
			$model_video = $this->model_video;
			$video_count = $model_video->countVideoByUserId($userId, $limit, $offset, $_search_term, $sort_column, $sort_order);
			if($video_count > 0){
				if($limit > 0){
					if($limit && ($page > ceil($video_count / $limit))){
						$this->redirect($this->ctx().'/user/video/');
					}
					$videos = $model_video->selectVideoByUserId($userId, $limit, $offset, $_search_term, $sort_column, $sort_order);

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
					$videos = $model_video->selectVideoByUserId($userId, $limit, $offset, $_search_term, $sort_column, $sort_order);
				}
			}else{
				$this->assign('message', 'No video');
			}
			
			$model_channel = $this->getModel('model_channel');
			
			if(is_array($videos) && (count($videos) > 0)){
				$this->loadModel('model_album');
				$model_album = $this->model_album;
				
				$this->loadModel('model_tag');
				$model_tag = $this->model_tag;
				
				foreach($videos as &$video){
					$video['thumbnails_path'] = empty($video['thumbnails_path']) ? $this->ctx() . '/images/icon-video.gif' : ($this->ctx() . $this->loadResources('image.upload.path') . $video['thumbnails_path']);
					$video['album'] = $model_album->selectAlbumByVideoId($video['id']);
					$video['tag'] = $model_tag->selectTagByVideoId($video['id']);
					$video['channel'] = $model_channel->getChannelByVideoId(array($video['id']));
					$video['creation_date'] = utils::getDiffTimeString($video['creation_date']);
				}
			}
			
			$albums= $this->model_video->getAlbumByUserId(array($userId));
			$channles = $model_channel->getChannelByUserId(array($userId));
			
			$this->assign('channels', $channles);
			$this->assign('albums', $albums);
			$this->assign('videos', $videos);
			$this->assign('pagination', $pagination);
			$this->assign('display_modes', $_display_modes);
			$this->assign('sort_modes', $_sort_modes);
			$this->assign('page_sizes', $_page_sizes);
			
			$this->assign('display_mode', $_display_mode);
			$this->assign('sort_mode', $_sort_mode);
			$this->assign('page_size', $_page_size);
			$this->assign('search_term', $_search_term);
			$this->assign('page', $page);
			
			$this->userVideoMessagesSource();
			$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_video');
		}
		
		/**
		 * Default message sourse for upload video pages
		 */
		function addvideouploadMessagesSource()
		{
			$this->defaultUserMessagesSource();	
			$this->assign("title", $this->loadMessages('user.uploadvideo.title'));
			$this->assign("choose", $this->loadMessages('user.uploadvideo.chooseavideotoupload'));
			$this->assign('videoExtSupport', $this->loadResources('video.upload.ext.support'));
			$this->assign("hint", $this->loadMessages('user.uploadvideo.hint'));
			$this->assign('successMessage', $this->loadMessages('user.information.update.success', array("video")));
			$this->assign('maxSize', $this->loadResources('video.upload.maxsize')*1024*1024);
			
			$this->assign("name", $this->loadMessages('user.videosetting.name'));
			$this->assign('description', $this->loadMessages('user.videosetting.description'));
			$this->assign('tag', $this->loadMessages('user.videosetting.tags'));
			
			$this->assign('titleiInvalid', $this->loadErrorMessage('error.video.title'));
			$this->assign('descriptionInvalid', $this->loadErrorMessage('error.video.description'));
			$this->assign('tagInvalid', $this->loadErrorMessage('error.video.tag'));
			
		}
		
		/**
		 * action upload video 
		 */
		function addvideoupload()
		{
			$this->loadModel('model_video');
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{				
				$model_user = $this->getModel('model_user');
				$user = $model_user->getUserByUserId(array($userId));
				$this->assign('sessionId', session_id());
				$this->assign('success',$this->loadMessages('user.upload.success'));
				$this->loadTemplate(USER_TEMPLATE_DIR."view_user_uploadvideo");
			}else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$videoTitle=$_POST['title'];
				$description=$_POST['description'];
				$tag=$_POST['tag'];
				$slipTag=split(',', $tag);
				$videoid=$_POST['videoid'];
				$tagid=$_POST['tagid'];
				$tcid=$_POST['tcid'];
				$this->model_video->deleteAllTagComponentsByVideoId(array($videoid));				
				for($j=0;$j<sizeof($slipTag);$j++)
				{				
					if($slipTag[$j]!="")
					{
						$checkTag=$this->model_video->isTagExist(array($slipTag[$j]));
						if($checkTag==0)
						{
							$this->model_video->addTagName(array($slipTag[$j]));			
							$tagNewId=$this->model_video->getTagIdByName(array($slipTag[$j]));
							$this->model_video->addTagIdAndComponentId(array($tagNewId[0]["id"],"1",$videoid));
						}
						else 
						{
							$tagNewId=$this->model_video->getTagIdByName(array($slipTag[$j]));
							$res=$this->model_video->checkIdAndComponentId(array($tagNewId[0]["id"],$videoid));
							if($res==0)
							{
								$this->assign('successMessage', $this->loadMessages('user.videosetting.updatesuccess'));
								$this->model_video->addTagIdAndComponentId(array($tagNewId[0]["id"],'1',$videoid));
							}
							else 
							{
								$this->assign('successMessage', $this->loadMessages('user.videosetting.updatesuccess'));
							}
						}
					}	
				}	
				$updatetitle= $this->model_video->updateTitlebyId(array($videoTitle,$videoid));
				$updatedescrition= $this->model_video->updateDescriptionbyId(array($description,$videoid));				
				$tags=$this->model_video->getTagfromTagandTagcomponent(array($tcid));
				$video= $this->model_video->getVideofromVideoId(array($videoid));
				$strTags="";
				for($i=0;$i<sizeof($tags);$i++)
				{
					$strTags .= $tags[$i]['name'] . ',' ; 
				}
				$strTags = substr($strTags, 0, -1); 
				$this->redirect($this->ctx() . '/user/video/');
			}
		}
		
		function assignVideoThumbnails($video){
			if($video){
				$videoThumbnail = empty($video['thumbnails_path']) ? '' : $this->loadResources('image.upload.path').$video['thumbnails_path'];
				$this->assign("videoThumbnail", $videoThumbnail);
			}
		}
		
		/**
		 * 
		 * Default messages source for user/home page
		 */
		function albumMessagesSource()		
		{
			$this->defaultUserMessagesSource();
			$this->assign('title', $this->loadMessages('user.album.title'));
			$this->assign('hint', $this->loadMessages('user.album.hint'));
		}
		
		/**
		 * 
		 * Display user video page
		 */
		function album(){
			$userId = $this->getLoggedUser();
			if($userId == 0){
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			
			$_search_obj = unserialize($_SESSION['ALBUM_SEARCH']);
			
			$_sort_modes = array(
				1 => 'Newest',
				2 => 'Oldest',
				3 => 'Alphabetical'
			);
			$_sort_columns = array(
				1 => 'creation_date',
				2 => 'creation_date',
				3 => 'album_name'
			);
			$_sort_orders = array(
				1 => 'DESC',
				2 => 'ASC',
				3 => 'ASC'
			);
			$_page_sizes = array(		
				1 => 10,
				2 => 25,
				3 => 50,
				4 => 'All'
			);
			$_default_sort_mode = 1;
			$_default_page_size = 2;
			$_default_search_term = '';
			
			$albums = array();
			$pagination = '';
			$_reset = $_GET['reset'];// reset all value for display
			if($_reset){
				
			}else{
				if($_GET['sort']){
					$_sort_mode = $_GET['sort'];
					if(!in_array($_sort_mode, array_keys($_sort_modes), false)){
						$_sort_mode = $_default_sort_mode;
					}
				}else{
					$_sort_mode = $_search_obj->sort ? $_search_obj->sort : $_default_sort_mode;
				}
				if($_GET['psize']){
					$_page_size = $_GET['psize'];
					if(!in_array($_page_size, array_keys($_page_sizes), false)){
						$_page_size = $_default_page_size;
					}
				}else{
					$_page_size = $_search_obj->psize ? $_search_obj->psize : $_default_page_size;
				}
				if(in_array('term', array_keys($_GET))){
					$_search_term = trim($_GET['term']);
				}else{
					$_search_term = $_search_obj->term ? $_search_obj->term : $_default_search_term;
				}
			}
			$page = $_GET['page'] ? $_GET['page'] : '1';			
			if(!ctype_digit($page)){
				$this->redirect($this->ctx().'/user/album/');
			}else{
				$page = intval($page);
			}
			
			$limit = is_int($_page_sizes[$_page_size]) ? $_page_sizes[$_page_size] : 0;
			$offset = ($page - 1) * $limit;
			$sort_column = $_sort_columns[$_sort_mode];
			$sort_order = $_sort_orders[$_sort_mode];
			
			$_search_obj->sort = $_sort_mode;
			$_search_obj->psize = $_page_size;
			$_search_obj->term = $_search_term;
			$_SESSION['ALBUM_SEARCH'] = serialize($_search_obj);
			
			
			if (!$this->model_user->userSettingExist(array($userId,'ALBUM_LIST_SORT')))
			{
				$this->model_user->addUserSetting(array($userId,'ALBUM_LIST_SORT',$_sort_mode));
			}
			else 
			{
				$this->model_user->updateUserSetting(array($_sort_mode,$userId,'ALBUM_LIST_SORT'));
			}
			
			if (!$this->model_user->userSettingExist(array($userId,'ALBUM_LIST_PSIZE')))
			{
				$this->model_user->addUserSetting(array($userId,'ALBUM_LIST_PSIZE',$_page_size));
			}
			else 
			{
				$this->model_user->updateUserSetting(array($_page_size,$userId,'ALBUM_LIST_PSIZE'));
			}
			
			if (!$this->model_user->userSettingExist(array($userId,'ALBUM_LIST_TERM')))
			{
				$this->model_user->addUserSetting(array($userId,'ALBUM_LIST_TERM',$_search_term));
			}
			else 
			{
				$this->model_user->updateUserSetting(array($_search_term,$userId,'ALBUM_LIST_TERM'));
			}
			
			$_search_obj->sort = $this->model_user->getUserSetting(array($userId,'ALBUM_LIST_SORT'));
			$_search_obj->psize = $this->model_user->getUserSetting(array($userId,'ALBUM_LIST_PSIZE'));
			$_search_obj->term = $this->model_user->getUserSetting(array($userId,'ALBUM_LIST_TERM'));
			$_SESSION['ALBUM_SEARCH'] = serialize($_search_obj);
			
			$this->loadModel('model_album');
			$model_album = $this->model_album;
			$album_count = $model_album->countAlbumByUserId($userId, $limit, $offset, $_search_term, $sort_column, $sort_order);
			if($album_count > 0){
				if($limit > 0){
					if($limit && ($page > ceil($album_count / $limit))){
						$this->redirect($this->ctx().'/user/album/');
					}
					$albums = $model_album->selectAlbumsByUserId($userId, $limit, $offset, $_search_term, $sort_column, $sort_order);

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
					$lastpage = ceil($album_count / $limit);		//lastpage is = total pages / items per page, rounded up.
					$lpm1 = $lastpage - 1;						//last page minus 1
					
					/* 
						Now we apply our rules and draw the pagination object. 
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
					$albums = $model_album->selectAlbumsByUserId($userId, $limit, $offset, $_search_term, $sort_column, $sort_order);
				}
			}else{
				$this->assign('message', 'No album');
			}
			
			if(is_array($albums) && (count($albums) > 0)){
				foreach($albums as &$album){
					$album['thumbnail'] = empty($album['thumbnails_path']) ? $this->ctx() . '/images/icon-album.gif' : ($this->ctx() . $this->loadResources('image.upload.path') . $album['thumbnails_path']);
					$album['create_date'] = utils::getDiffTimeString($album['create_date']);
				}
			}
			
			
			$this->assign('albums', $albums);
			$this->assign('pagination', $pagination);
			$this->assign('sort_modes', $_sort_modes);
			$this->assign('page_sizes', $_page_sizes);
			
			$this->assign('sort_mode', $_sort_mode);
			$this->assign('page_size', $_page_size);
			$this->assign('search_term', $_search_term);
			$this->assign('page', $page);
			
			$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_album');
		}
		
		/**
		 *  ajax refresh user's avatar after upload avatar image successfully
		 */
		function refreshUserAvatar(){
			$userId = $this->getLoggedUser();
				if($userId == 0){
					$this->redirect($this->ctx().'/auth/login/');
					return;
				}
			$this->loadModel('model_user');	
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$uid = $_POST['userId'];
				$user = $this->model_user->getUserByUserId(array($uid));
				echo $user['avatar'];
			}
		}
		
		/**
		 *  ajax add video to album
		 *  
		 */
		function addVideoToAlbum()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_video');
			$this->loadModel('model_album');
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$albumId=$_POST['albumId'];
				$videoId=$_POST['videoId'];
				$checked=$_POST['videoChecked'];
				$res=$this->model_video->checkUserId(array($videoId));
				$res1=$this->model_album->checkUserId(array($albumId));
				if($res['user_id']!=$userId || $res1['user_id']!=$userId)
				{
					echo false;
				}
				else 
				{
					if($checked == "true")
					{
						$this->model_video->addVideoToAlBum(array($albumId,$videoId));
					}
					else 
					{
						$this->model_video->dropAlbumIdAndVideoId(array($albumId,$videoId));
					}
					echo true;
				}
			}
		}
		
		function addVideoToChannel()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_video');
			$this->loadModel('model_album');
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$channelId=$_POST['channelId'];
				$videoId=$_POST['videoId'];
				$checked=$_POST['videoChecked'];
				$res=$this->model_video->checkUserId(array($videoId));
				if($res['user_id']!=$userId)
				{
					echo false;
				}
				else 
				{
					if($checked == "true")
					{
						$this->model_video->addVideoToChannel(array($channelId,$videoId));
					}
					else 
					{
						$this->model_video->dropChannelIdAndVideoId(array($channelId,$videoId));
					}
					echo true;
				}
			}
		}
		
		function channelMessagesSource(){
			$this->defaultUserMessagesSource();
			$this->assign('title', $this->loadMessages('user.channel.title'));
			$this->assign('hint', $this->loadMessages('user.channel.hint'));
		}
		
		function channel(){
			$userId = $this->getLoggedUser();
			if($userId == 0){
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			
			$_search_obj = unserialize($_SESSION['CHANNEL_SEARCH']);
			
			$_sort_modes = array(
				1 => 'Newest',
				2 => 'Oldest',
				3 => 'Alphabetical'
			);
			$_sort_columns = array(
				1 => 'creation_date',
				2 => 'creation_date',
				3 => 'channel_name'
			);
			$_sort_orders = array(
				1 => 'DESC',
				2 => 'ASC',
				3 => 'ASC'
			);
			$_page_sizes = array(
				1 => 10,
				2 => 25,
				3 => 50,
				4 => 'All'
			);
			$_default_sort_mode = 1;
			$_default_page_size = 2;
			$_default_search_term = '';
			
			$channels = array();
			$pagination = '';
			$_reset = $_GET['reset'];// reset all value for display
			if($_reset){
				
			}else{
				if($_GET['sort']){
					$_sort_mode = $_GET['sort'];
					if(!in_array($_sort_mode, array_keys($_sort_modes), false)){
						$_sort_mode = $_default_sort_mode;
					}
				}else{
					$_sort_mode = $_search_obj->sort ? $_search_obj->sort : $_default_sort_mode;
				}
				if($_GET['psize']){
					$_page_size = $_GET['psize'];
					if(!in_array($_page_size, array_keys($_page_sizes), false)){
						$_page_size = $_default_page_size;
					}
				}else{
					$_page_size = $_search_obj->psize ? $_search_obj->psize : $_default_page_size;
				}
				if(in_array('term', array_keys($_GET))){
					$_search_term = trim($_GET['term']);
				}else{
					$_search_term = $_search_obj->term ? $_search_obj->term : $_default_search_term;
				}
			}
			$page = $_GET['page'] ? $_GET['page'] : '1';			
			if(!ctype_digit($page)){
				$this->redirect($this->ctx().'/user/channel/');
			}else{
				$page = intval($page);
			}
			
			$limit = is_int($_page_sizes[$_page_size]) ? $_page_sizes[$_page_size] : 0;
			$offset = ($page - 1) * $limit;
			$sort_column = $_sort_columns[$_sort_mode];
			$sort_order = $_sort_orders[$_sort_mode];
			
			$_search_obj->sort = $_sort_mode;
			$_search_obj->psize = $_page_size;
			$_search_obj->term = $_search_term;
			$_SESSION['CHANNEL_SEARCH'] = serialize($_search_obj);
			
			if (!$this->model_user->userSettingExist(array($userId,'CHANNEL_LIST_SORT')))
			{
				$this->model_user->addUserSetting(array($userId,'CHANNEL_LIST_SORT',$_sort_mode));
			}
			else 
			{
				$this->model_user->updateUserSetting(array($_sort_mode,$userId,'CHANNEL_LIST_SORT'));
			}
			
			if (!$this->model_user->userSettingExist(array($userId,'CHANNEL_LIST_PSIZE')))
			{
				$this->model_user->addUserSetting(array($userId,'CHANNEL_LIST_PSIZE',$_page_size));
			}
			else 
			{
				$this->model_user->updateUserSetting(array($_page_size,$userId,'CHANNEL_LIST_PSIZE'));
			}
			
			if (!$this->model_user->userSettingExist(array($userId,'CHANNEL_LIST_TERM')))
			{
				$this->model_user->addUserSetting(array($userId,'CHANNEL_LIST_TERM',$_search_term));
			}
			else 
			{
				$this->model_user->updateUserSetting(array($_search_term,$userId,'CHANNEL_LIST_TERM'));
			}
			
			$_search_obj->sort = $this->model_user->getUserSetting(array($userId,'CHANNEL_LIST_SORT'));
			$_search_obj->psize = $this->model_user->getUserSetting(array($userId,'CHANNEL_LIST_PSIZE'));
			$_search_obj->term = $this->model_user->getUserSetting(array($userId,'CHANNEL_LIST_TERM'));
			$_SESSION['CHANNEL_SEARCH'] = serialize($_search_obj);
			
			$this->loadModel('model_channel');
			$model_channel = $this->model_channel;
			$channel_count = $model_channel->countChannelByUserId($userId, $limit, $offset, $_search_term, $sort_column, $sort_order);
			if($channel_count > 0){
				if($limit > 0){
					if($limit && ($page > ceil($channel_count / $limit))){
						$this->redirect($this->ctx().'/user/channel/');
					}
					$channels = $model_channel->selectChannelsByUserId($userId, $limit, $offset, $_search_term, $sort_column, $sort_order);

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
					$lastpage = ceil($channel_count / $limit);		//lastpage is = total pages / items per page, rounded up.
					$lpm1 = $lastpage - 1;						//last page minus 1
					
					/* 
						Now we apply our rules and draw the pagination object. 
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
					$channels = $model_channel->selectChannelsByUserId($userId, $limit, $offset, $_search_term, $sort_column, $sort_order);
				}
			}else{
				$this->assign('message', 'No channel');
			}
			
			if(is_array($channels) && (count($channels) > 0)){
				foreach($channels as &$channel){
					$channel['thumbnail'] = empty($channel['thumbnails_path']) ? $this->ctx() . '/images/channel.jpg' : ($this->ctx() . $this->loadResources('image.upload.path') . $channel['thumbnails_path']);
					$channel['create_date'] = utils::getDiffTimeString($channel['create_date']);
				}
			}
			
			$this->assign('channels', $channels);
			$this->assign('pagination', $pagination);
			$this->assign('sort_modes', $_sort_modes);
			$this->assign('page_sizes', $_page_sizes);
			
			$this->assign('sort_mode', $_sort_mode);
			$this->assign('page_size', $_page_size);
			$this->assign('search_term', $_search_term);
			$this->assign('page', $page);
			
			$this->loadTemplate(USER_TEMPLATE_DIR.'view_user_channel');
		}
		
		/**
		 * create video using ajax
		 * 
		 */
		function createUploadingVideo()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0){
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_video');	
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$videoTitle=$_POST['title'];
				$description=$_POST['description'];
				$tag=$_POST['tag'];
				$slipTag=split(',', $tag);
				$videoid=$_POST['videoid'];
				$tcid=$_POST['tcid'];
				$videoPath = $_POST['videoPath'];
				if($videoid!=null)
				{					
					for($j=0;$j<sizeof($slipTag);$j++){				
						if($slipTag[$j]!="")
						{
							$checkTag=$this->model_video->isTagExist(array($slipTag[$j]));
							if($checkTag==0)
							{
								$this->model_video->addTagName(array($slipTag[$j]));			
								$tagNewId=$this->model_video->getTagIdByName(array($slipTag[$j]));
								$this->model_video->addTagIdAndComponentId(array($tagNewId[0]["id"],"1",$videoid));
							}
							else 
							{
								$tagNewId=$this->model_video->getTagIdByName(array($slipTag[$j]));
								$res=$this->model_video->checkIdAndComponentId(array($tagNewId[0]["id"],$videoid));
								if($res==0)
								{
									$this->model_video->addTagIdAndComponentId(array($tagNewId[0]["id"],'1',$videoid));
								}
							}
						}	
					}
					if($videoPath != null){
						$this->model_video->updateVideoFile(array($videoPath, $videoid));
					}
					$updatetitle= $this->model_video->updateTitlebyId(array($videoTitle,$videoid));
					$updatedescrition= $this->model_video->updateDescriptionbyId(array($description,$videoid));
					echo $videoid;							
				}
				else{
					$newVideoId=$this->model_video->addNewVideoWithInfo(array($userId,$videoTitle,$description));
					if($videoPath != null){
						$this->model_video->updateVideoFile(array($videoPath, $newVideoId));
					}
					for($j=0;$j<sizeof($slipTag);$j++){				
						if($slipTag[$j]!="")
						{
							$checkTag=$this->model_video->isTagExist(array($slipTag[$j]));
							if($checkTag==0)
							{
								$this->model_video->addTagName(array($slipTag[$j]));			
								$tagNewId=$this->model_video->getTagIdByName(array($slipTag[$j]));
								$this->model_video->addTagIdAndComponentId(array($tagNewId[0]["id"],"1",$newVideoId));
							}
							else 
							{
								$tagNewId=$this->model_video->getTagIdByName(array($slipTag[$j]));
								$res=$this->model_video->checkIdAndComponentId(array($tagNewId[0]["id"],$newVideoId));
								if($res==0){
									$this->model_video->addTagIdAndComponentId(array($tagNewId[0]["id"],'1',$newVideoId));
								}
							}
						}	
					}
					echo $newVideoId;
				}							
			}
		}
	}
?>