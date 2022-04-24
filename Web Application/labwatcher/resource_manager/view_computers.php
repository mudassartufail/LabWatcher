<?php
include('../config/config.php');
include('../template/html.inc.php');
include('../includes/classes/class.user.php');
include('../includes/classes/class.pc.php');

$objUser = new User();
$objPc=new pc();
$objUser->isLogin();

startHtml('All Computers');
topHeader();
leftNavigation();
?>

<div class="content">
    <div class="row-fluid">
        <div class="span10">
            <div class="widget">
                <div class="head">
                    <div class="icon"><i class="icosg-clipboard1"></i></div>
                    <h2>All Computers</h2>
                </div>
                <div class="block-fluid"> 
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
                            $computers=$objPc->getAllComputers();
						if($computers)
						{	
                            $count=0;
                            foreach($computers as $computer)
                            {
                                $count +=1;
								$doView=$computer->systemName;
                        ?>
                            <tr>
                                <td class="TAR"><?php echo $count;?></td>
                                <td align="center"><?php echo "<a class=\"iframe\" href=\"computer_detail.php?do={$doView}\">$computer->systemName</a>";?></td>
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
                                <td class="TAC"><a class="iframe" href="hardware_detail.php?do=<?php echo $doView;?>"><span class="icon-view"></span></a></td>
                                <td align="center"><?php echo $computer->dateTime;?></td>
                            </tr>
                            <?php
                            }
						}
                            ?>
                        </tbody>
                    </table>
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