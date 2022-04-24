<?php
include('../config/config.php');
include('../template/html.inc.php');
include('../includes/classes/class.User.php');

$objUser=new User();
$objUser->isLogin();
$objUser->id = $_SESSION['Id'];

$userProfile = $objUser->getUserProfile();

if ( isset( $_POST['submit'] ) )
{
	$objUser->id=$_SESSION['Id'];
	
	if ( isset( $_REQUEST['f_name'] ) )
	{
		$objUser->fName = $objUser->cleanString($_REQUEST['f_name']);
	}
	if ( isset( $_REQUEST['l_name'] ) )
	{
		$objUser->lName = $objUser->cleanString($_REQUEST['l_name']);
	}
	if ( isset( $_REQUEST['email'] ) )
	{
		$objUser->email = $objUser->cleanString($_REQUEST['email']);
	}

	$objUser->updateProfile();
	
	$updated = $objUser->wasUpdated();

	if ( $updated )
	{
		$objUser->id=$_SESSION['Id'];
		$getName = $objUser->getUserProfile();
		$_SESSION['FullName'] = $getName[0]['FullName'];
		$_SESSION['succesMessage'] = 1;
	}
	else 
	{
		$_SESSION['errorMessage'] = 1;
	}
	header("Location: update_profile.php");
	exit;

}

startHtml('Update Profile');
topHeader();
leftNavigation();
?>
<style>
input[disabled], input[readonly] {
    background-color: #EEEEEE;
    cursor: not-allowed;
}
</style>
<div class="content">
    <div class="row-fluid">
        <div class="span8">
            <div class="widget">
                <div class="head">
                    <div class="icon"><i class="icosg-user"></i></div>
                    <h2>Update Profile</h2>
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
                            <div class="span2">First Name<font color="#FF0000">*</font></div>
                            <div class="span10">
                                <input type="text" name="f_name" id="f_name" class="validate[required,maxSize[50]]" value="<?php echo $userProfile[0]['firstName'];?>" />
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span2">Last Name<font color="#FF0000">*</font></div>
                            <div class="span10">
                                <input type="text" name="l_name" id="l_name" class="validate[required,maxSize[50]]" value="<?php echo $userProfile[0]['lastName'];?>" />
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span2">Email<font color="#FF0000">*</font></div>
                            <div class="span10">
                                <input type="text" name="email" id="email" class="validate[required,custom[email]]" value="<?php echo $userProfile[0]['email'];?>" readonly/>
                            </div>
                        </div>
                        <div class="toolbar bottom TAR">
                            <div class="btn-group">
                                <button class="btn btn-success" type="submit" name="submit">Update Profile</button>
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