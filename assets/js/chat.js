/*

Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)

This script may be used for non-commercial purposes only. For any
commercial purposes, please contact the author at 
anant.garg@inscripts.com

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

*/

var windowFocus = true;
var username;
var chatHeartbeatCount = 0;
var minChatHeartbeat = 1000;
var maxChatHeartbeat = 3300;
var chatHeartbeatTime = minChatHeartbeat;
var originalTitle;
var blinkOrder = 0;

var minChatOut = 5000;
var chatOutTime = minChatOut;

var minStatus = 2000;
var checkStatusTime = minStatus;

var chatboxFocus = new Array();
var newMessages = new Array();
var newMessagesWin = new Array();
var chatBoxes = new Array();

$(document).ready(function(){
	originalTitle = document.title;
//	startChatSession();
	
	$([window, document]).blur(function(){
		windowFocus = false;
	}).focus(function(){
		windowFocus = true;
		document.title = originalTitle;
	});
});

function chatWith(chatuser) {
	createChatBox(chatuser);
	$("#chatbox_"+chatuser+" .chatboxtextarea").focus();
}

//function chatWith(chatuser) {
//	$.post(CHAT_URL+"/?action=chatwith&chatter="+chatuser, function(data){
//		createChatBox(data);
//		$("#chatbox_"+chatuser+" .chatboxtextarea").focus();
//	});
//}

function showRecentChat(chatboxtitle) {
	$.post(CHAT_URL+"/",{
		chatboxtitle	: chatboxtitle,
		action			: "showrecentchat"
	}, function(html) {
		var x = html.split("-spt-");
		if(x[0]!="no") {
			$("#chatbox_"+chatboxtitle+" .chatboxcontent").html(x[0]);
			$("#txtidfrom_"+chatboxtitle).val(x[1]);
			$("#txtidto_"+chatboxtitle).val(x[2]);
			
			$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
		}
	});
	return false;
}

function createChatBox(chatboxtitle,minimizeChatBox) {
	if ($("#chatbox_"+chatboxtitle).length > 0) {
		if ($("#chatbox_"+chatboxtitle).css('display') == 'none') {
			$("#chatbox_"+chatboxtitle).css('display','block');
			restructureChatBoxes();
		}
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		return;
	}

	$(" <div />" ).attr("id","chatbox_"+chatboxtitle)
	.addClass("chatbox")
//	.html('<div class="chatboxhead"><div class="chatboxtitle">'+chatboxtitle+'</div><div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')">-</a> <a href="javascript:void(0)" onclick="javascript:closeChatBox(\''+chatboxtitle+'\')">X</a><input type="hidden" id="txtidfrom_'+chatboxtitle+'" value="1"><input type="hidden" id="txtidto_'+chatboxtitle+'" value="1"></div><br clear="all"/></div><div class="chatboxcontent"><div class="recentchat"><span class="recentchatinfo"><a href="javascript:void(0)" onclick="javascript:showRecentChat(\''+chatboxtitle+'\')">show recent chat</a></span></div></div><div class="chatboxinput"><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatboxtitle+'\');"></textarea></div>')
	.html('<div class="panel panel-default">'+
            '<div class="panel-heading">'+
            '    <h3 class="panel-title"><span class="fa fa-comments"></span> '+chatboxtitle+'</h3>'+
            '    <div class="pull-right">'+
            '        <a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')">-</a>'+ 
            '        <a href="javascript:void(0)" onclick="javascript:closeChatBox(\''+chatboxtitle+'\')">X</a>'+
            '        <input type="hidden" id="txtidfrom_'+chatboxtitle+'" value="1">'+
            '        <input type="hidden" id="txtidto_'+chatboxtitle+'" value="1">'+
            '    </div>'+
            '</div>'+
            '<div id="pbody_'+chatboxtitle+'" class="panel-body scroll" style="height: 300px;">'+
            '    <div id="content_'+chatboxtitle+'" class="messages messages-img">'+
            '        <div class="recentchat">'+
            '            <span class="recentchatinfo">'+
            '                <a href="javascript:void(0)" onclick="javascript:showRecentChat(\''+chatboxtitle+'\')">show recent chat</a>'+
            '            </span>'+
            '        </div>'+                            
            '    </div>'+
            '</div>'+
            '<div class="panel-footer">'+
            '	<input type="text" class="form-control chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatboxtitle+'\');" placeholder="Tulis pesan..."/>'+
            '</div>'+
		'</div>')
	.appendTo($( "body" ));
	
	$(".scroll").mCustomScrollbar({axis:"y", autoHideScrollbar: true, scrollInertia: 20, advanced: {autoScrollOnFocus: false}});
	$("#chatbox_"+chatboxtitle).css('bottom', '-15px');
	
	chatBoxeslength = 0;

	for (x in chatBoxes) {
		if ($("#chatbox_"+chatBoxes[x]).css('display') != 'none') {
			chatBoxeslength++;
		}
	}

	if (chatBoxeslength == 0) {
		$("#chatbox_"+chatboxtitle).css('right', '20px');
	} else {
		width = (chatBoxeslength)*(300+7)+20;
		$("#chatbox_"+chatboxtitle).css('right', width+'px');
	}
	
	chatBoxes.push(chatboxtitle);

	if (minimizeChatBox == 1) {
		minimizedChatBoxes = new Array();

		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}
		minimize = 0;
		for (j=0;j<minimizedChatBoxes.length;j++) {
			if (minimizedChatBoxes[j] == chatboxtitle) {
				minimize = 1;
			}
		}

		if (minimize == 1) {
			$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
			$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
		}
	}

	chatboxFocus[chatboxtitle] = false;

	$("#chatbox_"+chatboxtitle+" .chatboxtextarea").blur(function(){
		chatboxFocus[chatboxtitle] = false;
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextareaselected');
	}).focus(function(){
		chatboxFocus[chatboxtitle] = true;
		newMessages[chatboxtitle] = false;
		$('#chatbox_'+chatboxtitle+' .panel-heading').removeClass('chatboxblink');
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextareaselected');
	});

	$("#chatbox_"+chatboxtitle).click(function() {
		if ($('#chatbox_'+chatboxtitle+' .panel-body').css('display') != 'none') {
			$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		}
	});

	$("#chatbox_"+chatboxtitle).show();
}

