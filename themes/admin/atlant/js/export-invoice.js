EXPORT_INVOICE = {
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
	    	            
		$('#show_data').click(function(){        
	    	pageLoadingFrame("show");	
	    	$('#list-data,#download-file').hide();
	        $.post(URL_CHECK_PROPOSER,{proposer:$("#quick-search").val()},function(o){
	        	if(o > 0 || $("#quick-search").val() == '') {
	        		EXPORT_INVOICE.showData($("#quick-search").val());
	        	} else {
	        		$('#alert-not-found').fadeIn('slow');        
	    	    	pageLoadingFrame("hide");
	        	}
	        });            
		});
		
		$("#select_all").change(function(){
			if(this.checked){
				$(".selects").each(function(){
					this.checked=true;
				}); 
			} else {
				$(".selects").each(function(){
					this.checked=false;
				}); 
			}
		});
		
		$('#gen-invoice').click(function(){        
	    	pageLoadingFrame("show");	
			$('#alert-not-select').fadeOut();
			var idc = '', flag = 0;
			$(".selects").each(function(){
				if(this.checked) {
					idc += ((idc=='')?'':',')+$(this).val();
					flag = 1;
				}
			}); 

			if(flag == 1) {
		        $.post(URL_GEN_INVOICE,{proposer:$("#quick-search").val(),receiver:$("#to").val(),idc:idc},function(o){
	    		    obj = eval('('+o+')');
	    		    
		        	if(obj.status == 1) {
		            	$('#download-file').show();
		            	$('#invcode').val(obj.invcode);
		            	$('#proposerid').val(obj.proposerid);
		            	$('#printids').val(obj.printids);
		            	$('#qty').val(obj.qty);
		            	$('#weight').val(obj.weight);
		            	$('#receiver').val(obj.receiver);
		            	$('#cost').val(obj.cost);
		            	$('#price').val(obj.price);
		            	$('#filepdf').val(obj.filepdf);
		        	}
		            
	    	    	pageLoadingFrame("hide");
		        });  
			} else $('#alert-not-select').fadeIn();
		});
    },
    checkUncheck: function(id) {
		if (!$('#'+id).is(":checked")){
			$("#select_all").prop("checked", false);
		} else {
			var flag = 0;
	
			$(".selects").each(function(){
				if(!this.checked)
					flag=1;
			});
			
			if(flag == 0){ $("#select_all").prop("checked", true);}
		}
    },
    showData: function(proposer){
    	html = ''; ap=$('#data-print');
    	ap.html('');

        $.post(URL_SHOW_DATA,{proposer:proposer},function(o){
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
        			     html +='<td><input type="checkbox" id="select_'+no+'" class="selects" onclick="EXPORT_INVOICE.checkUncheck(\'select_'+no+'\')" value="'+v.cetak_id+'"></td>';
        			     html +='<td nowrap="nowrap">'+v.cetak_kode+'</td>';
        			     html +='<td nowrap="nowrap">'+v.cetak_jumlah+'</td>';
        			     html +='<td nowrap="nowrap">'+v.nama_pengguna+'</td>';
        			     html +='<td nowrap="nowrap">'+v.cetak_tanggal+'</td>';
        				 html += '</tr>';
        				 ap.append(html); 
        	    	});
        	    	$('#count').val(no);
        	    }else{
        		    ap.html('<tr><td colspan="6">Data tidak ditemukan</td></tr>');
        	    }
        	    
            }else{
    		    ap.html('<tr><td colspan="6">Data tidak ditemukan</td></tr>');
    	    }
        	pageLoadingFrame("hide");
        });
	},
    downloadFile: function(){
        $.post(URL_UPDATE_DATA,{
        	invcode:$("#invcode").val(),
        	proposerid:$("#proposerid").val(),
        	printids:$("#printids").val(),
        	qty:$("#qty").val(),
        	weight:$("#weight").val(),
        	receiver:$("#receiver").val(),
        	cost:$("#cost").val(),
        	price:$("#price").val()
        },function(o){
		    obj = eval('('+o+')');		    
        	if(obj.status == 1) {
        		window.location.href = URL_DOWNLOAD+''+$('#filepdf').val();
				/* var a = document.createElement('a');
				
				a.href=URL_DOWNLOAD+''+$('#filepdf').val();
				a.target = '_blank';
				document.body.appendChild(a);
				a.click(); */
				
        		setTimeout(function(){
        			document.location = obj.go_to;
              },5000);        		
        	}
        });
    }

}

$(document).ready(function(){
    EXPORT_INVOICE.init();
});