// JavaScript Document

$(function (){
	
	$(".above").hide();
	$(".below").hide();
	// Date Picker
	$('.datePicker').datetimepicker({
		showTimepicker: false,
		dateFormat: 'yy-mm-dd',
		controlType: 'select',
		changeMonth: true,
		changeYear: true,
	});
	
	$(document).on('click', '#addRow', function(){
		
	var html = '<tr>'+
					'<td>'+
						'<input type="text" name="bidderName[]" id="bidderName" class="validate[required]" style="width:151px"/>'+
					'</td>'+
					'<td>'+
						'<input type="text" name="technical[]" id="technical" style="width:120px"/>'+
					'</td>'+
					'<td>'+
						'<input type="text" name="financial[]" id="financial" style="width:120px"/>'+
					'</td>'+
					'<td>'+
						'<div class="input-append">'+
							'<input type="text" name="evaluatedCost[]" id="evaluatedCost" class="validate[required,custom[number]]"  style="text-align:right; width:110px !important" />'+
							'<span class="add-on"><i>Rs</i></span>'+
						'</div>'+
					'</td>'+
					'<td>'+
						'<input type="text" name="rules[]" id="rules" class="validate[required]" style="width:330px"/>'+
					'</td>'+
					'<td>'+
						'<div class="span12">'+
							'<span id="remove">'+
								'<span class="icon-remove" style="vertical-align: text-bottom;"></span>'+
								 'Remove'+
							 '</span>'+
						'</div>'+
					'</td>'+
				'</tr>';
		var thisDiv = $("#belowFiftyM").append(html);
		//thisDiv.append(html);
		
	});
	
	// Delete a row
	$(document).on('click', '#remove', function(){
		var thisDiv = $(this).parent().parent().parent().remove();
		thisDiv.remove();
	});
	
	
	// call this function for edit case;
	evaluationReportOption();
	tenderDetailInfo();
})






//show detail against pprawebsite advertisement
function integriryPact(id)
{
	
	var integriryPact = id.value;
	if(integriryPact == 1)
	{
		$(".integrityPactYes").show();
		
	}
	else
	{
		$(".integrityPactYes").hide();
	}
}

//show detail against pprawebsite advertisement
function advertisementPpra(id)
{
	
	var advertismentPapra = id.value;
	if(advertismentPapra == 1)
	{
		$(".ppraWebsiteYes").show();
		
	}
	else
	{
		$(".ppraWebsiteYes").hide();
	}
}
//show detail against news advertisement
function advertisementNews(id)
{
	
	var advertismentNews = id.value;
	if(advertismentNews == 1)
	{
		$(".newsPaper").show();
		
	}
	else
	{
		$(".newsPaper").hide();
	}
}
//show input File  against qualification criteria 
function qualificationFile(id)
{
	
	var qualificationcriteria = id.value;
	if(qualificationcriteria == 1)
	{
		$(".qualificationFile").show();
		
	}
	else
	{
		$(".qualificationFile").hide();
	}
}

//show input against Evaluation criteria 
function evaluationDetail(id)
{
	
	var evaluation = id.value;
	if(evaluation == 1)
	{
		$(".evaluation").show();
		
	}
	else
	{
		$(".evaluation").hide();
	}
}
//show input   against other Procurement methods
function otherMethod(id)
{
	
	var proMethod = id.value;
	if(proMethod == 'other')
	{
		$(".procurementMethod").show();
		
	}
	else
	{
		$(".procurementMethod").hide();
	}
}
//show input   against Evaluation Report
function evaluationReport(id)
{
	
	var evaluation = id.value;
	if(evaluation == 1)
	{
		$(".bidEvaluatioRAllBidder").show();
		
	}
	else
	{
		$(".bidEvaluatioRAllBidder").hide();
	}
}
//show input   against complaint deatil.
function complaintDeatil(id)
{
	
	var complaint = id.value;
	if(complaint == 1)
	{
		$(".complaintReceived").show();
		
	}
	else
	{
		$(".complaintReceived").hide();
	}
}
//show input   against deviation deatil.
function deviationDetailShow(id)
{
	
	var deviation = id.value;
	if(deviation == 1)
	{
		$(".deviationSpecification").show();
		
	}
	else
	{
		$(".deviationSpecification").hide();
	}
}

