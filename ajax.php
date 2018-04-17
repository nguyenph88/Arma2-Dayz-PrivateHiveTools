<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
!(isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])==='xmlhttprequest')&&die();
include_once('loader.php');
isset($_GET['checkObject'],$_GET['fieldValue'],$_GET['fieldId'])&&die(jsonHeader(checkObjects($_GET['fieldValue'],$_GET['fieldId'])));
isset($_GET['checkItems'],$_GET['fieldValue'],$_GET['fieldId'])&&die(jsonHeader(checkItems($_GET['fieldValue'],$_GET['fieldId'])));
(!isset($Token,$_GET['token'])||$Token!==$_GET['token'])&&die();
(!isset($Check)&&$Check===false)&&die();
isset($_POST['epochKey'])&&die(epochKey($_POST['epochKey']));
isset($_GET['searchPlayers'],$_GET['term'])&&die(jsonHeader(searchPlayers($_GET['term'])));
isset($_GET['searchTools'],$_GET['term'])&&die(jsonHeader(searchItems($_GET['term'],"AND ( `GROUP`='WEAPON' OR `GROUP`='TOOLBELT' )")));
isset($_GET['searchItems'],$_GET['term'])&&die(jsonHeader(searchItems($_GET['term'],"AND ( `GROUP`='ITEM' OR `GROUP`='AMMO' )")));
isset($_GET['searchBackPack'],$_GET['term'])&&die(jsonHeader(searchItems($_GET['term'],"AND `GROUP`='BACKPACK' ")));
isset($_GET['searchModel'],$_GET['term'])&&die(jsonHeader(searchItems($_GET['term'],"AND `GROUP`='MODEL'")));
isset($_GET['searchLocation'],$_GET['term'])&&die(jsonHeader(searchLocation($_GET['term'])));
isset($_GET['searchObjects'],$_GET['term'])&&die(jsonHeader(searchObjects($_GET['term'])));
isset($_GET['searchHiveObjects'],$_GET['term'])&&die(jsonHeader(searchHiveObjects($_GET['term'])));
isset($_GET['updateTraderData'],$_POST['id'],$_POST['value'])&&die(updateTraderData($_GET['updateTraderData'],$_POST['id'],$_POST['value']));
isset($_GET['insertTraderData'],$_POST['value'])&&die(insertTraderData($_POST['value']));
isset($_POST['truncateTradersData'])&&die(truncateTradersData());
isset($_GET['searchTraderHiveData'],$_GET['term'])&&die(jsonHeader(searchTraderHiveData($_GET['term'])));
isset($_GET['searchCurrency'],$_GET['term'])&&die(jsonHeader(searchItems($_GET['term']," AND ".((PHT_SQLITE===true)?"( `classname` LIKE '%goldbar%' OR `classname` LIKE '%silverbar%' OR `classname` LIKE '%briefcase%' OR `classname` LIKE '%copperbar%' OR `classname` LIKE '%tinbar%' )":" `classname` REGEXP 'goldbar|silverbar|briefcase|copperbar|tinbar'")." AND `GROUP`='ITEM' ")));
isset($_POST['rconTools'])&&die(include_once( DIR . '/includes/RconStuff.php'));