function chatOut(){
	$.post(CHAT_URL+"/?action=iamout", function(data){
		if(data!="no") {
			window.close();
		}
	});
	setTimeout('chatOut();',chatOutTime);
}

function checkLogin(){
	$.post(CHAT_URL+"/?action=checklogin", function(o){
		obj = eval('('+o+')');
		if(obj.status==1) {
			document.location = obj.data.go_to;
		}
	});
	
	setTimeout('checkLogin();',1000);
}

function checkStatus(){
	$('#info-status').html('');
	$.post(CHAT_URL+"/?action=checkstatus", function(data){
		var c = data.trim() === 'online'?'info':'danger';
		
		if(data.trim() === 'online') $('#chat-with').attr('onclick',"javascript:chatWith('admin')");
		else {
			$('#chat-with').removeAttr('onclick');
			if ($("#chatbox_admin").length > 0) $("#chatbox_admin").remove();
		}
		
		$('#info-status').removeAttr('class').attr('class','informer informer-'+c).html(data);
	});
	
	setTimeout('checkStatus();',checkStatusTime);
}

function chatHeartbeat(from){
	var itemsfound = 0;
	
	if (windowFocus == false) {
 
		var blinkNumber = 0;
		var titleChanged = 0;
		for (x in newMessagesWin) {
			if (newMessagesWin[x] == true) {
				++blinkNumber;
				if (blinkNumber >= blinkOrder) {
					document.title = x+' says...';
					titleChanged = 1;
					break;	
				}
			}
		}
		
		if (titleChanged == 0) {
			document.title = originalTitle;
			blinkOrder = 0;
		} else {
			++blinkOrder;
		}
	} else {
		for (x in newMessagesWin) {
			newMessagesWin[x] = false;
		}
	}

	for (x in newMessages) {
		if (newMessages[x] == true) {
			if (chatboxFocus[x] == false) {
				//FIXME: add toggle all or none policy, otherwise it looks funny
				$('#chatboxhead_'+x+' .panel-heading').toggleClass('chatboxblink');
			}
		}
	}
	
	var chatboxtitle = '';
	$.ajax({
	  url: CHAT_URL+"/?action=chatheartbeat&from="+from,
	  cache: false,
	  dataType: "json",
	  success: function(data) {
		$.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug

				chatboxtitle = item.f;				
				
				if ($("#chatbox_"+chatboxtitle).length <= 0) {
					createChatBox(chatboxtitle);
				}
				if ($("#chatbox_"+chatboxtitle).css('display') == 'none') {
					$("#chatboxhead_"+chatboxtitle+", #chatbox_"+chatboxtitle).css('display','block');
					//restructureChatBoxes();
				}
				
				var data = item.s;
				var y = data.split("-spt-");
				
				if (y[0] == 1) {
					item.f = username;
				}

				if (y[0] == 2) {
//						$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else if (y[0] == 3) {
//						$("#content_"+chatboxtitle).append('<div id="chatboxmessageoff_'+chatboxtitle+'" class="chatboxmessage"><span class="chatboxinfo">[ '+item.t+' ] '+item.m+'</span></div>');
					$("#content_"+chatboxtitle).append(
			                    '        <div id="chatboxmessageoff_'+chatboxtitle+'" class="item">'+
			                    '            <div class="image">'+
			                    '                <img src="'+item.p+'" alt="'+item.f+'">'+
			                    '            </div>'+
			                    '            <div id="cbmfrom_'+chatboxtitle+'_'+$("#txtidfrom_"+chatboxtitle).val()+'" class="text" style="color: #b64645;">'+
			                    '                <div class="heading">'+
			                    '                    <a href="#">'+item.f.charAt(0).toUpperCase() + item.f.slice(1)+'</a>'+
			                    '                    <span class="date">'+item.t+'</span>'+
			                    '                </div>'+item.m+''+
			                    '                <br class="clearrows">'+
			                    '            </div>'+
			                    '        </div>');
					$("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextareaselected');
					$("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextarealogout').attr("disabled","disabled");
				} else {
					newMessages[chatboxtitle] = true;
					newMessagesWin[chatboxtitle] = true;
					
					if($("#chatboxmessageoff_"+chatboxtitle).length==1){
						$("#chatboxmessageoff_"+chatboxtitle).remove();
						$("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextarealogout');
						$("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextareaselected').removeAttr("disabled");
					}
					
					if(y[1]==0 || $("#cbmfrom_"+chatboxtitle+"_"+(parseInt($("#txtidfrom_"+chatboxtitle).val())-1)).length==0) {
						$("#content_"+chatboxtitle).append(
                                '        <div class="item">'+
                                '            <div class="image">'+
                                '                <img src="'+item.p+'" alt="'+item.f+'">'+
                                '            </div>'+
                                '            <div id="cbmfrom_'+chatboxtitle+'_'+$("#txtidfrom_"+chatboxtitle).val()+'" class="text">'+
                                '                <div class="heading">'+
                                '                    <a href="#">'+item.f.charAt(0).toUpperCase() + item.f.slice(1)+'</a>'+
                                '                    <span class="date">'+item.t+'</span>'+
                                '                </div>'+item.m+''+
	                            '                <br class="clearrows">'+
                                '            </div>'+
                                '        </div>');
//						$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessagesender"><div class="cbmfrom_icon"><span class="chatboxmessagefrom">'+item.f+'</span></div><div class="cbmfrom_content"><div class="cbmfrom_contenttop"><div class="cbmfrom_contenttopleft"></div><div class="cbmfrom_contenttopright"></div></div><div class="cbmfrom_contentcenter"><div class="cbmfrom_contentcenterleft"></div><div class="cbmfrom_contentcentercenter"><div id="cbmfrom_'+chatboxtitle+'_'+$("#txtidfrom_"+chatboxtitle).val()+'"><div class="chatboxmessagetime">'+item.t+'</div><span class="chatboxmessagecontent">'+item.m+'</span><br class="clearrows"></div></div><div class="cbmfrom_contentcenterright"></div></div><div class="cbmfrom_contentbottom"><div class="cbmfrom_contentbottomleft"></div><div class="cbmfrom_contentbottomright"></div></div></div></div>');
						$("#txtidfrom_"+chatboxtitle).val(parseInt($("#txtidfrom_"+chatboxtitle).val())+1);
//						$(".cbmfrom_content").css("width","170px");
					} else {
						if(y[2]==1) {
							$("#cbmfrom_"+chatboxtitle+"_"+(parseInt($("#txtidfrom_"+chatboxtitle).val())-1)).append(
	                        		'                <hr class="separator">'+
		                            '                <div class="heading">'+
		                            '                    <span class="date">'+item.t+'</span>'+
		                            '                </div>'+item.m+
		                            '                <br class="clearrows">');
//							$("#cbmfrom_"+chatboxtitle+"_"+(parseInt($("#txtidfrom_"+chatboxtitle).val())-1)).append('<div class="chatboxmessagetime">'+item.t+'</div><span class="chatboxmessagecontent">'+item.m+'</span><br class="clearrows">');
						} else {
							$("#cbmfrom_"+chatboxtitle+"_"+(parseInt($("#txtidfrom_"+chatboxtitle).val())-1)).append(
		                            '                '+item.m+
		                            '                <br class="clearrows">');
//							$("#cbmfrom_"+chatboxtitle+"_"+(parseInt($("#txtidfrom_"+chatboxtitle).val())-1)).append('<span class="chatboxmessagecontent">'+item.m+'</span><br class="clearrows">');
						}
					}
					
//						var arrtarget = $("#txttarget").val().split(",");
//						var target = "";
//						
//						if($("#txttarget").val()=="")
//							$("#txttarget").val(chatboxtitle);
//						else if(jQuery.inArray(chatboxtitle, arrtarget)<0)
//							$("#txttarget").val($("#txttarget").val()+","+chatboxtitle);
				}
				
				if(270-$("#content_"+chatboxtitle)[0].scrollHeight < 0)
					$("#pbody_"+chatboxtitle+" .mCSB_container").animate({top: 270-$("#content_"+chatboxtitle)[0].scrollHeight}, 500);

				itemsfound += 1;
			}
		});

		chatHeartbeatCount++;

		if (itemsfound > 0) {
			chatHeartbeatTime = minChatHeartbeat;
			chatHeartbeatCount = 1;
		} else if (chatHeartbeatCount >= 10) {
			chatHeartbeatTime *= 2;
			chatHeartbeatCount = 1;
			if (chatHeartbeatTime > maxChatHeartbeat) {
				chatHeartbeatTime = maxChatHeartbeat;
			}
		}

		setTimeout('chatHeartbeat("'+chatboxtitle+'");',chatHeartbeatTime);
	}});
}

function restructureChatBoxes(title) {
	align = 0;
	chattitle = "";
	if(chatBoxes.length>1) {
		for (x in chatBoxes) {
			chatboxtitle = chatBoxes[x];
			if(title == chatboxtitle && $('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') == 'block' && (align >= 0 && align < chatBoxes.length-1)) {
				chattitle = chatBoxes[align+1]; break;
			} else if(title == chatboxtitle && $('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') == 'block' && align == chatBoxes.length-1) {
				chattitle = chatBoxes[align-1]; break;
			} else if(title == chatboxtitle && $('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') == 'none') {
				chattitle = chatBoxes[align]; break;
			}
			align++;
		}
		var minChatBoxes = new Array();
			
		if ($.cookie('chatbox_minimized')) {
			minChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}
	
		var newCookie = '';
	
		for (i=0;i<minChatBoxes.length;i++) {
			if (minChatBoxes[i] != chattitle) {
				newCookie += chattitle+'|';
			}
		}
	
		newCookie = newCookie.slice(0, -1);
		
		$.cookie('chatbox_minimized', newCookie);
		$('#chatbox_'+chattitle+' .chatboxcontent').css('display','block');
		$('#chatbox_'+chattitle+' .chatboxinput').css('display','block');
		$("#chatbox_"+chattitle+" .chatboxcontent").scrollTop($("#chatbox_"+chattitle+" .chatboxcontent")[0].scrollHeight);
		$("#chatbox_"+chattitle+" .chatboxtextarea").focus();
		$('#chatboxhead_'+chattitle+' .panel-heading').removeClass('chatboxinactive');
	}
}

function closeChatBox(chatboxtitle) {
	$('#chatboxhead_'+chatboxtitle+', #chatbox_'+chatboxtitle).css('display','none');
	$('#chatbox_'+chatboxtitle+' .chatboxcontent').html("");
	restructureChatBoxes(chatboxtitle);
	
	if ($("#chatbox_"+chatboxtitle).css('display') == 'none') {
		$('#chatboxhead_'+chatboxtitle+', #chatbox_'+chatboxtitle).remove();
		chatBoxes = jQuery.grep(chatBoxes, function(value) {
			return value != chatboxtitle;
		});
	}
	
	
	$.post(CHAT_URL+"/?action=closechat", { chatbox: chatboxtitle} , function(data){		
		var alamat = window.location;
		var x = alamat.toString().split("?");
		var y = x[1].toString().split("&");
		var z = $("#txttarget").val().split(",");
		var tgc = "";
		var target = "";
		
		for(var i=0; i<z.length; i++)
			if(z[i]!=chatboxtitle){
				target += ","+z[i];
				tgc = z[i];
			}
		
		var frm = opener.document.forms['frmtarget'];
		frm.elements['txttarget'].value = target.substring(1);
		
		if(target=="")
			window.close();
		
		alamat.replace(x[0]+"?tgc="+tgc+"&trg="+target.substring(1));
		
		showRecentChat(chatboxtitle);
	});
}

function toggleChatBoxGrowth(chatboxtitle) {
	if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') == 'none') {  
		
		var minimizedChatBoxes = new Array();
		
		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}

		var newCookie = '';

		for (i=0;i<minimizedChatBoxes.length;i++) {
			if (minimizedChatBoxes[i] != chatboxtitle) {
				newCookie += chatboxtitle+'|';
			}
		}

		newCookie = newCookie.slice(0, -1);


		$.cookie('chatbox_minimized', newCookie);
		$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','block');
		$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','block');
		$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
	} else {
		
		var newCookie = chatboxtitle;

		if ($.cookie('chatbox_minimized')) {
			newCookie += '|'+$.cookie('chatbox_minimized');
		}


		$.cookie('chatbox_minimized',newCookie);
		$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
		$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
	}
	
}

