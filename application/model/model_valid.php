<?php 
	require_once 'MDB2.php';
	/**
	 * 
	 * Valid model
	 *
	 */
	class model_valid extends Model
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
