<?php
include('../config/config.php');
include('../template/html.inc.php');
include('../includes/classes/class.user.php');
include('../includes/classes/class.pc.php');;

$objPc=new pc();
$objUser = new user();
$objUser->login();

startHtml('Computers Details');

if(isset($_REQUEST['do']))
{
	$pcName = $objUser->cleanString($_REQUEST['do']);
	$objPc->pcName=$pcName;
	$pcDetails=$objPc->getPcInfo();	
}
if($pcDetails)
{
	$i = 1;
?>

<script type="text/javascript" src="../js/plugins/highcharts/highcharts.js"></script>
<script type="text/javascript" src="../js/plugins/highcharts/modules/exporting.js"></script>
<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				var totalStorage=$("#totalstorage").text();
				var usedStorage=$("#usedstorage").text();
				
				var temp=usedStorage/totalStorage;
				var usedPercent=temp*100;
				var freePercent=100-usedPercent;
				
				var a=parseFloat(freePercent).toFixed(2);
				var b=parseFloat(usedPercent).toFixed(2);
				
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container',
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false
					},
					title: {
						text: 'Hard Disk Storage of Computer'
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								color: '#000000',
								connectorColor: '#000000',
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
								}
							}
						}
					},
				    series: [{
						type: 'pie',
						name: 'Hard Disk Storage',
						data: [
							['Free Space', parseInt(a)],
							['Used Space', parseInt(b)],
						]
					}]
				});
			});

