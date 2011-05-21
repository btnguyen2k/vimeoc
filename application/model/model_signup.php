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
		function addNewUser($params)
		{
			$sql = "INSERT INTO user (full_name, username, password) VALUES (?, ?, ?)";
			$result = $this->execute_query($sql, $params);
		}
	}

?>