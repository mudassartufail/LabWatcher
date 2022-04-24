<?php
/****************************************************/
// Filename: config.php
// Author: Muhammad Mudassar Tufail
// Created Date: 07-10-2013
// Description: Configuration file
/****************************************************/
session_start();
/* *****   Start: Site Links & URLs	**********  */
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','labwatcher_db');
define('ADMIN_PATH',$_SERVER['DOCUMENT_ROOT'].'/labwatcher/');
define('ADMIN_URL','http://'.$_SERVER['HTTP_HOST'].'/labwatcher/');

define('ADMIN_INCLUDES',ADMIN_PATH.'includes/');
define('ADMIN_CSS',ADMIN_URL.'css/');
define('ADMIN_JS',ADMIN_URL.'js/');
define('ADMIN_IMG',ADMIN_URL.'img/');
define('ADMIN_AJAX',ADMIN_URL.'includes/ajax/');
define('SYSTEM_EMAIL','mudassartufailmalik@gmail.com');
define('SYSTEM_EMAIL_NAME','Mudassar Tufail');

$dbCon = mysql_connect(DB_HOST,DB_USER,DB_PASS);
mysql_select_db(DB_NAME);
/* *****   End: Site Links & URLs	**********  */
?>