<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>

$[CONTENTSCRIPTS]


<div class="container2">
	<button id="openAddAdmin" class="icon i-edit" title="$[_addNew]" type="button"></button>
	<div id="paginate" class="pagination"></div>
</div>

<div class="container">
	<form accept-charset="UTF-8" method="post">
		<table class="footable table">	
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>Name</th>
						<th>Permissions</th>
						<th>Last IP</th>
						<th>Last Login</th>
						<th><button class="icon i-delete" name="submit" value="checkbox" type="submit" onclick="return confirm(confirmMSG)" title="$[_deleteSelected]"></button></th>
					</tr>	
				</thead>
				<tbody>
					$[TABLEDATA]
				</tbody>
		</table>
	</form>	
</div>


<div id="addAdminDialog" title="$[_addNew]" style="display:none;">
	<form id="addAdminDialogForm" accept-charset="UTF-8">
		<div class="container">
			<fieldset>
				<label for="username">Name:</label>
				<input class="validate[required,minSize[4]] text-input" name="username" value="" type="text" id="username" data-prompt-position="bottomLeft:0" />
				<br />
				<label for="password">Password:</label>
				<input class="pwout validate[required,minSize[8]] text-input" name="password" value="" type="text" id="password" data-prompt-position="bottomLeft:0" />
				<button type="button" class="icon" style="font-size:17px;padding:3px" id="genpw" onclick="javascript:void(0);" title="$[_genPW]"><span class="icon">&#xf084;</span></button>
				<br />
				<br />
				<h1>Permissions</h1>
				$[LISTPERM]
			</fieldset>
		</div>
	</form>
		<br />
	<button class="submit" type="button">$[_submit]</button>
	<button class="close" type="button">$[_close]</button>	
</div>


<div id="AdminDialog" style="display:none;"></div>

<div id="changePassDialog" style="display:none;">
	<fieldset>
		<label for="password2">Password:</label>
		<input class="pwout2 validate[required,minSize[8]] text-input" name="password2" value="" type="text" id="password2" data-prompt-position="bottomLeft:0" />
		<button type="button" class="icon" style="font-size:17px;padding:3px" id="genpw2" onclick="javascript:void(0);" title="$[_genPW]"><span class="icon">&#xf084;</span></button>
	<br />
	</fieldset>
<br />
<button class="submit" type="button">$[_submit]</button>
<button class="close" type="button">$[_close]</button>	
</div>

<div id="changePermDialog" style="display:none;">
				<fieldset>
					<h1>Permissions</h1>
					$[LISTPERM]
				</fieldset>
		<br />	
<button class="submit" type="button">$[_submit]</button>
<button class="close" type="button">$[_close]</button>	
</div>