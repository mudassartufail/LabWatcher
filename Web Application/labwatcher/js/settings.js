$(function(){
	// Procurement Method
	$("#lookup_dialog").dialog({
		autoOpen: false, 
		modal: true,
		width: 400,
		buttons: {
			"Submit": function() {
				//$('form[name="lookupForm"]').submit();
				if ( $('#lookupType').val() == '' || $('#lookupItem').val() == '' )
				{
					$('form[name="lookupForm"]').submit();
					return false;
				}
				else
				{
					var dataString = $( this ).find('form').serialize();
					$.ajax({
						type: "POST",
						url: "includes/ajax/ajax.php",
						data: dataString
					}).done(function(data) {
						$("#lookup_dialog").dialog( "close" );
						location.reload();
					});
				}
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});

	$(".lookup_dialog_button").click(function(){
		// First check which button is clicked and then select the same value from the drop down
		$('#lookupType').val($(this).attr('id'));
		$("#lookup_dialog").dialog('open')
	});
	
	// 
})

// Edit Record
function editRecord(datastring)
{
	$.ajax({
		type: "POST",
		dataType: "JSON",
		url: "includes/ajax/ajax.php",
		data: 'editLookupItem='+datastring
	}).done(function(data) {
		var lookupItemId = data.id;
		var lookupItemTitle = data.value;
		
		//Assign new values to dialog
		$('#lookupItem').val(lookupItemTitle);
		$('#lookupType').val(lookupItemId);
		$('#lookupAction').val('edit');
		$('#lookupItmId').val(datastring);
		
		// Open the dialog
		$("#lookup_dialog").dialog('open');
	});
}

// Delete Record
function confirmBox(param)
{
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "#dialog-confirm" ).dialog({
		resizable: false,
		height:140,
		modal: true,
		buttons: {
			"Delete": function() {
				$( this ).dialog( "close" );
				$.ajax({
					type: "POST",
					url: "includes/ajax/ajax.php",
					data: 'delete='+param
				}).done(function(lookupItmId) {
					$("#dialog-confirm").dialog( "close" );
					$('#lookup'+lookupItmId).hide();
					$('#settings').before('<div class="alert alert-success" onclick="removeMsg(this)">Record has been successfully deleted.</div>');
				});
				//window.location = "planning_detail.php?agency="+"<?php echo $_REQUEST['agency'];?>"+"&year="+"<?php echo $_REQUEST['year'];?>"+"&do="+param;
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});	
}

// Remove delete notification message
function removeMsg(param)
{
	$(param).animate({opacity: 0},'200','linear',function(){
		$(param).remove();
	});
}