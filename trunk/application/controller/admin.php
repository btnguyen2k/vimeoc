<?php 
	define("ADMIN_TEMPLATE_DIR","admin/");
	
	/**
	 * 
	 * Administrator controller
	 * @author Tri
	 *
	 */
	class Admin extends Application {
		/**	
		 * 
		 * Constructor
		 */
		function __construct(&$tmpl)
		{				
			$this->tmpl = &$tmpl;		
		}
		
		function index(){
			$this->redirect($this->ctx().'/admin/userList');
		}
		/**
		 * load message source for user list
		 * 
		 */
		function userListMessagesSource()
		{
			$this->assign("title",$this->loadMessages('admin.userlist.title'));			 
		}
			
		function userList()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/login');
				return;
			}
			if($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$userId = $_GET['userId'];
			}
			
			$_search_obj = unserialize($_SESSION['USER_SEARCH']);
			
			$_sort_modes = array(
				1 => 'Newest',
				2 => 'Oldest',
				3 => 'Alphabetical'
			);
			$_sort_columns = array(
				1 => 'creation_date',
				2 => 'creation_date',
				3 => 'username'
			);
			$_sort_orders = array(
				1 => 'DESC',
				2 => 'ASC',
				3 => 'ASC'
			);
			$_page_sizes = array(
				1 => 'All',//all users
				2 => 5,
				3 => 20,
				4 => 50
			);
			$_default_sort_mode = 1;
			$_default_page_size = 2;
			$_default_search_term = '';
			
			$users = array();
			$pagination = '';
			$_reset = $_GET['reset'];// reset all value for display
			if($_reset){
				
			}else{
				if($_GET['sort']){
					$_sort_mode = $_GET['sort'];
					if(!in_array($_sort_mode, array_keys($_sort_modes), false)){
						$_sort_mode = $_default_sort_mode;
					}
				}else{
					$_sort_mode = $_search_obj->sort ? $_search_obj->sort : $_default_sort_mode;
				}
				if($_GET['psize']){
					$_page_size = $_GET['psize'];
					if(!in_array($_page_size, array_keys($_page_sizes), false)){
						$_page_size = $_default_page_size;
					}
				}else{
					$_page_size = $_search_obj->psize ? $_search_obj->psize : $_default_page_size;
				}
				if(in_array('term', array_keys($_GET))){
					$_search_term = trim($_GET['term']);
				}else{
					$_search_term = $_search_obj->term ? $_search_obj->term : $_default_search_term;
				}
			}
			$page = $_GET['page'] ? $_GET['page'] : '1';			
			if(!ctype_digit($page)){
				$this->redirect($this->ctx().'/admin/userlist/');
			}else{
				$page = intval($page);
			}
			
			$limit = is_int($_page_sizes[$_page_size]) ? $_page_sizes[$_page_size] : 0;
			$offset = ($page - 1) * $limit;
			$sort_column = $_sort_columns[$_sort_mode];
			$sort_order = $_sort_orders[$_sort_mode];
						
			$this->loadModel('model_user');
			
			$model_user=$this->model_user;
			$user_count=$model_user->countUsers();
			if($user_count > 0)
			{
				if($limit > 0)
				{
					if($limit && ($page > ceil($user_count / $limit)))
					{
						$this->redirect($this->ctx().'/admin/userlist/');
					}
					$users = $model_user->selectUser($limit, $offset, $_search_term, $sort_column, $sort_order);
			
					$adjacents = 2;
					$targetpage = $_SERVER['REDIRECT_URL'];
					if(!($targetpage[strlen($targetpage) - 1] == '/')){
						$targetpage .= '/';
					}
					if ($page == 0){
						$page = 1;								//if no page var is given, default to 1.
					}
					$prev = $page - 1;							//previous page is page - 1
					$next = $page + 1;							//next page is page + 1
					$lastpage = ceil($user_count / $limit);		//lastpage is = total pages / items per page, rounded up.
					$lpm1 = $lastpage - 1;						//last page minus 1
					
					/* 
						Now we apply our rules and draw the pagination object. 
					*/
					$pagination = "";
					if($lastpage > 1)
					{
						$pagination .= "<div class=\"pagination\">";
						//previous button
						if ($page > 1) 
							$pagination.= "<a href=\"$targetpage?page=$prev\">« Previous</a>";
						else
							$pagination.= "<span class=\"disabled\">« Previous</span>";	
						
						//pages	
						if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
						{	
							for ($counter = 1; $counter <= $lastpage; $counter++)
							{
								if ($counter == $page)
									$pagination.= "<span class=\"current\">$counter</span>";
								else
									$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
							}
						}
						elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
						{
							//close to beginning; only hide later pages
							if($page < 1 + ($adjacents * 2))		
							{
								for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
								{
									if ($counter == $page)
										$pagination.= "<span class=\"current\">$counter</span>";
									else
										$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
								}
								$pagination.= "...";
								$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
								$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
							}
							//in middle; hide some front and some back
							elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
							{
								$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
								$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
								$pagination.= "...";
								for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
								{
									if ($counter == $page)
										$pagination.= "<span class=\"current\">$counter</span>";
									else
										$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
								}
								$pagination.= "...";
								$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
								$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
							}
							//close to end; only hide early pages
							else
							{
								$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
								$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
								$pagination.= "...";
								for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
								{
									if ($counter == $page)
										$pagination.= "<span class=\"current\">$counter</span>";
									else
										$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
								}
							}
						}
						
						//next button
						if ($page < $counter - 1){
							$pagination.= "<a href=\"$targetpage?page=$next\">Next »</a>";
						}else{
							$pagination.= "<span class=\"disabled\">Next »</span>";
						}
						$pagination.= "</div>\n";		
					}
				}else{
					$users = $model_user->selectUser($limit, $offset, $_search_term, $sort_column, $sort_order);
				}
			}
			
			if(is_array($users) && (count($users) > 0)){
				foreach($users as &$user){
					$user['avatar'] = empty($user['avatar']) ? $this->ctx() . '/images/icon-album.gif' : ($this->ctx() . $this->loadResources('image.upload.path') . $user['avatar']);
				}
			}
			
			$this->assign('users', $users);
			$this->assign('pagination', $pagination);
			$this->assign('sort_modes', $_sort_modes);
			$this->assign('page_sizes', $_page_sizes);
			
			$this->assign('sort_mode', $_sort_mode);
			$this->assign('page_size', $_page_size);
			$this->assign('search_term', $_search_term);
			$this->assign('page', $page);
			
			$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_user_list');
		}
		
		function disableAccount()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/login');
				return;
			}	
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$userId=$_GET['userId'];
				$this->model_user->updateDisableAccount(array($userId));
				$this->redirect($this->ctx().'/admin/userlist');
				
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_disableaccount');
			}
		}
		
		function enableAccount()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/login');
				return;
			}
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$userId=$_GET['userId'];
				$this->model_user->updateEnableAccount(array($userId));
				$this->redirect($this->ctx().'/admin/userlist');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_enableaccount');
			}		
		}
		
		function deleteAccount()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/login');
				return;
			}
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$userId=$_GET['userId'];
				$this->model_user->dropVideoByUserId(array($userId));
				$this->model_user->dropAlbumByUserId(array($userId));
				$this->model_user->dropChannelByUserId(array($userId));
				$this->model_user->dropRoleByUserId(array($userId));
				$this->model_user->dropUserByUserId(array($userId));
				$this->redirect($this->ctx().'/admin/userlist');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_deleteaccount');
			}
		}
		/**
		 * 
		 *function create new account
		 */
		function createNewAccountMessagesSource()
		{
			$this->assign("fullname",$this->loadMessages('admin.createnewaccount.fullname'));
			$this->assign("title", $this->loadMessages('admin.createnewaccount.title'));
			$this->assign("password", $this->loadMessages('admin.createnewaccount.password'));
			$this->assign("rpassword", $this->loadMessages('admin.createnewaccount.rpassword'));
			$this->assign("email", $this->loadMessages('admin.createnewaccount.email'));
			$this->assign("understand", $this->loadMessages('auth.signup.understand'));
			$this->assign("term", $this->loadMessages('auth.signup.term'));
			$this->assign("role", $this->loadMessages('admin.createnewaccount.role'));
			
			$this->assign('passwordInvalid', $this->loadErrorMessage('error.password.invalid'));
			$this->assign('mathpasswordInvalid', $this->loadErrorMessage('error.mathpassword.invalid'));
			$this->assign('termInvalid', $this->loadErrorMessage('error.term.invalid'));
			$this->assign('retypepasswordInvalid', $this->loadErrorMessage('error.retypepassword.invalid'));
			$this->assign('fullnameInvalid', $this->loadErrorMessage('error.fullname.invalid'));
			$this->assign('emailInvalid', $this->loadErrorMessage('error.email.invalid'));
			$this->assign('passwordlength', $this->loadErrorMessage('error.password.length'));
			$this->assign('repasswordlength', $this->loadErrorMessage('error.retypepassword.length'));
			$this->assign('fullnamelength', $this->loadErrorMessage('error.fullname.length'));
			$this->assign('emaillength', $this->loadErrorMessage('error.email.length'));
			$this->assign('passwordless', $this->loadErrorMessage('error.password.lesslength'));
			$this->assign('repasswordless', $this->loadErrorMessage('error.rpassword.lesslength'));
		}
		
		function createNewAccount()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/login');
				return;
			}
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$getrole=$this->model_user->getRole(array());
				$this->assign("getrole",$getrole);
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_signup');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$fullName = $_POST['fullname'];
				$username = $_POST['email'];
				$password = $_POST['password'];
				$role = $_POST['role'];
				if ($this->model_user->isExists(array($username)) == true)
				{
					$this->assign("username",$username);
					$this->assign("errorMessage", $this->loadMessages('auth.signup.errors'));
					$this->assign('fullname_',$fullName);
					$this->assign('username_',$username);
					$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_signup');
				}
				else 
				{
					$params = array($fullName, $username, $this->encodePassword($password), $username);
					$userId = $this->model_user->addNewUser($params);
					$userAlias = 'user'.$userId;
					$roles=$this->model_user->getRole(array());
					$this->model_user->updateUserAlias(array($userAlias, $userId));					
					$params = array($userId);
					$user = $this->model_user->getUserByUserId($params);
					$user['password']=$password;
					$this->model_user->updateUserRole(array($role,$userId));
					$this->assign("getrole",$roles);
					$this->sendingEmailWithSmarty('mail_welcome', 'user', $user, null, $user['email']);
					$this->assign("success",$this->loadMessages('auth.thankyou.success'));
					$this->assign("login",$this->loadMessages('auth.thankyou.login'));
					$this->loadTemplate('view_thankyou');
				}
			}
		}
		
		function editAccount()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/login');
			}
		}
		/**
		 * function update value message source
		 * 
		 */
		function configurationMessagesSource()
		{
			$this->assign("title",$this->loadMessages('admin.setting.Title'));
			$this->assign("signupTitle",$this->loadMessages('admin.setting.signupform'));
			$this->assign("loginTitle",$this->loadMessages('admin.setting.loginform'));
		}
		/**
		 * function update value
		 * 
		 */
		function configuration()
		{
			{
				if(!$this->isAdminLogged()){
					$this->redirect($this->ctx().'/admin/login');
				}
			}
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$login=$this->model_user->getValueConfigurationLogin();
				$signup=$this->model_user->getValueConfigurationSignup();
				$this->assign("login",$login['value']);
				$this->assign("signup",$signup['value']);
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_setting');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$login=$_POST['login'];
				$signup=$_POST['signup'];
				$this->model_user->updateConfigurationLoginForm(array($login));	
				$this->model_user->updateConfigurationSignUpForm(array($signup));		
				$login=$this->model_user->getValueConfigurationLogin();
				$signup=$this->model_user->getValueConfigurationSignup();
				$this->assign("login",$login['value']);
				$this->assign("signup",$signup['value']);
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_setting');
			}
		}
		/**
		 * Admin Login form messagessourse
		 * 
		 */
		function loginMessagesSource()
		{
			$this->assign("title",$this->loadMessages('admin.login.Title'));
			$this->assign("Id",$this->loadMessages('admin.login.Id'));
			$this->assign("Password",$this->loadMessages('admin.login.Password'));
			
			$this->assign('passwordInvalid', $this->loadErrorMessage('error.password.invalid'));
			$this->assign('emailInvalid', $this->loadErrorMessage('error.email.invalid'));
		}
		/**
		 * action Admin Login form
		 * 
		 */
		function login()
		{	
			if($this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/userList');
			}
			
			$this->loadModel('model_user');
			if ($_SERVER['REQUEST_METHOD'] == 'GET') 
			{
				$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_login');
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->loadModel('model_user');				
				$username = $_POST['email'];
				$password = $_POST['password'];
				$params = array($username, $this->encodePassword($password));
				$user=$this->model_user->getUserByUsername(array($username));
				$valid = $this->model_user->checkUsernameAndPassword($params);
				$isAdmin= $this->model_user->isAdmin(array($user['id'],"ROLE_ADMIN"));
				if($isAdmin==1)
				{
					if($valid)
					{
						$user = $this->model_user->getUserByUsername(array($username));
						if($user != null)
						{
							$this->setSessionValue("uid", $user['id']);
							$this->setSessionValue("username", $user['username']);
							$this->setSessionValue("logged", true);
							$this->setSessionValue("cookie", 0);
							$this->setSessionValue("remember", false);
							$this->redirect($this->ctx().'/user');
						}
						else 
						{
							die ('Fail to login');
						}
					}				
					else 
					{	
						$this->assign("errorMessage", $this->loadMessages('auth.login.error'));
						$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_login');
					}
				}
				else 
				{
					$this->assign("errorMessageGranted", $this->loadMessages('admin.login.error'));
					$this->loadTemplate(ADMIN_TEMPLATE_DIR.'view_admin_login');
				}	
			}
		}
		
		function disableLoginForm()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/login');
			}
		}
		
		function enableLoginForm()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/login');
			}
		}
		
		function disableRegistrationForm()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/login');
			}
		}
		
		function enableRegistrationForm()
		{
			if(!$this->isAdminLogged()){
				$this->redirect($this->ctx().'/admin/login');
			}
		}
	}
?>