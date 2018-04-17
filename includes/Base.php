<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
function dump($data,$info=null){echo '<pre style="border:2px solid #8C0000;background:#000;height:auto;overflow:auto;margin:0.5em;color:#fff;">';echo $info.' = ';var_dump($data);echo '</pre>'."\n";}
function printR($data,$info=null){echo '<pre style="border:2px solid #8C0000;background:#000;height:auto;overflow:auto;margin:0.5em;color:#fff;">';print_r($data);echo '</pre>'."\n";}
function writeLog($file,$action=null,$data=null){file_put_contents(dirname(__dir__) .'/' . $file.'.log',date('Y-m-d-H:i:s').' '.$_SERVER['REMOTE_ADDR'].' '.$action.' ' .$data.PHP_EOL, FILE_APPEND);}
function destroy(){if(isset($_SESSION))@session_unset();@session_destroy();}
function isJson($data,$opt=true){$data=json_decode($data,$opt); return ($data===null)?false:$data;}
function jsonHeader($DATA=null){header('HTTP/1.1 200 OK');header('Cache-Control: no-cache');header('Content-Type: application/json; charset=utf-8');return $DATA;}
function generateID($length=15){$char=array(1,2,3,4,5,6,7,8,9);$count=count($char)-1;$pass='';for($i=1;$i<=$length;$i++){$dice=mt_rand(0,$count);$pass .=$char[$dice];}return $pass;}	
function passwd($length=15){$char=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',1,2,3,4,5,6,7,8,9,0);$count=count($char)-1;$pass='';for($i = 1; $i<=$length;$i++){$dice=mt_rand(0,$count);$pass .=$char[$dice];}return $pass;}
function requirePost($post,$keys){foreach( $keys as $val ){if( !isset($post[$val]) || empty($post[$val]) ){return false;}}return true;}
function passHash($pw){$pw=hash('sha256','943Osn%2"=d)?1CXdsAS"sdA6;YjU'.$pw);$pw=hash('sha256',$pw.md5($pw));return $pw;}
function userHash($ID=0,$IP='127.0.0.1',$USERAGENT='browserXY'){$h=hash('sha256',$ID.$IP.$USERAGENT).hash('sha256',$USERAGENT.$IP.$ID);return hash('sha256',$h);}  
function getIp(){$ip='';if (isset($_SERVER['HTTP_CLIENT_IP'])){$ip=$_SERVER['HTTP_CLIENT_IP'];}elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];}elseif(isset($_SERVER['HTTP_X_FORWARDED'])){$ip=$_SERVER['HTTP_X_FORWARDED'];}elseif(isset( $_SERVER['HTTP_FORWARDED_FOR'])){$ip=$_SERVER['HTTP_FORWARDED_FOR'];}elseif(isset($_SERVER['HTTP_FORWARDED'])){$ip=$_SERVER['HTTP_FORWARDED'];}elseif(isset($_SERVER['REMOTE_ADDR'])){$ip=$_SERVER['REMOTE_ADDR'];}else{$ip='UNKNOWN';}return $ip;}
function matchPHP_SELF($ARR){foreach ($ARR as $val){if(preg_match("/{$val}/i",$_SERVER['PHP_SELF'])){return true;}}return false;}
function self($get=''){if (!empty($get)){$out=$_SERVER['PHP_SELF'].'?'.$get;} else {$out=$_SERVER['PHP_SELF'];}return htmlentities($out);}
function minMax($data,$min=999,$max=999,$id=null){if($min !== 999){if(mb_strlen($data) < $min){if(!empty($id)){echo jPrompt($id,_too_little_chars);} return false;}}if($max !== 999){if(mb_strlen($data) > $max){if(!empty($id)){echo jPrompt($id,_too_many_chars);} return false;}}return $data;}
function dateR($timestamp){$month=(defined($month=date('_F',$timestamp)))?constant($month).'&nbsp;'.date('Y',$timestamp):date('F Y',$timestamp);$day=(defined($day=date('_l',$timestamp)))?constant($day).',&nbsp;'.date('d. ',$timestamp):date('l, d. ',$timestamp);$time=date('H:i',$timestamp);return $day.$month.',&nbsp;'.$time;}
function cRep($temp,$file=false){if($file!==false){if(file_exists( DIR . $file)){$a=array();$b=array();$file=file_get_contents( DIR . $file);foreach($temp as $key => $val){$a[]=$key;$b[]=$val;}if(preg_match('/<\?(?:php)?(.*?)\?>/s',$file)){$file=preg_replace('/<\?(?:php)?(.*?)\?>/s','',$file);}$file=str_replace($a,$b,$file);return $file;}else{ return $file . ' is missing';}}}
function Notify($MSG,$CLASS){return '<div class="'.$CLASS.'Box">'.$MSG.'</div>';}
function image($NAME,$FOLDER='default',$TITLE='',$SIZE=false){$file=dirname(__dir__).'/style/images/'.$FOLDER.'/'. mb_strtolower($NAME).'.png';$SIZE=($SIZE!==false)?'width="'.$SIZE.'"':'';return (file_exists($file)) ? '<img '.$SIZE.' src="style/images/'.$FOLDER.'/'. mb_strtolower($NAME) .'.png" alt="'.$TITLE.'" title="'.$TITLE.'" />':'';}
function checkbox($VALUE='',$ID='checkbox',$CLASS='checkbox'){return '<div class="checkbox"><input type="checkbox" class="'.$CLASS.'" value="'.$VALUE.'" name="checkbox[]" id="'.$ID.'" /><label for="'.$ID.'"></label></div>';}
function searchItems($VALUE=null,$AND=null){$out=array();if(!empty($VALUE)){$query="SELECT `classname` FROM `pht_item_pool` WHERE `classname` LIKE '%".secure($VALUE)."%' ".$AND." ORDER BY `classname` ASC;";$row=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');if($row!==false){foreach($row as $val){$out[]=$val['classname'];}return json_encode($out);}}}
function searchLocation($VALUE=null){$out=array();if(!empty($VALUE)){$query="SELECT `worldspace`,`description` FROM `pht_location_pool` WHERE `description` LIKE '%".secure($VALUE)."%' ORDER BY `description` ASC;";$row=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');if($row!==false){foreach($row as $val){$a['space']=$val['worldspace'];;$a['desc']=$val['description'];$out['location'][]=$a;}return json_encode($out);}}}
function searchObjects($VALUE=null,$AND=null){$out=array();if(!empty($VALUE)){$query="SELECT `classname` FROM `pht_object_pool` WHERE `classname` LIKE '%".secure($VALUE)."%' ".$AND." ORDER BY `classname` ASC;";$row=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');if($row!== false){foreach($row as $val){$out[]=$val['classname'];}return json_encode($out);}}}
function traderDesc($VALUE=null){if(!empty($VALUE)){$query="SELECT `data`,`desc` FROM `pht_trader_pool`;";$row=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');if($row !== false){foreach($row as $key=>$val){$data=isJson($val['data']);if($data !== false){foreach($data[0] as $tid){if($VALUE == $tid[1]){return '<p>'.$row[$key]['desc'].'</p><br /><p>'.$VALUE.'</p>';}}}}}}return $VALUE;}
function checkObjects($VALUE=null,$FIELDID=null){$out=array();$out[0]=$FIELDID;$out[1]=true; if(!empty($VALUE)&&!empty($FIELDID)){$query="SELECT `id` FROM `pht_object_pool` WHERE `classname`='".secure($VALUE)."';";$result =(PHT_SQLITE===true)?liteQuery($query,'fetch') : sqlQuery($query,'fetch'); $out[1] =(isset($result[0]))?false:true; }return json_encode($out);}
function checkItems($VALUE=null,$FIELDID=null){$out=array();if(!empty($VALUE)&&!empty($FIELDID)){$out[0]=$FIELDID;$query="SELECT `id` FROM `pht_item_pool` WHERE `classname`='".secure($VALUE)."';";$out[1]=((PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch')===1)?false:true;}return json_encode($out);}




function Language(){
	$have = array('de'=>'deutsch','en'=>'english','no'=>'norwegian',);
	
	if(defined('PHT_FORCE_LANG') && isset($have[PHT_FORCE_LANG])) {
	
	$is = PHT_FORCE_LANG;
	
	} else {
	
		$get = (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))?trim(mb_strtolower(mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2))):false;
		$is = (isset($have[$get]))?$get:'en';
	}
	$file= DIR . '/includes/languages/'.$is.'.php';
	if (file_exists($file)) {
		include_once($file);
		foreach($lang as $key => $val){
			define($key,$val,false);
		}
		return $is;
	}else{
		die($file . ' is missing');
	}
}



function checkPHP($min='5.4.0'){
	$msg = null;
	$ext = get_loaded_extensions();
	$ext = array_flip($ext);
	$msg .= ( version_compare(PHP_VERSION,$min ) <= 0 ) ? 'You must be running PHP v'.$min.' or greater.<br />You are currently running version '. PHP_VERSION .'<br />Please ask your host to move you to a server running PHP v'. $min .' or greater.':null;
	$msg .= (!isset($ext['sqlite3'])) ? '<br />Your server does not appear to have a sqlite3 library available, please ask your host to install the <a target="_blank" href="http://us.php.net/manual/en/sqlite3.setup.php">json extension</a>.':null;
	$msg .= (!isset($ext['mysqli'])) ? '<br />Your server does not appear to have a mysqli library available, please ask your host to install the <a target="_blank" href="http://us.php.net/manual/en/mysqli.setup.php">mysqli extension</a>.':null;
	$msg .= (!isset($ext['json'])) ? '<br />Your server does not appear to have a JSON library available, please ask your host to install the <a target="_blank" href="http://us.php.net/manual/en/json.setup.php">json extension</a>.':null;
	$msg .= (!isset($ext['mbstring'])) ? '<br />Your server does not appear to have a mbstring library available, please ask your host to install the <a target="_blank" href="http://us.php.net/manual/en/mbstring.setup.php">mbstring extension</a>.':null;
	if (!empty($msg)){die('<body style="background-color:#000;margin:0 auto;text-align:left;width:800px;"><div style="padding:5px;border:2px solid #8C0000;color:#fff;font-size:16px;">'.$msg.'</div></body>');}
}



function isASCII($string) {
	return preg_match('/^[\x00-\x7F]*$/', $string);
}
	

function isUTF8($string) {
return preg_match('/(
		[\xC2-\xDF][\x80-\xBF]			# non-overlong 2-byte
	|	\xE0[\xA0-\xBF][\x80-\xBF]		# excluding overlongs
	|	[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
	|	\xED[\x80-\x9F][\x80-\xBF]		# excluding surrogates
	|	\xF0[\x90-\xBF][\x80-\xBF]{2}	# planes 1-3
	|	[\xF1-\xF3][\x80-\xBF]{3}		# planes 4-15
	|	\xF4[\x80-\x8F][\x80-\xBF]{2}	# plane 16
	)/x', $string);
}


function convertEncoding($inCharset, $outCharset, $string) {
	if ($inCharset == 'ISO-8859-1' && $outCharset == 'UTF-8') return utf8_encode($string);
	if ($inCharset == 'UTF-8' && $outCharset == 'ISO-8859-1') return utf8_decode($string);	
return mb_convert_encoding($string, $outCharset, $inCharset);
}