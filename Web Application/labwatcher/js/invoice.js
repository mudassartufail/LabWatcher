// JavaScript Document
var allcheck=0;
function check_all()
{
	if($("#checkAll").attr('checked'))
	{
		var checkBx = $(":checkbox");
		//alert(checkBx);
		var allCheck = checkBx.length;
		
		$.each(checkBx, function(){
				checkBx.attr('checked','checked');
			
			})
	}
	else
	{
		var checkBx = $(":checkbox");
		//alert(checkBx);
		var allCheck = checkBx.length;
		
		$.each(checkBx, function(){
				checkBx.removeAttr('checked');
			
			})
	}
}
function uncheckAll()
{
	$("#checkAll").removeAttr('checked')	
}

$(function(){
	
	$('#showSearch').click(function(e) {
		$('#myTable').toggle();
	});
	
})
function changeDisplay(id)
{
	id.style.display = "none";
}

$(function (){
	$( "#generateInvoice" ).submit(function() {
		var n = $( "input:checked" ).length;
		if(n >0)
		{
			//alert (n);
		}
		else
		{
			$("#inError").css("display","block");
			return false;
		}
		
	});	
});
	$(function(){
				
		// Show states for the selected country
		$("#country").change(function(){
			var countryId = $("#country").val();
			$.ajax({
				type: "POST",
				url: "../includes/ajax/catalog.php",
				data: {countryId : countryId}
			}).done(function( msg ) {
				$('#state').html(msg);
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
			});
		});
		
		// Date Picker
		$('.datePicker').datetimepicker({
			showTimepicker: false,
			dateFormat: 'yy-mm-dd',
			controlType: 'select',
			changeMonth: true,
			changeYear: true,
			yearRange: 'c-5:c+5'
		});
		// Show/Hide search form
		$('#showSearch').click(function(e) {
            $('#myTable').toggle();
        });
		
	});
	
	function validateEstCost(field, rules, i, options)
	{
		var minCost = parseFloat($('#minEstCost').val());
		var maxCost = parseFloat($('#maxEstCost').val());
		if ( minCost != '' && maxCost != '' )
		{
			if ( minCost > maxCost )
			{
				var alertText = 'Maximum estimated cost should be greater than the minimum estimated cost.';
				return alertText;
			}
		}
	}
	
	function validateDocCost(field, rules, i, options)
	{
		var minCost = parseFloat($('#minDocCost').val());
		var maxCost = parseFloat($('#maxDocCost').val());
		if ( minCost != '' && maxCost != '' )
		{
			if ( minCost > maxCost )
			{
				var alertText = 'Maximum document cost should be greater than the minimum document cost.';
				return alertText;
			}
		}
	}

$(function(){
	
	$("#invctendr").submit(function(){
			if($("#agency").val() != '')
			{
				
			}
			else
			{
				confirmBox();
				return false;
			}
		})
		
		
		
	})
	
	function confirmBox()
	{
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		$( "#dialog-confirm" ).dialog({
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
		});	
	}
