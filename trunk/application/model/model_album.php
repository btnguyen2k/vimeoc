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
		
		function selectAlbumsByUserId($id, $limit = 0, $offset = 0, $term = '', $sort_column = 'creation_date', $sort_order = 'ASC')
		{
			$types = array();
			$params = array(); 
			$sql = "select 
						a.id as 'album_id', 
						a.album_name as 'album_name', 
						count(b.video_id) as 'video_count', 
						a.creation_date as 'create_date',
						thumbnails_path as 'thumbnails_path' 
					from 
						album a 
					left outer join 
						album_video b 
					on 
						b.album_id = a.id 
					where
						a.user_id = ? ";
			
			$types[] = 'integer';
			$params[] = $id;
			
			if(!empty($term)){
				$term = str_replace('%', '\%', $term);
				$sql .= " and (a.album_name like ? or a.description like ?) ";
				$types[] = 'text';
				$types[] = 'text';
				$params[] = '%' . $term . '%';
				$params[] = '%' . $term . '%';
			}
			
			$sql .= "group by a.id order by a.{$sort_column} {$sort_order} ";
			
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
		 * check albumId exist
		 * @param param
		 */
		function isExistAlbumId($params)
		{
			$sql = 'select id from album where id=?';
			$types =  array('integer', 'integer');
			$res = $this->execute_query($sql,$params,$types);
			
			return sizeof($res) > 0;
		}
		
		/**
		 * 
		 * Select count album by user id
		 */
		function countAlbumByUserId($id, $limit = 0, $offset = 0, $term = '')
		{
			$types = array();
			$params = array(); 
			$sql = "select 
						count(a.id) as `count` 
					from 
						album a 
					where
						a.user_id = ? ";
			
			$types[] = 'integer';
			$params[] = $id;
			
			if(!empty($term)){
				$term = str_replace('%', '\%', $term);
				$sql .= " and (a.album_name like ? or a.description like ?) ";
				$types[] = 'text';
				$types[] = 'text';
				$params[] = '%' . $term . '%';
				$params[] = '%' . $term . '%';
			}
			$res = $this->execute_query($sql,$params,$types);
			
			return ($res[0] && $res[0]['count']) ? $res[0]['count'] : 0;
		}
		/**
		 *  add new album
		 *@param params 
		 */
		function addNewAlbum($params)
		{
			$sql = 'INSERT INTO album(user_id,album_name, description) VALUES (?, ?, ?)';
			$types = array('integer' ,'text', 'text');
			$this->execute_command($sql, $params, $types);
			return $this->getLatestInsertId('album');
		}
		/**
		 * get album by albumId and userId
		 * @param params
		 */
		function selectAlbumById($albumId)
		{
			$sql = 'SELECT 
						id as `album_id`, 
						user_id as `user_id`, 
						album_name as `album_name`, 
						album_locked as `album_alias`, 
						creation_date as `creation_date`, 
						description as `description`,
						thumbnails_path as `thumbnails_path`, 
						arrange as `arrange`, 
						password as `password`  
					FROM 
						album 
					WHERE 
						id = ?';
			$types = array('integer');
			$params = array($albumId);
			$res = $this->execute_query($sql,$params,$types);
			
			if(is_array($res) && count($res) > 0){
				return $res[0] ;
			}
			return null;
		}
		/**
		 * get album by albumId and userId
		 * @param params
		 */
		function getAlbumbyAlbumIdAndUserId($params)
		{
			$sql = 'SELECT * FROM album WHERE id=? and user_id=?';
			$types = array('integer','integer');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		/**
		 * update AlbumTitle by AlbumId
		 * @param params
		 */
		function updateAlbumTileByAlbumId($params)
		{
			$sql = 'Update album Set album_name=? where id=? ';
			$types= array('text','integer');
			$res = $this->execute_command($sql,$params,$types);
		}
		/**
		 * update AlbumDescription by AlbumId
		 * @param params
		 */
		function updateAlbumDescriptionByAlbumId($params)
		{
			$sql = 'Update album Set description=? where id=? ';
			$types= array('text','integer');
			$res = $this->execute_command($sql,$params,$types);
		}
		/**
		 * get video thumbnails by albumid 
		 */
		
		function getVideoThumbnailsByAlbumId($params)
		{					
			$sql = 'select * from video v inner join album_video av on v.id=av.video_id 
			where av.album_id=? and v.user_id=?';
			$types = array('integer','integer');
			$res = $this->execute_query($sql,$params,$types);		
			return $res;
		}
		/**
		 * update video.thumbnail to album.thumbnail
		 * @param params
		 */
		
		function updateVideoThumbnailToAlbumThumbnail($params)
		{
			$sql = 'Update album Set thumbnails_path=? where id=? ';
			$types= array('text','integer');
			$res = $this->execute_command($sql,$params,$types);
		}
		/**
		 * get avideo id by albumId
		 * @param params
		 */
		function getVideoIdByAlbumId($params)
		{
			$sql= 'select id from video v inner join album_video av on v.id=av.video_id
			where av.album_id=?';
			$types =  array('integer','integer');
			$res = $this->execute_query($sql,$params,$types);
			return sizeof($res) > 0;
		}
		/**
		 *  update password by userid and album id
		 *  @param params
		 */
		function updatePasswordByUserIdandAlbumId($params)
		{
			$sql = 'Update album Set password=? where id=? and user_id=?';
			$types= array('text','integer','integer');
			$res = $this->execute_command($sql,$params,$types);
		}
		
		/**
		 * delete  from album by albumId
		 * @param params
		 */
		function dropAlbumByAlbumId($params)
		{
			$sql = 'delete from album where id=?';
			$types = array('integer');
			$this->execute_command($sql, $params, $types);
		}
		
		/**
		 * delete  from album by albumId
		 * @param params
		 */
		function dropAlbumVideoByAlbumId($params)
		{
			$sql = 'delete from album_video where album_id=?';
			$types = array('integer');
			$this->execute_command($sql, $params, $types);
		}

		/**
		 * update AlbumTitle by AlbumId
		 * @param params
		 */
		function updateAlbumArrangeByAlbumId($params)
		{
			$sql = 'Update album Set arrange=? where id=? ';
			$types= array('integer','integer');
			$res = $this->execute_command($sql,$params,$types);
			return $res;
		}
		
		/**
		 * update albumAlias by AlbumId
		 * @param params
		 */
		function updateAlbumAliasByAlbumId($params)
		{
			$sql = 'Update album Set album_alias=? where id=? ';
			$types= array('text','integer');
			$res = $this->execute_command($sql,$params,$types);
			return $res;
		}
		
		function getAlbumByAlbumAlias($params){
			$sql = "Select * from album where album_alias=? and user_id=?";
			$types = array('text','integer');
			$res = $this->execute_query($sql, $params, $types);
			if(sizeof($res) > 0){
				return $res[0];
			}
			return null;
		}
		/**
		 * 
		 *check duplicated alias
		 * @param $params
		 */
		function isAliasExist($params)
		{					
			$sql = 'select 
						count(id) as `count` 
					from 
						album 
					where 
						album_alias=? and user_id=?';
			$types = array('text','integer');
			$res = $this->execute_query($sql,$params,$types);
			return $res[0]['count'];
		}
		/**
		 * check album bu userId
		 * @param params
		 */
		function checkUserId($params)
		{
			$sql='select user_id from album where id=?';
			$types =  array('integer','integer');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
	}
?>