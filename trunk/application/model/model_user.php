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
			$sql = 'select * from user where username=?';
			$types =  array('text');
			$ret = $this->execute_query($sql,$params,$types);
			if($ret!=null)
			{
				return false;
			}
			else 
			{
				return true;
			}
		}
		function checkUserName($params)
		{
			$sql = 'select username, password from user where username=? and password=?';
			$types=array('text','text');
			$res=$this->execute_query($sql,$params,$types);
			echo $res;
			if($res!=null)
			{
				return false;
			}
			else 
			{
				return true;
			}
			
		}
	}
?>