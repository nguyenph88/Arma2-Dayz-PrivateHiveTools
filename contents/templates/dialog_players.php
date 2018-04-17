<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>


<script>
		var	status=$[ALIVE];
		jQuery(function($){
			if(status == 1){
			$('.status').addClass('alive');
			$('.status').empty().append('&#xf087;');
			$('.status').removeClass('dead');
				
			}else if( status == 0 ) {
			$('.status').empty().append('&#xf088;');
			$('.status').addClass('dead');
			$('.status').removeClass('alive');
			}
		});
</script>

<button style="padding:0.7em;" onclick="updatePlayerStatus('$[CHARID]','$[ALIVE]');" type="button" >$[_change_status]</button>
<button style="padding:0.7em;" onclick="healPlayer('$[CHARID]');" type="button">$[_heal]</button>
			
			
<form id="playersDialogForm" accept-charset="UTF-8">
<input type="hidden" name="ID" value="$[CHARID]" />
<div class="container">
	<fieldset>
			<label for="STATUS">Status:</label>
			<div style="padding:0.5em;color:#333333;" class="icon status"></div>
		<br />
			<label for="HUMANITY">Humanity:</label>
			<input style="width:55px;" class="validate[required,custom[integer],minSize[1]] text-input" name="HUMANITY" value="$[HUMANITY]" type="text" id="HUMANITY" data-prompt-position="bottomLeft:0" />
		<br />
			<label for="KILLZ">Zombie Kills:</label>
			<input style="width:55px;" class="validate[required,custom[integer],minSize[1]] text-input" name="KILLZ" value="$[KILLZ]" type="text" id="KILLZ" data-prompt-position="topLeft:0" />
		<br />
			<label for="HEADSHOTS">Zombie Headshots:</label>
			<input style="width:55px;" class="validate[required,custom[integer],minSize[1]] text-input" name="HEADSHOTS" value="$[HEADSHOTS]" type="text" id="HEADSHOTS" data-prompt-position="topLeft:0" />
		<br />
			<label for="KILLB">Bandit Kills:</label>
			<input style="width:55px;" class="validate[required,custom[integer],minSize[1]] text-input" name="KILLB" value="$[KILLB]" type="text" id="KILLB" data-prompt-position="topLeft:0" />
		<br />
			<label for="KILLH">Human Kills:</label>
			<input style="width:55px;" class="validate[required,custom[integer],minSize[1]] text-input" name="KILLH" value="$[KILLH]" type="text" id="KILLH" data-prompt-position="topLeft:0" />
		<br />
			<label for="BACKPACK">Backpack:</label>
			<input class="searchBackPack validate[custom[onlyLetterNumber]] text-input" name="BACKPACK[0]" value="$[BACKPACK0]" type="text" id="BACKPACK"  placeholder="NO BACKPACK" data-prompt-position="topLeft:0" />
		<br />
			<label for="MODEL">Model:</label>
			<input class="searchModel validate[required,custom[onlyLetterNumber]] text-input" name="MODEL" value="$[MODEL]" type="text" id="MODEL" data-prompt-position="topLeft:0" />
		<br />
			<label for="WORLDSPACE">Worldspace:</label>
			<input class="searchLocation validate[required] text-input" name="WORLDSPACE" value="$[WORLDSPACE]" id="WORLDSPACE" type="text" data-prompt-position="topLeft:0" />
	</fieldset>
</div>

<div id="accordion2">
		<h3>$[_inventory]: $[_itemSlots]</h3>
		<div>
			$[INVENTORY1]
		</div>
		<h3>$[_inventory]: $[_toolSlots]</h3>
		<div>
			$[INVENTORY0]
		</div>
		<h3>$[_backpack]: $[_itemSlots]</h3>	
		<div>
			<table id="backItemSlots" class="footable table">
				<tbody>
					$[BACKPACK2]
				</tbody>	

			</table>
			<button id="addBackItemSlot" class="none" type="button">$[_newSlot]</button>
		</div>
		<h3>$[_backpack]: $[_toolSlots]</h3>	
		<div>
			<table id="backToolSlots" class="footable table">
				<tbody>
					$[BACKPACK1]
				</tbody>	
			</table>
			<button id="addBackToolSlot" class="none" type="button">$[_newSlot]</button>
		</div>
</div>
</form>
<br />	
<button id="save" type="button">$[_save]</button>
<button id="close" type="button">$[_close]</button>