<?php 
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'));

class infoBoard {

	public $p;
	public $o;
	public $blacklist;
	
	public $now;
	
	public function __construct() {
		$this->p=queryPlayers();
		$this->o=queryObjects();
		$this->blacklist=(PHT_SQLITE===true)?liteQuery("SELECT * FROM `pht_item_blacklist` ",'fetch'):sqlQuery("SELECT * FROM `pht_item_blacklist` ",'fetch');
		$this->now=time();
	}
	
	function date_sort($a,$b) {
		return $a['CREATEDATE'] < $b['CREATEDATE'];
	}
	

	
	
	function latestPlayers() {
	$data = $this->p;
	$now = $this->now;
	if($data !== false){
			$out ='';
			$count = count($data);	
			usort($data,array($this,'date_sort'));
			foreach($data as $val){			
				$cDate = strtotime($val['CREATEDATE']);
				if( $val['GENERATION']==1 && $val['ALIVE']==1 && ($cDate+604800) >= $now   ){
					$out .= '<tr>';
					$out .= '<td class="highlight">'.$val['PLAYERUID'].'</td>';
					$out .= '<td>'.$val['PLAYERNAME'].'</td>';
					$out .= '<td class="highlight">'.dateR($cDate).'</td>';
					$out .= '</tr>';	
				}
			}
		return $out;
		}	
	}
	
	
	function latestObjects() {
	
		$data = $this->o;
		$now = $this->now;

		if($data !== false){
				$out ='';
				$count = count($data);	
				usort($data,array($this,'date_sort'));
				foreach($data as $val){			
					$cDate = strtotime($val['CREATEDATE']);
					if( $val['DAMAGE']==0 && ($cDate+604800) >= $now   ){
						$out .= '<tr>';
						$out .= '<td class="highlight">'.$val['ID'].'</td>';
						$out .= '<td>'.$val['CLASSNAME'].'</td>';
						$out .= '<td class="highlight">'.dateR($cDate).'</td>';
						$out .= '</tr>';	
					}
				}
			return $out;
			}	
		}
	
		function strposa($haystack, $needles=array(), $offset=0) {
			$chr = array();
			foreach($needles as $needle) {
					$res = mb_strpos($haystack, $needle, $offset);
					if ($res !== false) $chr[] = $needle;
			}
			if(empty($chr)) return false;
			return $chr;
		}
	
