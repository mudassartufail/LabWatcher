<?php
include_once('class.database.php');
class pc extends database
{
    public $pcName;
	public $pcProcessor;
	public $pcRam;
	public $pcHarddisk;
	public $pcOs;
	
	public $pcStatus;
	public $harddiskUsage;
	
	public $keyboardStatus;
	public $mouseStatus;
	public $processorStatus;
	public $harddiskStatus;
	public $ramStatus;
	public $monitorStatus;
	
	// Constructor
	public function __construct()
	{
		$this->pcName='';
		$this->pcProcessor='';
		$this->pcRam='';
		$this->pcHarddisk='';
		$this->pcOs='';
		
		$this->pcStatus='';
		$this->harddiskUsage='';
		
		$this->keyboardStatus='';
		$this->processorStatus='';
		$this->ramStatus='';
		$this->mouseStatus='';
		$this->harddiskStatus='';
		$this->monitorStatus='';
	}
 
    public function newPcConnection()
	{
		$qry="INSERT INTO tbl_computers
		      SET
			     tbl_computers.systemName='".$this->pcName."',
				 tbl_computers.processorInfo='".$this->pcProcessor."',
				 tbl_computers.ramInfo='".$this->pcRam."',
				 tbl_computers.hardDiskInfo='".$this->pcHarddisk."',
				 tbl_computers.osInfo='".$this->pcOs."',
				 tbl_computers.Status='1',
				 tbl_computers.dateTime=NOW()";
				 
		parent::executeQuery($qry);		 
	}
	
	public function getConnectedPC()
	{
		$qry="SELECT
		            tbl_computers.systemName,
					tbl_computers.Status,
					tbl_computers.dateTime
			  FROM
			        tbl_computers
			  WHERE
			        tbl_computers.Status='1'";
		
		parent::executeQuery($qry);
		$qryRes = parent::asObject();
		if ( $qryRes )
		{
			return $qryRes;
		}			
	}
	
	public function countErrors()
	{
		$qry="SELECT
		            COUNT(tbl_errors.Id) AS Total
			  FROM
			        tbl_errors
			  WHERE
			        tbl_errors.pcName='".$this->pcName."'";
		
		parent::executeQuery($qry);
		$qryRes = parent::asObject();
		if ( $qryRes )
		{
			return $qryRes[0]->Total;
		}	
	}

	
	// Function to update pc information into the database
	public function updateConnection()
	{
		$qry="UPDATE tbl_computers
		      SET
			     tbl_computers.Status='".$this->pcStatus."',
				 tbl_computers.dateTime=NOW()
				 
			  WHERE
			      tbl_computers.systemName='".$this->pcName."' "; 
				
		parent::executeQuery($qry);
	}
	
	// Function to delete pc information into the database
	public function deleteConnection()
	{
		$qry="DELETE FROM `labwatcher_db`.`tbl_computers` WHERE `tbl_computers`.`systemName` = '".$this->pcName."' ";
				
		parent::executeQuery($qry);
	}
	
	
	
	// Function to check if pcname already exists in the system
	public function validatePC()
	{
		$qry = "SELECT
					COUNT(*) AS num
				FROM
					computer
				WHERE
					computer.system_name = '".$this->pcName."'";
					
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
		if (!isset($_SESSION['id']) && !isset($_SESSION['password']))
		{
			header("Location:".SITE_URL."index.php");
		}
	}
	
	// Check membership of the user
	function checkPcStatus()
	{
		$qry = "SELECT
					computer.status
				FROM
					computer
				WHERE
					computer.system_name = '".$this->pcName."' ";
		
		parent::executeQuery($qry);
		$qryRes = parent::asObject();
		if ( $qryRes )
		{
			return $qryRes;
		}
	}
	
	// Function to get pc Data
	public function getPcInfo()
	{
		$qry = "SELECT
		         tbl_computers.systemName,
				 tbl_computers.processorInfo,
				 tbl_computers.ramInfo,
				 tbl_computers.hardDiskInfo,
				 tbl_computers.osInfo,
				 tbl_computers.Status,
				 tbl_computers.dateTime
				FROM
					tbl_computers
				WHERE
					tbl_computers.systemName = '".$this->pcName."'";
		
		parent::executeQuery($qry);
		$qryRes = parent::asObject();
		if ( $qryRes )
		{
			return $qryRes;
		}
	}
	
