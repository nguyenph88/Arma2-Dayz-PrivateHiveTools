<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
$MAP['name'] 		= 'zargabad';
$MAP['locations'] 	= '[{"latte":"-65.47650756256365","lange":"-87.418212890625","label":"Zargabad"},{"latte":"-67.50856836293859","lange":"-104.52392578125","label":"Airfield"},{"latte":"-79.74993207509453","lange":"-68.9501953125","label":"Firuz Baharv"},{"latte":"-79.60821469998167","lange":"-102.19482421875","label":"Shahbaz"},{"latte":"-58.81374171570779","lange":"-117.158203125","label":"Nango"},{"latte":"-61.33353967329142","lange":"-135.41748046875","label":"Azizayt"},{"latte":"-58.60833366077633","lange":"-113.62060546875","label":"Factory"},{"latte":"-61.10078883158897","lange":"-73.89404296875","label":"The Villa"},{"latte":"-44.05601169578525","lange":"-93.18603515624999","label":"Hazar Bagh"},{"latte":"-39.92658842190943","lange":"-70.015869140625","label":"Military Base"},{"latte":"-70.29652611323708","lange":"-87.8851318359375","label":"Yarum"}]';
$MAP['size'] 		= 8191;
$MAP['var']			= 8193;
$MAP['div']			= 100;
$MAP['gpsX']		= 'pixel / ' . $MAP['div'];
$MAP['gpsY']		= '( '. ( $MAP['size'] + $MAP['var'] ) . '- pixel ) / ' . $MAP['div'];
$MAP['limitGPSX']	= 82;
$MAP['limitGPSY']	= 0;
$MAP['minZoom']		= 1;
$MAP['maxZoom']		= 6;
$MAP['setView']		= '[-70,-80],2';
$MAP['markerY']     = ( $MAP['size'] + $MAP['var'] ) . '- markerY';
$MAP['markerX']     = 'markerX';