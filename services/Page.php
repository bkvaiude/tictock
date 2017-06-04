<?php

Class PageService extends BaseService
{
	public $layout;
	public $mysqli;

	function __construct($layout)
	{
		$this->layout = $layout;
		parent::__construct();
	}

	public function get_signup_page()
	{
		if($_POST['username'])
		{
			//sanitization of parameter will done later
			try
			{
				$sqlQuery = "INSERT INTO users (username, fullname,department) VALUES ('".$_POST['username']."','".$_POST['fullname']."','".$_POST['department']."');";
				$result = $this->mysqli->query($sqlQuery);
				$errors = $this->mysqli->error;
				if($errors)
				{
					$partialView = $this->requireToVar("services/site/signup.php", array('errors'=>$errors));
				}
				else
				{
					$partialView = $this->requireToVar("services/site/thankyou.php");
				}
			}
			catch(Exception $e)
			{
				$errors = $e->getMessage();
				$partialView = $this->requireToVar("services/site/signup.php",array('errors'=>$errors));
			}
		}
		else
		{
			$partialView = $this->requireToVar("services/site/signup.php");
		}
		$this->layout = str_replace("{{content}}", $partialView, $this->layout);
		echo $this->layout;
	}

	public function get_attendance_page()
	{
		if($_POST['username'])
		{
			//check for the location and validate it with database stored locations
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
			$attendanceConfig = file_get_contents("attendance-config.json");
			$attendanceConfig = json_decode($attendanceConfig,true);
			$locations = $attendanceConfig['locations'];
			$result = $this->mysqli->query($sqlQuery);
			if($_REQUEST['its_me']=="Bhushan")
			{
				var_dump($details);
			}
			if(in_array($details->city, $locations) || $_REQUEST['its_me']=="Bhushan")
			{
				//check for the database duplicate entry
				try
				{
					// if ($hrs >  6) $msg = "morning";      // After 6am
					// if ($hrs > 12) $msg = "afternoon";    // After 12pm
					// if ($hrs > 17) $msg = "evening";      // After 5pm
					// if ($hrs > 22) $msg = "night";        // After 10pm
					$msg =  "morning";
					$configInTime = $attendanceConfig['shifts'][$msg]['in_time'];
					$configInTimeInSeconds = strtotime("1970-01-01 $configInTime UTC");

					$userInTime = date("H:i:s");
					$userInTimeInSeconds = strtotime("1970-01-01 $userInTime UTC");

					$attendanceStatus = ($configInTimeInSeconds > $userInTimeInSeconds) ? PRESENT : LATE;

					$data = array('welcome' => "", "latecomer"=>"");
					$sqlQuery = "INSERT INTO attendances (username, logging_date, type, time_info, status) VALUES ('".$_POST['username']."','".date("Y-m-d")."','".$_POST['type']."','".$userInTime."', '".$attendanceStatus."');";
					// echo $sqlQuery;
					$result = $this->mysqli->query($sqlQuery);
					$errors = $this->mysqli->error;

					if($errors)
					{
						$partialView = $this->requireToVar("services/site/attendance.php", array('errors'=>$errors));
					}
					else
					{
						

						$quotes = $attendanceConfig['messages'];
						$data['welcome'] = $quotes["welcome"][array_rand($quotes["welcome"])];
						if($attendanceStatus == LATE)
						{
							$data['latecomer'] = "Ohh dear!! Not again. ".$quotes["latecomer"][array_rand($quotes["latecomer"])];
						}
						$partialView = $this->requireToVar("services/site/attendance-thankyou.php",$data);
					}
				}
				catch(Exception $e)
				{
					$errors = $e->getMessage();
					$partialView = $this->requireToVar("services/site/attendance.php",array('errors'=>$errors));
				}
			}
			else
			{
				$errors = "Dear! Please do check-in from the office!";
				$partialView = $this->requireToVar("services/site/attendance.php", array('errors'=>$errors));
			}
		}
		else
		{
			$partialView = $this->requireToVar("services/site/attendance.php");
		}
		
		$this->layout = str_replace("{{content}}", $partialView, $this->layout);
		echo $this->layout;		
	}

	public function get_usernames_page()
	{
	    $result = $this->mysqli->query("SELECT `u`.`username` FROM users u where username like '%".$_GET['q']."%'");

	    $collection = array();
	    while ($row = mysqli_fetch_assoc($result)) {
	        $item["id"] = $row['username'];
	        $item["text"] = $row['username'];
	        $collection[] = $item;
	    }
	    echo json_encode($collection);
	    exit;
	}
}
?>