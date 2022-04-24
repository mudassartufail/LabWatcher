<?php
include('../config/config.php');
include('../template/html.inc.php');
include('../includes/classes/class.user.php');
include('../includes/classes/class.pc.php');;

$objPc=new pc();
$objUser = new user();
$objUser->login();

startHtml('Computer Details');

if(isset($_REQUEST['do']))
{
	$pcName = $objUser->cleanString($_REQUEST['do']);
	$objPc->pcName=$pcName;
	$pcDetails=$objPc->getPcInfo();
	
}
if($pcDetails)
{
	$i = 1;
?>
   
      <div class="widget">
        <div class="head">
            <div class="icon"><i class="icosg-clipboard1"></i></div>
            <h2>Computer Details</h2>
        </div>  
	 	<div class="row-form">
		<div class="span3"><b>System Name:</b></div>
		<div class="span9">
			<label><?php echo $pcDetails[0]->systemName;?></label>
		</div>
	</div>
        <div class="row-form">
        <div class="span3"><b>Operating System:</b></div>
        <div class="span9">
           <label><?php echo $pcDetails[0]->osInfo;?></label>
        </div>
    </div>
        <div class="row-form">
        <div class="span3"><b>Processor:</b></div>
        <div class="span9">
           <label><?php echo $pcDetails[0]->processorInfo;?></label>
        </div>
    </div>
     <div class="row-form">
        <div class="span3"><b>Hard Disk:</b></div>
        <div class="span9">
           <label><?php echo $pcDetails[0]->hardDiskInfo." GB";?></label>
        </div>
    </div>
    <div class="row-form">
        <div class="span3"><b>RAM:</b></div>
        <div class="span9">
           <label><?php echo $pcDetails[0]->ramInfo." GB";?></label>
        </div>
    </div>
    <div class="row-form">
        <div class="span3"><b>Status:</b></div>
        <div class="span9">
           <label>
		   <?php
				if($pcDetails[0]->Status=='1')
				{
					echo "<span style='color:green'><b>Service is Started</b></span>";
				}
				else if($pcDetails[0]->Status=='0')
				{
					echo "<span style='color:red'><b>Service is Stopped</b></span>";
				}
			?>
           </label>
        </div>
    </div>
    <div class="row-form">
        <div class="span3"><b>Date and Time:</b></div>
        <div class="span9">
           <label><?php echo $pcDetails[0]->dateTime;?></label>
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