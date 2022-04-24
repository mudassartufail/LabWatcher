<?php
include('../config/config.php');
include('../template/html.inc.php');
include('../includes/classes/class.User.php');

$objUser = new User();
$objUser->isLogin();
$objUser->isAdminLogin();

startHtml('All Users');
topHeader();
leftNavigation();
?>

<?php
// Get city Id and DELETE the record
if ( isset($_REQUEST['do']))
{
	list($do, $userId) = explode('|', $objUser->cleanString($objUser->decrypt($_REQUEST['do'])));
	$objUser->id = $objUser->cleanString($userId);
	$objUser->deleteUser();
	$_SESSION['succesMessage'] = 5;
	$url = 'view_users.php';
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
				window.location = 'view_users.php?do='+param;
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});	
}
</script>

<!-- Delete record confirmation Dialog -->
<div id="dialog-confirm" title="Delete User?" style="display:none;">
    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are you sure you want to delete this record?
</div>

<div class="content">
    <div class="row-fluid">
        <div class="span10">
            <div class="widget">
                <div class="head">
                    <div class="icon"><i class="icosg-clipboard1"></i></div>
                    <h2>All Users</h2>

                    <ul class="buttons">                                                        
                        <li><a href="add_user.php"><span class="icosg-plus1"></span></a></li>
                    </ul>
                    
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
                             <th width="8%">Sr. No.</th>
                             <th>First Name</th>
                             <th>Last Name</th>
                             <th>User Type</th>
                             <th>Email</th>
                             <th>Date Created</th>
                             <th width="8%">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                        <?php
                            $users = $objUser->viewUser();
						if($users)
						{	
                            $count=0;
                            foreach($users as $user)
                            {
                                $count +=1;
                                $doEdit = $objUser->encrypt('edit|'.$user->id);
                                $doDel = $objUser->encrypt('edit|'.$user->id);
								$objUser->id=$user->id;
                        ?>
                            <tr>
                                <td class="TAR"><?php echo $count;?></td>
                                <td align="center"><?php echo $objUser->capitalize($user->firstName);?></td>
                                <td align="center"><?php echo $objUser->capitalize($user->lastName);?></td>
                                <td align="center">
								<?php
                                if($user->type=='2')
								{
								 echo "Lab Staff"; 
								}
								?>
                                </td>
                                <td align="center"><?php echo $user->email;?></td>
                                <td align="center"><?php echo $user->dateCreated;?></td>
                                <td class="TAC">
                                	<a href="edit_user.php?do=<?php echo $doEdit;?>"><span class="icon-pencil"></span></a>
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
endHtml();
footer();
?>