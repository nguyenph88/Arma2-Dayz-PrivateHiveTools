<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>

<div class="infoBox">$[_playerMustLobby]</div>
<div class="container2">
	<div id="paginate" class="pagination"></div>
	<div class="search">
			<form name="searchForm" accept-charset="UTF-8" method="post" action="$[PAGE]" >
				<input class="searchPlayers" name="search[input]" placeholder="PlayerName / PlayerUID / CharID" />
				<input type="hidden" name="search[uid]" />
				<button class="icon i-go" type="submit"></button>
			</form>	
	</div>	
</div>

<div class="container">
<form accept-charset="UTF-8" method="post" >
	<table class="footable">
		<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Name</th>
			<th>Char-ID</th>
			<th>Player-UID</th>
			<th>Date</th>
			<th>Status</th>
			<th><button class="icon i-delete" name="submit" value="checkbox" type="submit" onclick="return confirm(confirmMSG)" title="$[_deleteSelected]"></button></th>
		</tr>	
		</thead>
		<tbody>
		$[TABLEDATA]
		</tbody>
	</table>
</form>	
</div>

<div id="teleportDialog" style="display:none;"></div>
<div id="playersDialog" style="display:none;"></div>

$[CONTENTSCRIPTS]
