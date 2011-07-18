<?php 
	define("CONTENT_TEMPLATE_DIR", "content/");
	include (BASE_DIR . '/application/uploader.php');
	/**
	 * 
	 * Content management controller
	 * @author Tri
	 *
	 */
	class Content extends Application {
		/**	
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{				
			$this->tmpl = &$tmpl;		
		}
		/**
		 * function load action message source
		 */
		function loadMessagesSource()
		{
			$this->assign("title", $this->loadMessages('content.load.title'));
			$this->assign("name", $this->loadMessages('content.load.name'));
			$this->assign("body", $this->loadMessages('content.load.body'));
			$this->assign('keyword', $this->loadMessages('content.load.keyword'));
			$this->assign('publish', $this->loadMessages('content.load.publish'));
		}
		/**
		 * 
		 * function action load
		 */
		function load(){
			
			// load content via content alias
			$alias = $_GET['alias'];
			// load content via content id
			$id = $_GET['id'];
			// check if alias exist, then load by alias ortherwise, try the content id
			$this->loadModel('model_content');
			$res= $this->model_content->isAliasExists(array($alias));
			$resId = $this->model_content->isIdExists(array($id));
			if($res==0)
			{
				if($resId==0)
				{
					$this->assign('errorMessage', $this->loadErrorMessage('error.content.found'));
				}
				else 
				{
					$content=$this->model_content->getContentById(array($id));
					$this->assign('content',$content);
				}
			}
			else 
			{
				$content=$this->model_content->getContentByAlias(array($alias));
				$this->assign('content',$content);				
			}
			$this->loadTemplate(CONTENT_TEMPLATE_DIR.'view_content');
		}
		
	}
?>