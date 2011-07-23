<?php 
	require_once 'MDB2.php';
	
	/**
	 * 
	 * Model category
	 * @author Tri
	 *
	 */
	class model_category extends Model {
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
		 * Load category by name
		 * @param $params
		 */
		function loadCategoryByName($params){
			$sql = "select * from category where name = ?";
			$types = array('text');
			$res = $this->execute_query($sql, $params, $types);
			if(sizeof($res) > 0){
				return $res[0];
			}
			
			return null;
		}
	}
?>