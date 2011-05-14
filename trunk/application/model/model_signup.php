<?php 
	require_once 'MDB2.php';
	/**
	 * 
	 * Login model
	 *
	 */
	class model_signup extends Model
	{
		/**
		 * 
		 * Constructor
		 */
		function __construct()
		{
			parent::__construct();
		}
	
		/**
		 * 
		 * Select data
		 */
		function select()
		{
			return array("title 1","title 2","title 3");
		}
	}

?>