function minimizeAnother(title) {
	if(chatBoxes.length>1) {
		for (x in chatBoxes) {
			chatboxtitle = chatBoxes[x];
			if($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') != 'none') {		
				var newCookie = chatboxtitle;
		
				if ($.cookie('chatbox_minimized')) {
					newCookie += '|'+$.cookie('chatbox_minimized');
				}
		
		
				$.cookie('chatbox_minimized',newCookie);
				$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
				$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
				$('#chatboxhead_'+chatboxtitle+' .panel-heading').addClass('chatboxinactive');
			}
		}
		var minimizedChatBoxes = new Array();
		
		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}
	
		var newCookie = '';
	
		for (i=0;i<minimizedChatBoxes.length;i++) {
			if (minimizedChatBoxes[i] != title) {
				newCookie += title+'|';
			}
		}
	
		newCookie = newCookie.slice(0, -1);
	
	
		$.cookie('chatbox_minimized', newCookie);
		$('#chatbox_'+title+' .chatboxcontent').css('display','block');
		$('#chatbox_'+title+' .chatboxinput').css('display','block');
		$("#chatbox_"+title+" .chatboxcontent").scrollTop($("#chatbox_"+title+" .chatboxcontent")[0].scrollHeight);	
		$("#chatbox_"+title+" .chatboxtextarea").focus();
		$('#chatboxhead_'+title+' .panel-heading').removeClass('chatboxinactive');
	} else
		$("#chatbox_"+title+" .chatboxtextarea").focus();
}

