<?php js_validate();?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-body profile" style="background: url('<?php echo themeUrl();?>img/backgrounds/wall_1.jpg') center center no-repeat;">
                                    <div align="center">
                                        <img src="<?php echo themeUrl();?>img/logo-login.png"/><br/>
                                    </div>
                                    <div class="profile-data">
                                        <div class="profile-data-name">KTA-PG</div>
										<?php 
										foreach ((array)get_version() as $k => $v) { ?>                                
                                        <div class="profile-data-title" style="color: #FFF;">Update Version <?php echo $v->changelog_version; ?></div>
										<?php } ?>
                                    </div>
                                </div>                                
                            </div>                            
                            
                        </div>
                        
                        <div class="col-md-9">

                            <!-- START TIMELINE -->
                            <div class="timeline timeline-right">
                                
                                <!-- START TIMELINE ITEM -->
                                <div class="timeline-item timeline-main">
                                    <div class="timeline-date">Update</div>
                                </div>
                                <!-- END TIMELINE ITEM -->                                                  
								<?php 
								foreach ((array)get_changelog() as $k => $v) { ?>                                
                                <!-- START TIMELINE ITEM -->
                                <div class="timeline-item timeline-item-right">
                                    <div class="timeline-item-info"><?php echo $v->changelog_date; ?></div>
                                    <div class="timeline-item-icon"><span class="fa fa-users"></span></div>                                   
                                    <div class="timeline-item-content">
                                         <div class="timeline-heading padding-bottom-0">
                                            <a href="#">System Application Update</a> Version <?php echo $v->changelog_version; ?>
                                        </div>                                        
                                        <div class="timeline-body">                                            
                                            <i><?php echo $v->changelog_text; ?></i>
                                        </div>                                               

                                    </div>                                    
                                </div>       
								<?php } ?>
                                <!-- END TIMELINE ITEM -->
                            </div>
                            <!-- END TIMELINE -->                            
                            
                        </div>
                        
                    </div>
<script type="text/javascript">
$(document).ready(function(){
    $('#panel-content-wrap').removeClass('panel');
    $('#border-header').css('border','none');
}); 
</script>