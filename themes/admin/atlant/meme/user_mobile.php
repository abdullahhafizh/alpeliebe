<style type="text/css">
div.tabs {
    display: none;
}
</style>
<div class="well">
    <form autocomplete="off" class="form-inline" method="POST" action="<?php echo site_url('meme/user/user_mobile'); ?>">
        <div class="row">            
            <div class="col-md-4">
                <select class="form-control" name="group" id="group" style="width: 100%;">
                    <option disabled selected> - Group - </option>
                    <?php                    
                    if (isset($_SESSION['group_id'])) {
                        $old_group = $_SESSION['group_id'];
                    }            
                    foreach ($groups['data']['groups'] as $group) {
                        ?>
                        <option value="<?php echo $group['group_id'];?>" <?php if (isset($old_group)){if ($old_group == $group['group_id']) {echo "selected";}} ?>><?php echo $group['name'];?></option>
                    <?php }?>
                </select>
            </div>            
            <div class="col-md-4">        
                <input class="form-control" type="text" id="keyword" name="keyword" value="<?php if(isset($_SESSION['keyword'])) { echo $_SESSION['keyword']; }?>" placeholder="Masukkan kata kunci" style="width: 100%;">
            </div>
            <div class="col-md-4">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Search!</button>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-warning" href="<?php echo site_url('meme/user/user_mobile_reset'); ?>" style="width: 100%;">Reset!</a>
                </div>
            </div>
        </div>
    </form>
