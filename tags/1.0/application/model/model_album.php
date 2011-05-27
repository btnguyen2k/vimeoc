<?php 
	require_once 'MDB2.php';
	/**
	 * 
	 * Login model
	 *
	 */
	class model_album extends Model
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
		 * Select album by user id
		 */
		function selectAlbumByUserId($params)
		{					
			$sql = 'select 
						album_name 
					from 
						album 
					where 
						user_id=?';
			$types = array('integer');
			$res = $this->execute_query($sql,$params,$types);
			
			return $res;
		}
		
		/**
		 * 
		 * Select count album by user id
		 */
		function countAlbumByUserId($params)
		{					
			$sql = 'select 
						count(id) as `count` 
					from 
						album 
					where 
						user_id=?';
			$types = array('integer');
			$res = $this->execute_query($sql,$params,$types);
			return $res[0]['count'];
		}
	}
?>