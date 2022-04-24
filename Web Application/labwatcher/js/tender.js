// JavaScript Document

// display and enable the  # title
function unplannedProName()
{
	$("#procureName").css('display', 'inline');
	$("#procureName").removeAttr('disabled');
	$("#procureList").attr('disabled','disabled')
	$("#procureList").css('display', 'none');
	$("#estimatedCost").removeAttr('readonly');
	$("#estimatedCost").val('');
	$("#planningDate").html('');
}
// display and enable the  # procureList
function plannedProName()
{
	$("#procureList").css('display', 'inline');
	$("#procureList").removeAttr('disabled');
	$("#procureName").attr('disabled','disabled');
	$("#procureName").css('display', 'none');
	planningEstimatedCost();
	
}

function planningEstimatedCost()
{
	var planningId = $("#plannedTitle").val();
	if(planningId != '')
	{
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "../includes/ajax/tender.php",
			data: {planningId : planningId}
		}).done(function( data ) {
			$.each(data,function()
			{
				$("#estimatedCost").val(data[0].cost);
				$("#estimatedCost").attr('readonly','readonly');
				if(data[0].pDate != "")
				{
					var notic = "<div class='alert alert-success'>"+            
								"Your selected Procurement Planning has Tentative Date Of Procurement Notice/RFQ: "+
								data[0].pDate +
								"</div>";
					$("#planningDate").html(notic);
				}
				else
				{
					$("#planningDate").html('');
				}
				
			})
			
		});
	}
	else
	{
		$("#estimatedCost").val('');
		$("#planningDate").html('');
	}
}
 
// date difference Notification
function dateDifferenceNotificationEdit()
{
	var nature = $("#nature").val();
	var adDate = $("#advertiseDate").datepicker('getDate');
	var closeDate = $("#closingDate").datepicker('getDate');
	if( nature != '' && adDate != null && closeDate !=null )
	{
		dayDiff =  Math.abs( Math.floor((closeDate.getTime() - adDate.getTime()) / (1000*60*60*24)) );
		
		if( nature == 'National' && dayDiff < 15 )
		{
			$("#national").css("display", "block");
			$("#national").fadeOut(10000);
		}
		if ( nature == 'International' && dayDiff < 30 )
		{
			$("#international").css("display", "block");
			$("#international").fadeOut(10000);
		}
	}
}
// date difference Notification
function dateDifferenceNotificationExt()
{
	var nature = $("#nature").val();
	var adDate = $("#advertiseDateExt").datepicker('getDate');
	var closeDate = $("#closingDateEXT").datepicker('getDate');
	if( nature != '' && adDate != null && closeDate !=null )
	{
		dayDiff =  Math.abs( Math.floor((closeDate.getTime() - adDate.getTime()) / (1000*60*60*24)) );
		
		if( nature == 'National' && dayDiff < 15 )
		{
			$("#national").css("display", "block");
			$("#national").fadeOut(10000);
		}
		if ( nature == 'International' && dayDiff < 30 )
		{
			$("#internationalExt").css("display", "block");
			$("#internationalExt").fadeOut(10000);
		}
	}
}
	
$(function() {
	var startDateTextBox = $('.advertiseDate');
	var endDateTextBox = $('.closingDate');
	
	startDateTextBox.datetimepicker({
		showTimepicker: false,
		dateFormat: 'yy-mm-dd',
		controlType: 'select',
		changeMonth: true,
		changeYear: true,
		yearRange: 'c:c+5',
		onClose: function(dateText, inst) {
			if (endDateTextBox.val() != '') {
				var testStartDate = startDateTextBox.datetimepicker('getDate');
				var testEndDate = endDateTextBox.datetimepicker('getDate');
				if (testStartDate > testEndDate)
					endDateTextBox.datetimepicker('setDate', testStartDate);
			}
			else {
				endDateTextBox.val(dateText);
			}
		},
		onSelect: function (selectedDateTime){
			endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
		}
	});
	endDateTextBox.datetimepicker({
		showTimepicker: false,
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		controlType: 'select',
		onClose: function(dateText, inst) {
			if (startDateTextBox.val() != '') {
				var testStartDate = startDateTextBox.datetimepicker('getDate');
				var testEndDate = endDateTextBox.datetimepicker('getDate');
				if (testStartDate > testEndDate)
					startDateTextBox.datetimepicker('setDate', testEndDate);
			}
			else {
				startDateTextBox.val(dateText);
			}
		},
		onSelect: function (selectedDateTime){
			startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
		}
	});
});	
	
