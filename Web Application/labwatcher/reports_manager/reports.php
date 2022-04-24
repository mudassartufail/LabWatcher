<?php
include('../config/config.php');
include('../template/html.inc.php');
include('../includes/classes/class.user.php');
include('../includes/classes/class.pc.php');
include('../includes/classes/class.errors.php');

$objUser = new User();
$objPc=new pc();
$objError=new errors();
$objUser->isLogin();

startHtml('Generate Reports');
topHeader();
leftNavigation();

$allErrors='';
$computerData='';
$pcerrors='';

$softSelection='';
$hardSelection='';
$allSelection='';
$computerSelection='';
$defaultSelection='selected="selected"';

if(isset($_REQUEST['search']))
{
	if(isset($_REQUEST['error']) && !empty($_REQUEST['error']) && empty($_REQUEST['computer']))
	{
		$error=$objUser->cleanString($_REQUEST['error']);
		
		if($error=="software")
		{
			$allErrors=$objError->getSoftwareErrors();
			$softSelection='selected="selected"';
			$hardSelection='';
			$allSelection='';
			$defaultSelection='';
			
		}
		else if($error=="hardware")
		{
			$allErrors=$objError->getHardwareErrors();
			$softSelection='';
			$hardSelection='selected="selected"';
			$allSelection='';
			$defaultSelection='';
		}
		else if($error=="all")
		{
			$allErrors=$objError->getAllErrors();
			$softSelection='';
			$hardSelection='';
			$allSelection='selected="selected"';
			$defaultSelection='';
		}
	
	}
	
	if(isset($_REQUEST['computer']) && !empty($_REQUEST['computer']) && empty($_REQUEST['error']))
	{
		$computer=$objUser->cleanString($_REQUEST['computer']);
		$objPc->pcName=$computer;
		$computerSelection=$computer;
		$computerData=$objPc->getPcInfo();	
	}
	
	if(isset($_REQUEST['computer']) && !empty($_REQUEST['computer']) && isset($_REQUEST['error']) && !empty($_REQUEST['error']))
	{
		$computer=$objUser->cleanString($_REQUEST['computer']);
		$error=$objUser->cleanString($_REQUEST['error']);
		if($error=="software")
		{
			$softSelection='selected="selected"';
			$hardSelection='';
			$allSelection='';
			$defaultSelection='';
			
		}
		else if($error=="hardware")
		{
			$softSelection='';
			$hardSelection='selected="selected"';
			$allSelection='';
			$defaultSelection='';
		}
		else if($error=="all")
		{
			$softSelection='';
			$hardSelection='';
			$allSelection='selected="selected"';
			$defaultSelection='';
		}
		$computerSelection=$computer;
		$objPc->pcName=$computer;
		$pcerrors=$objPc->getPcErrors($error);
	}
	
}


?>

