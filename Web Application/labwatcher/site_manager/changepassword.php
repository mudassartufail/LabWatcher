<?php
include('../config/config.php');
include('../template/html.inc.php');
include('../includes/classes/class.User.php');

$objUser=new User();
$objUser->isLogin();
$objUser->id = $_SESSION['Id'];

// Get user old password
$userProfile = $objUser->getUserProfile();
$oldPassword = $userProfile[0]['password'];

// When form is submitted
if ( isset( $_POST['submit'] ) )
{
	if ( $oldPassword == $_REQUEST['oldPassword'] )
	{
		if ( isset( $_REQUEST['newPassword'] ) )
		{
			$objUser->password = $objUser->cleanString($_REQUEST['newPassword']);
		}
		$objUser->updatePassword();
		$updated = $objUser->wasUpdated();
	}
	
	if($updated)
	{
		$_SESSION['succesMessage'] = 2;
	}
	else 
	{
		$_SESSION['errorMessage'] = 2;
	}
	header("Location: changepassword.php");
	exit;

}

startHtml('Change Password');
topHeader();
leftNavigation();
?>
<div class="content">
    <div class="row-fluid">
        <div class="span8">
            <div class="widget">
                <div class="head">
                    <div class="icon"><i class="icosg-locked"></i></div>
                    <h2>Change Password</h2>
                </div>
                <form id="validate" method="POST" action="">
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
                        
                        
                        <div class="row-form">
                            <div class="span3">Old Password<font color="#FF0000">*</font></div>
                            <div class="span9">
                                <input type="password" name="oldPassword" id="oldPassword" class="validate[required]" />
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span3">New Password<font color="#FF0000">*</font></div>
                            <div class="span9">
                                <input type="password" name="newPassword" id="newPassword" class="validate[required,minSize[6]]" />
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span3">Confirm Password<font color="#FF0000">*</font></div>
                            <div class="span9">
                                <input type="password" name="confirmPassword" id="confirmPassword" class="validate[required,equals[newPassword]]"/>
                            </div>
                        </div>
                        <div class="toolbar bottom TAR">
                            <div class="btn-group">
                                <button class="btn btn-success" type="submit" name="submit">Update Password</button>
                                <button class="btn btn-info" type="button" onClick="$('#validate').validationEngine('hide');">Hide prompts</button>
                                <button class="btn btn-primary" type="button" onclick="window.location='index.php'">Cancel</button>
                            </div>
                        </div>
    
                    </div>                
                </form>
            </div>
        </div>
    </div>
</div>
<?php
footer();
endHtml();
?>