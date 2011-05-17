<?php 
	require_once 'MDB2.php';
	/**
	 * 
	 * submitsucceed model
	 *
	 */
	class model_submitsucceed extends Model
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
