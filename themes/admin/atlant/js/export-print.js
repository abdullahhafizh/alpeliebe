EXPORT_PRINT = {
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
    		    EXPORT_PRINT.fillCity(obj.city);
    	    });
	    });
	    
	    $("#city").change(function(){
    	    $.post(URL_GET_DATA_DISTRICT,{id:$(this).val()},function(o){
    		    obj = eval('('+o+')');
    		    EXPORT_PRINT.fillDistrict(obj.district);
    	    });
	    });
	    	            
		$('#show_data').click(function(){
	    	pageLoadingFrame("show");	
	        
			var dt = new Date(),
				d = dt.getDate()<10?'0'+dt.getDate():dt.getDate(),
				m = dt.getMonth()<9?'0'+(dt.getMonth()+1):(dt.getMonth()+1),
				y = dt.getFullYear(),
				h = dt.getHours()<9?'0'+(dt.getHours()+1):(dt.getHours()+1),
				n = dt.getMinutes()<10?'0'+dt.getMinutes():dt.getMinutes(),
				s = dt.getSeconds()<10?'0'+dt.getSeconds():dt.getSeconds(),
				newdate = d+''+m+''+y+''+h+''+n+''+s;
			
	    	$('#list-data,#download-file').hide();
	        $.post(URL_CHECK_PROPOSER,{proposer:$("#quick-search").val()},function(o){
	        	if(o > 0 || $("#quick-search").val() == '') {
	        		EXPORT_PRINT.showData(0,$("#limit").val(),$("#quick-search").val(),$("#province").val(),$("#city").val());
	        		EXPORT_PRINT.fileArchive(0,$("#limit").val(),$("#quick-search").val(),$("#province").val(),$("#city").val(),'DataCetakAnggota-'+$("#quick-search").val()+'-'+newdate+'.xlsx','DataFoto-'+$("#quick-search").val()+'-'+newdate,newdate);
	        		EXPORT_PRINT.genReportExcel(0,$("#limit").val(),"",$("#quick-search").val(),$("#province").val(),$("#city").val(),'DataCetakAnggota-'+$("#quick-search").val()+'-'+newdate+'.xlsx','DataFoto-'+$("#quick-search").val()+'-'+newdate,newdate);
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
    showData: function(offset,limit,proposer,province,city){
    	html = ''; ap=$('#data-print');
    	ap.html('');

        $.post(URL_SHOW_DATA,{offset:offset,limit:limit,proposer:proposer,province:province,city:city},function(o){
            x = eval('('+o+')');
            
            obj = x.data;
        	$('#list-data').fadeIn();        	
            if( x.status == 1 ){
            	
        	    if(obj.length > 0){
        		    no=0; id = '';
        	    	$.each(obj,function(k,v){
        	    		 no++;
        		    	 html ='<tr>';
        			     html +='<td>'+no+'</td>';
        			     html +='<td nowrap="nowrap">'+v.kta_nomor_kartu.substr(0,6)+" "+v.kta_nomor_kartu.substr(6,4)+" "+v.kta_nomor_kartu.substr(10,6)+'</td>';
        			     html +='<td nowrap="nowrap">'+v.kta_nama_lengkap+'</td>';
        			     html +='<td nowrap="nowrap">'+((v.propinsi_nama != null)?v.propinsi_nama:'')+'</td>';
        			     html +='<td nowrap="nowrap">'+((v.kab_nama != null)?v.kab_nama:'')+'</td>';
        				 html += '</tr>';
        				 ap.append(html); 
        	    	});
        	    }else{
        		    ap.html('<tr><td colspan="5">Data tidak ditemukan</td></tr>');
        	    }
        	    
            }else{
    		    ap.html('<tr><td colspan="5">Data tidak ditemukan</td></tr>');
    	    }
        	pageLoadingFrame("hide");
        });
	},
    fileArchive: function(offset,limit,proposer,province,city,excelfile,zipfile,newdate){
        $.post(URL_FILE_ARCHIVE,{offset:offset,limit:limit,proposer:proposer,province:province,city:city,excelfile:excelfile,zipfile:zipfile,newdate:newdate});
	},
    genReportExcel: function(offset,limit,filename,proposer,province,city,excelfile,zipfile,newdate){
		$('#kta-ids,#count').val('');	
        $.post(URL_EXPORT_EXCEL,{offset:offset,limit:limit,filename:filename,proposer:proposer,province:province,city:city,excelfile:excelfile,zipfile:zipfile,newdate:newdate},function(o){
            obj = eval('('+o+')');
            if( obj.status == 1 ){
            	$('#download-file').show();
    	    	$('#kta-ids').val(obj.ids);
    	    	$('#count').val(obj.count);
    	    	$('#filezip').val(obj.filezip);
            }
        });
    },
    downloadFile: function(){
        $.post(URL_UPDATE_DATA,{id:$("#kta-ids").val(),proposer:$("#quick-search").val(),count:$("#count").val()},function(o){
		    obj = eval('('+o+')');		    
        	if(obj.status == 1) {
        		window.location.href = URL_DOWNLOAD+''+$('#filezip').val();

        		setTimeout(function(){
        			document.location = obj.go_to;
              },5000);        		
        	}
        });
    }

}

$(document).ready(function(){
    EXPORT_PRINT.init();
});