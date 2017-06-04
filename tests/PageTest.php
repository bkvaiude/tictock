<?php
	require_once realpath(dirname(__FILE__))."/../config.php";
	require_once PROJECT_ROOT."services/Base.php";
	require_once PROJECT_ROOT."services/Page.php";
	require_once PROJECT_ROOT."services/Database.php";

Class PageServiceTest extends PHPUnit_Framework_TestCase
{
	public function setUp(){ }
	public function tearDown(){ }

	//validate correct location
	public function testOutsideCheckInIsValid()
	{
	    // test to ensure that the object from an fsockopen is valid
	    $_POST['username'] = 'bruce';
	    $_SERVER['HTTP_X_FORWARDED_FOR'] = "127.0.0.1";
	    $isTesting['type'] = "outside-checkin";
	    $pageObj = new PageService();
	    $this->assertTrue($pageObj->get_attendance_page($isTesting) === "Dear! Please do check-in from the office!");
	}
	
	//validate correct IN Time
	public function testLateCheckInIsValid()
	{
	    $_POST['username'] = 'bruce';
	    $_SERVER['HTTP_X_FORWARDED_FOR'] = "111.119.215.8";
	    $isTesting['type'] = "late-checkin";
	    $pageObj = new PageService();
	    $this->assertTrue($pageObj->get_attendance_page($isTesting) === LATE);
	}
}
?>