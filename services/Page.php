<?php

Class PageService
{
	public $layout;
	public $mysqli;

	function __construct($layout)
	{
		$this->layout = $layout;
		$db = Database::getInstance();
		$this->mysqli = $db->getConnection(); 

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
			//check for the database duplicate entry
		}
		else
		{
			$partialView = $this->requireToVar("services/site/attendance.php");
		}
		
		$this->layout = str_replace("{{content}}", $partialView, $this->layout);
		echo $this->layout;		
	}

	private function requireToVar($file, $viewdata){
	    ob_start();
	    extract($viewdata);
	    require($file);
	    return ob_get_clean();
	}

}

// $ip = $_SERVER['REMOTE_ADDR'];
// $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
// echo $details->city; // -> "Mountain View"




?>