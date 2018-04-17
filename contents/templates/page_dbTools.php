<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>

<h1>PHT SQLiteDB</h1>
<div class="container">
	<fieldset>
		<label>Optimize:</label>
		<button style="padding:0.4em;" id="vacuum" type="button" >$[_execute]</button>
	</fieldset>
</div>

<br />

<h1>CHARACTER_DATA + PLAYER_DATA</h1>
<div class="container">
	
	<fieldset>	
			<label>$[_totalRecords]:</label>
			<input value="$[RECCHARDATA]" readonly />
			<button class="icon i-delete" title="$[_wipe]" id="truncCharacters" type="button" ></button>
		<br />
			<label>$[_corpses]:</label>
			<input value="$[RECDEATH]" readonly />
			<button class="icon i-delete" title="$[_wipe]" id="delCharacterDeaths" type="button" ></button>
		<br /><br />
		<h2>$[_lastLoggedIn]</h2>
			<label>7 $[_days]:</label>
			<input value="$[RECD7]" readonly />
			<button class="icon i-delete" title="$[_wipe]" id="delCharacter7" type="button" ></button>
		<br />
			<label>14 $[_days]:</label>
			<input value="$[RECD14]" readonly />
			<button class="icon i-delete" title="$[_wipe]" id="delCharacter14" type="button" ></button>
		<br />
			<label>28 $[_days]:</label>
			<input value="$[RECD28]" readonly />
			<button class="icon i-delete" title="$[_wipe]" id="delCharacter28" type="button" ></button>
		<br />
			<label>365 $[_days]:</label>
			<input value="$[RECD365]" readonly />
			<button class="icon i-delete" title="$[_wipe]" id="delCharacter365" type="button" ></button>
	
	</fieldset>
</div>

<br />

<h1>OBJECT_DATA</h1>
<div class="container">			
		<fieldset>
			<label>$[_totalRecords]:</label>
			<input value="$[RECOBDATA]"  readonly />
			<button class="icon i-delete" title="$[_wipe]" id="truncObjects" type="button" ></button>
		<br />
			<label>$[_damaged]:</label>
			<input value="$[RECOBDAM]" readonly />
			<button class="icon i-delete" title="$[_wipe]" id="delObjectDamage" type="button" ></button>
		<br />	
			<label>$[_vehicles]:</label>
			<input value="$[RECOBV]" readonly />
			<button class="icon i-delete" title="$[_wipe]" id="delObjectVehicles" type="button" ></button>
		<br />	
			<label>$[_objects]:</label>
			<input value="$[RECOBO]" readonly />
			<button class="icon i-delete" title="$[_wipe]" id="delObjectObjects" type="button" ></button>
		<br />
			<label>$[_empty] $[_vehicles]:</label>
			<input value="$[RECOBEMPTYV]" readonly />
			<button class="icon i-delete" title="$[_wipe]" id="delObjectEmptyVehicle" type="button" ></button>
		<br />	
			<label>$[_empty] $[_objects]:</label>
			<input value="$[RECOBEMPTYO]" readonly />
			<button class="icon i-delete" title="$[_wipe]" id="delObjectEmptyObjects" type="button" ></button>
		<br />
		<br />
		<h2>$[_lastChangeMove]</h2>
			<label>7 $[_days]:</label>
			<input value="$[REOB7]" readonly />
			<button class="icon i-delete" title="$[_wipe]" id="delObject7" type="button" ></button>
		<br />
			<label>14 $[_days]:</label>
			<input value="$[REOB14]" readonly />
			<button class="icon i-delete" title="$[_wipe]" id="delObject14" type="button" ></button>
		<br />
			<label>28 $[_days]:</label>
			<input value="$[REOB28]" readonly />
			<button class="icon i-delete" title="$[_wipe]" id="delObject28" type="button" ></button>
		<br />
			<label>365 $[_days]:</label>
			<input value="$[REOB365]" readonly />
			<button class="icon i-delete" title="$[_wipe]" id="delObject365" type="button" ></button>	
			
		 </fieldset>
	
</div>

<br />

<h1>OBJECT/VEHICLE LIST</h1>
<div class="container">	
				<table class="footable table">
				<tbody>
					$[RECLASSES]
					</tbody>
			</table>
</div>

$[CONTENTSCRIPTS]