<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'));
function epochKey($value='0'){$keys=array('ItemKeyGreen'=>range(0,2500),'ItemKeyRed'=>range(2500,5000),'ItemKeyBlue'=>range(5000,7500),'ItemKeyYellow'=>range(7500,10000),'ItemKeyBlack'=>range(10000,12500));if($value !== '0'){foreach($keys as $keyname => $keyrange){foreach($keyrange as $a => $b){if(!is_numeric($value)){if($value == $keyname.$a){return"$b";}}if(is_numeric($value)){if($value == $b){return $keyname.$a;}}}}}else{return $value;}}

function queryPlayers($and=null,$page=false,$limit=20){
$query="SELECT `P`.`PlayerName` AS `PLAYERNAME`,
`C`.`CharacterID` AS `ID`,
`C`.`PlayerUID` AS `PLAYERUID`,
`C`.`Worldspace` AS `WORLDSPACE`,
`C`.`Humanity` AS `HUMANITY`,
`C`.`LastLogin` AS `LASTLOGIN`, 
datediff(NOW(),`C`.`LastLogin`) AS `DATEDIFF`, 
`C`.`Datestamp` AS `CREATEDATE`,
`C`.`last_updated` AS `LASTUPDATE`,
`C`.`HeadshotsZ` AS `HEADSHOTS`,
`C`.`Model` AS `MODEL`,
`C`.`Inventory`	AS `INVENTORY`,
`C`.`Backpack` AS `BACKPACK`,
`C`.`Alive`	AS `ALIVE`,
`C`.`KillsZ` AS `KILLZ`,
`C`.`KillsB` AS `KILLB`,
`C`.`KillsH` AS `KILLH`,
`C`.`Generation` AS `GENERATION` 
FROM `Player_DATA` `P` INNER JOIN `Character_DATA` `C` ON ( `C`.`PlayerUID` = `P`.`PlayerUID` ) 
WHERE `C`.`InstanceID`=". (int)INSTANCE ." ".$and." ORDER BY `P`.`PlayerName` DESC, `C`.`CharacterID` ASC";	
$query .=($page !==false)?paginate($query,$limit,$page):null;
return sqlQuery($query,'fetch');
}

function searchPlayers($VALUE=null){
	if(!empty($VALUE)){
		$where = (!is_numeric($VALUE)) ? "`P`.`PlayerName` LIKE '%".secure($VALUE)."%'" : "( `C`.`PlayerUID` LIKE '%".secure($VALUE)."%' OR `C`.`CharacterID` LIKE '".(int)$VALUE."')";
		$row=sqlQuery("SELECT `P`.`PlayerName` AS `PLAYERNAME`, `C`.`CharacterID` AS `ID`, `C`.`PlayerUID` AS `PLAYERUID`, `C`.`Worldspace` AS `WORLDSPACE` FROM `Player_DATA` `P` INNER JOIN `Character_DATA` `C` ON ( `C`.`PlayerUID` = `P`.`PlayerUID` ) WHERE ".$where." AND `C`.`InstanceID`=". (int)INSTANCE ." GROUP BY `C`.`PlayerUID` ORDER BY `P`.`PlayerName` ASC ;",'fetch');
		if($row !==false){
			foreach ($row as $val){
			
				$a['id']=$val['ID'];
				$a['uid']=$val['PLAYERUID'];
				$a['playername']=$val['PLAYERNAME'];
				$a['worldspace']=$val['WORLDSPACE'];
				$out['players'][]=$a;
			}
		return json_encode($out);
		}
	}
}

function truncCharacters(){
	sqlQuery('TRUNCATE `Character_DATA`;','update');
	sqlQuery('TRUNCATE `Player_DATA`;','update');
	sqlQuery('TRUNCATE `Player_LOGIN`;','update');
}

function delCharacterDeaths(){
	sqlQuery('DELETE FROM `Character_DATA` WHERE `Alive`=0;','update');
}

function delCharacter7(){
	sqlQuery('DELETE FROM `Character_DATA` WHERE datediff( NOW(), `LastLogin` ) > 7 AND datediff( NOW(), `LastLogin` ) < 14 ;','update');
}

function delCharacter14(){
	sqlQuery('DELETE FROM `Character_DATA` WHERE datediff( NOW(), `LastLogin` ) > 14 AND datediff( NOW(), `LastLogin` ) < 28 ;','update');
}

function delCharacter28(){
	sqlQuery('DELETE FROM `Character_DATA` WHERE datediff( NOW(), `LastLogin` ) > 28 AND datediff( NOW(),`LastLogin` ) < 365 ;','update');
}

function delCharacter365(){
	sqlQuery('DELETE FROM `Character_DATA` WHERE datediff( NOW(), `LastLogin` ) > 365 ;','update');
}


function deletePlayers($VALUE=null){
	if(!empty($VALUE)){
		if(is_array($VALUE)){
			$LIMIT=count($VALUE);
			foreach ($VALUE as $ID){$IDS[]=(int)$ID;}
			return sqlQuery("DELETE FROM `Character_DATA` WHERE `CharacterID` IN ( '" . implode("','",$IDS ) . "' ) AND `InstanceID`=". (int)INSTANCE ." LIMIT ". $LIMIT  .";",'update'); 
		}
	return false;
	}
}


