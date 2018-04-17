<?php 
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
defined('PRIVATEHIVETOOLS')&&defined('isHeadAdmin')||die(@header('HTTP/1.0 404 Not Found'));


isset($_POST['addAdmin'])&&die(addAdmin($_POST['addAdmin']));
isset($_POST['changePass'])&&die(changePass($_POST['changePass']));
isset($_POST['changePerm'])&&die(changePerm($_POST['changePerm']));


function ListPerm() {

	$query = "SELECT `id`,`title` FROM `pht_content` WHERE `id` NOT IN ( 1, 2, 15, 7 ) ";
	$row=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
	if ( $row !== false ){
			$out = '';		
		foreach( $row as $val ){
			$out .= '<label>'.((!defined($val['title']))?$val['title']:constant($val['title'])).':</label>';
			$out .= '<select id="sPerm" name="permissions[]">';
			$out .= '<option value=""> NO </option>';
			$out .= '<option value="'.$val['id'].'"> YES </option>';
			$out .= '</select><br />';
		}
	return $out;
	}
}

function changePass($VALUE=null){
	$result=false;
	if (!empty($VALUE)){
		$data=isJson($VALUE);	
		if( $data !== false && is_array($data) ){
			if(!empty($data['password'])&&!empty($data['id'])){
				$query="UPDATE `pht_admin` SET `password`='".passHash(trim($data['password']))."' WHERE `id`=".(int)$data['id']." ";
				$result=(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');	
			}
		}
	}
return (!$result)?false:true;	
}


function changePerm($VALUE=null){
	$result=false;
	if (!empty($VALUE)){
		$data=isJson($VALUE);	
		if( $data !== false && is_array($data) ){
			if(!empty($data['id'])){
				
			if(!is_array($data['permissions'])){
				$data['permissions']=[];
			}	
			array_push($data['permissions'], 1, 2 );
			$data['permissions'] = array_filter($data['permissions']);
			$perm = '[' . implode(',',$data['permissions']) . ']';
			$query="UPDATE `pht_admin` SET `permissions`='".$perm."' WHERE `id`=".(int)$data['id']." ";
			$result=(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');	
			}
		}
	}
return (!$result)?false:true;	
}



function addAdmin($VALUE=null){
	$result=false;
	if (!empty($VALUE)){
		$data=isJson($VALUE);	
		if($data !== false && is_array($data)){
			if(!empty($data['username'])&&!empty($data['password'])){
			
			if(!is_array($data['permissions[]'])){
				$data['permissions[]']=[];
			}		
			array_push($data['permissions[]'], 1, 2 );
			$data['permissions[]'] = array_filter($data['permissions[]']);
			$perm = '[' . implode(',',$data['permissions[]']) . ']';
			$query="INSERT INTO `pht_admin` ( `username`, `password`,`permissions` ) VALUES ( '".secure($data['username'])."', '".passHash(trim($data['password']))."', '".$perm."' ) ";
			$result=(PHT_SQLITE===true)?@liteQuery($query,'update'):sqlQuery($query,'update');	
			}
		}
	}
return (!$result)?false:true;	
}


function deleteAdmins($VALUE=null){
	if(!empty($VALUE)&&is_array($VALUE)){
		foreach($VALUE as $ID){$IDS[]=(int)$ID;} 
		$query="DELETE FROM `pht_admin` WHERE NOT `id`=1 AND `id` IN ( " . implode(",",$IDS) . " )";
		return (PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
	} 
return false;
}

function TableData($limit,$page) {
	$query  ="SELECT * FROM `pht_admin` WHERE `id` >=1 ORDER BY `id` ASC";	
	$query .=(PHT_SQLITE===true)?paginateLite($query,$limit,$page):paginate($query,$limit,$page);
	$row=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
	if ( $row !== false ){
		$out='';
		foreach ( $row as $data ) {	
					$perm=isJson($data['permissions']);
					if ($perm !==false){
					$perm=array_filter($perm);
						$q="SELECT `id`,`title` FROM `pht_content` WHERE `id` IN ( '". implode("', '",$perm) ."' )";
						$a=(PHT_SQLITE===true)?liteQuery($q,'fetch'):sqlQuery($q,'fetch');			
						if ( $a !== false ){
						foreach($a as $k => $f){
							if($f['id']==1)unset($a[$k]);
							if($f['id']==2)unset($a[$k]);
							if($f['id']==7)unset($a[$k]);
							if($f['id']==15)unset($a[$k]);
						}	
						$permissions='';
						foreach ($a as $b){$permissions .= ((!defined($b['title']))?$b['title']:constant($b['title'])).', ';}
						}
					}
				$out .= '<tr>';
				$out .= '<td>
							<button class="icon i-epochKeyGen" onclick="changePass(\''. $data['id'] .'\');" title="$[_changepass]" type="button"></button>
							'. (($data['id']!=1)?'<button class="icon i-epochKeyGen" onclick="changePerm(\''. $data['id'] .'\');" title="Change Permissions" type="button"></button>':'').'
						</td>';
				$out .= '<td class="highlight">'. $data['username'] .'</td>';
				$out .= '<td>'. (($data['id'] != 1)?$permissions:'All' ).'</td>';
				$out .= '<td class="highlight">'. $data['last_ip'] .'</td>';
				$out .= '<td>'.dateR($data['last_login']).'</td>';
				$out .= '<td class="highlight">'. (($data['id']!=1)?checkbox($data['id'],'check'.$data['id']):'') .'</td>';
				$out .= '</tr>';
		}		
	return $out;	
 	} 
}

$content='';
if(isset($_POST['submit'])){if($_POST['submit']==='checkbox'){if(!empty($_POST['checkbox'])&&is_array($_POST['checkbox'])){$content .=(deleteAdmins($_POST['checkbox']))?Notify(count($_POST['checkbox']).'&nbsp;'. success_delete_entries,'success'):Notify(_an_error,'error');}}}
$temp = array(
'$[PAGE]'=>self($page),
'$[CONTENTSCRIPTS]'=>$contentScripts,
'$[TABLEDATA]'=>TableData($maxResults,$page),
'$[LISTPERM]'=>ListPerm(),
'$[_deleteSelected]'=>@_deleteSelected,
'$[_submit]'=>@_submit,
'$[_addNew]'=>@_addNew,
'$[_changepass]'=>@_changepass,
'$[_edit]'=>@_edit,
'$[_close]'=>@_close,
'$[_save]'=>@_save,
);
$content .= cRep($temp,'/contents/templates/page_'.$page.'.php');	
echo $content;