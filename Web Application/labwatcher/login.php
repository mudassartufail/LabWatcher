<?php
session_start();
if ( !empty($_SESSION['email']) )
{
	header('Location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />    
    <title>Lab Watcher :: Staff Login</title>
    <link href="css/stylesheets.css" rel="stylesheet" type="text/css" />      
    <!--[if lt IE 10]>
        <link href="css/ie.css" rel="stylesheet" type="text/css" />
    <![endif]-->      
    <link rel="icon" type="image/ico" href="favicon.ico"/>
    <script type='text/javascript' src='js/plugins/jquery/jquery-1.8.3.min.js'></script>
    <script type='text/javascript' src='js/plugins/bootstrap/bootstrap.min.js'></script>
    <script type='text/javascript' src='js/plugins/cookies/jquery.cookies.2.2.0.min.js'></script>
    <script type='text/javascript' src='js/plugins/validationEngine/jquery.validate.js'></script>
    <script type='text/javascript' src='js/login.js'></script>
    
    
	<style>
	.modal {
		display:    none;
	    position:   fixed;
	    z-index:    10000;
	    top:       	0;
	    left:       50%;
	    height:     250px;
	    width:      320px;
		margin-left: -160px;
		margin-top: 200px;
	    background: rgba( 255, 255, 255, .8 )
	                url('img/loaders/2d_2.gif')
	                50% 50%
	                no-repeat;
	}
	/* When the body has the loading class, we turn
	   the scrollbar off with overflow:hidden */
	body.loading {
		overflow: hidden;
	}
	/* Anytime the body has the loading class, our
	   modal element will be visible */
	body.loading .modal {
		display: block;
	}
	</style>
</head>

<body>
<div class="modal"></div>

    <div class="header">
        <a href="index.php" class="logo centralize"></a>
    </div>    
    
    <div class="login" id="login">
        <div class="wrap">
            <h1>Technical Staff Login</h1>
            <form name="loginForm" id="loginForm" action="" method="post">
	            <div class="row-fluid">
	                <div class="input-prepend">
	                    <span class="add-on"><i class="icosg-mail"></i></span>
	                    <input type="text" name="email" id="email" placeholder="Login Email..." value="<?php echo (isset($_COOKIE['email'])) ? $_COOKIE['email'] : ''; ?>" />
	                </div>                                                 
	                <div class="input-prepend">
	                    <span class="add-on"><i class="icon-lock"></i></span>
	                    <input type="password" name="password" id="password" placeholder="Password"value="<?php echo (isset($_COOKIE['password'])) ? $_COOKIE['password'] : ''; ?>"/>
	                </div>          
	                <div class="dr"><span></span></div>                                
	            </div>                
	            <div class="row-fluid">
	                <div class="span8 remember">
                        <input name="remember" id="remember" value="1" type="checkbox" <?php echo (isset($_COOKIE['email']) && isset($_COOKIE['password'])) ? 'checked="checked"' : '';?> style="margin-top:0;">
                        <span style="vertical-align: middle;">Remember me</span> 
					</div>
	                <div class="span4 TAR">
	                    <input type="submit" class="btn btn-block btn-primary" value="Log In" />
	                </div>
	            </div>
            </form>
                <div class="dr"><span></span></div>
                <div class="row-fluid">
                    <div class="span8">                    
                        <input type="button" class="btn btn-block" onClick="loginBlock('#forgot');" value="Forgot your password?" />
                    </div>
                </div>            
            </div>
       </div>  
    
    <div class="login" id="forgot">
        <div class="wrap">
            <h1>Forgot your password?</h1>
            <form name="forgotForm" id="forgotForm" action="" method="post">
				<div class="row-fluid">
	                <p>Enter your email address to recover your password</p>
	                <div class="input-prepend">
	                    <span class="add-on"><i class="icon-envelope"></i></span>
	                    <input type="text" name="forgetEmail" placeholder="E-mail"/>
	                </div>                                                           
	                <div class="dr"><span></span></div>                               
	            </div>                   
	            <div class="row-fluid">
	                <div class="span4">                    
	                    <input type="button" class="btn btn-block" onClick="loginBlock('#login');" value="Back" />
	                </div>                                
	                <div class="span4"></div>
	                <div class="span4 TAR">
	                    <input type="submit" class="btn btn-block btn-primary" value="Recover" />
	                </div>
	            </div>
	         </form>
        </div>
    </div>    
    
</body>
</html>
