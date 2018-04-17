<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>

<div class="infoBox">
	$[_ShopInfo] 
</div>

<div class="container2">	
	<button id="openAddItem" class="icon i-edit" title="$[_addNewProduct]" type="button"></button>
	<div id="paginate" class="pagination"></div>

	<div class="search">
			<form name="searchForm" accept-charset="UTF-8" method="post" action="$[PAGE]" >
				<input class="searchTraderHiveData" name="search[input]" placeholder="$[_item] / TID" />
				<input type="hidden" name="search[id]" />
				<button class="icon i-go" type="submit"></button>
			</form>	
	</div>	
</div>

<div class="container">
<form accept-charset="UTF-8" method="post">
	<table class="footable table">	
			<thead>
				<tr>
					<th>$[_item]</th>
					<th>Trader / TID</th>
					<th>$[_stock]</th>
					<th>$[_sell]</th>
					<th>$[_buy]</th>
					<th><button class="icon i-delete" name="submit" value="checkbox" type="submit" onclick="return confirm(confirmMSG)" title="$[_deleteSelected]"></button></th>
				</tr>	
			</thead>
			
			<tbody>
				$[TABLEDATA]
			</tbody>
			
	</table>
</form>	
</div>



<div id="addItem" title="$[_addNewProduct]" style="display:none;">

		<div class="infoBox">
			$[_addItemInfo] 
		</div>

		<form id="addItemForm" accept-charset="UTF-8">
		<fieldset>
			<label for="item" >$[_item]/$[_object] Name:</label>
			<input class="validate[required,custom[onlyLetterNumber]] text-input" name="item" value="" type="text" id="item" data-prompt-position="bottomLeft:0" />
			
			<br />
			
			<label for="afile" >$[_category]</label>
			<select class="validate[required]" name="afile" id="afile" data-prompt-position="bottomLeft:0">
			<option value="" disabled selected>Select a Category</option>
			<option value="trade_items">Item</option>
			<option value="trade_backpacks">Backpack</option>
			<option value="trade_weapons">Weapon</option>
			<option value="trade_any_vehicle">Vehicle</option>
			</select>
			
			<br />
			
			<label for="sell" >$[_sell]:</label>
			<input class="validate[required,custom[integer]] text-input" name="sell" value="1" type="text" id="sell" data-prompt-position="bottomLeft:0" />
			<input style="padding:0.35em 0.5em 0.45em 0.5em;" class="searchCurrency validate[required,custom[onlyLetterNumber]] text-input" name="sell" value="" type="text" id="sell" maxlength="2" data-prompt-position="bottomLeft:0" />
			
			<br />
			
			<label for="buy" >$[_buy]:</label>
			<input class="validate[required,custom[integer]] text-input" name="buy" value="1" type="text" id="buy" data-prompt-position="bottomLeft:0" />
			<input style="padding:0.35em 0.5em 0.45em 0.5em;" class="searchCurrency validate[required,custom[onlyLetterNumber]] text-input" name="buy" value="" type="text" id="sell" maxlength="2" data-prompt-position="bottomLeft:0" />
			
			<br />
			
			<label for="qty" >$[_stock]:</label>
			<input class="validate[required,custom[integer]] text-input" name="qty" value="10" type="text" id="qty" maxlength="3" data-prompt-position="bottomLeft:0" />
			
						
			<br />
			
			<label for="tid" >Trader/TID:</label>
			<input style="width:68px;" class="validate[required,custom[integer]] text-input" name="tid" value="" type="text" id="tid" maxlength="4" data-prompt-position="bottomLeft:0" />
			
			<br /><br />
			<button style="padding:6px;" id="submitAddItem" type="button">$[_add]</button>
		</fieldset>
		</form>
</div>

$[CONTENTSCRIPTS]