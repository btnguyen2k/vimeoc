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
		/**
		 * 
		 *Get Fullname by user Id
		 * @param $params
		 */
		function getFullNamebyUserId($params)
		{
			$sql= 'select full_name from user where id=?';
			$types =  array('text','integer');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		/**
		 * 
		 *Get play by user Id ...
		 * @param $params
		 */
		function getPlaybyUserId($params)
		{
			$sql= 'select play_count from video where user_id=?';
			$types =  array('text','integer');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		/**
		 *  
		 * Get comment by user Id ...
		 * @param $params
		 */
		function getCommentbyId($params)
		{	
			$sql= 'select comment_count from video where id=?';
			$types =  array('text','integer');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		/**
		 * Get likes by user Id
		 */
		function getLikebyId($params)
		{	
			$sql= 'select like_count from video where id=?';
			$types =  array('text','integer');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		/**
		 * Get albumid by videoid
		 */
		function getAlbumIdByVideoId($params)
		{
			$sql= 'select album_id from album_video av inner join video v on av.album_id=v.id
			where v.id=?';
			$types =  array('text','integer');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		
		
		/**
		 * Get Album by userID
		 * 
		 */
		function getAlbumbyId($params)
		{	
			$sql= 'select album_name from album where id=? and user_id=?';
			$types =  array('text','integer','integer');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		/**
		 * update title by Id
		 * @param $params
		 */
		function updateTitlebyId($params)
		{
			$sql = "Update video Set video_title=? where id=? ";
			$types= array('text','integer');
			$res = $this->execute_command($sql,$params,$types);
		}
		/**
		 * 
		 * update description by Id
		 * @param $params
		 */
		function updateDescriptionbyId($params)
		{
			$sql = "Update video Set description=? where id=? ";
			$types= array('text','integer');
			$res = $this->execute_command($sql,$params,$types);
		}
		
		/**
		 * select tag by tag_ID
		 * @param $params
		 */
		
		function getTagfromTagandTagcomponent($params)
		{
			$sql = "select name from tag t inner join tag_component tc on t.id=tc.tag_id
			where tc.component_type=? and tc.component_id=? ";
			$types= array('integer','integer');
			$res = $this->execute_query($sql,$params,$types);
			return $res;
		}
		
		/**
		 * select video from video
		 * @param $params
		 */
		
		function getVideofromVideoId($params)
		{
			$sql = "select* from video v inner join tag_component tc on v.id=tc.component_id 
			where v.id=? and tc.component_id=?";
			$types = array('integer','integer');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		/**
		 * update video by video id
		 * @param $params
		 */
		
		function updateVideobyVideoId($params)
		{
			$sql = "Update video Set video_title=? and description=? where id=? ";
			$types= array('text','text','integer');
			$res = $this->execute_command($sql,$params,$types);
		}
		
		/**
		 * select album by album id
		 * @param $params
		 */
		
		function getAlbumByUserId($params)
		{
			$sql = "select * from album where user_id=?";
			$types= array('text','integer');
			$res = $this->execute_query($sql,$params,$types);
			return $res;
		}
		/**
		 * select video by video id
		 * @param $params
		 */
		function getVideoByVideoId($params)
		{
			$sql= "select video_title from video where user_id=? and id=?";
			$type= array('text','integer','integer');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		
		/**
		 * insert video to album_video by album_name
		 * @param $params
		 */
		function addVideoToAlBum($params)
		{
			$sql = 'INSERT INTO album_video(album_id, video_id) VALUES (?, ?)';
			$types = array('integer', 'integer');
			$this->execute_command($sql, $params, $types);
		}
		
		/**
		 * select album_id by album_name
		 * @param $params
		 */
		function getAlbumId($params)
		{
			$sql= 'select id from album where album_name=?';
			$type= array('text','text');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		/**
		 * check albumid and videoid
		 * @param $params
		 */
		function isExist($params)
		{
			$sql = 'select album_id,video_id from album_video where album_id=? and video_id=?';
			$types =  array('integer', 'integer','integer','integer');
			$res = $this->execute_query($sql,$params,$types);	
			return sizeof($res) > 0;
		}
		/**
		 * drop albumid and videoid
		 * @param $params
		 */
		function dropAlbumIdAndVideoId($params)
		{
			$sql = 'delete from album_video where album_id=? and video_id=?';
			$types = array('integer', 'integer');
			$this->execute_command($sql, $params, $types);
		}
		
	}
?>