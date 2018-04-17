<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>


<div id="main">
	<div class="infoBox">
		$[_afterSetup]
	</div>


	<form id="form" accept-charset="UTF-8" method="post" action="index.php">
			<legend><label>MySQL Database Settings </label></legend>
			<fieldset>
				<label for="DBHOST">DB HOST/IP: </label>
					<input class="validate[required] text-input" name="CONF[DBHOST]" value="" type="text" id="DBHOST" data-prompt-position="bottomLeft:0"/>
				<br />
				<label for="DBPORT">DB PORT: </label>
					<input class="validate[required,custom[integer]] text-input" name="CONF[DBPORT]" value="3306" type="text" id="DBPORT" data-prompt-position="bottomLeft:0" />
				<br />
				<label for="DBNAME">DB NAME: </label>
					<input class="validate[required] text-input" name="CONF[DBNAME]" value="" type="text" id="DBNAME" data-prompt-position="bottomLeft:0" />
				<br />
				<label for="DBUSER">DB USER: </label>
					<input class="validate[required] text-input" name="CONF[DBUSER]" value="" type="text" id="DBUSER" data-prompt-position="bottomLeft:0" />
				<br />
				<label for="DBPASS">DB PASSWD: </label>
					<input class="validate[required] text-input" name="CONF[DBPASS]" value="" type="password" id="DBPASS" data-prompt-position="bottomLeft:0" />
			</fieldset>	
			
			<legend><label>GameServer Settings </label></legend>
				<fieldset>
					<label for="GAME">GAME: </label>
						<select class="validate[required]" name="CONF[GAME]" data-prompt-position="bottomLeft:0">
							<option value="1">A2 EPOCH</option>
							<option value="2">DAYZ MOD</option>
						</select>
					<br />
					
					<label for="GAMEIP">GAMESERVER IP: </label>
						<input class="validate[required] text-input" name="CONF[GAMEIP]" value="" type="text" id="GAMEIP" data-prompt-position="bottomLeft:0" />
					<br />
					
					<label for="GAMEPORT">GAMESERVER PORT: </label>
						<input class="validate[required,custom[integer]] text-input" name="CONF[GAMEPORT]" value="" type="text" id="GAMEPORT" data-prompt-position="bottomLeft:0" />
					<br />
					
					<label for="GAMERCON">GAMESERVER RCON PASSWD: </label>
						<input class="validate[required] text-input" name="CONF[GAMERCON]" value="" type="password" id="GAMERCON" data-prompt-position="bottomLeft:0" />
					<br />
					<label for="GAMEMAP">GAMESERVER MAP: </label>
					<select class="validate[required]" name="CONF[GAMEMAP]" data-prompt-position="bottomLeft:0">
							<option value="1">chernarus</option>
							<option value="3">lingor</option>
							<option value="4">namalsk</option>
							<option value="5">ovaron</option>
							<option value="6">panthera2</option>
							<option value="7">utes</option>
							<option value="10">sauerland</option>
							<option value="11">takistan</option>
							<option value="12">zargabad</option>
							<option value="13">napf</option>
						</select>
					<br />	
					<label for="INSTANCE">HIVE INSTANCE ID: </label>
						<input class="validate[required,custom[integer]]  text-input" name="CONF[INSTANCE]" value="" type="text" id="INSTANCE" data-prompt-position="bottomLeft:0" />	
						
				</fieldset>	
						
				<legend><label>Head Admin Account </label></legend>
				<fieldset>
						<label for="USERNAME">Username: </label>
						<input class="validate[required,minSize[4]] text-input" name="CONF[USERNAME]" value="" type="text" id="USERNAME" data-prompt-position="bottomLeft:0" />
					<br />
					<label for="PASSWORD">Password: </label>
						<input class="validate[required,minSize[8]] text-input" name="CONF[PASSWORD]" value="" type="password" id="PASSWORD" data-prompt-position="bottomLeft:0" />
					<br />
						<label for="confirm1">Confirm Password:</label>
						<input class="validate[equals[PASSWORD]] text-input" type="password" id="confirm1" data-prompt-position="topLeft:0" />
					<br />	
					
						<label for="reset">Reset Key: </label>
						<input class="validate[required,minSize[8]] text-input" name="CONF[PHT_RESET_KEY]" value="" type="password" id="RESET" data-prompt-position="bottomLeft:0" />	
					<br />
						<label for="confirm2">Confirm Key:</label>
						<input class="validate[equals[RESET]] text-input" type="password" id="confirm2" data-prompt-position="topLeft:0" />
				</fieldset>	

				<br />
				
				<button id="submit" name="setup" type="submit"> GOOooo </button>
			</form>	
		
	<br /><br />

		<ul>
		<li><a target="_blank" href="http://n8m4re.de"><img src="style/images/logo1.png" alt="" /></a></li>
			<li>&copy; 2014 - 9999 PrivateHiveTools $[VERSION] by Nightmare </li>
		</ul>

	
</div>


<script>
//<![CDATA[
jQuery(document).ready(function($){
$('#main').dialog({autoOpen:true,width:'auto',height:'auto',resizable:false,modal:false,draggable:true,closeOnEscape:false,dialogClass:'no-title',position:['auto',30]});
});
//]]>
</script>
<noscript>This page needs JavaScript activated to work!</noscript>
</body>
</html>