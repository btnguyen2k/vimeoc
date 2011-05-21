<?php 
	require_once 'MDB2.php';
	/**
	 * 
	 * Login model
	 *
	 */
	class model_user extends Model
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
		function addNewUser($params)
		{					
			$sql = 'INSERT INTO user(full_name, username, password, email) VALUES (?, ?, ?, ?)';
			$types = array('text', 'text', 'text', 'text');
			$this->execute_command($sql, $params, $types);
		}
		
		function isExists($params)
		{
			
		}
	}
?>