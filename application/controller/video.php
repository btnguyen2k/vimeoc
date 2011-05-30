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
				$this->tmpl->assign('userAvatar', $user['avatar']);
			}
			
			$this->tmpl->assign("videobasicinfo", $this->loadMessages('user.video.link.basicinfo'));
			$this->tmpl->assign("videothumbnail", $this->loadMessages('user.video.link.thumbnail'));
			$this->tmpl->assign("videovideofile", $this->loadMessages('user.video.link.videofile'));
			$this->tmpl->assign("videocustomurl", $this->loadMessages('user.video.link.customurl'));
			$this->tmpl->assign("videoaddto", $this->loadMessages('user.video.link.addto'));
			$this->tmpl->assign("videodelete", $this->loadMessages('user.video.link.delete'));
			$this->tmpl->assign("videobacktovideo", $this->loadMessages('user.video.link.backtovideo'));
		}
		/**
		 * Load messages source for videosetting page
		 * 
		 */
		
		function videosettingMessagesSource()
		{
			$this->defaultVideoMessagesSource();
			
			$this->tmpl->assign("name", $this->loadMessages('user.videosetting.name'));
			$this->tmpl->assign("title", $this->loadMessages('user.videosetting.title'));
			$this->tmpl->assign('description', $this->loadMessages('user.videosetting.description'));
			$this->tmpl->assign('tag', $this->loadMessages('user.videosetting.tags'));

			$this->tmpl->assign('titleiInvalid', $this->loadErrorMessage('error.video.title'));
			$this->tmpl->assign('descriptionInvalid', $this->loadErrorMessage('error.video.description'));
			$this->tmpl->assign('tagInvalid', $this->loadErrorMessage('error.video.tag'));
		}
		/**
		 *view and action for videosetting form 
		 *
		 */
		
		function videosetting()
		{
			$this->loadModel('model_user');	
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$this->loadTemplate('view_video_videosetting');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadTemplate('view_video_videosetting');
			}
		}
	}
?>