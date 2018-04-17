<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'));

isset($_POST['vacuum'])&&die(vacuum());
isset($_POST['truncCharacters'])&&die(truncCharacters());
isset($_POST['delCharacterDeaths'])&&die(delCharacterDeaths());
isset($_POST['delCharacter7'])&&die(delCharacter7());
isset($_POST['delCharacter14'])&&die(delCharacter14());
isset($_POST['delCharacter28'])&&die(delCharacter28());
isset($_POST['delCharacter365'])&&die(delCharacter365());
isset($_POST['truncObjects'])&&die(truncObjects());
isset($_POST['delObjectDamage'])&&die(delObjectDamage());
isset($_POST['delObjectVehicles'])&&die(delObjectVehicles());
isset($_POST['delObjectObjects'])&&die(delObjectObjects());
isset($_POST['delObjectEmptyVehicle'])&&die(delObjectEmptyVehicle());
isset($_POST['delObjectEmptyObjects'])&&die(delObjectEmptyObjects());
isset($_POST['delObject7'])&&die(delObject7());
isset($_POST['delObject14'])&&die(delObject14());
isset($_POST['delObject28'])&&die(delObject28());
isset($_POST['delObject365'])&&die(delObject365());
isset($_POST['delByObjectClass'])&&die(delByObjectClass($_POST['delByObjectClass']));

class dbTools {

	public $p;
	public $o;
	
	public function __construct() {
		$this->p=queryPlayers();
		$this->o=queryObjects();
	}
	
	function recordCharData($a=1){
		$data=$this->p;
		$count=0;
		if($data !== false){
			if($a===1) $count = count($data);
			if($a===2){foreach($data as $val){if($val['ALIVE']==0){$count++;}}}
			if($a===3){foreach($data as $val){if($val['DATEDIFF'] > 7 && $val['DATEDIFF'] < 14){$count++;}}}
			if($a===4){foreach($data as $val){if($val['DATEDIFF'] > 14 && $val['DATEDIFF'] < 28){$count++;}}}
			if($a===5){foreach($data as $val){if($val['DATEDIFF'] > 28 && $val['DATEDIFF'] < 365){$count++;}}}
			if($a===6){foreach($data as $val){if($val['DATEDIFF'] > 365){$count++;}}}
		}
	return $count;	
	}
	
	function recordObData($a=1){
		$data=$this->o;
		$count=0;
		$regex='/land_|storage|shed|bench|wall|floor|fence|pump|wood|hrescue|stick|pole|generator|panel|house|rack|bag|stand|barrel|canvas|wire|hedgehog|net|trap|ramp|fort|nest/i';
		if($data!==false){
				if($a===1) $count = count($data);
				if($a===2){foreach($data as $val){if($val['DAMAGE']==1){$count++;}}}
				if($a===3){foreach($data as $val){if(!preg_match($regex,$val['CLASSNAME'])&&($val['INVENTORY']=='[[[],[]],[[],[]],[[],[]]]'||$val['INVENTORY']=='[]')){$count++;}}}
				if($a===4){foreach($data as $val){if(preg_match($regex,$val['CLASSNAME'])&&($val['INVENTORY']=='[[[],[]],[[],[]],[[],[]]]'||$val['INVENTORY']=='[]')){$count++;}}}
				if($a===5){foreach($data as $val){if(!preg_match($regex,$val['CLASSNAME'])){$count++;}}}
				if($a===6){foreach($data as $val){if(preg_match($regex,$val['CLASSNAME'])){$count++;}}}	
				if($a===7){foreach($data as $val){if($val['DATEDIFF'] > 7 && $val['DATEDIFF'] < 14){$count++;}}}
				if($a===8){foreach($data as $val){if($val['DATEDIFF'] > 14 && $val['DATEDIFF'] < 28){$count++;}}}
				if($a===9){foreach($data as $val){if($val['DATEDIFF'] > 28 && $val['DATEDIFF'] < 365){$count++;}}}
				if($a===10){foreach($data as $val){if($val['DATEDIFF'] > 365){$count++;}}}	
				if($a===11){
					$count='';
					$class=array();
					foreach($data as $v){$class[]=$v['CLASSNAME'];}				
					ksort($class);
					foreach( array_count_values($class) as $key => $val){						
						$count .= '<tr>';
						$count .= '<td><button class="icon i-delete" title="$[_wipe]" onclick="delByObjectClass(\''.$key.'\')" type="button" ></button></td>';
						$count .= '<td class="highlight">'.$val.'</td>';
						$count .= '<td><span>'.image($key,'objects','',45).'</span> '.$key.'</td>';
						$count .= '</tr>';
					}
				}		
		}
	return $count;
	}
}



	
$das=new dbTools();
	
$temp = array(
'$[PAGE]'			=>self($page),
'$[CONTENTSCRIPTS]'	=>$contentScripts,
'$[RECCHARDATA]'	=>$das->recordCharData(1),
'$[RECDEATH]'		=>$das->recordCharData(2),
'$[RECD7]'			=>$das->recordCharData(3),
'$[RECD14]'			=>$das->recordCharData(4),
'$[RECD28]'			=>$das->recordCharData(5),
'$[RECD365]'		=>$das->recordCharData(6),
'$[RECOBDATA]'		=>$das->recordObData(1),
'$[RECOBDAM]'		=>$das->recordObData(2),
'$[RECOBEMPTYV]'	=>$das->recordObData(3),
'$[RECOBEMPTYO]'	=>$das->recordObData(4),
'$[RECOBV]'			=>$das->recordObData(5),
'$[RECOBO]'			=>$das->recordObData(6),
'$[REOB7]'			=>$das->recordObData(7),
'$[REOB14]'			=>$das->recordObData(8),
'$[REOB28]'			=>$das->recordObData(9),
'$[REOB365]'		=>$das->recordObData(10),
'$[RECLASSES]'		=>$das->recordObData(11),
'$[_totalRecords]'	=>@_totalRecords,
'$[_damaged]'		=>@_damaged,
'$[_vehicles]'		=>@_vehicles,
'$[_corpses]'		=>@_corpses,
'$[_objects]'		=>@_objects,
'$[_empty]'			=>@_empty,
'$[_wipe]'			=>@_wipe,
'$[_days]'			=>@_days,
'$[_lastChangeMove]'=>@_lastChangeMove,
'$[_lastLoggedIn]'=>@_lastLoggedIn,
'$[_execute]'=>@_execute,

);
echo cRep($temp,'/contents/templates/page_'.$page.'.php');