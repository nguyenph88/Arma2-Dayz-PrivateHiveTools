$[PHP]

/*#### MYSQL DATABASE SETTINGS #########*/ 

$CONF['DBHOST']		= '$[DBHOST]'; 		/** DATABASE HOSTNAME OR IP **/
$CONF['DBPORT'] 	= $[DBPORT]; 		/** DATABASE PORT **/
$CONF['DBPASS'] 	= '$[DBPASS]'; 		/** DATABASE PASSWORD **/
$CONF['DBUSER'] 	= '$[DBUSER]'; 		/** DATABASE USER **/
$CONF['DBNAME'] 	= '$[DBNAME]'; 		/** DATABASE NAME **/


/*#### GAME SETTINGS  #################*/

$CONF['GAME'] 		= $[GAME]; 			/** 1=A2EPOCH, 2=DAYZMOD **/
$CONF['GAMEIP']		= '$[GAMEIP]'; 		/** IP OF GAMESERVER **/
$CONF['GAMEPORT']	= $[GAMEPORT]; 		/** PORT OF GAMESERVER **/
$CONF['GAMERCON'] 	= '$[GAMERCON]'; 	/** RCON PASSWORD OF GAMESERVER **/
$CONF['GAMEMAP'] 	= $[GAMEMAP]; 		/** 1=chernarus,2=chernarusplus,3=lingor,4=namalsk,5=ovaron,6=panthera2,7=utes,8=altis,9=stratis,10=sauerland,11=takistan,12=zargabad,13=napf **/
$CONF['INSTANCE'] 	= $[INSTANCE]; 		/** SERVER INSTANCE ( see /MPMissions/init.sqf ) **/
 
 
/*#### PHT SETTINGS ###################*/
$CONF['PHT_RESET_KEY'] 		= '$[PHT_RESET_KEY]'; 	/** pw reset key **/	
$CONF['PHT_FORCE_LANG'] 	= ''; 				/** de / en / no **/
$CONF['PHT_MAXTABLEDATA'] 	= 10;
$CONF['PHT_SQLITE']		  	= true;
$CONF['PHT_SQLITEDB']	  	= '$[PHT_SQLITEDB]';
$CONF['PHT_SETUP'] 			= false; 
$CONF['PHT_AUTH']	  		= true;				
$CONF['PHT_TOKEN']    		= '$[PHT_TOKEN]';	/** needed when PHT_AUTH set to false **/