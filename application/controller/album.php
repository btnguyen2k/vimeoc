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
				return;
			}
			if($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$albumId = $_GET['id'];
			}elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
				$albumId = $_POST['id'];
			}
			if(!$albumId){
				$this->redirect($this->ctx() . '/user');
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
				$this->redirect($this->ctx() . '/album/?id=' . $albumId);
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
						$this->redirect($this->ctx() . '/album/?id=' . $albumId);
					}
					$videos = $model_video->selectVideoByAlbumId($albumId, $limit, $offset, $_search_term, $sort_column, $sort_order);
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
							$pagination.= "<a href=\"$targetpage?id=$albumId&page=$prev\">« Previous</a>";
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
									$pagination.= "<a href=\"$targetpage?id=$albumId&page=$counter\">$counter</a>";					
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
										$pagination.= "<a href=\"$targetpage?id=$albumId&page=$counter\">$counter</a>";					
								}
								$pagination.= "...";
								$pagination.= "<a href=\"$targetpage?id=$albumId&page=$lpm1\">$lpm1</a>";
								$pagination.= "<a href=\"$targetpage?id=$albumId&page=$lastpage\">$lastpage</a>";		
							}
							//in middle; hide some front and some back
							elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
							{
								$pagination.= "<a href=\"$targetpage?id=$albumId&page=1\">1</a>";
								$pagination.= "<a href=\"$targetpage?id=$albumId&page=2\">2</a>";
								$pagination.= "...";
								for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
								{
									if ($counter == $page)
										$pagination.= "<span class=\"current\">$counter</span>";
									else
										$pagination.= "<a href=\"$targetpage?id=$albumId&page=$counter\">$counter</a>";					
								}
								$pagination.= "...";
								$pagination.= "<a href=\"$targetpage?id=$albumId&page=$lpm1\">$lpm1</a>";
								$pagination.= "<a href=\"$targetpage?id=$albumId&page=$lastpage\">$lastpage</a>";		
							}
							//close to end; only hide early pages
							else
							{
								$pagination.= "<a href=\"$targetpage?id=$albumId&page=1\">1</a>";
								$pagination.= "<a href=\"$targetpage?id=$albumId&page=2\">2</a>";
								$pagination.= "...";
								for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
								{
									if ($counter == $page)
										$pagination.= "<span class=\"current\">$counter</span>";
									else
										$pagination.= "<a href=\"$targetpage?id=$albumId&page=$counter\">$counter</a>";					
								}
							}
						}
						
						//next button
						if ($page < $counter - 1){
							$pagination.= "<a href=\"$targetpage?id=$albumId&page=$next\">Next »</a>";
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
					$video['creation_date'] = date_format(new DateTime($video['creation_date']), 'U');
					$video['thumbnails_path'] = empty($video['thumbnails_path']) ? $this->ctx() . '/images/icon-video.gif' : ($this->ctx() . $this->loadResources('image.upload.path') . $video['thumbnails_path']);
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
			
			$this->assign('albumId', $albumId);
			
			//var_dump($_SERVER);
			//$this->userVideoMessagesSource();
			//krumo($videos);
			$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_index');
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
			}		
			$this->assign("menuMyAlbum", $this->loadMessages('album.menu.myalbum.link'));
			$this->assign("menubasicinfoAlbum", $this->loadMessages('album.menu.basicinfo.link'));
			$this->assign("menuthumbnailAlbum", $this->loadMessages('album.menu.thumbnail.link'));
			$this->assign("menuarrangeAlbum", $this->loadMessages('album.menu.arrange.link'));
			$this->assign("menupasswordAlbum", $this->loadMessages('album.menu.password.link'));
			$this->assign("menudeleteAlbum", $this->loadMessages('album.menu.delete.link'));
			$this->assign("menubackAlbum", $this->loadMessages('album.menu.back.link'));
			$this->assign("videoId", $_GET["videoId"]);
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
				$this->model_album->addNewAlbum(array($userId,$albumName,$description));
				$this->assign("successMessage",$this->loadMessages('album.create.successful'));
//				$this->assign('title_',$albumName);
//				$this->assign('description_',$description);
				$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_createnewalbum');
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
				$this->model_album->updateAlbumTileByAlbumId(array($albumName,$albumId));
				$this->model_album->updateAlbumDescriptionByAlbumId(array($albumDescription,$albumId));
				$this->assign('successMessage',$this->loadMessages('album.albumsetting.successful'));
				$this->assign('description_',$albumDescription);
				$this->assign('title_',$albumName);
				$this->assign('albumId',$albumId);
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
				if($res==0)
				{
					$this->assign('error', $this->loadErrorMessage('error.albumthumbnail.error'));
				}
				$this->assign("albumThumbnail",$album['thumbnails_path']);
				$this->assign("albumName",$album['album_name']);
				$this->assign("albumId",$albumId);
				$this->assign("videoThumbnails",$videoThumbnails);
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
				$this->assign("albumThumbnail",$album['thumbnails_path']);
				$this->assign("albumName",$album['album_name']);
				$this->assign('albumId',$albumId);
				$this->assign('succeesMessage',$this->loadMessages('album.albumthumbnail.success'));
				$this->assign("videoThumbnails",$videoThumbnails);
				$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_albumthumbnail');
			}
			
			
		}
		
	}
	
?>
