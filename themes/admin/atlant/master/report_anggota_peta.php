        <script type="text/javascript" src="<?php echo themeUrl();?>js/highmaps.js"></script>        
        <script type="text/javascript" src="<?php echo themeUrl();?>js/id-all.js"></script>        
        <script type="text/javascript" src="<?php echo themeUrl();?>js/exporting.js"></script>        
	<script>
	$(function() {    
    var data = [
        {
            "hc-key": "id-3700",
            "value": <?php echo myNum(get_total_by_prop());?>,
			"Jumlah Koperasi" : <?php echo myNum(get_total_kop_by_prop());?>
        },
        {
            // Aceh
			"hc-key": "id-ac",
            "value": <?php echo myNum(get_total_by_prop(1));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(1));?>
        },
		{
            // Sumatera Utara
			"hc-key": "id-su",
            "value": <?php echo myNum(get_total_by_prop(2));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(2));?>
        },
		{
            // Sumatera Barat
			"hc-key": "id-sb",
            "value": <?php echo myNum(get_total_by_prop(3));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(3));?>
        },
		{
            // Riau
			"hc-key": "id-ri",
            "value": <?php echo myNum(get_total_by_prop(4));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(4));?>
        },
		{
            // Kepulauan Riau
			"hc-key": "id-kr",
            "value": <?php echo myNum(get_total_by_prop(20));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(20));?>
        },
		{
            // Jambi
			"hc-key": "id-ja",
            "value": <?php echo myNum(get_total_by_prop(5));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(5));?>
        },
		{
            // Bengkulu
			"hc-key": "id-be",
            "value": <?php echo myNum(get_total_by_prop(7));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(7));?>
        },
		{
            // Sumatera Selatan
			"hc-key": "id-sl",
            "value": <?php echo myNum(get_total_by_prop(6));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(6));?>
        },
		{
            // Bangka Belitung
			"hc-key": "id-bb",
            "value": <?php echo myNum(get_total_by_prop(9));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(9));?>
        },
		{
            // Lampung
			"hc-key": "id-1024",
            "value": <?php echo myNum(get_total_by_prop(8));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(8));?>
        },
		{
            // Banten
			"hc-key": "id-bt",
            "value": <?php echo myNum(get_total_by_prop(25));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(25));?>
        },
		{
            // Jakarta
			"hc-key": "id-jk",
            "value": <?php echo myNum(get_total_by_prop(21));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(21));?>
        },
		{
            // Jawa Barat
			"hc-key": "id-jr",
            "value": <?php echo myNum(get_total_by_prop(22));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(22));?>
        },
		{
            // Jawa Tengah
			"hc-key": "id-jt",
            "value": <?php echo myNum(get_total_by_prop(23));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(23));?>
        },
		{
            // Jawa Timur
			"hc-key": "id-ji",
            "value": <?php echo myNum(get_total_by_prop(24));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(24));?>
        },
		{
            // Yogyakarta
			"hc-key": "id-yo",
            "value": <?php echo myNum(get_total_by_prop(10));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(10));?>
        },
		{
            // Bali
			"hc-key": "id-ba",
            "value": <?php echo myNum(get_total_by_prop(26));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(26));?>
        },
		{
            // Nusa Tenggara Barat
			"hc-key": "id-nb",
            "value": <?php echo myNum(get_total_by_prop(27));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(27));?>
        },
		{
            // Nusa Tenggara Timur
			"hc-key": "id-nt",
            "value": <?php echo myNum(get_total_by_prop(11));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(11));?>
        },
		{
            // Kalimantan Barat
			"hc-key": "id-kb",
            "value": <?php echo myNum(get_total_by_prop(12));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(12));?>
        },
        {
            // Kalimantan Timur
			"hc-key": "id-ki",
            "value": <?php echo myNum(get_total_by_prop(15));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(15));?>
			
        },
		{
            // Kalimantan Tengah
			"hc-key": "id-kt",
            "value": <?php echo myNum(get_total_by_prop(13));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(13));?>
        },
        {
            // Kalimantan Selatan
			"hc-key": "id-ks",
            "value": <?php echo myNum(get_total_by_prop(14));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(14));?>
        },
		{
            // Sulawesi Utara
			"hc-key": "id-sw",
            "value": <?php echo myNum(get_total_by_prop(17));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(17));?>
        },
		{
            // Sulawesi Tengah
			"hc-key": "id-st",
            "value": <?php echo myNum(get_total_by_prop(18));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(18));?>
        },
		{
            // Gorontalo
			"hc-key": "id-go",
            "value": <?php echo myNum(get_total_by_prop(29));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(29));?>
        },
		{
            // Sulawesi Barat
			"hc-key": "id-sr",
            "value": <?php echo myNum(get_total_by_prop(30));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(30));?>
			
        },
        
        {
            // Sulawesi Selatan
			"hc-key": "id-se",
            "value": <?php echo myNum(get_total_by_prop(19));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(19));?>
        },
		 {
            "hc-key": "id-sg",
            "value": <?php echo myNum(get_total_by_prop(28));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(28));?>
        },
		{
            // Maluku Utara
			"hc-key": "id-la",
            "value": <?php echo myNum(get_total_by_prop(32));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(32));?>
        },
        {
            // Papua Barat
			"hc-key": "id-ib",
            "value": <?php echo myNum(get_total_by_prop(34));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(34));?>
        }, 
		{
            // Papua Barat
			"hc-key": "id-pa",
            "value": <?php echo myNum(get_total_by_prop(33));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(33));?>
        },
		{
            // Maluku
			"hc-key": "id-ma",
            "value": <?php echo myNum(get_total_by_prop(31));?>,
			"koperasi" : <?php echo myNum(get_total_kop_by_prop(31));?>
        }		
    ];

    // Initiate the chart
    $('#container').highcharts('Map', {
                 tooltip: {
                     formatter: function(){
                         var s = this.key + '<br/>';
                         s += 'Jumlah Anggota : ' + this.point.value+ '<br/>';
                         s += 'Jumlah koperasi : ' + this.point.koperasi;
                         return s;
                     },
                 },
		
		legend: {
            enabled: false
          },


        title : {
            text : 'Koperasi KAKRI'
        },

        subtitle : {
            text : 'Tahun 2016'
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
            name: 'valueKoperasi',
            states: {
                hover: {
                    color: '#007c2d'
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

</br></br>
<div class="row">
    <div class="col-md-12">
		<div id ="container"></div>
	</div>
</div>
<div class="row">
    <div class="col-md-12">
    <div class="panel panel-default" style="margin-top:-10px;">
        <div class="panel-heading">
            <div class="panel-title-box">
                <h3>Tabel Data KAKRI</h3>
                <span>Summary Jumlah Per Wilayah</span>
            </div>                                    
            <ul class="panel-controls" style="margin-top: 2px;">
                <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                <li><a href="<?php echo current_url();?>" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>                                       
            </ul>
        </div>
        <div class="panel-body panel-body-table">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                   <thead>
                    <tr>
                        <th width="30px">No</th>
                        <th>Wilayah</th>
                        <th width="80">Anggota</th>
                        <th width="80">Koperasi</th>
                    </tr>
                    </thead>
                   <tbody> 
                    <?php 
                    $no=1;$jumlah=0;
                    foreach ((array)$wilayah as $key => $value) {
                        echo "<tr>";
                        echo "<td><b>".($no++)."</b></td>";
                        echo "<td><b>".$value->name."</b></td>";
                        echo "<td align='right'><b>".$value->jumlah."</b></td>";
                        echo "<td align='right'><b>".get_total_kop_by_prop($value->propinsi_id)."</b></td>";
                        echo "</tr>";
                        if(trim($this->jCfg['search']['type'])=="detail"){
                            foreach ((array)get_rincian_kta_by_prov($value->propinsi_id) as $kp => $vp) {
                               echo "<tr>
                                <td></td>
                                <td>".$vp->nama."</td>
                                <td align='right'>".$vp->jumlah."</td>
                               </tr>";
                               $jumlah += $vp->jumlah;
							   $jumlah_koperasi += get_total_kop_by_prop($value->propinsi_id);
                            }
                        }else{
                            $jumlah += $value->jumlah;
 						    $jumlah_koperasi += get_total_kop_by_prop($value->propinsi_id);
                        }
                    }?>
                    <tr>
                        <td colspan="2"><b>JUMLAH</b></td>
                        <td align="right"><b><?php echo myNum($jumlah);?></b></td>
                        <td align="right"><b><?php echo myNum($jumlah_koperasi);?></b></td>
                    </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>   
	</div>
</div>
</body>
</html>
