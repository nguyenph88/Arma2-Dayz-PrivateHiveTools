<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>

<button style="padding:0.7em;" onclick="repairObject('$[OBID]');" type="button">$[_repair]</button>
<button style="padding:0.7em;" onclick="refuelObject('$[OBID]');" type="button" >$[_refuel]</button>

<form id="objectDialogForm" accept-charset="UTF-8">

<input type="hidden" name="ID" value="$[OBID]" />

	<div class="container">
		<fieldset>
			<label for="CLASSNAME">Classname:</label>
			<input class="searchObjects validate[required,custom[onlyLetterNumber]] text-input" name="CLASSNAME" value="$[CLASSNAME]" type="text" id="CLASSNAME" data-prompt-position="bottomLeft:0" />
		<br />
			<label for="WORLDSPACE">Worldspace:</label>
			<input class="searchLocation validate[required] text-input" name="WORLDSPACE" value="$[WORLDSPACE]" type="text" id="WORLDSPACE" data-prompt-position="bottomLeft:0" />
			<br />
		</fieldset>
	</div>
	
		<div id="accordion">
			<h3>$[_inventory]: $[_toolSlots]</h3>
			<div>
				<table id="INVENTORY0" class="footable table">
					<tbody>
						$[INVENTORY0]
					</tbody>	
				</table>
				<button id="addINVENTORY0" class="none" type="button">$[_newSlot]</button>
			</div>
			<h3>$[_inventory]: $[_itemSlots]</h3>
			<div>
				<table id="INVENTORY1" class="footable table">
					<tbody>
						$[INVENTORY1]
					</tbody>	
				</table>
				<button id="addINVENTORY1" class="none" type="button">$[_newSlot]</button>
			</div>
			<h3>$[_inventory]: $[_backSlots]</h3>
			<div>
				<table id="INVENTORY2" class="footable table">
					<tbody>
						$[INVENTORY2]
					</tbody>	
				</table>
				<button id="addINVENTORY2" class="none" type="button">$[_newSlot]</button>
			</div>
	</div>

</form>
	<br />
	<br />
	<br />
<button id="save" type="button">$[_save]</button>
<button id="close" type="button">$[_close]</button>	
<button id="close" onclick="deleteObject('$[OBID]');" type="button" >$[_delete]</button>