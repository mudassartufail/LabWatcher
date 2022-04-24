<?php
include_once('class.Database.php');
include_once('class.PHPMailer.php');

class User extends Database
{
	public $id;
	public $email;
	public $fName;
	public $lName;
	public $type;
	public $password;

	// Constructor
	public function __construct()
	{
		$this->id='';
		$this->fName='';
		$this->lName='';
		$this->email = '';
		$this->type='';
		$this->password = '';
	}
	
	public function addUser()
	{
		$qry = "INSERT INTO user 
			SET
				user.email ='".$this->email."',
				user.firstName='".$this->fName."',
				user.lastName='".$this->lName."',
				user.password='".$this->password."',
				user.type='".$this->type."',
				user.dateCreated=NOW()";
				
		parent::executeQuery($qry);
	}
	
	public function updateUser()
	{
		$qry = "UPDATE user 
			SET
				user.email ='".$this->email."',
				user.firstName='".$this->fName."',
				user.lastName='".$this->lName."',
				user.password='".$this->password."',
				user.type='".$this->type."',
				user.dateCreated=NOW()
			WHERE
			    user.id='".$this->id."'";	
		parent::executeQuery($qry);
	}
	
	// Function to check if username and password matches in database
	public function login()
	{
		$qry = "SELECT
					user.id,
					user.email,
					user.type,
					CONCAT(user.FirstName,' ',user.LastName) AS FullName,
					user.password
				FROM
					user
				WHERE
					user.email = '".$this->email."' AND user.`Password` = '".$this->password."'";
					
		parent::executeQuery($qry);
		$qryRes = parent::asArray();
		$affectedRows = parent::getAffectedRows();
		
		if ( $affectedRows > 0 )
		{
			$_SESSION['Id']=$qryRes[0]['id'];
			 $_SESSION['FullName']=$qryRes[0]['FullName'];
			 $_SESSION['email'] = $qryRes[0]['email'];
			 $_SESSION['type']=$qryRes[0]['type'];
			 $_SESSION['password'] = $qryRes[0]['password'];
			 return $qryRes;
		}
		else 
		{
			return false;
		}
	}
	
	// Function to get user profile information
	public function viewUser()
	{
		$qry = "SELECT
					user.id,
					user.firstName,
					user.lastName,
					CONCAT(user.firstName, ' ', user.lastName) AS FullName,
					user.password,
					user.type,
					user.dateCreated,
					user.email
				FROM
					user
				WHERE
				    user.type!='1'	
				ORDER BY
					user.id DESC";
						
		parent::executeQuery($qry);
		$qryRes = parent::asObject();
		if ( $qryRes )
		{
			return $qryRes;
		}
	}
	
	// Delete user from Database
	public function deleteUser()
	{
		$qry = "DELETE
				FROM
					user
				WHERE
					user.id = '".$this->id."'";
		parent::executeQuery($qry);
	}
	
	
	// Function to get user profile information
	public function getUserData()
	{
		$qry = "SELECT
					user.id,
					user.firstName,
					user.lastName,
					CONCAT(user.firstName, ' ', user.lastName) AS FullName,
					user.password,
					user.type,
					user.dateCreated,
					user.email
				FROM
					user
				WHERE
					user.id='".$this->id."'";
						
		parent::executeQuery($qry);
		$qryRes = parent::asObject();
		if ( $qryRes )
		{
			return $qryRes;
		}
	}
	
	
	
	// Function to check if user is logged in
	public function isLogin()
	{
		if ( !isset($_SESSION['email']) && !isset($_SESSION['password']) )
		{
			echo "<script>window.location='login.php'</script>";
		}
	}
	
	public function isAdmin()
	{
		if(isset($_SESSION['type']))
		{
			if($_SESSION['type']=='1')
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
	}
	
	
	public function isAdminLogin()
	{
		if(isset($_SESSION['type']))
		{
			if($_SESSION['type']=='2')
			{
				$url=ADMIN_URL."index.php";
				echo "<script>window.location='$url'</script>";
			}
		}
	}
	
	
	// Function to update Password
	public function updatePassword()
	{
		$qry = "UPDATE user
			SET
				user.password = '".$this->password."'
			WHERE user.id = '".$this->id."' ";
		parent::executeQuery($qry);
	}
	
	function cleanString($string)
    {
		$trimmed = trim($string);
		$detagged = strip_tags($trimmed);
		if(get_magic_quotes_gpc())
		{
			$stripped = stripslashes($detagged);
			$escaped = mysql_real_escape_string($stripped);
		}
		else
		{
			$escaped = mysql_real_escape_string($detagged);
		}
		return $escaped;
    }
	
	
	/// Functions to display error messages
	function successMsg($e)
	{
		if($e == 1){
			$msg = "Profile has been successfully updated.";
		}if($e == 2){
			$msg = "Password has been successfully updated.";
		}if($e == 3){
			$msg = "Record has been successfully added.";
		}if($e == 4){
			$msg = "Record has been successfully updated.";
		}if($e == 5){
			$msg = "Record has been successfully deleted.";
		}
		return $msg;
	}
	
	function errorMsg($error)
	{
		if($error == 1){
			$errMsg = "<strong>Error! </strong>There is an error in updating your profile.";
		}if($error == 2){
			$errMsg = "<strong>Error! </strong>Wrong old password.";
		}if($error == 3){
			$errMsg = "<strong>Error! </strong>There is an error with your request. Please try again.";
		}if($error == 4){
			$errMsg = "<strong>Error! </strong>Parent category can not be deleted. Delete its sub categories first.";
		}if($error == 5){
			$errMsg = "<strong>Error! </strong>Parent agency can not be deleted. Delete its sub agencies first.";
		}
		return $errMsg;
	}
	
	
	// Encrypt the given string
function encrypt($string)
{
	$key = "TTL29881sDcvt5ljg6hTTL";
	$result = '';
	for($i=0; $i<strlen($string); $i++)
	{
		$char = substr($string, $i, 1);
		$keyChar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)+ord($keyChar));
		$result.=$char;
	}

