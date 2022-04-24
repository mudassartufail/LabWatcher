<?php
include_once('class.database.php');
class commonFunctions extends database
{
	public $pcId;
	public $softId;
	public $hardId;
	
	// Constructor
	public function __construct()
	{
		$this->pcId = '';
		$this->softId = '';
		$this->hardId = '';
	}
	
	///  Function that will capitalized 1st Chanrater of each word.
	public function capitalize($str)
	{
		$lowercaseTitle = strtolower($str);
		$ucTitleString = ucwords($lowercaseTitle);
		return $ucTitleString;
	}
	
	
	//Get all pc information
	public function getPcDetails()
	{
		$qry="SELECT
		          computer.system_name,
				  computer.processor_info,
				  computer.ram_info,
				  computer.hard_disk_info,
				  computer.os_info,
				  computer.status
			  FROM
			      computer
			  WHERE
			      computer.system_name='".$this->pcId."' ";
				  
		parent::executeQuery($qry);
		$qryRes = parent::asObject();
		if ( $qryRes )
		{
			return $qryRes;
		}		  
	}
	

}
?>