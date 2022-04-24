<?php
include('../../config/config.php');
include_once('../classes/class.User.php');

$objUser = new User();
$eMsg = array();

// Check if category already exists in the system
if (isset($_REQUEST['emailCheck']))
{
	$objUser->email = $objUser->cleanString($_REQUEST['emailCheck']);
	$isAvailable = $objUser->emailCheck();
	
	$count=$isAvailable[0]->Rows;
	
	if ($count>0)
	{
		$eMsg['email'] = "*This Email already exists in the system. ";
	}
}

// User Login: check email/password, if mnatches in database then login user
if(isset($_REQUEST['email']) && isset($_REQUEST['password']))
{
	$objUser->email = $objUser->cleanString($_REQUEST['email']);
	$objUser->password = $objUser->cleanString($_REQUEST['password']);
	
	// If user chooses to be remembered
	if (isset($_REQUEST['remember']))
	{
		setcookie('email', $objUser->email, time()+(60*60*24*30), '/');
		setcookie('password', $objUser->password, time()+(60*60*24*30), '/');
	}
	else
	{
		setcookie('email', $objUser->email, time()-(60*60*24*30), '/');
		setcookie('password', $objUser->password, time()-(60*60*24*30), '/');
	}
	
	$result=$objUser->login();
	
	if($result)
	{
		echo "1";
	}
	else 
	{
		echo "0";
	}
}

// Forgot password
if ( isset( $_REQUEST['forgetEmail'] ) )
{
	$objUser->email = $objUser->cleanString($_REQUEST['forgetEmail']);
	$objUser->recoverPassword();
}


if ($eMsg)
{
	$jsonMsg = json_encode($eMsg);
	print_r($jsonMsg);
}
?>