function checkChatBoxInputKey(event,chatboxtextarea,chatboxtitle) {
	 
	if(event.keyCode == 13 && event.shiftKey == 0)  {
		message = $(chatboxtextarea).val();
		message = message.replace(/^\s+|\s+$/g,"");

		$(chatboxtextarea).val('');
		$(chatboxtextarea).focus();
//		$(chatboxtextarea).css('height','44px');
		if (message != '') {
			$.post(CHAT_URL+"/?action=sendchat", {
				to: chatboxtitle, 
				message: message
			} , function(data){
				var x = data.split("-spt-");
				message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
				
				if(x[2]==1){
					message = message+" <span style='color:#f00; text-align:right; width:100%;'>sent failed, try again...!</span>";
				}
				
				if(x[1]==0 || $("#cbmto_"+chatboxtitle+"_"+(parseInt($("#txtidto_"+chatboxtitle).val())-1)).length==0) {
					$("#content_"+chatboxtitle).append(
                            '        <div class="item in">'+
                            '            <div class="image">'+
                            '                <img src="'+x[4]+'" alt="Me">'+
                            '            </div>'+
                            '            <div id="cbmto_'+chatboxtitle+'_'+$("#txtidto_"+chatboxtitle).val()+'" class="text">'+
                            '                <div class="heading">'+
                            '                    <a href="#">Me</a>'+
                            '                    <span class="date">'+x[0]+'</span>'+
                            '                </div>'+message+
                            '                <br class="clearrows">'+
                            '            </div>'+
                            '        </div>');
//					$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessageto"><div class="cbmto_icon"><span class="chatboxmessageke">me</span></div><div class="cbmto_content"><div class="cbmto_contenttop"><div class="cbmto_contenttopleft"></div><div class="cbmto_contenttopright"></div></div><div class="cbmto_contentcenter"><div class="cbmto_contentcenterleft"></div><div class="cbmto_contentcentercenter"><div id="cbmto_'+chatboxtitle+'_'+$("#txtidto_"+chatboxtitle).val()+'"><div class="chatboxmessagetime">'+x[0]+'</div><span class="chatboxmessagecontent">'+message+'</span><br class="clearrows"></div></div><div class="cbmto_contentcenterright"></div></div><div class="cbmto_contentbottom"><div class="cbmto_contentbottomleft"></div><div class="cbmto_contentbottomright"></div></div></div></div>');
					$("#txtidto_"+chatboxtitle).val(parseInt($("#txtidto_"+chatboxtitle).val())+1);
//					$(".cbmto_content").css("width","170px");
				} else {
					if(x[3]==1) {
						$("#cbmto_"+chatboxtitle+"_"+(parseInt($("#txtidto_"+chatboxtitle).val())-1)).append(
                        		'                <hr class="separator">'+
	                            '                <div class="heading">'+
	                            '                    <span class="date">'+x[0]+'</span>'+
	                            '                </div>'+message+
	                            '                <br class="clearrows">');
//						$("#cbmto_"+chatboxtitle+"_"+(parseInt($("#txtidto_"+chatboxtitle).val())-1)).append('<div class="chatboxmessagetime">'+x[0]+'</div><span class="chatboxmessagecontent">'+message+'</span><br class="clearrows">');
					} else {
						$("#cbmto_"+chatboxtitle+"_"+(parseInt($("#txtidto_"+chatboxtitle).val())-1)).append(
	                            '                '+message+
	                            '                <br class="clearrows">');
//						$("#cbmto_"+chatboxtitle+"_"+(parseInt($("#txtidto_"+chatboxtitle).val())-1)).append('<span class="chatboxmessagecontent">'+message+'</span><br class="clearrows">');
					}
				}

				if(270-$("#content_"+chatboxtitle)[0].scrollHeight < 0)
					$("#pbody_"+chatboxtitle+" .mCSB_container").animate({top: 270-$("#content_"+chatboxtitle)[0].scrollHeight}, 500);
			});
		}
		chatHeartbeatTime = minChatHeartbeat;
		chatHeartbeatCount = 1;

		return false;
	}

	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

	if (maxHeight > adjustedHeight) {
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			$(chatboxtextarea).css('height',adjustedHeight+8 +'px');
	} else {
		$(chatboxtextarea).css('overflow','auto');
	}
	 
}

