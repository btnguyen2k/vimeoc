<?php
	define("CHANNEL_TEMPLATE_DIR","channel/");
	
	/**
	 * 
	 * Channel controller
	 * @author Tri
	 *
	 */
	class Channel extends Application
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
		 * Load messages source for all Channel features
		 * 
		 */
		function defaultChannelMessagesSource()
		{
			$userId = $this->getLoggedUser();
			if($userId > 0)
			{
				$this->loadModel('model_user');
				$user = $this->model_user->getUserByUserId($userId);
				$this->assign('userAvatar', $user['avatar']);
				$this->assign('user_fullname', $user['full_name']);
			}		
			$this->assign("menuChannel", $this->loadMessages('channel.menu.channelpage.link'));
			$this->assign("menuBackToChannel", $this->loadMessages('channel.menu.channelback.link'));
			$this->assign("menuchannelsetting", $this->loadMessages('channel.menu.channelsetting.link'));
			$this->assign("menuchannelthumbnail", $this->loadMessages('channel.menu.channelthumbnail.link'));
			$this->assign("menuchanneladdto", $this->loadMessages('channel.menu.channeladdto.link'));
			$this->assign("menuchannelarrange", $this->loadMessages('channel.menu.channelarrange.link'));
			$this->assign("menuchanneldelete", $this->loadMessages('channel.menu.channeldelete.link'));
			$this->assign("menuchannelcreate", $this->loadMessages('channel.menu.channelcreate.link'));
			$this->assign("videoId", $_GET["videoId"]);
			$this->assign("albumId", $_GET["albumId"]);
		}
		/**	
		 * Load defaul create new channel page
		 * 
		 */
		function createNewChannelMessagesSource()
		{
			$this->defaultChannelMessagesSource();
			
			$this->assign("name", $this->loadMessages('channel.create.name'));
			$this->assign("title", $this->loadMessages('channel.create.title'));
			$this->assign('description', $this->loadMessages('channel.create.description'));
			$this->assign('hint', $this->loadMessages('channel.create.hint'));
			
			$this->assign('errorDescription', $this->loadErrorMessage('error.channel.create.description'));
			$this->assign('show_user_avatar', 1);
		}
		/**
		 * Load and action create new channel 
		 * 
		 */
		
		function createNewChannel()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_channel');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{						
				$this->loadTemplate(CHANNEL_TEMPLATE_DIR.'view_channel_createnewchannel');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$channelName=$_POST['title'];
				$description=$_POST['description'];
				$channelId = $this->model_channel->addNewChannel(array($userId,$channelName,$description));
				$this->redirect($this->ctx().'/channel/?channelId='.$channelId);
			}
		}
		/**
		 * Load defaul channel basic info page
		 * 
		 */
		function channelSettingMessagesSource()
		{
			$this->defaultChannelMessagesSource();
			
			$this->assign("name", $this->loadMessages('channel.setting.name'));
			$this->assign("title", $this->loadMessages('channel.setting.title'));
			$this->assign('description', $this->loadMessages('channel.setting.description'));
			$this->assign('hint', $this->loadMessages('channel.setting.hint'));
			
			$this->assign('errorDescription', $this->loadErrorMessage('error.channel.create.description'));
		}
		/**
		 * Load and action channel basic info page
		 * 
		 */
		function channelSetting()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_channel');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$channelId=$_GET['channelId'];
				$channel = $this->model_channel->getChannelbyChannelId(array($channelId));
				$this->assign("channelId",$channelId);
				$this->assign("description_",$channel['description']);
				$this->assign("title_",$channel['channel_name']);
				$this->loadTemplate(CHANNEL_TEMPLATE_DIR.'view_channel_channelsetting');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$channelDescription=$_POST['description'];
				$channelName=$_POST['title'];
				$channelId=$_POST['channelId'];
				$this->model_channel->updateChannelTileByChannelId(array($channelName,$channelId));
				$this->model_channel->updateChannelDescriptionByChannelId(array($channelDescription,$channelId));
				$channel=$this->model_channel->getChannelbyChannelId(array($channelId));
				$this->assign('successMessage',$this->loadMessages('channel.setting.successful'));
				$this->assign('description_',$channelDescription);
				$this->assign('title_',$channelName);
				$this->assign('channelId',$channelId);
				$this->loadTemplate(CHANNEL_TEMPLATE_DIR.'view_channel_channelsetting');
			}
			
		}
		/**
		 * Load defaul channel delete page
		 * 
		 */
		function channelDeleteMessagesSource()
		{
			$this->defaultChannelMessagesSource();
			
			$this->assign("name", $this->loadMessages('channel.delete.name'));
			$this->assign('question', $this->loadMessages('channel.delete.question'));
			$this->assign('hint', $this->loadMessages('channel.delete.hint'));
			
			$this->assign('errorDescription', $this->loadErrorMessage('error.channel.create.description'));
		}
		
		/**
		 * Load defaul and action for channel delete page
		 * 
		 */
		function channelDelete()
		{
			$userId = $this->getLoggedUser();
			if($userId == 0)
			{
				$this->redirect($this->ctx().'/auth/login/');
				return;
			}
			$this->loadModel('model_channel');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$channelId=$_GET['channelId'];
				$channel = $this->model_channel->getChannelbyChannelId(array($channelId));
				$this->assign("channelId",$channelId);
				$this->assign("title",$channel['channel_name']);
				$this->loadTemplate(CHANNEL_TEMPLATE_DIR.'view_channel_channeldelete');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$channelId=$_POST['channelId'];
				$channel = $this->model_channel->getChannelbyChannelId(array($channelId));
				$this->assign("channelId",$channelId);
				$this->assign("title",$channel['channel_name']);
				$this->model_channel->dropChannelByChannelId(array($channelId));
				$this->model_channel->dropChannelVideoByChannelId(array($channelId));
				$this->redirect($this->ctx().'/user/album/albumsetting');
			}
		}
		
	}

?>
