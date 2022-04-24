<?php
include('../config/config.php');
include('../template/html.inc.php');
include('../includes/classes/class.user.php');
include('../includes/classes/class.errors.php');

$objUser = new User();
$objSoftware=new errors();
$objUser->isLogin();

startHtml('Software Errors');
topHeader();
leftNavigation();
?>

<?php
// Get error Id and DELETE the record
if ( isset($_REQUEST['do']))
{
	list($do, $softId) = explode('|', $objUser->cleanString($objUser->decrypt($_REQUEST['do'])));
	$objSoftware->id = $objUser->cleanString($softId);
	$objSoftware->deleteError();
	
	//$deleted = $objSoftware->wasDeleted();
	
	//if($deleted)
	//{
		$_SESSION['succesMessage'] = 5;
	//}
	//else 
	//{
	//	$_SESSION['errorMessage'] = 3;
	//}
	$url = 'view_software_errors.php';
	echo "<script>window.location='$url'</script>";
	exit;
}
?>

<script>
function confirmBox(param)
{
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "#dialog-confirm" ).dialog({
		resizable: false,
		height:140,
		modal: true,
		buttons: {
			"Delete": function() {
				$( this ).dialog( "close" );
				window.location = 'view_software_errors.php?do='+param;
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});	
}
</script>

<!-- Delete record confirmation Dialog -->
<div id="dialog-confirm" title="Delete Error?" style="display:none;">
    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are you sure you want to delete this record?
</div>

<div class="content">
    <div class="row-fluid">
        <div class="span10">
            <div class="widget" style="width:90% !important">
                <div class="head">
                    <div class="icon"><i class="icosg-clipboard1"></i></div>
                    <h2>All Software Errors</h2>
                </div>
                <div class="block-fluid">
                    
                    <?php         
                        if ( isset($_SESSION['succesMessage']) )
                        {
                            $msg = $objUser->successMsg($_SESSION['succesMessage']);
                    ?>
                            <div class="alert alert-success">            
                                <?php echo $msg;?>
                            </div>
                    <?php
                            unset($_SESSION['succesMessage']);
                        }
                        if ( isset($_SESSION['errorMessage']) )
                        {
                            $errMsg = $objUser->errorMsg($_SESSION['errorMessage']);
                    ?>
                            <div class="alert alert-error">            
                                <?php echo $errMsg;?>
                            </div>
                    <?php
                            unset($_SESSION['errorMessage']);
                        }
                    ?>
                    
                    <table class="fpTable table-hover" cellpadding="0" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                             <th width="7%">Sr. No.</th>
                             <th width="25%">System Name</th>
                             <th width="35%">Error Message</th>
                             <th width="15%">Date and Time</th>
                             <th width="10%">View</th>
                             <th width="8%">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                        <?php
                            $softwareErrors=$objSoftware->getSoftwareErrors();
						if($softwareErrors)
						{	
                            $count=0;
                            foreach($softwareErrors as $error)
                            {
                                $count +=1;
								$doView=$error->Id;
                                $doDel = $objUser->encrypt('edit|'.$error->Id);
                        ?>
                            <tr>
                                <td class="TAR"><?php echo $count;?></td>
                                <td align="center"><?php echo "<a class=\"iframe\" href=\"computer_detail.php?do={$doView}\">$error->pcName</a>";?></td>
                                <td align="left">
								<?php
								 $message=( strlen($error->errorMessage) > 60 )? substr($error->errorMessage, 0, 60)."...": $error->errorMessage;
								 echo "<a class=\"iframe\" href=\"error_detail.php?do={$doView}\">$message</a>"; 
								?>
                                </td>
                                <td align="center"><?php echo $error->dateTime;?></td>
                                <td align="center">
                                        <input type="checkbox" name="errorStatus" id="<?php echo $error->Id;?>" value="<?php echo $error->Status;?>"
                                     <?php echo ($error->Status == 1)?'checked="checked"':'';?> onclick="errorStatus(this.id, this.value)" />
                                    </td>
                                <td class="TAC">
                                    <span id="link" onclick="confirmBox('<?php echo $doDel;?>')"><span class="icon-trash"></span></span>
                                </td>
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
function errorStatus(errorId, errorStatus)
{
	 $.ajax({
			  type: 'POST',
			  url: '../includes/ajax/ajax_calls.php',
			  data: {'errorId': errorId, 'errorStatus': errorStatus},
			  success: function(data){
			  $('#'+errorId).val(data);
			  }
		 })
}
</script>