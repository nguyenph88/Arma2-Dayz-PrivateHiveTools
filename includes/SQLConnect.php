<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/

function db(){
	@$db=mysqli_init();
	@$db->options(MYSQLI_OPT_CONNECT_TIMEOUT,2);
	@$db->real_connect(DBHOST,DBUSER,DBPASS,DBNAME,DBPORT)||die('<div style="background:#000;padding:1.2em;border:0.5em solid #8C0000;color:#fff;font-size:1.2em;">Connect Error ('.$db->connect_errno .')</p>'. $db->connect_error .'<br><a style="color:#FFBF00;" target="_blank" href="http://dev.mysql.com/doc/refman/5.6/en/error-messages-server.html" >http://dev.mysql.com/doc/refman/5.6/en/error-messages-server.html</a></div>');
	@$db->set_charset('UTF8');
	return $db;
}

function db2(){
$dir=DIR .'/db';
$file=DIR .'/db/'.@PHT_SQLITEDB;
!is_dir($dir)&&die('<div style="background:#000;padding:1.2em;border:0.5em solid #8C0000;color:#fff;font-size:1.2em;">"'.$dir.'" is missing</div>');
!file_exists($file)&&die('<div style="background:#000;padding:1.2em;border:0.5em solid #8C0000;color:#fff;font-size:1.2em;">"'.$file.'" is missing</div>');
!is_writable($dir)&&die('<div style="background:#000;padding:1.2em;border:0.5em solid #8C0000;color:#fff;font-size:1.2em;">permission issue: "'.$dir.'" is not writable</div>');
!is_writable($file)&&die('<div style="background:#000;padding:1.2em;border:0.5em solid #8C0000;color:#fff;font-size:1.2em;">permission issue: "'.$file.'" is not writable</div>');
$db = new SQLite3($file);
$db->busyTimeout(1000);
return $db;
}

function vacuum(){$db=db2();return (!$db->exec('VACUUM'))?false:true;}


function cleanup(&$data){
$data=trim($data);
$a=array("/(\r\n)|(\r)/m","/(\n){3,}/m", "/\s{3,}/m","/(.)\\1{15,}/im" );
$b=array("\n","\n\n"," ","\\1");
if(function_exists('get_magic_quotes_gpc')&&get_magic_quotes_gpc()==1){$data=stripcslashes($data);}
$data=preg_replace($a,$b,$data);
$data=strip_tags($data);
return $data;
}

function secure($data){
	$db=(PHT_SQLITE===true)?db2():db();
	$data=cleanup($data);
	$a = array('select from ','select into ','insert into ','update set ','drop table ','delete from ','union ','truncate ');
	foreach($a as $b ){
		if(preg_match("/{$b}/i",$data))
		$data=str_ireplace($a,' ',$data);
	}
return (PHT_SQLITE===true)?((!is_numeric($data))?$db->escapeString($data):(int)$data):((!is_numeric($data))?$db->real_escape_string($data):(int)$data);
}

function sqlQuery($query=null,$opt='fetch'){
$db=db();
$fu=array('update'=>1,'fetch'=>2,'num'=>3);
	if($result=$db->query($query)){
		if($fu[$opt]===1){$row=$result;}
		if($fu[$opt]===2){
			$row=array();
			if($result->num_rows!==0){while($rows=$result->fetch_assoc()){$row[]=$rows;}}else{$row=false;}
		}
		if($fu[$opt]===3){$row=$result->num_rows;} 
	return $row;	
	}	
return false;
}

function liteQuery($query=null,$opt='fetch'){
$db=db2();
$fu=array('update'=>1,'fetch'=>2,'num'=>3);
	if($result=$db->query($query)){
		if($fu[$opt]===1){$row=$result;}
		if($fu[$opt]===2){$row=false;while($rows=$result->fetchArray(SQLITE3_ASSOC)){$row[]=$rows;}}	
		if($fu[$opt]===3){$row=array();while($rows=$result->fetchArray(SQLITE3_ASSOC)){$row[]=$rows;}$row=count($row);} 
		$db->close();
		unset($db);
		return $row;	
	}	
return false;
}