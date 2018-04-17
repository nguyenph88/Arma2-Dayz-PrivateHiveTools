<?php 
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'));

isset($_GET['parseTraderPool'],$_POST['value'])&&die(parseTraderPool($_POST['value']));
isset($_POST['openTraderDialog'])&&die(openTraderDialog($_POST['openTraderDialog']));
isset($_POST['updateTrader'])&&die(updateTrader($_POST['updateTrader']));
isset($_POST['addTrader'])&&die(addTrader($_POST['addTrader']));


function addTrader($VALUE=null){
	$result=false;$new=array();
	if (!empty($VALUE)){
		$data=isJson($VALUE);	
		if($data !== false){			
			if(is_array($data['tid0'])&&is_array($data['tid1'])){		
				foreach ($data['tid0'] as $k=>$v){$tid[$k][]=$v;$tid[$k][]=(int)$data['tid1'][$k];}
			} else {
				$tid[0][]=$data['tid0'];
				$tid[0][]=(int)$data['tid1'];
			}
			if (isset($tid)){		
				$new[]=$tid;
				$new[]=[];
				$new[]=$data['status'];	
				$new=json_encode($new);
				$query="INSERT INTO `pht_trader_pool` ( `classname`, `desc`, `data` ) VALUES ( '".secure($data['classname'])."', '".secure($data['desc'])."', '".secure($new)."' )";
				$result=(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');		
			}
		}
	}
return (!$result)?false:true;	
}


function deleteTrader($VALUE=null){
	if(!empty($VALUE)&&is_array($VALUE)){
		foreach($VALUE as $ID){$IDS[]=(int)$ID;} 
		$query="DELETE FROM `pht_trader_pool` WHERE `id` IN ( " . implode(",",$IDS) . " ) ";
		return (PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
	} 
return false;
}


function updateTrader($VALUE=null){
	$result=false;$new=array();
	if (!empty($VALUE)){	
		$data=isJson($VALUE);			
		if($data !== false){		
			if(is_array($data['tid0'])&&is_array($data['tid1'])){		
				foreach ($data['tid0'] as $k=>$v){$tid[$k][]=$v;$tid[$k][]=(int)$data['tid1'][$k];}
			} else {
				$tid[0][]=$data['tid0'];
				$tid[0][]=(int)$data['tid1'];
			}	
			if (isset($tid)){		
				$new[]=$tid;
				$new[]=[];
				$new[]=$data['status'];	
				$new=json_encode($new);
				$query="UPDATE `pht_trader_pool` SET `classname`='".secure($data['classname'])."',`desc`='".secure($data['desc'])."',`data`='".secure($new)."' WHERE `id`=".(int)$data['id']." ";
				$result=(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');		
			}
		}
	}
return (!$result)?false:true;	
}


function parseTraderPool($INPUT=null){
	$result=false;
	if (!empty($INPUT)){
	
		$INPUT=base64_decode($INPUT);
	
		if (!isASCII($INPUT) && !isUTF8($INPUT)) {
			$INPUT = convertEncoding('ISO-8859-1', 'UTF-8', $INPUT);
		}
		
		$r1=explode('//',trim($INPUT));
		if(is_array($r1)){
			$s=array();
			foreach($r1 as $k1 => $v1){		
				if(mb_strpos($v1,'menu_')){
					$s[$k1]['desc']=trim(mb_strstr($v1,'menu_',-1));
					$v1=strstr($v1,'menu_');
					$v1=str_ireplace(array(';','menu_'),null,$v1);
					$r2=explode('= ',$v1);
					$s[$k1]['classname']=trim($r2[0]); 
					$s[$k1]['data']=trim(str_ireplace(array("\t","\n","\r"),null,$r2[1]));
				}
			}	
		}	
		if(isset($s)&&is_array($s)){
			foreach($s as $i){
			$i['classname']=strip_tags($i['classname']);
			$i['desc']=strip_tags($i['desc']);
			$i['data']=strip_tags($i['data']);
			$inserts[]="( '".$i['classname']."', '".$i['desc']."', '".$i['data']."' )";
			}
		}
		
		if(isset($inserts)&&is_array($inserts)){
			(PHT_SQLITE===true)?liteQuery('DELETE FROM `pht_trader_pool` ','update'):sqlQuery('TRUNCATE `pht_trader_pool` ','update');
			$query="INSERT INTO `pht_trader_pool` ( `classname`, `desc`, `data` ) VALUES ".implode(',',$inserts)." ";
			$result=(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
		} else {
			echo Notify( @_an_error_parse,'error');
		}
	
	}
return (!$result)?false:true;
}

function openTraderDialog($VALUE=null) {
	if(!empty($VALUE)&&is_numeric($VALUE)){
		$query="SELECT `id`,`classname`,`data`,`desc` FROM `pht_trader_pool` WHERE `id`=".(int)$VALUE." ";
		$row=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
		if ( $row !== false ) {
				$data=$row[0];		
				$tids=isJson($data['data']);
					$out='';
			if($tids!==false&&!empty($tids[0])&&!empty($tids[2])){			
					foreach($tids[0] as $tid){	
					$out .= '<tr>';
					$out .= '<td><button class="none row-delete" type="button"><i class="icon i-delete"></i></button></td>';
					$out .= '<td><input class="validate[required] text-input" name="tid0" value="'.$tid[0].'" type="text" data-prompt-position="bottomLeft:0" /></td>';
					$out .= '<td><input style="width:80px;" class="validate[required,custom[integer],minSize[1]]" name="tid1" value="'.$tid[1].'" type="text" data-prompt-position="bottomLeft:0" /></td>';
					$out .= '</tr>';
					}
				} else {
					$tids[2] = 'friendly';		
					$out .= '<tr>';
					$out .= '<td><button class="none row-delete" type="button"><i class="icon i-delete"></i></button></td>';
					$out .= '<td><input class="validate[required] text-input" name="tid0" value="" type="text" data-prompt-position="bottomLeft:0" /></td>';
					$out .= '<td><input style="width:80px;" class="validate[required,custom[integer],minSize[1]]" name="tid1" value="" type="text" data-prompt-position="bottomLeft:0" /></td>';
					$out .= '</tr>';
				}
		return cRep(array('$[ID]'=>$data['id'],'$[TID]' =>$out,'$[STATUS]' =>$tids[2],'$[CLASSNAME]'=>$data['classname'],'$[DESC]'=>$data['desc'],'$[_category]'=>@_category,'$[_classname]'=>@_classname,'$[_close]'=>@_close,'$[_save]'=>@_save,'$[_desc]'=>@_desc,'$[_newTid]'=>@_newTid,),'/contents/templates/dialog_trader.php');
		}
	}
}



function TableData($limit,$page) {
	$query  ="SELECT `id`,`classname`,`data`,`desc` FROM `pht_trader_pool` ORDER BY `classname` ASC ";	
	$query .=(PHT_SQLITE===true)?paginateLite($query,$limit,$page):paginate($query,$limit,$page);
	$row=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
	if ( $row !== false ){
		$out='';
		foreach ( $row as $data ) {		
				$data['data'] = (isJson($data['data']))?isJson($data['data']):null;		
				$tids=array();
				if(isset($data['data'][0])&&is_array($data['data'][0])){
				foreach($data['data'][0] as $val){$tids[]=$val[1];}
				$tids=implode(', ',$tids);
				}else{$tids='';}	
				$out .= '<tr>';
				$out .= '<td><button class="icon i-list" onclick="openTraderDialog(\''. $data['id'] .'\');" title="$[_edit]" type="button"></button></td>';
				$out .= '<td class="highlight">'. $data['desc'] .'</td>';
				$out .= '<td>'. $data['classname'] .'</td>';
				$out .= '<td class="highlight">'.$tids.'</td>';
				$out .= '<td>'. checkbox($data['id'],'check'.$data['id']) .'</td>';
				$out .= '</tr>';
		}		
	return $out;	
 	} 
}

$content='';
if(isset($_POST['submit'])){if($_POST['submit']==='checkbox'){if(!empty($_POST['checkbox'])&&is_array($_POST['checkbox'])){$content .=(deleteTrader($_POST['checkbox']))?Notify(count($_POST['checkbox']).'&nbsp;'. success_delete_entries,'success'):Notify(_an_error,'error');}}}
$temp = array(
'$[PAGE]'=>self($page),
'$[CONTENTSCRIPTS]'=>$contentScripts,
'$[TABLEDATA]'=>TableData($maxResults,$page),
'$[_deleteSelected]'=>@_deleteSelected,
'$[_submit]'=>@_submit,
'$[_classname]'=>@_classname,
'$[_pleaseSelectA]'=>@_pleaseSelectA,
'$[_insertSqfHere]'=>@_insertSqfHere,
'$[_desc]'=>@_desc,
'$[_edit]'=>@_edit,
'$[_category]'=>@_category,
'$[_close]'=>@_close,
'$[_save]'=>@_save,
'$[_desc]'=>@_desc,
'$[_newTid]'=>@_newTid,
'$[_addNewTrader]'=>@_addNewTrader,
'$[_infoTraderPool]'=>@_infoTraderPool,
);
$content .= cRep($temp,'/contents/templates/page_'.$page.'.php');	
echo $content;