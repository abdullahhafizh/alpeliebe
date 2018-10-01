<!DOCTYPE html>
<html lang="en">
<head>  
  <title><?php echo cfg('app_name');?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" type="image/png" href="<?php echo themeUrl();?>img/logo.png">
  <!--<link rel="icon" href="<?php echo themeUrl();?>/img/favicon.ico" type="image/x-icon" />-->
  <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/jquery/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/bootstrap/bootstrap.min.js"></script>  
  <script type="text/javascript">
    var BASE_URL = '<?php echo base_url();?>';
    var THEME_URL = '<?php echo themeUrl();?>';
    var CURRENT_URL = '<?php echo current_url();?>';
    var MEME = {};
    window.history.forward();
    function noBack() {
      window.history.forward();
    }
  </script>
  <link rel="stylesheet" type="text/css" id="theme" href="<?php echo themeUrl();?>css/theme-default-head-light.css"/>
  <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet">  
  <?php load_css();?>
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">  
</head>
<body>
  <?php get_info_message();?>  
  <div class="page-container page-navigation-top page-navigation-top-custom">    
    <div class="page-content">      
      <?php if($this->jCfg['theme_setting']['header']==true){?>
        <div class="page-content-header">
          <div class="pull-left" style="padding-left: 10px;">
            <a href="<?php echo site_url();?>">
              <img src="<?php echo themeUrl();?>img/logo.png" height="50" />
            </a>
          </div>

          <div class="pull-right">
            <div class="socials">
              <?php echo myDate(date("Y-m-d H:i:s"),"d M Y H:i");?>
            </div>

            <div class="contacts">
              <a href="#"><span class="fa fa-user"></span> <?php echo $this->jCfg['user']['fullname'];?>, <?php echo $this->jCfg['user']['name'];?></a>
            </div>
          </div>
        </div>

        <?php } ?>
        <ul class="x-navigation x-navigation-horizontal">
          <?php if($this->jCfg['theme_setting']['header']==true){?>
            <li class="xn-navigation-control">
              <a href="<?php echo site_url('meme/me');?>" class="x-navigation-control"></a>
            </li>
            <?php }else{ ?>
            <li class="xn-logo">
              <img src="<?php echo themeUrl();?>img/logo-login.png" height="40" />
              <a href="<?php echo site_url('meme/me');?>" class="x-navigation-control"></a>
            </li>
            <?php } ?>
            <?php top_menu($this->jCfg['menu']);?>
            <li class="xn-icon-button pull-right last">
              <a href="#"><span class="fa fa-power-off"></span></a>
              <ul class="xn-drop-left animated zoomIn">
                <li><a href="<?php echo site_url('meme/me/change_password');?>"><span class="fa fa-key"></span> Change Password</a></li>
                <li><a href="<?php echo site_url('auth/out');?>" class="act_confirm" data-title="Logout" data-body="Apakah anda yakin akan logout ?" data-desc="Tekan Tidak jika anda ingin melanjutkan pekerjaan anda. Tekan Ya untuk keluar." data-icon="fa-sign-out"><span class="fa fa-sign-out"></span> Sign Out</a></li>
                <li><a href="<?php echo site_url('meme/me/app_version');?>"><span class="fa fa-gear"></span><span>About KTA-PG</span></a></li>
              </ul>
            </li>            
          </ul>
          <?php get_breadcrumb($this->breadcrumb);?>          
          <div class="row">
            <?php if($this->is_dashboard==FALSE){?>
            <div class="col-md-6">
              <div class="page-title">
                <h2><!--<a href = "<?php echo $own_links;?>"><span class="fa fa-arrow-circle-o-left"></span></a>--> <?php echo isset($title)?$title:'';?></h2>
              </div>
            </div>

            <div class="col-md-6">
              <!-- START TABS -->
              <div class="panel panel-default tabs" style="border-top-width:0px;">
                <ul class="nav nav-tabs pull-right" role="tablist">
                  <?php isset($links)?getLinksWebArch($links):'';?>
                </ul>
              </div>
              <!-- END TABS -->
            </div>

            <div style="clear:both;"></div>
            <div style="border-bottom:1px solid #009F9A;margin:-20px 10px 10px 10px;" id="border-header"></div>
            <?php }else{ ?>
            <div style="clear:both;"></div>
            <div style="border-bottom:1px solid #009F9A;margin:-20px 10px 30px 10px;" id="border-header"></div>
            <?php } ?>
          </div>
          <!-- PAGE CONTENT WRAPPER -->
          <div class="page-content-wrap">
            <div class="row" style="margin:-20px 10px 10px 10px;">
              <div class="col-md-12 panel" id="panel-content-wrap" style="border-radius:0px;padding:20px;">
