<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'));

isset($_POST['openPlayerDialog'])&&die(openPlayerDialog($_POST['openPlayerDialog']));
isset($_POST['playerStatus'])&&die(updatePlayerStatus($_POST['playerStatus']));
isset($_POST['updatePlayer'])&&die(updatePlayer($_POST['updatePlayer']));
isset($_POST['healPlayer'])&&die(healPlayer($_POST['healPlayer']));
isset($_POST['updatePlayerWorldspace'])&&die(updatePlayerWorldspace($_POST['updatePlayerWorldspace']));
isset($_POST['openTeleport'])&&die(openTeleport($_POST['openTeleport']));

function openTeleport(){ return cRep( array('$[_toPlayer]'=>@_toPlayer,'$[_toLocation]'=>@_toLocation),'/contents/templates/dialog_teleport.php');}


function TableData($limit,$page) {

			$and = '';	
			$id = (!empty($_POST['search']['uid'])) ? trim($_POST['search']['uid']):false;
			$input = (!empty($_POST['search']['input'])) ? trim($_POST['search']['input']):false;

			if($input && is_numeric($input)) {
				$and = ' AND `C`.`PlayerUID` LIKE \'%'.(int)$input.'%\' OR `C`.`CharacterID` LIKE \'%'.(int)$input.'%\''; 
				$page = false;
			}elseif($input && !is_numeric($input)) {				
				if(GAME==='A2EPOCH') $and=' AND `P`.`PlayerName`= \''.secure($input).'\'';
				if(GAME==='DAYZMOD') $and=' AND `P`.`playerName`= \''.secure($input).'\'';				
				$page = false;
			}elseif($id && is_numeric($id)) {
				$and = ' AND `C`.`PlayerUID`='.(int)$id.''; 
				$page = false;
			}
			
			
	$row = queryPlayers($and,$page,$limit);
	if ( $row !== false ) {
			$out = '';
		foreach ( $row as $key => $data ) {
			$out .= '<tr data-status="'.(($data['ALIVE']==1)?'alive':'dead').'" class="char'.$data['ID'].'">';
			$out .= '<td>';
			$out .= '<button class="icon i-list" onclick="openPlayerDialog(\''. $data['ID'] .'\',\''. addslashes($data['PLAYERNAME']).'\',\''. $data['PLAYERUID'] .'\');" title="$[_edit]" type="button"></button>';
			$out .= '<button class="icon i-heal" onclick="healPlayer(\''. $data['ID'] .'\');" title="$[_heal]" type="button"></button>';
			$out .= '<button class="icon i-port" onclick="openTeleport(\''. $data['ID'] .'\',\''.$data['PLAYERNAME'].'\');" type="button" title="$[_teleport]"></button>';
			$out .= '<button class="icon i-change" onclick="updatePlayerStatus(\''.$data['ID'].'\',\''.$data['ALIVE'].'\');" title="$[_change_status]" type="button" ></button>';
			$out .= '</td>';
			$out .= '<td class="highlight"><p><b>'.$data['PLAYERNAME'].'</b></p></td>';
			$out .= '<td><p>'. $data['ID'] .'</p></td>';
			$out .= '<td class="highlight"><p>'. $data['PLAYERUID'] .'</p></td>';
			$out .= '<td><p><b>$[_pCreated]:</b>&nbsp;'.dateR(strtotime($data['CREATEDATE'])).'</p><p><b>$[_pLastUpdate]:</b>&nbsp;'. dateR(strtotime($data['LASTUPDATE'])).'</p><p><b>$[_pLastLogin]:</b>&nbsp;'.dateR(strtotime($data['LASTLOGIN'])).'</p></td>';
			$out .= '<td class="highlight" style="text-align:center;"><span class="icon" style="font-size:1.5em">'.(($data['ALIVE']==1)?'<b style="color:#2DB300;">&#xf087;</b>':'<b style="color:#D90000;">&#xf088;</b>').'</span></td>';
			$out .= '<td>'.checkbox($data['ID'],'check'.$data['ID']) . '</td>';
			$out .= '</tr>';
		}
	return $out;	
	}	
}


$content = '';
if(isset($_POST['submit'])&&$_POST['submit']==='checkbox'){if(!empty($_POST['checkbox'])&&is_array($_POST['checkbox'])){$content .= (deletePlayers($_POST['checkbox']))?Notify(count($_POST['checkbox']).'&nbsp;'. success_delete_player,'success'):Notify(_an_error,'error');}}
$temp = array('$[PAGE]'=>self($page),'$[CONTENTSCRIPTS]'=>$contentScripts,'$[TABLEDATA]'=>TableData($maxResults,$page),'$[_deleteSelected]'=>@_deleteSelected,'$[_all]'=>@_all,'$[_alive]'=>@_alive,'$[_dead]'=>@_dead,'$[_heal]'=>@_heal,'$[_teleport]'=>@_teleport,'$[_change_status]'=>@_change_status,'$[_edit]'=>@_edit,'$[_pCreated]'=>@_pCreated,'$[_pLastUpdate]'=>@_pLastUpdate,'$[_pLastLogin]'=>@_pLastLogin,'$[_playerMustLobby]'=>@_playerMustLobby,);
$content .= cRep( $temp,'/contents/templates/page_' . $page . '.php');	
echo $content;