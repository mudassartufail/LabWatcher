<?php
include('../../config/config.php');
include('../classes/class.pc.php');

$objPc = new pc();
$msgs = array();
$inserted = '';

if (isset($_POST['status']))
{
	$result=$_POST['status'];
	$msgs=explode("$",$result);
	
	$sysName=$msgs[0];
	$keyboard=$msgs[1];
	$mouse=$msgs[2];
	$monitor=$msgs[3];
	$processor=$msgs[4];
	$harddisk=$msgs[5];
	$ram=$msgs[6];
	$diskUsage=$msgs[7];
	$status=$msgs[8];
	
	$objPc->pcName=$sysName;
	$objPc->keyboardStatus=$keyboard;
	$objPc->mouseStatus=$mouse;
	$objPc->monitorStatus=$monitor;
	$objPc->processorStatus=$processor;
	$objPc->harddiskStatus=$harddisk;
	$objPc->ramStatus=$ram;
	$objPc->harddiskUsage=$diskUsage;
	$objPc->pcStatus=$status;
	$objPc->updateConnection();
	$objPc->updateDeviceStatus();
	
}

?>