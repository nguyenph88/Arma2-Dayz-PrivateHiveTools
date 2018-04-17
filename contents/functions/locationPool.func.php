<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'));


isset($_POST['addLocation'])&&die(addLocation($_POST['addLocation']));
isset($_POST['updateLocation'])&&die(updateLocation($_POST['updateLocation']));
isset($_POST['openLocationPoolDialog'])&&die(openLocationPoolDialog($_POST['openLocationPoolDialog']));



function openLocationPoolDialog($VALUE=null) {
	if(!empty($VALUE)&&is_numeric($VALUE)){
		$query="SELECT `id`,`worldspace`,`description` FROM `pht_location_pool` WHERE `id`=".(int)$VALUE." ";
		$row=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
		if($row !== false){
		$data=$row[0];
		return cRep(array('$[ID]'=>$data['id'],'$[WORLDSPACE]'=>$data['worldspace'],'$[DESCRIPTION]'=>$data['description'],'$[_desc]'=> @_desc,'$[_close]'=> @_close,'$[_save]'=> @_save,),'/contents/templates/dialog_locationPool.php');
		}
	}
}


function addLocation($VALUE=null){
	$result=false;
	if (!empty($VALUE)){
		$result=false;
		$data=isJson($VALUE);
		if($data!== false&&!empty($data['worldspace'])&&!empty($data['desc'])){
			$query="INSERT INTO `pht_location_pool` ( `worldspace`,`description` ) VALUES ( '".secure($data['worldspace'])."', '".secure($data['desc'])."') ";
			$result=(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
		}
	}
return (!$result)?false:true;	
}


function updateLocation($VALUE=null){
	$result=false;
	if (!empty($VALUE)){	
		$data=isJson($VALUE);	
		if($data!==false && is_array($data)){	
			$query="UPDATE `pht_location_pool` SET `worldspace`='".secure($data['worldspace'])."',`description`='".secure($data['description'])."' WHERE `id`=".(int)$data['id']." ";
			$result=(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');	
		}
	}
return (!$result)?false:true;	
}




function deleteLocation($VALUE=null){
	if(!empty($VALUE)&&is_array($VALUE)){
		foreach($VALUE as $ID){$IDS[]=(int)$ID;} 
		$query = "DELETE FROM `pht_location_pool` WHERE `id` IN ( '" . implode("','",$IDS) . "' ) ";
		return (PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
	} 
return false;
}

function TableData($limit,$page) {
	$query  = "SELECT `id`,`worldspace`,`description` FROM `pht_location_pool` ORDER BY `description` ASC";	
	$query .=(PHT_SQLITE===true)?paginateLite($query,$limit,$page):paginate($query,$limit,$page);
	$row = (PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
	
	if ( $row !== false ) {
		$out='';
		foreach ( $row as $data ) {				
			$out .= '<tr>';
			$out .= '<td><button class="icon i-list" onclick="openLocationPoolDialog(\''. $data['id'] .'\');" title="$[_edit]" type="button"></button></td>';
			$out .= '<td class="highlight">'. $data['description'] .'</td>';
			$out .= '<td>'. $data['worldspace'] .'</td>';
			$out .= '<td class="highlight">'. checkbox($data['id'],'check'.$data['id']) .'</td>';
			$out .= '</tr>';
		}		
	return $out;	
 	} 
	
}

$content='';
if (isset($_POST['submit'])){if($_POST['submit']==='checkbox'){if(!empty($_POST['checkbox'])&&is_array($_POST['checkbox'])){$content .=(deleteLocation($_POST['checkbox']))?Notify(count($_POST['checkbox']).'&nbsp;'. success_delete_entries,'success'):Notify(_an_error,'error');}}}
$temp=array(
'$[PAGE]'=>self($page),
'$[CONTENTSCRIPTS]'=>$contentScripts,
'$[TABLEDATA]'=>TableData($maxResults,$page),
'$[_deleteSelected]'=>@_deleteSelected,
'$[_submit]'=>@_submit,
'$[_addNew]'=>@_addNew,
'$[_desc]'=>@_desc,
'$[_edit]'=>@_edit,
'$[_close]'=>@_close,
'$[_save]'=>@_save,

);
$content .= cRep( $temp, '/contents/templates/page_'.$page.'.php');	
echo $content;