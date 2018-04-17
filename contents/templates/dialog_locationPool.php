<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>
<form id="locationPoolDialogForm" accept-charset="UTF-8">
	<input name="id" value="$[ID]" type="hidden" />
	<div class="container">
		<fieldset>
			<label for="description">$[_desc]:</label>
			<input class="validate[required] text-input" name="description" value="$[DESCRIPTION]" type="text" id="description" data-prompt-position="bottomLeft:0" />
			<br />			
			<label for="worldspace">Worldspace:</label>
			<input class="validate[required] text-input" name="worldspace" value="$[WORLDSPACE]" type="text" id="worldspace" data-prompt-position="bottomLeft:0" />
			<br />	
		</fieldset>
	</div>
</form>
	<br />
<button class="save" type="button">$[_save]</button>
<button class="close" type="button">$[_close]</button>	