	// Function to get pc Data
	public function getAllComputers()
	{
		$qry = "SELECT
		         tbl_computers.systemName,
				 tbl_computers.Status,
				 tbl_computers.dateTime
				FROM
					tbl_computers";
					
		parent::executeQuery($qry);
		$qryRes = parent::asObject();
		if ( $qryRes )
		{
			return $qryRes;
		}
	}
	
	public function countSoftwareErrors()
	{
		$qry="SELECT 
		             COUNT(tbl_errors.Id) AS softwareErrors
			   FROM  tbl_errors
			   WHERE tbl_errors.Type='1' AND tbl_errors.pcName='".$this->pcName."'";
		parent::executeQuery($qry);
		$qryRes=parent::asObject();
		
		if($qryRes)
		{
			return $qryRes[0]->softwareErrors;
		}		   
	}
	
	public function countHardwareErrors()
	{
		$qry="SELECT 
		             COUNT(tbl_errors.Id) AS hardwareErrors
			   FROM  tbl_errors
			   WHERE tbl_errors.Type='0' AND tbl_errors.pcName='".$this->pcName."'";
		parent::executeQuery($qry);
		$qryRes=parent::asObject();
		
		if($qryRes)
		{
			return $qryRes[0]->hardwareErrors;
		}
			   
	}
	
	public function getDeviceStatus()
	{
		$qry="SELECT
				  tbl_computers.hardDiskInfo,
				  tbl_computers.hardDiskUsage,
				  tbl_computers.hardDiskStatus,
				  tbl_computers.keyboardStatus,
				  tbl_computers.mouseStatus,
				  tbl_computers.monitorStatus,
				  tbl_computers.processorStatus,
				  tbl_computers.ramStatus
			  FROM
			  	  tbl_computers
			  WHERE
			      tbl_computers.systemName='".$this->pcName."'";
		
		parent::executeQuery($qry);
		$qryRes=parent::asObject();
		if ( $qryRes )
		{
			return $qryRes;
		}	
	}
	
	public function getAllPc()
	{
		$qry="SELECT `systemName` FROM `tbl_computers`";
		parent::executeQuery($qry);
		
		$qryRes=parent::asObject();
		
		if($qryRes)
		{
			return $qryRes;
		}
	}
	
	public function getPcErrors($data)
	{
		if($data=="software")
		{
			$data='1';
		}
		else if($data=="hardware")
		{
			$data='0';
		}
		else if($data=="all")
		{
			$data='0'."' OR tbl_errors.Type= '".'1';
		}
		
		$qry="SELECT
		             tbl_errors.Id,
					 tbl_errors.errorMessage,
					 tbl_errors.pcName,
					 tbl_errors.Type,
					 tbl_errors.dateTime,
					 tbl_errors.Status
			  FROM   tbl_errors
			  WHERE  tbl_errors.pcName='".$this->pcName."' AND (tbl_errors.Type='".$data."')
			  ORDER BY tbl_errors.Id DESC";

		parent::executeQuery($qry);
		$qryRes=parent::asObject();
		
		if($qryRes)
		{
			return $qryRes;
		}
	}
	
	public function updateDeviceStatus()
	{
		$qry="UPDATE tbl_computers
		      SET
			     tbl_computers.keyboardStatus='".$this->keyboardStatus."',
				 tbl_computers.mouseStatus='".$this->mouseStatus."',
				 tbl_computers.monitorStatus='".$this->monitorStatus."',
				 tbl_computers.processorStatus='".$this->processorStatus."',
				 tbl_computers.hardDiskStatus='".$this->harddiskStatus."',
				 tbl_computers.ramStatus='".$this->ramStatus."',
				 tbl_computers.hardDiskUsage='".$this->harddiskUsage."'";
		parent::executeQuery($qry);
	}
	
	public function getHardDiskUsage()
	{
		$qry="SELECT
				  tbl_computers.hardDiskUsage
			  FROM
			  	  tbl_computers
			  WHERE
			      tbl_computers.systemName='".$this->pcName."'";
				  
		parent::executeQuery($qry);
		$qryRes=parent::asObject();
		
		if($qryRes)
		{
			return $qryRes;
		}
	}
	
}
?>