<!-- koment -->
        <script type="text/javascript" src="<?php echo themeUrl();?>js/highmaps.js"></script>        
        <script type="text/javascript" src="<?php echo themeUrl();?>js/id-all.js"></script>        
        <script type="text/javascript" src="<?php echo themeUrl();?>js/exporting.js"></script>        
	<script>
	$(function() {    
    var data = [
        {
            "hc-key": "id-3700",
            "value": <?php echo myNum(get_total_by_prop());?>,
			url: '<?php echo $own_links;?>/domisili/?_id=id-3700'

        },
		<?php 
			foreach ((array)get_hc_key() as $k => $v) {
                $koma = $k<count(get_hc_key())-1?",":"";
				echo "{";
				echo '"hc-key":"'.$v->hc_key.'",';				
				echo '"value":"'.myNum(get_total_kabupaten($v->propinsi_id)).'",';				
				echo "url:'".$own_links."/domisili/?_id=".$v->hc_key."'";				
				echo "}".$koma;				
			}?>						
    ];

    // Initiate the chart
    $('#container').highcharts('Map', {
                 tooltip: {
                     formatter: function(){
                         var s = this.key + '<br/>';
                         s += 'Jumlah Kabupaten : ' + this.point.value+ '<br/>';
                         return s;
                     },
                 },
		
		legend: {
            enabled: false
          },


        title : {
            text : 'Peta Indonesia'
        },

        subtitle : {
            text : 'Distribusi Domisili Permendagri No. 56 2015'
        },

        mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'top'
            }
        },
        series : [{
            data : data,
            mapData: Highcharts.maps['countries/id/id-all'],
            joinBy: 'hc-key',
			allowPointSelect: true,
            cursor: 'pointer',
			name: 'value',
            color: '#fcce16',
            states: {
                select: {
                    color: '#a4edba',
                    borderColor: 'black',
                    dashStyle: 'shortdot'
						}
					},
				point: {
                    events: {
                        click: function () {
                            location.href = this.options.url;
                        }
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
        }]
    });
});
	</script>
</head>
<body>
            <div class="row">
                        <div class="col-md-3">
                            <div class="widget widget-primary widget-padding-sm">
                                <div class="widget-title">TOTAL DATA PROPINSI</div>
                                <div class="widget-subtitle">Berdasarkan PERMENDAGRI No. 56 Tahun 2015</div>
                                <div class="widget-int"><span data-toggle="counter" data-to="<?php echo myNum(get_total_province());?>"><?php echo myNum(get_total_province());?> </span></div>
                            </div>                        
                        </div>
                        <div class="col-md-3">
                            <div class="widget widget-success widget-padding-sm">
                                <div class="widget-title">TOTAL DATA KABUPATEN</div>
                                <div class="widget-subtitle">Berdasarkan PERMENDAGRI No. 56 Tahun 2015</div>
                                <div class="widget-int"><span data-toggle="counter" data-to="<?php echo myNum(get_total_kabupaten());?>"><?php echo myNum(get_total_kabupaten());?> </span></div>
                            </div>                        
                        </div>
                        <div class="col-md-3">
                            <div class="widget widget-danger widget-padding-sm">
                                <div class="widget-title">TOTAL DATA KECAMATAN</div>
                                <div class="widget-subtitle">Berdasarkan PERMENDAGRI No. 56 Tahun 2015</div>
                                <div class="widget-int"><span data-toggle="counter" data-to="<?php echo myNum(get_total_kecamatan());?>"><?php echo myNum(get_total_kecamatan());?></span></div>
                            </div>                        
                        </div>
                        <div class="col-md-3">
                            <div class="widget widget-info widget-padding-sm">
                                <div class="widget-title">TOTAL DATA KELURAHAN</div>
                                <div class="widget-subtitle">Berdasarkan Database Komisi Pemilihan Umum</div>
                                <div class="widget-int"><span data-toggle="counter" data-to="<?php echo myNum(get_total_kelurahan());?>"><?php echo myNum(get_total_kelurahan());?></span></div>
                            </div>                        
                        </div>
            </div>	
<div class="row">
    <div class="col-md-12">
		<div id ="container"></div>
	</div>
</div>
</body>
</html>
