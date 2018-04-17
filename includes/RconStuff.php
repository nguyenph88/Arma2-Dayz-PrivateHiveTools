<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
defined('PRIVATEHIVETOOLS')||die();
if(ini_get('allow_url_fopen')== 0){die('<div class="errorBox" style="font-size:16px;">'. _allow_url_fopen .'</div>');}
function strToHex($string){$hex='';for($i=0;$i < mb_strlen($string);$i++){$hex .= dechex(ord($string[$i]));}return $hex;}
function hexToStr($hex){$string='';for($i=0;$i < mb_strlen($hex) - 1;$i += 2){$string .=chr(hexdec($hex[$i].$hex[$i + 1]));}return $string;}
function computeUnsignedCRC32($str){sscanf(crc32($str),"%u", $var);$var=dechex($var + 0);return $var;}
function dec_to_hex($dec){$sign=" ";$h=null;if($dec < 0){$sign="-";$dec=abs($dec);}$hex=array(0=>0,1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>'a',11=>'b',12=>'c',13=>'d',14=>'e',15=>'f');do{$h=$hex[($dec % 16)].$h;$dec /= 16;}while($dec >= 1);return $sign.$h;}
function get_checksum($cs){$var=computeUnsignedCRC32($cs);$x=('0x');$a=mb_substr($var,0,2);$a=$x.$a;$b=mb_substr($var,2,2);$b=$x.$b;$c=mb_substr($var,4,2);$c=$x.$c;$d=mb_substr($var,6,2);$d=$x.$d;return chr($d).chr($c).chr($b).chr($a);}
function sPass($passwd){$head=chr(0x42).chr(0x45);$passhead=chr(0xFF).chr(0x00);$passwd=$passhead.$passwd;return $head . get_checksum($passwd).$passwd;}
function sCmd($cmd){$head=chr(0x42).chr(0x45);$cmdhead=chr(0xFF).chr(0x01).chr(0x00);$cmd=$cmdhead.$cmd;return $head . get_checksum($cmd).$cmd;}


function rconConnect($passwd,$ip,$port,$cmd) {

	$answer = false;
	$result = fsockopen('udp://'.$ip,$port,$errno,$errstr,1);
	stream_set_timeout($result,1);

	if($result) {
	
		#writeLog('encoding','',print_r(mb_detect_encoding($str),true));

		fwrite($result,sPass($passwd));
		$res = fread($result,1024);
		fwrite($result,sCmd($cmd));
			$answer = fread($result,10240);
			if(strToHex( mb_substr($answer,9,1)) == '0') {
				$count=strToHex( mb_substr( $answer, 10, 1));
				for($i = 0; $i < $count-1; $i++){
				$answer .= fread($result,10240);
				}
		}
	fwrite($result,sCmd('exit'));
	}
	return $answer;
}


