<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>
<form id="ObjectPoolDialogForm" accept-charset="UTF-8">
	<input name="id" value="$[ID]" type="hidden" />
	<div class="container">
		<fieldset>
			<label for="classname">$[_classname]:</label>
			<input class="validate[required] text-input" name="classname" value="$[CLASSNAME]" type="text" id="classname" data-prompt-position="bottomLeft:0" />
			<br />
		</fieldset>
	</div>
</form>
	<br />
<button class="save" type="button">$[_save]</button>
<button class="close" type="button">$[_close]</button>	