function updatePlayerWorldspace($VALUE=null){
	if(!empty($VALUE)){
		$DATA=isJson($VALUE);
		if($DATA !== false){
			$result=sqlQuery("UPDATE `Character_DATA` SET `Worldspace`='".secure($DATA['worldspace'])."' WHERE `CharacterID`=". (int)$DATA['id'] ." AND `InstanceID`=". (int)INSTANCE ." LIMIT 1;",'update');
		}
		return (!$result)?Notify(_an_error,'error'):Notify(success_teleport,'success');
	}
}


function updatePlayerStatus($VALUE=null){
	if(!empty($VALUE)){
		$DATA=isJson($VALUE);
		if($DATA !== false){
			$result=sqlQuery("UPDATE `Character_DATA` SET `Alive`=". (int)$DATA['status'] ." WHERE `CharacterID`=". (int)$DATA['id'] ." AND `InstanceID`=". (int)INSTANCE ." LIMIT 1;",'update');
		}
		return (!$result)?Notify(_an_error,'error'):($DATA['status']==1)?Notify(success_player_alive,'success'):Notify(success_player_dead,'success') ;
	}
}

function healPlayer($VALUE=null){
	if(!empty($VALUE)){
		$result=sqlQuery("UPDATE `Character_DATA` SET `Medical`='[false,false,false,false,false,false,false,12000,[],[0,0],0,[0,0]]' WHERE `CharacterID`=".(int)$VALUE." AND `InstanceID`=".(int)INSTANCE ." LIMIT 1;",'update');
		return (!$result)?Notify(_an_error,'error'):Notify(success_player_healed,'success');
	}
}

function updatePlayer($VALUE=null){
	if(!empty($VALUE)){
		$DATA=isJson($VALUE);
		if ($DATA!==false){
			$new=array();
			$new[]='`Humanity`='.((!empty($DATA['HUMANITY']))?(int)$DATA['HUMANITY']:0);
			$new[]='`HeadshotsZ`='.((!empty($DATA['HEADSHOTS']))?(int)$DATA['HEADSHOTS']:0);
			$new[]='`KillsZ`='.((!empty($DATA['KILLZ']))?(int)$DATA['KILLZ']:0);
			$new[]='`KillsB`='.((!empty($DATA['KILLB']))?(int)$DATA['KILLB']:0);
			$new[]='`KillsH`='.((!empty($DATA['KILLH']))?(int)$DATA['KILLH']:0);
			$new[]='`Worldspace`='.((!empty($DATA['WORLDSPACE']))? "'".secure($DATA['WORLDSPACE'])."'":"'[]'");
			$new[]='`Model`='.((!empty($DATA['MODEL'])) ? "'".secure($DATA['MODEL'])."'":"'Survivor2_DZ'");	
			$backpack[0]='';$backpack[1][0]=[];$backpack[1][1]=[];$backpack[2][0]=[];$backpack[2][1]=[];
			if(isset($DATA['INVENTORY[1]'],$DATA['INVENTORY[0]'])){		
					if(is_array($DATA['INVENTORY[1]'])&&is_array($DATA['INVENTORY[0]'])){			
						if(empty($inv0)){$inventory[0]=[];} 
						foreach($DATA['INVENTORY[0]'] as $inv0){if(!empty($inv0)){$inv0=preg_replace('/[^a-zA-Z0-9_]/',null,$inv0);$inventory[0][]=$inv0;}}
						if(empty($inv1)){$inventory[1]=[];} 
						foreach($DATA['INVENTORY[1]'] as $inv1){if(!empty($inv1)){$inv1=preg_replace('/[^a-zA-Z0-9_]/',null,$inv1);$inventory[1][]=$inv1;}}
						$inventory = json_encode($inventory);
						$new[]='`Inventory`=\''.secure($inventory).'\'';
					}
			}
			if(isset($DATA['BACKPACK[0]'])){if(!empty($DATA['BACKPACK[0]'])){$backpack[0]=trim($DATA['BACKPACK[0]']);}}
			if(isset($DATA['BACKPACK[1][0]'])&&!empty($DATA['BACKPACK[1][1]'])){ 
				if(is_array($DATA['BACKPACK[1][0]'])){
					foreach($DATA['BACKPACK[1][0]'] as $back10){if(!empty($back10)){$backpack[1][0][]=preg_replace('/[^a-zA-Z0-9_]/',null,$back10);}else{$backpack[1][0]=[];}}
				} elseif(!empty($DATA['BACKPACK[1][0]'])){
					$backpack[1][0][]=preg_replace('/[^a-zA-Z0-9_]/',null,$DATA['BACKPACK[1][0]']); 
				} 
			}
			if(isset($DATA['BACKPACK[1][1]'])&&!empty($DATA['BACKPACK[1][0]'])){ 
				if (is_array($DATA['BACKPACK[1][1]'])){
					foreach($DATA['BACKPACK[1][1]'] as $back11){if(!empty($back11)){$backpack[1][1][]=(int)preg_replace('/[^0-9_]/',null,$back11);}else{$backpack[1][1]=[];}}
				} elseif(!empty($DATA['BACKPACK[1][1]'])) {
					$backpack[1][1][]=(int)preg_replace('/[^0-9_]/',null,$DATA['BACKPACK[1][1]']); 
				} 
			}
			if(isset($DATA['BACKPACK[2][0]'])&&!empty($DATA['BACKPACK[2][1]'])){ 
				if (is_array($DATA['BACKPACK[2][0]'])){
					foreach($DATA['BACKPACK[2][0]'] as $back20){if(!empty($back20)){$backpack[2][0][]=preg_replace('/[^a-zA-Z0-9_]/',null,$back20);}else{$backpack[2][0]=[];}}
				} elseif(!empty($DATA['BACKPACK[2][0]'])){
					$backpack[2][0][]=preg_replace('/[^a-zA-Z0-9_]/',null,$DATA['BACKPACK[2][0]']); 
				} 
			}
			if(isset($DATA['BACKPACK[2][1]'])&&!empty($DATA['BACKPACK[2][0]'])){ 
				if (is_array($DATA['BACKPACK[2][1]'])){
					foreach($DATA['BACKPACK[2][1]'] as $back21){if(!empty($back21)){$backpack[2][1][]=(int)preg_replace('/[^0-9_]/',null,$back21);}else{$backpack[2][1]=[];}}
				} elseif(!empty($DATA['BACKPACK[2][1]'])) {
					$backpack[2][1][]=(int)preg_replace('/[^0-9_]/',null,$DATA['BACKPACK[2][1]']); 
				} 
			}	
			$new[]='`Backpack`=\''.secure(json_encode($backpack)).'\'';
			if(!empty($DATA['ID'])&&is_numeric($DATA['ID'])){
				$result = sqlQuery("UPDATE `Character_DATA` SET ". implode(",",$new ) ." WHERE `CharacterID`=". (int)$DATA['ID'] ." AND `InstanceID`=". (int)INSTANCE ." LIMIT 1;",'update');
				return (!$result)?Notify(_an_error,'error'):Notify(_success_change,'success');
			} else {return Notify(_an_error,'error');}
		}
	}
}


