<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>
<div id="login" style="display:none">
	<section>
		<form id="form" accept-charset="UTF-8" method="post"  >
			<fieldset>
					<input id="a" name="username" value="" type="text" placeholder="Username" />
				<br />
					<input id="b" name="password" value="" type="password" placeholder="Password" />
				<br />
			</fieldset>	
			
			<button name="login" type="submit" >Login</button>
			<br />
		</form>	
					<a style="font-size:10px;float:right;" id="lost" href="#">Lost Password(HeadAdmin only)</a>
			<br />
	</section>
	
	<footer>
		<ul>
			<li>&copy; 2014 - 9999 PrivateHiveTools $[VERSION] by Nightmare </li>
			<li><a target="_blank" href="http://n8m4re.de"><img src="style/images/logo1.png" alt="" /></a></li>
		</ul>
	</footer>
</div>


<div id="lostPw" style="display:none">
<form id="rForm" accept-charset="UTF-8" >
		<fieldset>
				<label>Reset Key:</label>
				<input id="resetKey" name="resetKey" value="" type="password"  />
			<br /><br />	
				<label>New Password:</label>
				<input id="newPw" class="validate[required,minSize[8]] text-input" name="newPw" value="" type="password"  data-prompt-position="bottomLeft:0" />
			<br /><br />		
				<label>Confirm New Password:</label>
				<input class="validate[equals[newPw]] text-input" value="" type="password" id="confirmNewPW"  data-prompt-position="bottomLeft:0" />	
		</fieldset>	
	</form>
	<br />	
		<button id="reset" type="button"> Submit </button>
</div>
<script>
//<![CDATA[
jQuery(function(){
$('#login').dialog({autoOpen:true,width:'auto',height:'auto',resizable:false,modal:false,draggable:true,closeOnEscape:false,dialogClass:'no-title',position:['auto',100]});	
$('#form').submit(function(){var a=$('#a');var b=$('#b');if($.trim(a.val())===''||$.trim(b.val())===''){return false;}});	
$('#lostPw').dialog({autoOpen:false,width:300,height:400,resizable:false,modal:true,draggable:false,closeOnEscape:true,dialogClass:'',position:['auto',100]});	
$('#lost').click(function(){
var form = $('#rForm');
form.validationEngine();
$('#lostPw').dialog('open');
	$('#reset').click(function(){
		var val=form.validationEngine('validate');
		if (val==true) { 
				$.fn.serializeObject=function(){var o={};var a=this.serializeArray();$.each(a,function(){if(o[this.name] !== undefined){if(!o[this.name].push){o[this.name]=[o[this.name]];}o[this.name].push(this.value||'');}else{o[this.name]=this.value||'';}});return o;};
				var data=form.serializeObject();
				var obJ=JSON.stringify(data);
				$.post('index.php',{reset:obJ}).done(function(data){ 
				if( data == true){window.location.reload();} 
			});
		}
	});
});

});
//]]>
</script>
<noscript>This page needs JavaScript activated to work!</noscript>
</body>
</html>