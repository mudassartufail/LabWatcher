<?php
include('config/config.php');
include('template/html.inc.php');
include('includes/classes/class.User.php');
include('includes/classes/class.errors.php');
include('includes/classes/class.pc.php');

$objUser = new User();
$objUser->isLogin();

startHtml('Dashboard');
topHeader();
leftNavigation();
$objError=new errors();
$objPc=new pc();
?>
<!--<meta http-equiv="refresh" content="10"/>-->
<div class="content">
                
    <div class="row-fluid">
    
        <div class="span12">
            
            <div class="middle">

                <div class="button">
                    <a href="#">
                        <span class="icomg-tender"></span>
                        <span class="text">Errors Manager</span>
                    </a>
                 <ul class="sub">
                  <li>
                  <a href="<?php echo ADMIN_URL;?>errors_manager/view_hardware_errors.php" class="tip" title="Hardware Errors" target="_blank"><span class="icon-th-list"></span>
                  </a>
                  </li>
                   <li><a href="<?php echo ADMIN_URL;?>errors_manager/view_software_errors.php" class="tip" title="Software Errors" target="_blank"><span class="icon-th-list">
                   </span></a>
                   </li>
                 </ul>
                </div>
              
                <div class="button">
                    <a href="#">
                        <span class="icomg-wrench"></span>
                        <span class="text">Settings</span>
                    </a>
                    <ul class="sub">
                     <li><a href="<?php echo ADMIN_URL;?>site_manager/update_profile.php" class="tip" title="Update Profile" target="_blank"><span class="icon-user"></span></a></li>
                     <li>
                     <a href="<?php echo ADMIN_URL;?>site_manager/changepassword.php" class="tip" title="Change Password" target="_blank"><span class="icon-lock"></span></a>
                     </li>
                    </ul>
                </div>                

                <div class="button">
                    <a href="#">
                        <span class="icomg-catalog"></span>
                        <span class="text">Resource Manager</span>
                    </a>
                 <ul class="sub">                        
                  <li><a href="<?php echo ADMIN_URL;?>resource_manager/view_computers.php" class="tip" title="Connected Computers" target="_blank"><span class="icon-th-list"></span></a>
                  </li>
                 </ul>
                </div>                  
             <?php
			 if($objUser->isAdmin())
			 {
			 ?>    
                <div class="button">
                    <a href="#">
                        <span class="icomg-user2"></span>
                        <span class="text">User Manager</span>
                    </a>
                    <ul class="sub">
                        <li><a href="<?php echo ADMIN_URL;?>user_manager/add_user.php" class="tip" title="Add User" target="_blank"><span class="icon-plus"></span></a></li>
                        <li><a href="<?php echo ADMIN_URL;?>user_manager/view_users.php" class="tip" title="All Users" target="_blank"><span class="icon-th-list"></span></a></li>
                    </ul>                        
                </div>
             <?php
	         }
             ?>   
            </div>                                    
        </div>
        
        <div class="row-fluid">
            <div class="span6">                
                <div class="widget">
                    <div class="head">
                        <div class="icon"><i class="icosg-complaint"></i></div>
                        <h2>Latest Errors Reported</h2>
                        <ul class="buttons">
                            <li>
                                <a href="<?php echo ADMIN_URL;?>errors_manager/view_software_errors.php">
                                <span class="icon-th tip" style="height:20px;" data-original-title="View All Software Errors"></span>
                                </a>
                            </li>
                             <li>
                                <a href="<?php echo ADMIN_URL;?>errors_manager/view_hardware_errors.php">
                                <span class="icon-th tip" style="height:20px;" data-original-title="View All Hardware Errors"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="block">
                    <?php
					$latestErrors=$objError->getLatestErrors();
					if($latestErrors)
					{
					?>
                        <table class="fpTable table-hover" id="error_table" cellpadding="0" cellspacing="0" width="100%" style="float:right;">
                            <thead>
                                <tr>
                                    <th width="22%">System Name</th>
                                    <th width="32%">Error Message</th>
                                    <th width="18%">Error Type</th>
                                    <th width="23%">Date and Time</th>
                                    <th width="5%">View</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							foreach($latestErrors as $error)
							{
								$doView=$error->Id;
								$doViewPc=$error->pcName;
							?>
                                <tr>
                                    <td align="center">
                                        <?php echo "<a class=\"iframe\" href=\"resource_manager/computer_detail.php?do={$doViewPc}\">$error->pcName</a>";?>
                                    </td>
                                    <td align="left">
                                    <?php
									$message=( strlen($error->errorMessage) > 30 )? substr($error->errorMessage, 0, 30)."...": $error->errorMessage;
									?>
                                       <?php echo "<a class=\"iframe\" href=\"errors_manager/error_detail.php?do={$doView}\">$message</a>"; ?>
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
                                    <?php
									echo $error->dateTime;
									?>
                                    </td>
                                    <td align="center">
                                        <input type="checkbox" name="errorStatus" id="<?php echo $error->Id;?>" value="<?php echo $error->Status;?>"
                                     <?php echo ($error->Status == 1)?'checked="checked"':'';?> onclick="errorStatus(this.id, this.value)" />
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
                        No Latest Errors Found.
                        <?php
						}
						?>
                    </div>
                </div>
            </div>
            <div class="span6">                
                <div class="widget">
                    <div class="head">
                        <div class="icon"><i class="icosg-complaint"></i></div>
                        <h2>Running Computers</h2>
                        <ul class="buttons">
                            <li>
                                <a href="<?php echo ADMIN_URL;?>resource_manager/view_computers.php">
                                <span class="icon-th tip" style="height:20px;" data-original-title="View All"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="block">
                    <?php
					$connectedPcs=$objPc->getConnectedPC();
					if($connectedPcs)
					{
					?>
                        <table class="fpTable table-hover" cellpadding="0" cellspacing="0" width="100%" style="float:right;">
                            <thead>
                                <tr>
                                   <th width="24%">System Name</th>
                                    <th width="20%">Errors Reported</th>
                                    <th width="20%">Hardware Status</th>
                                    <th width="20%">Date and Time</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							foreach($connectedPcs as $pc)
							{
								$doView=$pc->systemName;
							?>
                               <tr>
                                    <td align="center">
                                        <?php echo "<a class=\"iframe\" href=\"resource_manager/computer_detail.php?do={$doView}\">$pc->systemName</a>";?>
                                    </td>
                                    <td align="center">
                                    <?php
									$objPc->pcName=$pc->systemName;
									$counter=$objPc->countErrors();
									echo "<span style='color:#585858; font-size:14px'><b>$counter</b></span>";
									?>
                                    </td>
                                    <td class="TAC"><a class="iframe" href="resource_manager/hardware_detail.php?do=<?php echo $doView;?>"><span class="icon-view"></span></a></td>
                                    <td align="center">
                                    <?php
									echo $pc->dateTime;
									?>
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
							echo "No Running Computers Found.";
						}
						?>
                    </div>
                </div>
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
function errorStatus(errorId, errorStatus)
{
	 $.ajax({
			  type: 'POST',
			  url: 'includes/ajax/ajax_calls.php',
			  data: {'errorId': errorId, 'errorStatus': errorStatus},
			  success: function(data){
			  $('#'+errorId).val(data);
			  window.location.reload();
			  }
		 })
}
</script>