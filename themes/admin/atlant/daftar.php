<style type="text/css">
.border_camera{
    width:170px;height:130px;
    border:5px solid #FE4A3F;
    margin: 10px;
}
</style>
<div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Form </strong> Pendaftaran</h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <p></p>
                                </div>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-7">
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Tipe KTA</label>
                                                <div class="col-md-9">                                                                                            
                                                    <select class="form-control select">
                                                        <option>Umum</option>
                                                        <option>Atlet</option>
                                                    </select>
                                                    <span class="help-block">Apakah Umum atau atlet</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">ID PBSI</label>
                                                <div class="col-md-9">                                            
                                                    <input type="text" class="form-control"/>                                           
                                                    <span class="help-block">Di isi untuk KTA Atlet</span>
                                                </div>
                                            </div>
                                            

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Nama Lengkap</label>
                                                <div class="col-md-9">                                            
                                                    <input type="text" class="form-control"/>                                           
                                                    <span class="help-block">Nama Lengkap Kartu Anggota</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Jenis Kelamin</label>
                                                <div class="col-md-9">                                                                                                                                        
                                                    <label class="check"><input type="radio" name="mm" class="icheckbox" checked="checked"/> Pria</label>
                                                    <label class="check"><input type="radio" name="mm" class="icheckbox" />Wanita</label>
                                                    <span class="help-block">Jenis Kelamin</span>
                                                </div>
                                            </div>

                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Tanggal lahir</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                        <input type="text" class="form-control datepicker" value="2014-11-01">                                            
                                                    </div>
                                                    <span class="help-block">Tanggal Lahir Calon Anggota</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Agama</label>
                                                <div class="col-md-9">                                            
                                                    <input type="text" class="form-control"/>                                           
                                                    <span class="help-block">Agama Lengkap Kartu Anggota</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email</label>
                                                <div class="col-md-9">                                            
                                                    <input type="text" class="form-control"/>                                           
                                                    <span class="help-block">Email Lengkap Kartu Anggota</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Telp</label>
                                                <div class="col-md-9">                                            
                                                    <input type="text" class="form-control"/>                                           
                                                    <span class="help-block">Telp Lengkap Kartu Anggota</span>
                                                </div>
                                            </div>

                                            
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Alamat</label>
                                                <div class="col-md-9 col-xs-12">                                            
                                                    <textarea class="form-control" rows="3"></textarea>
                                                    <span class="help-block">Alamat anggota</span>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="col-md-5">
                                            
                                            <div class="col-md-6">
                                                <div class="form-group border_camera">
                                                    <div id="my_camera"></div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <a href="#" onclick="take_snapshot();" class="btn btn-primary btn-lg"><span class="fa fa-camera"></span>Ambil Foto</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group border_camera" id="div_result" style="display:none;">
                                                    <div id="result_camera">

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default">Bersihkan Form</button>                                    
                                    <button class="btn btn-primary pull-right">Simpan</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>

<script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/webcamjs/webcam.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        Webcam.set({
            width: 160,
            height: 120,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach( '#my_camera' );

    });

    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $('#div_result').fadeIn();
            $('#result_camera').html( '<img src="'+data_uri+'"/>');
        } );
    }

</script>