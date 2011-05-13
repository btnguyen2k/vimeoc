<?php 
	/**
	 * 
	 * The homepage controller
	 * @author Tri
	 *
	 */
	class Home extends Application 
	{
		/**
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{			
			$this->loadModel('model_home');	
			$this->tmpl = &$tmpl;		
		}
	
		/**
		 * 
		 * Default action
		 */
		function index()
		{
			$articles = $this->model_home->select();
			//$data['articles'] = $articles;
			$this->tmpl->assign("title", "Hello world!");
			$this->loadView('view_home',$data);
		}
	}
?>