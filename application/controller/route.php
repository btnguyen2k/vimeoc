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
		
		/**
		 * 
		 * Routing action handles the advantaged url-rewrite
		 */
		function routing(){
			$userAlias = $_GET['userAlias'];
			$videoAlias = $_GET['videoAlias'];
			$albumAlias = $_GET['albumAlias'];
			
			$userModel = $this->getModel('model_user');
			$albumModel = $this->getModel('model_album');
			$videoModel = $this->getModel('model_video');
			
			$defaultRegex = '/^user[0-9]{1,12}$/';
			
			$user = $userModel->getUserByUserAlias(array($userAlias));
			
			if($user == null){
				$user = $userModel->getUserByUsername(array($userAlias));
				if($user == null){		
					if(preg_match($defaultRegex, $userAlias)){
						$userId = substr($userAlias, 4);
						$user = $userModel->getUserByUserId($userId);
					}						
				}
			}
			
			if($user == null){
				$this->redirect($this->ctx());
				return;
			}
			
			if(!isset($videoAlias) && !isset($albumAlias)){
				$_GET['userId'] = $user['id']; 	
				$controller = $this->getController('user', $this->tmpl);					
				$controller->userprofileMessagesSource();
				$controller->userprofile();
				return;
			}
			
			if(is_numeric($videoAlias)){
				$video = $videoModel->getVideoByVideoId(array($videoAlias));
				if($video != null && ($user['id'] == $video['user_id'])){
					$_GET['videoId'] = $video['id']; 	
					$controller = $this->getController('video', $this->tmpl);					
					$controller->publicVideoMessagesSource();
					$controller->publicVideo();
				}else{
					$this->redirect($this->ctx());
				}
			}else{
				$video = $videoModel->getVideoByVideoAlias(array($videoAlias, $user['id']));				
				if($video == null){
					$album = $albumModel->getAlbumByAlbumAlias(array($albumAlias, $user['id']));
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
						$controller->publicVideoMessagesSource();
						$controller->publicVideo();
					}else{
						$this->redirect($this->ctx());
					}
				}
			}
		}		
	}
?>