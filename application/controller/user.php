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
			$loggedUser = $this->getLoggedUser();
			if($loggedUser == null){
				$this->redirect($this->ctx().'/auth/login/');
			}
			
			$this->loadTemplate('view_user_home');
		}
		
		/**
		 * 
		 * Load messages source for all user features
		 */
		function defaultUserMessagesSource()
		{
			$this->tmpl->assign("menuUploadVideo", $this->loadMessages('user.menu.link.uploadVideo'));
			$this->tmpl->assign("menuVideos", $this->loadMessages('user.menu.link.videos'));
			$this->tmpl->assign("menuAlbums", $this->loadMessages('user.menu.link.albums'));
			$this->tmpl->assign("menuPersonalInfo", $this->loadMessages('user.menu.link.personalInfo'));
			$this->tmpl->assign("menuPortrait", $this->loadMessages('user.menu.link.portrait'));
			$this->tmpl->assign("menuPassword", $this->loadMessages('user.menu.link.password'));
			$this->tmpl->assign("menuShortcutURL", $this->loadMessages('user.menu.link.shortcutURL'));
			$this->tmpl->assign("menuLogout", $this->loadMessages('user.menu.link.logout'));
		}
		
		/**
		 * 
		 * Default messages source for personalInfo page
		 */
		function personalInfoMessagesSource()
		{
			$this->defaultUserMessagesSource();
			
			$this->tmpl->assign("title", $this->loadMessages('user.personalInfo.title'));
		}
		
		/**
		 * 
		 * Display personal information page
		 */
		function personalInfo()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$this->loadTemplate('view_user_info');
			} 
		}
	}
?>