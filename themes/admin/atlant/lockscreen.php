<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title>LOCK SCREEN - SAK-PG</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo themeUrl();?>css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->                                  
    </head>
    <body>
        
        <div class="lockscreen-container">
        	<div class="row" style="margin-top: 100px;">
				<div class="col-md-3">
				</div> 
				<div class="col-md-6">
					<div class="alert alert-warning" role="alert" style="text-align: center;">			
		           		<strong>PERINGATAN!</strong> Perbaharui browser Anda untuk dapat mengakses website ini
					</div>
				</div> 
			</div>         	
            <div class="lockscreen-box">
                
                <div class="lsb-access">
                    <div class="lsb-box">
                        <div class="fa fa-lock"></div>
                        <div class="user animated fadeIn">
                        	<img src="<?php echo themeUrl();?>img/logo-login.png" alt="Golkar" />
                            <div class="user_signin animated fadeIn">
                                <div class="fa fa-sign-in"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- div class="lsb-form animated fadeInDown">
                    <form action="</?php echo site_url('meme/me');?>" method="post" class="form-horizontal">
                        <div class="form-group sign-in animated fadeInDown">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="fa fa-user"></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Your login"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="fa fa-lock"></span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Password"/>
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="hidden"/>
                    </form>
                </div -->
                
            </div>
            
        </div>
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/bootstrap/bootstrap.min.js"></script>        
        <!-- END PLUGINS -->

        <!-- START TEMPLATE -->       
        <script type="text/javascript">
        var url_img_lock = "<?php echo themeUrl();?>assets/images/users/no-image.jpg";
        </script>         
        <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins.js"></script>
        <script type="text/javascript" src="<?php echo themeUrl();?>js/actions.js"></script>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS --> 
    </body>
</html>






