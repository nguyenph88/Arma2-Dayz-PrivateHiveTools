<?php
/****************************
SurvivorStats by Nightmare
http://n8m4re.de
*****************************/

function getPerm($ID) {
	$query = "SELECT `permissions` FROM `pht_admin` WHERE `id`=" . (int)$ID . " LIMIT 1;";
	$rows=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
	if ( $rows !== false ) {
			$json = isJson($rows[0]['permissions']);	
			if ( $json !== false ) {
				$permData = array();
				foreach ( $json as $perm ) { $permData[] = (int)$perm; }			
			} else {
				$permData = array(0);
			}
		return $permData;
		}
return array(0);
}


function getContent($AND=null) {
	$ADMIN_ID = (PHT_AUTH===false) ? -1 : ( (isset($_SESSION['ADMIN_ID'])) ? $_SESSION['ADMIN_ID'] : false);
	if ( $ADMIN_ID ) {
		$query = "SELECT * FROM `pht_content` WHERE ( `all`=1 OR `id` IN (".implode( ',', getPerm($ADMIN_ID) ).") ) ".$AND." ;";
		$rows=(PHT_SQLITE===true)?liteQuery($query,'fetch'):sqlQuery($query,'fetch');
		if ($rows !== false){return $rows;}
	}
return false;
}


function makeMenu($IS='left') {
	$row = getContent("AND `is`='".$IS."' ORDER BY `order` ASC"); 
	if ( $row !== false ) { 
			$out = '';
		foreach ( $row as $key => $val ){	
			if (defined('GAME')&&in_array(GAME, isJson($val['game']))) {
			$out	.= '<li class="'.$val['key'].'">';
			$out	.= '<a '. (($val['func']== 1)?'id="'.$val['key'].'"':null) .' '.((isset($_GET[$val['key']]))?'class="menu-'.$IS.' active "':'class="menu-'.$IS.'"');
			$out	.= ' href="'.(($val['func']== 0)?self($val['key']):'#').'"';
			$out	.= ' title="'.((!defined($val['title']))?$val['title']:constant($val['title'])).'" >';
			$out	.= '<span class="'.(($val['func']==1)?'menuHead':'menuLeft').' icon i-'.$val['key'].'"></span>'.((!defined($val['name']))?$val['name']:constant($val['name']));
			$out	.= '</a>';
			$out 	.= '</li>';		
			}
		}
	return $out;
	}
}


function Content($default='infoBoard') {
$row = getContent(); 
if ( $row !== false ){ 


		foreach($row as $key => $val){
			(defined('GAME') && in_array( GAME, isJson($val['game']) ) && isset($_GET[$val['key']]) ) ? $page = $val['key'] : '';
		}	
		
		if ( isset($page) ) {
			$maxResults = ( !defined('PHT_MAXTABLEDATA') || !is_numeric(PHT_MAXTABLEDATA) ) ? 20 : PHT_MAXTABLEDATA;
			$contentScripts = ContentScripts($page);
			$pageNum = ( !empty($_GET[$page]) && is_numeric($_GET[$page]) ) ? '='.$_GET[$page] : '';
			
			ob_start('mb_output_handler');
			
			$file = DIR .'/contents/functions/' . $page . '.func.php';
			
			(file_exists($file)) ? include_once( $file ) : '';
			
			$buffer = ob_get_contents(); 
			
			ob_end_clean();
			
			return $buffer;
			
		} else {
			die( header('location: '.self($default)) );
		}
	} 	
}


function HeaderScripts() {
	$row=getContent();
	if( $row !== false ){
	$scripts ='';
	foreach ( $row as $val ){
	if (isset($_GET[$val['key']])){
		$src=isJson($val['3rdScripts']);
		if($src !== false||!empty($src)) {
			foreach ($src as $script ){
			$scripts .='<script type="text/javascript" src="scripts/3rdParty/'.$script.'.js" charset="UTF-8"></script>'."\n";}
			}
	}
	}	
	return $scripts;	
	}	
}

function ContentScripts($PAGE) {
	$row=getContent();
	if( $row !== false ){
	$s  = '<script>'."\n";
	$s .= '//<![CDATA['."\n";
	$s .= 'var PHT_PAGE = \''.self($PAGE).'\';'."\n";
	$s .= 'var PHT_ERROR = \'' . Notify( @_an_error,'error') . '\';'."\n";
	$s .= 'var PHT_SUCCESS_CHANGE = \'' . Notify( @_success_change,'success') . '\';'."\n";
	$s .= 'var PHT_SUCCESS_EXEC = \'' . Notify( @success_exec,'success') . '\';'."\n";
	$s .= '//]]>'."\n";
	$s .= '</script>'."\n";
	
	foreach ( $row as $val ){if (isset($_GET[$val['key']])){$src=isJson($val['phtScripts']);if($src !== false||!empty($src)){foreach ($src as $sc ){$s .= '<script src="scripts/'.$sc.'.js" charset="utf-8"></script>'."\n";}}}}
	return $s;
	}	
}



function paginateLite($query,$limit=10,$page='main',$and=''){$p=(empty($_GET[$page])||!is_numeric($_GET[$page]))?1:(int)$_GET[$page];if(isset($p)){$rows=liteQuery($query,'num');if($rows <= $limit){return ';';}else{echo"\n",'<script>',"\n",'//<![CDATA[',"\n",' var curretPAGE=',$p,';',"\n",' var totalPAGE=',ceil( $rows / $limit ),';',"\n",'//]]>',"\n",'</script>';return ' LIMIT '.(int)(($p - 1)*$limit).','.(int)$limit.' ;';}}return ';';}
function paginate($query,$limit=10,$page='main',$and=''){$p=(empty($_GET[$page])||!is_numeric($_GET[$page]))?1:(int)$_GET[$page];if(isset($p)){$rows=sqlQuery($query,'num');if($rows <= $limit){return ';';}else{echo"\n",'<script>',"\n",'//<![CDATA[',"\n",' var curretPAGE=',$p,';',"\n",' var totalPAGE=',ceil( $rows / $limit ),';',"\n",'//]]>',"\n",'</script>';return ' LIMIT '.(int)(($p - 1)*$limit).','.(int)$limit.' ;';}}return ';';}