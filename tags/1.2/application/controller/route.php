<?php 
	/**
	 * 
	 * Route the url-rewrite for video and album
	 * @author Tri
	 *
	 */
	class Route extends Application {
		/**
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{				
			$this->tmpl = &$tmpl;		
		}
		
		function routing(){
			$userAlias = $_GET['userAlias'];
			$videoAlias = $_GET['videoAlias'];
			$albumAlias = $_GET['albumAlias'];
			
			$userModel = $this->getModel('model_user');
			$albumModel = $this->getModel('model_album');
			$videoModel = $this->getModel('model_video');
			
			$user = $userModel->getUserByUserAlias(array($userAlias));
			if($user == null){
				$user = $userModel->getUserByUsername(array($userAlias));
				if(user == null){
					$this->redirect($this->ctx());
					return;
				}
			}
			
			$video = $videoModel->getVideoByVideoAlias(array($videoAlias));
			if($video == null){
				$album = $albumModel->getAlbumByAlbumAlias(array($albumAlias));
				if($album != null && ($user['id'] == $album['user_id'])){
					$_GET['albumId'] = $album['id']; 	
					$controller = $this->getController('album', $this->tmpl);
					$controller->indexMessagesSource();
					$controller->index();
				}else{
					$this->redirect($this->ctx());
				}
			}else{
				if($video != null && ($user['id'] == $video['user_id'])){
					$_GET['videoId'] = $video['id']; 	
					$controller = $this->getController('video', $this->tmpl);
					$controller->videopageMessagesSource();
					$controller->videopage();
				}else{
					$this->redirect($this->ctx());
				}
			}
			
			echo $video != null;
		}		
	}
?>