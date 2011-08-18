<?php
	require_once 'MDB2.php';
	/**
	 * 
	 * Login model
	 *
	 */
	class model_channel extends Model
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
		 *  add new channel
		 *@param params 
		 */
		function addNewChannel($params)
		{
			$sql = 'INSERT INTO channel(user_id,channel_name,description) VALUES (?, ?, ?)';
			$types = array('integer' ,'text', 'text');
			$this->execute_command($sql, $params, $types);
			return $this->getLatestInsertId('channel');
		}
	     /**
		 * get channel by channelId
		 * @param params
		 */
		function getChannelbyChannelId($params)
		{
			$sql = 'SELECT * FROM channel WHERE id=?';
			$types = array('integer');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		/**
		 * update Channel title by ChannelId
		 * @param params
		 */
		function updateChannelTileByChannelId($params)
		{
			$sql = 'Update channel Set channel_name=? where id=? ';
			$types= array('text','integer');
			$res = $this->execute_command($sql,$params,$types);
		}
		/**
		 * update AlbumDescription by AlbumId
		 * @param params
		 */
		function updateChannelDescriptionByChannelId($params)
		{
			$sql = 'Update channel Set description=? where id=? ';
			$types= array('text','integer');
			$res = $this->execute_command($sql,$params,$types);
		}
		/**
		 * delete  from channel by channelId
		 * @param params
		 */
		function dropChannelByChannelId($params)
		{
			$sql = 'delete from channel where id=?';
			$types = array('integer');
			$this->execute_command($sql, $params, $types);
		}
		
		/**
		 * delete  from album by albumId
		 * @param params
		 */
		function dropChannelVideoByChannelId($params)
		{
			$sql = 'delete from channel_video where channel_id=?';
			$types = array('integer');
			$this->execute_command($sql, $params, $types);
		}
		/**
		 * get video id by channelId
		 * @param params
		 */
		function getVideoIdByChannelId($params)
		{
			$sql= 'select id from video v inner join channel_video cv on v.id=cv.video_id
			where cv.channel_id=?';
			$types =  array('text','integer');
			$res = $this->execute_query($sql,$params,$types);
			return sizeof($res) > 0;
		}
		/**
		 * get video thumbnails by channelid 
		 */
		
		function getVideoThumbnailsByChannelId($params)
		{					
			$sql = 'select * from video v inner join channel_video cv on v.id=cv.video_id 
			where cv.channel_id=? and v.user_id=?';
			$types = array('integer','integer');
			$res = $this->execute_query($sql,$params,$types);		
			return $res;
		}
		/**
		 * update video.thumbnail to album.thumbnail
		 * @param params
		 */
		
		function updateVideoThumbnailToChannelThumbnail($params)
		{
			$sql = 'Update channel Set thumbnails_path=? where id=? ';
			$types= array('text','integer');
			$res = $this->execute_command($sql,$params,$types);
		}
		
		function selectChannelsByUserId($id, $limit = 0, $offset = 0, $term = '', $sort_column = 'creation_date', $sort_order = 'ASC'){
			$types = array();
			$params = array(); 
			$sql = "select 
						a.id as `channel_id`, 
						a.channel_name as `channel_name`, 
						a.thumbnails_path as `thumbnails_path`,
						count(b.video_id) as 'video_count', 
						a.creation_date as 'create_date' 
					from 
						channel a 
					left outer join 
						channel_video b 
					on 
						b.channel_id = a.id 
					where
						a.user_id = ? ";
			
			$types[] = 'integer';
			$params[] = $id;
			
			if(!empty($term)){
				$term = str_replace('%', '\%', $term);
				$sql .= " and (a.channel_name like ? or a.description like ?) ";
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
		
		function countChannelByUserId($id, $limit = 0, $offset = 0, $term = '')
		{
			$types = array();
			$params = array(); 
			$sql = "select 
						count(a.id) as `count` 
					from 
						channel a 
					where
						a.user_id = ? ";
			
			$types[] = 'integer';
			$params[] = $id;
			
			if(!empty($term)){
				$term = str_replace('%', '\%', $term);
				$sql .= " and (a.channel_name like ? or a.description like ?) ";
				$types[] = 'text';
				$types[] = 'text';
				$params[] = '%' . $term . '%';
				$params[] = '%' . $term . '%';
			}
			$res = $this->execute_query($sql,$params,$types);
			
			return ($res[0] && $res[0]['count']) ? $res[0]['count'] : 0;
		}
		
		function updateChannelArrangeByChannelId($params)
		{
			$sql = 'Update channel Set arrange=? where id=? ';
			$types= array('integer','integer');
			$res = $this->execute_command($sql,$params,$types);
			return $res;
		}
		
		function getChannelByUserId($params){
			$sql = "select * from channel where user_id=?";
			$types= array('integer');
			$res = $this->execute_query($sql,$params,$types);
			return $res;
		}
		
		function getChannelByVideoId($params){
			$sql = "Select channel_id from channel_video where video_id=?";
			$types= array('integer');
			$res = $this->execute_query($sql,$params,$types);
			return $res;
		}
		
		/**
		 * get channels of other users not by the specific user
		 */
		function getChannelOfOther($params){
			$sql = "SELECT * FROM channel WHERE user_id!=?";
			$types= array('integer');
			$res = $this->execute_query($sql,$params,$types);
			return $res;
		}
		/**
		 * check channelId exist
		 * @param param
		 */
		function isExistChannelId($params)
		{
			$sql = 'select id from channel where id=?';
			$types =  array('integer', 'integer');
			$res = $this->execute_query($sql,$params,$types);	
			return sizeof($res) > 0;
		}
		/**
		 * check channelId by userid
		 * @param param
		 */
		function checkChannelIdByUserId($params)
		{
			$sql = 'select id from channel where user_id=? and id=?';
			$types =  array('integer', 'integer', 'integer');
			$res = $this->execute_query($sql,$params,$types);			
			return sizeof($res) > 0;
		}
		
		
		/**
		 * 
		 * Get all channels
		 */
		function getChannels(){
			$sql = "SELECT * FROM channel";
			$res = $this->execute_query($sql);
			return $res;
		}
		
		/**
		 * get videoids by channelId
		 * @param params
		 */
		function getVideoIdsByChannelId($params, $sort_column = 'creation_date', $sort_order = 'ASC')
		{
			$sql= "select * from video v inner join channel_video cv on v.id=cv.video_id
			where cv.channel_id=? order by v.{$sort_column} {$sort_order}";
			$types =  array('integer','integer');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res ;
			}
			return null;
		}
		/**
		 * 
		 */
		function getVideoNotByChannelId($params, $sort_column = 'creation_date', $sort_order = 'ASC')
		{
			$sql= "SELECT * FROM video v WHERE (v.user_id=? AND v.id NOT IN(
					SELECT cv.video_id
					FROM channel_video cv
					WHERE cv.channel_id =?
					))
					OR (v.id IN (
					SELECT cv.video_id
					FROM channel_video cv
					WHERE cv.channel_id =?
					))
					order by v.{$sort_column} {$sort_order}";
			$types =  array('integer','integer','integer','integer','integer');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res ;
			}
			return null;	
		}
	}
?>