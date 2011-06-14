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
				$videoThumbnails=$this->model_album->getVideoThumbnailsByAlbumId(array($albumId));
				
				$this->assign("videoThumbnails",$videoThumbnails);
				$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_albumthumbnail');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadTemplate(ALBUM_TEMPLATE_DIR.'view_album_albumthumbnail');
			}
			
			
		}
		
	}
	
?>
