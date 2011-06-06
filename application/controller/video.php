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
			$this->assign("successMessage", $this->loadMessages('video.preandpostroll.successful'));
		}
		
		
		/**
		 * View and action for preAndPostRoll
		 * 
		 */
		function preAndPostRoll()
		{
			$this->loadModel('model_video');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				5
				$this->loadTemplate('view_video_preandpostroll');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				
				$this->loadTemplate('view_video_preandpostroll');
			}
		}
		
	}
?>