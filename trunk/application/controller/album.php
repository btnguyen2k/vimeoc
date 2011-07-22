<?php
	define("ALBUM_TEMPLATE_DIR","album/");
	
	/**
	 * 
	 * Album controller
	 * @author Tri
	 *
	 */
	class Album extends Application
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
		 * Default messages source for album index page
		 */
		function indexMessagesSource()		
		{
			$this->defaultAlbumMessagesSource();
			$this->assign('title', $this->loadMessages('album.index.title'));
		}
		/**
		 * 
		 * Default action
		 */
		function index()
		{
			$userId = $this->getLoggedUser();
			if($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$albumId = $_GET['albumId'];
			}elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
				$albumId = $_POST['albumId'];
			}
			
			if(!ctype_digit($albumId)){
				$error_flag = true;
				$this->loadTemplate('view_404');
				return;
			}
		
			$this->loadModel('model_album');
			$model_album = $this->model_album;
			$album = $model_album->selectAlbumById($albumId);
			
			if(!$album){
				$error_flag = true;
				$this->loadTemplate('view_404');
				return;
			}
			//check user input password
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$password = $_POST['password'];
				if($password != $album['password']){
					$this->assign('albumId', $albumId);
					$this->indexMessagesSource();
					$this->assign("title", $this->loadMessages('album.index.password.title'));
					$this->assign("input_password_label", $this->loadMessages('album.index.password.input_label'));
					$this->assign('errorMessage', $this->loadErrorMessage('error.album.index.password.invalid_password'));
					$this->loadTemplate(ALBUM_TEMPLATE_DIR . 'view_album_index_password');
					return;
				}else{
					$_SESSION['AUTHORISED_ALBUM_PASSWORD'] = $_SESSION['AUTHORISED_ALBUM_PASSWORD'] . $albumId . ',';
				}
			}
			$authorised_album_password = explode(',', $_SESSION['AUTHORISED_ALBUM_PASSWORD']);
			//check album password
			if($album['password'] && ($album['user_id'] != $userId) && !(in_array($albumId, $authorised_album_password))){
				$this->assign('albumId', $albumId);
				$this->indexMessagesSource();
				$this->assign("title", $this->loadMessages('album.index.password.title'));
				$this->assign("input_password_label", $this->loadMessages('album.index.password.input_label'));
				$this->loadTemplate(ALBUM_TEMPLATE_DIR . 'view_album_index_password');
				return;
			}
			
			
			$_search_obj = unserialize($_SESSION['ALBUM_SEARCH']);
			
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
				
				$_sort_mode = $album['arrange'] ? $album['arrange'] : $_default_sort_mode;

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
				$this->redirect($this->ctx() . '/album/?albumId=' . $albumId);
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
			$_SESSION['ALBUM_SEARCH'] = serialize($_search_obj);
			
			$this->loadModel('model_video');
			$model_video = $this->model_video;
			$video_count = $model_video->countVideoByAlbumId($albumId, $limit, $offset, $_search_term, $sort_column, $sort_order);
			if($video_count > 0){
				if($limit > 0){
					if($limit && ($page > ceil($video_count / $limit))){
						$this->redirect($this->ctx() . '/album/?albumId=' . $albumId);
					}
					$videos = $model_video->selectVideoByAlbumId($albumId, $limit, $offset, $_search_term, $sort_column, $sort_order);
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
							$pagination.= "<a href=\"$targetpage?albumId=$albumId&page=$prev\">« Previous</a>";
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
									$pagination.= "<a href=\"$targetpage?albumId=$albumId&page=$counter\">$counter</a>";					
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
										$pagination.= "<a href=\"$targetpage?albumId=$albumId&page=$counter\">$counter</a>";					
								}
								$pagination.= "...";
								$pagination.= "<a href=\"$targetpage?albumId=$albumId&page=$lpm1\">$lpm1</a>";
								$pagination.= "<a href=\"$targetpage?albumId=$albumId&page=$lastpage\">$lastpage</a>";		
							}
							//in middle; hide some front and some back
							elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
							{
								$pagination.= "<a href=\"$targetpage?albumId=$albumId&page=1\">1</a>";
								$pagination.= "<a href=\"$targetpage?albumId=$albumId&page=2\">2</a>";
								$pagination.= "...";
								for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
								{
									if ($counter == $page)
										$pagination.= "<span class=\"current\">$counter</span>";
									else
										$pagination.= "<a href=\"$targetpage?albumId=$albumId&page=$counter\">$counter</a>";					
								}
								$pagination.= "...";
								$pagination.= "<a href=\"$targetpage?albumId=$albumId&page=$lpm1\">$lpm1</a>";
								$pagination.= "<a href=\"$targetpage?albumId=$albumId&page=$lastpage\">$lastpage</a>";		
							}
							//close to end; only hide early pages
							else
							{
								$pagination.= "<a href=\"$targetpage?albumId=$albumId&page=1\">1</a>";
								$pagination.= "<a href=\"$targetpage?albumId=$albumId&page=2\">2</a>";
								$pagination.= "...";
								for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
								{
									if ($counter == $page)
										$pagination.= "<span class=\"current\">$counter</span>";
									else
										$pagination.= "<a href=\"$targetpage?albumId=$albumId&page=$counter\">$counter</a>";					
								}
							}
						}
						
						//next button
						if ($page < $counter - 1){
							$pagination.= "<a href=\"$targetpage?albumId=$albumId&page=$next\">Next »</a>";
						}else{
							$pagination.= "<span class=\"disabled\">Next »</span>";
						}
						$pagination.= "</div>\n";		
					}
				}else{
					$videos = $model_video->selectVideoByAlbumId($albumId, $limit, $offset, $_search_term, $sort_column, $sort_order);
				}
			}else{
				$this->assign('message', 'No video');
			}
			
			if(is_array($videos) && (count($videos) > 0)){
				$this->loadModel('model_album');
				$model_album = $this->model_album;
				
				$this->loadModel('model_tag');
				$model_tag = $this->model_tag;
				
				foreach($videos as &$video){
					$video['thumbnails_path'] = empty($video['thumbnails_path']) ? $this->ctx() . '/images/icon-video.gif' : ($this->ctx() . $this->loadResources('image.upload.path') . $video['thumbnails_path']);
					$video['album'] = $model_album->selectAlbumByVideoId($video['id']);
					$video['tag'] = $model_tag->selectTagByVideoId($video['id']);
				}
			}
			
			$this->assign('videos', $videos);
			$this->assign('pagination', $pagination);
			$this->assign('display_modes', $_display_modes);
			//$this->assign('sort_modes', $_sort_modes);
			$this->assign('page_sizes', $_page_sizes);
			
			$this->assign('display_mode', $_display_mode);
			$this->assign('sort_mode', $_sort_mode);
			$this->assign('page_size', $_page_size);
			$this->assign('search_term', $_search_term);
			$this->assign('page', $page);
			
			$this->assign('albumId', $albumId);
			$this->assign('album_name', $album['album_name']);
			$this->assign('show_user_avatar', 1);
			
			$this->indexMessagesSource();
			$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_index');
		}
		
		function assignAlbumThumbnails($album){
			if($album){
				$albumThumbnail = empty($album['thumbnails_path']) ? '' : $this->loadResources('image.upload.path').$album['thumbnails_path'];
				$this->assign("albumThumbnail", $albumThumbnail);
			}
		}
		
		/**
		 * Load messages source for all Album features
		 * 
		 */
		function defaultAlbumMessagesSource()
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
			$this->assign("menuMyAlbum", $this->loadMessages('album.menu.myalbum.link'));
			$this->assign("menubasicinfoAlbum", $this->loadMessages('album.menu.basicinfo.link'));
			$this->assign("menuthumbnailAlbum", $this->loadMessages('album.menu.thumbnail.link'));
			$this->assign("menuarrangeAlbum", $this->loadMessages('album.menu.arrange.link'));
			$this->assign("menuCustomUrlAlbum", $this->loadMessages('album.menu.customUrl'));
			$this->assign("menupasswordAlbum", $this->loadMessages('album.menu.password.link'));
			$this->assign("menudeleteAlbum", $this->loadMessages('album.menu.delete.link'));
			$this->assign("menubackAlbum", $this->loadMessages('album.menu.back.link'));
			$this->assign("createNewAlbum", $this->loadMessages('album.menu.create.link'));
			$this->assign("videoId", $_GET["videoId"]);
			$this->assign("albumId", $_GET["albumId"]);
			$this->assign("videobacktovideo", $this->loadMessages('user.video.link.backtovideo'));
		}
		/**
		 * Load defaul create new album page
		 * 
		 */
		function createNewAlbumMessagesSource()
		{
			$this->defaultAlbumMessagesSource();
			
			$this->assign("name", $this->loadMessages('album.create.name'));
			$this->assign("title", $this->loadMessages('album.create.title'));
			$this->assign('description', $this->loadMessages('album.create.description'));
			$this->assign('hint', $this->loadMessages('album.create.hint'));
			
			$this->assign('errorDescription', $this->loadErrorMessage('error.album.create.description'));
			$this->assign('show_user_avatar', 1);
			$this->assign('create_album', 1);
		}
		/**
		 * Load and action create new album 
		 * 
		 */
		
		function createNewAlbum()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_album');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{						
				$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_createnewalbum');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$albumName=$_POST['title'];
				$description=$_POST['description'];
				$albumId = $this->model_album->addNewAlbum(array($userId,$albumName,$description));
				$this->redirect($this->ctx().'/album/?albumId='.$albumId);
			}
		}
		/**
		 * Load defaul album basic info page
		 * 
		 */
		function albumSettingMessagesSource()
		{
			$this->defaultAlbumMessagesSource();
			
			$this->assign("name", $this->loadMessages('album.albumsetting.name'));
			$this->assign("title", $this->loadMessages('album.albumsetting.title'));
			$this->assign('description', $this->loadMessages('album.albumsetting.description'));
			$this->assign('hint', $this->loadMessages('album.albumsetting.hint'));
			
			$this->assign('errorDescription', $this->loadErrorMessage('error.album.create.description'));
		}
		/**
		 * Load and action album basic info page
		 * 
		 */
		
		function albumSetting()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_album');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$albumId=$_GET['albumId'];
				$album=$this->model_album->getAlbumbyAlbumIdAndUserId(array($albumId,$userId));
				if($album==null)
				{
					$this->loadTemplate('view_404');
					return;
				}
				$this->assignAlbumThumbnails($album);
				$this->assign("albumId",$albumId);
				$this->assign("description_",$album['description']);
				$this->assign("title_",$album['album_name']);
				$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_albumsetting');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$albumDescription=$_POST['description'];
				$albumName=$_POST['title'];
				$albumId=$_POST['albumid'];
				$res=$this->model_album->isExistAlbumId(array($albumId));
				if($res==0)
				{
					$this->loadTemplate('view_404');
					return;
				}
				$this->model_album->updateAlbumTileByAlbumId(array($albumName,$albumId));
				$this->model_album->updateAlbumDescriptionByAlbumId(array($albumDescription,$albumId));
				$album=$this->model_album->getAlbumbyAlbumIdAndUserId(array($albumId,$userId));
				$this->assignAlbumThumbnails($album);
				$this->assign('successMessage',$this->loadMessages('album.albumsetting.successful'));
				$this->assign('description_',$albumDescription);
				$this->assign('title_',$albumName);
				$this->assign('albumId',$albumId);
				$this->assign("albumThumbnail", $albumThumbnail);
				$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_albumsetting');
			}
		}
		
		/**
		 * Load defaul Thumbnail page
		 * 
		 */
		
		function albumThumbnailMessagesSource()
		{
			$this->defaultAlbumMessagesSource();
			
			$this->assign("name", $this->loadMessages('album.albumthumbnail.name'));
			$this->assign("choose", $this->loadMessages('album.albumthumbnail.choose'));
			$this->assign('hint', $this->loadMessages('album.albumthumbnail.hint'));
			
		}
		
		/**
		 * Load and action album Thumbnail page
		 * 
		 */
		
		function albumThumbnail()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			
			$this->loadModel('model_album');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$albumId=$_GET['albumId'];
				$videoThumbnails=$this->model_album->getVideoThumbnailsByAlbumId(array($albumId,$userId));
				$album=$this->model_album->getAlbumbyAlbumIdAndUserId(array($albumId,$userId));
				$res=$this->model_album->getVideoIdByAlbumId(array($albumId));
				$video=$this->model_album->getVideoThumbnailsByAlbumId(array($albumId,$userId));
				$ret=$this->model_album->isExistAlbumId(array($albumId));
				if($ret==0)
				{
					$this->loadTemplate('view_404');
					return;
				}
				if($res==0)
				{
					$this->assign('error', $this->loadErrorMessage('error.albumthumbnail.error'));
				}
				else
				{
					if($album['thumbnails_path']=="")
					{
						$this->model_album->updateVideoThumbnailToAlbumThumbnail(array($video[0]['thumbnails_path'],$albumId));
					}
				}
				$this->assign("albumThumbnail",$album['thumbnails_path']);
				$this->assign("albumThumbnail1",$album['thumbnails_path']);
				$this->assign("albumName",$album['album_name']);
				$this->assign("albumId",$albumId);
				$this->assign("videoThumbnails",$videoThumbnails);
				$this->assignAlbumThumbnails($album);
				$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_albumthumbnail');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$albumId=$_POST['albumId'];
				$radioChecked=$_POST['videoThumbnail'];
				$videoThumbnails=$this->model_album->getVideoThumbnailsByAlbumId(array($albumId,$userId));
				$res=$this->model_album->getVideoIdByAlbumId(array($albumId));
				if($res==0)
				{
					$this->assign('error', $this->loadErrorMessage('error.albumthumbnail.error'));
				}
				$this->model_album->updateVideoThumbnailToAlbumThumbnail(array($radioChecked,$albumId));
				$album=$this->model_album->getAlbumbyAlbumIdAndUserId(array($albumId,$userId));
				if($album==null)
				{
					$this->loadTemplate('view_404');
					return;
				}
				$this->assign("albumName",$album['album_name']);
				$this->assign('albumId',$albumId);
				$this->assign('succeesMessage',$this->loadMessages('album.albumthumbnail.success'));
				$this->assign("albumThumbnail1",$album['thumbnails_path']);
				$this->assign("videoThumbnails",$videoThumbnails);
				$this->assignAlbumThumbnails($album);
				$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_albumthumbnail');
			}
			
			
		}
		/**
		 * Load defaul password page
		 * 
		 */
		function albumPasswordMessagesSource()
		{
			$this->defaultAlbumMessagesSource();
			
			$this->assign("name", $this->loadMessages('album.password.name'));
			$this->assign("protected", $this->loadMessages('album.password.protected'));
			$this->assign('hint', $this->loadMessages('album.password.hint'));
			
			$this->assign('errorMessage',$this->loadErrorMessage('error.albumpassword.remove'));
			$this->assign('passwordInvalid',$this->loadErrorMessage('error.albumpassword.invalid'));
			
		}

		/**
		 * Load and action album password page
		 * 
		 */
		function albumPassword()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_album');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$albumId=$_GET['albumId'];
				$album=$this->model_album->getAlbumbyAlbumIdAndUserId(array($albumId,$userId));
				if($album==null)
				{
					$this->loadTemplate('view_404');
					return;
				}
				$this->assignAlbumThumbnails($album);
				$this->assign("albumName",$album['album_name']);
				$this->assign("albumId",$albumId);
				$this->assign("albumPassword",$album['password']);
				$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_password');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$albumId=$_POST['albumId'];
				$albumPassword=$_POST['password'];
				$res=$this->model_album->isExistAlbumId(array($albumId));
				if($res==0)
				{
					$this->loadTemplate('view_404');
					return;
				}
				$this->model_album->updatePasswordByUserIdandAlbumId(array($albumPassword,$albumId,$userId));
				$album=$this->model_album->getAlbumbyAlbumIdAndUserId(array($albumId,$userId));
				if($album==null)
				{
					$this->loadTemplate('view_404');
					return;
				}
				$this->assignAlbumThumbnails($album);
				$this->assign("successMessage",$this->loadMessages('album.password.success'));
				$this->assign("albumName",$album['album_name']);
				$this->assign("albumPassword",$album['password']);
				$this->assign("albumId",$albumId);
				$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_password');
			}
		}
		/**
		 * Load defaul delete album page
		 * 
		 */
		
		function albumDeleteMessagesSource()
		{
			$this->defaultAlbumMessagesSource();
			
			$this->assign("name", $this->loadMessages('album.delete.name'));
			$this->assign("question", $this->loadMessages('album.delete.quetion'));
			$this->assign('hint', $this->loadMessages('album.delete.hint'));
		}
		
		/**
		 * Load and action delete album page
		 * 
		 */
		
		function albumDelete()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_album');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$albumId=$_GET['albumId'];
				$album=$this->model_album->getAlbumbyAlbumIdAndUserId(array($albumId,$userId));
				if($album==null)
				{
					$this->loadTemplate('view_404');
					return;	
				}
				$this->assignAlbumThumbnails($album);
				$this->assign("albumName",$album['album_name']);
				$this->assign("albumId",$albumId);
				$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_deletealbum');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$albumId=$_POST['albumId'];
				$album=$this->model_album->getAlbumbyAlbumIdAndUserId(array($albumId,$userId));
				$this->assignAlbumThumbnails($album);
				$this->assign("albumName",$album['album_name']);
				$this->assign("albumId",$albumId);
				$res=$this->model_album->isExistAlbumId(array($albumId));
				if($res==0)
				{
					$this->loadTemplate('view_404');
					return;
				}
				$this->model_album->dropAlbumByAlbumId(array($albumId));
				$this->model_album->dropAlbumVideoByAlbumId(array($albumId));
				$this->redirect($this->ctx().'/user/album/albumsetting');
			}
		}

		
		/**
		 * Load defaul arrange page
		 * 
		 */
		function arrangeMessagesSource(){
			$this->defaultAlbumMessagesSource();
		}
		
		/**
		 * Load and action for arrange page
		 * 
		 */
		
		function arrange(){
			$userId = $this->getLoggedUser();
			if($userId == 0){
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				$error_flag = false;
				$albumId = $_GET['albumId'];
				
				if(!ctype_digit($albumId)){
					$error_flag = true;
					$this->loadTemplate('view_404');
					return;
				}
				

				$this->loadModel('model_album');
				$model_album = $this->model_album;
				$album = $model_album->selectAlbumById($albumId);
				
				//validate album owner
				if(!$album){
					$error_flag = true;
					$this->loadTemplate('view_404');
					return;
				}

				if($album['user_id'] != $userId){
					$error_flag = true;
					$this->loadTemplate('view_access_denied');
					return;
				}

				
				$this->loadModel('model_video');
				$model_video = $this->model_video;
				
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
				
				$default_sort_mode = 1;
				$sort_mode = $album['arrange'] ? $album['arrange'] : $default_sort_mode;
				$sort_column = $_sort_columns[$sort_mode];
				$sort_order = $_sort_orders[$sort_mode];
				
				$videos = $model_video->selectVideoByAlbumId($albumId, 5, 0, '', $sort_column, $sort_order);
				
				if(is_array($videos) && (count($videos) > 0)){
					$this->assign('video_count', count($videos));
					foreach($videos as &$video){
						$video['thumbnails_path'] = empty($video['thumbnails_path']) ? $this->ctx() . '/images/icon-video.gif' : ($this->ctx() . $this->loadResources('image.upload.path') . $video['thumbnails_path']);
					}
				}else{
					$this->assign('message', $this->loadMessages('album.arrange.no_video'));
					$this->assign('video_count', 0);
				}
				
				$this->assignAlbumThumbnails($album);
				$this->assign('videos', $videos);
				$this->assign('sort_modes', $_sort_modes);
				$this->assign('sort_mode', $sort_mode);
				$this->assign('album_id', $albumId);
				$this->assign('hint', $this->loadMessages('album.arrange.hint'));
				$this->assign('title', $this->loadMessages('album.arrange.title'));
				$this->assign('album_title', $album['album_name']);
				
				$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_arrange');
			}elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
				if((!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')){
					$albumId = $_POST['albumId'];

					//validate album id here

					$this->loadModel('model_album');
					$model_album = $this->model_album;
					$album = $model_album->selectAlbumById($albumId);

					//validate album owner here

					$this->loadModel('model_video');
					$model_video = $this->model_video;
					
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
					
					$default_sort_mode = 1;
					$sort_mode = $_POST['sort'];
					$sort_column = $_sort_columns[$sort_mode];
					$sort_order = $_sort_orders[$sort_mode];
					
					$videos = $model_video->selectVideoByAlbumId($albumId, 5, 0, '', $sort_column, $sort_order);
					
					if(is_array($videos) && (count($videos) > 0)){
						foreach($videos as &$video){
							$video['thumbnails_path'] = empty($video['thumbnails_path']) ? $this->ctx() . '/images/icon-video.gif' : ($this->ctx() . $this->loadResources('image.upload.path') . $video['thumbnails_path']);
						}
					}
					
					$this->assign('videos', $videos);
					$this->assign('sort_modes', $_sort_modes);
					$this->assign('sort_mode', $sort_mode);
					$this->assign('album_id', $albumId);
					
					$return = '';
					if(is_array($videos) && (count($videos) > 0)){
						foreach($videos as &$video){
							$return .= "
							<a href=\"{$ctx}/video/videopage/?videoId={$video['id']}\"><img width=\"100\" src=\"{$video['thumbnails_path']}\" /></a><br/>
							title: {$video['video_title']}<br/>
							<div class=\"creation_date\">uploaded: <span class=\"relative_time\">{$video['creation_date']}</span></div><br/>";
						}
					}
					
					$doc = new DOMDocument('1.0');
					$doc->formatOutput = true;
					
					$root = $doc->createElement('result');
					$root = $doc->appendChild($root);
					
					$error = $doc->createElement('error');
					$error = $root->appendChild($error);
					
					$error_code = $doc->createTextNode('0');
					$error_code = $error->appendChild($error_code);
					
					$message = $doc->createElement('message');
					$message = $root->appendChild($message);
					
					$message_content = $doc->createCDATASection($return);
					$message_content = $message->appendChild($message_content);
					
					header("Content-Type:text/xml");
					echo $doc->saveXML();
				}else{
					$error_flag = false;
					$albumId = $_GET['albumId'];
					
					if(!ctype_digit($albumId)){
						$error_flag = true;
						$this->loadTemplate('view_404');
						return;
					}
					

					$this->loadModel('model_album');
					$model_album = $this->model_album;
					$album = $model_album->selectAlbumById($albumId);
					
					//validate album owner
					if(!$album){
						$error_flag = true;
						$this->loadTemplate('view_404');
						return;
					}

					if($album['user_id'] != $userId){
						$error_flag = true;
						$this->loadTemplate('view_access_denied');
						return;
					}
					
					$this->loadModel('model_video');
					$model_video = $this->model_video;
					
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
					
					$default_sort_mode = 1;
					$sort_mode = $_POST['sort'];

					if($sort_mode != $album['arrange']){
						if(array_key_exists($sort_mode, $_sort_modes)){
							if($model_album->updateAlbumArrangeByAlbumId(array($sort_mode, $albumId))){
								$this->assign('successMessage', $this->loadMessages('album.arrange.success'));
							}else{
								$this->assign('errorMessage', 'a'.$this->loadErrorMessage('error.album.arrange'));
								$error_flag = true;
							}
						}else{
							$this->assign('errorMessage', $this->loadErrorMessage('error.album.arrange.invalid_sort_mode'));
							$sort_mode = $album['arrange'] ? $album['arrange'] : $default_sort_mode;
							$error_flag = true;
						}
					}else{
						$this->assign('successMessage', $this->loadMessages('album.arrange.success'));
					}
					
					$sort_column = $_sort_columns[$sort_mode];
					$sort_order = $_sort_orders[$sort_mode];
					
					$videos = $model_video->selectVideoByAlbumId($albumId, 5, 0, '', $sort_column, $sort_order);
					
					if(is_array($videos) && (count($videos) > 0)){
						$this->assign('video_count', count($videos));
						foreach($videos as &$video){
							$video['thumbnails_path'] = empty($video['thumbnails_path']) ? $this->ctx() . '/images/icon-video.gif' : ($this->ctx() . $this->loadResources('image.upload.path') . $video['thumbnails_path']);
						}
					}else{
						$this->assign('message', $this->loadMessages('album.arrange.no_video'));
						$this->assign('video_count', 0);
					}
					
					$this->assign('videos', $videos);
					$this->assign('sort_modes', $_sort_modes);
					$this->assign('sort_mode', $sort_mode);
					$this->assign('album_id', $albumId);
					$this->assign('hint', $this->loadMessages('album.arrange.hint'));
					$this->assign('title', $this->loadMessages('album.arrange.title'));
					$this->assign('album_title', $album['album_name']);
					$this->assignAlbumThumbnails($album);
					$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_arrange');
				}
			}
		}
		/**
		 * load default custom url page
		 * @param params
		 * 
		 */
		
		function albumCustomUrlMessagesSource()
		{
			$this->defaultAlbumMessagesSource();
			
			$this->assign("title", $this->loadMessages('album.customURL.title'));
			$this->assign("name", $this->loadMessages('album.customURL.name'));
			$this->assign('preview', $this->loadMessages('album.customURL.preview'));
			$this->assign('hint', $this->loadMessages('album.customURL.hint'));
		}
		
		/**
		 * load default and action for custom url page
		 * @param params
		 * 
		 */
		
		function albumCustomUrl()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_album');
			$this->loadModel('model_user');
			$this->loadModel('model_video');
			$this->loadModel('model_channel');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$albumId=$_GET['albumId'];
				$user = $this->model_user->getUserByUserId($userId);
				$album = $this->model_album->getAlbumbyAlbumIdAndUserId(array($albumId,$userId));
				if($album==null)
				{
					$this->loadTemplate('view_404');
					return;
				}
				$domain=$this->loadResources('domain');
				
				if(!$album['album_alias']){
					$previewLink = BASE_PATH . CONTEXT . "/" . "album" . "/" . $album['id'];
				}else{
					$previewLink = BASE_PATH . CONTEXT . "/" . ($user['profile_alias'] ? $user['profile_alias'] : 'user' . $user['id']) .  "/" . $album['album_alias'];
				}

				$this->assign("previewUrl", $previewLink);
				
				$this->assign('albumCustomUrl',$album['album_alias']);
				$this->assign("albumName",$album['album_name']);
				$this->assign("albumId",$albumId);
				$this->assign("domain",$domain);
				$this->assignAlbumThumbnails($album);
				$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_albumcustomurl');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$albumId=$_POST['albumId'];
				$albumCustomUrl=$_POST['url'];
				$album = $this->model_album->getAlbumbyAlbumIdAndUserId(array($albumId,$userId));
				//server side validate here
				$urlReg = "/^[a-z0-9]{0,32}\$/";
				if(!preg_match($urlReg, $albumCustomUrl)){
					$this->assign('errorMessage', $this->loadErrorMessage('error.album.alias.invalidUrl'));
					$errorFlag = true;
				}
				
				//check owner id	
				if((!$errorFlag) && ((!$album) || ($album['user_id'] != $userId))){
					$this->assign('errorMessage', $this->loadErrorMessage('error.album.alias.invalidVideoId'));
					//$this->assign('videoTitle', 'N/A');
					$errorFlag = true;
				}
				
				//check exist alias against album
				if((!$errorFlag) && ($this->model_album->isAliasExist(array($albumCustomUrl)))){
					$this->assign('errorMessage', $this->loadErrorMessage('error.album.alias.aliasExists', array($albumCustomUrl)));
					$errorFlag = true;
				}
				//check exist alias against video
				if((!$errorFlag) && ($this->model_video->isAliasExist(array($albumCustomUrl)))){
					$this->assign('errorMessage', $this->loadErrorMessage('error.album.alias.aliasExists', array($albumCustomUrl)));
					$errorFlag = true;
				}
				
				if(!$errorFlag){
					if(($album['album_alias'] == $albumCustomUrl) || $this->model_album->updateAlbumAliasByAlbumId(array($albumCustomUrl, $albumId))){
						$this->assign('successMessage', $this->loadMessages('album.customURL.success'));
					//	$this->assign('video_alias', $albumCustomUrl);
						
						if(!$album['album_alias']){
							$previewLink = BASE_PATH . CONTEXT . "/" . "album" . "/" . $album['id'];
						}else{
							$previewLink = BASE_PATH . CONTEXT . "/" . ($user['profile_alias'] ? $user['profile_alias'] : 'user' . $user['id']) .  "/" . $album['album_alias'];
						}
						$this->assign("previewUrl", $previewLink);
					}else{
						$this->assign('errorMessage', $this->loadErrorMessage('error.album.alias'));
						$this->assign('video_alias', $video['video_alias']);
						$errorFlag = true;
					}
				}

				$user = $this->model_user->getUserByUserId($userId);
				$album=$this->model_album->getAlbumbyAlbumIdAndUserId(array($albumId,$userId));								
				$domain=$this->loadResources('domain');
				$fullName = $user['full_name'];
								
				if(!$album['album_alias']){
					$previewLink = BASE_PATH . CONTEXT . "/" . "album" . "/" . $album['id'];
				}else{
					$previewLink = BASE_PATH . CONTEXT . "/" . ($user['profile_alias'] ? $user['profile_alias'] : 'user' . $user['id']) .  "/" . $album['album_alias'];
				}
				
				$this->assign("previewUrl", $previewLink);
				$this->assign('albumCustomUrl',$albumCustomUrl );
				$this->assign('fullName', $fullName);
				$this->assign("albumName",$album['album_name']);
				$this->assign("albumId",$albumId);
				$this->assign("domain",$domain);
				$this->assignAlbumThumbnails($album);
				$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_albumcustomurl');
			}
		}
	}
	
?>
