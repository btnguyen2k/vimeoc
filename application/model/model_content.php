<?php
	require_once 'MDB2.php';
	/**
	 * 
	 * Content model
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
		 * check content id
		 * @param param
		 */
			function isExistContentId($params)
		{
			$sql = 'select id from content where id=?';
			$types =  array('integer', 'integer');
			$res = $this->execute_query($sql,$params,$types);
			
			return sizeof($res) > 0;
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
		
		/**
		 * 
		 * Get published content by category id
		 * @param $params
		 */
		function loadPublishedContentByCategory($params){
			$sql = "select * from content where category_id = ? and publish = 1";
			$type = array('integer');
			$res = $this->execute_query($sql, $params, $types);
			return $res;
		}	
		/**
		 * publish content
		 * @param params
		 */
		function publishContent($params)
		{
			$sql = 'UPDATE content SET publish=1 WHERE id=?';
			$types = array('integer');
			return $this->execute_command($sql, $params, $types);
		}
		/**
		 * unpublish
		 * @param params
		 */
		function unpublishContent($params){
			$sql = 'UPDATE content SET publish=0 WHERE id=?';
			$types = array('integer');
			return $this->execute_command($sql, $params, $types);
		}
		/**
		 * delete
		 * @param params
		 */
		function dropContentById($params){
			$sql = 'delete from content where id=?';
			$types = array('integer');
			$this->execute_command($sql, $params, $types);
		}
		/**
		 * insert content
		 * @param params
		 */
		function addNewContent($params)
		{
			$sql = 'INSERT INTO content(title, alias, body, keywords, publish, creator_id, modifier_id, create_date, category_id ) VALUES (?, ?, ?, ? ,? ,?, ?, CURRENT_TIMESTAMP, ?)';
			$types = array('text', 'text', 'text', 'text' , 'integer', 'integer', 'integer','integer');
			$this->execute_command($sql, $params, $types);
		}
		/**
		 * get category by contentid
		 * @param params
		 */
		function getCategoryByContentId($params)
		{
			$sql = "select * from content where id=?";
			$types = array('integer');
			$res = $this->execute_query($sql, $params, $types);
			return $res[0] ;
		}
		/**
		 * getContent
		 * @param params
		 */
		function getContent($params)
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
						content 
					where 
						alias=?';
			$types = array('text');
			$res = $this->execute_query($sql,$params,$types);
			return $res[0]['count'];
		}
		/**
		 * function update title
		 * @param param
		 */
		function updateTitle($params){
			$sql = "UPDATE content SET title=? WHERE id=?";
			$types = array('text','integer');
			return $this->execute_command($sql, $params, $types);
		}
		/**
		 * function update alias
		 * @param param
		 */
		function updateAlias($params){
			$sql = "UPDATE content SET alias=? WHERE id=?";
			$types = array('text','integer');
			return $this->execute_command($sql, $params, $types);
		}
		
		/**
		 * function update publish
		 * @param param
		 */
		function updatePublish($params){
			$sql = "UPDATE content SET publish=? WHERE id=?";
			$types = array('text','integer');
			return $this->execute_command($sql, $params, $types);
		}
		
		/**
		 * function update body
		 * @param param
		 */
		function updateBody($params){
			$sql = "UPDATE content SET body=? WHERE id=?";
			$types = array('text','integer');
			return $this->execute_command($sql, $params, $types);
		}
		/**
		 * function update keyword
		 * @param param
		 */
		function updateKeyword($params){
			$sql = "UPDATE content SET keywords=? WHERE id=?";
			$types = array('text','integer');
			return $this->execute_command($sql, $params, $types);
		}
		/**
		 * function update modifer
		 * @param param
		 */
		function updateModifyDate($params){
			$sql = "UPDATE content SET modify_date=CURRENT_TIMESTAMP WHERE id=?";
			$types = array('integer');
			return $this->execute_command($sql, $params, $types);
		}
			/**
		 * function update modifername
		 * @param param
		 */
		function updateModifer($params){
			$sql = "UPDATE content SET modifier_id=? WHERE id=?";
			$types = array('integer','integer');
			return $this->execute_command($sql, $params, $types);
		}
		
		/**
		 * function update category_id
		 * @param param
		 */
		function updateCategoryId($params)
		{
			$sql = "UPDATE content SET category_id=? WHERE id=?";
			$types = array('integer','integer');
			return $this->execute_command($sql, $params, $types);	
		}
		/**
		 * get category 
		 * @param $param
		 */
		function getCategory()
		{
			$sql = "select * from category";
			$res = $this->execute_query($sql);
			if(sizeof($res) > 0)
			{
				return $res ;
			}
			return null;
		}
	}
?>