function RconUnban($value=false) {
	if($value!==false&&is_numeric($value)) {
		$query="DELETE FROM `pht_rcon_bans` WHERE `id`=".(int)$value.";";
		$result=(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
		rconConnect(GAMERCON,GAMEIP,GAMEPORT,'removeBan '. $value );
	}
}


function RconBansData(){

	$a = array();
	
	$result = rconConnect(GAMERCON,GAMEIP,GAMEPORT,'bans');
	
	if($result !== false ) {	

		$muell=array('----------------------------------------','[#] [IP Address] [Minutes left] [Reason]','[#] [GUID] [Minutes left] [Reason]','------','IP Bans:','Bans:');
		foreach($muell as $wegdamit) {	
			if(preg_match("/{$wegdamit}/i",$result)) {
				$result = str_ireplace($muell, null, $result);
				}
		}
				
		if(!empty($result)) {
		
			$result = trim($result);
			$result = explode("\n",$result);
			unset($result[0]);
			
			$result = array_merge(array_filter($result));
			
			foreach($result as $k => $v) {
				$a[] = explode(" ",$v);
				unset($a[$k][0],$a[$k][1]);
				$a[$k] = array_merge(array_filter($a[$k],'mb_strlen'));
				$rows = count($a[$k]);
				$r[] = array_slice($a[$k],2);
				$a[$k][2] = null;
				
				foreach($r[$k] as $value) {
					$a[$k][2] .=' '.$value;
					$a[$k][2] = trim($a[$k][2]);
				}
				array_splice($a[$k],2,$rows,$a[$k][2]);
				$values[] = "( '".(int)$k."','".addslashes($a[$k][0])."', '".addslashes($a[$k][1])."', '".addslashes($a[$k][2])."' )";
			}
			
			
			if(!empty($values)&&is_array($values)){
				$query="INSERT INTO `pht_rcon_bans` ( `id`, `guid`, `time`, `reason` ) VALUES ".implode(',',$values)." ;";
				(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
			}
		}
	}
	
}



function RconPlayerData($refresh=null) {
	
	$a=array();
	$result = rconConnect(GAMERCON,GAMEIP,GAMEPORT,'players');
	
	$refresh = (isset($refresh) && $refresh==='true') ? true:false;
	
	if( $result !== false ) {
	
		$muell = array('--------------------------------------------------','(OK)','[#] [IP Address]:[Port] [Ping] [GUID] [Name]');
		foreach($muell as $wegdamit) {
			if(preg_match("/{$wegdamit}/i",$result)){
				$result = str_ireplace($muell,null,$result);
			}
		}
			
		$result=explode("\n",$result);
		
		if(!empty($result)) {
		
			unset($result[0]);
			$result = array_merge(array_filter($result));
			$rows = count($result) - 1;
			$result = str_replace("({$rows} players in total)",null,$result);
			$result = array_merge(array_filter($result));
			foreach($result as $k => $v) {
			$a[]=explode(" ",$v);
			unset($a[$k][0]);
			$a[$k] = array_merge(array_filter($a[$k],'mb_strlen'));
			
				$rows = count($a[$k]);
			
				if(!empty($a)) {
					$r[]=array_slice($a[$k],3);
					$name=null;
					foreach($r[$k] as $value){
						$name .= ' '.$value;
					}
					array_splice($a[$k],3,$rows,trim($name));
				}
			}
				
			if(is_array($a)) {
				$data=json_encode($a);
				if($data!=='[]'||$refresh===true){
					$query="UPDATE `pht_rcon_player` SET `data`='".secure($data)."' WHERE `id`=1";
					(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
				}
			}
		}
	}
}



function RconPlayerTable() {

	$query="SELECT `data` FROM `pht_rcon_player` WHERE `id`=1";
	$row=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
	$row=isJson($row[0]['data']);
	if($row !== false) {
	$out=null;
	foreach($row as $key => $value){
		$value[1]=($value[1] > '100')?'<span style="color:red;">'.$value[1].'</span>':$value[1];
		$value[1]=($value[1] > '50')?'<span style="color:yellow;">'.$value[1].'</span>':$value[1];
		$value[1]=($value[1] < '50')?'<span style="color:lime;">'.$value[1].'</span>':$value[1];
		$value[3]='<span style="font-size:14px;">'.$value[3].'</span>';$out .= '<tr>';
		$out .='<td><button style="padding:0.5em;" class="kick" value="'.$key.'" type="button">kick</button>&nbsp;<button style="padding:0.5em;" class="ban" value="'.$key.'" type="button">ban</button></td>';
		$out .='<td>'.$value[3].'</td>';
		$out .='<td>'.$value[2].'</td>';
		$out .='<td>'.$value[1].'</td>';
		$out .= '<td>'.$value[0].'</td>';
		$out .='<td>'.$key.'</td>';
		$out .='</tr>';
		}
	return $out;
	}
}

function RconBansTable() {

		$query="SELECT * FROM `pht_rcon_bans` ";
		$row=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
		if($row !== false) {
			$out='';
			foreach($row as $data){
			$out .='<tr>';
			$out .='<td><button style="padding:0.5em;" class="unban" value="'.$data['id'].'" type="button">unban</button></td>';
			$out .='<td>'.$data['id'].'</td>';
			$out .='<td>'.$data['guid'].'</td>';
			$out .='<td>'.$data['time'].'</td>';
			$out .='<td>'.$data['reason'].'</td>';
			$out .='<tr>';}
			return $out;
		}
}



isset($_POST['bansData'])&&die(RconBansData());
isset($_POST['playerData'])&&die(RconPlayerData($_POST['playerData']));
isset($_POST['unban'])&&die(RconUnban($_POST['unban']));
isset($_POST['lock'])&&die(rconConnect(GAMERCON,GAMEIP,GAMEPORT,'#lock'));
isset($_POST['unlock'])&&die(rconConnect(GAMERCON,GAMEIP,GAMEPORT,'#unlock'));
isset($_POST['shutdown'])&&die(rconConnect(GAMERCON,GAMEIP,GAMEPORT,'#shutdown'));
isset($_POST['restart'])&&die(rconConnect(GAMERCON,GAMEIP,GAMEPORT,'#restart'));
isset($_POST['kick'])&&die(rconConnect(GAMERCON,GAMEIP,GAMEPORT,'kick '.$_POST['kick']));
isset($_POST['ban'])&&die(rconConnect(GAMERCON,GAMEIP,GAMEPORT,'ban '.$_POST['ban'].' '.$_POST['time'].' '.$_POST['reason']));
isset($_POST['send'])&&die(rconConnect(GAMERCON,GAMEIP,GAMEPORT,'Say -1 PHP-TestMessage:'.$_POST['msg']));
isset($_POST['rconTools'])&&die(cRep(array('$[PLAYERTABLE]'=>RconPlayerTable(),'$[BANSTABLE]'=>RconBansTable(),'$[_battlEyeNeeded]'=>@_battlEyeNeeded,),'/contents/templates/dialog_rconTools.php'));