//show input   against deviation deatil.
function deviationQualiShow(id)
{
	
	var deviation = id.value;
	if(deviation == 1)
	{
		$(".deviationQualification").show();
		
	}
	else
	{
		$(".deviationQualification").hide();
	}
}
// Get Tender detail information against tender number.
function tenderDetailInfo(id)
{
	var tenderNumber;
	if(id)
	{
		tenderNumber = id.value;
	}
	else
	{
		tenderNumber = $("#tenderNum").val();
	}
	if(tenderNumber != '')
	{
		$.ajax({
				type: "POST",
				url: "../includes/ajax/evaluation.php",
				dataType: "json",
				data: {tenderNumber : tenderNumber}
			}).done(function( data ) {
				if(data == 'not')
				{
					id.value= '';
				}
				else
				{
					obj = eval(data);
					//alert(Object.keys(obj).length);
					tenderId = obj.tenderId;
					$("#tenderId").val(obj.tenderId);
					$("#tenderValue").val(obj.tenderValue);
					$("#estimatedValue").val(obj.estValue);
					$("#openingDateTime").val(obj.openTime);
					$("#closingDateTime").val(obj.closeTime);
					nature = obj.Nature;
					nature = "<option id='ntu' value='"+nature+"'>"+nature+"</option>";
					$("#tenderNature").html(nature);
					
					//$('#tenderNature').val(nature);
   					$('#tenderNature').change();
					
					$("#tenderNature").html(nature);
					PlanningId = obj.PlanningId;
					if(PlanningId == 0)
					{
						$("#annualProcurementPlanNo").attr('checked','checked');
						$("#annualProcurementPlanYes").attr('disabled','disabled');	
					}
					else
					{
						$("#annualProcurementPlanYes").attr('checked','checked');
						$("#annualProcurementPlanNo").attr('disabled','disabled');
						
						proMethod = "<option value='"+obj.proMethod+"'>"+obj.proValue+"</option>";
						$("#procurementMethod").html(proMethod);
						
					}
					if(obj.extension == '20')
					{
						$("#extDueDateYes").attr('checked','checked');
						$("#extDueDateNo").attr('disabled','disabled');
						$(".extension").show();
					}
					else
					{
						$("#extDueDateNo").attr('checked','checked');
						$("#extDueDateYes").attr('disabled','disabled');
						$(".extension").hide();
					}
				}
				
			});
	}
	else 
	{
		$("#annualProcurementPlanNo").removeAttr('disabled');
		$("#annualProcurementPlanYes").removeAttr('disabled');
		
		$("#annualProcurementPlanNo").removeAttr('checked');
		$("#annualProcurementPlanYes").removeAttr('checked');
		
		$("#extDueDateYes").removeAttr('disabled');
		$("#extDueDateNo").removeAttr('disabled');
		
		$("#extDueDateYes").removeAttr('checked');
		$("#extDueDateNo").removeAttr('checked');
		$(".extension").hide();
		
		$("#tenderId").val('');
		$("#tenderValue").val('');
		$("#estimatedValue").val('');
		$("#openingDateTime").val('');
		$("#closingDateTime").val('');
		
		nature = "<option value='National'>National</option>"+
				"<option value='International'>International</option>";
		$("#tenderNature").html(nature);
		
		
	}
}
// show and hid form feild  WRT Selected evaluation Report option.
function evaluationReportOption(id)
{
	
	var evRepOptn;
	if(id)
	{
		evRepOptn = id.value;
	}
	else
	{
		evRepOptn = $("#evaluationRepOption").val();
	}
	if(evRepOptn != '')
	{
		$.ajax({
			type: "POST",
			url: "../includes/ajax/evaluation.php",
			data: {evRepOptn : evRepOptn}
		}).done(function( data ) {
			if(typeof(teseNumber) != "undefined")
			{
				var cnt = '<option value="'+teseNumber+'" selected=selected>'+teseNumber+'</option>';
				data = data + cnt;
			}
			$('#tenderNum').html(data);
		})
		
		if(evRepOptn == '25')
		{
			$(".above").hide();
			$(".below").show();
			$(".more").hide();
			//$("#validate").reset();
		}
		else
		{
			if(evRepOptn == '27')
			{
				
				$(".below").hide();
				$(".above").show();
				$(".more").show();
				$("#bdrep, #bdrept").show();
				$("#bdrep").removeClass('bidEvaluatioRAllBidder')
				$("#bdrept").removeClass('bidEvaluatioRAllBidder')
				$(".evaluation").hide();
				$(".procurementMethod ").hide();
				//$("#bdrep").css('display', 'Block !important');
				// = "Block !important";
				//$("#bdrep").
				
			}
			else
			{
				$(".below").hide();
				$(".above").show();
				$(".more").hide();
				$("#bdrep").addClass('bidEvaluatioRAllBidder')
				$("#bdrept").addClass('bidEvaluatioRAllBidder')
				$(".evaluation").hide();
				$(".procurementMethod ").hide();
			}
		}

	}
	else
	{
		$(".above").hide();
		$(".below").hide();
	}
} 




