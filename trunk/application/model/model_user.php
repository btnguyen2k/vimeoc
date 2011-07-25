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
	
		function selectUser($limit = 0, $offset = 0, $term = '', $sort_column = 'creation_date', $sort_order = 'ASC')
		{
			$types = array();
			$params = array(); 
			$sql = "select id, username, full_name, CAST(account_enabled as unsigned integer) `enabled`, creation_date ,avatar from user u ";			
			
			if(!empty($term)){
				$term = str_replace('%', '\%', $term);
				$sql .= " where (u.username like ? or u.full_name like ?) ";
				$types[] = 'text';
				$types[] = 'text';
				$params[] = '%' . $term . '%';
				$params[] = '%' . $term . '%';
			}
			
			$sql .= "group by u.id order by u.{$sort_column} {$sort_order} ";
			
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
		 * select contents
		 * 
		 */
		function selectContent($limit = 0, $offset = 0, $term = '', $sort_column = 'create_date', $sort_order = 'ASC')
		{
			$types = array();
			$params = array(); 
			$sql = "select id, title, create_date, modify_date, creator_id, modifier_id, publish, category_id from content c ";			
			
			if(!empty($term)){
				$term = str_replace('%', '\%', $term);
				$sql .= " where (c.title like ? or c.keywords like ?) ";
				$types[] = 'text';
				$types[] = 'text';
				$params[] = '%' . $term . '%';
				$params[] = '%' . $term . '%';
			}
			
			$sql .= "group by c.id order by c.{$sort_column} {$sort_order} ";
			
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
		 * Count users
		 */
		function countUsers($term = '')
		{
			$types = array();
			$params = array();					
			$sql = 'select count(id) as `count` from user u';			
			
			if(!empty($term)){
				$term = str_replace('%', '\%', $term);
				$sql .= " where (u.username like ? or u.full_name like ?) ";
				$types[] = 'text';
				$types[] = 'text';
				$params[] = '%' . $term . '%';
				$params[] = '%' . $term . '%';
			}
			
			$res = $this->execute_query($sql,$params,$types);
			
			return ($res[0] && $res[0]['count']) ? $res[0]['count'] : 0;
		}
		
		/**
		 * 
		 * Count content
		 */
		function countContents($term = '')
		{
			$types = array();
			$params = array();					
			$sql = 'select count(id) as `count` from content c';			
			
			if(!empty($term)){
				$term = str_replace('%', '\%', $term);
				$sql .= " where (c.title like ? or c.keywords like ?) ";
				$types[] = 'text';
				$types[] = 'text';
				$params[] = '%' . $term . '%';
				$params[] = '%' . $term . '%';
			}
			
			$res = $this->execute_query($sql,$params,$types);
			
			return ($res[0] && $res[0]['count']) ? $res[0]['count'] : 0;
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
		 * check userId exist or not 
		 * @param $params
		 */
		function isExistUserId($params)
		{
			$sql = 'select id from user where id=?';
			$types =  array('integer', 'integer');
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
		
		function getEnabledUserByUsername($params){
			$sql = 'select * from user where username=? and account_enabled=1';
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
		 * get all user
		 */
		function getAllUsers()
		{
			$sql = 'select * from user ';
			$res = $this->execute_query($sql);
			return $res;
		}
		
		/**
		 * get user status by user id
		 */
		function getUserStatusByUserId($params)
		{
			$sql = 'SELECT CAST(account_enabled as unsigned integer) `status` FROM user WHERE id=?';
			$type = array('integer');
			$res = $this->execute_query($sql, $params, $type);
			return $res[0];
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
		 * Update user information for admin in edit user's profile page (fullname, email, status)
		 */
		function updateUserInformationForAdmin($params){
			$sql = 'UPDATE user SET full_name=?, email=?, account_enabled=? WHERE id=?';
			$type = array('text', 'text', 'integer', 'integer');
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
			$types = array('text', 'integer');
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
			$sql = "Select count(ur.user_id) as `count` From user_role ur, role r where ur.role_id = r.id and ur.user_id = ? and r.name = ?";
			$types = array('integer','integer','text');
			$result = $this->execute_query($sql, $params);
			return $result[0]['count'] > 0;
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
		/**
		 * delete user by user
		 * @param $param
		 */
		function dropUserByUserId($params)
		{
			$sql = 'delete from user where id=?';
			$types = array('integer');
			$this->execute_command($sql, $params, $types);
		}
		/**
		 * update admin role
		 * @param $param
		 */
		function updateUserRole($params)
		{
			$sql = 'UPDATE user_role SET role_id =? WHERE user_id=?';
			$types = array('integer','integer');
			return $this->execute_command($sql, $params, $types);
		}
		/**
		 * get role 
		 * @param $param
		 */
		function getRole()
		{
			$sql = "select * from role";
			$res = $this->execute_query($sql);
			return $res;
		}		
		/**
		 * update value configuration login form
		 */
		function updateConfigurationLoginForm($params){
			$sql = "UPDATE configuration SET value=? WHERE name='SHOW_LOGIN_FORM'";
			$types = array('integer');
			return $this->execute_command($sql, $params, $types);
		}
		/**
		 * update value configuration sign up form
		 */
		function updateConfigurationSignUpForm($params){
			$sql = "UPDATE configuration SET value=? WHERE name='SHOW_SIGNUP_FORM'";
			$types = array('integer');
			return $this->execute_command($sql, $params, $types);
		}
		/**
		 * get value configuration login form
		 * @param param
		 */
		function getValueConfigurationLogin()
		{
			$sql = "select * from configuration where name='SHOW_LOGIN_FORM'";
			$res = $this->execute_query($sql);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}
		/**
		 *get value configuration sign up form
		 *@param param
		 */
		function getValueConfigurationSignup()
		{
			$sql = "select * from configuration where name='SHOW_SIGNUP_FORM'";
			$res = $this->execute_query($sql);
			if(sizeof($res) > 0)
			{
				return $res[0];
			}
			return null;
		}
		
		/**
		 * select user role
		 * @param param
		 */
		function getUserRoleByUserId($params)
		{
			$sql = "select * from user_role where user_id=?";
			$types = array('integer');
			$res = $this->execute_query($sql, $params, $types);
			if(sizeof($res) > 0)
			{
				return $res[0] ;
			}
			return null;
		}	
		

		/**
		 * function insert usersetting
		 * @param param
		 */
		function addUserSetting($params){
			$sql = 'INSERT INTO user_setting(user_id, name, value) VALUES (?, ?, ?)';
			$types = array('integer' ,'text','text');
			$this->execute_command($sql, $params, $types);
		}
		
		/**
		 * function update usersetting
		 * @param param
		 */
		function updateUserSetting($params){
			$sql = "UPDATE user_setting SET value=? WHERE user_id=? and name=?";
			$types = array('text','integer','text');
			return $this->execute_command($sql, $params, $types);
		}
		/**
		 * 
		 * check user_setting Exist
		 * @param $params
		 */
		function userSettingExist($params)
		{					
			$sql = 'select 
						count(*) as `count` 
					from 
						user_setting 
					where 
						user_id=? and name=?';
			$types = array('integer','text');
			$res = $this->execute_query($sql,$params,$types);
			return $res[0]['count'];
		}
		
		
		/**
		 * function get usersetting($params)
		 * @param $params
		 */
		function getUserSetting($params)
		{
			$sql = "select value from user_setting where user_id=? and name=?";
			$types = array('integer','text');
			$res = $this->execute_query($sql, $params, $types);
			if(sizeof($res) > 0)
			{
				return $res[0]['value'] ;
			}
			return null;
		}
	}
?>