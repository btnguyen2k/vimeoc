<?php 

	/**
	 * 
	 * User controller
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
	}
?>