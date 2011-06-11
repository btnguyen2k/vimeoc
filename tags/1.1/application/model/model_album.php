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
		 * Select album by video id
		 */
		function selectAlbumByVideoId($videoId)
		{			
			$sql = 'select distinct 
						album_id as `album_id`, 
						album_name as `album_name`
					from 
						album as a 
					join 
						album_video as b 
					on 
						a.id = b.album_id and b.video_id = ?';
			$types = array('integer');
			$params = array($videoId);
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