// date difference Notification
//function dateDifferenceNotification()
//{
//	
//	var nature = $("#nature").val();
//	
//	if ( nature == '' )
//	{
//		$("#tNature").css("display", "block");
//		$("#tNature").fadeOut(5000, function(){
//			$("#closingDate").val("");
//			});
//		
//		return false;
//	}
//	
//	var adDate = $("#advertiseDate").datepicker('getDate');
//	var closeDate = $("#closingDate").datepicker('getDate');
//	//alert (adDate);
//	if(adDate != null )
//	{
//		dayDiff =  Math.abs( Math.floor((closeDate.getTime() - adDate.getTime()) / (1000*60*60*24)) );
//	}
//	else
//	{
//		
//		$("#adDate").css("display", "block");
//		$("#adDate").fadeOut(12000, function(){
//			$("#closingDate").val("");
//			});
//		return false;
//		
//	}
//
//	if( nature == 'National' && dayDiff < 15 )
//	{
//		$("#national").css("display", "block");
//		$("#national").fadeOut(10000);
//	}
//	if ( nature == 'International' && dayDiff < 30 )
//	{
//		$("#international").css("display", "block");
//		$("#international").fadeOut(10000);
//	}
//}
//




// display and enable the  #plannedTitle and populate the Procurements name on the bases of pre selected Agency and Sector
function plannedProNameEdit()
{
	$("#procureList").css('display', 'inline');
	$("#plannedTitle").removeAttr('disabled');
	$("#procureName").attr('disabled','disabled');
	$("#procureName").css('display', 'none');
	
	
	var agencyId = $("#agency").val();
	var sectorId = $("#sector").val();
	if(sectorId != '' &&  agencyId != '')
	{
			$.ajax({
				type: "POST",
				url: "../includes/ajax/tender.php",
				data: {agencyId : agencyId, sectorId : sectorId}
			}).done(function( data ) {
				$("#radioPlanned").attr('checked','checked');
				$("#procureList").removeAttr('disabled');
				$("#procureList").css('display', 'inline');
				$('#plannedTitle').html(data);
			});
		}
	if(sectorId == '' &&  agencyId != '')
	{
			$.ajax({
				type: "POST",
				url: "../includes/ajax/tender.php",
				data: {onlyAgencyId : agencyId}
			}).done(function( data ) {
				$("#radioPlanned").attr('checked','checked');
				$("#procureList").removeAttr('disabled');
				$("#procureList").css('display', 'inline');
				$('#plannedTitle').html(data);
			});
		}
	if(sectorId != '' &&  agencyId == '')
	{
			$.ajax({
				type: "POST",
				url: "../includes/ajax/tender.php",
				data: {onlySectorId : sectorId}
			}).done(function( data ) {
				$("#procureList").removeAttr('disabled');
				$("#procureList").css('display', 'inline');
				$('#plannedTitle').html(data);
			});
		}
	
}

// populate the Procurements name on the bases of pre selected Agency and Sector
function agencyPlannings()
{
	var agencyId = $("#agency").val();
	var sectorId = $("#sector").val();
	if(agencyId != '')
	{
		if(sectorId != '')
		{
			$.ajax({
				type: "POST",
				url: "../includes/ajax/tender.php",
				data: {agencyId : agencyId, sectorId : sectorId}
			}).done(function( data ) {
				$("#radioPlanned").attr('checked','checked');
				$("#procureList").removeAttr('disabled');
				$("#procureList").css('display', 'inline');
				$('#plannedTitle').html(data);
			});
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "../includes/ajax/tender.php",
				data: {onlyAgencyId : agencyId}
			}).done(function( data ) {
				$("#radioPlanned").attr('checked','checked');
				$("#procureList").removeAttr('disabled');
				$("#procureList").css('display', 'inline');
				$('#plannedTitle').html(data);
			});
		}
	}
	
}

