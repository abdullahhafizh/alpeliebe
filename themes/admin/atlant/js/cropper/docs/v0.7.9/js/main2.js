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
    var $image2 = $("#img-container2 > img"),
        options = {
	  	  dragCrop: false,
		  movable: false,
          data: {
	    	x: 430,
	        y: 1280,
	        width: 560,
	        height: 390
          },
          preview: ".img-preview2",
          built: function () {
      	    $(this).cropper("zoom", 0.1);
      	  }
        };

    $image2.cropper(options).on({
      "build.cropper": function (e) {
        console.log(e.type);
      },
      "built.cropper": function (e) {
        console.log(e.type);
      }
    });

    $(document).on("click", "[data-method]", function () {
      var data = $(this).data();

      if (data.method) {
        $image2.cropper(data.method, data.option);
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
            $image2.cropper("reset", true).cropper("replace", blobURL);
            $inputImage.val("");
          } else {
            showMessage("Please choose an image file.");
          }
        }
      });
    } else {
      $inputImage.parent().remove();
    }

    $("#download").click(function () {
      window.open($image2.cropper("getDataURL"));
    });

    var $zoomWith = $("#zoomWith");

    $("#zoom").click(function () {
      $image2.cropper("zoom", $zoomWith.val());
    });


    var $rotateWith = $("#rotateWith");

    $("#rotate").click(function () {
      $image2.cropper("rotate", $rotateWith.val());
    });


    var $getDataInto = $("#getDataInto");

    $("#getData").click(function () {
      var data = $image2.cropper("getData"),
          val = "";

      try {
        val = JSON.stringify(data);
      } catch (e) {
        console.log(data);
      }

      $getDataInto.val(val);
    });


    var $setDataX = $("#setDataX"),
        $setDataY = $("#setDataY"),
        $setDataWidth = $("#setDataWidth"),
        $setDataHeight = $("#setDataHeight");

    $("#setData").click(function () {
      var data = {
            x: $setDataX.val(),
            y: $setDataY.val(),
            width: $setDataWidth.val(),
            height: $setDataHeight.val()
          };

      $image2.cropper("setData", data);
    });


    var $setAspectRatioWith = $("#setAspectRatioWith");

    $("#setAspectRatio").click(function () {
      $image2.cropper("setAspectRatio", $setAspectRatioWith.val());
    });


    var $replaceWith = $("#replaceWith");

    $("#replace").click(function () {
      $image2.cropper("replace", $replaceWith.val());
    });


    var $getImageDataInto = $("#getImageDataInto");

    $("#getImageData").click(function () {
      var data = $image2.cropper("getImageData"),
          val = "";

      try {
        val = JSON.stringify(data);
      } catch (e) {
        console.log(data);
      }

      $getImageDataInto.val(val);
    });


    var $dataURLInto = $("#dataURLInto"),
        $dataURLView = $("#dataURLView");

    $("#getDataURL").click(function () {
      var dataURL = $image2.cropper("getDataURL");

      $dataURLInto.text(dataURL);
      $dataURLView.html('<img src="' + dataURL + '">');
    });

    $("#getDataURL2").click(function () {
      var dataURL = $image2.cropper("getDataURL", "image/jpeg");

      $dataURLInto.text(dataURL);
      $dataURLView.html('<img src="' + dataURL + '">');
    });

    $("#getDataURL3").click(function () {
      var dataURL = $image2.cropper("getDataURL", {
            width: 160,
            height: 90
          });

      $dataURLInto.text(dataURL);
      $dataURLView.html('<img src="' + dataURL + '">');
    });

    $("#getDataURL4").click(function () {
      var dataURL = $image2.cropper("getDataURL", {
            width: 320,
            height: 180
          }, "image/jpeg", 0.8);

      $dataURLInto.text(dataURL);
      $dataURLView.html('<img src="' + dataURL + '">');
    });

    $(".docs-options :radio").on("change", function () {
      var $this = $(this);

      if ($this.is(":checked")) {
        options[$this.attr("name")] = $this.val() === "true" ? true : false;
        $image2.cropper("destroy").cropper(options);
      }
    });

    $("[data-toggle='tooltip']").tooltip();
  }());

  // Sidebar
  // -------------------------------------------------------------------------

//  (function () {
//    var $sidebar = $(".docs-sidebar"),
//        offset = $sidebar.offset(),
//        offsetTop = offset.top,
//        mainHeight = $sidebar.parents(".row").height() - $sidebar.height();
//
//    $(window).bind("scroll", function () {
//      var st = $(this).scrollTop();
//
//      if (st > offsetTop && (st - offsetTop) < mainHeight) {
//        $sidebar.addClass("fixed");
//      } else {
//        $sidebar.removeClass("fixed");
//      }
//    });
//  }());

  // Examples
  // -------------------------------------------------------------------------

  // Example 1
  $(".fixed-dragger-cropper > img").cropper({
    aspectRatio: 640 / 320, // 2 / 1
    autoCropArea: 0.6, // Center 60%
    multiple: false,
    dragCrop: false,
    dashed: false,
    movable: false,
    resizable: false,
    built: function () {
      $(this).cropper("zoom", 0.5);
    }
  });


  // Example 2
  var $image = $(".bootstrap-modal-cropper > img"),
      originalData = {};

  $("#bootstrap-modal").on("shown.bs.modal", function () {
    $image.cropper({
      multiple: true,
      data: originalData,
      done: function (data) {
        console.log(data);
      }
    });
  }).on("hidden.bs.modal", function () {
    originalData = $image.cropper("getData"); // Saves the data on hide
    $image.cropper("destroy");
  });

});
