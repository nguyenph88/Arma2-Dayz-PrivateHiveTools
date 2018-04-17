<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>

<div class="infoBox">$[_battlEyeNeeded]</div>

<div style="padding:0.5em 0 0.2em;"><button style="padding:0.6em;float:left;" id="showplayerlist" type="button">Playerlist</button><button style="padding:0.6em;float:left;margin-left:0.2em;" id="showbanlist" type="button">Banlist</button><button style="padding:0.6em;float:left;margin-left:0.2em;" id="restart" type="button">Restart</button><button style="padding:0.6em;float:left;margin-left:0.2em;" id="shutdown" type="button">Shutdown</button><button style="padding:0.6em;float:left;margin-left:0.2em;" id="lock" type="button">Lock</button><button style="padding:0.6em;float:left;margin-left:0.2em;" id="unlock" type="button">UnLock</button><button style="padding:0.6em;float:right;" id="refresh" type="button">Refresh</button></div>
<br /><br /><br />
<table id="playerlist" class="footable table" style="display:none"><thead><tr><th></th><th>NAME</th><th>GUID</th><th>PING</th><th>IP</th><th>#</th></tr></thead><tbody>$[PLAYERTABLE]</tbody></table>
<table id="banlist" class="footable table" style="display:none"><thead><tr><th></th><th>#</th><th>GUID / IP</th><th>TIME</th><th>REASON</th></tr></thead><tbody>$[BANSTABLE]</tbody></table>
<div id="banDialog" style="display:none"><fieldset><label>reason</label><input name="reason" value="Admin Ban" /><br /><label>Ban Time in Minutes (0=Infinite)</label><input name="time" value="0" /></fieldset><button id="banNow" type="button">Ban</button></div>
<script>
//<![CDATA[
jQuery(function($){
	var URL='ajax.php?token='+ PHT_TOKEN;
	$('#showbanlist').click(function(){$(this).addClass('active');$('#playerlist').hide();$('#banlist').show();$('#showplayerlist').removeClass('active');banlist=true;playerlist=false;});
	$('#showplayerlist').click(function(){$(this).addClass('active');$('#banlist').hide();$('#playerlist').show();$('#showbanlist').removeClass('active');playerlist=true;banlist=false;});
	if(playerlist==true){$('#showplayerlist').addClass('active');$('#banlist').hide();$('#playerlist').show();} else if(banlist==true){$('#showbanlist').addClass('active');$('#playerlist').hide();$('#banlist').show();}
	var r=0;
	var rconDialog=function(){$.post(URL,{rconTools:true}).done(function(data){$('#rconToolsDialog').html(data);});};
	var playerData=function(){$.post(URL,{rconTools:true,playerData:true}).done();};	
	var bansData=function(){$.post(URL,{rconTools:true,bansData:true}).done();};		
	$('#refresh').click(function(){if(r==0){r=1;$('#refresh').html('<img class="loader" src="style/images/loader.gif" />');$('#playerlist,#banlist').hide();setTimeout(function(){playerData();bansData();},1000);}		});
	$('#lock').click(function(){var c=confirm(confirmMSG);if(c==true){$.post(URL,{rconTools:true,lock:true}).done(function(){$('#content').prepend('<div id="re" class="successBox" style="z-index:9999;font-size:14px;position:fixed;right:80px;">server is locked now</div>');setTimeout(function(){$('#re').hide('puff',function(){$(this).remove();});},3000);});}});	
	$('#unlock').click(function(){var c=confirm(confirmMSG);if(c==true){$.post(URL,{rconTools:true,unlock:true}).done(function(){$('#content').prepend('<div id="re" class="successBox" style="z-index:9999;font-size:14px;position:fixed;right:80px;">server is unlocked now</div>');setTimeout(function(){$('#re').hide('puff',function(){$(this).remove();});},3000);});}});	
	$('#shutdown').click(function(){var c=confirm(confirmMSG);if(c==true){$.post(URL,{rconTools:true,shutdown:true}).done(function(){$('#content').prepend('<div id="re" class="successBox" style="z-index:9999;font-size:14px;position:fixed;right:80px;">server will shutdown</div>');setTimeout(function(){$('#re').hide('puff',function(){$(this).remove();});},3000);});}});
	$('#restart').click(function(){var c=confirm(confirmMSG);if(c==true){$.post(URL,{rconTools:true,restart:true}).done(function(){$('#content').prepend('<div id="re" class="successBox" style="z-index:9999;font-size:14px;position:fixed;right:80px;">server mission will be restarted</div>');setTimeout(function(){$('#re').hide('puff',function(){$(this).remove();});},3000);});}});
	$('.kick').click(function(){var c=confirm(confirmMSG);if(c==true){var val=$(this).attr('value');$.post(URL,{rconTools:true,kick:val}).done(function(){$('#content').prepend('<div id="re" class="successBox" style="z-index:9999;font-size:14px;position:fixed;right:80px;">kicking player #'+ val +'</div>');setTimeout(function(){$('#re').hide('puff',function(){$(this).remove();});},3000);});}});		
	$('.ban').click(function(){var val=$(this).attr('value');$('#banDialog').dialog({autoOpen:true,width:'auto',height:'auto',resizable:false,position:['auto',57]});$('#banDialog').addClass('ban' + val );$('#banNow').click(function(){var c=confirm(confirmMSG);if(c==true){var iput=$('input[name="time"],input[name="reason"]').serializeArray();iput.push({name:'rconTools',value:true},{name:'ban',value:val});$.post(URL,iput,function(){$('.ban' + val).dialog('close');});}});});
	$('.unban').click(function(){var val=$(this).attr('value');var c=confirm(confirmMSG);if(c==true){$('#banlist tr:last').remove();$.post(URL,{rconTools:true,unban:val});}});
});
//]]>
</script>