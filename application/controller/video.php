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
			$this->assign("videoId", $_GET["videoId"]);
			$this->assign("requiredFields", $this->loadErrorMessage('error.field.required'));
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
				$videoid=$_GET['videoId'];
				$tcid=$_GET['videoId'];
				$tagid=$_GET['tagid'];
				
				$tags=$this->model_video->getTagfromTagandTagcomponent(array($tcid));
				$video= $this->model_video->getVideofromVideoId(array($videoid));
				$this->assign('title_', $video['video_title']);
				$this->assign('description_', $video['description']);
				$this->assign('tag_', $tags);
				$this->assign('tcid', $tcid);
				$this->assign('hiddenvideo',$videoid);
				$this->loadTemplate('view_video_videosetting');
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
				for($j=0;$j<sizeof($slipTag);$j++)
				{				
					if($slipTag[$j]!="")
					{
						$checkTag=$this->model_video->isTagExist(array($slipTag[$j]));
						if($checkTag==0)
						{
							$this->model_video->addTagName(array($slipTag[$j]));			
							$tagNewId=$this->model_video->getTagIdByName(array($slipTag[$j]));
							$this->model_video->addTagIdAndComponentId(array($tagNewId[0]["id"],$videoid));
						}
						else 
						{
	
							$tagNewId=$this->model_video->getTagIdByName(array($slipTag[$j]));
							$res=$this->model_video->checkIdAndComponentId(array($tagNewId[0]["id"],$videoid));
							if($res==0)
							{
								$this->assign('successMessage', $this->loadMessages('user.videosetting.updatesuccess'));
								$this->model_video->addTagIdAndComponentId(array($tagNewId[0]["id"],$videoid));
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
				$this->assign('tcid', $tcid);
				$this->assign('hiddenvideo',$videoid);
				$this->assign('title_', $video['video_title']);
				$this->assign('description_', $video['description']);
				$this->assign('tag_', $tags);
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
				if(!$videoid){
					$this->redirect($this->ctx().'/user/home');
					return;
				}
				$albums= $this->model_video->getAlbumByUserId(array($userId));
				$video=$this->model_video->getVideoByVideoId(array($videoid));
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
				$albums= $this->model_video->getAlbumByUserId(array($userId));
				$video=$this->model_video->getVideoByVideoId(array($videoid));
				$this->assign("videoid",$videoid);
				$this->assign("checkedAlbums",$albumid);
				$this->assign("video",$video['video_title']);
				$this->assign("albums",$albums);
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
				$video2 = $this->model_video->getVideoByVideoId(array($videoid));
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
				
				$video = $this->model_video->getVideoByVideoIdAndUserId(array($userId,$videoid));
				$video2 = $this->model_video->getVideoByVideoId(array($videoid));
				$this->assign("getpreRoll",$video2[pre_roll]);
				$this->assign("getpostRoll",$video2[post_roll]);
				$this->assign("video",$video[video_title]);
				$this->assign("videoid",$videoid);
				$this->loadTemplate('view_video_preandpostroll');
			}
		}
		/**
		 * Load messages source for customUrl page
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
					$this->assign('errorMessage', $this->loadErrorMessage('error.video.alias.invalidUrl'));
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
					$this->assign('errorMessage', $this->loadErrorMessage('error.video.alias.invalidVideoId'));
					$this->assign('videoTitle', 'N/A');
					$errorFlag = true;
				}
				
				//check exist alias here
				if((!$errorFlag) && ($model_video->isAliasExist(array($url_alias, $userId)))){
					$this->assign('errorMessage', $this->loadErrorMessage('error.video.alias.aliasExists', array($url_alias)));
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
					}else{
						$this->assign('errorMessage', $this->loadErrorMessage('error.video.alias'));
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

			$this->loadModel('model_user');
			$model_user = $this->model_user;
			
			if($_SERVER["REQUEST_METHOD"] == "GET"){
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
				
				$this->assign('videoTitle', $video['video_title']);
				$this->assign('upId', uniqid());
				
				$this->loadTemplate('view_video_file');
			}else if($_SERVER["REQUEST_METHOD"] == "POST"){
				$videoId = $_POST['videoId'];
				if(!$videoId){
					$ret=array('status'=>0,'errorMessage'=>'Invalid data');
					echo json_encode($ret);
					return;
				}
				
				$video = $model_video->getVideoById($videoId);
				if((!$video) || ($video['user_id'] != $userId)){
					$ret=array('status'=>0,'errorMessage'=>'Invalid data');
					echo json_encode($ret);
					return;
				}
				
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
					$maxsize = $this->loadResources('video.upload.maxsize');
					if($size > $maxsize)
					{
						$ret = array('status'=>0, 'errorMessage'=>$this->loadErrorMessage('error.user.upload.maximum.file.size', array($maxsize.'MB')), 'upId'=>uniqid());
						echo json_encode($ret);	
					}else if($size == 0){
						$ret = array('status'=>0, 'errorMessage'=>$this->loadErrorMessage('error.field.required'), 'upId'=>uniqid());
						echo json_encode($ret);	
					}else{
						$fileInfo = utils::getFileType($fileName);
						$name = utils::genRandomString(32) . '.' . $fileInfo[1];
						$target = BASE_DIR . $this->loadResources('video.upload.path') . $name;
						move_uploaded_file($tmpName, $target);
						
					    $ret = $this->model_video->updateVideoFile(array($name, $videoId));
				
						if($ret == 0)
						{
							$ret = array('status'=>0, 'errorMessage'=>'Error', 'upId'=>uniqid());
							echo json_encode($ret);	
						}
						else 
						{
							$ret = array('status'=>1, 'successMessage'=>$this->loadMessages('user.information.update.success', array("video")), 'upId'=>uniqid());
							echo json_encode($ret);	
						}
					}
				}
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
				$id=$_GET['videoId'];
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
				$this->assign("videoid",$id);
				$this->loadTemplate('view_videopage');
			}
			else if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$id=$_POST['videoid'];
				$res=$this->model_video->checkUserId(array($id));
				if($res["user_id"]==$userId)
				{
					$this->model_video->dropVideoByVideoId(array($id));
				}
				$this->loadTemplate('view_videopage');
				
			}
		}
	
		function thumbnailMessagesSource()
		{
			$this->defaultVideoMessagesSource();
			$this->assign("title", $this->loadMessages('video.thumbnail.title'));
			$this->assign("hint", $this->loadMessages('video.thumbnail.hint'));
			$this->assign("currentThumbnail", $this->loadMessages('video.thumbnail.currentThumbnail'));
			$this->assign("uploadNewThumbnail", $this->loadMessages('video.thumbnail.uploadNewThumbnail'));

		}
		
	function thumbnail(){
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
				$this->assign('videoId', $video['video_id']);
				$this->assign('videoTitle', $video['video_title']);
				$this->assign('videoThumbnail', $video['thumbnails_path'] ? ($this->ctx(). $this->loadResources('image.upload.path') . $video['thumbnails_path']) : ($this->ctx() . '/images/icon-video.gif'));
				$this->assign('upId', uniqid());
				$this->loadTemplate('view_video_thumbnail');
			}elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($_FILES['portrait']['error'] > 0)
				{
					$ret = array('status' => 0, 'errorMessage' => $this->loadErrorMessage('error.video.thumbnail'), 'upId' => uniqid());
					echo json_encode($ret);
					return;
				}
				else{
					$error_flag = false;
					$videoId = $_POST['videoId'];
					$video = $model_video->getVideoById($videoId);
					//check video owner
					if(!$video || ($video['user_id'] != $userId)){
						$ret = array('status' => 0, 'errorMessage' => $this->loadErrorMessage('error.video.thumbnail.invalidVideoId'), 'upId' => uniqid());
						echo json_encode($ret);
						return;
					}else{
						$old_thumbnail = $video['thumbnails_path'];
					}
					
					//check upload error
					$type = $_FILES['thumbnail_image']['type'];
					$size = $_FILES['thumbnail_image']['size'] / (1024*1024);
					$tmpName = $_FILES['thumbnail_image']['tmp_name'];
					$fileName = $_FILES['thumbnail_image']['name'];
					$fileInfo = utils::getFileType($fileName);
					
					$extSupport = explode(',', $this->loadResources('image.upload.ext.support'));
					//if((!$errorFlag) && ($type != 'image/jpeg' && $type != 'image/png' && $type != 'image/gif')){
					if(!in_array('.' . $fileInfo[1], $extSupport)){
						$ret = array('status' => 0, 'errorMessage' => $this->loadErrorMessage('error.video.thumbnail.notSupport'), 'upId' => uniqid());
						echo json_encode($ret);
						return;
					}
					
					$maxsize = $this->loadResources('image.upload.maxsize');
					if($size > $maxsize){
						$ret = array('status' => 0, 'errorMessage' => $this->loadErrorMessage('error.video.thumbnail.fileSizeLimit'), 'upId' => uniqid());
						echo json_encode($ret);
						return;
					}
					
					do{
						$name = utils::genRandomString(32) . '.' . $fileInfo[1];
						$target = BASE_DIR . $this->loadResources('image.upload.path') . $name;
					}while(file_exists($target));
					
					$rimg = new RESIZEIMAGE($tmpName);
				    $rimg->resize_limitwh(300, 300, $target);				    
				    $rimg->close();
				    
				    $result = $model_video->updateThumbnailById(array($name, $videoId));
				    
					if($result == 0){
						$ret = array('status' => 0, 'errorMessage' => $this->loadErrorMessage('error.video.thumbnail'), 'upId' => uniqid());
						echo json_encode($ret);
						return;
					}else{
						$video['thumbnails_path'] = $name;
						if($old_thumbnail && file_exists(BASE_DIR . $this->loadResources('image.upload.path') . $old_thumbnail)){
							unlink(BASE_DIR . $this->loadResources('image.upload.path') . $old_thumbnail);
							file_put_contents('d:\log.txt', "delete " . $name . "\n", FILE_APPEND);
						}
						$ret = array('status' => 1, 'successMessage' => $this->loadMessages('video.thumbnail.success'), 'upId' => uniqid(), 'thumbnail' => ($this->ctx() . $this->loadResources('image.upload.path') . $name));
						echo json_encode($ret);
						return;
					}
				}
			}
		}
	}
?>