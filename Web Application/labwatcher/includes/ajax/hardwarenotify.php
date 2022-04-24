<?php 
include('../../config/config.php');
include('../classes/class.errors.php');

$result=array();
if (isset($_POST['harderror']))
{
   $msg = $_POST['harderror'];
   $result=explode("$",$msg);
   $errormsg=$result[0];
   $sysName=$result[1];
   
   $hardObj=new errors();
   $hardObj->pcname=$sysName;
   $hardObj->errormsg=$errormsg;
   
   $hardObj->newHardwareError();
   unset($_POST['harderror']); 
}

?>
