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
		
		/**
		 * 
		 * Check whether username exists or not
		 * @param $params
		 */
		function isExists($params)
		{
			$sql = 'select username from user where username=?';
			$types =  array('text', 'text');
			$res = $this->execute_query($sql,$params,$types);
			
			return sizeof($res) > 0;
		}
		
		/**
		 * 
		 * Validate username and password
		 * @param $params
		 */
		function checkUsernameAndPassword($params)
		{
			$sql = 'select username from user where username=? and password=?';
			$types = array('text', 'text', 'text');
			$res = $this->execute_query($sql,$params,$types);
			
			return sizeof($res) > 0;
		}
		
		/**
		 * 
		 * Get user by username
		 * @param $params username value
		 */
		function getUserByUsername($params)
		{
			$sql = 'select username from user where username=?';
			$types = array('text');
			$res = $this->execute_query($sql,$params,$types);
			
			return $res;
		}
	}
?>