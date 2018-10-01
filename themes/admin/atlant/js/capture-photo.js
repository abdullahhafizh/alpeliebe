EXPORT_MEMBER = {
    init: function(){

	  var fstreaming = false,
	    fvideo = document.querySelector('#fvideo'),
	    fcanvas = document.querySelector('#fcanvas'),
	    ftext = document.querySelector('#ftext'),
	    ftake = document.querySelector('#ftake'),
	    fwidth = 300,
	    fheight = 0;
	  var cstreaming = false,
	  	cvideo = document.querySelector('#cvideo'),
	    ccanvas = document.querySelector('#ccanvas'),
	    ctext = document.querySelector('#ctext'),
	    ctake = document.querySelector('#ctake'),
	    cwidth = 300,
	    cheight = 0;

	  navigator.getMedia = (navigator.getUserMedia ||
	    navigator.webkitGetUserMedia ||
	    navigator.mozGetUserMedia ||
	    navigator.msGetUserMedia);

	  navigator.getMedia({
	      video: true,
	      audio: false
	    },
	    function(stream) {
	      if (navigator.mozGetUserMedia) {
	          fvideo.mozSrcObject = stream;
	          cvideo.mozSrcObject = stream;
	      } else {
	        var vendorURL = window.URL || window.webkitURL;
	        fvideo.src = vendorURL.createObjectURL(stream);
	        cvideo.src = vendorURL.createObjectURL(stream);
	      }
	      fvideo.play();
	      cvideo.play();
	    },
	    function(err) {
	      console.log("An error occured! " + err);
	    }
	  );

	  fvideo.addEventListener('canplay', function(ev) {
	    if (!fstreaming) {
	      fheight = fvideo.videoHeight / (fvideo.videoWidth / fwidth);
	      fvideo.setAttribute('width', fwidth);
	      fvideo.setAttribute('height', fheight);
	      fcanvas.setAttribute('width', fwidth);
	      fcanvas.setAttribute('height', fheight);
	      fstreaming = true;
	    }
	  }, false);

	  cvideo.addEventListener('canplay', function(ev) {
	    if (!cstreaming) {
	      cheight = cvideo.videoHeight / (cvideo.videoWidth / cwidth);
	      cvideo.setAttribute('width', cwidth);
	      cvideo.setAttribute('height', cheight);
	      ccanvas.setAttribute('width', cwidth);
	      ccanvas.setAttribute('height', cheight);
	      cstreaming = true;
	    }
	  }, false);

	  function takefacepicture() {
	    fvideo.style.display = "none";
	    fcanvas.style.display = "block";
	    ftake.innerText= "RETAKE WAJAH";
	    fcanvas.width = 169;
	    fcanvas.height = 225;
	    fcanvas.getContext('2d').drawImage(fvideo, 0, 0, fwidth, fheight);
	    var data = fcanvas.toDataURL('image/png');
	    ftext.setAttribute('value', data);
	  }

	  function takecardidpicture() {
	    cvideo.style.display = "none";
	    ccanvas.style.display = "block";
	    ctake.innerText= "RETAKE KTP";
	    ccanvas.width = cwidth;
	    ccanvas.height = cheight;
	    ccanvas.getContext('2d').drawImage(cvideo, 0, 0, cwidth, cheight);
	    var data = ccanvas.toDataURL('image/png');
	    ctext.setAttribute('value', data);
	  }

	  ftake.addEventListener('click', function(ev) {
	    if(ftake.innerText==="CAPTURE WAJAH")
	    {
	    	takefacepicture();
	    }
	    else
	    {
	        fvideo.style.display = "block";
	        fcanvas.style.display = "none";
	        ftext.setAttribute('value', '');
	        ftake.innerText= "CAPTURE WAJAH";
	    }
	    ev.preventDefault();
	  }, false);


	  ctake.addEventListener('click', function(ev) {
	    if(ctake.innerText==="CAPTURE KTP")
	    {
	    	takecardidpicture();
	    }
	    else
	    {
	        cvideo.style.display = "block";
	        ccanvas.style.display = "none";
	        ctext.setAttribute('value', '');
	        ctake.innerText= "CAPTURE KTP";
	    }
	    ev.preventDefault();
	  }, false);
	    
	    $("#btn-save").click(function(){
	    	if($('#ftext').val() == '' && $('#ctext').val() == '')
	    		$('#fwarning,#cwarning').slideDown();
	    	else if($('#ftext').val() == '')
	    		$('#cwarning').slideDown();
	    	else if($('#ctext').val() == '')
	    		$('#cwarning').slideDown();
	    	else 
	    		$("#form-validated").submit();
	    });
	    
	    $("#kta_propinsi").change(function(){
    	    $.post(URL_GET_DATA_CITY,{id:$(this).val()},function(o){
    		    obj = eval('('+o+')');
    		    EXPORT_MEMBER.fillCity(obj.city);
    	    });
	    });
	    
	    $("#kta_kabupaten").change(function(){
    	    $.post(URL_GET_DATA_DISTRICT,{id:$(this).val()},function(o){
    		    obj = eval('('+o+')');
    		    EXPORT_MEMBER.fillDistrict(obj.district);
    	    });
	    });
	    
	    $("#kta_kecamatan").change(function(){
    	    $.post(URL_GET_DATA_AREA,{id:$(this).val()},function(o){
    		    obj = eval('('+o+')');
    		    EXPORT_MEMBER.fillArea(obj.area);
    	    });
	    });
    },
	fillCity: function(obj) { 
    	ap=$('#kta_kabupaten');
    	
    	ap.empty();
    	html = '<option value=""> - pilih kabupaten/kota - </option>';
	    if(obj.length > 0){
		    
	    	$.each(obj,function(k,v){
				 html += '<option value="'+v.kab_kode+'">'+v.kab_nama+'</option>';				 
	    	});	    	
	    	
	    }
    	ap.append(html);
    	ap.selectpicker('refresh');
	},
	fillDistrict: function(obj) { 
    	ap=$('#kta_kecamatan');
    	
    	ap.empty();
    	html = '<option value=""> - pilih kecamatan - </option>';
	    if(obj.length > 0){
		    
	    	$.each(obj,function(k,v){
				 html += '<option value="'+v.kec_kode+'">'+v.kec_nama+'</option>';				 
	    	});	    	
	    	
	    }
    	ap.append(html);
    	ap.selectpicker('refresh');
	},
	fillArea: function(obj) { 
    	ap=$('#kta_kelurahan');
    	
    	ap.empty();
    	html = '<option value=""> - pilih kelurahan - </option>';
	    if(obj.length > 0){
		    
	    	$.each(obj,function(k,v){
				 html += '<option value="'+v.kel_kode+'">'+v.kel_nama+'</option>';				 
	    	});	    	
	    	
	    }
    	ap.append(html);
    	ap.selectpicker('refresh');
	}  

}

$(document).ready(function(){
    EXPORT_MEMBER.init();
});