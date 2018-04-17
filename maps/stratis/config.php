<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
$MAP['name'] 		= 'stratis';
$MAP['locations'] 	= '[{"latte":"-82.12440739532367","lange":"-64.215087890625","label":"Spartaner"},{"latte":"-71.67057415064292","lange":"-58.831787109375","label":"Agios Cephas"},{"latte":"-69.39578308847753","lange":"-49.053955078125","label":"LZ Connor"},{"latte":"-78.36714623906053","lange":"-78.651123046875","label":"Jay Bay"},{"latte":"-70.0205873017406","lange":"-88.70361328125","label":"Strogos Bay"},{"latte":"-64.86760781632728","lange":"-45.164794921875","label":"Agios loannis"},{"latte":"-52.49615953109709","lange":"7.833251953125","label":"Tsoukalia"},{"latte":"-56.66830207577005","lange":"8.953857421875","label":"Tsoukalia Bay"},{"latte":"-45.614037411350914","lange":"-35.39794921875","label":"Camp Maxwell"},{"latte":"-51.890053935216905","lange":"-92.92236328125","label":"Girna"},{"latte":"-53.357108745695996","lange":"-97.569580078125","label":"Girna Bay"},{"latte":"-24.046463999666567","lange":"-93.087158203125","label":"Camp Tempest"},{"latte":"-24.44714958973082","lange":"-101.612548828125","label":"Kyfi Bay"},{"latte":"-12.039320557540572","lange":"11.2060546875","label":"Mike-26"},{"latte":"-16.678293098288503","lange":"58.106689453125","label":"Limeri Bay"},{"latte":"9.058702156392139","lange":"91.131591796875","label":"Keiros Bay"},{"latte":"31.50362930577303","lange":"108.5009765625","label":"Kamino Bay"},{"latte":"49.61070993807422","lange":"103.07373046875","label":"Kamino Shooting Range"},{"latte":"66.99884379185184","lange":"69.93896484375","label":"Kamino Coast"},{"latte":"62.20651189841766","lange":"39.57275390625","label":"Camp Rogain"},{"latte":"59.153403092050375","lange":"-34.420166015625","label":"Military"},{"latte":"66.81787214936938","lange":"-50.394287109375","label":"Agia Marina"},{"latte":"63.89873081524394","lange":"-61.19384765625","label":"Marina Bay"},{"latte":"54.57206165565852","lange":"-94.306640625","label":"Stratis Airbase"},{"latte":"0.615222552406841","lange":"-100.08544921874999","label":"Nisi Bay"},{"latte":"11.221510260010541","lange":"10.733642578125","label":"Old Outpost"},{"latte":"46.694667307773116","lange":"21.763916015625","label":"LZ Baldy"},{"latte":"62.59334083012024","lange":"128.935546875","label":"Pythos"},{"latte":"83.97925949886205","lange":"-13.95263671875","label":"Xiros"}]';
$MAP['size'] 		= 5119;
$MAP['var']			= 8000;
$MAP['div']			= 202;
$MAP['gpsX']		= 'pixel / ' . $MAP['div'];
$MAP['gpsY']		= '( '. ( $MAP['size'] + $MAP['var'] ) . ' - pixel ) / ' . $MAP['div'];
$MAP['limitGPSX']	= 51;
$MAP['limitGPSY']	= 0;
$MAP['minZoom']		= 1;
$MAP['maxZoom']		= 6;
$MAP['setView']		= '[-10,0],2';
$MAP['markerY']     = ( $MAP['size'] + $MAP['var'] ) . '- markerY';
$MAP['markerX']     = 'markerX';