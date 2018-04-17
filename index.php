<?php 
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
include_once('loader.php');

header('Content-Type: text/html; charset=utf-8');

$content = '';
if (isset($Check)&&$Check===true){
$temp=array('$[TOKEN]'=>$Token,'$[VERSION]'=> 'v2.0','$[HEADERSCRIPTS]'=>HeaderScripts(),'$[LANGUAGE]'=>$Language,'$[CONTENT]'=>Content(),'$[MENULEFT]'=>makeMenu('left'),'$[MENUHEADER]'=>makeMenu('header'),'$[_confirm]'=>@_confirm,'$[_submit]'=>@_submit,'$[_generate]'=>@_generate,);
$content .= cRep($temp,'/contents/templates/index_header.php');	
$content .= cRep($temp,'/contents/templates/index_main.php');
die($content);
} else {
isset($_POST['reset'])&&die(resetPw($_POST['reset']));
destroy();
$temp=array('$[VERSION]'=> 'v2.0','$[HEADERSCRIPTS]'=>'','$[LANGUAGE]'=>$Language,);
$content .= cRep($temp,'/contents/templates/index_header.php');	
$content .= cRep($temp,'/contents/templates/index_login.php');	
die($content);
}