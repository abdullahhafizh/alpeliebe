<div class="panel-body tab-content">
  <ul class="nav nav-tabs" role="tablist">
    <li  class="active"><a href="<?php echo site_url()?>" role="tab">Dashboard Maps Distribution</a></li>
    <li><a href="<?php echo site_url('meme/me/detail_kta/'.$_SESSION['tingkat_kta'].'')?>" role="tab">Statistik Anggota</a></li>      
  </ul>
  <br>

  <div class="row" id="refresh">        
    <div class="col-md-4">
      <div class="widget widget-primary widget-padding-sm">
        <div class="widget-title"><i class="fa fa-users fa-fw"></i> Jumlah Anggota</div>
        <div class="widget-subtitle">Jumlah Seluruh Anggota Alpenindo</div>
        <div class="widget-int">
          <span data-toggle="counter">
            <?php echo $tot_member; ?>
          </span>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="widget widget-success widget-padding-sm">
        <div class="widget-title"><i class="fa fa-id-card fa-fw"></i> Jumlah Kartu Tercetak</div>
        <div class="widget-subtitle">Jumlah Seluruh Kartu Tercetak</div>
        <div class="widget-int">
          <span data-toggle="counter">
            <?php echo $tot_card_printed; ?>
          </span>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="widget widget-info widget-padding-sm">
        <div class="widget-title"><i class="fa fa-credit-card fa-fw"></i> Jumlah Kartu Belum Cetak</div>
        <div class="widget-subtitle">Jumlah Seluruh Kartu Belum Tercetak</div>
        <div class="widget-int">
          <span data-toggle="counter">
            <?php echo $tot_card_not_printed; ?>
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">      
      <div id ="container"></div>        
    </div>    
    <br>
    <div class="col-md-4">
      <!-- <div class="panel with-nav-tabs">
        <div class="panel-body"> -->
          <!-- <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1default" data-toggle="tab">Minggu ini</a></li>
            <li><a href="#tab2default" data-toggle="tab">3 Bulan ini</a></li>
          </ul> -->
          <!-- <div class="tab-content"> -->
            <!-- <div class="tab-pane fade in active" id="tab1default">
              <div id="cart_pie_gender3"></div>
            </div> -->
            <!-- <div class="tab-pane fade in active" id="tab2default"> -->
              <div id="cart_pie_gender2"></div>
              <!-- </div> -->
              <!-- </div> -->
        <!-- </div>
        </div> -->
      </div>
    </div>
  </div>
  <!-- <script type="text/javascript" src="<?php echo themeUrl();?>js/highmaps.js"></script> -->
  <script type="text/javascript" src="https://code.highcharts.com/maps/highmaps.js"></script>
  <!-- <script type="text/javascript" src="<?php echo themeUrl();?>js/id-all.js"></script> -->
  <script type="text/javascript" src="https://code.highcharts.com/mapdata/countries/id/id-all.js"></script>
  <!-- <script type="text/javascript" src="<?php echo themeUrl();?>js/exporting.js"></script> -->
  <script type="text/javascript" src="https://code.highcharts.com/maps/modules/exporting.js"></script>
  <script>
    //SCRIPT UNTUK PANGGIL PETA PROPINSI HNSI
    $(function() {
      var data = [
      {
        "hc-key": "id-3700",

        url: '<?php echo $own_links;?>/detail/?_id=id-3700'
      },
      <?php
          //tadinya DATA PETA dari SQL, sekarang DARI API
          //foreach ((array)get_hc_key() as $k => $v) {
      $i = 0;
      foreach ($tot_print_per_province['data'] as $v) {
//$i++;
        $belumcetak = $v['data'][0]['total'];
        $sudahcetak = $v['data'][1]['total'];
        $printed = $sudahcetak + $belumcetak;
            //if ($v['printed'] == "YES") {
            //$koma = $k<count(get_hc_key())-1?",":"";
        $koma = $i<count($tot_print_per_province['data'])-1?",":"";
        echo "{";
            //echo '"hc-key":"'.$v->hc_key.'",';
        echo '"hc-key":"'.$v['hc_key'].'",';
            //echo '"value":"'.myNum(get_total_by_prop($v->propinsi_id)).'",';
            echo '"value":'.$printed.','; //.$v['data_count'].'",';
            echo '"sudahcetak":'.$sudahcetak.',';
            echo '"belumcetak":'.$belumcetak.',';
            //echo "url:'".$own_links."/detail/?_id=".$v->hc_key."'";
            echo "url:'".$own_links."/detail/?_id=".$v['hc_key']."'";
            echo "}".$koma;
          }//}
          ?>
          ];

      // Initiate the chart
      $('#container').highcharts('Map', {
        tooltip: {
          formatter: function(){
            var s = this.key + '<br/>'; //ganti 'this.key' sama $v['hc_key']
            s += 'Jumlah Anggota : ' + this.point.value+ '<br/>';
            s += 'Sudah Cetak : ' + this.point.sudahcetak+ '<br/>';
            s += 'Belum Cetak : ' + this.point.belumcetak+ '<br/>';
            return s;
          },
        },

        legend: {
          enabled: false
        },

        title : {
          text : '<b>Peta Distribusi Per Provinsi</b>'
        },

        subtitle : {
          text : '<b>Anggota Alumni Penabur se-Indonesia</b>'
        },

        credits: {
          enabled: false
        },

        mapNavigation: {
          enabled: true,
          buttonOptions: {
            verticalAlign: 'top'
          }
        },

        series : [
        {
          data : data,
          mapData: Highcharts.maps['countries/id/id-all'],
          joinBy: 'hc-key',
          allowPointSelect: true,
          cursor: 'pointer',
          name: 'value',
          states: {
            select: {
              color: '#a4edba',
              borderColor: 'black',
              dashStyle: 'shortdot'
            }
          },
          point: {
            events: {
              //click: function () {
                //location.href = this.options.url;
              //}
            }
          },
          dataLabels: {
            enabled: true,
            format: '{point.name}'
          },
          tooltip: {
            formatter: function(){
              console.log(this);
            },
            valueSuffix: ' Anggota'
          }
        }
        ]
      });
    });
  </script>
  <?php
  js_hight_chart();
  ?>
  <script type="text/javascript">
    $(function () {
      $('#cart_pie_gender2').highcharts({
        chart: {
          type: 'column',
          marginLeft:60,
          marginRight:10,
          reflow: true
        },
        title: {
          text: '<b>Info Statistik Jumlah Anggota Baru</b>'
        },
        credits: {
          enabled:false
        },
        exporting:{
          enabled:false
        },
        subtitle: {
          <?php
          if (count($req2['data']<=2)) {
            echo "text: '<b>Jumlah Anggota Baru dalam ".count($req2['data'])." bulan per 1 bulan</b>'";
          }
          else
          {
            echo "text: '<b>Jumlah Anggota Baru dalam 3 bulan per 1 bulan</b>'";
          }
          ?>          
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
          data: [
          <?php
          foreach ($req2['data'] as $p => $v) {
            echo $p>0?',':'';
            $monthNum  = $v['month'];
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F');
            echo "['".$monthName."',".$v['total']."]";
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

      $('#cart_pie_gender3').highcharts({
        chart: {
          type: 'column',
          marginLeft:60,
          marginRight:10,
          reflow: true
        },
        title: {
          text: '<b>Info Statistik Jumlah Anggota Baru per 1 minggu</b>'
        },
        credits: {
          enabled:false
        },
        exporting:{
          enabled:false
        },
        subtitle: {
          text: '<b>Jumlah Anggota Baru dalam 1 bulan per 1 minggu</b>'
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
            foreach ($req2['data'] as $p => $v) {
             echo $p>0?',':'';
           // echo "['".$v['name']."',".$v['data_count']."]";
             echo "['Bulan Ini',".$v['data_count']."]";
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