// populate the Procurements name on the bases of pre selected Agency and Sector
function sectorPlannings()
{
	var agencyId = $("#agency").val();
	var sectorId = $("#sector").val();
	if(sectorId != '')
	{
		if(agencyId != '')
		{
			$.ajax({
				type: "POST",
				url: "../includes/ajax/tender.php",
				data: {agencyId : agencyId, sectorId : sectorId}
			}).done(function( data ) {
				$("#procureList").removeAttr('disabled');
				$("#procureList").css('display', 'inline');
				$('#plannedTitle').html(data);
			});
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "../includes/ajax/tender.php",
				data: {onlySectorId : sectorId}
			}).done(function( data ) {
				$("#procureList").removeAttr('disabled');
				$("#procureList").css('display', 'inline');
				$('#plannedTitle').html(data);
			});
		}
	}
}




// check estimated cost for Tender that is greater than 100000
function estimatedCostCheck(field, rules, i, options)
{
	hi = $("#procurementMethod").val();
	//return false;
	if(hi == 1)
	{
		if ( field.val() < 100000)
		{
			var alertText = '*For tedner estimated cost should be at least 100,000';
			return alertText;
		}
	}
}
$(function(){
	$(document).on('click', '#addRow', function(){
		
		var html = '<div class="row-form addedfile">'+
						'<div class="span2 TAR">&nbsp;</div>'+
						'<div class="span3">'+
							'<input type="file" name="attachFile[]" id="atch_file" />'+
						'</div>'+
						'<div class="span7">'+
							'<span id="remove">'+
								'<span class="icon-remove" style="vertical-align: text-bottom;"></span>'+
								 'Remove'+
							 '</span>'+
						'</div>'+
					'</div>';
		var thisDiv = $(".fileUpload").append();
		thisDiv.append(html);
		
	});
	
	// Delete a row
	$(document).on('click', '#remove', function(){
		var thisDiv = $(this).parent().parent().remove();
		thisDiv.remove();
	});
	// Replace the planned procurement names to simple name
	$(document).on('click', '#remove', function(){
		//var thisDiv = $(this).parent().parent().remove();
//			thisDiv.remove();
	});
	
	
	// Show states for the selected country
	$("#country").change(function(){
		var countryId = $("#country").val();
		$.ajax({
			type: "POST",
			url: "../includes/ajax/catalog.php",
			data: {countryId : countryId}
		}).done(function( msg ) {
			$('#state').html(msg);
			$('#state').trigger('change');
		});
	});
	// Show Cities for the selected state
	$("#state").change(function(){
		var stateId = $("#state").val();
		$.ajax({
			type: "POST",
			url: "../includes/ajax/catalog.php",
			data: {stateId : stateId}
		}).done(function( data ) {
			$("#city").html(data);
			$('#city').trigger('change');
		});
	});
	
	// Date Picker
	$('.datePicker').datetimepicker({
		showTimepicker: false,
		dateFormat: 'yy-mm-dd',
		controlType: 'select',
		changeMonth: true,
		changeYear: true,
		yearRange: 'c:c+10'
	});
	
	// Date Picker for edit tender
	$('.datePickerEdit').datetimepicker({
		showTimepicker: false,
		dateFormat: 'yy-mm-dd',
		controlType: 'select',
		changeMonth: true,
		changeYear: true,
		minDate: 'w',
		yearRange: 'c:c+10'
	});
	// Time Picker
	$('.timePicker').timepicker({
		showDatepicker: false,
		controlType: 'select',
		timeFormat: 'HH:mm:ss',
	});
});
	// check advertisement date and closing date interval 