function openPlayerDialog($VALUE=null){
	if(!empty($VALUE)){
		$inv0=false;$inv1=false;$back0='';$back1=false;$back2=false;
		$invPut0='<input class="searchTools validate[custom[onlyLetterNumber]] text-input" style="float:left;font-size:11px;width:165px;" name="INVENTORY[0]" value="{$TOOLS}" type="text" placeholder="empty slot" data-prompt-position="topLeft:0" />';
		$invPut1='<input class="searchItems validate[custom[onlyLetterNumber]] text-input" style="float:left;font-size:11px;width:165px;" name="INVENTORY[1]" value="{$ITEMS}" type="text" placeholder="empty slot" data-prompt-position="topLeft:0" />';
		$backPut1='<tr><td><button class="none row-delete" type="button"><i class="icon i-delete"></i></button></td><td><input class="searchTools validate[custom[onlyLetterNumber]] text-input" name="BACKPACK[1][0]" value="{$ITEMS0}" type="text" placeholder="empty slot" data-prompt-position="topLeft:0" /></td><td><input class="validate[custom[integer]] text-input" name="BACKPACK[1][1]" value="{$ITEMS1}" type="text" placeholder="" data-prompt-position="topLeft:0" /></td></tr>';
		$backPut2='<tr><td><button class="none row-delete" type="button"><i class="icon i-delete"></i></button></td><td><input class="searchItems validate[custom[onlyLetterNumber]] text-input" name="BACKPACK[2][0]" value="{$ITEMS0}" type="text" placeholder="empty slot" data-prompt-position="topLeft:0" /></td><td><input class="validate[custom[integer]] text-input" name="BACKPACK[2][1]" value="{$ITEMS1}" type="text" placeholder="" data-prompt-position="topLeft:0" /></td></tr>';
		
		$row = queryPlayers('AND `C`.`CharacterID`='.(int)$VALUE);
		if($row !== false){
				$data=$row[0];
				$data['MODEL']=str_replace('"', '', $data['MODEL']);
				$data['INVENTORY']=isJson($data['INVENTORY']);
				$data['BACKPACK']=isJson($data['BACKPACK']);
				
				if($data['INVENTORY'] !== false){
					sort($data['INVENTORY'][0]);
					sort($data['INVENTORY'][1]);
					for($i=0;$i<=19;$i++){$items[$i]=(!isset($data['INVENTORY'][1][$i]))?'':$data['INVENTORY'][1][$i];$items[$i]=(is_array($items[$i]))?$items[$i][0]:$items[$i];$inv1 .= str_replace('{$ITEMS}',$items[$i],$invPut1);}				
					for($i=0;$i<=15;$i++){$tools[$i]=(!isset($data['INVENTORY'][0][$i]))?'':$data['INVENTORY'][0][$i];$inv0 .= str_replace('{$TOOLS}',$tools[$i],$invPut0);}			
				} 
				if(!$inv1){for($i=0;$i<=19;$i++){$inv1 .=str_replace('{$ITEMS}','',$invPut1);}}
				if(!$inv0){for($i=0;$i<=15;$i++){$inv0 .=str_replace('{$TOOLS}','',$invPut0);}}
				
				if($data['BACKPACK']!== false&&!empty($data['BACKPACK'])&&is_array($data['BACKPACK'])){	
					$back0 = $data['BACKPACK'][0];
					if(!empty($data['BACKPACK'][2])&&!empty($data['BACKPACK'][2][0])){foreach($data['BACKPACK'][2][0] as $key => $val){$back2 .=str_replace(array('{$ITEMS0}','{$ITEMS1}'),array($data['BACKPACK'][2][0][$key],$data['BACKPACK'][2][1][$key]),$backPut2);}		} 
					if(!empty($data['BACKPACK'][1])&&!empty($data['BACKPACK'][1][0])){foreach($data['BACKPACK'][1][0] as $key => $val){$back1 .=str_replace(array('{$ITEMS0}','{$ITEMS1}'),array($data['BACKPACK'][1][0][$key],$data['BACKPACK'][1][1][$key]),$backPut1);}}
				}
				#if(!$back2){$back2 = str_replace(array('{$ITEMS0}','{$ITEMS1}'),array('',''),$backPut2);}
				#if(!$back1){$back1 = str_replace(array('{$ITEMS0}','{$ITEMS1}'),array('',''),$backPut1);}	

		$temp=array(
		'$[CHARID]'=>$data['ID'],
		'$[PLAYERNAME]'=>$data['PLAYERNAME'],
		'$[PLAYERUID]'=>$data['PLAYERUID'],
		'$[WORLDSPACE]'=>$data['WORLDSPACE'],
		'$[HUMANITY]'=>$data['HUMANITY'],
		'$[KILLZ]'=>$data['KILLZ'],
		'$[ALIVE]'=>$data['ALIVE'],
		'$[HEADSHOTS]'=>$data['HEADSHOTS'],
		'$[KILLB]'=>$data['KILLB'],
		'$[KILLH]'=>$data['KILLH'],
		'$[MODEL]'=>$data['MODEL'],
		'$[IMGMODEL]'=>image($data['MODEL'],'models',$data['MODEL']),
		'$[INVENTORY1]'=>$inv1, 
		'$[INVENTORY0]'=>$inv0, 
		'$[BACKPACK0]'=>$back0,
		'$[BACKPACK1]'=>$back1,
		'$[BACKPACK2]'=>$back2,
		'$[BACKPACK2]'=>$back2,
		'$[_inventory]'=>@_inventory,
		'$[_backpack]'=>@_backpack,
		'$[_itemSlots]'=>@_itemSlots,
		'$[_toolSlots]'=>@_toolSlots,
		'$[_newSlot]'=>@_newSlot,
		'$[_close]'=>@_close,
		'$[_save]'=>@_save,
		'$[_alive]'=>@_alive,
		'$[_dead]'=>@_dead,
		'$[_heal]'=>@_heal,
		'$[_teleport]'=>@_teleport,
		'$[_change_status]'=>@_change_status,
		);
		return cRep($temp,'/contents/templates/dialog_players.php');		
		}	
	}
}