	return base64_encode($result);
}

	// Decrypt the given string
	function decrypt($string)
	{
		$key = "TTL29881sDcvt5ljg6hTTL";
		$result = '';
		$string = base64_decode($string);
		
		for($i=0; $i<strlen($string); $i++)
		{
			$char = substr($string, $i, 1);
			$keyChar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)-ord($keyChar));
			$result.=$char;
		}	
		return $result;
	}
	
	///  Function that will capitalized 1st Chanrater of each word.
	function capitalize($str)
	{
		$lowercaseTitle = strtolower($str);
		$ucTitleString = ucwords($lowercaseTitle);
		return $ucTitleString;
	}
	
	// Function to recover password
	public function recoverPassword()
	{
		$qry = "SELECT
					user.id,
					user.email,
					user.password
				FROM
					user
				WHERE
					user.email = '".$this->email."' ";
					
		parent::executeQuery($qry);
		$qryRes = parent::asObject();
		$affectedRows = parent::getAffectedRows();
		
		if ( $affectedRows > 0 )// If valid email address
		{		
			if ( $qryRes )
			{
				$this->id = $qryRes[0]->id;
				$getName = $this->profileInfo();
				$userFullName = $getName[0]->FullName;
				$userEmail = $qryRes[0]->email;
				$userPassword = $qryRes[0]->password;
			}
		}
		if($affectedRows>0)
		{
			$mail = new PHPMailer(); // defaults to using php "mail()"
			$body = "
				Dear $userFullName,<br/>
				Your password is '$userPassword'. Once logged into the web site you can change your password.<br/><br/>
				
				Regards,<br/>
				LabWatcher Team";
			$mail->IsSMTP();	
			$mail->SetFrom(SYSTEM_EMAIL, SYSTEM_EMAIL_NAME);
			$mail->AddReplyTo(SYSTEM_EMAIL, SYSTEM_EMAIL_NAME);
			$mail->AddAddress("$userEmail", "$userFullName");
			$mail->Subject="LabWatcher - Recover Password";
			$mail->AltBody="To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
			$mail->MsgHTML($body);
			
			if(!$mail->Send())
			{
				echo '<font color="#B70000" id="forgotErr">Mailer Error: ' . $mail->ErrorInfo . '</font>';
			}
			else
			{
				echo '<font color="green" id="forgotErr">Your password is sent to your email. Please check your email.</font>';
			}
			
		}
		else 
		{
			echo '<font color="#B70000" id="forgotErr">This email does not exists in our system.</font>';
		}
	}
	
	// Update record to Database
	public function emailCheck()
	{
		$qry = "SELECT
					COUNT(user.email) AS Rows
				FROM
					user
				WHERE
					user.email = '".$this->email."' ";
				
		parent::executeQuery($qry);
		$qryRes = parent::asObject();
		if ($qryRes)
		{
			return $qryRes;
		}
	}
	
	public function getUserProfile()
	{
		$qry = "SELECT
					user.id,
					user.firstName,
					user.lastName,
					user.email,
					user.password,
					CONCAT(user.firstName, ' ', user.lastName) AS FullName
				FROM
					user
				WHERE
				    user.id='".$this->id."'";
						
		parent::executeQuery($qry);
		$qryRes = parent::asArray();
		if ( $qryRes )
		{
			return $qryRes;
		}
	}
	
	public function updateProfile()
	{
		$qry="UPDATE user
		      SET 
			      user.firstName='".$this->fName."',
			      user.lastName='".$this->lName."',
			      user.email='".$this->email."' 
			  WHERE
			      user.id='".$this->id."'";
				  
		parent::executeQuery($qry);
	}
}
?>