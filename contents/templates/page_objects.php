<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>

<div class="infoBox">$[_afterServerRestart]</div>

<div class="container2">

	<button id="openAddObjectDialog" class="icon i-edit" title="$[_addNew]" type="button"></button>
	
	<div id="paginate" class="pagination"></div>

	<div class="search">
		<form name="searchForm" accept-charset="UTF-8" method="post" action="$[PAGE]" >
			<input class="searchHiveObjects" name="search[input]" placeholder="Classname / ObjectID / CharID"/>
			<input type="hidden" name="search[id]" />
			<button class="icon i-go" type="submit"></button>
		</form>	
	</div>
</div>

<div class="container">
	<form accept-charset="UTF-8" method="post" >
		<table class="footable table">
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th>Classname</th>
					<th>Obj-ID</th>
					<th>Char-ID / Key</th>
					<th>Damage</th>
					<th>Fuel</th>
					<th>Date</th>
					<th><button class="icon i-delete" name="submit" value="checkbox" type="submit" onclick="return confirm(confirmMSG)" title="$[_deleteSelected]"></button></th>
				</tr>	
			</thead>
			
			<tbody>
				$[TABLEDATA]
			</tbody>
		</table>
	</form>	
</div>


<div id="addObjectDialog" title="$[_addNew]" style="display:none;">
	<form id="addObjectDialogForm" accept-charset="UTF-8">
		<div class="container">
			<fieldset>
			
				<label for="classname">$[_classname]:</label>
				<input class="searchObjects validate[required] text-input" name="classname" value="" type="text" id="classname" data-prompt-position="bottomLeft:0" />
				<br />
				<label for="characterid">Char-ID:</label>
				<input class="validate[required,custom[integer],minSize[1]] text-input" name="characterid" value="0" type="text" id="characterid" data-prompt-position="bottomLeft:0" placeholder="0  = Default"/>
				<br /><br />
				<h2>Worldspace</h2>
				<label>Player:</label>
				<input id="selectP" name="playerName" type="text"  placeholder="e.g. HansWurst ..." />
				<br />
				<label>Enter:</label>
				<input class="validate[required] text-input" id="pSpace" name="worldspace" type="text" data-prompt-position="bottomLeft:0" placeholder="[0,[12345,12345,123]]" />
				<br />
			
			</fieldset>
		</div>
	</form>
		<br />
	<button class="submit" type="button">$[_submit]</button>
	<button class="close" type="button">$[_close]</button>	
</div>

<div id="teleportDialog" style="display:none;"></div>
<div id="objectDialog" style="display:none;"></div>

$[CONTENTSCRIPTS]
