<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>

$[CONTENTSCRIPTS]
<div class="overview">
	<div class="box">
		<h1>$[_latestPlayers]</h1>
		<div class="box-content">
			<table class="footable table">
				<thead>
					<tr>
						<th>UID</th>
						<th>NAME</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				$[LATESTPLAYERS]
				</tbody>
			</table>
		</div>	
	</div>	

	<div class="box">
		<h1>$[_latestObjects]</h1>
		<div class="box-content">
			<table class="footable table">
				<thead>
					<tr>
						<th>ID</th>
						<th>NAME</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				$[LATESTOBJECTS]
				</tbody>
			</table>
		</div>	
	</div>
	
	<div class="box">
		<h1>$[_inBlackListP]</h1>
		<div class="box-content">
			<table class="footable table">
				<thead>
					<tr>
						<th>ID</th>
						<th>UID</th>
						<th>NAME</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				$[BLACKLISTP]
				</tbody>
			</table>
		</div>	
	</div>
	
	<div class="box">
		<h1>$[_inBlackListOb]</h1>
		<div class="box-content">
			<table class="footable table">
				<thead>
					<tr>
						<th>ID</th>
						<th>NAME</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					$[BLACKLISTO]
				</tbody>
			</table>
		</div>	
	</div>
	
	<div class="box">
		<h1>Statistic</h1>
		<div class="box-content">
			<table class="footable table">
				<tbody>
				
					<tr>
						<td>Alive:</td>
						<td>$[RECORD_ALIVE]</td>
					</tr>
					
					<tr>
						<td>Dead:</td>
						<td>$[RECORD_DEAD]</td>
					</tr>
					
					<tr>
						<td>Headshots:</td>
						<td>$[RECORD_HS]</td>
					</tr>
					
					<tr>
						<td>Zombie Kills:</td>
						<td>$[RECORD_KZ]</td>
					</tr>
					
					<tr>
						<td>Human Kills:</td>
						<td>$[RECORD_KH]</td>
					</tr>
					
					<tr>
						<td>Bandit Kills:</td>
						<td>$[RECORD_KB]</td>
					</tr>
					
					<tr>
						<td>Vehicles:</td>
						<td>$[RECORD_V]</td>
					</tr>
					
					<tr>
						<td>Objects:</td>
						<td>$[RECORD_O]</td>
					</tr>
					
					<tr>
						<td>Empty Vehicles:</td>
						<td>$[RECORD_V_EMPTY]</td>
					</tr>
					
					<tr>
						<td>Empty Objects:</td>
						<td>$[RECORD_O_EMPTY]</td>
					</tr>		
				</tbody>
			</table>
		</div>	
	</div>
	
	<div class="box">
		<h1>Objects / Vehicles</h1>
		<div class="box-content">
			<table class="footable table">
				<tbody>
					$[RECORD_OV_COUNTER]
				</tbody>
			</table>
		</div>	
	</div>
	
</div>
