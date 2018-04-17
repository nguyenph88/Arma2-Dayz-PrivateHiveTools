<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'));

include_once( DIR . '/maps/'. GAMEMAP .'/config.php');

isset($_GET['returnLocations'])&&die(jsonHeader($MAP['locations']));
isset($_GET['returnPlayers'])&&die(jsonHeader(returnPlayers($MAP)));
isset($_GET['returnVehicles'])&&die(jsonHeader(returnVehicles($MAP)));
isset($_GET['returnObjects'])&&die(jsonHeader(returnObjects($MAP)));
isset($_POST['deleteObjects'],$_POST['ids'])&&die(deleteObjects($_POST['ids']));
isset($_POST['insertObject'])&&die(insertObject($_POST['insertObject']));
isset($_POST['updatePlayerWorldspace'])&&die(updatePlayerWorldspace($_POST['updatePlayerWorldspace']));


#function addMapMarkerToDB($LABEL,$Y,$X){$query = "INSERT INTO `pht_map_marker` SET `latte`='".$Y."', `lange`='".$X."', `label`='".$LABEL."' ;";return sqlQuery($query,'in');}

function returnPlayers($MAP) {
$out = array();
$data = array();
		
		$and = "AND `C`.`last_updated` > DATE_SUB( NOW(), INTERVAL 2 MINUTE ) ";
		#$and = "AND `C`.`Alive`=1 AND `C`.`CharacterID`=25326";
		$rows = queryPlayers($and);
		
		//printR($rows);
		if ( $rows !== false && is_array($rows) ) {	
				
				foreach( $rows as $row ) {
				
						
					$coord = isJson($row['WORLDSPACE']);
					$coord = (!is_array($coord)||empty($coord)) ? [0,[0,0,0]] : $coord;
					$data[$row['ID']]['uid'] 	 = $row['PLAYERUID'];
					$data[$row['ID']]['name'] 	 = $row['PLAYERNAME'];	
					//$data[$row['ID']]['angla'] 	 = $coord[0];
					$data[$row['ID']]['markerX'] = $coord[1][0];
					$data[$row['ID']]['markerY'] = $coord[1][1];	
				}

		}
return json_encode($data);
}	
	
	
function returnVehicles($MAP) {
$out  = array();
$data = array();
		$regex='land_|storage|shed|bench|wall|floor|fence|pump|wood|hrescue|stick|pole|generator|panel|house|rack|bag|stand|barrel|canvas|wire|hedgehog|net|trap|ramp|fort|nest';
		$and  = "AND `Classname` NOT REGEXP '".$regex."'";
		$rows = queryObjects($and);
	
		//printR($rows);
		if ( $rows !== false ) {	
				foreach( $rows as $row ) {
					
					$coord = isJson($row['WORLDSPACE']);
					$coord = (!is_array($coord)||empty($coord)) ? [0,[0,0,0]] : $coord;
					
					$data[$row['ID']]['classname'] = $row['CLASSNAME'];	
					//$data[$row['ID']]['angla'] 	= $coord[0];
					$data[$row['ID']]['markerX'] 	= $coord[1][0];
					$data[$row['ID']]['markerY'] 	= $coord[1][1];	
			}

		}
return json_encode($data);
}		
	
function returnObjects($MAP) {
$out  = array();
$data = array();
		$regex='land_|storage|shed|bench|wall|floor|fence|pump|wood|hrescue|stick|pole|generator|panel|house|rack|bag|stand|barrel|canvas|wire|hedgehog|net|trap|ramp|fort|nest';
		$and  = "AND `Classname` REGEXP '".$regex."'";
		$rows = queryObjects($and);
	
		//printR($rows);
		if ( $rows !== false ) {	
				foreach( $rows as $row ) {
					
					$coord = isJson($row['WORLDSPACE']);
					$coord = (!is_array($coord)||empty($coord)) ? [0,[0,0,0]] : $coord;
					
					$data[$row['ID']]['classname'] = $row['CLASSNAME'];	
					//$data[$row['ID']]['angla'] 	= $coord[0];
					$data[$row['ID']]['markerX'] 	= $coord[1][0];
					$data[$row['ID']]['markerY'] 	= $coord[1][1];	
			}

		}
return json_encode($data);
}		
	
#function returnMarkersStaticFromDB(){$out='';$query="SELECT * FROM `pht_map_marker` ;";$rows=sqlQuery($query,'fetch');if($rows !== false){foreach($rows as $data){$out .='location.addLayer( new L.Marker(['.$data['latte'].','.$data['lange'].'],{ icon: new LocationIcon({ labelText:\''.$data['label'].'\'})}));'."\n";}}return $out;}

$content='';
$temp = array(
'$[PAGE]'			=>self($page),
'$[CONTENTSCRIPTS]'	=>$contentScripts,
'$[MAPname]'		=>@$MAP['name'],
'$[MAPgpsX]'		=>@$MAP['gpsX'],
'$[MAPgpsY]'		=>@$MAP['gpsY'],
'$[MAPgpsY]'		=>@$MAP['gpsY'],

'$[MAPmarkerX]'		=>@$MAP['markerX'],
'$[MAPmarkerY]'		=>@$MAP['markerY'],

'$[MAPlimitGPSX]'	=>@$MAP['limitGPSX'],
'$[MAPlimitGPSY]'	=>@$MAP['limitGPSY'],
'$[MAPmaxZoom]'		=>@$MAP['maxZoom'],
'$[MAPminZoom]'		=>@$MAP['minZoom'],
'$[MAPsetView]'		=>@$MAP['setView'],
'$[MAPvar]'			=>@$MAP['var'],
'$[MAPsize]' 		=>@$MAP['size'],

'$[_delete]' 		=>@_delete,
'$[_waste]' 		=>@_waste,
'$[_addToWaste]' 	=>@_addToWaste,
);

$content .= cRep( $temp, '/contents/templates/page_'.$page.'.php');	
echo $content;