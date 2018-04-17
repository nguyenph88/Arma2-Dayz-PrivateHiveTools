<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>

$[CONTENTSCRIPTS]

<div class="infoBox">$[_infoBlackList]</div>

<div class="container2">
	<button id="openAddBlacklist" class="icon i-edit" title="$[_addNew]" type="button"></button>
	<div id="paginate" class="pagination"></div>
</div>

<div class="container">
	<form accept-charset="UTF-8" method="post">
		<table class="footable table">	
				<thead>
					<tr>
						<th>$[_classname]</th>
						<th><button class="icon i-delete" name="submit" value="checkbox" type="submit" onclick="return confirm(confirmMSG)" title="$[_deleteSelected]"></button></th>
					</tr>	
				</thead>
				<tbody>
					$[TABLEDATA]
				</tbody>
		</table>
	</form>	
</div>


<div id="addBlacklist" title="$[_addNew]" style="display:none;">
	<form id="addBlacklistDialogForm" accept-charset="UTF-8">
		<div class="container">
			<fieldset>
				<label for="classname">$[_classname]:</label>
				<input class="validate[required,custom[onlyLetterNumber]] text-input" name="item" value="" type="text" id="classname" data-prompt-position="bottomLeft:0" />
				<br />
			</fieldset>
		</div>
	</form>
		<br />
	<button class="submit" type="button">$[_submit]</button>
	<button class="close" type="button">$[_close]</button>	
</div>