		function blackListP() {
	
			$data = $this->p;
			$bl = $this->blacklist;
			$blist=array();			
			if ( $bl !==false ){foreach($bl as $k=>$v){$blist[]=mb_strtolower($bl[$k]['item']);}}			
			if($data !== false){
					$out ='';
					foreach($data as $val){	
						$inv = mb_strtolower($val['INVENTORY']);
						$back = mb_strtolower($val['BACKPACK']);
						$is1=$this->strposa($inv,$blist,1);
						$is2=$this->strposa($back,$blist,1);
						if($is1!==false){
							foreach($is1 as $v){	
								$out .= '<tr>';
								$out .= '<td class="highlight">'.$val['ID'].'</td>';
								$out .= '<td>'.$val['PLAYERUID'].'</td>';
								$out .= '<td class="highlight">'.$val['PLAYERNAME'].'</td>';
								$out .= '<td><p>'.$v.'</p><span>'.image($v,'items') .'</span></td>';
								$out .= '<td class="highlight">Inventory</td>';
								$out .= '</tr>';	
							}
						}
						if($is2!==false){
							foreach($is2 as $v){	
							$out .= '<tr>';
							$out .= '<td class="highlight">'.$val['ID'].'</td>';
							$out .= '<td>'.$val['PLAYERUID'].'</td>';
							$out .= '<td class="highlight">'.$val['PLAYERNAME'].'</td>';
							$out .= '<td><p>'.$v.'</p><span>'.image($v,'items').'</span></td>';
							$out .= '<td class="highlight">Backpack</td>';
							$out .= '</tr>';	
							}
						}
				}
				return $out;
				}	
		}
	
		
		function blackListO() {
	
			$data = $this->o;
			$bl = $this->blacklist;
			$blist=array();
					
			if ( $bl !==false ){
				foreach($bl as $k=>$v){$blist[] = mb_strtolower($bl[$k]['item']);}
			}
					
			if($data !== false){
					$out ='';
					foreach($data as $val){	
						$inv = mb_strtolower($val['INVENTORY']);
						$is1 = $this->strposa($inv,$blist,1);
						if($is1!==false){
							foreach($is1 as $v){	
								$out .= '<tr>';
								$out .= '<td class="highlight">'.$val['ID'].'</td>';
								$out .= '<td>'.$val['CLASSNAME'].'</td>';
								$out .= '<td class="highlight"><p>'.$v.'</p><span>'.image($v,'items') .'</span></td>';
								$out .= '<td>Inventory</td>';
								$out .= '</tr>';	
							}
						}
				}
				return $out;
				}	
		}	
	
	
		function recordData($a=1){
		$o=$this->o;
		$p=$this->p;
		$count=0;
		$regex='/land_|storage|shed|bench|wall|floor|fence|pump|wood|hrescue|stick|pole|generator|panel|house|rack|bag|stand|barrel|canvas|wire|hedgehog|net|trap|ramp|fort|nest/i';
		
		
		if($a===1&&$p!==false){foreach($p as $val){$count +=$val['HEADSHOTS'];}}		
		if($a===2&&$p!==false){foreach($p as $val){$count +=$val['KILLZ'];}}	
		if($a===3&&$p!==false){foreach($p as $val){$count +=$val['KILLH'];}}
		if($a===4&&$p!==false){foreach($p as $val){$count +=$val['KILLB'];}}
		if($a===5&&$p!==false){foreach($p as $val){if($val['ALIVE']==1){$count++;}}}
		if($a===6&&$p!==false){foreach($p as $val){if($val['ALIVE']==0){$count++;}}}
				
		if($a===7&&$o!==false){foreach($o as $val){if(!preg_match($regex,$val['CLASSNAME'])){$count++;}}}		
		if($a===8&&$o!==false){foreach($o as $val){if(preg_match($regex,$val['CLASSNAME'])){$count++;}}}		
		if($a===9&&$o!==false){foreach($o as $val){if(!preg_match($regex,$val['CLASSNAME'])&&($val['INVENTORY']=='[[[],[]],[[],[]],[[],[]]]'||$val['INVENTORY']=='[]')){$count++;}}}
		if($a===10&&$o!==false){foreach($o as $val){if(preg_match($regex,$val['CLASSNAME'])&&($val['INVENTORY']=='[[[],[]],[[],[]],[[],[]]]'||$val['INVENTORY']=='[]')){$count++;}}}	
		
		if($a===11&&$o!==false){
			$count='';
			$class=array();
			foreach($o as $v){
				$class[]=$v['CLASSNAME'];
			}
			
			ksort($class);
			foreach( array_count_values($class) as $key => $val){
			
					$count .= '<tr>';
					$count .= '<td class="highlight"><span>'.image($key,'objects','',35).'</span>'.$key.'</td>';
					$count .= '<td>'.$val.'</td>';
					$count .= '</tr>';	
			}
	
		}	
	return $count;
	}


}



	
$das=new infoBoard();


$content='';
$temp = array(
'$[PAGE]'=>self($page),
'$[CONTENTSCRIPTS]'=>$contentScripts,
'$[LATESTPLAYERS]'=>$das->latestPlayers(),
'$[LATESTOBJECTS]'=>$das->latestObjects(),
'$[BLACKLISTP]'=>$das->blackListP(),
'$[BLACKLISTO]'=>$das->blackListO(),
'$[RECORD_HS]'=>$das->recordData(1),
'$[RECORD_KZ]'=>$das->recordData(2),
'$[RECORD_KH]'=>$das->recordData(3),
'$[RECORD_KB]'=>$das->recordData(4),
'$[RECORD_ALIVE]'=>$das->recordData(5),
'$[RECORD_DEAD]'=>$das->recordData(6),
'$[RECORD_V]'=>$das->recordData(7),
'$[RECORD_O]'=>$das->recordData(8),
'$[RECORD_V_EMPTY]'=>$das->recordData(9),
'$[RECORD_O_EMPTY]'=>$das->recordData(10),
'$[RECORD_OV_COUNTER]'=>$das->recordData(11),
'$[_latestPlayers]'=>@_latestPlayers,
'$[_latestObjects]'=>@_latestObjects,
'$[_inBlackListOb]'=>@_inBlackListOb,
'$[_inBlackListP]'=>@_inBlackListP,
'$[_deleteSelected]'=>@_deleteSelected,
'$[_submit]'=>@_submit,
'$[_desc]'=>@_desc,
'$[_edit]'=>@_edit,
'$[_close]'=>@_close,
'$[_save]'=>@_save,
'$[_desc]'=>@_desc,

);
$content .= cRep($temp,'/contents/templates/page_'.$page.'.php');	
echo $content;