<?php
	define("CHANNEL_TEMPLATE_DIR","channel/");
	
	/**
	 * 
	 * Channel controller
	 * @author Tri
	 *
	 */
	class Channel extends Application
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
		function indexMessagesSource(){
			$this->defaultChannelMessagesSource();
			$this->assign('title', $this->loadMessages('channel.index.title'));
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
				$channelId = $_GET['channelId'];
			}
			
			if(!ctype_digit($channelId)){
				$error_flag = true;
				$this->loadTemplate('view_404');
				return;
			}
		
			$this->loadModel('model_channel');
			$model_channel = $this->model_channel;
			$channel = $model_channel->getChannelbyChannelId(array($channelId));
			
			if(!$channel){
				$error_flag = true;
				$this->loadTemplate('view_404');
				return;
			}
			
			$_search_obj = unserialize($_SESSION['CHANNEL_SEARCH']);
			
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
			//$_reset = $_GET['reset'];// reset all value for display
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
				
				$_sort_mode = $channel['arrange'] ? $channel['arrange'] : $_default_sort_mode;

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
				$this->redirect($this->ctx() . '/channel/?channelId=' . $channelId);
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
			$_SESSION['CHANNEL_SEARCH'] = serialize($_search_obj);
			
			$this->loadModel('model_video');
			$model_video = $this->model_video;
			$video_count = $model_video->countVideoByChannelId($channelId, $limit, $offset, $_search_term, $sort_column, $sort_order);
			if($video_count > 0){
				if($limit > 0){
					if($limit && ($page > ceil($video_count / $limit))){
						$this->redirect($this->ctx() . '/channel/?channelId=' . $channelId);
					}
					$videos = $model_video->selectVideoByChannelId($channelId, $limit, $offset, $_search_term, $sort_column, $sort_order);
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
							$pagination.= "<a href=\"$targetpage?channelId=$channelId&page=$prev\">« Previous</a>";
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
									$pagination.= "<a href=\"$targetpage?channelId=$channelId&page=$counter\">$counter</a>";					
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
										$pagination.= "<a href=\"$targetpage?channelId=$channelId&page=$counter\">$counter</a>";					
								}
								$pagination.= "...";
								$pagination.= "<a href=\"$targetpage?channelId=$channelId&page=$lpm1\">$lpm1</a>";
								$pagination.= "<a href=\"$targetpage?channelId=$channelId&page=$lastpage\">$lastpage</a>";		
							}
							//in middle; hide some front and some back
							elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
							{
								$pagination.= "<a href=\"$targetpage?channelId=$channelId&page=1\">1</a>";
								$pagination.= "<a href=\"$targetpage?channelId=$channelId&page=2\">2</a>";
								$pagination.= "...";
								for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
								{
									if ($counter == $page)
										$pagination.= "<span class=\"current\">$counter</span>";
									else
										$pagination.= "<a href=\"$targetpage?channelId=$channelId&page=$counter\">$counter</a>";					
								}
								$pagination.= "...";
								$pagination.= "<a href=\"$targetpage?channelId=$channelId&page=$lpm1\">$lpm1</a>";
								$pagination.= "<a href=\"$targetpage?channelId=$channelId&page=$lastpage\">$lastpage</a>";		
							}
							//close to end; only hide early pages
							else
							{
								$pagination.= "<a href=\"$targetpage?channelId=$channelId&page=1\">1</a>";
								$pagination.= "<a href=\"$targetpage?channelId=$channelId&page=2\">2</a>";
								$pagination.= "...";
								for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
								{
									if ($counter == $page)
										$pagination.= "<span class=\"current\">$counter</span>";
									else
										$pagination.= "<a href=\"$targetpage?channelId=$channelId&page=$counter\">$counter</a>";					
								}
							}
						}
						
						//next button
						if ($page < $counter - 1){
							$pagination.= "<a href=\"$targetpage?channelId=$channelId&page=$next\">Next »</a>";
						}else{
							$pagination.= "<span class=\"disabled\">Next »</span>";
						}
						$pagination.= "</div>\n";		
					}
				}else{
					$videos = $model_video->selectVideoByChannelId($channelId, $limit, $offset, $_search_term, $sort_column, $sort_order);
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
			
			$this->assign('channelId', $channelId);
			$this->assign('channel_name', $channel['channel_name']);
			$this->assign('show_user_avatar', 1);
			
			$this->indexMessagesSource();
			$this->loadTemplate(CHANNEL_TEMPLATE_DIR.'view_channel_index');
		}
		/** 
		 * Load messages source for all Channel features
		 * 
		 */
		function defaultChannelMessagesSource()
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
			$this->assign("menuChannel", $this->loadMessages('channel.menu.channelpage.link'));
			$this->assign("menuBackToChannel", $this->loadMessages('channel.menu.channelback.link'));
			$this->assign("menuchannelsetting", $this->loadMessages('channel.menu.channelsetting.link'));
			$this->assign("menuchannelthumbnail", $this->loadMessages('channel.menu.channelthumbnail.link'));
			$this->assign("menuchanneladdto", $this->loadMessages('channel.menu.channeladdto.link'));
			$this->assign("menuchannelarrange", $this->loadMessages('channel.menu.channelarrange.link'));
			$this->assign("menuchanneldelete", $this->loadMessages('channel.menu.channeldelete.link'));
			$this->assign("menuchannelcreate", $this->loadMessages('channel.menu.channelcreate.link'));
			$this->assign("videoId", $_GET["videoId"]);
			$this->assign("albumId", $_GET["albumId"]);
		}
		/**	
		 * Load defaul create new channel page
		 * 
		 */
		function createNewChannelMessagesSource()
		{
			$this->defaultChannelMessagesSource();
			
			$this->assign("name", $this->loadMessages('channel.create.name'));
			$this->assign("title", $this->loadMessages('channel.create.title'));
			$this->assign('description', $this->loadMessages('channel.create.description'));
			$this->assign('hint', $this->loadMessages('channel.create.hint'));
			
			$this->assign('errorDescription', $this->loadErrorMessage('error.channel.create.description'));
			$this->assign('show_user_avatar', 1);
		}
		/**
		 * Load and action create new channel 
		 * 
		 */
		
		function createNewChannel()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_channel');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{						
				$this->loadTemplate(CHANNEL_TEMPLATE_DIR.'view_channel_createnewchannel');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$channelName=$_POST['title'];
				$description=$_POST['description'];
				$channelId = $this->model_channel->addNewChannel(array($userId,$channelName,$description));
				$this->redirect($this->ctx().'/channel/?channelId='.$channelId);
			}
		}
		/**
		 * Load defaul channel basic info page
		 * 
		 */
		function channelSettingMessagesSource()
		{
			$this->defaultChannelMessagesSource();
			
			$this->assign("name", $this->loadMessages('channel.setting.name'));
			$this->assign("title", $this->loadMessages('channel.setting.title'));
			$this->assign('description', $this->loadMessages('channel.setting.description'));
			$this->assign('hint', $this->loadMessages('channel.setting.hint'));
			
			$this->assign('errorDescription', $this->loadErrorMessage('error.channel.create.description'));
		}
		/**
		 * Load and action channel basic info page
		 * 
		 */
		function channelSetting()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_channel');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$channelId=$_GET['channelId'];
				$channel = $this->model_channel->getChannelbyChannelId(array($channelId));
				$this->assign("channelId",$channelId);
				$this->assign("description_",$channel['description']);
				$this->assign("title_",$channel['channel_name']);
				$this->loadTemplate(CHANNEL_TEMPLATE_DIR.'view_channel_channelsetting');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$channelDescription=$_POST['description'];
				$channelName=$_POST['title'];
				$channelId=$_POST['channelId'];
				$this->model_channel->updateChannelTileByChannelId(array($channelName,$channelId));
				$this->model_channel->updateChannelDescriptionByChannelId(array($channelDescription,$channelId));
				$channel=$this->model_channel->getChannelbyChannelId(array($channelId));
				$this->assign('successMessage',$this->loadMessages('channel.setting.successful'));
				$this->assign('description_',$channelDescription);
				$this->assign('title_',$channelName);
				$this->assign('channelId',$channelId);
				$this->loadTemplate(CHANNEL_TEMPLATE_DIR.'view_channel_channelsetting');
			}
			
		}
		/**
		 * Load defaul channel delete page
		 * 
		 */
		function channelDeleteMessagesSource()
		{
			$this->defaultChannelMessagesSource();
			
			$this->assign("name", $this->loadMessages('channel.delete.name'));
			$this->assign('question', $this->loadMessages('channel.delete.question'));
			$this->assign('hint', $this->loadMessages('channel.delete.hint'));
			
			$this->assign('errorDescription', $this->loadErrorMessage('error.channel.create.description'));
		}
		
		/**
		 * Load defaul and action for channel delete page
		 * 
		 */
		function channelDelete()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_channel');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$channelId=$_GET['channelId'];
				$channel = $this->model_channel->getChannelbyChannelId(array($channelId));
				$this->assign("channelId",$channelId);
				$this->assign("title",$channel['channel_name']);
				$this->loadTemplate(CHANNEL_TEMPLATE_DIR.'view_channel_channeldelete');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$channelId=$_POST['channelId'];
				$channel = $this->model_channel->getChannelbyChannelId(array($channelId));
				$this->assign("channelId",$channelId);
				$this->assign("title",$channel['channel_name']);
				$this->model_channel->dropChannelByChannelId(array($channelId));
				$this->model_channel->dropChannelVideoByChannelId(array($channelId));
				$this->redirect($this->ctx().'/user/album/albumsetting');
			}
		}
		/**
		 * Load defaul channel Thumbnail page
		 * 
		 */
		
		function channelThumbnailMessagesSource()
		{
			$this->defaultChannelMessagesSource();
			
			$this->assign("name", $this->loadMessages('channel.thumbnail.name'));
			$this->assign("choose", $this->loadMessages('channel.thumbnail.choose'));
			$this->assign('hint', $this->loadMessages('channel.thumbnail.hint'));
			
		}
		/**
		 * Load and action channel Thumbnail page
		 */
		
		function channelThumbnail()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_channel');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$channelId=$_GET['channelId'];
				$videoThumbnails=$this->model_channel->getVideoThumbnailsByChannelId(array($channelId,$userId));
				$channel = $this->model_channel->getChannelbyChannelId(array($channelId));
				$res=$this->model_channel->getVideoIdByChannelId(array($channelId));
				if($res==0)
				{
					$this->assign('error', $this->loadErrorMessage('error.albumthumbnail.error'));
				}
				$this->assign("channelThumbnail",$channel['thumbnails_path']);
				$this->assign("channelId",$channelId);
				$this->assign("channelName",$channel['channel_name']);
				$this->assign("videoThumbnails",$videoThumbnails);
				$this->loadTemplate(CHANNEL_TEMPLATE_DIR.'view_channel_channelthumbnail');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$channelId=$_POST['channelId'];
				$radioChecked=$_POST['videoThumbnail'];
				$this->model_channel->updateVideoThumbnailToChannelThumbnail(array($radioChecked,$channelId));
				$videoThumbnails=$this->model_channel->getVideoThumbnailsByChannelId(array($channelId,$userId));
				$res=$this->model_channel->getVideoIdByChannelId(array($channelId));
				if($res==0)
				{
					$this->assign('error', $this->loadErrorMessage('error.albumthumbnail.error'));
				}
				$channel = $this->model_channel->getChannelbyChannelId(array($channelId));
				$this->assign("channelId",$channelId);
				$this->assign("channelName",$channel['channel_name']);
				$this->assign('succeesMessage',$this->loadMessages('channel.thumbnail.success'));
				$this->assign("videoThumbnails",$videoThumbnails);
				$this->assign("channelThumbnail",$channel['thumbnails_path']);
				$this->loadTemplate(CHANNEL_TEMPLATE_DIR.'view_channel_channelthumbnail');
			}
		}
		
		function assignChannelThumbnails($channel){
			if($channel){
				$channelThumbnail = empty($channel['thumbnails_path']) ? '' : $this->loadResources('image.upload.path').$channel['thumbnails_path'];
				$this->assign("channelThumbnail", $channelThumbnail);
			}
		}
		
		/**
		 * Load defaul arrange page
		 * 
		 */
		function arrangeMessagesSource(){
			$this->defaultChannelMessagesSource();
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
				$channelId = $_GET['channelId'];
				
				if(!ctype_digit($channelId)){
					$error_flag = true;
					$this->loadTemplate('view_404');
					return;
				}
				

				$this->loadModel('model_channel');
				$model_channel = $this->model_channel;
				$channel = $model_channel->getChannelbyChannelId(array($channelId));
				
				//validate channel owner
				if(!$channel){
					$error_flag = true;
					$this->loadTemplate('view_404');
					return;
				}

				if($channel['user_id'] != $userId){
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
				$sort_mode = $channel['arrange'] ? $channel['arrange'] : $default_sort_mode;
				$sort_column = $_sort_columns[$sort_mode];
				$sort_order = $_sort_orders[$sort_mode];
				
				$videos = $model_video->selectVideoByChannelId($channelId, 5, 0, '', $sort_column, $sort_order);
				
				if(is_array($videos) && (count($videos) > 0)){
					$this->assign('video_count', count($videos));
					foreach($videos as &$video){
						$video['thumbnails_path'] = empty($video['thumbnails_path']) ? $this->ctx() . '/images/icon-video.gif' : ($this->ctx() . $this->loadResources('image.upload.path') . $video['thumbnails_path']);
					}
				}else{
					$this->assign('message', $this->loadMessages('channel.arrange.no_video'));
					$this->assign('video_count', 0);
				}
				
				$this->assignChannelThumbnails($channel);
				$this->assign('videos', $videos);
				$this->assign('sort_modes', $_sort_modes);
				$this->assign('sort_mode', $sort_mode);
				$this->assign('channelId', $channelId);
				$this->assign('hint', $this->loadMessages('channel.arrange.hint'));
				$this->assign('title', $this->loadMessages('channel.arrange.title'));
				$this->assign('channel_title', $channel['channel_name']);
				
				$this->loadTemplate(CHANNEL_TEMPLATE_DIR.'view_channel_arrange');
			}elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
				if((!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')){
					$channelId = $_POST['channelId'];

					//validate channel id here

					$this->loadModel('model_channel');
					$model_channel = $this->model_channel;
					$channel = $model_channel->getChannelbyChannelId(array($channelId));

					//validate channel owner here

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
					
					$videos = $model_video->selectVideoByChannelId($channelId, 5, 0, '', $sort_column, $sort_order);
					
					if(is_array($videos) && (count($videos) > 0)){
						foreach($videos as &$video){
							$video['thumbnails_path'] = empty($video['thumbnails_path']) ? $this->ctx() . '/images/icon-video.gif' : ($this->ctx() . $this->loadResources('image.upload.path') . $video['thumbnails_path']);
						}
					}
					
					$this->assign('videos', $videos);
					$this->assign('sort_modes', $_sort_modes);
					$this->assign('sort_mode', $sort_mode);
					$this->assign('channel_id', $channelId);
					
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
					$channelId = $_GET['channelId'];
					
					if(!ctype_digit($channelId)){
						$error_flag = true;
						$this->loadTemplate('view_404');
						return;
					}
					

					$this->loadModel('model_channel');
					$model_channel = $this->model_channel;
					$channel = $model_channel->getChannelbyChannelId(array($channelId));
					
					//validate channel owner
					if(!$channel){
						$error_flag = true;
						$this->loadTemplate('view_404');
						return;
					}

					if($channel['user_id'] != $userId){
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

					if($sort_mode != $channel['arrange']){
						if(array_key_exists($sort_mode, $_sort_modes)){
							if($model_channel->updateChannelArrangeByChannelId(array($sort_mode, $channelId))){
								$this->assign('successMessage', $this->loadMessages('channel.arrange.success'));
							}else{
								$this->assign('errorMessage', 'a'.$this->loadErrorMessage('error.channel.arrange'));
								$error_flag = true;
							}
						}else{
							$this->assign('errorMessage', $this->loadErrorMessage('error.channel.arrange.invalid_sort_mode'));
							$sort_mode = $channel['arrange'] ? $channel['arrange'] : $default_sort_mode;
							$error_flag = true;
						}
					}else{
						$this->assign('successMessage', $this->loadMessages('channel.arrange.success'));
					}
					
					$sort_column = $_sort_columns[$sort_mode];
					$sort_order = $_sort_orders[$sort_mode];
					
					$videos = $model_video->selectVideoByChannelId($channelId, 5, 0, '', $sort_column, $sort_order);
					
					if(is_array($videos) && (count($videos) > 0)){
						$this->assign('video_count', count($videos));
						foreach($videos as &$video){
							$video['thumbnails_path'] = empty($video['thumbnails_path']) ? $this->ctx() . '/images/icon-video.gif' : ($this->ctx() . $this->loadResources('image.upload.path') . $video['thumbnails_path']);
						}
					}else{
						$this->assign('message', $this->loadMessages('channel.arrange.no_video'));
						$this->assign('video_count', 0);
					}
					
					$this->assign('videos', $videos);
					$this->assign('sort_modes', $_sort_modes);
					$this->assign('sort_mode', $sort_mode);
					$this->assign('channelId', $channelId);
					$this->assign('hint', $this->loadMessages('channel.arrange.hint'));
					$this->assign('title', $this->loadMessages('channel.arrange.title'));
					$this->assign('channel_title', $channel['channel_name']);
					$this->assignChannelThumbnails($channel);
					$this->loadTemplate(CHANNEL_TEMPLATE_DIR.'view_channel_arrange');
				}
			}
		}
	}

?>