<div class="content">
    <div class="row-fluid">
        <div class="span10">
            <div class="widget">
                <div class="head">
                    <div class="icon"><i class="icosg-clipboard1"></i></div>
                    <h2>Generate Reports</h2>
                </div>
                <div class="block-fluid"> 
                    <form id="validate" name="reportSearch" method="get" action="" class="searchForm">
                        <table id="myTable" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                            	<td width="5%">
                                    <select name="error" id="error" style="width:100%;" class="select"> 
                                    	<option value="" <?php echo $defaultSelection;?>>-Select Error Type-</option>                       
                                        <option value="software" <?php echo $softSelection;?>>Software Errors</option>
                                        <option value="hardware" <?php echo $hardSelection;?>>Hardware Errors</option>
                                        <option value="all" <?php echo $allSelection;?>>All Errors</option>
                                    </select>
                                </td>
                                <td width="20%">
                                    <select name="computer" id="computer" style="width:31%;" class="select"> 
                                    	<option value="">-Select Computer-</option>
                                        <?php
										$allComputers=$objPc->getAllPc();
										foreach($allComputers as $computer)
										{
										?>
                                     <option value="<?php echo $computer->systemName;?>" <?php echo ($computer->systemName == $computerSelection) ? 'selected="selected"' : "";?>>
										<?php echo $computer->systemName;?>
                                        </option>
                                        <?php
										}
										?>                       
                                    </select>
                                </td>
                                
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <button class="btn btn-success" type="submit" name="search">Search</button>
                                    <button class="btn" type="reset" onclick="javascript:window.location='<?php echo $_SERVER['PHP_SELF'];?>'">Reset Search</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <?php
                    if($allErrors)
					{
					?>
                    <table class="fpTable table-hover" cellpadding="0" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                             <th width="7%">Sr. No.</th>
                             <th width="20%">System Name</th>
                             <th width="35%">Error Message</th>
                             <th width="15%">Error Type</th>
                             <th width="15%">Date and Time</th>
                           </tr>
                        </thead>
                        <tbody>
                        <?php	
                            $count=0;
                            foreach($allErrors as $error)
                            {
                                $count +=1;
								$doView=$error->pcName;
								$doViewError=$error->Id;
                        ?>
                            <tr>
                                <td class="TAR"><?php echo $count;?></td>
                                <td align="center"><?php echo "<a class=\"iframe\" href=\"../resource_manager/computer_detail.php?do={$doView}\">$error->pcName</a>";?></td>
                                <td align="left">
								<?php
								 $message=( strlen($error->errorMessage) > 60 )? substr($error->errorMessage, 0, 60)."...": $error->errorMessage;
								 echo "<a class=\"iframe\" href=\"../errors_manager/error_detail.php?do={$doViewError}\">$message</a>"; 
								?>
                                </td>
                                <td align="center">
                                <?php
									if($error->Type=='0')
									{
										echo "<span style='color:brown'><b>Hardware</b></span>";
									}
									else if($error->Type=='1')
									{
										echo "<span style='color:#FF00FF'><b>Software</b></span>";
									}
								?>
                                </td>
                                <td align="center">
								<?php echo $error->dateTime;?>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
					}
					else if($computerData)
					{
					?>
                    <table class="fpTable table-hover" cellpadding="0" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                             <th width="4%">Sr.#</th>
                             <th width="18%">System Name</th>
                             <th width="15%">Service Status</th>
                             <th width="18%">Reported Software Errors</th>
                             <th width="18%">Reported Hardware Errors</th>
                             <th width="13%">Hardware Status</th>
                             <th width="20%">Date and Time</th>
                           </tr>
                        </thead>
                        <tbody>
                        <?php
                            $count=0;
                            foreach($computerData as $computer)
                            {
                                $count +=1;
								$doView=$computer->systemName;
                        ?>
                            <tr>
                                <td class="TAR"><?php echo $count;?></td>
                                <td align="center"><?php echo "<a class=\"iframe\" href=\"../resource_manager/computer_detail.php?do={$doView}\">$computer->systemName</a>";?></td>
                                <td align="center">
								<?php
									if($computer->Status=='1')
									{
										echo "<span style='color:green'><b>Service is Started</b></span>";
									}
									else if($computer->Status=='0')
									{
										echo "<span style='color:red'><b>Service is Stopped</b></span>";
									}
							    ?>
                                </td>
                                <td align="center">
								<?php
								$objPc->pcName=$computer->systemName;
								$softwareCount=$objPc->countSoftwareErrors(); 
								echo "<span style='color:#585858; font-size:14px'><b>$softwareCount</b></span>";
								?>
                                </td>
                                <td align="center">
								<?php 
								$objPc->pcName=$computer->systemName;
								$hardwareCount=$objPc->countHardwareErrors(); 
								echo "<span style='color:#585858; font-size:14px'><b>$hardwareCount</b></span>";
								?>
                                </td>
                                <td class="TAC"><a class="iframe" href="../resource_manager/hardware_detail.php?do=<?php echo $doView;?>"><span class="icon-view"></span></a></td>
                                <td align="center"><?php echo $computer->dateTime;?></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
					}
					else if($pcerrors)
					{
					?>
                    <table class="fpTable table-hover" cellpadding="0" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                             <th width="7%">Sr. No.</th>
                             <th width="20%">System Name</th>
                             <th width="35%">Error Message</th>
                             <th width="15%">Error Type</th>
                             <th width="15%">Date and Time</th>
                           </tr>
                        </thead>
                        <tbody>
                        <?php	
                            $count=0;
                            foreach($pcerrors as $error)
                            {
                                $count +=1;
								$doView=$error->pcName;
								$doViewError=$error->Id;
                        ?>
                            <tr>
                                <td class="TAR"><?php echo $count;?></td>
                                <td align="center"><?php echo "<a class=\"iframe\" href=\"../resource_manager/computer_detail.php?do={$doView}\">$error->pcName</a>";?></td>
                                <td align="left">
								<?php
								 $message=( strlen($error->errorMessage) > 60 )? substr($error->errorMessage, 0, 60)."...": $error->errorMessage;
								 echo "<a class=\"iframe\" href=\"../errors_manager/error_detail.php?do={$doViewError}\">$message</a>"; 
								?>
                                </td>
                                <td align="center">
                                <?php
									if($error->Type=='0')
									{
										echo "<span style='color:brown'><b>Hardware</b></span>";
									}
									else if($error->Type=='1')
									{
										echo "<span style='color:#FF00FF'><b>Software</b></span>";
									}
								?>
                                </td>
                                <td align="center">
								<?php echo $error->dateTime;?>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
					}
					else
					{
					?>
                    <p>No Record Found!</p>
                    <?php
					}
					?>
                </div>              
            </div>
        </div>
    </div>
</div>
<?php
footer();
endHtml();
?>
<script>
function hardErrorStatus(hardId, hardStatus)
{
	 $.ajax({
			  type: 'POST',
			  url: '../includes/ajax/ajax_calls.php',
			  data: {'hardId': hardId, 'hardStatus': hardStatus},
			  success: function(data){
			  $('#'+hardId).val(data);
			  }
		 })
}
</script>