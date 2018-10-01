$(document).ready(function(){
  login._init();
});

login = {
  _init : function(){
    $('#btn_login').click(function(){
      login.actLogin();
    });

    $('#login_pass').keypress(function(e) {
      if(e.which == 13) {
        login.actLogin();
      }
    });
  },
  actLogin : function(){
    $('#btn_login').html('Loading <i class="fa fa-spinner fa-pulse fa-fw"></i>');
    var request = $.ajax({
      url: AUTH_URL,
      type: "POST",
      data: {
        username      : $('#login_username').val(),
        password      : $('#login_pass').val(),
        captcha       : $('#login_captcha').val(),
        login         : true
      },
      dataType: "json"
    });

    request.done(function( obj ) {
      if(obj.status==0) {
        $('#alert_message').removeClass('alert-warning').addClass('alert-danger').fadeIn();
        $('#txt_message').html(obj.message);
        $('#login_username,#login_pass').val('');
        $('#login_username').focus();
      } else if(obj.status==2) {
        $('#alert_message').removeClass('alert-warning').addClass('alert-danger').fadeIn();
        $('#txt_message').html(obj.message);
        setTimeout(function() {
          document.location = obj.data.go_to;
        },2000);
      } else if(obj.status==3) {
        $('#login_username,#login_pass,#refresh,#login_captcha,#btn_login').attr('disabled','disabled');
        noty({
          text: obj.message,
          layout: 'topCenter',
          buttons: [
            {
              addClass: 'btn btn-success btn-clean', text: 'Iya', onClick: function($noty) {
                $noty.close();
                var req = $.ajax({
                  url: RESET_URL,
                  type: "POST",
                  data: {
                    uname		: obj.data.uname,
                    upassword	: obj.data.upassword,
                    reset		: true
                  },
                  dataType: "json"
                });
                req.done(function( o ) {
                  if(o.status==1) {
                    $('#alert_message').removeClass('alert-warning').addClass('alert-danger').fadeIn();
                    $('#txt_message').html(o.message);
                    setTimeout(function(){
                      document.location = o.data.go_to;
                    },2000);
                  }
                });
              }
            },{
              addClass: 'btn btn-danger btn-clean', text: 'Tidak', onClick: function($noty) {
                $noty.close();
                $('#login_username,#login_pass,#refresh,#login_captcha,#btn_login').removeAttr('disabled');
              }
            }
          ]
        });
      } else {
        $('#alert_message').removeClass('alert-danger').addClass('alert-warning').fadeIn();
        $('#txt_message').html(obj.message);
        document.location = obj.data.go_to;
      }
      $('#btn_login').html('Login');
      return false;
    });


        /*request.fail(function( jqXHR, textStatus ) {
          alert( "Request data id failed: " + textStatus );
           $('#btn_login').html('Login');
        });*/
    }
}
