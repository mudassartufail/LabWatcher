<?php
include_once(ADMIN_PATH.'includes/classes/class.Breadcrumbs.php');
function startHtml($title)
{
	$GLOBALS['1'] = $title;
?>
<!DOCTYPE html>
<html lang="en">
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />        
    
    <title><?php echo (!empty($title)) ? 'LabWatcher System :: '.$title : '';?></title>
    
    <link href="<?php echo ADMIN_CSS;?>stylesheets.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>zebra_pagination.css" type="text/css"> 
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/jquery/jquery-1.8.3.min.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/jquery/jquery-ui-1.9.1.custom.min.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/jquery/globalize.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/other/excanvas.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/other/jquery.mousewheel.min.js'></script>    
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/bootstrap/bootstrap.min.js'></script>            
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/cookies/jquery.cookies.2.2.0.min.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/fancybox/jquery.fancybox.pack.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/highcharts/highcharts.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/highcharts/modules/exporting.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/epiechart/jquery.easy-pie-chart.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/sparklines/jquery.sparkline.min.js'></script>    
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/pnotify/jquery.pnotify.min.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/fullcalendar/fullcalendar.min.js'></script>        
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/datatables/jquery.dataTables.min.js'></script>    
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/wookmark/jquery.wookmark.js'></script>        
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/jbreadcrumb/jquery.jBreadCrumb.1.1.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>
    <script type='text/javascript' src="<?php echo ADMIN_JS;?>plugins/uniform/jquery.uniform.min.js"></script>
    <script type='text/javascript' src="<?php echo ADMIN_JS;?>plugins/select/select2.min.js"></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/tagsinput/jquery.tagsinput.min.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/maskedinput/jquery.maskedinput-1.3.min.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/multiselect/jquery.multi-select.min.js'></script>    
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/validationEngine/languages/jquery.validationEngine-en.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/validationEngine/jquery.validationEngine.js'></script>        
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/stepywizard/jquery.stepy.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/animatedprogressbar/animated_progressbar.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/hoverintent/jquery.hoverIntent.minified.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/media/mediaelement-and-player.min.js'></script>    
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/cleditor/jquery.cleditor.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/shbrush/shCore.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/shbrush/shBrushXml.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/shbrush/shBrushJScript.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/shbrush/shBrushCss.js'></script>    
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/filetree/jqueryFileTree.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins/pagination/zebra_pagination.js'></script>    
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>plugins.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>charts.js'></script>
    <script type='text/javascript' src='<?php echo ADMIN_JS;?>actions.js'></script>
</head>
<body>
<div id="loading" style="position:absolute; width:100%; text-align:center; top:300px; z-index:100000;">
	<img src="<?php echo ADMIN_IMG;?>loaders/gif_3.gif">
</div>
<script>
	var ld=(document.all);
	var ns4=document.layers;
	var ns6=document.getElementById&&!document.all;
	var ie4=document.all;
	if (ns4)
		ld=document.loading;
	else if (ns6)
		ld=document.getElementById("loading").style;
	else if (ie4)
		ld=document.all.loading.style;
	
	function init()
	{
		if(ns4)
			ld.visibility="hidden";
		else if
			(ns6||ie4) ld.display="none";
	}
	$(window).load(function() {
		init();
	})
</script>  
<div class="modal2"></div>
<?php	
}
function topHeader()
{
?>
	<div class="header">
        <a href="<?php echo ADMIN_URL;?>index.php" class="logo"></a>
        
        <div class="btn-group" style="float:right; margin:20px 45px;">                                
           <button data-toggle="dropdown" class="btn btn-small dropdown-toggle"><span class="icon-user"></span> <?php echo $_SESSION['FullName'];?> <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li><a href="<?php echo ADMIN_URL;?>logout.php"><span class="icon-off"></span> Logout</a></li>
            </ul>
        </div>
    </div>
<?php 
}
function leftNavigation()
{
	$siteActive = '';
	$catalogActive = '';
	$commentActive = '';
	$onlineQryActive = '';
	$userActive = '';

	$siteArr = array(
	              'update_profile.php',
				  'changepassword.php'
					);
	$catalogArr = array(
				'view_computers.php'
				);
	$commentArr = array(
				'view_hardware_errors.php',
				'view_software_errors.php'
				);
	$onlineQryArr = array(
				'reports.php'
				);						
	$userArr = array(
				'add_user.php',
				'edit_user.php',
				'view_users.php',
				);
						
	$pageName = basename($_SERVER['PHP_SELF']);
	if ( in_array($pageName, $siteArr) )
	{
		$siteActive = 'class="active"';
	}
	if ( in_array($pageName, $catalogArr) )
	{
		$catalogActive = 'class="active"';
	}
	if ( in_array($pageName, $commentArr) )
	{
		$commentActive = 'class="active"';
	}
	if ( in_array($pageName, $userArr) )
	{
		$userActive = 'class="active"';
	}
	if ( in_array($pageName, $onlineQryArr) )
	{
		$onlineQryActive = 'class="active"';
	}
?>
<!--Load the navigation menu on the bases of user type and his permissions-->
	<!--Start: Admin Navigation-->
    <div class="navigation">

        <ul class="main">
            <li><a href="#site" <?php echo $siteActive;?>><span class="icon-sitemanager"></span><span class="text">Settings</span></a></li>
            <li><a href="#catalog" <?php echo $catalogActive;?>><span class="icon-catagoging"></span><span class="text">Resource Monitoring</span></a></li>
            <li><a href="#tender" <?php echo $commentActive;?>><span class="icon-tender"></span><span class="text">Errors Management</span></a></li>
            <li><a href="#onlineQry" <?php echo $onlineQryActive;?>><span class="icon-online-quries"></span><span class="text">Generate Reports</span></a></li>
        <?php
		if($_SESSION['type']=='1')
		{
		?>    
            <li><a href="#user" <?php echo $userActive;?>><span class="icon-users"></span><span class="text">User Management</span></a></li>
        <?php
		}
		?>    
        </ul>
        
        <div class="control"></div>        
        
        <div class="submain">
            
			<!--Start: Site-->
            <div id="site">                
                <div class="menu">                                      
                    <div class="widget-fluid">
                       <div class="head">Settings</div>
                    </div>
                    <a href="<?php echo ADMIN_URL;?>site_manager/update_profile.php"><span class="icon-user"></span> Update Profile</a>
                    <a href="<?php echo ADMIN_URL;?>site_manager/changepassword.php"><span class="icon-lock"></span> Change Password</a>
                	<div class="dr"><span></span></div>
                </div>
            </div> 
            <!--#site close-->
                
            <!--Start: Catalog-->
            <div id="catalog">                
                <div class="menu">    
                    <div class="widget-fluid">
                        <div class="head">Resource Management</div>
                    </div>
                    <a href="<?php echo ADMIN_URL;?>resource_manager/view_computers.php"><span class="icon-th"></span> Connnected Computers</a>
                	<div class="dr"><span></span></div>  
                </div>
            </div>
            <!--#catl close-->
			
            <div id="tender">                
                <div class="menu">
                    <div class="widget-fluid">
                        <div class="head">Errors Management</div>
                    </div>
                    <a href="<?php echo ADMIN_URL;?>errors_manager/view_hardware_errors.php"><span class="icon-th"></span> All Hardware Errors</a>
                    <a href="<?php echo ADMIN_URL;?>errors_manager/view_Software_errors.php"><span class="icon-th"></span> All Software Errors</a>
                	<div class="dr"><span></span></div>  
                                     
                </div>
            </div>
            <!--Start Online Query-->
			<div id="onlineQry">              
                <div class="menu">
                    <div class="widget-fluid">
                        <div class="head">Reports Management</div>
                    </div>
                    <a href="<?php echo ADMIN_URL;?>reports_manager/reports.php"><span class="icon-th"></span> Generate Reports</a>
                	<div class="dr"><span></span></div>
                </div>
            </div>
			<!--End Online Query-->
        <?php
		if($_SESSION['type']=='1')
		{
		?> 
            <!--Start User-->
			<div id="user">              
                <div class="menu">
                    <div class="widget-fluid">
                        <div class="head">User Management</div>
                    </div>
                    <a href="<?php echo ADMIN_URL;?>user_manager/add_user.php"><span class="icon-plus"></span> Add User</a>
                    <a href="<?php echo ADMIN_URL;?>user_manager/view_users.php"><span class="icon-th"></span> All Users</a>
                	<div class="dr"><span></span></div>
                </div>
            </div>
			<!--End User-->
        <?php
		}
		?>   
        </div>

    </div>
    <!--End: Admin Navigation-->
   <?php  
     // If its home page then don't show the breadcrumb
	if ( basename($_SERVER['PHP_SELF']) != 'index.php' )
	{				
	
	echo '<div class="breadCrumb clearfix" style="clear:both;">
				<ul id="breadcrumbs">';
				
	/*** a new breadcrumbs object ***/
	$bc = new breadcrumbs;
	/*** set the pointer if you like ***/
	$bc->setPointer('->');
	/*** create the trail ***/
	$bc->crumbs();
	/*** output ***/
	echo $bc->breadcrumbs.'<li>'.$GLOBALS['1'].'</li></ul></div>'; 
  	}
	?>  
	   
<?php
}
function footer()
{
?>
	<div class="footer">
        <div class="left">
            <div class="btn-group dropup">                
                <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="icon-cog"></span> Navigation</button>
                <ul class="dropdown-menu">
                    <li><a href="#" id="fixedNav">Fix Navigation</a></li>
                    <li><a href="#" id="collapsedNav">Collapsible Navigation</a></li>                    
                </ul>
            </div>
            <div class="btn-group dropup">                
                <button class="btn dropdown-toggle" data-toggle="dropdown">BG</button>
                <ul class="dropdown-menu" id="bgPreview">
                    <li class="bg_default"></li>
                    <li class="bg_mgrid"></li>
                    <li class="bg_crosshatch"></li>                    
                    <li class="bg_hatch"></li>
                    <li class="bg_yellow_hatch"></li>
                    <li class="bg_green_hatch"></li>
                </ul>
            </div>            
        </div>
        <script type="text/javascript">
        </script>
        <div class="right">
        <b><?php echo date("D, d M Y");?></b>
        </div>
    </div>
<?php
}
function endHtml()
{
?>    
</body>
</html>
<?php
}
?>