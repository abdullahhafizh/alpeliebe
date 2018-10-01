<!DOCTYPE html>
<html lang="en" class="body-full-height">
<head>
  <!-- META SECTION -->
  <title>LOGIN - <?php echo cfg('app_name');?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" type="image/png" href="<?php echo themeUrl();?>img/logo.png">
  <!-- <link rel="icon" href="favicon.ico" type="image/x-icon" /> -->
  <!-- END META SECTION -->
  <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/jquery/jquery.min.js"></script>
  <!-- CSS INCLUDE -->
  <link rel="stylesheet" type="text/css" id="theme" href="<?php echo themeUrl();?>css/theme-default.css"/>
  <!-- EOF CSS INCLUDE -->
  <style type="text/css">
  .ctheme {
    color: <?php echo cfg('color_theme');?>;
  }
  body {
    background-color: #fff;
  }
</style>
</head>
<body>
  <div class="login-container login-v2">
    <div class="login-box animated fadeInDown">
      <div class="login-body">

        <!-- LOGO LOGIN -->
        <div class="login-title" align="center">
          <img src="<?php echo themeUrl();?>img/logo.png" style="width: 38%;" />
        </div>

        <!-- DISPLAY CAPTCHA -->
        <form action="javascript:void(0)" class="form-horizontal" id="frmCaptcha" name="frmCaptcha">
          <div class="alert alert-success" id="alert_message" role="alert" style="display:none;">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
              <span class="sr-only">Close</span>
            </button>
            <strong id="txt_message"></strong>
          </div>

          <!-- INPUT USERNAME -->
          <div class="form-group">
            <div class="col-md-12">
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="fa fa-user"></span>
                </div>
                <!-- Input username dilempar ke function act_auth() di auth.php -->
                <input style="color: black;" type="text" class="form-control" id="login_username" name="login_username" placeholder="Username"/>
              </div>
            </div>
          </div>

          <!-- INPUT PASSWORD -->
          <div class="form-group">
            <div class="col-md-12">
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="fa fa-lock"></span>
                </div>
                <!-- Input password dilempar ke function act_auth() di auth.php dan di-MD5 di sana -->
                <input style="color: black;" type="password" class="form-control" id="login_pass" name="login_pass" placeholder="Password"/>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-2">
              &nbsp;
            </div>

            <div class="col-md-7">
              <?php echo $image;?>
            </div>

            <div class="col-md-1">
              <span style="color: #fcce16;" id="refresh" href="javascript:void(0)" onclick="parent.window.location.reload(true)">
                <i class="fa fa-refresh"></i>
              </span>
            </div>
          </div>

          <!-- INPUT CAPTCHA -->
          <div class="form-group">
            <div class="col-md-12">
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="fa fa-unlock"></span>
                </div>
                <input style="color: black;" type="text" class="form-control" id="login_captcha" name="login_captcha" placeholder="Captcha"/>
              </div>
            </div>
          </div>
<!--                <div class="form-group">
                        <div class="col-md-7">
                            <div class="input-group">
                                <div class="input-group-addon">
                                </div>
                                <input type="text" class="form-control" id="txtCaptcha" name="txtCaptcha" placeholder="Captcha" maxlength="10" size="32"/>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <img id="imgCaptcha" src="<?php echo themeUrl();?>create_image.php" />
                            </div>
                        </div>
                    </div>
                  -->
                  <!-- ACTION TEKAN BUTTON LOGIN atau TEKAN ENTER -->
                  <div class="form-group">
                    <div class="col-md-12">
                      <button class="btn btn-primary btn-lg btn-block" id="btn_login" name="btn_login" onclick="getParam(document.frmCaptcha)">Login</button>
                    </div>
                  </div>
                </form>
              </div>

              <!-- LABEL COPYRIGHT DI BAWAH BUTTON LOGIN -->
              <div class="login-footer" style="color: white;">
                <center>
                  &copy;<?php echo date("Y")." ".'&nbsp; - &nbsp;Ikatan Alumni Penabur se-Indonesia';?>
                </center>
                <div class="pull-right">
                        <!--<a href="#">About</a> |
                        <a href="#">Privacy</a> |
                        <a href="#">Contact Us</a>-->
                      </div>
                    </div>
                  </div>
                </div>

                <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/summernote/summernote.js"></script>
                <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/noty/jquery.noty.js"></script>
                <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/noty/layouts/topCenter.js"></script>
                <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/noty/themes/default.js"></script>
                <script type="text/javascript">
                  var AUTH_URL = '<?php echo site_url("auth/act_auth");?>';
                  var RESET_URL = '<?php echo site_url("auth/reset");?>';

                </script>

                <script type="text/javascript" src="<?php echo themeUrl();?>js/login.meme.js"></script>
                <script language="JavaScript" type="text/javascript" src="<?php echo themeUrl();?>js/ajax_captcha.js"></script>
              </body>
              </html>
