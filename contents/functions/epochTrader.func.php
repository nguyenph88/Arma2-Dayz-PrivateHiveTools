<?php
/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'));

function TableData($limit,$page){
			$and='';
			 $id=(!empty($_POST['search']['id']))?trim($_POST['search']['id']):false;
			 $input=(!empty($_POST['search']['input'])) ? trim($_POST['search']['input']):false;
			if($input&&is_numeric($input)) {
				$and=' WHERE `tid`='.(int)$input.''; 
				$page=false;
			} elseif($input && !is_numeric($input)) {
				$and=' WHERE `item` LIKE \'%'.secure($input).'%\' '; 
				$page=false;
			}
	
	$row=queryTrader($and,$page,$limit);
	if($row !== false){
	$out='';	
		foreach ( $row as $data ) {		
				$item = isJson($data['item']);
				$sell = isJson($data['sell']);
				$buy  = isJson($data['buy']);			
				$img = mb_strtolower($item[0]).'.png';
				$dir = (file_exists( DIR . '/style/images/items/'.$img)) ? 'style/images/items/'.$img  : 'style/images/objects/'.$img;				
				$out .= '<tr class="tooltip" data-dir="'.$dir.'">';
				$out .= '<td class="highlight"><p>'.$item[0].'</p></td>';
				$out .= '<td><p>'.traderDesc($data['tid']).'</p></td>';	
				$out .= '<td class="highlight">';
				$out .= '<input type="text" id="qty-'.$data['id'].'" name="qty" value="'.$data['qty'].'" data-id="'.$data['id'].'" maxlength="3" />';
				$out .= '</td>';
				$out .= '<td style="width:270px;">';					
				$out .= '<input type="text" id="sell0-'.$data['id'].'" name="sell[0]" value="'.$sell[0].'" data-id="'.$data['id'].'" maxlength="2" />';
				$out .= '<input type="text" style="width:150px;padding:0.35em 0.5em 0.48em 0.5em;margin-left:0.5em;" class="searchCurrency" id="sell1-'.$data['id'].'" name="sell[1]" value="'.$sell[1].'" data-id="'.$data['id'].'" />';			
				$out .= '</td>';	
				$out .= '<td class="highlight" style="width:270px;">';
				$out .= '<input type="text" id="buy0-'.$data['id'].'" name="buy[0]" value="'.$buy[0].'" data-id="'.$data['id'].'" maxlength="2" />';
				$out .= '<input type="text" style="width:150px;padding:0.35em 0.5em 0.48em 0.5em;margin-left:0.5em;" class="searchCurrency" id="buy1-'.$data['id'].'" name="buy[1]" value="'.$buy[1].'" data-id="'.$data['id'].'" />';
				$out .= '</td>';
				$out .= '<td>'. checkbox($data['id'],'check'.$data['id']) .'</td>';
				$out .= '</tr>';
			}	
		return $out;	
 		} 
}

$content='';
if(isset($_POST['submit'])){if(!empty($_POST['checkbox'])&&is_array($_POST['checkbox'])){$content .=(deleteTraderData($_POST['checkbox']))?Notify(count($_POST['checkbox']).'&nbsp;'. success_delete_entries,'success'):Notify(_an_error,'error');}}
$temp=array('$[PAGE]'=>self($page),'$[CONTENTSCRIPTS]'=>$contentScripts,'$[TABLEDATA]'=>TableData($maxResults,$page),'$[_deleteSelected]'=>@_deleteSelected,'$[_submit]'=>@_submit,'$[_add]'=>@_add,	'$[_editOffer]'=>@_editOffer,'$[_item]'=>@_item,'$[_stock]'=>@_stock,'$[_sell]'=>@_sell,'$[_buy]'=>@_buy,'$[_addItemInfo]'=>@_addItemInfo,'$[_addNewProduct]'=>@_addNewProduct,'$[_category]'=>@_category,'$[_object]'=>@_object,'$[_ShopInfo]'=>@_ShopInfo,);
$content .= cRep( $temp, '/contents/templates/page_'.$page.'.php');	
echo $content;