function queryObjects($and=null,$page=false,$limit=20){
$query 	= "SELECT 
`ObjectID` AS `ID`,
`Classname` AS `CLASSNAME`,
`Datestamp` AS `CREATEDATE`,
`LastUpdated` AS `LASTUPDATE`, 
datediff(NOW(),`LastUpdated`) AS `DATEDIFF`,
`CharacterID` AS `CHARID`,
`Worldspace` AS `WORLDSPACE`,
`Inventory` AS `INVENTORY`,
`Hitpoints` AS `HITPOINTS`,
`Fuel` AS `FUEL`,
`Damage` AS `DAMAGE` 
FROM `Object_DATA`WHERE `Instance`=".(int)INSTANCE ." ".$and." ORDER BY `Classname` ASC ";
$query .= ( $page !== false ) ? paginate($query,$limit,$page) : null;
return sqlQuery($query,'fetch');
} 




function truncObjects(){sqlQuery('TRUNCATE `Object_DATA`;','update');}
function delObjectDamage(){sqlQuery('DELETE FROM `Object_DATA` WHERE `Damage`=1;','update');}

function delObjectVehicles(){
	$regex='land_|storage|shed|bench|wall|floor|fence|pump|wood|hrescue|stick|pole|generator|panel|house|rack|bag|stand|barrel|canvas|wire|hedgehog|net|trap|ramp|fort|nest';
	sqlQuery("DELETE FROM `Object_DATA` WHERE `Classname` NOT REGEXP '".$regex."';",'update');
}

