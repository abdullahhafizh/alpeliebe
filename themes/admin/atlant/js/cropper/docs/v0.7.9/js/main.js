$(function () {

  "use strict";

  var console = window.console || { log: function () {} },
      $alert = $(".docs-alert"),
      $message = $alert.find(".message"),
      showMessage = function (message, type) {
        $message.text(message);

        if (type) {
          $message.addClass(type);
        }

        $alert.fadeIn();

        setTimeout(function () {
          $alert.fadeOut();
        }, 3000);
      };

  // Overview
  // -------------------------------------------------------------------------

  (function () {
    var $image = $("#img-container > img"),
        options = {
    	  data: { x: 65, y: 1300, width: 250, height: 340 },
          preview: ".img-preview"
        };

    $image.cropper(options).on({
      "build.cropper": function (e) {
        console.log(e.type);
      },
      "built.cropper": function (e) {
        console.log(e.type);
      }
    });

    $("#zoom_in,#zoom_out,#rotate_left,#rotate_right,#move").click(function () {
      var data = $(this).data();

      if (data.method) {
        $image.cropper(data.method, data.option);
      }
    });

    var $inputImage = $("#upload_lampiran_1"),
        blobURL;

    if (window.URL) {
      $inputImage.change(function () {
        var files = this.files,
            file;

        if (files && files.length) {
          file = files[0];

          if (/^image\/\w+$/.test(file.type)) {
            if (blobURL) {
              URL.revokeObjectURL(blobURL); // Revoke the old one
            }

            blobURL = URL.createObjectURL(file);
            $image.cropper("reset",true)
	            .cropper("replace", blobURL)
	            .cropper("setData", { x: 65, y: 1300, width: 250, height: 340 });
            
            $('#links').html("");
            $('#num').val(1);
            $("#download").removeAttr('disabled');
        	$('#panel-crop').css('opacity','1');
          } else {
            showMessage("Please choose an image file.");
          }
        }
      });
    } else {
      $inputImage.parent().remove();
    }

    $('#btn-reset').click(function () {
    	var links = $('#links'),
    		input = links.find('input:text');;
    	
		links.html('');
		input.val('');
		$('#num').val(1);
		$('#download').removeAttr('disabled');
		$(this,'#btn-save').attr('disabled','disabled');
    	$('#panel-result').css('opacity','0.2');
    });

    $('#download').click(function () {
    	$('#modal_choose').slideDown(); 
    });

    $('#btn-type').click(function () {
    	var dataURL = $image.cropper('getDataURL'),   	
    		co = $("input[name='crop_option']:checked").val(),
    		label = co == 'wajah'?'Pas Foto':'KTP';
    	
    	if($('#img-'+co).length) $('#img-'+co).remove();    		
        $('#links').append('<a class="gallery-item" href="javascript:void(0)" id="img-'+co+'" data-gallery>'+
			'<div class="image">'+
			'	<img src="' + dataURL + '" alt=""/>'+
			'	<div class="meta">'+
			'		<strong>'+label+'</strong>'+
			'	</div>'+
			'</div>'+
			'<input type="hidden" name="data_'+co+'" value="' + dataURL + '"></a>');
        
    	$('#panel-result').css('opacity','1');
		$('#btn-reset').removeAttr('disabled');
		$("#btn-save").removeAttr('disabled');
		$('#modal_choose').slideUp(); 
    });
    
  }());
});
