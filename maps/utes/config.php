<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
$MAP['name'] 		= 'utes';
$MAP['locations'] 	= '[{"latte":"-79.43237075914709","lange":"-117.79541015625001","label":"USS Khe Sanh"},{"latte":"-36.456636011596196","lange":"13.0517578125","label":"Strelka"},{"latte":"14.604847155053898","lange":"-32.750244140625","label":"Kamenyy"},{"latte":"-21.493963563064455","lange":"-21.59912109375","label":"Airfield"}]';
$MAP['size'] 		= 5119;
$MAP['var']			= 8000;
$MAP['div']			= 202;
$MAP['gpsX']		= 'pixel / ' . $MAP['div'];
$MAP['gpsY']		= '( '. ( $MAP['size'] + $MAP['var'] ) . ' - pixel ) / ' . $MAP['div'];
$MAP['limitGPSX']	= 51;
$MAP['limitGPSY']	= 0;
$MAP['minZoom']		= 1;
$MAP['maxZoom']		= 6;
$MAP['setView']		= '[-60,-60],2';
$MAP['markerY']     = ( $MAP['size'] + $MAP['var'] ) . '- markerY';
$MAP['markerX']     = 'markerX';
