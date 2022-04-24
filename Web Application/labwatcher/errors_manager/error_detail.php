<?php
include('../config/config.php');
include('../template/html.inc.php');
include('../includes/classes/class.user.php');
include('../includes/classes/class.pc.php');;
include('../includes/classes/class.errors.php');

$objPc=new pc();
$objUser = new user();
$objError=new errors();
$objUser->login();

startHtml('Error Details');

if(isset($_REQUEST['do']))
{
	$errorId = $objUser->cleanString($_REQUEST['do']);
	$objError->id=$errorId;
	$errorDetails=$objError->getErrorInfo();
}
if($errorDetails)
{
	$i = 1;
?>
   
      <div class="widget">
        <div class="head">
            <div class="icon"><i class="icosg-clipboard1"></i></div>
            <h2>Error Details</h2>
        </div>  
	 	<div class="row-form">
		<div class="span3"><b>System Name:</b></div>
		<div class="span9">
			<label><?php echo $errorDetails[0]->pcName;?></label>
		</div>
	</div>
        <div class="row-form">
        <div class="span3"><b>Error Type:</b></div>
        <div class="span9">
          <label>
		   <?php if($errorDetails[0]->Type=='0')
			{
				echo "<span style='color:brown'><b>Hardware</b></span>";
			}
			else if($errorDetails[0]->Type=='1')
			{
				echo "<span style='color:#FF00FF'><b>Software</b></span>";
			}
			?>
          </label>
        </div>
    </div>
    <div class="row-form">
        <div class="span3"><b>Date and Time:</b></div>
        <div class="span9">
           <label><?php echo $errorDetails[0]->dateTime;?></label>
        </div>
    </div>
    <div class="row-form">
        <div class="span3"><b>Error Message:</b></div>
        <div class="span9">
           <label><?php echo $errorDetails[0]->errorMessage;?></label>
        </div>
    </div>
    </div>
  
                  
    <?php
}
?>
<style>
.widget
{
	background: none repeat scroll 0 0 white;
    border: 1px solid #CCCCCC;
    border-radius: 9px 9px 9px 9px;
    margin-bottom: 10px;
    margin-left: 7px;
	overflow:hidden;
    margin-top: 5px;
    position: relative;
    width: 98%;
}
.tabbable:before, .tabbable:after
{
	min-height: 10px;
	
}
</style>