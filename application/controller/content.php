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
					$this->loadTemplate('view_404');
					return;
				}
				else 
				{
					$content=$this->model_content->getContentById(array($id));
					if($content['publish']=='1')
					{
						$this->assign('content',$content);
						$this->assign('keywords', $content['keywords']);
						$this->assign('title', $content['title']);
					}
					else 
					{
						$this->loadTemplate('view_404');
						return;
					}
				}
			}
			else 
			{
				$content=$this->model_content->getContentByAlias(array($alias));
				if($content['publish']=='1')
				{
					$this->assign('content',$content);				
					$this->assign('keywords', $content['keywords']);
					$this->assign('title', $content['title']);
				}
				else 
				{
					$this->loadTemplate('view_404');
					return;
				}
			}
			
			$model_category = $this->getModel('model_category');
			$userCategory = $model_category->loadCategoryByName(array('user'));			
			if($userCategory != null && $content['category_id'] == $userCategory['id']){
				$model_content = $this->getModel('model_content');
				$contents = $model_content->loadPublishedContentByCategory(array($userCategory['id']));				
				$this->assign("contentLinkList", $contents);
			}	
			
			$this->loadTemplate(CONTENT_TEMPLATE_DIR.'view_content');
		}
		/**
		 * publish content
		 * 
		 */
		
		function publishContent()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/login');
				return;
			}	
			$this->loadModel('model_content');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$contentId=$_GET['contentId'];
				$this->model_content->publishContent(array($contentId));
				$this->redirect($this->ctx().'/admin/contentList');
			}
		}
		/**
		 * 
		 * Unpublish content
		 */
		function unpublishContent()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/login');
				return;
			}	
			$this->loadModel('model_content');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$contentId=$_GET['contentId'];
				$this->model_content->unpublishContent(array($contentId));
				$this->redirect($this->ctx().'/admin/contentList');
				
			}
		}
		/**
		 * delete content
		 * 
		 */
		function deleteContent()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/login');
				return;
			}
			$this->loadModel('model_content');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$contentId=$_GET['contentId'];
				$res=$this->model_content->isExistContentId(array($contentId));
				if($res==0)
				{
					$this->loadTemplate('view_404');
					return;
				}
				$this->model_content->dropContentById(array($contentId));
				$this->redirect($this->ctx().'/admin/contentlist');
			}
		}
		/**
		 * function create new content messeage source
		 * 
		 */
		function createNewContentMessagesSource()
		{
			$this->assign("title",$this->loadMessages('admin.content.title'));
			$this->assign("alias", $this->loadMessages('admin.content.alias'));
			$this->assign("body",$this->loadMessages('admin.content.body'));
			$this->assign("keyword", $this->loadMessages('admin.content.keyword'));
			$this->assign("publish",$this->loadMessages('admin.content.publish'));
			$this->assign("name",$this->loadMessages('admin.content.name'));
			$this->assign("categoryLable",$this->loadMessages('admin.content.category'));
			
			$this->assign('titleInvalid', $this->loadErrorMessage('error.title.invalid'));
			$this->assign('aliasInvalid', $this->loadErrorMessage('error.alias.invalid'));
			$this->assign('bodyInvalid', $this->loadErrorMessage('error.body.invalid'));
			$this->assign('keywordInvalid', $this->loadErrorMessage('error.keyword.invalid'));
		}
		/**
		 * function create new content
		 * 
		 */
		function createNewContent()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/login');
				return;
			}
			$userId = $this->getLoggedUser();
			$this->loadModel('model_content');
			$this->loadModel('model_category');
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$categories=$this->model_category->getCategory();
				if($categories==null)
				{
					$this->loadTemplate('view_404');
					return;
				}
				$this->assign('categories', $categories);
				$this->loadTemplate(CONTENT_TEMPLATE_DIR.'view_content_createnewcontent');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$title=$_POST['title'];
				$alias=$_POST['alias'];				
				$body=$_POST['body'];
				$keywords=$_POST['keywords'];
				$publish=$_POST['publish'];
				$category=$_POST['category'];
				$categories=$this->model_category->getCategory();
				if(!empty($alias)){
					$alias = strtolower($alias);
					$alias = str_replace(' ', '-', $alias); 
				}
				if($this->model_content->isAliasExist(array($alias)))
				{
					$this->assign('errorMessage', $this->loadErrorMessage('error.content.alias.aliasExists'));
				}
				else 
				{
					$res=$this->model_content->addNewContent(array($title,$alias,$body,$keywords,$publish,$userId,$userId,$category));
					if($res==0)
					{
						$this->assign("errorInsertMessage","Create New Content Failed");
					}
					$this->assign("messageSuccessful",$this->loadMessages('admin.content.successful'));
					$this->redirect($this->ctx().'/admin/contentlist');
				}
				$this->assign('title_',$title);
				$this->assign('body_',$body);
				$this->assign('keywords_',$keywords);
				$this->assign('publish_',$publish);
				$this->assign('categories', $categories);
				$this->loadTemplate(CONTENT_TEMPLATE_DIR.'view_content_createnewcontent');
			}
		}
		/**
		 * function update content messeage source
		 * 
		 */
		function updateContentMessagesSource()
		{
			$this->assign("title",$this->loadMessages('admin.contentupdate.title'));
			$this->assign("alias", $this->loadMessages('admin.content.alias'));
			$this->assign("body",$this->loadMessages('admin.content.body'));
			$this->assign("keyword", $this->loadMessages('admin.content.keyword'));
			$this->assign("publish",$this->loadMessages('admin.content.publish'));
			$this->assign("name",$this->loadMessages('admin.content.name'));
			$this->assign("categoryLable",$this->loadMessages('admin.content.category'));
			
			$this->assign('titleInvalid', $this->loadErrorMessage('error.title.invalid'));
			$this->assign('aliasInvalid', $this->loadErrorMessage('error.alias.invalid'));
			$this->assign('bodyInvalid', $this->loadErrorMessage('error.body.invalid'));
			$this->assign('keywordInvalid', $this->loadErrorMessage('error.keyword.invalid'));
		}
		/**
		 * function update content
		 */
		function updateContent()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/login');
				return;
			}
			$userId = $this->getLoggedUser();
			$this->loadModel('model_content');
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$contentId=$_GET['id'];
				$content=$this->model_content->getContent(array($contentId));
				if($content==null)
				{
					$this->loadTemplate('view_404');
					return;
				}
				$category=$this->model_content->getCategoryByContentId(array($contentId));
				$this->assign('content',$content);
				$this->assign('contentId',$contentId);
				$publish_=$content['publish'];
				$this->assign('category',$category['category_id']);
				$this->assign('publish_',$publish_);
				$this->loadTemplate(CONTENT_TEMPLATE_DIR.'view_content_updatecontent');
			}
			if ($_SERVER['REQUEST_METHOD'] == 'POST') 
			{
				$contentId=$_POST['contentId'];
				$title=$_POST['title'];
				$alias=$_POST['alias'];
				$publish=$_POST['publish'];
				$body=$_POST['body'];
				$keywords=$_POST['keywords'];
				$cContent = $this->model_content->getContent(array($contentId));
				$category =$_POST['category'];
				if($cContent['alias']!=$alias)
				{
					if($this->model_content->isAliasExist(array($alias)))
					{
						$this->model_content->updateTitle(array($title,$contentId));
						$this->model_content->updatePublish(array($publish,$contentId));
						$this->model_content->updateBody(array($body,$contentId));
						$this->model_content->updateKeyword(array($keywords,$contentId));
						$this->model_content->updateModifyDate(array($contentId));
						$this->model_content->updateModifer(array($userId,$contentId));
						$this->model_content->updateCategoryId(array($category,$contentId));
						$this->assign('errorMessage', $this->loadErrorMessage('error.content.alias.aliasExists'));
					}
					else 
					{
						$this->model_content->updateTitle(array($title,$contentId));
						$this->model_content->updateAlias(array($alias,$contentId));
						$this->model_content->updatePublish(array($publish,$contentId));
						$this->model_content->updateBody(array($body,$contentId));
						$this->model_content->updateKeyword(array($keywords,$contentId));
						$this->model_content->updateModifyDate(array($contentId));
						$this->model_content->updateModifer(array($userId,$contentId));
						$this->model_content->updateCategoryId(array($category,$contentId));
						$this->assign("successfullMessage",$this->loadMessages('admin.contentupdate.successful'));
					}
				}				
				else 
				{
					$this->model_content->updateTitle(array($title,$contentId));
					$this->model_content->updateAlias(array($alias,$contentId));
					$this->model_content->updatePublish(array($publish,$contentId));
					$this->model_content->updateBody(array($body,$contentId));
					$this->model_content->updateKeyword(array($keywords,$contentId));
					$this->model_content->updateModifyDate(array($contentId));
					$this->model_content->updateModifer(array($userId,$contentId));
					$this->model_content->updateCategoryId(array($category,$contentId));
					$this->assign("successfullMessage",$this->loadMessages('admin.contentupdate.successful'));
				}
				$this->assign('contentId',$contentId);
				$content=$this->model_content->getContent(array($contentId));
				$this->assign('content',$content);
				$publish_=$content['publish'];
				$this->assign('publish_',$publish_);
				$this->assign('category',$category);
				$this->loadTemplate(CONTENT_TEMPLATE_DIR.'view_content_updatecontent');
			}
		}
	}
?>