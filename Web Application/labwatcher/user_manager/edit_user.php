<?php
include('../config/config.php');
include('../template/html.inc.php');
include('../includes/classes/class.User.php');
$objUser = new User();
$objUser->isLogin();
$objUser->isAdminLogin();
startHtml('Edit User');
topHeader();
leftNavigation();
?>

<?php

if(isset($_REQUEST['do']))
{
    list($do, $userId) = explode('|', $objUser->cleanString($objUser->decrypt($_REQUEST['do'])));
	$objUser->id=$userId;
	$user=$objUser->getUserData();
	$userFName = $user[0]->firstName;
	$userLName = $user[0]->lastName;
	$userEmail = $user[0]->email;
	$userPassword = $user[0]->password;
	$userType=$user[0]->type;
}

// If form is submitted
if ( isset( $_POST['submit'] ) )
{
	if ( isset( $_REQUEST['f_name']))
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
	if ( isset( $_REQUEST['password'] ) )
	{
		$objUser->password =  $objUser->cleanString($_REQUEST['password']);
	}
	$objUser->type =  '2';		
	
	// Insert into DB
	$objUser->id =$userId;
	$objUser->updateUser();
	$updated = $objUser->wasUpdated();
	
	if ( $updated )
	{
		$_SESSION['succesMessage'] = 4;
	}
	else {
		$_SESSION['errorMessage'] = 3;
	}
	$url = 'view_users.php';
	echo "<script>window.location='$url'</script>";
	exit;
}

?>

<div class="content">
    <div class="row-fluid">
       <div class="span8">
                <div class="widget">
                    <div class="head">
                        <div class="icon"><i class="icosg-plus"></i></div>
                        <h2>Edit User</h2>
                    </div>
                    
                    <form id="validate"  method="POST" action="" enctype="multipart/form-data">
                    <div class="block-fluid">
                    
                        <div class="row-form">
                            <div class="span2">First Name:<font color="#FF0000">*</font></div>
                            <div class="span10">
                                <input type="text" name="f_name" id="f_name" class="validate[required]" value="<?php echo $userFName;?>"/>
                            </div>
                        </div>
                        
                        <div class="row-form">
                            <div class="span2">Last Name:<font color="#FF0000">*</font></div>
                            <div class="span10">
                                <input type="text" name="l_name" id="l_name" class="validate[required]" value="<?php echo $userLName;?>"/>
                            </div>
                        </div>
                        
                        <div class="row-form">
                            <div class="span2">Email:<font color="#FF0000">*</font></div>
                            <div class="span10">
                                <input type="text" name="email" id="email" class="validate[required,custom[email],funcCall[validateEmail]]" value="<?php echo $userEmail;?>"/>
                                <input type="hidden" name="hiddenEmail" id="hiddenEmail" value="<?php echo $userEmail;?>" />
                            </div>
                        </div>
                        
                        <div class="row-form">
                            <div class="span2">Password:<font color="#FF0000">*</font></div>
                            <div class="span10">
                                <input type="password" name="password" id="password" class="validate[required,minSize[6]]" value="<?php echo $userPassword;?>"/>
                            </div>
                        </div>
                        
                        <div class="row-form">
                            <div class="span2">Repeat Password:<font color="#FF0000">*</font></div>
                            <div class="span10">
                                <input type="password" name="repassword" id="repassword" class="validate[required,equals[password],minSize[6]]" value="<?php echo $userPassword;?>"/>
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


<script>
var alertText;
function validateEmail(field, rules, i, options)
{
	var oldEmail=$('#hiddenEmail').val();
	var presentEmail=field.val();
	
  if(oldEmail!=presentEmail)
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
}
</script>

<?php
footer();
endHtml();
?>