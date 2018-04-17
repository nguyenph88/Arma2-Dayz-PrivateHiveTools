<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'));

isset($_POST['openObjectDialog'])&&die(openObjectDialog($_POST['openObjectDialog']));
isset($_POST['updateObject'])&&die(updateObject($_POST['updateObject']));
isset($_POST['repairObject'])&&die(repairObject($_POST['repairObject']));
isset($_POST['refuelObject'])&&die(refuelObject($_POST['refuelObject']));
isset($_POST['updateObjectWorldspace'])&&die(updateObjectWorldspace($_POST['updateObjectWorldspace']));
isset($_POST['openTeleport'])&&die(openTeleport($_POST['openTeleport']));
isset($_POST['insertObject'])&&die(insertObject($_POST['insertObject']));
isset($_POST['deleteObject'])&&die(deleteObjects($_POST['deleteObject']));

function openTeleport(){ return cRep( array('$[_toPlayer]'=>@_toPlayer,'$[_toLocation]'=>@_toLocation),'/contents/templates/dialog_teleport.php');}

function TableData($limit,$page){

		$and = '';
			 $id = (!empty($_POST['search']['id'])) ? trim($_POST['search']['id']):false;
			 $input = (!empty($_POST['search']['input'])) ? trim($_POST['search']['input']):false;
			if( $input && is_numeric($input)) {
				$and = ' AND `ObjectID` LIKE \'%'.(int)$input.'%\' OR `CharacterID` LIKE \'%'.(int)$input.'%\' '; 
				$page = false;
			} elseif($input && !is_numeric($input)) {
				$and = ' AND `Classname` LIKE \'%'.secure($input).'%\' '; 
				$page = false;
			} elseif($id && is_numeric($id)) {
				$and = ' AND `ObjectID`='.(int)$id.''; 
				$page = false;
			}
		
		

	$row = queryObjects($and,$page,$limit);
	if ( $row !== false ) {
	$out = '';
	foreach ( $row as $key => $data ) {
	
				$CHARID = ( defined('GAME') == 'A2EPOCH' ) ? $data['CHARID'] .'&nbsp;/&nbsp;'. epochKey($data['CHARID']): $data['CHARID'];
				
				$dirImg = 'style/images/objects/'.strtolower($data['CLASSNAME']).'.png';

				$out .= '<tr class="tooltip ob'.$data['ID'].'" data-dir="'.$dirImg.'" >';
				$out .= '<td>';
				$out .= '<button class="icon i-list" onclick="openObjectDialog(\''. $data['ID'] .'\',\''.$data['CLASSNAME'].'\');" type="button" title="$[_edit]"></button>';
				$out .= '<button class="icon i-repair" onclick="repairObject(\''. $data['ID'] .'\');" type="button" title="$[_repair]"></button>';
				$out .= '<button class="icon i-fuel" onclick="refuelObject(\''. $data['ID'] .'\');" type="button" title="$[_refuel]"></button>';
				$out .= '<button class="icon i-port" onclick="openTeleport(\''. $data['ID'] .'\',\''.$data['CLASSNAME'].'\');" type="button" title="$[_teleport]"></button>';
				$out .= '</td>';
				$out .= '<td class="highlight"><p><b>'.$data['CLASSNAME'].'</b></p></td>';
				$out .= '<td><p>'.$data['ID'] .'</p></td>';
				$out .= '<td class="highlight"><p>'. $CHARID .'</p></td>';
				$out .= '<td><p>'. round($data['DAMAGE']*100) .'%</p></td>';
				$out .= '<td class="highlight"><p>'. round($data['FUEL']*100) .'%</p></td>';	
				$out .= '<td><p><b>$[_pCreated]:</b>&nbsp;'.dateR(strtotime($data['CREATEDATE'])).'</p><p><b>$[_pLastUpdate]:</b>&nbsp;'. dateR(strtotime($data['LASTUPDATE'])).'</p></td>';
				$out .= '<td class="highlight">'. checkbox($data['ID'],'check'.$data['ID']) .'</td>';
				$out .= '</tr>';
			}
	return $out;		
	}
}

$content = '';
if(isset($_POST['submit'])){if(!empty($_POST['checkbox'])&&is_array($_POST['checkbox'])){$content .= (deleteObjects($_POST['checkbox']))?Notify(count($_POST['checkbox']).'&nbsp;'. success_delete_object,'success'):Notify(_an_error,'error');}}
$temp=array(
'$[PAGE]'=>self($page),
'$[CONTENTSCRIPTS]'=>$contentScripts,
'$[TABLEDATA]'=>TableData($maxResults,$page),
'$[_deleteSelected]'=>@_deleteSelected,
'$[_all]'=>@_all,
'$[_objects]'=>@_objects,
'$[_vehicles]'=>@_vehicles,
'$[_repair]'=>@_repair,
'$[_teleport]'=>@_teleport,
'$[_refuel]'=>@_refuel,
'$[_change]'=>@_change,
'$[_edit]'=>@_edit,
'$[_pCreated]'=>@_pCreated,
'$[_pLastUpdate]'=>@_pLastUpdate,
'$[_pLastLogin]'=>@_pLastLogin,
'$[_afterServerRestart]'=>@_afterServerRestart,
'$[_addNew]'=>@_addNew,
'$[_close]'=> @_close,
'$[_classname]'=>@_classname,

);
$content .= cRep( $temp,'/contents/templates/page_'.$page.'.php');	
echo $content;