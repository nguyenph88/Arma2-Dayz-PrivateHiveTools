<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>
<div class="container">
			<fieldset>
				<label>$[_toPlayer]:</label>
				<input class="telePlayer" name="playerName" placeholder="e.g. HansWurst ..." />
				<input id="a" name="worldspace" type="text" readonly />
				
			<br />
				<label>$[_toLocation]:</label>
				<input class="searchLocation" name="DESCRIPTION" placeholder="e.g. Stary ..." />
				<input id="b" name="worldspace" type="text" readonly />
				
			</fieldset>
		</div>
	<br />
<button id="tele" type="button">Teleport</button>