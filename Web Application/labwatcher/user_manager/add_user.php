<?php
include('../config/config.php');
include('../template/html.inc.php');
include('../includes/classes/class.User.php');
$objUser = new User();
$objUser->isLogin();
$objUser->isAdminLogin();
startHtml('Add User');
topHeader();
leftNavigation();
?>

<?php

// When form is submitted
if ( isset( $_POST['submit'] ) )
{
	$objUser->fName = $objUser->cleanString($_REQUEST['fName']);
	$objUser->lName = $objUser->cleanString($_REQUEST['lName']);
	$objUser->email = $objUser->cleanString($_REQUEST['email']);
	$objUser->type = '2';
	$objUser->password = $objUser->cleanString($_REQUEST['password']);

	$objUser->addUser();
	$inserted = $objUser->wasInserted();
	
	if($inserted)
	{
		$_SESSION['succesMessage'] = 3;
	}
	else {
		$_SESSION['errorMessage'] = 3;
	}
	
	$url = 'view_users.php';
	echo "<script>window.location='$url'</script>";
	exit;
}
?>
<script>
var alertText;
function validateEmail(field, rules, i, options)
{
	$.ajax({
		data: 'emailCheck='+field.val(),
		url: '../includes/ajax/user.php',
		type: 'post',
		dataType: 'JSON'
	}).done(function(data){
		if (data)
		{
			alertText = data.email;
		}
		else
		{
			alertText = '';
		}
	})
	if (alertText)
	{
		return alertText;
	}
}
</script>
<div class="content">
    <div class="row-fluid">
        <div class="span8">
            <div class="widget">
                <div class="head">
                    <div class="icon"><i  class="icosg-plus"></i></div>
                    <h2>Add User</h2>
                </div>
                <form id="validate"  method="POST" action="">
                    <div class="block-fluid">
                        
                        <div class="row-form">
                            <div class="span2">First Name:<font color="#FF0000">*</font></div>
                            <div class="span10">
                                <input type="text" name="fName" id="fName" class="validate[required]"/>
                            </div>
                        </div>
                        
                        <div class="row-form">
                            <div class="span2">Last Name:<font color="#FF0000">*</font></div>
                            <div class="span10">
                                <input type="text" name="lName" id="lName" class="validate[required]"/>
                            </div>
                        </div>
                        
                        <div class="row-form">
                            <div class="span2">Email:<font color="#FF0000">*</font></div>
                            <div class="span10">
                                <input type="text" name="email" id="email" class="validate[required,custom[email],funcCall[validateEmail]]"/>
                            </div>
                        </div>
                        
                        <div class="row-form">
                            <div class="span2">Password:<font color="#FF0000">*</font></div>
                            <div class="span10">
                                <input type="password" name="password" id="password" class="validate[required,minSize[6]]"/>
                            </div>
                        </div>
                        
                        <div class="row-form">
                            <div class="span2">Repeat Password:<font color="#FF0000">*</font></div>
                            <div class="span10">
                                <input type="password" name="repassword" id="repassword" class="validate[required,equals[password],minSize[6]]"/>
                            </div>
                        </div>
                       
                        <div class="toolbar bottom TAR">
                            <div class="btn-group">
                                <button class="btn btn-success" type="submit" name="submit">Add User</button>
                                <button class="btn btn-info" type="button" onClick="$('#validate').validationEngine('hide');">Hide prompts</button>
                                <button class="btn btn-primary" type="button" onclick="window.location='view_users.php'">Cancel</button>
                            </div>
                        </div>
    
                    </div>                
                </form>
            </div>
        </div>
    </div>
</div>
<?php
endHtml();
footer();
?>