function delObjectObjects(){
	$regex='land_|storage|shed|bench|wall|floor|fence|pump|wood|hrescue|stick|pole|generator|panel|house|rack|bag|stand|barrel|canvas|wire|hedgehog|net|trap|ramp|fort|nest';
	sqlQuery("DELETE FROM `Object_DATA` WHERE `Classname` REGEXP '".$regex."';",'update');
}

function delObjectEmptyVehicle(){
	$regex='land_|storage|shed|bench|wall|floor|fence|pump|wood|hrescue|stick|pole|generator|panel|house|rack|bag|stand|barrel|canvas|wire|hedgehog|net|trap|ramp|fort|nest';
	sqlQuery("DELETE FROM `Object_DATA` WHERE ( `Inventory`='[[[],[]],[[],[]],[[],[]]]' || `Inventory`='[]' ) AND `Classname` NOT REGEXP '".$regex."';",'update');
}

function delObjectEmptyObjects(){
	$regex='land_|storage|shed|bench|wall|floor|fence|pump|wood|hrescue|stick|pole|generator|panel|house|rack|bag|stand|barrel|canvas|wire|hedgehog|net|trap|ramp|fort|nest';
	sqlQuery("DELETE FROM `Object_DATA` WHERE ( `Inventory`='[[[],[]],[[],[]],[[],[]]]' || `Inventory`='[]' ) AND `Classname` REGEXP '".$regex."';",'update');
}

function delObject7(){sqlQuery('DELETE FROM `Object_DATA` WHERE datediff( NOW(), `LastUpdated` ) > 7 AND datediff( NOW(), `LastUpdated` ) < 14 ;','update');}
function delObject14(){sqlQuery('DELETE FROM `Object_DATA` WHERE datediff( NOW(), `LastUpdated` ) > 14 AND datediff( NOW(), `LastUpdated` ) < 28 ;','update');}
function delObject28(){sqlQuery('DELETE FROM `Object_DATA` WHERE datediff( NOW(), `LastUpdated` ) > 28 AND datediff( NOW(), `LastUpdated` ) < 365 ;','update');}
function delObject365(){sqlQuery('DELETE FROM `Object_DATA` WHERE datediff( NOW(), `LastUpdated` ) > 365 ;','update');}
function delByObjectClass($VALUE=null){if(!empty($VALUE)){return sqlQuery("DELETE FROM `Object_DATA` WHERE `Classname`='".secure($VALUE)."' AND `Instance`=". (int)INSTANCE .";",'update');}return false;	}

function deleteObjects($VALUE=null){
	if(!empty($VALUE)){
		if(is_array($VALUE)){
			$LIMIT=count($VALUE);
			foreach($VALUE as $ID){$IDS[]=(int)$ID;} 
			return sqlQuery("DELETE FROM `Object_DATA` WHERE `ObjectID` IN ( '" . implode("','",$IDS) . "' ) AND `Instance`=". (int)INSTANCE ." LIMIT ". $LIMIT .";",'update');
		} 
	return false;
	}
}

function searchHiveObjects($VALUE=null){
	if(!empty($VALUE)){
		$where=(!is_numeric($VALUE)) ? "`Classname` LIKE '%".secure($VALUE)."%' GROUP BY `Classname`" : "`ObjectID` LIKE '%".(int)$VALUE."%' OR `CharacterID` LIKE '%".(int)$VALUE."%' ";
		$row=sqlQuery("SELECT `ObjectID`,`Classname` FROM `Object_DATA` WHERE `Instance`=". (int)INSTANCE ." AND ". $where ." ORDER BY `Classname` ASC ;",'fetch');
		
		if($row !==false){
			foreach ($row as $val){$a['id']=$val['ObjectID'];$a['classname']=$val['Classname'];$out['objects'][]=$a;}
			return json_encode($out);
		}
	}
}

function repairObject($VALUE=null){
	if(!empty($VALUE)){
		$result = sqlQuery("UPDATE `Object_DATA` SET `Hitpoints`='[]',`Damage`=0 WHERE `ObjectID`=".(int)$VALUE." AND `Instance`=".(int)INSTANCE ." LIMIT 1;",'update');
		return (!$result) ? Notify(_an_error,'error') : Notify(success_object_repair,'success');
	}
}

function refuelObject($VALUE=null){
	if(!empty($VALUE)){
		$result = sqlQuery("UPDATE `Object_DATA` SET `Fuel`=1 WHERE `ObjectID`=".(int)$VALUE." AND `Instance`=".(int)INSTANCE ." LIMIT 1;",'update');
		return (!$result) ? Notify(_an_error,'error') : Notify(success_object_refuel,'success');
	}
}


function updateObjectWorldspace($VALUE=null){
	if(!empty($VALUE)){
		$DATA=isJson($VALUE);
		if($DATA !== false){
			$result=sqlQuery("UPDATE `Object_DATA` SET `Worldspace`='".secure($DATA['worldspace'])."' WHERE `ObjectID`=". (int)$DATA['id'] ." AND `Instance`=". (int)INSTANCE ." LIMIT 1;",'update');
		}
		return (!$result)?Notify(_an_error,'error'):Notify(success_teleport,'success');
	}
}

