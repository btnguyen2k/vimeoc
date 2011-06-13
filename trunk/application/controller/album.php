<?php
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
//		/**
//		 * 
//		 * Default action
//		 */
//		function index()
//		{
//			$this->redirect("/vimeoc/home");
//		}
		
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
		function createnewalbumMessagesSource()
		{
			$this->defaultAlbumMessagesSource();
			
			$this->assign("name", $this->loadMessages('album.create.name'));
			$this->assign("title", $this->loadMessages('album.create.title'));
			$this->assign('description', $this->loadMessages('album.create.description'));
			
			$this->assign('errorDescription', $this->loadErrorMessage('error.album.create.description'));
		}
		/**
		 * Load and action create new album 
		 * 
		 */
		
		function createnewalbum()
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
				$this->loadTemplate('view_album_createnewalbum');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$albumName=$_POST['title'];
				$description=$_POST['description'];
				$this->model_album->addNewAlbum(array($userId,$albumName,$description));
				$this->assign("successMessage",$this->loadMessages('album.create.successful'));
//				$this->assign('title_',$albumName);
//				$this->assign('description_',$description);
				$this->loadTemplate('view_album_createnewalbum');
			}
		}
	}
?>
