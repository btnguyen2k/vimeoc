<?php 
	define("VIDEO_TEMPLATE_DIR", "video/");
	include (BASE_DIR . '/application/uploader.php');
		
	/**
	 * 
	 * Video controller
	 * @author Tri
	 *
	 */
	class Video extends Application
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
		 * Load messages source for all user features
		 * 
		 */
		function defaultVideoMessagesSource()
		{
			$userId = $this->getLoggedUser();
			if($userId > 0)
			{
				$this->loadModel('model_user');
				$user = $this->model_user->getUserByUserId($userId);
				$this->assign('userAvatar', $user['avatar']);
				$this->assign('show_user_avatar', 1);
				
				$videoId = $_GET["videoId"];
				if(!empty($videoId)){
					$model_video = $this->getModel('model_video');
					$video = $model_video->getVideoById($videoId);
					if($video == null || ($video['user_id'] != $userId)){
						$this->assign("owner", false);
					}else{
						$this->assign("owner", true);
					}
				}else{
					$this->assign("owner", true);
				}
			}
			
			$this->assign("videobasicinfo", $this->loadMessages('user.video.link.basicinfo'));
			$this->assign("videothumbnail", $this->loadMessages('user.video.link.thumbnail'));
			$this->assign("videovideofile", $this->loadMessages('user.video.link.videofile'));
			$this->assign("videocustomurl", $this->loadMessages('user.video.link.customurl'));
			$this->assign("videoaddto", $this->loadMessages('user.video.link.addto'));
			$this->assign("videoaddtochannel", $this->loadMessages('user.video.link.addtochannel'));
			$this->assign("videodelete", $this->loadMessages('user.video.link.delete'));
			$this->assign("videobacktovideo", $this->loadMessages('user.video.link.backtovideo'));
			$this->assign("videopreandpost", $this->loadMessages('user.video.link.preandpostroll'));
			$this->assign("videopage", $this->loadMessages('user.video.link.playvideo'));
			$this->assign("videoId", $_GET["videoId"]);
			$this->assign("requiredFields", $this->loadErrorMessage('error.field.required'));
		}
		
		function assignVideoThumbnails($video){
			if($video){
				$videoThumbnail = empty($video['thumbnails_path']) ? '' : $this->loadResources('image.upload.path').$video['thumbnails_path'];
				$this->assign("videoThumbnail", $videoThumbnail);
			}
		}
		/**
		 * Load messages source for videosetting page
		 * 
		 */
		
		function videoSettingMessagesSource()
		{
			$this->defaultVideoMessagesSource();
			
			$this->assign("name", $this->loadMessages('user.videosetting.name'));
			$this->assign("title", $this->loadMessages('user.videosetting.title'));
			$this->assign('description', $this->loadMessages('user.videosetting.description'));
			$this->assign('tag', $this->loadMessages('user.videosetting.tags'));
			$this->assign('hint', $this->loadMessages('user.videosetting.hint'));

			$this->assign('titleiInvalid', $this->loadErrorMessage('error.video.title'));
			$this->assign('descriptionInvalid', $this->loadErrorMessage('error.video.description'));
			$this->assign('tagInvalid', $this->loadErrorMessage('error.video.tag'));
		}
		
		/**
		 *view and action for videosetting form 
		 *
		 */
		
		function videoSetting()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			
			$this->loadModel('model_video');	
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$videoid=$_GET['videoId'];
				$tcid=$_GET['videoId'];
				$tagid=$_GET['tagid'];
				
				$tags=$this->model_video->getTagfromTagandTagcomponent(array($tcid));
				$video= $this->model_video->getVideofromVideoId(array($videoid));
				if($video==null)
				{
					$this->loadTemplate('view_404');
					return;
				}else{
					if($video['user_id'] != $userId){
						$this->loadTemplate('view_access_denied');
						return;	
					}
				}
				$strTags="";
				for($i=0;$i<sizeof($tags);$i++)
				{
					$strTags .= $tags[$i]['name'] . ',' ; 
				}
				$strTags = substr($strTags, 0, -1); 
				$this->assign('title_', $video['video_title']);
				$this->assign('description_', $video['description']);
				$this->assign('tag_', $strTags);
				$this->assign('tcid', $tcid);
				$this->assign('hiddenvideo',$videoid);
				$this->assignVideoThumbnails($video);
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_video_videosetting');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$videoTitle=$_POST['title'];
				$description=$_POST['description'];
				$tag=$_POST['tag'];
				$slipTag=split(',', $tag);
				$videoid=$_POST['videoid'];
				$tagid=$_POST['tagid'];
				$tcid=$_POST['tcid'];
				
				$ret=$this->model_video->isExistVideoId(array($videoid));
				if($ret)
				{
					$video= $this->model_video->getVideofromVideoId(array($videoid));
					if($video['user_id'] != $userId){
						$this->loadTemplate('view_access_denied');
						return;	
					}
					
					$this->model_video->deleteAllTagComponentsByVideoId(array(COMPONENT_VIDEO_TYPE,$videoid));
				}else{
					$this->loadTemplate('view_404');
					return;
				}
				
				for($j=0;$j<sizeof($slipTag);$j++)
				{				
					if($slipTag[$j]!="")
					{
						$checkTag=$this->model_video->isTagExist(array($slipTag[$j]));
						if($checkTag==0)
						{
							$this->model_video->addTagName(array($slipTag[$j]));			
							$tagNewId=$this->model_video->getTagIdByName(array($slipTag[$j]));
							//$this->model_video->deleteTagIdAndComponentId(array($tagNewId[0]["id"],$videoid));
							$this->model_video->addTagIdAndComponentId(array($tagNewId[0]["id"],COMPONENT_VIDEO_TYPE,$videoid));
						}
						else 
						{
							$tagNewId=$this->model_video->getTagIdByName(array($slipTag[$j]));
							$res=$this->model_video->checkIdAndComponentId(array($tagNewId[0]["id"],$videoid));
							if($res==0)
							{
								$this->assign('successMessage', $this->loadMessages('user.videosetting.updatesuccess'));
								//$this->model_video->deleteTagIdAndComponentId(array($tagNewId[0]["id"],$videoid));
								$this->model_video->addTagIdAndComponentId(array($tagNewId[0]["id"],COMPONENT_VIDEO_TYPE,$videoid));
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
				$this->assign('tcid', $tcid);
				$this->assign('hiddenvideo',$videoid);
				$this->assign('title_', $video['video_title']);
				$this->assign('description_', $video['description']);
				$this->assign('tag_', $strTags);
				$this->assignVideoThumbnails($video);
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_video_videosetting');
			}
		}
		/**
		 *  Load messages source for video_addtopage
		 * 
		 */
		
		function addToPageMessagesSource()
		{
			$this->defaultVideoMessagesSource();
			
			$this->assign("add", $this->loadMessages('video.addtopage.addtialbum'));
			$this->assign("title", $this->loadMessages('video.addtopage.title'));
			$this->assign("hint", $this->loadMessages('video.addtopage.hint'));
			
		}
		
		/**
		 * view and action for video_addtopage
		 */
		function addToPage()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_video');
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$videoid=$_GET['videoId'];
				if(!$videoid){
					$this->redirect($this->ctx().'/user/home');
					return;
				}
				$albums= $this->model_video->getAlbumByUserId(array($userId));
				$video=$this->model_video->getVideoByVideoId(array($videoid));
				if($video == null)
				{
					$this->loadTemplate('view_404');
					return;
				}else{
					if($video['user_id'] != $userId){
						$this->loadTemplate('view_access_denied');
						return;	
					}
				}
				
				$albumIds=$this->model_video->getAlbumIdByVideoIdWithoutJoin(array($videoid));
				$str="";
				for($i=0;$i<sizeof($albumIds);$i++)
				{
					$str .= $albumIds[$i]['album_id'] . ',';
				}
				$this->assign("videoid",$videoid);
				$this->assign("checkedAlbums",$str);
				$this->assign("video",$video['video_title']);
				$this->assign("albums",$albums);
				$this->assignVideoThumbnails($video);
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_video_addtopage');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$videoid=$_POST['videoid'];
				$albumid=$_POST["album_id"];
				$mAlbumId = split(',', $albumid);
				$albumUncheck = $_POST["albumUncheck"];
				$mAlbumUncheck = split(',', $albumUncheck);
				$res=$this->model_video->isExistVideoId(array($videoid));
				if($res==0)
				{
					$this->loadTemplate('view_404');
					return;
				}else{
					$video=$this->model_video->getVideoByVideoId(array($videoid));
					if($video['user_id'] != $userId){
						$this->loadTemplate('view_access_denied');
						return;	
					}
				}
				for($j=0;$j<sizeof($mAlbumUncheck);$j++)
				{
					$this->model_video->dropAlbumIdAndVideoId(array($mAlbumUncheck[$j],$videoid));	
					$this->assign('successMessage', $this->loadMessages('video.addtopage.successful'));			
				}
				for($i=0;$i<sizeof($mAlbumId);$i++)
				{
					if($mAlbumId[$i]!="")
					{
						if ($this->model_video->isExist(array($mAlbumId[$i],$videoid)) == true)
						{
							$this->assign("errorMessage", $this->loadMessages('video.addtopage.error'));
						}
						else 
						{
							$this->model_video->addVideoToAlBum(array($mAlbumId[$i],$videoid));
							$this->assign('successMessage', $this->loadMessages('video.addtopage.successful'));
						}
					}
				}
				$albums= $this->model_video->getAlbumByUserId(array($userId));
				$video=$this->model_video->getVideoByVideoId(array($videoid));
				$this->assign("videoid",$videoid);
				$this->assign("checkedAlbums",$albumid);
				$this->assign("video",$video['video_title']);
				$this->assign("albums",$albums);
				$this->assignVideoThumbnails($video);
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_video_addtopage');
			}
		}
		
		/**
		 * Load messages sourse for Addtochannel
		 * 
		 */
		function addToChannelMessagesSource()
		{
			$this->defaultVideoMessagesSource();
			
			$this->assign("add", $this->loadMessages('video.addtochannel.add'));
			$this->assign("title", $this->loadMessages('video.addtochannel.title'));
			$this->assign("hint", $this->loadMessages('video.addtochannel.hint'));
			
		}
		/**
		 *  view and action for video_addtopage
		 */
		function addToChannel()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_video');
			$this->loadModel('model_channel');
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$videoId=$_GET['videoId'];
				if(!$videoId){
					$this->redirect($this->ctx().'/user/home');
					return;
				}
				$video=$this->model_video->getVideoByVideoId(array($videoId));
				if($video==null)
				{
					$this->loadTemplate('view_404');
					return;
				}else if($video['user_id'] != $userId){
					$this->loadTemplate('view_access_denied');
					return;
				}
				$channel= $this->model_video->getChannelByUserId(array($userId));
				$otherChannel=$this->model_channel->getChannelOfOther(array($userId));
				$channelIds=$this->model_video->getChannelIdByVideoIdWithoutJoin(array($videoId));
				$str="";
				for($i=0;$i<sizeof($channelIds);$i++)
				{
					$str .= $channelIds[$i]['channel_id'] . ',';
				}
				$this->assign("videoId",$videoId);
				$this->assign("checkedChannels",$str);
				$this->assign("video",$video['video_title']);
				$this->assign("channel",$channel);
				$this->assign("otherChannel",$otherChannel);
				$this->assignVideoThumbnails($video);
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_video_addtochannel');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$videoId=$_POST['videoId'];
				$channelId=$_POST["channelId"];
				$mChannelId = split(',', $channelId);
				$channelUncheck = $_POST["channelUncheck"];
				$mChannelUncheck = split(',', $channelUncheck);
				$res=$this->model_video->isExistVideoId(array($videoId));
				if($res==0)
				{
					$this->loadTemplate('view_404');
					return;
				}else{
					$video=$this->model_video->getVideoByVideoId(array($videoId));
					if($video['user_id'] != $userId){
						$this->loadTemplate('view_access_denied');
						return;
					}
				}
				for($j=0;$j<sizeof($mChannelUncheck);$j++)
				{
					$this->model_video->dropChannelIdAndVideoId(array($mChannelUncheck[$j],$videoId));				
				}
				for($i=0;$i<sizeof($mChannelId);$i++)
				{
					if($mChannelId[$i]!="")
					{
						if ($this->model_video->isChannelExist(array($mChannelId[$i],$videoId)) == true)
						{
							$this->assign("errorMessage", $this->loadMessages('video.addtopage.error'));
						}
						else 
						{
							$this->model_video->addVideoToChannel(array($mChannelId[$i],$videoId));
							$this->assign('successMessage', $this->loadMessages('video.addtopage.successful'));
						}
					}
				}
				$channel= $this->model_video->getChannelByUserId(array($userId));
				$otherChannel=$this->model_channel->getChannelOfOther(array($userId));
				$video=$this->model_video->getVideoByVideoId(array($videoId));
				$this->assign("videoId",$videoId);
				$this->assign("checkedChannels",$channelId);
				$this->assign("video",$video['video_title']);
				$this->assign("channel",$channel);
				$this->assign("otherChannel",$otherChannel);
				$this->assignVideoThumbnails($video);
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_video_addtochannel');
			}
			
		}

		/**
		 * Load messages source for preAndPostRoll
		 * 
		 */
		
		function preAndPostRollMessagesSource()
		{
			$this->defaultVideoMessagesSource();
			
			$this->assign("title", $this->loadMessages('video.preandpostroll.title'));
			$this->assign("PreRoll", $this->loadMessages('video.preandpostroll.preroll'));
			$this->assign("PostRoll", $this->loadMessages('video.preandpostroll.postroll'));
			$this->assign("hint", $this->loadMessages('video.preandpostroll.hint'));
			
		}

		
		/**
		 * View and action for preAndPostRoll
		 * 
		 */
		function preAndPostRoll()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_video');
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$videoid=$_GET['videoId'];				
				$res=$this->model_video->isExistVideoId(array($videoid));
				if($res==0)
				{
					$this->loadTemplate('view_404');
					return;
				}else{
					$video=$this->model_video->getVideoByVideoId(array($videoid));
					if($video['user_id'] != $userId){
						$this->loadTemplate('view_access_denied');
						return;
					}
				}
				$video2 = $this->model_video->getVideoByVideoId(array($videoid));
				$this->assign("getpreRoll",$video2[pre_roll]);
				$this->assign("getpostRoll",$video2[post_roll]);
				$this->assign("videoid",$videoid);
				$this->assign("video",$video2[video_title]);
				$this->assignVideoThumbnails($video2);
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_video_preandpostroll');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$preRoll=$_POST['hpreroll'];
				$postRoll=$_POST['hpostroll'];
				$videoid=$_POST['videoid'];
				$res=$this->model_video->isExistVideoId(array($videoid));
				if($res==0)
				{
					$this->loadTemplate('view_404');
					return;
				}else{
					$video=$this->model_video->getVideoByVideoId(array($videoid));
					if($video['user_id'] != $userId){
						$this->loadTemplate('view_access_denied');
						return;
					}
				}
				$this->model_video->updatePre_roll(array($preRoll,$videoid,$userId));
				$this->model_video->updatePost_roll(array($postRoll,$videoid,$userId));				
				$this->assign("successMessage", $this->loadMessages('video.preandpostroll.successful'));
				
				$video = $this->model_video->getVideoByVideoIdAndUserId(array($userId,$videoid));
				$video2 = $this->model_video->getVideoByVideoId(array($videoid));
				$this->assign("getpreRoll",$video2[pre_roll]);
				$this->assign("getpostRoll",$video2[post_roll]);
				$this->assign("video",$video[video_title]);
				$this->assign("videoid",$videoid);
				$this->assignVideoThumbnails($video2);
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_video_preandpostroll');
			}
		}
		/**
		 * Load messages source for customUrl page
		 * 
		 */
		
		function customUrlMessagesSource()
		{
			$this->defaultVideoMessagesSource();
			$this->assign("title", $this->loadMessages('video.customurl.title'));
			$this->assign("chooseYourCustomUrl", $this->loadMessages('video.customurl.chooseYourCustomUrl'));
			$this->assign("message_invalid_url", $this->loadMessages('video.customurl.invalidUrl'));
			$this->assign("message_url_hint", $this->loadMessages('video.customurl.hint'));
		}
		/**
		 * View and action for video custom url
		 * 
		 */
		function customUrl()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0){
				$this->redirect($this->ctx() . '/auth/login/');
				return;
			}
			$this->loadModel('model_video');
			$model_video = $this->model_video;

			$this->loadModel('model_user');
			$model_user = $this->model_user;
			
			$this->loadModel('model_album');
			$model_album = $this->model_album;
			
			$user = $model_user->getUserByUserId(array($userId));
			
			if ($_SERVER['REQUEST_METHOD'] == 'GET'){
				$videoId = $_GET['videoId'];
				if(!$videoId){
					$this->redirect($this->ctx() . '/user/video/');
					return;
				}
				$res=$this->model_video->isExistVideoId(array($videoId));
				$video = $model_video->getVideoById($videoId);
				if($res==0)
				{
					$this->loadTemplate('view_404');
					return;
				}else{
					if($video['user_id'] != $userId){
						$this->loadTemplate('view_access_denied');
						return;	
					}	
				}
				
				$this->assign('user_alias', $user['profile_alias'] ? $user['profile_alias'] : 'user' . $user['id']);
				$this->assign('video_alias', $video['video_alias']);
				$this->assignVideoThumbnails($video);
				$this->assign('videoId', $video['video_id']);
				$this->assign('videoTitle', $video['video_title']);
				$this->assign("domain", BASE_PATH . CONTEXT);
				
				if(!$video['video_alias']){
					$userAlias = empty($user['profile_alias']) ? 'user'.$user['id'] : $user['profile_alias'];
					$previewLink = BASE_PATH . CONTEXT . "/" . $userAlias . '/' . $video['video_id'];
				}else{
					$previewLink = BASE_PATH . CONTEXT . "/" . ($user['profile_alias'] ? $user['profile_alias'] : 'user' . $user['id']) .  "/" . $video['video_alias'];
				}
				$this->assign("previewUrl", $previewLink);
				
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_video_custom_url');
			}else if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$videoId = $_POST['videoId'];
				$url_alias = $_POST['url_alias'];
				$errorFlag = false;
				
				//server side validate here
				$urlReg = "/^[a-zA-Z0-9]{1,16}\$/";
				if(!preg_match($urlReg, $url_alias)){
					$this->assign('errorMessage', $this->loadErrorMessage('error.video.alias.invalidUrl'));
					$errorFlag = true;
				}
				
				//check owner id
				$video = $model_video->getVideoById($videoId);
				if($video['user_id'] != $userId){
					$this->loadTemplate('view_access_denied');
					return;
				}
				
				$reservedKeywords = $this->loadResources('shortcut.url.reserved.video');
				$reservedKeywords = split(",",$reservedKeywords);
				if(in_array($url_alias, $reservedKeywords)){
					$this->assign('errorMessage', $this->loadErrorMessage('error.video.alias.invalidUrl'));
					$errorFlag = true;					
				}
				
				$user = $model_user->getUserByUserId(array($userId));
				$this->assign('user_alias', $user['profile_alias'] ? $user['profile_alias'] : 'user' . $user['id']);
				$this->assign('videoId', $videoId);
				$this->assign("domain", BASE_PATH . CONTEXT);
				$this->assign('video_alias', $video['video_alias']);
				$this->assignVideoThumbnails($video);
				$this->assign('videoTitle', $video['video_title']);
				
				if((!$errorFlag) && ((!$video) || ($video['user_id'] != $userId))){
					$this->assign('errorMessage', $this->loadErrorMessage('error.video.alias.invalidVideoId'));
					$this->assign('videoTitle', 'N/A');
					$errorFlag = true;
				}
				
				//check exist alias here
				if((!$errorFlag) && ($model_video->isAliasExist(array($url_alias, $userId)))){
					$this->assign('errorMessage', $this->loadErrorMessage('error.video.alias.aliasExists', array($url_alias)));
					$errorFlag = true;
				}
				if((!$errorFlag) && ($model_album->isAliasExist(array($url_alias, $userId)))){
					$this->assign('errorMessage', $this->loadErrorMessage('error.album.alias.aliasExists', array($url_alias)));
					$errorFlag = true;
				}
				
				//save video alias
				if(!$errorFlag){
					if(($video['video_alias'] == $url_alias) ||$model_video->updateAliasById(array($url_alias, $videoId))){
						$this->assign('successMessage', $this->loadMessages('video.customurl.success'));
						$this->assign('video_alias', $url_alias);

						//if(!$video['video_alias']){
						if ( empty($url_alias) ) {
							$userAlias = empty($user['profile_alias']) ? 'user'.$user['id'] : $user['profile_alias'];
							$previewLink = BASE_PATH . CONTEXT . "/" . $userAlias . '/' . $video['video_id'];
						}else{
							$userAlias = empty($user['profile_alias']) ? 'user'.$user['id'] : $user['profile_alias'];
							$previewLink = BASE_PATH . CONTEXT . "/" . $userAlias .  "/" . $url_alias;
						}
						$this->assign("previewUrl", $previewLink);
					}else{
						$this->assign('errorMessage', $this->loadErrorMessage('error.video.alias'));
						$this->assign('video_alias', $video['video_alias']);
						$errorFlag = true;
					}
				}
				
				if($errorFlag){
					if(!$video['video_alias']){
						$userAlias = empty($user['profile_alias']) ? 'user'.$user['id'] : $user['profile_alias'];
						$previewLink = BASE_PATH . CONTEXT . "/" . $userAlias . '/' . $video['video_id'];
					}else{
						$previewLink = BASE_PATH . CONTEXT . "/" . ($user['profile_alias'] ? $user['profile_alias'] : 'user' . $user['id']) .  "/" . $video['video_alias'];
					}
					
					$this->assign("previewUrl", $previewLink);
				}
				
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_video_custom_url');
			}
		}
		
		/**
		 * 
		 * Default messagesSource for updateVideoFile page
		 */
		function updateVideoFileMessagesSource(){
			$this->defaultVideoMessagesSource();
			$this->assign("title", $this->loadMessages('video.videofile.title'));
			$this->assign("message_title", $this->loadMessages('video.videofile.title'));
			$this->assign('choose', $this->loadMessages('video.videofile.choose'));
			$this->assign('videoExtSupport', $this->loadResources('video.upload.ext.support'));
			$this->assign('maxSize', $this->loadResources('video.upload.maxsize')*1024*1024);
		}
		
		/**
		 * 
		 * updateVideoFile action
		 */
		function updateVideoFile(){
			$userId = $this->getLoggedUser();
			if($userId == 0){
				$this->redirect($this->ctx() . '/auth/login/');
				return;
			}
			$this->loadModel('model_video');
			$model_video = $this->model_video;

			if($_SERVER["REQUEST_METHOD"] == "GET"){
				$videoId = $_GET['videoId'];
				if(!$videoId){
					$this->loadTemplate('view_404');
					return;
				}
				
				$video = $model_video->getVideoById($videoId);
			
				if((!$video) || ($video['user_id'] != $userId)){
					$this->loadTemplate('view_access_denied');
					return;
				}
				
				$this->assign('videoTitle', $video['video_title']);
				$this->assignVideoThumbnails($video);
				$this->assign('vid', $videoId);		
				$this->assign('sessionId', session_id());		
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_video_file');
			}
		}
		
		/**
		 * Default message source for videopage
		 * 
		 */
		function videopageMessagesSource()
		{
			$this->defaultVideoMessagesSource();
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
			
			$this->loadModel('model_user');
			$this->loadModel('model_video');

			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$id=$_GET['videoId'];
				
				$params=array($id);
				$video=$this->model_video->getVideoByVideoId(array($id));
				$res=$this->model_video->isExistVideoId(array($id));
				if($res==0)
				{
					$this->loadTemplate('view_404');
					return;
				}else{
					if($video['user_id'] != $userId){
						$this->loadTemplate('view_access_denied');
						return;	
					}	
				}
				$fullname=$this->model_user->getFullNamebyUserId(array($video['user_id']));
				$play=$this->model_video->getPlaybyVideoId(array($id));
				$comment=$this->model_video->getCommentbyId($params);
				$like=$this->model_video->getLikebyId($params);
				$albums=$this->model_video->getAlbumByVideoIdAndUserId(array($id,$video['user_id']));
				$tags=$this->model_video->getTagfromTagandTagcomponent(array($id));
				
				$strTags="";
				for($i=0;$i<sizeof($tags);$i++)
				{
					$strTags .= $tags[$i]['name'] . ', ' ;
				}
				$strTags = substr(trim($strTags), 0, -1); 
				
				$strAlbums="";
				for($i=0;$i<sizeof($albums);$i++)
				{
					$strAlbums .= $albums[$i]['album_name'] . ',' ; 
				}
				$strAlbums = substr($strAlbums, 0, -1); 
				
				$this->assign("tags",$tags);
				$this->assign("play",$play['play_count']);
				$this->assign("comment",$comment['comment_count']);
				$this->assign("like",$like['like_count']);
				$this->assign("album",$albums);
				$this->assign("fullname",$fullname['full_name']);
				$this->assign("video",$video);
				$this->assign("videoid",$id);
				$this->assign("strTags",$strTags);
				$this->assign("strAlbums",$strAlbums);
				$this->assign("videoOwner", $userId == $video['user_id']);
				
				$start = $video['creation_date'];				
				$now = mktime(date("H"), date("i"),date("s"), date("m"), date("d"), date("Y"));
				$end = date("Y-m-d H:i:s", time());
				$diff=$this->get_time_difference($start, $end);
				$strDate="";
				if($diff['days']==0){
					if ($diff['hours']==0){
						if ($diff['minutes']==0)
							$strDate.= $diff['seconds'] . ' seconds';
						else 
							$strDate.= $diff['minutes'] . ' minutes';
					}
					else{ 
						$strDate.= $diff['hours']. ' hours ' . $diff['minutes'] . ' minutes';
					}
				}
				else{
					$strDate.= $diff['days']. ' days ' . $diff['hours'] . ' hours';
				}		
				$this->assign('videoThumbnail', !empty($video['thumbnails_path']) ? ($this->ctx() . $this->loadResources('image.upload.path') . $video['thumbnails_path']) : ($this->ctx() . '/images/icon-video.gif'));
				$this->assign("days",$strDate);
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_videopage');
			}
			else if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$id=$_POST['videoid'];
				$res=$this->model_video->isExistVideoId(array($id));
				if($res==0)
				{
					$this->loadTemplate('view_404');
					return;
				}else{
					if($video['user_id'] != $userId){
						$this->loadTemplate('view_access_denied');
						return;	
					}	
				}			
				$videos=$this->model_video->getVideofromVideoId(array($id));
				$this->assign("thumbnails",$videos['thumbnails_path']);
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_videopage');
			}
		}
	
		function thumbnailMessagesSource()
		{
			$this->defaultVideoMessagesSource();
			$this->assign("title", $this->loadMessages('video.thumbnail.title'));
			$this->assign("hint", $this->loadMessages('video.thumbnail.hint'));
			$this->assign('imageExtSupport', $this->loadResources('image.upload.ext.support'));
			$this->assign("currentThumbnail", $this->loadMessages('video.thumbnail.currentThumbnail'));
			$this->assign("uploadNewThumbnail", $this->loadMessages('video.thumbnail.uploadNewThumbnail'));
			$this->assign('successMessage', $this->loadMessages('user.information.update.success', array("video thumbnail")));
			$this->assign('maxSize', $this->loadResources('image.upload.maxsize')*1024*1024);
		}
		
		function thumbnail(){
			$userId = $this->getLoggedUser();
			if($userId == 0){
				$this->redirect($this->ctx() . '/auth/login/');
				return;
			}
			$this->loadModel('model_video');
			$model_video = $this->model_video;

			if ($_SERVER['REQUEST_METHOD'] == 'GET'){
				$videoId = $_GET['videoId'];
				if(!$videoId){
					$this->loadTemplate('view_404');
					return;
				}
				
				$video = $model_video->getVideoById($videoId);
				if((!$video) || ($video['user_id'] != $userId)){
					$this->loadTemplate('view_access_denied');
					return;
				}
				$path=$this->loadResources('video.upload.thumbnails');
				$videoPath=$video['video_path'];
				$videoHash=utils::getFileType($videoPath);
				$videoHash=$videoHash[0];
				$folder=$path.$videoHash;
				$folderPath=BASE_DIR . $folder;
				if(file_exists($folderPath) && is_dir($folderPath)){
					$dir = opendir($folderPath);
					$arrayImage=array();
					$fileType=$this->loadResources('image.upload.ext.support');
					$fileType = substr($fileType, 1);
					$fileTypeArray=split(';\*', $fileType);
					while (($fileName = readdir($dir)) !== false)
					{						
						if ($fileName != "." && $fileName != ".."){
							$type = utils::getFileType($fileName);							
							if($type != null){
								$type = '.' . $type[1];
								if(in_array($type, $fileTypeArray)){
									$arrayImage[]=$fileName;
								}					
							}		
						}
					}
					closedir($dir);
				}
				$this->assign('folder',$folder);
				$this->assign('arrayImage',$arrayImage);
				$this->assign('videoId', $video['video_id']);
				$this->assign('videoTitle', $video['video_title']);
				$this->assign('videoThumbnail', !empty($video['thumbnails_path']) ? ($this->loadResources('image.upload.path') . $video['thumbnails_path']) : ($this->ctx() . '/images/icon-video.gif'));
				$this->assign('imageUpload',$this->loadResources('image.upload.path'));
				$this->assign('sessionId', session_id());
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_video_thumbnail');
			}
		}
		
		/**
		 *  ajax refresh video's thumbnail after upload thumbnail image successfully
		 */
			function refreshVideoThumbnail(){
			$userId = $this->getLoggedUser();
				if($userId == 0){
					$this->redirect($this->ctx().'/auth/login/');
					return;
				}
			$this->loadModel('model_video');	
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$vid = $_POST['videoId'];
				$video = $this->model_video->getVideoById($vid);
				echo $video['thumbnails_path'];
			}
		}
		/**
		 * delete video messagesource
		 */
		function videoDeleteMessagesSource()
		{
			$this->defaultVideoMessagesSource();
			
			$this->assign("name", $this->loadMessages('album.delete.name'));
			$this->assign("question", $this->loadMessages('album.delete.quetion'));
			$this->assign('hint', $this->loadMessages('album.delete.hint'));
		}
		/**
		 * delete video
		 */
		function videoDelete()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_video');
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$videoid=$_GET['videoId'];
				$res=$this->model_video->isExistVideoId(array($videoid));
				if($res==0)
				{
					$this->loadTemplate('view_404');
					return;
				}else{
					$video = $this->model_video->getVideoById($videoid);
					if($video['user_id'] != $userId){
						$this->loadTemplate('view_access_denied');
						return;
					}
				}
				$video = $this->model_video->getVideoByVideoIdAndUserId(array($userId,$videoid));
				$this->assign("videoName",$video['video_title']);
				$this->assign("videoId",$videoid);
				$this->assignVideoThumbnails($video);
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_video_videodelete');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$videoid=$_GET['videoId'];
				$res=$this->model_video->isExistVideoId(array($videoid));
				if($res==0)
				{
					$this->loadTemplate('view_404');
					return;
				}else{
					$video = $this->model_video->getVideoById($videoid);
					if($video['user_id'] != $userId){
						$this->loadTemplate('view_access_denied');
						return;
					}
				}
				$video = $this->model_video->getVideoByVideoIdAndUserId(array($userId,$videoid));
				$this->assignVideoThumbnails($video);
				$this->assign("videoName",$video['video_title']);
				$this->assign("videoId",$videoid);
				$this->model_video->deleteAllTagComponentsByVideoId(array(COMPONENT_VIDEO_TYPE,$videoid));
				$this->model_video->dropVideoByVideoId(array($videoid));
				$this->redirect($this->ctx().'/user/video/');
			}
		}
	/**
		 * Default message source for public video
		 * 
		 */
		function publicVideoMessagesSource()
		{
			$this->defaultVideoMessagesSource();
			$this->assign("day", $this->loadMessages('user.videopage.day'));
			$this->assign("by", $this->loadMessages('user.videopage.by'));
			$this->assign("plays", $this->loadMessages('user.videopage.plays'));
			$this->assign("comments", $this->loadMessages('user.videopage.comments'));
			$this->assign("likes", $this->loadMessages('user.videopage.likes'));
			$this->assign("tag", $this->loadMessages('user.videopage.tag'));
			$this->assign("albums", $this->loadMessages('user.videopage.albums'));
			
		}
		
		/**
		 * Display public video
		 * 
		 */
		function publicVideo()
		{
			$userId = $this->getLoggedUser();
			
			$this->loadModel('model_user');
			$this->loadModel('model_video');

			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$id=$_GET['videoId'];
				
				$params=array($id);
				$video=$this->model_video->getVideoByVideoId(array($id));
				$res=$this->model_video->isExistVideoId(array($id));
				if($res==0)
				{
					$this->loadTemplate('view_404');
					return;
				}	
				$fullname=$this->model_user->getFullNamebyUserId(array($video['user_id']));
				$play=$this->model_video->getPlaybyVideoId(array($id));
				$comment=$this->model_video->getCommentbyId($params);
				$like=$this->model_video->getLikebyId($params);
				$albums=$this->model_video->getAlbumByVideoIdAndUserId(array($id,$video['user_id']));
				$tags=$this->model_video->getTagfromTagandTagcomponent(array($id));
				
				$strTags="";
				for($i=0;$i<sizeof($tags);$i++)
				{
					$strTags .= $tags[$i]['name'] . ', ' ;
				}
				$strTags = substr(trim($strTags), 0, -1); 
				
				$strAlbums="";
				for($i=0;$i<sizeof($albums);$i++)
				{
					$strAlbums .= $albums[$i]['album_name'] . ',' ; 
				}
				$strAlbums = substr($strAlbums, 0, -1); 
				
				$this->assign("tags",$tags);
				$this->assign("play",$play['play_count']);
				$this->assign("comment",$comment['comment_count']);
				$this->assign("like",$like['like_count']);
				$this->assign("album",$albums);
				$this->assign("fullname",$fullname['full_name']);
				$this->assign("video",$video);
				$this->assign("title",$video['video_title']);
				$this->assign("videoid",$id);
				$this->assign("strTags",$strTags);
				$this->assign("strAlbums",$strAlbums);
				$this->assign("videoOwner", $userId == $video['user_id']);
				
				$start = $video['creation_date'];				
				$strDate = utils::getDiffTimeString($start);		
				$this->assign('videoThumbnail', !empty($video['thumbnails_path']) ? ($this->ctx() . $this->loadResources('image.upload.path') . $video['thumbnails_path']) : ($this->ctx() . '/images/icon-video.gif'));
				$this->assign("days",$strDate);
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_video_publicvideo');
			}
			else if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$id=$_POST['videoid'];
				$res=$this->model_video->isExistVideoId(array($id));
				if($res==0)
				{
					$this->loadTemplate('view_404');
					return;
				}		
				$videos=$this->model_video->getVideofromVideoId(array($id));
				$this->assign("thumbnails",$videos['thumbnails_path']);
				$this->loadTemplate(VIDEO_TEMPLATE_DIR.'view_video_publicvideo');
			}
		}
		
		/**
		 * update thumbnails from screen shot
		 */
		function updateThumbnailFromScreenShot()
		{
			$userId = $this->getLoggedUser();
				if($userId == 0){
					$this->redirect($this->ctx().'/auth/login/');
					return;
				}
			$this->loadModel('model_video');	
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$vid = $_POST['videoId'];
				$imageName= $_POST['imageName'];
				$video = $this->model_video->getVideoById($vid);
				$videoPath=$video['video_path'];
				$videoHash=utils::getFileType($videoPath);
				$videoThumbnailsDir = $videoHash[0];
				$destination=$this->loadResources('image.upload.path');
				$source=$this->loadResources('video.upload.thumbnails');
				$destName = $imageName;
				$destType = utils::getFileType($imageName);
				while(file_exists(BASE_DIR.$destination.$destName)){
					$destName=utils::genRandomString(64).'.'.$destType[1];
				}
				if(!copy(BASE_DIR.$source.$videoThumbnailsDir."/".$imageName,BASE_DIR.$destination.$destName))
				{
					echo "failed to copy $imageName to $destination \n";
				}
				$this->model_video->updateThumbnailById(array($destName,$vid));
				echo $destName;
			}
		}
	}
?>