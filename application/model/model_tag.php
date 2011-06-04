<?php 
	require_once 'MDB2.php';
	/**
	 * 
	 * Login model
	 *
	 */
	class model_tag extends Model
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
		function selectTagByVideoId($videoId)
		{			
			$sql = 'select distinct 
						tag_id as `tag_id`, 
						name as `tag_name`
					from 
						tag as a 
					join 
						tag_component as b 
					on 
						a.id = b.tag_id and b.component_type = 1 and b.component_id = ?';
			$types = array('integer');
			$params = array($videoId);
			$res = $this->execute_query($sql,$params,$types);
			
			return $res;
		}
	}
?>