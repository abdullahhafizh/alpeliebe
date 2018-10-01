<?php
function active($string)
{
  if ($_SESSION['tingkat_kta'] == $string) {
    echo "active";    
  }
}
?>
<div class="panel-body tab-content">
  <ul class="nav nav-tabs" role="tablist">
    <li ><a href="<?php echo site_url()?>" role="tab">Dashboard Maps Distribution</a></li>
    <li class="active"><a href="<?php echo site_url('meme/me/detail_kta/'.$_SESSION['tingkat_kta'].'')?>" role="tab">Statistik Anggota</a></li>    
    <div class="panel-body">
      <div class="row">
        <div class="col-md-12">        
          <div class="btn-group btn-group-justified" role="group">
            <div class="btn-group" role="group">
              <a href="<?php echo site_url('meme/me/detail_kta/sma')?>" class="btn btn-default <?php active(sma); ?>"><b>SMA</b></a>
            </div>
            <div class="btn-group" role="group">
              <a href="<?php echo site_url('meme/me/detail_kta/smp')?>" class="btn btn-default <?php active(smp); ?>"><b>SMP</b></a>
            </div>
            <div class="btn-group" role="group">
              <a href="<?php echo site_url('meme/me/detail_kta/sd')?>" class="btn btn-default <?php active(sd); ?>"><b>SD</b></a>
            </div>
            <div class="btn-group" role="group">
              <a href="<?php echo site_url('meme/me/detail_kta/tk')?>" class="btn btn-default <?php active(tk); ?>"><b>TK</b></a>
            </div>
            <div class="btn-group" role="group">
              <a href="<?php echo site_url('meme/me/detail_kta/staff')?>" class="btn btn-default <?php active(staff); ?>"><b>STAFF</b></a>
            </div>
          </div>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-12">
          <div class="panel" id="cart_pie_gender">
          </div>
        </div>
      </div>      
      <div class="row">
        <div class="col-md-12">            
          <div class="panel panel-default">
           <div class="panel-heading">
            <div class="panel-title-box">
              <h3>DATA STATISTIK ANGGOTA PER <?php echo strtoupper($_SESSION['tingkat_kta']); ?></h3>
            </div>                
            <ul class="panel-controls">
              <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
            </ul>
          </div>               
          <div class="panel-body panel-body-table scroll">
            <div class="table-responsive">
             <table class="table table-hover table-bordered table-striped">
              <thead>
                <tr>
                  <td rowspan= "2" valign="middle" align="center"><b>Nama <?php echo strtoupper($_SESSION['tingkat_kta']); ?></b></td>
                  <td valign="middle" align="center"><b>Jumlah Kartu Tercetak</b></td>
                  <td valign="middle" align="center"><b>Jumlah Kartu Belum Cetak</b></td>
                  <td valign="middle" align="center"><b>Total Anggota</b></td>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($print['data'] as $p => $v) {
                  ?>
                  <tr>
                    <td valign="middle" ><b><?php echo $v['name'];?></b></td>
                    <td valign="middle" align="center"><b>
                      <?php
                      $satu = $v['data']['1']['total'];
                      if ($satu == null || $satu == '') {
                        echo "0";
                      }
                      else {
                        echo $v['data']['1']['total'];
                      }
                      ?>
                    </b></td>
                    <td valign="middle" align="center"><b>
                      <?php
                      $nol = $v['data']['0']['total'];
                      if ($nol == null || $nol == '') {
                        echo "0";
                      }
                      else {
                        echo $v['data']['0']['total'];
                      }
                      ?>
                    </b></td>
                    <td valign="middle" align="center"><b><?php echo $v['data']['0']['total']+$v['data']['1']['total'];?></b></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
js_hight_chart();
?>
<script type="text/javascript">
  $(function () {
    $('#cart_pie_gender').highcharts({
      chart: {
        type: 'column',
        marginLeft:60,
        marginRight:10,
        reflow: true
      },
      title: {
        text: '<b>Info Statistik Jumlah Anggota per <?php echo strtoupper($_SESSION['tingkat_kta']); ?> dalam 1 Sekolah Penabur</b>'
      },
      credits: {
        enabled:false
      },
      exporting:{
        enabled:false
      },
      subtitle: {
        text: '<b>Jumlah Anggota per <?php echo strtoupper($_SESSION['tingkat_kta']); ?> dalam 1 Sekolah Penabur</b>'
      },
      plotOptions: {
        column : {
          pointWidth:23
        }
      },
      xAxis: {
        type: 'category',
        labels: {
          rotation: -35,
          style: {
            fontSize: '9px',
            fontFamily: 'Verdana, sans-serif'
          }
        }
      },
      yAxis: {
        min: 0,
        title: {
          text: 'Jumlah'
        }
      },
      legend: {
        enabled: false
      },
      tooltip: {
        pointFormat: '{series.name} : <b>{point.y:f}</b>'
      },
      series: [
      {
        name: 'TOTAL DATA',
        data: [<?php          
          foreach ($req['data'] as $p => $v) {
           echo $p>0?',':'';
           echo "['".$v['name']."',".$v['data_count']."]";
         }
         ?>
         ],
         dataLabels: {
          enabled: true,
          rotation: -90,
          color: '#111',
          align: 'right',
          x: 4,
          y: -20,
          style: {
            fontSize: '9px',
            fontFamily: 'Verdana, sans-serif'
          }
        },
        color:'#ffbc14'
      }
      ]
    });
  });
</script>
