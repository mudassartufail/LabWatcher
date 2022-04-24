<?php
include('../../config/config.php');
include('../classes/class.pc.php');

$objPc = new pc();
$msgs = array();
$inserted = '';

if (isset($_POST['message']))
{
	$result=$_POST['message'];
	
	$msgs=explode("$",$result);
	
	$sysname=$msgs[0];
	$syspro=$msgs[1];
	$sysram=$msgs[2];
	$syshard=$msgs[3];
	$sysos=$msgs[4];
	
	$objPc->pcName=$sysname;
	$objPc->pcProcessor=$syspro;
	$objPc->pcRam=$sysram;
	$objPc->pcHarddisk=$syshard;
	$objPc->pcOs=$sysos;
	
	// Insert into DB
	$objPc->newPcConnection();
}

if (isset($_POST['uninstall']))
{
	$pcname=$_POST['uninstall'];
	
	$objPc->pcName=$pcname;
	
	// Delete from DB
	$objPc->deleteConnection();
}

?>