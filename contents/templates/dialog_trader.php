<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>

<form id="traderDialogForm" accept-charset="UTF-8">
	<input name="id" value="$[ID]" type="hidden" />
	<div class="container">
		<fieldset>
			<label for="classname">$[_classname]:</label>
			<input class="validate[required] text-input" name="classname" value="$[CLASSNAME]" type="text" id="classname" data-prompt-position="bottomLeft:0" />
			<br />
			<label for="desc">$[_desc]:</label>
			<input class="validate[required] text-input" name="desc" value="$[DESC]" type="text" id="desc" data-prompt-position="bottomLeft:0" />
			<br />
			
			<label for="status">Status:</label>
			<select id="status" name="status" class="validate[required,custom[onlyLetterNumber]]" data-prompt-position="bottomLeft:0">
				<option value="$[STATUS]">$[STATUS]</option>
				<option value="friendly">friendly</option>
				<option value="neutral">neutral</option>
				<option value="hero">hero</option>
				<option value="hostile">hostile</option>
			</select>
			
			<br />
		</fieldset>
		
		<table id="tids" class="footable table" style="width:540px;margin:0 auto;" >
			<thead>
					<tr>
						<th></th>
						<th>$[_category]</th>
						<th>Tid</th>
					</tr>
			</thead>
			<tbody>$[TID]</tbody>
			
		</table>
		<button id="addtid" class="none" type="button">$[_newTid]</button>
	</div>
</form>
	<br />
	<br />
	<br />
<button class="save" type="button">$[_save]</button>
<button class="close" type="button">$[_close]</button>	