function insertObject($VALUE=null){
$result = false;
	if(!empty($VALUE)){
		$DATA=isJson($VALUE);
		if($DATA !== false){
			$result=sqlQuery("INSERT INTO `Object_DATA` ( `ObjectUID`,`Instance`,`Classname`,`Datestamp`,`CharacterID`,`Worldspace`,`Inventory`,`Hitpoints`,`Fuel`,`Damage` ) VALUES ( ".(int)generateID(18).", ". (int)INSTANCE .", '".secure($DATA['classname'])."', NOW(), '".(int)$DATA['characterid']."', '".secure($DATA['worldspace'])."', '[]', '[]', 1, 0 );",'update');
		}
	}
return (!$result)?false:true;		
}






function updateObject($VALUE=null){
if(!empty($VALUE)){
	$DATA=isJson($VALUE);
	if($DATA !== false){
		$new=array();
		$new[]='`Classname`=' .((!empty($DATA['CLASSNAME'])) ? "'".secure($DATA['CLASSNAME'])."'":null);	
		$new[]='`Worldspace`='.((!empty($DATA['WORLDSPACE']))? "'".secure($DATA['WORLDSPACE'])."'":"'[]'");
		
		$inventory[0][0]=[];
		$inventory[0][1]=[];
		$inventory[1][0]=[];
		$inventory[1][1]=[];
		$inventory[2][0]=[];
		$inventory[2][1]=[];

			if(isset($DATA['INVENTORY[0][0]']) && !empty($DATA['INVENTORY[0][1]'])){ 
					if(is_array($DATA['INVENTORY[0][0]'])){
						foreach($DATA['INVENTORY[0][0]'] as $inv00){if(!empty($inv00)){$inventory[0][0][]= preg_replace('/[^a-zA-Z0-9_]/',null,$inv00);}else{$inventory[0][0]=[];}}
					} elseif(!empty($DATA['INVENTORY[0][0]'])){
						$inventory[0][0][]=preg_replace('/[^a-zA-Z0-9_]/',null,$DATA['INVENTORY[0][0]']); 
					} 
			}

			if(isset($DATA['INVENTORY[0][1]']) && !empty($DATA['INVENTORY[0][0]'])){
					if(is_array($DATA['INVENTORY[0][1]'])){
						foreach($DATA['INVENTORY[0][1]'] as $inv01){if(!empty($inv01)){$inventory[0][1][]=(int)preg_replace('/[^0-9_]/',null,$inv01);}else{$inventory[0][1]=[];}}
					} elseif(!empty($DATA['INVENTORY[0][1]'])){
						$inventory[0][1][]=(int)preg_replace('/[^0-9_]/',null,$DATA['INVENTORY[0][1]']);
					}
			}	
		
			if(isset($DATA['INVENTORY[1][0]']) && !empty($DATA['INVENTORY[1][1]'])){ 
					if(is_array($DATA['INVENTORY[1][0]'])){
						foreach($DATA['INVENTORY[1][0]'] as $inv10){if(!empty($inv10)){$inventory[1][0][]= preg_replace('/[^a-zA-Z0-9_]/',null,$inv10);}else{$inventory[1][0]=[];}}
					} elseif(!empty($DATA['INVENTORY[1][0]'])){
						$inventory[1][0][]=preg_replace('/[^a-zA-Z0-9_]/',null,$DATA['INVENTORY[1][0]']); 
					} 
			}
			
			if(isset($DATA['INVENTORY[1][1]']) && !empty($DATA['INVENTORY[1][0]'])){
					if(is_array($DATA['INVENTORY[1][1]'])){
						foreach($DATA['INVENTORY[1][1]'] as $inv11){if(!empty($inv11)){$inventory[1][1][]=(int)preg_replace('/[^0-9_]/',null,$inv11);}else{$inventory[1][1]=[];}}
					} elseif(!empty($DATA['INVENTORY[1][1]'])){
						$inventory[1][1][]=(int)preg_replace('/[^0-9_]/',null,$DATA['INVENTORY[1][1]']);
					}
			}	
		
			if(isset($DATA['INVENTORY[2][0]']) && !empty($DATA['INVENTORY[2][1]'])){ 
					if(is_array($DATA['INVENTORY[2][0]'])){
						foreach($DATA['INVENTORY[2][0]'] as $inv20){if(!empty($inv20)){$inventory[2][0][]=preg_replace('/[^a-zA-Z0-9_]/',null,$inv20);}else{$inventory[2][0]=[];}}
					} elseif(!empty($DATA['INVENTORY[2][0]'])){
						$inventory[2][0][]=preg_replace('/[^a-zA-Z0-9_]/',null,$DATA['INVENTORY[2][0]']); 
					} 
			}
				
			if(isset($DATA['INVENTORY[2][1]']) && !empty($DATA['INVENTORY[2][0]'])){
					if(is_array($DATA['INVENTORY[2][1]'])){
						foreach($DATA['INVENTORY[2][1]'] as $inv21){if(!empty($inv21)){$inventory[2][1][]=(int)preg_replace('/[^0-9_]/',null,$inv21);}else{$inventory[2][1]=[];}}
					} elseif(!empty($DATA['INVENTORY[2][1]'])){
						$inventory[2][1][]=(int)preg_replace('/[^0-9_]/',null,$DATA['INVENTORY[2][1]']);
					}
			}		
		}
		
	$new[] = '`Inventory`=\'' . secure(json_encode($inventory)) . '\'';	
	if (!empty($DATA['ID'])&&is_numeric($DATA['ID'])){
		$result = sqlQuery("UPDATE `Object_DATA` SET ". implode(",",$new ) ." WHERE `ObjectID`=". (int)$DATA['ID'] ." AND `Instance`=". (int)INSTANCE ." LIMIT 1;",'update');
		return (!$result) ? Notify(_an_error,'error') : Notify(_success_change,'success');
	} else { return Notify(_an_error,'error');}
	
	}
}


