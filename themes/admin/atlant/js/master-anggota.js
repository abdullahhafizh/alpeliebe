MASTER_MEMBER = {
    init: function(){
		var data = $.ajax({type:'GET', url:URL_GET_PROPOSER,async:false}).responseText,
			dataProposer = JSON.parse(data);
	
	    $("#pengusul").autocomplete({
	        source: dataProposer,
	        open: function(event, ui) {
	            
	            var autocomplete = $(".ui-autocomplete:visible");
	            var oldTop = autocomplete.offset().top;
	            var newTop = oldTop - $("#pengusul").height() + 25;
	            autocomplete.css("top", newTop);
	            
	        }
	    }).blur(function(){
	    	if($(this).val() != '')
	    		$('#alert-not-found').fadeOut('slow');
	    });
	    
	    $("#province").change(function(){
	    	MASTER_MEMBER.fillCity($(this).val());
	    });
	    
	    $("#city").change(function(){
		    MASTER_MEMBER.fillDistrict($(this).val());
	    });
	    
	    $("#district").change(function(){
		    MASTER_MEMBER.fillArea($(this).val());
	    });

	    $('#select_all').click(function(event) {  //on click 
	        if(this.checked) { // check select status
	            $('.chk_item').each(function() { //loop through each checkbox
	                this.checked = true;  //select all checkboxes with class "checkbox1"               
	            });
	        }else{
	            $('.chk_item').each(function() { //loop through each checkbox
	                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
	            });         
	        }
	    });

	    if(SEARCH_CITY != 0) {
	    	MASTER_MEMBER.fillCity($('#province').val(),SEARCH_CITY);
	    	MASTER_MEMBER.fillDistrict(SEARCH_CITY);
	    }
	    
	    if(SEARCH_DISTRICT != 0) {
	    	MASTER_MEMBER.fillDistrict($('#city').val(),SEARCH_DISTRICT);
	    	MASTER_MEMBER.fillArea(SEARCH_DISTRICT);
	    }
	    
	    if(SEARCH_AREA != 0)
	    	MASTER_MEMBER.fillArea($('#district').val(),SEARCH_AREA);
    },
	fillCity: function(id,val) {
	    $.post(URL_GET_DATA_CITY,{id:id},function(o){
		    arrobj = eval('('+o+')');
		    obj = arrobj.city;
		    ap=$('#city');
	    	
	    	ap.empty();
	    	html = '<option value=""> - pilih kabupaten/kota - </option>';
		    if(obj.length > 0){
			    
		    	$.each(obj,function(k,v){
		    		var s = v.kab_kode == val?'selected="selected"':'';
					html += '<option value="'+v.kab_kode+'" '+s+'>'+v.kab_nama+'</option>';				 
		    	});	    	
		    	
		    }
	    	ap.append(html);
	    	ap.selectpicker('refresh');
	    });
	},
	fillDistrict: function(id,val) {
	    $.post(URL_GET_DATA_DISTRICT,{id:id},function(o){
	    	arrobj = eval('('+o+')');
		    obj = arrobj.district;		    
	    	ap=$('#district');
	    	
	    	ap.empty();
	    	html = '<option value=""> - pilih kecamatan - </option>';
		    if(obj.length > 0){
			    
		    	$.each(obj,function(k,v){
		    		var s = v.kec_kode == val?'selected="selected"':'';
					html += '<option value="'+v.kec_kode+'" '+s+'>'+v.kec_nama+'</option>';				 
		    	});	    	
		    	
		    }
	    	ap.append(html);
	    	ap.selectpicker('refresh');
	    });
	},
	fillArea: function(id,val) {
	    $.post(URL_GET_DATA_AREA,{id:id},function(o){
	    	arrobj = eval('('+o+')');
		    obj = arrobj.area;
	    	ap=$('#area');
	    	
	    	ap.empty();
	    	html = '<option value=""> - pilih kelurahan - </option>';
		    if(obj.length > 0){
			    
		    	$.each(obj,function(k,v){
		    		var s = v.kel_kode == val?'selected="selected"':'';
					 html += '<option value="'+v.kel_kode+'" '+s+'>'+v.kel_nama+'</option>';				 
		    	});	    	
		    	
		    }
	    	ap.append(html);
	    	ap.selectpicker('refresh');
	    }); 
	}   

}

$(document).ready(function(){
    MASTER_MEMBER.init();
});