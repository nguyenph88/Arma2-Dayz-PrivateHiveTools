<?php
function Logout(){

		$userSessID	= session_id();	
		$query="DELETE FROM `pht_session` WHERE `sessionID`='".secure($userSessID)."' ;";
		(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
		destroy();	
		header('location: ' . self() );
}


function Login($userIP,$userAgent,$username,$password) {
	
	$password 		= passHash(trim($_POST['password']));
	$now 			= time();
	$lastActive 	= ( $now + SESSION_TIME );
	$setTime 		= ( $now + generateID(2) );
	
	
		$query  = "SELECT * FROM `pht_admin` WHERE `id` !=-1 AND `username`='".secure($username)."' AND `loginblock`=0 ;";
		$result = (PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
		
		if ($result !== false){ 
			$row = $result[0];
			if ($password !== $row['password']){
				$query = "UPDATE `pht_admin` SET `last_ip`='".secure($userIP)."',`loginfail`=`loginfail` + 1 WHERE `id` !=-1  AND `id`=".(int)$row['id']." ;";
				(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
				
				
			return false;	
			} else {
			
				(PHT_SQLITE===true)?liteQuery("DELETE FROM `pht_session` WHERE `lastActive` <= ".(int)$now." ;",'update'):sqlQuery("DELETE FROM `pht_session` WHERE `lastActive` <= ".(int)$now." ;",'update');
					
				$_SESSION['LOGGED_IN']	= true;	
				$_SESSION['ADMIN_ID']	= $row['id'];
				$_SESSION['USERNAME']	= $row['username'];
				$_SESSION['LOGIN_FAIL']	= $row['loginfail'];
				$_SESSION['LAST_IP']	= $row['last_ip'];
				$_SESSION['LAST_LOGIN']	= $row['last_login'];
				$_SESSION['HASH']		= userHash($row['id'],$userIP,$userAgent);
				$_SESSION['TOKEN'] 		= userHash($_SESSION['HASH'].$now,$userIP,$userAgent);		
					
				session_regenerate_id(true);
				$userSessID	= session_id();		
						
				$query="UPDATE `pht_admin` SET `hash`='".secure($_SESSION['HASH'])."',`last_login`=".(int)$now.",`last_ip`='".secure($userIP)."',`loginfail`=0 WHERE `id` !=-1 AND `id`=".(int)$row['id']." ;";
				(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
								
				$query="INSERT INTO `pht_session` ( `sessionID`, `userID`, `token`, `ip`, `userAgent`, `lastActive`, `setTime` ) VALUES ( '".secure($userSessID)."', ".(int)$row['id'].", '".secure($_SESSION['TOKEN'])."', '".secure($userIP)."', '".secure($userAgent)."', ".(int)$lastActive.", ".(int)$setTime." ) ;";
				(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
				
			return true;
			}
		}			
return false;
}


function Check($userIP,$userAgent) {

	$now 			= time();
	$lastActive 	= ( $now + SESSION_TIME ); 
	$setTime 		= ( $now + 60 );
	$userSessID		= session_id();	
	
	if (isset($_SESSION['LOGGED_IN'],$_SESSION['HASH'])){	

			$query="SELECT `sessionID`,`userID`,`setTime` FROM `pht_session` WHERE `sessionID`='".secure($userSessID)."' ;";	
			$result=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
			
			if ( $result !== false ) {
			$row=$result[0];	
			
			
				$query ="SELECT * FROM `pht_admin` WHERE `id` !=-1 AND `id`=".(int)$row['userID']." AND `hash`='".secure($_SESSION['HASH'])."' ;";
				$isA=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
				if ( $isA === false) destroy();
	

				if ( $row['userID'] == 1 ) {
					define( 'isHeadAdmin', true );
				}
				
				$hash  = userHash($row['userID'],$userIP,$userAgent);
				if ( $_SESSION['HASH'] !== $hash ) {
						$query="DELETE FROM `pht_session` WHERE `sessionID`='".$row['sessionID']."' ;";
						(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
						return false; 
					}	
							
				if ($now >= $row['setTime']){
						$query="UPDATE `pht_session` SET `requestURI`='".secure($_SERVER['REQUEST_URI'])."',`lastActive`=".(int)$lastActive.", `setTime`=".(int)$setTime." WHERE `sessionID`='".$row['sessionID']."' ;";
						(PHT_SQLITE===true)?liteQuery($query,'update'):sqlQuery($query,'update');
					}	
			return true;	
			} 
			
	
	} else {	
		$query = "SELECT `sessionID` FROM `pht_session` WHERE `ip`='".secure($userIP)."' AND `userAgent`='".secure($userAgent)."' AND `lastActive` >=".(int)$now.";";	
		$result = (PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');	
		if ( $result !== false ) { 			
			$row = $result[0];		
			$SID = (isset($_SERVER['HTTP_COOKIE'])) ? str_replace( SESSION_NAME . '=','',$_SERVER['HTTP_COOKIE']) : 0;
			if ( $SID === $row['sessionID']) {
				session_regenerate_id(true);	
				return true;	
			}		
		}
	}
return false; 
}