<?php
include('../../config/config.php');
include('../classes/class.user.php');
include('../classes/class.errors.php');
include('../classes/class.pc.php');

$objUser = new user();
$objError=new errors();
$objPc=new pc();
$msgArray=array();

// Change error Status to active/inactive
if(isset( $_REQUEST['errorStatus']))
{
	$currentStatus = $_REQUEST['errorStatus'];
	$newStatus = 1 - $currentStatus;	
	$objError->id = $_REQUEST['errorId'];
	$objError->status= $newStatus;
	$objError->updateErrorStatus();
	echo $newStatus;
}

if(isset($_REQUEST['label']))
{
	$label=$_REQUEST['label'];
	
   if($label!='all')
   {	
	$pcName=$_REQUEST['systemName'];
	$objPc->pcName=$pcName;
	$hardDiskStatus=$objPc->getHardDiskUsage();
	
	$hardUsage=$hardDiskStatus[0]->hardDiskUsage;
	
	$diskArray=array();
	$totalSpace=array();
	$freeSpace=array();
	$driveLable=array();
	$tempArr=array();
	$diskArray=explode("|",$hardUsage);
	$count=sizeof($diskArray);
	$temp=0;
	
	for($a=0;$a<$count-1;$a++)
	{
		$tempArr=explode(' ',$diskArray[$a]);
		$totalSpace[$tempArr[0]]=$tempArr[1];
		$freeSpace[$tempArr[0]]=$tempArr[2];
	}

    foreach($totalSpace as $space=>$key)
	{
		if($space==$label)
		{
			$totalDriveSpace=$key;
		}
	}
	
	foreach($freeSpace as $space=>$key)
	{
		if($space==$label)
		{
			$freeDriveSpace=$key;
		}
	}
	
	$msgArray['freeSpace']=$freeDriveSpace;
	$msgArray['totalSpace']=$totalDriveSpace;
	
	if($msgArray)
	{
		$arr=json_encode($msgArray);
		print_r($arr);
	}
   }

}

?>