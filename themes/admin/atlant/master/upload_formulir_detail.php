<style type="text/css">
.border_camera{
    width:170px;height:130px;
    border:5px solid #FE4A3F;
    margin: 10px;
}
.content {
	background-image: url('<?php echo base_url()."assets/images/id_card_front.jpg";?>'); 
	background-size: 350px 220px;
	background-repeat: no-repeat; 
	height:220px; 
	width:350px;
}
.nama,.nomor,.domisili,.masa{
	text-align: right;
}
.nama{
	font-size: 16px;
	font-weight: bold;
	line-height: 20px;
}
.nomor{
	font-size: 12px;
	line-height: 12px;
}
.domisili{
	font-size: 10px;
	line-height: 15px;
}
.masa{
	font-size: 7px;
	margin-top: 5px;
}

.canvas {
	height:650px; 
	width:1063px;
}
.content-lg { 
	background-image: url('<?php echo base_url()."assets/images/id_card_front.jpg";?>'); 
	background-size: 100% 100%;
	background-repeat: no-repeat;
	height:650px; 
	width:1063px;
}
.content-lg-no-image { 
	background-color:transparent; 
	/*background-size: 100% 100%;
	background-repeat: no-repeat;*/
	height:650px; 
	width:1063px;
}
.nama-lg,.nomor-lg,.domisili-lg,.masa-lg{
	text-align: right;
}
.nama-lg{
	font-size: 50px;
	font-weight: bold;
	line-height: 50px;
}
.nomor-lg{
	font-size: 35px;
	line-height: 50px;
}
.domisili-lg{
	font-size: 30px;
	line-height: 28px;
}
.masa-lg{
	font-size: 18px;
	margin-top: 30px;
}
</style>
<?php js_validate();?>
<?php
$status = cfg('status_anggota');
$asuransi = cfg('status_asuransi');
$tipe_kta = cfg('tipe_kta');
$jenkel = cfg('jenkel');
$jenis_bayar = cfg('jenis_bayar');
$status_nikah = cfg('status_nikah');
$pendidikan = cfg('pendidikan');
$pekerjaan = cfg('pekerjaan');
$tingkat = cfg('tingkatan');
$jabatan = cfg('jabatan');
$hastakarya = cfg('hasta_karya');
?>
                            
    <form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save_detail" class="form-horizontal" method="post"> 
        <input type="hidden" name="kta_id" id="kta_id" value="<?php echo isset($val->kta_id)?$val->kta_id:'';?>" />
        <input type="hidden" name="kta_ktp" id="kta_ktp" value="<?php echo isset($val->kta_no_id)?$val->kta_no_id:'';?>" />

        <div class="panel-body">                                                                        
            <div class="row">
                <div class="col-md-6">
                    <h3>No. NIK : <?php echo $val->kta_no_id;?></h3>
                </div>                
                <div class="col-md-6">
                    <h3>Pengusul : <?php 
									foreach ((array)get_detail_pengusul($val->kta_pemesan) as $k => $v) {
										echo $v->nama;
									}					
					?></h3>
                </div>                
                <div class="col-md-12">
                    <hr>
                </div>                
            </div>            
            <div class="row">
             <div class="col-md-6" style="border:1px solid #000;">
			<img alt="" src="<?php echo base_url()."assets/collections/kta/medium/".$val->kta_lampiran1;?>" style="height:100%;width:550px;" >
			 </div>                
             <div class="col-md-6" style="border:1px solid #000;">
			<img alt="" src="<?php echo base_url()."assets/collections/kta/medium/".$val->kta_lampiran2;?>" style="height:100%;width:550px;" >
			 </div>                				
			 </div>

        </div>
        <div class="panel-footer">
          <div class="pull-left">
            <button type="button" onclick="document.location='<?php echo $own_links;?>'" class="btn btn-white btn-cons">Cancel</button>
          </div>
          <div class="pull-right">
            <button type="button" onclick="document.location='<?php echo $own_links."/edit/?_id="._encrypt($val->kta_id);?>'" class="btn btn-white btn-cons">Edit</button>
            <button type="submit" name="simpan" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Lanjut</button>
          </div>
        </div>
        <div class="message-box message-box-danger animated fadeIn" id="message-box-danger">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span> Keterangan Reject</div>
                    <div class="mb-content">
						<div class="form-group">
							<div class="col-md-10">
                                <textarea name="ket_reject"  value="" id="ket_reject" class="form-control" placeholder="Masukan Alasan Reject"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mb-footer">
						<button class="btn btn-primary pull-right" type="submit" name="reject">Reject</button>
                        <button class="btn btn-default pull-left mb-control-close">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript">
    $(document).ready(function(){
        is_edc();
        $('#kta_jenis_bayar').change(function(){
            is_edc();
        });
    });
    function is_edc(){
        m = $('#kta_jenis_bayar').val();
        if(m==1){
            $('.edc_div').fadeIn();
        }else{
            $('.edc_div').fadeOut();
        }
    }
    </script>
                            