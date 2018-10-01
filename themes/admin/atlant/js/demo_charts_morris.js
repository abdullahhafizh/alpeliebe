var morrisCharts = function() {
    if($('#morris-line-example').length>0){
        Morris.Line({
          element: 'morris-line-example',
          data: [
            { y: '2001', a: 100, b: 90 },
            { y: '2002', a: 75,  b: 65 },
            { y: '2003', a: 50,  b: 40 },
            { y: '2004', a: 75,  b: 65 },
            { y: '2005', a: 50,  b: 40 },
            { y: '2006', a: 75,  b: 65 },
            { y: '2007', a: 56, b: 45 },
            { y: '2008', a: 77, b: 60 },
            { y: '2009', a: 46, b: 30 },
            { y: '2010', a: 76, b: 60 },
            { y: '2011', a: 44, b: 40 },
            { y: '2012', a: 42, b: 30 },
            { y: '2013', a: 65, b: 50 },
            { y: '2014', a: 53, b: 50 },
            { y: '2015', a: 86, b: 70 },
            { y: '2016', a: 98, b: 80 },
            { y: '2017', a: 37, b: 30 },
            { y: '2018', a: 55, b: 50 },
            { y: '2019', a: 63, b: 60 },
            { y: '2020', a: 87, b: 80 },
            { y: '2021', a: 26, b: 40 },
            { y: '2022', a: 75, b: 50 },
            { y: '2023', a: 54, b: 30 },
            { y: '2024', a: 93, b: 60 },
            { y: '2025', a: 37, b: 40 }
          ],
          xkey: 'y',
          ykeys: ['a', 'b'],
          labels: ['Umum', 'Atlet'],
          resize: true,
          lineColors: ['#FE4A3F', '#95B75D']
        });

    }
    /*Morris.Area({
        element: 'morris-area-example',
        data: [
            { y: '2006', a: 100, b: 90 },
            { y: '2007', a: 75,  b: 65 },
            { y: '2008', a: 50,  b: 40 },
            { y: '2009', a: 75,  b: 65 },
            { y: '2010', a: 50,  b: 40 },
            { y: '2011', a: 75,  b: 65 },
            { y: '2012', a: 100, b: 90 }
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        resize: true,
        lineColors: ['#3FBAE4', '#FEA223']
    });


    Morris.Bar({
        element: 'morris-bar-example',
        data: [
            { y: '2006', a: 100, b: 90 },
            { y: '2007', a: 75,  b: 65 },
            { y: '2008', a: 50,  b: 40 },
            { y: '2009', a: 75,  b: 65 },
            { y: '2010', a: 50,  b: 40 },
            { y: '2011', a: 75,  b: 65 },
            { y: '2012', a: 100, b: 90 }
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        barColors: ['#B64645', '#33414E']
    });


    Morris.Donut({
        element: 'morris-donut-example',
        data: [
            {label: "Laki-Laki", value: 45},
            {label: "Perempuan", value: 55},
        ],
        colors: ['#95B75D', '#3FBAE4']
    });*/

}();