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
			
			$this->assign('title', $this->loadMessages('home.title'));
			
			$this->loadModel('model_album');
			$model_album = $this->model_album;
			$this->assign('album_count', $model_album->countAlbumByUserId($userId));
			
			$model_video = $this->loadModel('model_video');
			$model_video = $this->model_video;
			$this->assign('video_count', $model_video->countVideoByUserId($userId));
			
			$videos = $model_video->selectVideoByUserId($userId, 2, 0, '', 'creation_date', 'DESC');
			$this->assign('recent_videos', $videos);
			
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
				$this->assign('userAvatar', $user['avatar']);
			}
			
			$this->assign("menuUploadVideo", $this->loadMessages('user.menu.link.uploadVideo'));
			$this->assign("menuVideos", $this->loadMessages('user.menu.link.videos'));
			$this->assign("menuAlbums", $this->loadMessages('user.menu.link.albums'));
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
			$this->assign("domain", BASE_PATH . CONTEXT);
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
				$this->assign('alias', $user['profile_alias']);
				$this->loadTemplate('view_user_shortcut');
			}
			else if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$user = $this->model_user->getUserByUserId($userId);
				
				$alias = $_POST['alias'];
				// check alias format
				
				if($this->model_user->existsAlias(array($alias, $userId)))
				{
					$this->assign('errorMessage', $this->loadErrorMessage('error.user.shortcut.duplicated', array($alias)));
					$this->assign('alias', $user['profile_alias']);
					$this->loadTemplate('view_user_shortcut');
				}
				else 
				{
					$this->model_user->updateUserAlias(array($alias, $userId));
					$this->assign('successMessage', $this->loadMessages('user.information.update.success', array("profile shortcut's URL")));
					$this->assign('alias', $alias);
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
			
			$this->assign('title', $this->loadMessages('user.portrait.title'));
			$this->assign('currentPortrait', $this->loadMessages('user.portrait.current'));
			$this->assign('uploadNew', $this->loadMessages('user.portrait.upload'));					
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
				$this->assign('upId', uniqid());
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
						$this->assign('errorMessage', $this->loadErrorMessage('error.user.portrait.notsupport'));
						$this->assign('avatar', $user['avatar']);
						$this->assign('upId', uniqid());	
						$this->loadTemplate('view_user_portrait');						
					}else{
						if($size > 5)//5MB
						{
							$this->assign('errorMessage', $this->loadErrorMessage('error.user.upload.maximum.file.size', array('5MB')));
							$this->assign('avatar', $user['avatar']);
							$this->assign('upId', uniqid());							
							$this->loadTemplate('view_user_portrait');
						}else if($size == 0){
							$this->assign('errorMessage', $this->loadErrorMessage('error.field.required'));
							$this->assign('avatar', $user['avatar']);
							$this->assign('upId', uniqid());							
							$this->loadTemplate('view_user_portrait');
						}else{							
							$fileInfo = utils::getFileType($fileName);
							$name = utils::genRandomString(32) . '.' . $fileInfo[1];
							$target = BASE_DIR . $this->loadResources('image.upload.path') . $name;
							
							$rimg = new RESIZEIMAGE($tmpName);
						    $rimg->resize_limitwh(300, 300, $target);				    
						    $rimg->close(); 
						    
						    $ret = $this->model_user->updateUserAvatar(array($name, $userId));
						    
							if($ret == 0)
							{
								$this->assign('errorMessage', 'Error');
								$this->assign('avatar', $user['avatar']);
								$this->assign('userAvatar', $user['avatar']);
							}
							else 
							{
								$this->assign('successMessage', $this->loadMessages('user.information.update.success', array("portrait")));
								$this->assign('avatar', $name);
								$this->assign('userAvatar', $name);
								$this->assign('upId', uniqid());
								$this->loadTemplate('view_user_portrait');
							}
						}
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
			
			$this->assign("title", $this->loadMessages('user.personalInfo.title'));
			$this->assign("fullNameTitle", $this->loadMessages('user.personalInfo.fullName'));
			$this->assign("emailTitle", $this->loadMessages('user.personalInfo.email'));
			$this->assign("yourWebsiteTitle", $this->loadMessages('user.personalInfo.website'));
			
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
					$this->assign('errorMessage', 'Error');
				}
				else 
				{
					$this->assign('successMessage', $this->loadMessages('user.information.update.success', array("personal info")));
				}
				
				$user = $this->model_user->getUserByUserId(array($userId));
				$this->assign('fullName', $user['full_name']);
				$this->assign('email', $user['email']);
				$this->assign('website', $user['website']);
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
			
			$this->assign("title", $this->loadMessages('user.password.title'));
			$this->assign("currentpassword", $this->loadMessages('user.password.currentpassword'));
			$this->assign("newpassword", $this->loadMessages('user.password.newpassword'));
			$this->assign("repassword", $this->loadMessages('user.password.retypepassword'));
			
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
					
					if($res == 0)
					{
						$this->assign('FailMessage', $this->loadMessages('user.password.fail'));
						$this->loadTemplate('view_user_password');
					}
					else 
					{
						$this->assign('successMessage', $this->loadMessages('user.password.success'));
						$this->loadTemplate('view_user_password');
					}
				}
				else 
				{
					$this->assign("errorMessage", $this->loadMessages('user.password.error'));
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
			$this->assign("title", $this->loadMessages('user.profile.title'));
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
				$profileAlias=$_GET['profileAlias'];
				$params=array($id);
				$fullname_Alias=$this->model_user->getFullnameByProfileAlias(array($profileAlias));
				$fullname_UserId=$this->model_user->getFullNamebyUserId($params);
				if($fullname_Alias!=0)
				{
					$this->assign("fullname",$fullname_Alias['full_name']);
					$this->loadTemplate('view_user_profile');
				}
				else if ($fullname_UserId!=0)
				{
					$this->assign("fullname",$fullname_UserId['full_name']);
					$this->loadTemplate('view_user_profile');
				}
				else 
				{
					$this->loadTemplate('view_home');
				}
				
				
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
			if($userId == 0){
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			
			$_search_obj = unserialize($_SESSION['SEARCH']);
			
			$_display_modes = array(1 => 'Thumnail mode', 2 => 'Detail mode');
			
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
				1 => 'All',//all videos
				2 => 2,
				3 => 3,
				4 => 50
			);
			$_default_display_mode = 1;
			$_default_sort_mode = 1;
			$_default_page_size = 2;
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
			$page = $_GET['page'] ? $_GET['page'] : 1;			
			if(!is_numeric($page)){
				$this->redirect($this->ctx().'/user/video/');
			}else{
				$page = intval($page);
			}
			
			$limit = is_int($_page_sizes[$_page_size]) ? $_page_sizes[$_page_size] : 0;
			$offset = ($page - 1) * $limit;
			$sort_column = $_sort_columns[$_sort_mode];
			$sort_order = $_sort_orders[$_sort_mode];
			
			$_search_obj->mode = $_display_mode;
			$_search_obj->sort = $_sort_mode;
			$_search_obj->psize = $_page_size;
			$_search_obj->term = $_search_term;
			$_SESSION['SEARCH'] = serialize($_search_obj);
			
			$this->loadModel('model_video');
			$model_video = $this->model_video;
			$video_count = $model_video->countVideoByUserId($userId, $limit, $offset, $_search_term, $sort_column, $sort_order);
			if($video_count > 0){
				if($limit > 0){
					if($limit && ($page > ceil($video_count / $limit))){
						$this->redirect($this->ctx().'/user/video/');
					}
					$videos = $model_video->selectVideoByUserId($userId, $limit, $offset, $_search_term, $sort_column, $sort_order);
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
					$videos = $model_video->selectVideoByUserId($userId, $limit, $offset, $_search_term, $sort_column, $sort_order);
				}
			}else{
				$this->assign('message', 'You have no video');
			}
			
			if(is_array($videos) && (count($videos) > 0)){
				$this->loadModel('model_album');
				$model_album = $this->model_album;
				
				$this->loadModel('model_tag');
				$model_tag = $this->model_tag;
				
				foreach($videos as &$video){
					$video['creation_date'] = date_format(new DateTime($video['creation_date']), 'U');
					$video['thumbnails_path'] = empty($video['thumbnails_path']) ? $this->ctx() . '/images/icon-video.gif' : $video['thumbnails_path'];
					$video['album'] = $model_album->selectAlbumByVideoId($video['id']);
					$video['tag'] = $model_tag->selectTagByVideoId($video['id']);
					//krumo($video);
				}
			}
			
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
			
			//var_dump($_SERVER);
			$this->userVideoMessagesSource();
			$this->loadTemplate('view_user_video');
		}
		
		/**
		 * Default message source for videopage
		 * 
		 */
		
		function videopageMessagesSource()
		{
			$this->assign("title", $this->loadMessages('user.videopage.title'));
			$this->assign("day", $this->loadMessages('user.videopage.day'));
			$this->assign("by", $this->loadMessages('user.videopage.by'));
			$this->assign("plays", $this->loadMessages('user.videopage.plays'));
			$this->assign("comments", $this->loadMessages('user.videopage.comments'));
			$this->assign("likes", $this->loadMessages('user.videopage.likes'));
			$this->assign("tag", $this->loadMessages('user.videopage.tag'));
			$this->assign("albums", $this->loadMessages('user.videopage.albums'));
		}
		/**
		 * Display video pages
		 * 
		 */
		
		function videopage()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			
			$this->loadModel('model_user');
			$this->loadModel('model_video');
			$video=array();
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$id=$_GET['Id'];
				$params=array($id);
				$fullname=$this->model_user->getFullNamebyUserId(array($userId));
				$play=$this->model_video->getPlaybyUserId(array($userId));
				$comment=$this->model_video->getCommentbyId($params);
				$like=$this->model_video->getLikebyId($params);
				$album=$this->model_video->getAlbumbyId(array($id,$userId));
				$this->assign("play",$play['play_count']);
				$this->assign("comment",$comment['comment_count']);
				$this->assign("like",$like['like_count']);
				$this->assign("album",$album['album_name']);
				$this->assign("fullname",$fullname['full_name']);
				$this->assign("video",$video);
				$this->loadTemplate('view_videopage');
			} 
		}
		/**
		 * Default message sourse for upload video pages
		 */
		function addvideouploadMessagesSource()
		{
			$this->defaultUserMessagesSource();	
			$this->assign("title", $this->loadMessages('user.uploadvideo.title'));
			$this->assign("choose", $this->loadMessages('user.uploadvideo.chooseavideotoupload'));
		}
		/**
		 * action upload video
		 */
		function addvideoupload()
		{
			$this->loadModel('model_user');
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$videoId=$_GET['videoId'];
				$video = $this->model_user->getVideoByVideoIdAndUserId(array($userId,$videoId));
				$this->assign('video', $video['video_title']);
				$this->assign('videoid',$videoId);
				$this->assign('upId', uniqid());
				$this->loadTemplate("view_user_uploadvideo");
			}
			else if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$videoId=$_POST['videoid'];
				if($_FILES['video']['error'] > 0)
				{
					echo $_FILES['video']['error'];
				}
				else 
				{
					$type = $_FILES['video']['type'];
					$size = $_FILES['video']['size'] / (1024*1024);
					$tmpName = $_FILES['video']['tmp_name'];
					$fileName = $_FILES['video']['name'];
					
					$video = $this->model_user->getVideoByVideoIdAndUserId(array($userId,$videoId));
						
					if($size > 102400)
					{
						$this->assign('errorMessage', 'Maximum file size is 1GB');
						$this->assign('video', $video['video_title']);							
						$this->loadTemplate("view_user_uploadvideo");
						return;
					}
					
					$fileInfo = utils::getFileType($fileName);
					$name = utils::genRandomString(32) . '.' . $fileInfo[1];
					$target = BASE_DIR . $this->loadResources('video.upload.path') . $name;
					move_uploaded_file($tmpName, $target);
					
				    $ret = $this->model_user->updateVideo(array($name,$videoId));
			
					if($ret == 0)
					{
						$this->assign('errorMessage', 'Error');
					}
					else 
					{
						$this->assign('successMessage', $this->loadMessages('user.information.update.success', array("video")));
						$this->assign('video', $name);
						$this->assign('userAvatar', $name);
						
						$this->loadTemplate("view_user_uploadvideo");
					}
				}
			}
		}

	}
?>