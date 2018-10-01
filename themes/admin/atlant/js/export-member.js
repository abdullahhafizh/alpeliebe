EXPORT_MEMBER = {
    init: function(){
		var data = $.ajax({type:'GET', url:URL_GET_PROPOSER,async:false}).responseText,
			dataProposer = JSON.parse(data);
	
	    $("#quick-search").autocomplete({
	        source: dataProposer,
	        open: function(event, ui) {
	            
	            var autocomplete = $(".ui-autocomplete:visible");
	            var oldTop = autocomplete.offset().top;
	            var newTop = oldTop - $("#quick-search").height() + 25;
	            autocomplete.css("top", newTop);
	            
	        }
	    }).blur(function(){
	    	if($(this).val() != '')
	    		$('#alert-not-found').fadeOut('slow');
	    });
	    
	    $("#province").change(function(){
    	    $.post(URL_GET_DATA_CITY,{id:$(this).val()},function(o){
    		    obj = eval('('+o+')');
    		    EXPORT_MEMBER.fillCity(obj.city);
    	    });
	    });
	    
	    $("#city").change(function(){
    	    $.post(URL_GET_DATA_DISTRICT,{id:$(this).val()},function(o){
    		    obj = eval('('+o+')');
    		    EXPORT_MEMBER.fillDistrict(obj.district);
    	    });
	    });
	    
	    $("#district").change(function(){
    	    $.post(URL_GET_DATA_AREA,{id:$(this).val()},function(o){
    		    obj = eval('('+o+')');
    		    EXPORT_MEMBER.fillArea(obj.area);
    	    });
	    });
	    	            
		$('#generate_report').click(function(){        
	    	pageLoadingFrame("show");
	    	$('#form-link').hide();
	        $.post(URL_CHECK_PROPOSER,{proposer:$("#quick-search").val()},function(o){
	        	if(o > 0 || $("#quick-search").val() == '') {
					EXPORT_MEMBER.genReportExcel(0,"",$("#quick-search").val(),$("#province").val(),$("#city").val(),$("#district").val(),$("#area").val());
					EXPORT_MEMBER.genReportPDF(0,"",$("#quick-search").val(),$("#province").val(),$("#city").val(),$("#district").val(),$("#area").val());
	        	} else {
	        		$('#alert-not-found').fadeIn('slow');        
	    	    	pageLoadingFrame("hide");
	        	}
	        });            
		});
    },
	fillCity: function(obj) { 
    	ap=$('#city');
    	
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
    	ap=$('#district');
    	
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
    	ap=$('#area');
    	
    	ap.empty();
    	html = '<option value=""> - pilih kelurahan - </option>';
	    if(obj.length > 0){
		    
	    	$.each(obj,function(k,v){
				 html += '<option value="'+v.kel_kode+'">'+v.kel_nama+'</option>';				 
	    	});	    	
	    	
	    }
    	ap.append(html);
    	ap.selectpicker('refresh');
	},
    genReportExcel: function(offset,filename,proposer,province,city,district,area){
        $.post(URL_EXPORT_EXCEL,{limit:500,offset:offset,filename:filename,proposer:proposer,province:province,city:city,district:district,area:area},function(o){
            obj = eval('('+o+')');
           if( obj.status == 1 ){
               EXPORT_MEMBER.genReportExcel(obj.data.offset,obj.data.filename,obj.data.proposer,obj.data.province,obj.data.city,obj.data.district,obj.data.area);
           } else {
            	$('#form-link').show();
            	$('#link-excel').fadeIn();
             }
        });
    },
    genReportPDF: function(offset,filename,proposer,province,city,district,area){
    	$.post(URL_EXPORT_PDF,{limit:200,offset:offset,filename:filename,proposer:proposer,province:province,city:city,district:district,area:area},function(o){
            obj = eval('('+o+')');
           if( obj.status == 1 ){
               EXPORT_MEMBER.genReportPDF(obj.data.offset,obj.data.filename,obj.data.proposer,obj.data.province,obj.data.city,obj.data.district,obj.data.area);
           } else {
            	$('#form-link').show();
            	$('#link-pdf').fadeIn();
            	pageLoadingFrame("hide");
           }
        });
    }

}

$(document).ready(function(){
    EXPORT_MEMBER.init();
});