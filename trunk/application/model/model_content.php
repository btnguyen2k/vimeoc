<?php
	require_once 'MDB2.php';
	/**
	 * 
	 * Login model
	 *
	 */
	class model_content extends Model
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
		 * Check whether alias
		 * @param $params
		 * 
		 */
		
		function isAliasExists($params)
		{					
			$sql = 'select 
						count(alias) as `count` 
					from 
						content 
					where 
						alias=?';
			$types = array('text');
			$res = $this->execute_query($sql,$params,$types);
			return $res[0]['count'];
		}
			/**
		 * 
		 * Check whether id
		 * @param $params
		 * 
		 */
		
		function isIdExists($params)
		{					
			$sql = 'select 
						count(id) as `count` 
					from 
						content 
					where 
						id=?';
			$types = array('integer');
			$res = $this->execute_query($sql,$params,$types);
			return $res[0]['count'];
		}
		
		/**
		 * get content by alias
		 * @param $params
		 */
		function getContentByAlias($params)
		{
			$sql = "select * from content where alias=?";
			$types = array('text');
			$res = $this->execute_query($sql, $params, $types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		
		/**
		 * get content by id 
		 * @param $params
		 */
		function getContentById($params)
		{
			$sql = "select * from content where id=?";
			$types = array('integer');
			$res = $this->execute_query($sql, $params, $types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
	}
?>