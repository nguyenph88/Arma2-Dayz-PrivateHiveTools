<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>
$[CONTENTSCRIPTS]
<div class="container2">
	<button id="openAddTrader" class="icon i-edit" title="$[_addNewTrader]" type="button"></button>
	<button id="openParseTrader" class="icon i-parser" title="server_traders.sqf Parser" type="button"></button>
	<div id="paginate" class="pagination"></div>
</div>

<div class="container">
	<form accept-charset="UTF-8" method="post">
		<table class="footable table">	
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>$[_desc]</th>
						<th>$[_classname]</th>
						<th>Tids</th>
						<th><button class="icon i-delete" name="submit" value="checkbox" type="submit" onclick="return confirm(confirmMSG)" title="$[_deleteSelected]"></button></th>
					</tr>	
				</thead>
				<tbody>
					$[TABLEDATA]
				</tbody>
		</table>
	</form>	
</div>


<div id="parseTrader" title="Trader.sqf Parser" style="display:none;">
		<textarea id="#sqf" style="width:400px;height:400px;" class="validate[required]" name="sqf" placeholder="$[_insertSqfHere]" ></textarea>
		<br /><br />
		<button style="padding:6px;" id="submitParseTrader" type="button">$[_submit]</button>
</div>

<div id="addTraderDialog" title="$[_addNewTrader]" style="display:none;">
	<form id="addTraderDialogForm" accept-charset="UTF-8">
		<div class="container">
			<fieldset>
				<label for="classname">$[_classname]:</label>
				<input class="validate[required] text-input" name="classname" value="" type="text" id="classname" data-prompt-position="bottomLeft:0" />
				<br />
				<label for="desc">$[_desc]:</label>
				<input class="validate[required] text-input" name="desc" value="" type="text" id="desc" data-prompt-position="bottomLeft:0" />
				<br />
				
				<label for="status">Status:</label>
				<select id="status" name="status" class="validate[required,custom[onlyLetterNumber]]" data-prompt-position="bottomLeft:0">
					<option value="" disabled selected>$[_pleaseSelectA] Status</option>
					<option value="friendly">friendly</option>
					<option value="neutral">neutral</option>
					<option value="hero">hero</option>
					<option value="hostile">hostile</option>
				</select>
				
				<br />
			</fieldset>
			
			<table id="tids1" class="footable table" style="width:540px;margin:0 auto;" >
				<thead>
						<tr>
							<th></th>
							<th>$[_category]</th>
							<th>Tid</th>
						</tr>
				</thead>

				<tbody>
					<tr>
						<td><button class="none row-delete" type="button"><i class="icon i-delete"></i></button></td>
						<td><input class="validate[required] text-input" name="tid0" value="" type="text" data-prompt-position="bottomLeft:0" /></td>
						<td><input style="width:80px;" class="validate[required,custom[integer],minSize[1]]" name="tid1" value="" type="text" data-prompt-position="bottomLeft:0" /></td>
					</tr>
				</tbody>
				
			</table>
			<button id="addtid1" class="none" type="button">$[_newTid]</button>
		</div>
	</form>
		<br />
	<button class="submit" type="button">$[_submit]</button>
	<button class="close" type="button">$[_close]</button>	
</div>

<div id="TraderDialog" style="display:none;"></div>