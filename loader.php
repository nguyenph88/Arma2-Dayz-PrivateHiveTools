<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
error_reporting(-1);

define('PRIVATEHIVETOOLS',true);
define('DIR',dirname(__file__));
define('SESSION_TIME',86400); //1DAY=86400;1WEEK=604800
define('SESSION_NAME','PHT');

if(ini_get('register_globals')==1){@ini_set('register_globals',0);if(ini_get('register_globals')==1){die('<div style="background:#000;padding:5px;border:2px solid #8C0000;color:#fff;font-size:16px;">register_globals is set to <b>on</b>. This setting is dangerous.</div>');}}
if(@ini_get('date.timezone')==''){date_default_timezone_set(@date_default_timezone_get());}

!is_writable(DIR)&&die('<div style="background:#000;padding:1.2em;border:0.5em solid #8C0000;color:#fff;font-size:1.2em;">permission issue: "'. DIR .'" is not writable</div>');

ini_set('default_charset','UTF-8');
ini_set('session.name',SESSION_NAME );
ini_set('session.cookie_httponly',1);
ini_set('session.use_only_cookies',1);
ini_set('session.use_trans_sid',0);
ini_set('session.hash_function','sha256');
ini_set('session.gc_maxlifetime', SESSION_TIME);
ini_set('session.gc_probability',100); 
ini_set('session.gc_divisor',100);
	
$GAMES=array(1=>'A2EPOCH',2=>'DAYZMOD');
$MAPS=array(1=>'chernarus',2=>'chernarusplus',3=>'lingor',4=>'namalsk',5=>'ovaron',6=>'panthera2',7=>'utes',8=>'altis',9=>'stratis',10=>'sauerland',11=>'takistan',12=>'zargabad',13=>'napf');
$FILES=array('/config.php','/includes/SQLConnect.php','/includes/Base.php','/includes/Auth.php','/includes/Content.php',);

if(!file_exists(DIR .'/config.php')) {
	file_put_contents( DIR . '/config.php','<?php ');
}

foreach ($FILES as $file) {
	!file_exists(DIR . $file)&&die('<div style="background:#000;padding:5px;border:2px solid #8C0000;color:#fff;font-size:16px;">" '.$file.' " is missing</div>');
	require_once(DIR . $file); 
}


if(matchPHP_SELF(array('loader.php'))){
	header('Location: index.php');
};

if (isset($CONF)&&is_array($CONF)){
	if(isset($GAMES[$CONF['GAME']])){$CONF['GAME']=$GAMES[$CONF['GAME']];require_once( DIR . '/includes/game_'.$CONF['GAME'].'.php');}	
	$CONF['GAMEMAP'] = (isset($MAPS[$CONF['GAMEMAP']])) ? $MAPS[$CONF['GAMEMAP']]:null;
	foreach ($CONF as $KEY=>$VAL){
		$VAL = (is_int($VAL)||is_bool($VAL)) ? $VAL : trim($VAL);
		define($KEY,$VAL);
	}
unset($CONF,$MAPS,$GAMES,$FILES);
}
	
	
checkPHP('5.4.0');
$Language = Language();
mb_language($Language);
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_regex_encoding('UTF-8');
	
	
function resetPw($VALUE=null){
	$result=false;
	if (!empty($VALUE)){
		$data=isJson($VALUE);		
		if( $data !== false && is_array($data) ){
			if(isset($data['newPw'],$data['resetKey'])&&!empty($data['newPw'])&&!empty($data['resetKey'])&&defined('PHT_RESET_KEY')){
				if ( PHT_RESET_KEY === trim($data['resetKey'])){
					$query="UPDATE `pht_admin` SET `password`='".passHash(trim($data['newPw']))."' WHERE `id`=1 ";
					$result=(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');	
				}
			}
		}
	}
return (!$result)?false:true;	
}
	
	
if(defined('PHT_SETUP')&&PHT_SETUP===true||!defined('PHT_SETUP')){include_once( dirname(__file__) .'/setup.php');}			
if (PHT_AUTH===false) {
	$Check=true;
	$Token = PHT_TOKEN;
} else {
	!isset($_SESSION)&&session_start();
	isset($_GET['logout'])&&die(logout());
	$userAgent 	= $_SERVER['HTTP_USER_AGENT'];
	$userIP		= getIp();	
	$Token 	= (isset($_SESSION['TOKEN'])&&!empty($_SESSION['TOKEN']))?$_SESSION['TOKEN']:false;
	if(!isset($_SESSION['LOGGED_IN'])&&isset($_POST['username'],$_POST['password'])){
		$Check 	= Login($userIP,$userAgent,$_POST['username'],$_POST['password']);
	} else {
		$Check 	= Check($userIP,$userAgent);
	}
}