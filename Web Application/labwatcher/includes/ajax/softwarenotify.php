<?php 
include('../../config/config.php');
include('../classes/class.errors.php');

$result=array();

if (isset($_POST['softerror']))
{
   $msg = $_POST['softerror'];
   $result=explode("$",$msg);
   $errormsg=$result[1];
   $sysName=$result[0];
   
   $softObj=new errors();
   $softObj->pcname=$sysName;
   $softObj->errormsg=$errormsg;
   
   $softObj->newSoftwareError();
   unset($_POST['softerror']);
}
?>
