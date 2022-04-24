<?php
include_once('class.database.php');
class errors extends database
{
	public $id;
    public $errormsg;
	public $pcname;
	public $status;
	public $type;
	
	// Constructor
	public function __construct()
	{
		$this->id='';
		$this->errormsg='';
		$this->pcname='';
		$this->status='0';
		$this->type='';
	}
	
	// Function to insert registration information into the database
	public function newSoftwareError()
	{
	    //$qry="INSERT INTO `labwatcher_db`.`tbl_errors` (`Id`, `errorMessage`, `pcName`,``) VALUES (NULL, '".$this->errormsg."', '".$this->pcname."')";
		
		$qry="INSERT INTO tbl_errors
		      SET
		         tbl_errors.errorMessage='".$this->errormsg."',
			     tbl_errors.pcName='".$this->pcname."',
				 tbl_errors.status='".$this->status."',
				 tbl_errors.type='1',
				 tbl_errors.dateTime=NOW()";
		parent::executeQuery($qry);
	}
	
	// Function to insert registration information into the database
	public function newHardwareError()
	{
	    //$qry="INSERT INTO `labwatcher_db`.`tbl_errors` (`Id`, `errorMessage`, `pcName`,``) VALUES (NULL, '".$this->errormsg."', '".$this->pcname."')";
		
		$qry="INSERT INTO tbl_errors
		      SET
		         tbl_errors.errorMessage='".$this->errormsg."',
			     tbl_errors.pcName='".$this->pcname."',
				 tbl_errors.status='".$this->status."',
				 tbl_errors.type='0',
				 tbl_errors.dateTime=NOW()";
		parent::executeQuery($qry);
	}	
	
	// Function to delete error from the database
	public function deleteError()
	{
		$qry = "DELETE
				FROM
					tbl_errors
				WHERE
					 tbl_errors.Id =".$this->id;
		parent::executeQuery($qry);
	}	
	
	//Get Latest Software Errors
	public function getLatestErrors()
	{
		$qry="SELECT tbl_errors.Id,
					 tbl_errors.errorMessage,
					 tbl_errors.pcName,
					 tbl_errors.Type,
					 tbl_errors.dateTime,
					 tbl_errors.Status
			  FROM   tbl_errors
			  WHERE  tbl_errors.Status='0'
			  ORDER BY tbl_errors.Id DESC";
		
		parent::executeQuery($qry);
		$qryRes=parent::asObject();
		if ( $qryRes )
		{
			return $qryRes;
		}
	}
	
	public function updateErrorStatus()
	{
		$qry = "UPDATE tbl_errors
			SET
				Status = '".$this->status."'
			WHERE
				tbl_errors.Id = '".$this->id."'";
		parent::executeQuery($qry);
	}
	
	public function getErrorDetails()
	{
		$qry="SELECT
					 tbl_errors.errorMessage,
					 tbl_errors.pcName,
					 tbl_errors.dateTime
			  FROM   tbl_errors
			  WHERE  tbl_errors.Id='".$this->id."'";
			  
		parent::executeQuery($qry);
		$qryRes=parent::asObject();
		if ( $qryRes )
		{
			return $qryRes;
		}	  
	}
	
	public function getSoftwareErrors()
	{
		$qry="SELECT
		             tbl_errors.Id,
					 tbl_errors.errorMessage,
					 tbl_errors.pcName,
					 tbl_errors.Type,
					 tbl_errors.dateTime,
					 tbl_errors.Status
			  FROM   tbl_errors
			  WHERE  tbl_errors.Type='1'
			  ORDER BY tbl_errors.Id DESC";
			  
		parent::executeQuery($qry);
		$qryRes=parent::asObject();
		if ( $qryRes )
		{
			return $qryRes;
		}		 
	}
	
	public function getHardwareErrors()
	{
		$qry="SELECT
		             tbl_errors.Id,
					 tbl_errors.errorMessage,
					 tbl_errors.pcName,
					 tbl_errors.Type,
					 tbl_errors.dateTime,
					 tbl_errors.Status
			  FROM   tbl_errors
			  WHERE  tbl_errors.Type='0'
			  ORDER BY tbl_errors.Id DESC";
			  
		parent::executeQuery($qry);
		$qryRes=parent::asObject();
		if ( $qryRes )
		{
			return $qryRes;
		}	 
	}
	
	public function getAllErrors()
	{
		$qry="SELECT
		             tbl_errors.Id,
					 tbl_errors.errorMessage,
					 tbl_errors.pcName,
					 tbl_errors.Type,
					 tbl_errors.dateTime,
					 tbl_errors.Status
			  FROM   tbl_errors
			  ORDER BY tbl_errors.Id DESC";
			  
		parent::executeQuery($qry);
		$qryRes=parent::asObject();
		if ( $qryRes )
		{
			return $qryRes;
		}		 
	}
	
	public function getErrorInfo()
	{
	  $qry="SELECT
		             tbl_errors.Id,
					 tbl_errors.errorMessage,
					 tbl_errors.pcName,
					 tbl_errors.Type,
					 tbl_errors.dateTime,
					 tbl_errors.Status
			  FROM   tbl_errors
			  WHERE  tbl_errors.Id='".$this->id."'
			  ORDER BY tbl_errors.Id DESC";
			  
		parent::executeQuery($qry);
		$qryRes=parent::asObject();
		if ( $qryRes )
		{
			return $qryRes;
		}		
	}
	
	
}
?>