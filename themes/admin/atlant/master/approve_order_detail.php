<style type="text/css">
.border_camera{
    width:170px;height:130px;
    border:5px solid #FE4A3F;
    margin: 10px;
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
                            
    <form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="order_id" id="order_id" value="<?php echo isset($val->order_id)?$val->order_id:'';?>" />
        <input type="hidden" name="penggunaID" id="penggunaID" value="<?php echo isset($val->order_pengguna)?$val->order_pengguna:'';?>" />
        <input type="hidden" name="jumlah_kartu" id="jumlah_kartu" value="<?php echo get_kta_order($val->order_id);?>" />
        <div class="panel-body">                                                                        
            
            <div class="row">
                
                <div class="col-md-6">
                    <h3>Data Pemesan</h3>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td width="200">Nama Pemesan</td>
                                <td width="1">:</td>
                                <td><?php echo $val->nama_pengguna;?></td>
                            </tr>
                            <tr>
                                <td>No. Telp Pemesan</td>
                                <td width="1">:</td>
                                <td><?php echo $val->notelp_pengguna;?></td>
                            </tr>
                            <tr>
                                <td>Email Pemesan</td>
                                <td width="1">:</td>
                                <td><?php echo $val->email_pengguna;?></td>
                            </tr>
                            <tr>
                                <td>Alamat Pemesan</td>
                                <td width="1">:</td>
                                <td><?php echo $val->alamat_pengguna;?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="1"></td>
                                <td><?php echo $val->propinsi_nama;?></td>
                            </tr>
                            <tr>
                                <td>Saldo Pemesan</td>
                                <td width="1">:</td>
                                <td><?php echo "Rp. ".myNum($val->saldo_pengguna);?></td>
                            </tr>
                            <tr>
                                <td colspan="3"><hr></td>
                            </tr>
                        </tbody>
                    </table>
                  
                </div>
                <div class="col-md-6">
                    <h3>Data Order</h3>
                        <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td width="200">Order ID</td>
                                <td width="1">:</td>
                                <td><?php echo $val->order_id;?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Order</td>
                                <td width="1">:</td>
                                <td><?php echo $val->order_date;?></td>
                            </tr>
                            <tr>
                                <td>Jumlah Kartu</td>
                                <td width="1">:</td>
                                <td><?php echo get_kta_order($val->order_id)." Kartu";?></td>
                            </tr>
                            <tr>
                                <td>Biaya Cetak</td>
                                <td width="1">:</td>
                                <td><?php echo "Rp. ".myNum(get_kta_order($val->order_id) * 10000);?></td>
                            </tr>
                            <tr>
                                <td>Approve Order</td>
                                <td width="1">:</td>
                                <td width="400">
									<div class="input-group">
										<span class="input-group-addon"><span class="fa fa-user"></span></span>                                
										<select class="validate[required] form-control" name="kta_approve" id="kta_approve">
										   <option value=""> - pilih status - </option>
										   <option value="1"> Approved </option>
										   <option value="2"> Rejected </option>
										</select>                                        
									</div>								
								</td>
                            </tr>
                            <tr>
                                <td colspan="3"><hr></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
<div class="panel panel-default tabs" style="margin-top:25px;">
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Nomor Kartu</th>
                    <th>Nama Lengkap</th>
                    <th>Gender</th>
                    <th colspan="4">Domisili</th>
                </tr>
                </thead>
               <tbody> 
					<?php 
						$no =0;
						foreach ((array)get_order($val->order_id) as $k => $v) {
							$no++;
					?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $v->kta_nomor_kartu;?></td>
                            <td><?php echo $v->kta_nama_lengkap;?></td>
                            <td><?php echo $jenkel[$v->kta_jenkel];?></td>
                            <td><?php echo $v->propinsi_nama;?></td>
                            <td><?php echo $v->kab_nama;?></td>
                            <td><?php echo $v->kec_nama;?></td>							
                            <td><?php echo $v->kel_nama;?></td>							
                        </tr>
					<?php
					}?>						
                </tbody>
            </table>
            
        </div>
    </div>
</div>

        </div>
        <div class="panel-footer">
          <div class="pull-left">
            <button type="button" onclick="document.location='<?php echo $own_links;?>'" class="btn btn-white btn-cons">Cancel</button>
          </div>
          <div class="pull-right">
            <button type="submit" name="simpan" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Update Data</button>
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
                            