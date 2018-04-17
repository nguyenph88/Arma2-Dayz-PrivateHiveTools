<?php 
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'));

isset($_POST['addItem'])&&die(addItem($_POST['addItem']));

function addItem($VALUE=null){
	$result=false;
	if (!empty($VALUE)){
		$data=isJson($VALUE);	
		if($data !== false && is_array($data)){
			if(!empty($data['item'])){
				$query="INSERT INTO `pht_item_blacklist` ( `item` ) VALUES ( '".secure($data['item'])."' ) ";
				$result=(PHT_SQLITE===true)?@liteQuery($query,'update'):sqlQuery($query,'update');	
			}
		}
	}
return (!$result)?false:true;	
}


function deleteItem($VALUE=null){
	if(!empty($VALUE)&&is_array($VALUE)){
		$LIMIT = count($VALUE);
		foreach($VALUE as $ID){$IDS[]=(int)$ID;} 
		$query="DELETE FROM `pht_item_blacklist` WHERE `id` IN ( " . implode(",",$IDS) . " ) ";
		return (PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
	} 
return false;
}


function TableData($limit,$page) {
	$query  ="SELECT * FROM `pht_item_blacklist` ORDER BY `item` ASC";	
	#$query .=(PHT_SQLITE===true)?paginateLite($query,$limit,$page):paginate($query,$limit,$page);
	$row=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
	if ( $row !== false ){
		$out='';
		foreach ( $row as $data ) {		
			
				$out .= '<tr>';
				$out .= '<td class="highlight">'. $data['item'] .'</td>';
				$out .= '<td>'. checkbox($data['id'],'check'.$data['id']) .'</td>';
				$out .= '</tr>';
		}		
	return $out;	
 	} 
}

$content='';
if(isset($_POST['submit'])){if($_POST['submit']==='checkbox'){if(!empty($_POST['checkbox'])&&is_array($_POST['checkbox'])){$content .=(deleteItem($_POST['checkbox']))?Notify(count($_POST['checkbox']).'&nbsp;'. success_delete_entries,'success'):Notify(_an_error,'error');}}}
$temp = array(
'$[PAGE]'=>self($page),
'$[CONTENTSCRIPTS]'=>$contentScripts,
'$[TABLEDATA]'=>TableData($maxResults,$page),
'$[_deleteSelected]'=>@_deleteSelected,
'$[_submit]'=>@_submit,
'$[_addNew]'=>@_addNew,
'$[_changepass]'=>@_changepass,
'$[_infoBlackList]'=>@_infoBlackList,
'$[_edit]'=>@_edit,
'$[_classname]'=>@_classname,
'$[_close]'=>@_close,
'$[_save]'=>@_save,
);
$content .= cRep($temp,'/contents/templates/page_'.$page.'.php');	
echo $content;