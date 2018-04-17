<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'));

isset($_POST['addItemPool'])&&die(addItemPool($_POST['addItemPool']));
isset($_POST['updateItemPool'])&&die(updateItemPool($_POST['updateItemPool']));
isset($_POST['openItemPoolDialog'])&&die(openItemPoolDialog($_POST['openItemPoolDialog']));


function openItemPoolDialog($VALUE=null) {
	if(!empty($VALUE)&&is_numeric($VALUE)){
		$query="SELECT `id`,`classname`,`group` FROM `pht_item_pool` WHERE `id`=".(int)$VALUE." ";
		$row=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
		if($row !== false){
		$data=$row[0];
		return cRep(
		array(
		'$[ID]'=>$data['id'],
		'$[CLASSNAME]'=>$data['classname'],
		'$[GROUP]'=>$data['group'],
		'$[_desc]'=> @_desc,
		'$[_close]'=> @_close,
		'$[_save]'=> @_save,
		'$[_deleteSelected]'=>@_deleteSelected,
		'$[_classname]'=>@_classname,
		'$[_category]'=>@_category,
		'$[_pleaseSelectA]'=>@_pleaseSelectA,
		'$[_change]'=>@_change,
		'$[_edit]'=>@_edit,
		)
		,'/contents/templates/dialog_itemPool.php');
		}
	}
}


function addItemPool($VALUE=null){
	$result=false;
	if (!empty($VALUE)){
		$result=false;
		$data=isJson($VALUE);
		if($data!== false&&!empty($data['classname'])&&!empty($data['group'])){
			$query="INSERT INTO `pht_item_pool` ( `classname`,`group` ) VALUES ( '".secure($data['classname'])."', '".secure($data['group'])."' ) ";
			$result=(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
		}
	}
return (!$result)?false:true;	
}


function updateItemPool($VALUE=null){
$result=false;
	if (!empty($VALUE)){	
		$data=isJson($VALUE);	
		if($data!==false && is_array($data)){	
			$query="UPDATE `pht_item_pool` SET `classname`='".secure($data['classname'])."',`group`='".secure($data['group'])."' WHERE `id`=".(int)$data['id']." ";
			$result=(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');	
		}
	}
return (!$result)?false:true;	
}




function deleteItemPool($VALUE=null){
$result=false;
	if(!empty($VALUE)&&is_array($VALUE)){
		foreach($VALUE as $ID){$IDS[]=(int)$ID;} 
		$query = "DELETE FROM `pht_item_pool` WHERE `id` IN ( '" . implode("','",$IDS) . "' ) ";
		$result = (PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
	} 
return (!$result)?false:true;
}


function TableData($limit,$page) {
	$query  = "SELECT `id`,`classname`,`group` FROM `pht_item_pool` ORDER BY `group` ASC";		
	$query .=(PHT_SQLITE===true) ? paginateLite($query,$limit,$page):paginate($query,$limit,$page);
	$row = (PHT_SQLITE === true) ? liteQuery($query,'fetch') : sqlQuery($query,'fetch');
	if ( $row !== false ) {
			$out = '';
		foreach ( $row as $data ) {
			$out .= '<tr>';
			$out .= '<td><button class="icon i-list" onclick="openItemPoolDialog(\''. $data['id'] .'\');" title="$[_edit]" type="button"></button></td>';
			$out .= '<td class="highlight"><p>'. $data['classname'] .'</p><span>'. image($data['classname'],(($data['group']==='MODEL')?'models':'items')) .'</span></td>';
			$out .= '<td>'. $data['group'] .'</td>';
			$out .= '<td class="highlight">'. checkbox($data['id'],'check'.$data['id']) .'</td>';
			$out .= '</tr>';
		}
	return $out;		
	} 
}





$content = '';
if(isset($_POST['submit'])){if(!empty( $_POST['checkbox']) && is_array($_POST['checkbox'])){$content .=(deleteItemPool($_POST['checkbox']))?Notify(count($_POST['checkbox']).'&nbsp;'. success_delete_entries,'success'):Notify(_an_error,'error');}}
$temp=array(
'$[PAGE]'=>self($page),
'$[CONTENTSCRIPTS]'=>$contentScripts,
'$[TABLEDATA]'=>TableData($maxResults,$page),
'$[_deleteSelected]'=>@_deleteSelected,
'$[_classname]'=>@_classname,
'$[_category]'=>@_category,
'$[_pleaseSelectA]'=>@_pleaseSelectA,
'$[_change]'=>@_change,
'$[_edit]'=>@_edit,
'$[_submit]'=>@_submit,
'$[_addNew]'=>@_addNew,
'$[_close]'=>@_close,
'$[_save]'=>@_save,
);

$content .= cRep( $temp,'/contents/templates/page_'.$page.'.php');	
echo $content;