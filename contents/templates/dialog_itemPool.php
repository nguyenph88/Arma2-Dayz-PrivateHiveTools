<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>
<form id="ItemPoolDialogForm" accept-charset="UTF-8" >
	<input name="id" value="$[ID]" type="hidden" />
<div class="container">
	<fieldset>
			<label for="classname">$[_classname]:</label>
			<input class="validate[required] text-input" name="classname" value="$[CLASSNAME]" type="text" id="classname" data-prompt-position="bottomLeft:0" />
		<br />	
			<label for="group">$[_category]:</label>
			<select class="validate[required] text-input" name="group" id="group" data-prompt-position="bottomLeft:0">
				<option value="$[GROUP]">$[GROUP]</option>
				<option value="AMMO">AMMO</option>
				<option value="BACKPACK">BACKPACK</option>
				<option value="ITEM">ITEM</option>
				<option value="TOOLBELT">TOOLBELT</option>
				<option value="MODEL">MODEL</option>
				<option value="WEAPON">WEAPON</option>
			</select>
	</fieldset>
	</div>
	</form>
	<br />	
	<button class="save" type="button">$[_save]</button>
	<button class="close" type="button">$[_close]</button>	