function openObjectDialog($VALUE=null) {
	if(!empty($VALUE)){

			$inv0='';
			$inv1='';
			$inv2='';
			$invPut0 = '<tr><td><button class="none row-delete" type="button"><i class="icon i-delete"></i></button></td><td><input class="searchTools validate[custom[onlyLetterNumber]] text-input" name="INVENTORY[0][0]" value="{$ITEMS0}" type="text" placeholder="empty slot" data-prompt-position="topLeft:0" /></td><td><input class="validate[custom[integer]] text-input" name="INVENTORY[0][1]" value="{$ITEMS1}" type="text" placeholder="" data-prompt-position="topLeft:0" /></td></tr>';
			$invPut1 = '<tr><td><button class="none row-delete" type="button"><i class="icon i-delete"></i></button></td><td><input class="searchItems validate[custom[onlyLetterNumber]] text-input" name="INVENTORY[1][0]" value="{$ITEMS0}" type="text" placeholder="empty slot" data-prompt-position="topLeft:0" /></td><td><input class="validate[custom[integer]] text-input" name="INVENTORY[1][1]" value="{$ITEMS1}" type="text" placeholder="" data-prompt-position="topLeft:0" /></td></tr>';
			$invPut2 = '<tr><td><button class="none row-delete" type="button"><i class="icon i-delete"></i></button></td><td><input class="searchBackPack validate[custom[onlyLetterNumber]] text-input" name="INVENTORY[2][0]" value="{$ITEMS0}" type="text" placeholder="empty slot" data-prompt-position="topLeft:0" /></td><td><input class="validate[custom[integer]] text-input" name="INVENTORY[2][1]" value="{$ITEMS1}" type="text" placeholder="" data-prompt-position="topLeft:0" /></td></tr>';

			$row = queryObjects('AND `ObjectID`='.(int)$VALUE);
		if ( $row !== false ) {
				$data=$row[0];
				$data['INVENTORY']=isJson($data['INVENTORY']);
		
				if ($data['INVENTORY'] !== false) {	
				
					if (isset($data['INVENTORY'][0],$data['INVENTORY'][0][0],$data['INVENTORY'][0][1])&&!empty($data['INVENTORY'][0][0])&&!empty($data['INVENTORY'][0][1])){
						foreach($data['INVENTORY'][0][0] as $key => $val ) {
						$inv0 .= str_replace(array('{$ITEMS0}','{$ITEMS1}'),array($data['INVENTORY'][0][0][$key],$data['INVENTORY'][0][1][$key]),$invPut0);
						}
					} 
					
					
					if (isset($data['INVENTORY'][1],$data['INVENTORY'][1][0],$data['INVENTORY'][1][1])&&!empty($data['INVENTORY'][1][0])&&!empty($data['INVENTORY'][1][1])){
						foreach($data['INVENTORY'][1][0] as $key => $val ) {
						$inv1 .= str_replace(array('{$ITEMS0}','{$ITEMS1}'),array($data['INVENTORY'][1][0][$key],$data['INVENTORY'][1][1][$key]),$invPut1);
						}		
					} 
					
					if (isset($data['INVENTORY'][2],$data['INVENTORY'][2][0],$data['INVENTORY'][2][1])&&!empty($data['INVENTORY'][2][0])&&!empty($data['INVENTORY'][2][1])){
						foreach($data['INVENTORY'][2][0] as $key => $val ) {
						$inv2 .= str_replace(array('{$ITEMS0}','{$ITEMS1}'),array($data['INVENTORY'][2][0][$key],$data['INVENTORY'][2][1][$key]),$invPut2);
						}		
					} 
				}
				
			#if (!$inv0){$inv0 = str_replace(array('{$ITEMS0}','{$ITEMS1}'),array('',''),$invPut0);}	
			#if (!$inv1){$inv1 = str_replace(array('{$ITEMS0}','{$ITEMS1}'),array('',''),$invPut1);}	
			#if (!$inv2){$inv2 = str_replace(array('{$ITEMS0}','{$ITEMS1}'),array('',''),$invPut2);}
			
			$temp = array(
			'$[IMGCLASS]' => image($data['CLASSNAME'],'objects',$data['CLASSNAME'],55),
			'$[OBID]'=>$data['ID'],
			'$[CLASSNAME]'=>$data['CLASSNAME'],
			'$[WORLDSPACE]'=>$data['WORLDSPACE'],
			'$[INVENTORY0]'=>$inv0,
			'$[INVENTORY1]'=>$inv1,
			'$[INVENTORY2]'=>$inv2,
			'$[_inventory]'=>@_inventory,
			'$[_backSlots]'=>@_backSlots,
			'$[_itemSlots]'=>@_itemSlots,
			'$[_toolSlots]'=>@_toolSlots,
			'$[_newSlot]'=>@_newSlot,
			'$[_close]'=>@_close,
			'$[_save]'=>@_save,
			'$[_delete]'=>@_delete,
			'$[_repair]'=>@_repair,
			'$[_refuel]'=>@_refuel,
			
			);
		return  cRep( $temp,'/contents/templates/dialog_objects.php');
		}
	}
}


