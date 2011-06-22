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
	}
?>