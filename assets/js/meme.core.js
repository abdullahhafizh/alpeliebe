$(document).ready(function(){
	$('.act_confirm').each(function(){
		$(this).click(function(m){
			m.preventDefault();
			url 	= $(this).attr('href');
			body 	= $(this).attr('data-body') == undefined?'Apakah Anda Yakin ?':$(this).attr('data-body');
			title 	= $(this).attr('data-title') == undefined?'Confirm':$(this).attr('data-title');
			icon 	= $(this).attr('data-icon') == undefined?'fa-warning':$(this).attr('data-icon');
			desc 	= $(this).attr('data-desc') == undefined?'':$(this).attr('data-desc');

			MEME.confirm({
				url:url,
				body:body,
				title:title,
				desc:desc,
				icon:icon
			});

		});
	});

	$('.act_info').each(function(){
		$(this).click(function(m){
			m.preventDefault();
			body 	= $(this).attr('data-body') == undefined?'Information':$(this).attr('data-body');
			title 	= $(this).attr('data-title') == undefined?'Information':$(this).attr('data-title');
			icon 	= $(this).attr('data-icon') == undefined?'fa-info':$(this).attr('data-icon');
			desc 	= $(this).attr('data-desc') == undefined?'':$(this).attr('data-desc');

			MEME.information({
				body:body,
				title:title,
				icon:icon,
				desc:desc
			});

		});
	});

	$('.act_modal').each(function(){
		$(this).click(function(m){
			m.preventDefault();
			url 	= $(this).attr('href');
			body 	= $(this).attr('data-body') == undefined?'':$(this).attr('data-body');
			title 	= $(this).attr('data-title') == undefined?'Data':$(this).attr('data-title');
			icon 	= $(this).attr('data-icon') == undefined?'fa-camera-retro':$(this).attr('data-icon');
			size 	= $(this).attr('data-size') == undefined?$(document).height()-50+'|400':$(this).attr('data-size');

			MEME.modal({
				body:body,
				url:url,
				size:size.split("|"),
				title:title,
				icon:icon
			});

		});
	});

});
MEME = {
	
	information : function(p){
		obj = $('#mb-custom-meme');
		$('#mb-custom-meme .mb-container').removeClass('topm_200');
		$('#title-mb-meme').html('<span class="fa '+p.icon+'"></span><strong>'+p.title+'</strong>');
		ctn = '<p>'+p.body+'</p>';
		if($.trim(p.desc)!=""){
			ctn += '<p>'+p.desc+'</p>';
		}
		obj.removeClass('message-box-danger').removeClass('message-box-success').removeClass('message-box-info').removeClass('message-box-warning');
		obj.addClass('message-box-info');
		$('#content-mb-meme').html(ctn);

		btn = '<button class="btn btn-default btn-lg" onclick="$(\'#mb-custom-meme\').hide();return false;" style="margin-left:20px;">Tutup</button>';
		$('#btn-mb-meme').html(btn);
		playAudio('alert');
		obj.show();
		return false;

	},
	confirm : function(p){
		obj = $('#mb-custom-meme');
		$('#mb-custom-meme .mb-container').removeClass('topm_200');
		$('#title-mb-meme').html('<span class="fa '+p.icon+'"></span><strong>'+p.title+'</strong>');
		ctn = '<p>'+p.body+'</p>';
		if($.trim(p.desc)!=""){
			ctn += '<p>'+p.desc+'</p>';
		}
		obj.removeClass('message-box-danger').removeClass('message-box-success').removeClass('message-box-info').removeClass('message-box-warning');
		obj.addClass('message-box-warning');
		$('#content-mb-meme').html(ctn);

		btn = '<a href="'+p.url+'" class="btn btn-success btn-lg">Ya</a>';
		btn += '<button class="btn btn-default btn-lg" onclick="$(\'#mb-custom-meme\').hide();return false;" style="margin-left:20px;">Tidak</button>';
		$('#btn-mb-meme').html(btn);
		playAudio('alert');
		obj.show();
		return false;
	},
	modal : function(p){
		obj = $('#mb-custom-meme');
		$('#mb-custom-meme .mb-container').addClass('topm_200');
		$('#title-mb-meme').html('<span class="fa '+p.icon+'"></span><strong>'+p.title+'</strong>');
		ctn = "<iframe frameborder='0' width='"+p.size[0]+"px' height='"+p.size[1]+"px' src='"+p.url+"' ></iframe>";
		ctn += '<p>'+p.body+'</p>';
		if($.trim(p.desc)!=""){
			ctn += '<p>'+p.desc+'</p>';
		}
		obj.removeClass('message-box-danger').removeClass('message-box-success').removeClass('message-box-info').removeClass('message-box-warning');
		obj.addClass('message-box-success');
		$('#content-mb-meme').html(ctn);

		btn = '<button class="btn btn-default btn-lg" onclick="$(\'#mb-custom-meme\').hide();return false;" style="margin-left:20px;">Tutup</button>';
		$('#btn-mb-meme').html(btn);
		playAudio('alert');
		obj.show();
		return false;
	}
}