function startChatSession(){  
	$.ajax({
	  url: CHAT_URL+"/?action=startchatsession",
	  cache: false,
	  dataType: "json",
	  success: function(data) {
 
		username = data.username;

		$.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug

				chatboxtitle = item.f;
				
				if ($("#chatbox_"+chatboxtitle).length <= 0) {
					createChatBox(chatboxtitle,1);
				}
				
				if (item.s == 1) {
					item.f = username;
				}

				if (item.s == 2) {
					$("#content_"+chatboxtitle).append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
					$("#content_"+chatboxtitle).append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+item.f+':</span><span class="chatboxmessagetime">'+item.t+'</span><br class="clearrows"><span class="chatboxmessagecontent">'+item.m+'</span></div>');
				}
			}
		});
		
		var chatboxtitle = '';
		for (i=0;i<chatBoxes.length;i++) {
			chatboxtitle = chatBoxes[i];
			
			$("#content_"+chatboxtitle).scrollTop($("#content_"+chatboxtitle)[0].scrollHeight);
			setTimeout('$("#content_"+chatboxtitle).scrollTop($("#content_"+chatboxtitle)[0].scrollHeight);', 100); // yet another strange ie bug
//			$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
//			setTimeout('$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);', 100); // yet another strange ie bug
		}

//		setTimeout('chatOut();',chatOutTime);			
		setTimeout('chatHeartbeat("'+chatboxtitle+'");',chatHeartbeatTime);
		
	}});
}

/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};