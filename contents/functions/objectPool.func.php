<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'));

isset($_POST['addObject'])&&die(addObject($_POST['addObject']));
isset($_POST['updateObjectPool'])&&die(updateObjectPool($_POST['updateObjectPool']));
isset($_POST['openObjectPoolDialog'])&&die(openObjectPoolDialog($_POST['openObjectPoolDialog']));


function openObjectPoolDialog($VALUE=null) {
	if(!empty($VALUE)&&is_numeric($VALUE)){
		$query="SELECT `id`,`classname` FROM `pht_object_pool` WHERE `id`=".(int)$VALUE." ";
		$row=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
		if($row !== false){
		$data=$row[0];
		return cRep(
		array(
		'$[ID]'=>$data['id'],
		'$[CLASSNAME]'=>$data['classname'],
		'$[_close]'=> @_close,
		'$[_save]'=> @_save,
		'$[_deleteSelected]'=>@_deleteSelected,
		'$[_classname]'=>@_classname,
		'$[_category]'=>@_category,
		'$[_pleaseSelectA]'=>@_pleaseSelectA,
		'$[_change]'=>@_change,
		'$[_edit]'=>@_edit,
		)
		,'/contents/templates/dialog_objectPool.php');
		}
	}
}


function addObject($VALUE=null){
	$result=false;
	if (!empty($VALUE)){
		$result=false;
		$data=isJson($VALUE);
		if($data!== false&&!empty($data['classname'])){
			$query="INSERT INTO `pht_object_pool` ( `classname` ) VALUES ( '".secure($data['classname'])."' ) ";
			$result=(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
		}
	}
return (!$result)?false:true;	
}


function updateObjectPool($VALUE=null){
	$result=false;
	if (!empty($VALUE)){	
		$data=isJson($VALUE);	
		if($data!==false && is_array($data)){	
			$query="UPDATE `pht_object_pool` SET `classname`='".secure($data['classname'])."' WHERE `id`=".(int)$data['id']." ";
			$result=(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');	
		}
	}
return (!$result)?false:true;	
}




function deleteObjectPool($VALUE=null){
	if(!empty($VALUE)&&is_array($VALUE)){
		foreach($VALUE as $ID){$IDS[]=(int)$ID;} 
		$query = "DELETE FROM `pht_object_pool` WHERE `id` IN ( '" . implode("','",$IDS) . "' ) ";
		return (PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
	} 
return false;
}


function TableData($limit,$page) {
	$query  = "SELECT `id`,`classname` FROM `pht_object_pool` ORDER BY `classname` ASC";	
	$query .=(PHT_SQLITE===true)?paginateLite($query,$limit,$page):paginate($query,$limit,$page);
	$row = ( PHT_SQLITE === true) ? liteQuery($query,'fetch') : sqlQuery($query,'fetch');
	if ( $row !== false ) {
			$out = '';
		foreach ( $row as $data ) {	
			$out .= '<tr>';
			$out .= '<td><button class="icon i-list" onclick="openObjectPoolDialog(\''. $data['id'] .'\');" title="$[_edit]" type="button"></button></td>';
			$out .= '<td class="highlight"><p>'. $data['classname'] .'</p><span>'. image($data['classname'],'objects'). '</span></td>';
			$out .= '<td>'. checkbox($data['id'],'check'.$data['id']) .'</td>';
			$out .= '</tr>';
		}		
	return $out;	
 	} 
	
}


$content = '';
if(isset($_POST['submit'])){if($_POST['submit']==='checkbox'){if(!empty($_POST['checkbox'])&&is_array($_POST['checkbox'])){$content .= (deleteObjectPool($_POST['checkbox']))?Notify(count($_POST['checkbox']).'&nbsp;'. success_delete_object,'success'):Notify(_an_error,'error');}}}
$temp = array(
'$[PAGE]'				=> self($page),
'$[CONTENTSCRIPTS]'		=> $contentScripts,
'$[TABLEDATA]'			=> TableData($maxResults,$page),
'$[_deleteSelected]' 	=> @_deleteSelected,
'$[_submit]'			=> @_submit,
'$[_edit]'				=> @_edit,
'$[_close]'				=> @_close,
'$[_classname]'			=> @_classname,
'$[_addNew]'			=> @_addNew,
);

$content .= cRep( $temp, '/contents/templates/page_'.$page.'.php');	
echo $content;