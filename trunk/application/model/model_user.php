<?php 
	require_once 'MDB2.php';
	/**
	 * 
	 * Login model
	 *
	 */
	class model_user extends Model
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
		function addNewUser($params)
		{					
			// insert new user
			$sql = 'INSERT INTO user(full_name, username, password, email) VALUES (?, ?, ?, ?)';
			$types = array('text', 'text', 'text', 'text');
			$this->execute_command($sql, $params, $types);
			
			// insert user role
			$userId = $this->getLatestInsertId('user');
			$role = $this->getRoleByName(ROLE_USER);			
			if($role != null)
			{
				$sql = 'INSERT INTO user_role(user_id, role_id) VALUES(?, ?)';
				$types = array('integer', 'integer');
				$values = array($userId, $role['id']);
				$this->execute_command($sql, $values, $types);
			}
			
			return $userId;
		}
		
		/**
		 * Get role by name
		 * @param $name
		 */
		
		function getRoleByName($name)
		{
			$sql = 'SELECT * FROM role WHERE name=?';
			$types = array('text');
			$values = array($name);
			$roles = $this->execute_query($sql, $values, $types);
			if(sizeof($roles) > 0)
			{
				return $roles[0];
			}
			
			return null;
		}
		
		/**
		 * 
		 * Check whether username exists or not
		 * @param $params
		 */
		
		function isExists($params)
		{
			$sql = 'select username from user where username=?';
			$types =  array('text', 'text');
			$res = $this->execute_query($sql,$params,$types);
			
			return sizeof($res) > 0;
		}
		
		/**
		 * 
		 * Validate username and password
		 * @param $params
		 */
		
		function checkUsernameAndPassword($params)
		{
			$sql = 'select username from user where username=? and password=?';
			$types = array('text', 'text', 'text');
			$res = $this->execute_query($sql,$params,$types);		
			return sizeof($res) > 0;
		}
		
		/**
		 * Validate password
		 * @param $params
		 */
		
		function checkPassword($params)
		{
			$sql = 'select password from user where password=? and id=?';
			$type =  array('text','text','text');
			$res = $this->execute_query($sql,$params,$type);
			
			return sizeof($res) >0;
		}
		
		/**
		 * validate username
		 * @param $params
		 */
		
		function checkUsername($params)
		{
			$sql = 'select username from user where username=?';
			$types= array('text','text');
			$res=$this->execute_query($sql,$params,$types);
			return sizeof($res) > 0;
		}
		
		
		/**
		 * 
		 * Get user by username
		 * @param $params username value
		 */
		
		function getUserByUsername($params)
		{
			$sql = 'SELECT * FROM user WHERE username=?';
			$types = array('text');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		
		/**
		 * 
		 * Get user by user id
		 * @param $params
		 */
		
		function getUserByUserId($params)
		{
			$sql = 'select * from user where id=?';
			$types = array('integer');
			$res = $this->execute_query($sql,$params,$types);
			
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		/**
		 * Get video by video id
		 * @param $params
		 */
		function getVideoByVideoId($params)
		{
			$sql = 'select * from video where id=?';
			$types = array('integer');
			$res = $this->execute_query($sql,$params,$types);
			
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		
		
		/**
		 * 
		 * Get user by username
		 * 
		 */
		
		function getUsersByUsername($params)
		{
			$sql = 'select * from user where username=?';
			$types = array('text');
			$res = $this->execute_query($sql,$params,$types);
			
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			
			return null;
		}
		
		/**
		 * update password 
		 * @param $params
		 */
		
		function updatePassword($params)
		{
			$sql = "Update user Set password=? where username=? ";
			$types= array('text','text');
			$res = $this->execute_command($sql,$params,$types);
		}
		
		/**
		 * 
		 * Update user information (fullName, email and website)
		 * @param $user
		 */
		
		function updateUserInformation($params)
		{
			$sql = 'UPDATE user SET full_name=?, email=?, website=? where id=?';
			$type = array('text', 'text', 'text', 'integer');
			return $this->execute_command($sql, $params, $types);
		}
		
		/**
		 * Update user password
		 * @param $password
		 */
		
		function updateUserPassword($params)
		{
			$sql = 'Update user set password=? where id=?';
			$type =  array('text','integer');
			return $this->execute_command($sql, $params, $type);
			
		}
		
		/**
		 * 
		 * Update user avatar
		 * @param $params
		 */
		
		function updateUserAvatar($params)
		{
			$sql = 'UPDATE user SET avatar=? WHERE id=?';
			$types = array('text', 'text');
			return $this->execute_command($sql, $params, $types);
		}
		
		/**
		 * Select fullname by User Id
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
		 * Check if the alias exists?
		 * @param $params
		 */
		
		function existsAlias($params)
		{
			$sql = 'SELECT profile_alias FROM user WHERE profile_alias =? and id !=?';
			$types = array('text', 'text', 'integer');
			$res = $this->execute_query($sql, $params, $types);
			
			return sizeof($res) > 0;
		}
		
		/**
		 * Update user alias
		 * @param $params
		 */
		
		function updateUserAlias($params)
		{
			$sql = 'UPDATE user SET profile_alias =? WHERE id=?';
			$types = array('text', 'integer');
			return $this->execute_command($sql, $params, $types);
		}
		
		/**
		 * Select full name by profile_Alias
		 * @param $params
		 */
		
		function getFullnameByProfileAlias($params)
		{
			$sql= 'select full_name from user where profile_alias=?';
			$types =  array('text','text');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		
		/**
		 * 
		 * Get video by userid and video id
		 * @param $params
		 */
		
		function getVideoByVideoIdAndUserId($params)
		{
			$sql= "select video_title from video where user_id=? and id=?";
			$types= array('text','integer','integer');
			$res = $this->execute_query($sql,$params,$types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		
		function getUserByUserAlias($params){
			$sql = "select * from user where profile_alias=?";
			$types = array('text');
			$res = $this->execute_query($sql, $params, $types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		
		function isAdmin($params){
			$sql = "Select count(1) From user_role ur, role r where ur.role_id = r.id and ur.user_id = ? and r.name = ?";
			$types = array('integer','integer','text');
			$result = $user_model->execute_query($sql, $params);
			return sizeof($resuls) > 0;
		}
		/**
		 * update enable user
		 * @param $params
		 */
		function updateEnableAccount($params){
			$sql = 'UPDATE user SET account_enabled =1 WHERE id=?';
			$types = array('integer');
			return $this->execute_command($sql, $params, $types);
		}
		/**
		 * update disable user
		 * @param $params
		 */
		function updateDisableAccount($params){
			$sql = 'UPDATE user SET account_enabled =0 WHERE id=?';
			$types = array('integer');
			return $this->execute_command($sql, $params, $types);
		}
		/**
		 * delete video by user
		 * @param $params
		 */
		function dropVideoByUserId($params)
		{
			$sql = 'delete from video where user_id=?';
			$types = array('integer');
			$this->execute_command($sql, $params, $types);
		}
		/**
		 * delete album by user
		 * @param $params
		 */
		function dropAlbumByUserId($params)
		{
			$sql = 'delete from album where user_id=?';
			$types = array('integer');
			$this->execute_command($sql, $params, $types);
		}
		/**
		 * delete channel by user
		 * @param $param
		 */
		function dropChannelByUserId($params)
		{
			$sql = 'delete from channel where user_id=?';
			$types = array('integer');
			$this->execute_command($sql, $params, $types);
		}
		/**
		 * delete role by user
		 * @param $param
		 */
		function dropRoleByUserId($params)
		{
			$sql = 'delete from user_role where user_id=?';
			$types = array('integer');
			$this->execute_command($sql, $params, $types);
		}
	}
?>