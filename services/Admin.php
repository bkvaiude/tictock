<?php
use AshleyDawson\SimplePagination\Paginator;

Class AdminService extends BaseService
{
	public $layout;
	public $mysqli;

	function __construct($layout)
	{
		$this->layout = $this->requireToVar($layout);
		parent::__construct();
	}

	public function get_login_page()
	{
		if(isset($_SESSION['is_login']) && $_SESSION['is_login']==true && $_GET['logout']==true)
		{
			unset($_SESSION['is_login']);
		}
		else if(isset($_SESSION['is_login']) && $_SESSION['is_login']==true)
		{
			header("Location:admin.php?landing_page=list");
			exit;			
		}

		if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password']))
		{
			if($_POST['username']=="admin"  && md5($_POST['password']) == "478bf2de70f915a6320a5451c3d7fdb9")
			{
				$_SESSION['is_login'] = true;
				header("Location:admin.php?landing_page=list");
				exit;
			}
		}
		$partialView = $this->requireToVar("services/admin/login.php");
		$this->layout = str_replace("{{content}}", $partialView, $this->layout);
		echo $this->layout;
	}

	public function get_list_page()
	{

		// Instantiate a new paginator service
		$paginator = new Paginator();

		// Set some parameters (optional)
		$paginator
		    ->setItemsPerPage(10) // Give us a maximum of 10 items per page
		    ->setPagesInRange(5) // How many pages to display in navigation (e.g. if we have a lot of pages to get through)
		;
		
		$extraSqlCondition = "";


		// Pass our item total callback
		$paginator->setItemTotalCallback(function () {
			$fromDate = date('Y-m-d', strtotime('today - '.$_GET['last_x_days'].' days'));
			$toDate = date('Y-m-d');
			if(!empty($_GET['search_key']))
			{
				$search_key = $_GET['search_key'];
				$extraSqlCondition = " AND ( a.username like '%$search_key%' OR u.fullname like '%$search_key%' OR department like '%$search_key%')";
			}
			$sql = "SELECT count(*) as cnt FROM users u, attendances a where status IN ('P','L') and type='IN' and logging_date between '".$fromDate."' and '".$toDate."' $extraSqlCondition and u.username = a.username";
		    // Run count query
		    $result = $this->mysqli->query($sql);
		    $row=mysqli_fetch_assoc($result);
		    // Return the count (the value of the first result column), cast as an integer
		    return (int) $row['cnt'];
		});

		// Pass our slice callback
		$paginator->setSliceCallback(function ($offset, $length) {
			$fromDate = date('Y-m-d', strtotime('today - '.$_GET['last_x_days'].' days'));
			$toDate = date('Y-m-d');
			if(!empty($_GET['search_key']))
			{
				$search_key = $_GET['search_key'];
				$extraSqlCondition = " AND ( a.username like '%$search_key%' OR u.fullname like '%$search_key%' OR department like '%$search_key%')";
			}
		    $sql = "SELECT * FROM users u, attendances a where status IN ('P','L') and type='IN' and logging_date between '".$fromDate."' and '".$toDate."' $extraSqlCondition and u.username = a.username order by u.username, a.logging_date desc LIMIT {$offset}, {$length}";
		    // Run slice query
		    $result = $this->mysqli->query($sql);
		    
		    // Build a collection of items
		    $collection = array();
		    while ($row = mysqli_fetch_assoc($result)) {
		        $collection[] = $row;
		    }
		    
		    // Return the collection
		    return $collection;
		});
		// Paginate the item collection, passing the current page number (e.g. from the current request)
		$pagination = $paginator->paginate((int) $_GET['page']);

		// Ok, from here on is where we'd be inside a template of view (e.g. pass $pagination to your view)
		// Iterate over the items on this page

		$partialView = $this->requireToVar("services/admin/list.php", array("pagination"=>$pagination));
		$this->layout = str_replace("{{content}}", $partialView, $this->layout);
		echo $this->layout;
	}

	public function get_profile_page()
	{
		$fromDate = date('Y-m-d', strtotime('today - '.$_GET['last_x_days'].' days'));
		$toDate = date('Y-m-d');
	    $result = $this->mysqli->query("SELECT `u`.`username`, `u`.`fullname`, department, SEC_TO_TIME(AVG(TIME_TO_SEC(`time_info`))) avg_time FROM users u, attendances a where status IN ('P','L') and type='IN' and logging_date between '".$fromDate."' and '".$toDate."' and u.username = a.username and a.username='".$_GET['username']."' GROUP BY u.username, u.fullname, department LIMIT 1");
	    $row = mysqli_fetch_assoc($result);
		
		$partialView = $this->requireToVar("services/admin/profile.php", array("profileData"=>$row));
		$this->layout = str_replace("{{content}}", $partialView, $this->layout);
		echo $this->layout;
	}

	public function get_config_page()
	{
		if(isset($_POST['config']) && !empty($_POST['config']))
		{
			$config = $_POST['config'];
			$configData = json_decode($config);
			if(json_last_error() == JSON_ERROR_NONE)
			{
				file_put_contents("attendance-config.json", $config);
			}
			else
			{
				$errors = "Error has been occurred during the JSON parsing!";
			}
		}
		$attendanceConfig = file_get_contents("attendance-config.json");
		$partialView = $this->requireToVar("services/admin/config.php", array("config"=>$attendanceConfig, "errors"=>$errors));
		$this->layout = str_replace("{{content}}", $partialView, $this->layout);
		echo $this->layout;
	}


	public function get_department_page()
	{
		$fromDate = date('Y-m-d', strtotime('today - '.$_GET['last_x_days'].' days'));
		$toDate = date('Y-m-d');
	    $result = $this->mysqli->query("SELECT `u`.`username`, `u`.`fullname`, department, SEC_TO_TIME(AVG(TIME_TO_SEC(`time_info`))) avg_time FROM users u, attendances a where status IN ('P','L') and type='IN' and logging_date between '".$fromDate."' and '".$toDate."' and u.username = a.username and u.department='".$_GET['department']."' GROUP BY u.username, u.fullname, department LIMIT 100");

	    $collection = array();
	    while ($row = mysqli_fetch_assoc($result)) {
	        $collection[] = $row;
	    }
		
		$partialView = $this->requireToVar("services/admin/department.php", array("profileData"=>$collection));
		$this->layout = str_replace("{{content}}", $partialView, $this->layout);
		echo $this->layout;
	}


}

?>