function dateInterval(field, rules, i, options)
{
	var nature = $("#nature").val();
	if ( nature == '' )
	{
		alertText = '*Select tender nature.';
	}
	
	var dayDiff, alertText;
	
	var addDate = $('#advertiseDate').datepicker('getDate');
	var closeDate = $('#closingDate').datepicker('getDate');
	
	
	if ( addDate &&  closeDate )
	{
		// Get the date difference in days
		dayDiff =  Math.abs( Math.floor((closeDate.getTime() - addDate.getTime()) / (1000*60*60*24)) );

		if( nature == 'National' && dayDiff != 15 )
		{
			alertText = '*Closing date should be 15 days after advertisement date.';
		}
		if ( nature == 'International' && dayDiff != 30 )
		{
			alertText = '*Closing date should be 30 days after advertisement date.';
		}
		return alertText;
	}
}
	//  Notification for user to select clossing time  30 minit greater than opening time.
function closingTimeNotification()
{
	var timeDiff, alertText;
	
	var openTime = $('#openingTime').datepicker('getDate');
	var closeTime = $('#closingTime').datepicker('getDate');
	
	if ( openTime &&  closeTime )
	{
		// Get time difference in minutes
		timeDiff = Math.abs( Math.floor((openTime.getTime() - closeTime.getTime()) / (1000*60)) );
		if( timeDiff < 30 )
		{
			$("#cTimeNot").css("display", "block");
			$("#cTimeNot").fadeOut(10000);
		}
		else
		{
			$("#cTimeNot").css("display", "none");
		}
	}
}
	
	// check closing time interval with opening time
function timeInterval(field, rules, i, options)
{
	var timeDiff, alertText;
	
	var openTime = $('#openingTime').datepicker('getDate');
	var closeTime = $('#closingTime').datepicker('getDate');
	
	if ( openTime &&  closeTime )
	{
		timeDiff = Math.abs( Math.floor((openTime.getTime() - closeTime.getTime()) / (1000*60)) );
		if( timeDiff < 5 )
		{
			alertText = '*Closing time must be greater than 5 minutes after the opening time.';
		}
		return alertText;
	}
}
var tenderNumMsg;    
// Validate the tender number
function validateTenderNum(field, rules, i, options)  
{
	var tenderNum = field.val();
	if ( tenderNum != '' )
	{
		$.ajax({
			type: "POST",
			url: "../includes/ajax/tender.php",
			data: {tenderNum : tenderNum}
		}).done(function( msg ) {
			if (msg)
			{
				tenderNumMsg = '*This tender number already exists.';
			}
		});
	}
	return tenderNumMsg;
}

// Validate the Edited tender number
function validateEditedTenderNum(field, rules, i, options)  
{
	var tenderNum = field.val();
	var hiddenTenderNum = $("#hiddenTenderNum").val();
	if ( tenderNum != '' )
	{
		if(tenderNum != hiddenTenderNum)
		{
			$.ajax({
				type: "POST",
				url: "../includes/ajax/tender.php",
				data: {tenderNum : tenderNum}
			}).done(function( msg ) {
				if (msg)
				{
					tenderNumMsg = '*This tender number already exists.';
				}
			});
		}
	}
	return tenderNumMsg;
}

// To delete file from database and physical location.
function deleteFile(id)
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
					url: "../includes/ajax/planning.php",
					data: {fileId : id}
				}).done(function( data ) {
					var thisDiv = $("#"+id).parent().parent().remove();
					thisDiv.remove();
				});
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});	
}

// show and Hide editable feilds W.R.T.  Selected EditOption.
function showEditOptions()
{
	
	$(".addedfile").remove();
	var editOption = $("#updateOption").val();
	if(editOption == '')
	{
		$(".corrigendum").hide();
		$(".amendments").hide();
		$(".extension").hide();
		$(".canceled").hide();
	}
	if(editOption == '18')
	{
		$(".corrigendum").show();
		$(".amendments").hide();
		$(".extension").hide();
		$(".canceled").hide();
	}
	if(editOption == '19')
	{
		
		$(".corrigendum").hide();
		$(".amendments").show();
		$(".extension").hide();
		$(".canceled").hide();
		
	}
	if(editOption == '20')
	{
		$(".corrigendum").hide();
		$(".amendments").hide();
		$(".extension").show();
		$(".canceled").hide();
	}
	if(editOption == '21')
	{
		$(".corrigendum").hide();
		$(".amendments").hide();
		$(".extension").hide();
		$(".canceled").show();
	}

}