</div>
<?php if (count($json_decoded4['data']) >= 1) { ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php
            if ($page <= 1) {
                $pagelink = null;
            }
            else {
                $pagelink = "/".$page;
            }
            ?>
            <div class="pull-left col-lg-6 col-md-6 col-sm-6 col-xs-6 col-ls-6">    
                <a class="btn btn-primary btn-block btn-lg <?php if ($page <= 0) {echo "disabled";}?>" style="text-decoration: none;" href="<?php echo base_url();?>index.php/meme/user/user_mobile<?php echo $pagelink; ?>"><i class="fa fa-chevron-left fa-fw"></i>Previous Page</a>
            </div>
            <?php

            $next_page = $page + 1;
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_PORT => "2406",
                CURLOPT_URL => "http://".cfg('api_ip').":2406/sk_member/alpenindo/getall",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"group\":\"".$group_id."\",\"group_role\":\"member\",\"year_in\":\"\",\"key\":\"".$keyword."\",\"page\":".$next_page.",\"per_page\":20}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
                CURLOPT_HTTPHEADER => array(
                    "SessionId: ".$_SESSION['session']."",
                    "VersionCode: ".cfg('version_code')."",
                    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $next =  json_decode($response, true);
            }

            ?>
            <div class="pull-right col-lg-6 col-md-6 col-sm-6 col-xs-6 col-ls-6">
                <?php echo isset($paging)?$paging:'';?>
                <?php $paginate = $page + 2; ?>
                <a class="btn btn-primary btn-block btn-lg <?php if(count($next['data']) <= 0){echo "disabled";}?>" style="text-decoration: none;" href="<?php echo base_url();?>index.php/meme/user/user_mobile/<?php echo $paginate; ?>">Next Page <i class="fa fa-chevron-right fa-fw"></i></a>
            </div>
        </div>
        <!-- <?php echo $page; ?> -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped datatable" id="example">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                        <!-- <th>Tanggal Lahir</th>
                        <th>Tempat Lahir</th>
                        <th>Alamat</th>
                        <th>Provinsi</th>
                        <th>Kabupaten</th> -->                        
                        <th>No ID</th>
                        <th>Email</th>                        
                        <th>Nomor Handphone</th>
                        <!-- <th>Foto</th>
                        <th>Status</th>
                        <th>Golongan Darah</th> -->
                        <th>Kartu Tercetak</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php
                    foreach($json_decoded4['data'] as $r){
                        ?>
                        <tr>
                            <td style="color: black;" align="center"></td>
                            <td><?php echo $r['full_name'];?></td>
                                <!-- <td><?php echo $r['birth_date'];?></td>
                                <td><?php echo $r['birth_place'];?></td>
                                <td><?php echo $r['address'];?></td>
                                <td><?php echo $r['province']['province_name'];?></td>
                                <td><?php echo $r['kabupaten']['kabupaten_name'];?></td> -->
                                <td><?php echo $r['id_no'];?></td>
                                <!-- <td><?php echo $r['card_no'];?></td>
                                    <td><?php echo '<img src="'.$r['profile_pic'].'" height="100">';?></td> -->
                                    <td><?php echo $r['email_address'];?></td>
                                    <td><?php echo "+".$r['phone_country_code'].$r['phone_no'];?></td>
                                <!-- <td align="center"><?php echo ($r['status']=='ACTIVE')?'<span class="label label-info">Aktif</span>':'<span class="label label-warning">Non Aktif</span>';?></td>
                                    <td><?php echo $r['blood_type'];?></td> -->
                                    <td align="center"><?php echo ($r['card_printed']=='YES')?'<span class="label label-success">Ya</span>':'<span class="label label-danger">Tidak</span>';?></td>
                                    <td align="center">
                                        <?php 
                                        $eid = _encrypt($r['card_no']);
                                    // $except = array();
                                    // if($r->user_id==1)
                                    //     $except = array('delete','edit');
                                    // link_action($links_table_item,"?_id=".$eid,$except);
                                        ?>                                    
                                        <div class="row" style="display: inline-flex;">
                                            <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="Reset Password" style="text-decoration: none;" href="<?php echo base_url();?>meme/user/reset_password/?_id=<?php echo $eid; ?>">
                                                <i class="fa fa-key fa-fw"></i>
                                            </a>                                            
                                            <a class="btn btn-success btn-sm" data-toggle="tooltip" data-original-title="Jadikan Pengguna Web" style="text-decoration: none;" href="<?php echo base_url();?>meme/user/mobile_to_web/?_id=<?php echo $eid; ?>">
                                                <i class="fa fa-user"></i>
                                            </a>
                                            <?php if ($r['card_printed']=='NO') {
                                                echo '<a class="btn btn-warning btn-sm" data-toggle="tooltip" data-original-title="Update Status Cetak Kartu" style="text-decoration: none;" href="<?php echo base_url();?>meme/user/update_cardprinted/?_id=<?php echo $eid; ?>"><i class="fa fa-id-card"></i></a>';
                                            } ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>        
            </div>    
            <div class="panel-footer">
                <?php
                if ($page <= 1) {
                    $pagelink = null;
                }
                else {
                    $pagelink = "/".$page;
                }
                ?>
                <div class="pull-left col-lg-6 col-md-6 col-sm-6 col-xs-6 col-ls-6">    
                    <a class="btn btn-primary btn-block btn-lg <?php if ($page <= 0) {echo "disabled";}?>" style="text-decoration: none;" href="<?php echo base_url();?>index.php/meme/user/user_mobile<?php echo $pagelink; ?>"><i class="fa fa-chevron-left fa-fw"></i>Previous Page</a>
                </div>
                <?php

                $next_page = $page + 1;
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_PORT => "2406",
                    CURLOPT_URL => "http://".cfg('api_ip').":2406/sk_member/alpenindo/getall",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"group\":\"".$group_id."\",\"group_role\":\"member\",\"year_in\":\"\",\"key\":\"".$keyword."\",\"page\":".$next_page.",\"per_page\":20}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
                    CURLOPT_HTTPHEADER => array(
                        "SessionId: ".$_SESSION['session']."",
                        "VersionCode: ".cfg('version_code')."",
                        "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    $next =  json_decode($response, true);
                }

                ?>
                <div class="pull-right col-lg-6 col-md-6 col-sm-6 col-xs-6 col-ls-6">
                    <?php echo isset($paging)?$paging:'';?>
                    <?php $paginate = $page + 2; ?>
                    <a class="btn btn-primary btn-block btn-lg <?php if(count($next['data']) <= 0){echo "disabled";}?>" style="text-decoration: none;" href="<?php echo base_url();?>index.php/meme/user/user_mobile/<?php echo $paginate; ?>">Next Page <i class="fa fa-chevron-right fa-fw"></i></a>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready( function () { 
                var table = $('#example').DataTable( {
            // "language": {
            //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"
            // },            
            "pageLength": 100,
            // "lengthChange": false,
            // "paging": false,
            "order": [[ 1, "asc" ]]
        } );
                // table.search("<?php if(isset($_SESSION['keyword'])) { echo $_SESSION['keyword']; }?>").draw();
                // table.on( 'order.dt search.dt', function () {
                //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                //         cell.innerHTML = i+1;
                //     } );
                // } ).draw();
            } );    
        </script>
        <?php } ?>