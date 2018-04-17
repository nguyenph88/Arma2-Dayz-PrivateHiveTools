<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>
<div class="container2">
	<button id="openAddLocation" class="icon i-edit" title="$[_addNew]" type="button"></button>
	<div id="paginate" class="pagination"></div>
</div>

<div class="container">
	<form accept-charset="UTF-8" method="post">	
		<table class="footable table">
				<thead>
					<tr>
						<th></th>
						<th>$[_desc]</th>
						<th>Worldspace</th>
						<th><button class="icon i-delete" name="submit" value="checkbox" type="submit" onclick="return confirm(confirmMSG)" title="$[_deleteSelected]"></button></th>
					</tr>	
				</thead>
				
				<tbody>
					$[TABLEDATA]
				</tbody>
		</table>
	</form>	
</div>



<div id="addLocationDialog" title="$[_addNew]" style="display:none;">
	<form id="addLocationDialogForm" accept-charset="UTF-8" >
		<div class="container">
			<fieldset>
				<label for="desc">$[_desc]:</label>
				<input class="validate[required] text-input" name="desc" value="" type="text" id="desc" data-prompt-position="bottomLeft:0" />
				<br />
				<label for="worldspace">Worldspace:</label>
				<input class="validate[required] text-input" name="worldspace" value="" type="text" id="worldspace" data-prompt-position="bottomLeft:0" />
			</fieldset>
		</div>
	</form>
		<br />
	<button class="submit" type="button">$[_submit]</button>
	<button class="close" type="button">$[_close]</button>	
</div>

<div id="LocationPoolDialog" style="display:none;"></div>

$[CONTENTSCRIPTS]
