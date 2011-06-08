<?php 

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
			$this->redirect("/vimeoc/home");
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
			}
			
			$this->assign("videobasicinfo", $this->loadMessages('user.video.link.basicinfo'));
			$this->assign("videothumbnail", $this->loadMessages('user.video.link.thumbnail'));
			$this->assign("videovideofile", $this->loadMessages('user.video.link.videofile'));
			$this->assign("videocustomurl", $this->loadMessages('user.video.link.customurl'));
			$this->assign("videoaddto", $this->loadMessages('user.video.link.addto'));
			$this->assign("videodelete", $this->loadMessages('user.video.link.delete'));
			$this->assign("videobacktovideo", $this->loadMessages('user.video.link.backtovideo'));
			$this->assign("videopreandpost", $this->loadMessages('user.video.link.preandpostroll'));
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
				$videoid=$_GET['videoid'];
				$tagid=$_GET['tagid'];
				$tcid=$_GET['tcid'];
				$video= $this->model_video->getVideofromVideoId(array($videoid,$tcid));
				$this->assign('title_', $video['video_title']);
				$this->assign('description_', $video['description']);
				$tags=$this->model_video->getTagfromTagandTagcomponent(array($tagid,$tcid));
				$this->assign('tag_', $tags);
				$this->assign('hiddenvideo',$videoid);
				$this->loadTemplate('view_video_videosetting');
				// Session to get videoid, tagid and tcid
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$title=$_POST['title'];
				$description=$_POST['description'];
				$tag=$_POST['tag'];
				$videoid=$_POST['videoid'];
				$tagid=$_POST['tagid'];
				$tcid=$_POST['tcid'];
				$updatetitle= $this->model_video->updateTitlebyId(array($title,$videoid));
				$updatedescrition= $this->model_video->updateDescriptionbyId(array($description,$videoid));
				$this->assign('successMessage', $this->loadMessages('user.videosetting.updatesuccess'));
				$this->loadTemplate('view_video_videosetting');
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
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$videoid=$_GET['videoId'];
				$albums= $this->model_video->getAlbumByUserId(array($userId));
				$video=$this->model_video->getVideoByVideoId(array($userId,$videoid));
				$this->assign("videoid",$videoid);
				$this->assign("video",$video['video_title']);
				$this->assign("albums",$albums);
				$this->loadTemplate('view_video_addtopage');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$videoid=$_POST['videoid'];
				$albumid=$_POST["album_id"];
				$mAlbumId = split(',', $albumid);
				$albumUncheck = $_POST["albumUncheck"];
				$mAlbumUncheck = split(',', $albumUncheck);
				for($j=0;$j<sizeof($mAlbumUncheck);$j++)
				{
					$this->model_video->dropAlbumIdAndVideoId(array($mAlbumUncheck[$j],$videoid));
				}
				
				for($i=0;$i<sizeof($mAlbumId);$i++)
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
					$this->loadTemplate('view_video_addtopage');
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
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$videoid=$_GET['videoId'];
				$video = $this->model_video->getVideoByVideoIdAndUserId(array($userId,$videoid));
				$preRoll = $this->model_video->getVideoByVideoId(array($videoid));
				$postRoll = $this->model_video->getVideoByVideoId(array($videoid));
				$video2 = $this->model_video->getVideoByVideoId(array($videoid));
				echo $video2[pre_roll];
				echo $video2[post_roll];
				$this->assign("getpreRoll",$video2[pre_roll]);
				$this->assign("getpostRoll",$video2[post_roll]);
				$this->assign("videoid",$videoid);
				$this->assign("video",$video[video_title]);
				$this->loadTemplate('view_video_preandpostroll');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$preRoll=$_POST['hpreroll'];
				$postRoll=$_POST['hpostroll'];
				$videoid=$_POST['videoid'];
				$this->model_video->updatePre_roll(array($preRoll,$videoid,$userId));
				$this->model_video->updatePost_roll(array($postRoll,$videoid,$userId));
				$this->assign("successMessage", $this->loadMessages('video.preandpostroll.successful'));
				$this->loadTemplate('view_video_preandpostroll');
			}
		}
		/**
		 * Load messages source for videosetting page
		 * 
		 */
		
		function customUrlMessagesSource()
		{
			$this->defaultVideoMessagesSource();
			$this->assign("message_title", $this->loadMessages('video.customurl.title'));
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
			
			if ($_SERVER['REQUEST_METHOD'] == 'GET'){
				$videoId = $_GET['videoId'];
				if(!$videoId){
					$this->redirect($this->ctx() . '/user/video/');
					return;
				}
				
				$video = $model_video->getVideoById($videoId);
				if((!$video) || ($video['user_id'] != $userId)){
					$this->redirect($this->ctx() . '/user/video/');
					return;
				}
				
				$user = $model_user->getUserByUserId(array($userId));
				$this->assign('user_alias', $user['profile_alias'] ? $user['profile_alias'] : 'user' . $user['id']);
				$this->assign('video_alias', $video['video_alias']);
				$this->assign('videoId', $video['video_id']);
				$this->assign('videoTitle', $video['video_title']);
				$this->assign("domain", BASE_PATH . CONTEXT);
				
				if(!$video['video_alias']){
					$previewLink = BASE_PATH . CONTEXT . "/" . $video['video_id'];
				}else{
					$previewLink = BASE_PATH . CONTEXT . "/" . ($user['profile_alias'] ? $user['profile_alias'] : 'user' . $user['id']) .  "/" . $video['video_alias'];
				}
				$this->assign("previewUrl", $previewLink);
				
				$this->loadTemplate('view_video_custom_url');
			}else if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$videoId = $_POST['videoId'];
				$url_alias = $_POST['url_alias'];
				$errorFlag = false;
				
				//server side validate here
				$urlReg = "/^[a-z0-9]{0,32}\$/";
				if(!preg_match($urlReg, $url_alias)){
					$this->assign('errorMessage', $this->loadMessages('video.customurl.invalidUrl'));
					$errorFlag = true;
				}
				
				//check owner id
				$video = $model_video->getVideoById($videoId);
				$user = $model_user->getUserByUserId(array($userId));
				$this->assign('user_alias', $user['profile_alias'] ? $user['profile_alias'] : 'user' . $user['id']);
				$this->assign('videoId', $videoId);
				$this->assign("domain", BASE_PATH . CONTEXT);
				$this->assign('video_alias', $video['video_alias']);
				$this->assign('videoTitle', $video['video_title']);
				
				if((!$errorFlag) && ((!$video) || ($video['user_id'] != $userId))){
					$this->assign('errorMessage', $this->loadMessages('video.customurl.invalidVideoId'));
					$this->assign('videoTitle', 'N/A');
					$errorFlag = true;
				}
				
				//check exist alias here
				if((!$errorFlag) && ($model_video->isAliasExist(array($url_alias, $userId)))){
					$this->assign('errorMessage', str_replace('%%1', "'{$url_alias}'", $this->loadMessages('video.customurl.aliasExists')));
					$errorFlag = true;
				}
				
				//save video alias
				if(!$errorFlag){
					if($model_video->updateAliasById(array($url_alias, $videoId))){
						$this->assign('successMessage', $this->loadMessages('video.customurl.success'));
						$this->assign('video_alias', $url_alias);
						
						if(!$url_alias){
							$previewLink = BASE_PATH . CONTEXT . "/" . $video['video_id'];
						}else{
							$previewLink = BASE_PATH . CONTEXT . "/" . ($user['profile_alias'] ? $user['profile_alias'] : 'user' . $user['id']) .  "/" . $url_alias;
						}
						$this->assign("previewUrl", $previewLink);
					}else{krumo($this->loadMessages('video.customurl.error'));
						$this->assign('errorMessage', $this->loadMessages('video.customurl.error'));
						$this->assign('video_alias', $video['video_alias']);
						$errorFlag = true;
					}
				}
				
				if($errorFlag){
					if(!$video['video_alias']){
						$previewLink = BASE_PATH . CONTEXT . "/" . $video['video_id'];
					}else{
						$previewLink = BASE_PATH . CONTEXT . "/" . ($user['profile_alias'] ? $user['profile_alias'] : 'user' . $user['id']) .  "/" . $video['video_alias'];
					}
					$this->assign("previewUrl", $previewLink);
				}
				
				$this->loadTemplate('view_video_custom_url');
			}
		}
	}
?>