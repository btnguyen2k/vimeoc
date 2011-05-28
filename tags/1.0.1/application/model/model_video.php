<?php 
	require_once 'MDB2.php';
	/**
	 * 
	 * Login model
	 *
	 */
	class model_video extends Model
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
		function selectVideoByUserId($id, $limit = 0, $offset = 0, $sort_column = 'creation_date', $sort_order = 'ASC')
		{
			$types = array();
			$params = array(); 
			$sql = "select 
						id as `id`,
						video_path as `video_path`,
						thumbnails_path as `thumbnails_path` 
					from 
						video 
					where 
						user_id = ?
					order by {$sort_column} {$sort_order} ";
			$types[] = 'integer';
			
			$params[] = $id;
			//var_dump($sql);
			if($limit > 0){
				$sql .= ' limit ? offset ?';
				$types[] = 'integer';
				$types[] = 'integer';
				$params[] = $limit;
				$params[] = $offset;
			}
			$res = $this->execute_query($sql,$params,$types);

			return $res;
		}

		/**
		 * 
		 * Select data
		 */
		function countVideoByUserId($params)
		{					
			$sql = 'select 
						count(id) as `count` 
					from 
						video 
					where 
						user_id = ? ';
			$types = array('integer');
			$res = $this->execute_query($sql,$params,$types);
			return $res[0]['count'];
		}
	}
?>