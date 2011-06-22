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
	}
?>