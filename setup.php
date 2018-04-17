<?php
defined('PRIVATEHIVETOOLS')||die(header('location: index.php'));
$setupDir=DIR . '/includes/setup';
$confFile=$setupDir .'/config.tpl';
$dbDir=DIR . '/db';
!is_dir($setupDir)&&die('<div style="background:#000;padding:1.2em;border:0.5em solid #8C0000;color:#fff;font-size:1.2em;">"'.$setupDir.'" is missing</div>');
!is_dir($dbDir)&&die('<div style="background:#000;padding:1.2em;border:0.5em solid #8C0000;color:#fff;font-size:1.2em;">"'.$dbDir.'" is missing</div>');
!is_writable(DIR)&&die('<div style="background:#000;padding:1.2em;border:0.5em solid #8C0000;color:#fff;font-size:1.2em;">permission issue: "'. DIR .'" is not writable</div>');
!is_writable($dbDir)&&die('<div style="background:#000;padding:1.2em;border:0.5em solid #8C0000;color:#fff;font-size:1.2em;">permission issue: "'.$dbDir.'" is not writable</div>');
!is_writable( DIR .'/config.php')&&die('<div style="background:#000;padding:1.2em;border:0.5em solid #8C0000;color:#fff;font-size:1.2em;">permission issue: "'. DIR .'/config.php'.'" is not writable</div>');
!file_exists($confFile)&&die('<div style="background:#000;padding:1.2em;border:0.5em solid #8C0000;color:#fff;font-size:1.2em;">"'.$confFile.'" is missing</div>');
if(isset($_POST['setup'],$_POST['CONF'])&&!empty($_POST['CONF']['PHT_RESET_KEY'])){
$dbNew=hash('sha256',passwd(20)).'_db.sqlite';
$token=hash('sha256',passwd(20));
$temp=array('$[PHP]'=>'<?php','$[PHT_TOKEN]'=>$token,'$[PHT_SQLITEDB]'=>$dbNew,'$[PHT_RESET_KEY]'=>$_POST['CONF']['PHT_RESET_KEY'], );
foreach($_POST['CONF'] as $k => $v ){$temp['$['.$k.']'] = trim($v);}
$confFile=cRep($temp,'/includes/setup/config.tpl');	
file_put_contents(DIR .'/config.php',$confFile);
$defaultDb=file_get_contents( DIR . '/includes/setup/database.sqlite');
file_put_contents(DIR . '/db/'.$dbNew, $defaultDb);
sleep(1);
$db=new SQLite3( DIR . '/db/'.$dbNew );
$db->query("REPLACE INTO `pht_admin` ( `id`, `username`, `password`, `permissions` ) VALUES ( 1, '".trim($_POST['CONF']['USERNAME'])."', '".passHash($_POST['CONF']['PASSWORD'])."', '[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15]' ) ");
header('location: '. self() );
}

$content='';
$temp=array('$[VERSION]'=> 'v2.0','$[HEADERSCRIPTS]'=>'','$[LANGUAGE]'=>$Language,'$[_confirm]'=>@_confirm,'$[_afterSetup]'=>@_afterSetup,);
$content .= cRep($temp,'/contents/templates/index_header.php');	
$content .= cRep($temp,'/contents/templates/index_setup.php');
die($content);