$(function(){
	
	$(".drive").change(function()
	{
        
		if($(this).is(":checked"))
		{
            var val = $(this).val();
			var systemName=$("#pcName").val();
			$.ajax({
				type: 'POST',
				url: '../includes/ajax/ajax_calls.php',
				data: {'label': val,'systemName':systemName},
				dataType: 'json',
				success: function(msg)
				{
					if(msg)
					{
					  var totalSpace=msg.totalSpace;
					  var freeSpace=msg.freeSpace;
					  var usedSpace=totalSpace-freeSpace;
                      totalSpace=Math.floor(totalSpace/(1024*1024*1024));
					  usedSpace=Math.floor(usedSpace/(1024*1024*1024));
					  $("#hardInfo").hide();
					  $("#driveTotal").html(totalSpace);
					  $("#driveUsed").html(usedSpace);
					  $("#driveInfo").show();
					  
					  var temp=usedSpace/totalSpace;
					    var usedPercent=temp*100;
						var freePercent=100-usedPercent;
						
						var a=parseFloat(freePercent).toFixed(2);
						var b=parseFloat(usedPercent).toFixed(2);
						
						chart = new Highcharts.Chart({
							chart: {
								renderTo: 'driveContainer',
								plotBackgroundColor: null,
								plotBorderWidth: null,
								plotShadow: false
							},
							title: {
								text: val+' Drive Storage'
							},
							tooltip: {
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
								}
							},
							plotOptions: {
								pie: {
									allowPointSelect: true,
									cursor: 'pointer',
									dataLabels: {
										enabled: true,
										color: '#000000',
										connectorColor: '#000000',
										formatter: function() {
											return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
										}
									}
								}
							},
							series: [{
								type: 'pie',
								name: val+' Drive Storage',
								data: [
									['Free Space', parseInt(a)],
									['Used Space', parseInt(b)],
								]
							}]
						});
					  
					  
					}
					else
					{
						$("#hardInfo").show();
						$("#driveInfo").hide();
					}
				}
			});
			
        }
		
    });

});					
</script>
         
    <div class="widget">
        <div class="head">
            <div class="icon"><i class="icosg-clipboard1"></i></div>
            <h2>Hardware Status</h2>
        </div>  
        <div class="block-fluid tabbable">                    
            <ul class="nav nav-tabs">
            <?php
			$i = 1;
			$class = ( $i == '1' )? "active": ""; 
			?>
             <li class="<?php echo $class;?>"><a data-toggle="tab" href="#tab<?php echo $i;?>">Hard Disk</a></li>
             <?php $i++; $class = ( $i == '1' )? "active": "";?>
             <li class="<?php echo $class;?>"><a data-toggle="tab" href="#tab<?php echo $i;?>">Keyboard</a></li>
             <?php $i++; $class = ( $i == '1' )? "active": "";?>
             <li class="<?php echo $class;?>"><a data-toggle="tab" href="#tab<?php echo $i;?>">Mouse</a></li>
             <?php $i++; $class = ( $i == '1' )? "active": "";?>
             <li class="<?php echo $class;?>"><a data-toggle="tab" href="#tab<?php echo $i;?>">Monitor</a></li>
             <?php $i++; $class = ( $i == '1' )? "active": "";?>
             <li class="<?php echo $class;?>"><a data-toggle="tab" href="#tab<?php echo $i;?>">Processor</a></li>
             <?php $i++; $class = ( $i == '1' )? "active": "";?>
             <li class="<?php echo $class;?>"><a data-toggle="tab" href="#tab<?php echo $i;?>">RAM</a></li>
             <?php $i++; $class = ( $i == '1' )? "active": "";?>
            </ul>
            
            <div class="tab-content">
            <?php
            $i = 1;
			$class = ( $i == '1' )? "tab-pane active": "tab-pane"; 
            ?>
             <div id="tab<?php echo $i;?>" class="<?php echo $class;?>">
					<?php
                    $objPc->pcName = $pcDetails[0]->systemName;	
                    $statuses=$objPc->getDeviceStatus();
                    if($statuses[0]->hardDiskStatus)
                    {
						$diskString=$statuses[0]->hardDiskUsage;
						$diskArray=array();
						$totalSpace=array();
						$freeSpace=array();
						$driveLable=array();
						$tempArr=array();
						$diskArray=explode("|",$diskString);
						$count=sizeof($diskArray);
						$temp=0;
						
						for($a=0;$a<$count-1;$a++)
						{
							$tempArr=explode(' ',$diskArray[$a]);
							$driveLable[$a]=$tempArr[0];
							$totalSpace[$tempArr[0]]=$tempArr[1];
							$freeSpace[$tempArr[0]]=$tempArr[2];
						}
						
						$freeStorage=0;
						foreach($freeSpace as $space=>$key)
						{
							$freeStorage+=$key;
						}
						
						$freeStorage=($freeStorage/(1024*1024*1024));
					    $totalStorage=$statuses[0]->hardDiskInfo;
						$usedStorage=$totalStorage-$freeStorage;
                     ?>
                     &nbsp;&nbsp;<span style="font-weight:bold">Overall:</span>&nbsp;&nbsp;<input type="radio" name="drive" value="all" class="drive" style="margin-top:0" checked="checked"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     <?php
					 foreach($driveLable as $label=>$key)
					 {
						 ?>
                         <span style="font-weight:bold"><?php echo $key." Drive";?></span>&nbsp;&nbsp;<input type="radio" name="drive" class="drive" value="<?php echo $key;?>" style="margin-top:0"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <?php
					 }
					 ?>
                     <hr/>
                     <input type="hidden" name="pcName" id="pcName" value="<?php echo $pcDetails[0]->systemName;?>"/>
                     <span id="hardInfo">   
                        <ul>
                            <li><?php echo "<b>Hard Disk Status:</b> ".$statuses[0]->hardDiskStatus;?></li>
                            <li><b>Total Storage:</b> <span id="totalstorage"><?php echo $statuses[0]->hardDiskInfo;?></span> GB</li>
                            <li><b>Used Storage Space:</b> <span id="usedstorage"><?php echo ceil($usedStorage);?></span> GB</li>
                        </ul>
                        <div id="container" style="width: 550px; height: 210px; margin: 0 auto"></div>
                     </span>
                     <span id="driveInfo" style="display:none;">
                        <ul>
                            <li><?php echo "<b>Hard Disk Status:</b> ".$statuses[0]->hardDiskStatus;?></li>
                            <li><b>Total Storage:</b> <span id="driveTotal"></span> GB</li>
                            <li><b>Used Storage Space:</b> <span id="driveUsed"></span> GB</li>
                        </ul>
                        <div id="driveContainer" style="width: 550px; height: 210px; margin: 0 auto"></div>
                     </span>
                         
                        <?php
                    }
                    else
                    {
                        ?>
                        Status Not Found!
                        <?php
                    }
                    ?> 
                </div>
                <?php
				$i++;
				$class = ( $i == '1' )? "tab-pane active": "tab-pane"; 
                ?>
                 <div id="tab<?php echo $i;?>" class="<?php echo $class;?>">
                      <p>
                        <?php
                        if($statuses[0]->keyboardStatus)
                        {
                         ?>
                            <ul>
                                <li><?php echo "Keyboard Status: ".$statuses[0]->keyboardStatus;?></li>
                            </ul>
                            <?php
                        }
                        else
                        {
                            ?>
                            Status Not Found!
                            <?php
                        }
                        ?>
                       </p>
                    </div>
                    <?php
                    $i++;
					$class = ( $i == '1' )? "tab-pane active": "tab-pane"; 
                ?>
                 <div id="tab<?php echo $i;?>" class="<?php echo $class;?>">
                      <p>
                        <?php
                        if($statuses[0]->mouseStatus)
                        {
                         ?>
                            <ul>
                                <li><?php echo "Mouse Status: ".$statuses[0]->mouseStatus;?></li>
                            </ul>
                            <?php
                        }
                        else
                        {
                            ?>
                            Status Not Found!
                            <?php
                        }
                        ?>
                       </p>
                    </div>
                    <?php
                    $i++;
					$class = ( $i == '1' )? "tab-pane active": "tab-pane"; 
                ?>
                 <div id="tab<?php echo $i;?>" class="<?php echo $class;?>">
                      <p>
                        <?php
                        if($statuses[0]->monitorStatus)
                        {
                         ?>
                            <ul>
                                <li><?php echo "Monitor Status: ".$statuses[0]->monitorStatus;?></li>
                            </ul>
                            <?php
                        }
                        else
                        {
                            ?>
                            Status Not Found!
                            <?php
                        }
                        ?>
                       </p>
                    </div>
                    <?php
                    $i++;
					$class = ( $i == '1' )? "tab-pane active": "tab-pane"; 
                ?>
                 <div id="tab<?php echo $i;?>" class="<?php echo $class;?>">
                      <p>
                        <?php
                        if($statuses[0]->processorStatus)
                        {
                         ?>
                            <ul>
                                <li><?php echo "Processor Status: ".$statuses[0]->processorStatus;?></li>
                            </ul>
                            <?php
                        }
                        else
                        {
                            ?>
                            Status Not Found!
                            <?php
                        }
                        ?>
                       </p>
                    </div>
                    <?php
                    $i++;
					$class = ( $i == '1' )? "tab-pane active": "tab-pane"; 
                ?>
                 <div id="tab<?php echo $i;?>" class="<?php echo $class;?>">
                      <p>
                        <?php
                        if($statuses[0]->ramStatus)
                        {
                         ?>
                            <ul>
                                <li><?php echo "RAM Status: ".$statuses[0]->ramStatus;?></li>
                            </ul>
                            <?php
                        }
                        else
                        {
                            ?>
                            Status Not Found!
                            <?php
                        }
                        ?>
                       </p>
                    </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<style>
.widget
{
	background: none repeat scroll 0 0 white;
    border: 1px solid #CCCCCC;
    border-radius: 9px 9px 9px 9px;
    margin-bottom: 10px;
    margin-left: 7px;
	overflow:hidden;
    margin-top: 5px;
    position: relative;
    width: 98%;
}
.tabbable:before, .tabbable:after
{
	min-height: 10px;
	
}
</style>