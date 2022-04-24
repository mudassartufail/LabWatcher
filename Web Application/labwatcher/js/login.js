//Start: Login form Animation
function loginBlock(block){
    
    $(".login:visible").animate({
        left: '30%',
        opacity: 0
    },'200','linear',function(){
        $(this).css('left','70%').css('display','none');
    });    
    $(block).css({opacity: 0, display: 'block',left: '70%'});
    fix_block_items_width('.input-prepend',['.add-on','button'],'input');
    $(block).find('.checker').show();
    $(block).animate({opacity: 1, left: '50%'},'200');
}

function fix_block_items_width(block,what,to)
{
/* Func for fix bootstrap prepended items(bootstrap)
 * by Aqvatarius for Virgo Premium admin template
 * */    
    $(block).each(function(){
        
        var iWidth = $(this).width();
        
        for(i=0; i < what.length; i++){
            $(this).find(what[i]).each(function(){
                iWidth -= $(this).width()+(parseInt($(this).css('padding-left')) * 2);
            });
        }
        $(this).find(to).width(iWidth-14);
        
    });    
    
}

$(function(){
	$("body").on({
		// When ajaxStart is fired, add 'loading' to body class
		ajaxStart: function() {
			$(this).addClass("loading");
			return false;
		},
		// When ajaxStop is fired, rmeove 'loading' from body class
		ajaxStop: function() {
			$(this).removeClass("loading");
		}    
	});
	
	/// Login Form validation
	$("#loginForm").validate({
		rules: {
			email: {
				required: true,
				email: true
			},
			password: "required"
		},
		messages: {
			email: {
				required: "Enter email.",
				email: "Invalid email address."
			},
			password: "Enter your password."
		},
		submitHandler: function(form) {
			$("font#err").remove();
			var myEmail = $('#email').val();
			var myPassword=$('#password').val();
			
			$.ajax({
				type: 'POST',
				url: 'includes/ajax/user.php',
				data: {'email': myEmail, 'password': myPassword},
				success: function(msg){
					if( msg == '1' )
					{
						window.location = 'index.php';
					}
					else
					{
						$("#loginForm").before('<font color="#B70000" id="err">Invalid email/password.</font>');
					}
				}
			});
			return false;
		}
	});
	
	
	// Forgot form validation
	$("#forgotForm").validate({
		rules: {
			forgetEmail: { 
				required: true,
				email: true
			}
		},
		messages: {
			forgetEmail: {
				required: "Enter your email.",
				email: "Invalid email."
			}
		},
		submitHandler: function(form) {
			$("font#forgotErr").remove();
			var dataString = $('#forgotForm').serialize();
			$.ajax({
				type: 'POST',
				url: 'includes/ajax/user.php',
				data: dataString,
				success: function(msg){
					$("#forgotForm").before(msg);
				}
			});
			return false;
		}
	});
	
	
	
});