function queryTrader($and=null,$page=null,$limit=20) {
	$query 	= "SELECT `id`,`item`,`qty`,`buy`,`sell`,`tid`,`afile` FROM `Traders_DATA` ".$and." ORDER BY `item` ASC ";
	$query .= ($page!== null)?paginate($query,$limit,$page):null;	
return sqlQuery($query,'fetch');
}



function searchTraderHiveData($VALUE=null){
if(!empty($VALUE)){
$where = (!is_numeric($VALUE)) ? "`item` LIKE '%".secure($VALUE)."%' GROUP BY `item`" : "`tid` LIKE '%".(int)$VALUE."%' ";

$row=sqlQuery("SELECT `id`,`item`,`tid` FROM `Traders_DATA` WHERE ". $where ." ORDER BY `item` ASC ;",'fetch');
if($row !==false){foreach ($row as $val){
$a['id']=$val['tid'];
$val['item']=(isJson($val['item']))?isJson($val['item']):$val['item'][0]=null;
$a['item']=$val['item'][0];
$out['objects'][]=$a;}return json_encode($out);}}
}

function truncateTradersData(){sqlQuery('TRUNCATE `Traders_DATA`;','update');}
function deleteTraderData($VALUE=null){if(!empty($VALUE)){if(is_array($VALUE)){$LIMIT=count($VALUE);foreach($VALUE as $ID){$IDS[]=(int)$ID;}return sqlQuery("DELETE FROM `Traders_DATA` WHERE `id` IN ( '" . implode("','",$IDS) . "' ) LIMIT ". $LIMIT .";",'update');} return false;}}


function updateTraderData($IS=null,$ID=null,$VALUE=null){
	if(isset($IS,$ID,$VALUE)&&is_numeric($ID)){
		if($IS==='qty'&&is_numeric($VALUE)){$query="UPDATE `Traders_DATA` SET `qty`=".(int)$VALUE." WHERE `id`=".(int)$ID." LIMIT 1;";}
		if($IS==='sell'&&is_array($VALUE)){
		$VALUE[0]=(int)$VALUE[0];
		$VALUE[2]=(int)$VALUE[2];
		$VALUE=json_encode($VALUE);$query="UPDATE `Traders_DATA` SET `sell`='".secure($VALUE)."' WHERE `id`=".(int)$ID." LIMIT 1;";}
		if($IS==='buy'&&is_array($VALUE)){
		$VALUE[0]=(int)$VALUE[0];
		$VALUE[2]=(int)$VALUE[2];	
		$VALUE=json_encode($VALUE);$query="UPDATE `Traders_DATA` SET `buy`='".secure($VALUE)."' WHERE `id`=".(int)$ID." LIMIT 1;";}
		if(isset($query)){sqlQuery($query,'update');}
	}
}


function insertTraderData($VALUE=null){

if(!empty($VALUE))
	$data = isJson($VALUE);	
	if ($data !== false) {	
			if(isset($data['item'],$data['qty'],$data['tid'],$data['afile'])&&is_array($data['sell'])&&is_array($data['buy'])){
				$data['sell'][0]=(int)$data['sell'][0];
				$data['buy'][0]=(int)$data['buy'][0];
				$data['qty']=(int)$data['qty'];
				$data['tid']=(int)$data['tid'];				
				$type=1;
				$type=($data['afile']==='trade_items'||$data['afile']==='trade_backpacks')?1:$type;
				$type=($data['afile']==='trade_any_vehicle')?2:$type;
				$type=($data['afile']==='trade_weapons')?3:$type;
				$query = "INSERT INTO `Traders_DATA` SET `item`='[\"".$data['item']."\",".$type."]',`qty`=".$data['qty'].",`buy`='[".$data['buy'][0].",\"".$data['buy'][1]."\",1]',`sell`='[".$data['sell'][0].",\"".$data['sell'][1]."\",1]',`afile`='".$data['afile']."',`tid`=".$data['tid'].";";
			}

		if(isset($query)){$result=sqlQuery($query,'update');return (!$result)?Notify(_an_error,'error'):Notify(_success_change,'success');}
	}	
}