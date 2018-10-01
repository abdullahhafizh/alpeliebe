<!DOCTYPE html>
<html lang="en" class="body-full-height">
<head>  
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/jquery/jquery.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <style type="text/css">
  @media print {
    h1 {
      font-family: 'Roboto', sans-serif;
      color:black;    
    }    
    .profpic {
      object-fit: cover;
      object-position: center;
      width: 185px;
      height: 240px;      
    }
    .pull-right {
      float: right;
    }    
    .hidden-print {
      display: none !important;
    }    
  }
  h1 {
    font-family: 'Roboto', sans-serif;
    color:black;    
  }  
  .profpic {
    object-fit: cover;
    object-position: center;
    width: 185px;
    height: 240px;    
  }
</style>
</head>
<body style="background-repeat: no-repeat;" background="<?php echo base_url()."assets/images/card.jpeg";?>">
  <nav style="position: fixed;bottom: 0;" class="hidden-print">
    <div class="container">
      <br>
      <button class="btn btn-success" id="btn_login"> Print </button>
      <button class="btn btn-danger" onclick="window.close()"> Cancel </button>      
    </div>
  </nav>
  <!-- <img src="<?php echo base_url()."assets/images/card.jpeg";?>"> -->
  <div class="kartu" id="kartu">    
    <?php $qrcode = generate_qr_code($noKartu);?>
    <br><br>      
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img class="col-md-offset-7 pull-right" style="width:145px;height:145px;" src="<?php echo $qrcode;?>">    
    <br><br><br><br><br><br><br><br><br><br><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img class="profpic col-md-offset-7 pull-right" src="<?php echo $profPic?>">
    <br><br><br><br><br><br><br><br><br><br><br><br>
    <b>
      <h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $namaLengkap;?></h1>
      <h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $noKartu;?></h1>
    </b>      
    <br><br><br><p></p>    
  </div>
  <div id="editor"></div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.14.0/printThis.min.js"></script>
<script type="text/javascript" src="http://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script>
<script type="text/javascript">  
  $(document).ready(function(){          
    $('#btn_login').click(function(){      
      // html2canvas(document.querySelector(".kartu")).then(canvas => {
      //   allowTaint: true,

      //   imagestring = canvas.toDataURL("image/png");
      //   console.log(imagestring);
      //   document.body.appendChild(canvas);
      //   canvas.toBlob(function(blob) {
      //     saveAs(blob, "Dashboard.png"); 
      //   });
      // });
      // html2canvas($("#widget"), {
      //   onrendered: function(canvas) {
      //     theCanvas = canvas;


      //     canvas.toBlob(function(blob) {
      //       saveAs(blob, "Dashboard.png"); 
      //     });
      //   }
      // });
      $("html").printThis({
  debug: false,               // show the iframe for debugging
  importCSS: true,            // import page CSS
  importStyle: true,         // import style tags
  printContainer: true,       // grab outer container as well as the contents of the selector  
  pageTitle: "",              // add title to print page    
  header: null,               // prefix to html
  footer: null,               // postfix to html
  base: false ,               // preserve the BASE tag, or accept a string for the URL
  formValues: true,           // preserve input/form values
  removeScripts: false,       // remove script tags from print content
  copyTagClasses: false       // copy classes from the html & body tag
});
//       // window.print();
//       // window.close();
});
  });
</script>
</html>
