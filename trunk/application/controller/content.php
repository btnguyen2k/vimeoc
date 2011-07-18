<?php 
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
		
		function load(){
			// load content via content alias
			echo $_GET['alias'];
			
			// load content via content id
			echo $_GET['id'];
			
			// check if alias exist, then load by alias ortherwise, try the content id
		}
	}
?>