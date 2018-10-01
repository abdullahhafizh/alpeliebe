                        </div>
                    </div>
                </div>                
            </div>                        
        </div>        

        <!-- <style type="text/css">
        .topm_200{
            margin-top:-200px;
        }
    </style> -->
    <div class="message-box message-box-danger animated fadeIn" id="mb-custom-meme">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title" id="title-mb-meme"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                <div class="mb-content" id="content-mb-meme">
                    <p>Apakah anda yakin akan logout ?</p>                    
                    <p>Tekan Tidak jika anda ingin melanjutkan pekerjaan anda. Tekan Ya untuk keluar.</p>
                </div>
                <div class="mb-footer">
                    <div class="pull-right" id="btn-mb-meme">
                        <a href="<?php echo site_url('auth/out');?>" class="btn btn-success btn-lg">Ya</a>
                        <button class="btn btn-default btn-lg mb-control-close">Tidak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>        

    <audio id="audio-alert" src="<?php echo themeUrl();?>audio/alert.mp3" preload="auto"></audio>
    <audio id="audio-fail" src="<?php echo themeUrl();?>audio/fail.mp3" preload="auto"></audio>    
</body>
<script type='text/javascript' src='<?php echo themeUrl();?>js/plugins/icheck/icheck.min.js'></script>
<script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>

<script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/knob/jquery.knob.min.js"></script>
<script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/owl/owl.carousel.min.js"></script>                
<?php load_js_plugins();?>        
<script type="text/javascript" src="<?php echo themeUrl();?>js/plugins.js"></script>        
<script type="text/javascript" src="<?php echo themeUrl();?>js/actions.js"></script>    
<script type="text/javascript" src="<?php echo base_url();?>assets/js/meme.core.js"></script>

<?php load_js();?>
<?php load_js_script();?>
<script type="text/javascript">
 var IMAGE_USER_URL = '<?php echo base_url();?>assets/collections/photo/';
</script>
</html>