<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>

<script>
//<![CDATA[
var PHT_TOKEN='$[TOKEN]';
var confirmMSG='$[_confirm]';
//]]>
</script>

<header>
	<nav>
		<ul>
		$[MENUHEADER]
		<li style="float:right;"><a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=7C3V8Y85DCYP2" title="Many Thanks for your Beans!"><img style="width:90px;" src="style/images/donate.png" alt="" /></a></li>
		</ul>
		
	</nav>
</header>

<div id="main">
	<aside class="menuLeft">
		<nav>
			<ul>$[MENULEFT]</ul>
		</nav>
	</aside>
	<section id="content" class="content">
			$[CONTENT]
	</section>
</div>


<footer>
	<ul>
		<li><span> &copy; 2014 - 9999 PrivateHiveTools $[VERSION] by Nightmare </span></li>
		<li><a target="_blank" href="http://n8m4re.de"><img src="style/images/logo1.png" alt="" /></a></li>
	</ul>
</footer>
<div style="display:none;" id="itemCatalogDia" title="Item Catalog" ></div>
<div style="display:none;" id="KeyGen" title="EpochKeyGen"><br /><input id="enterCharKey" name="epochKey" value="" placeholder="ItemKeyNameXX / CharID" />	<br /><input id="resultKey" placeholder="result" readonly /><br /><br /><button id="getKey" type="button">$[_submit]</button><button id="genKey" type="button">$[_generate]</button><br /></div>
<noscript>This page needs JavaScript activated to work!</noscript>

</body>
</html>