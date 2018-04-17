/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
jQuery(document).ready(function($){

$('#paginate').bootstrapPaginator({numberOfPages:15,size:'small',alignment:'left',currentPage:curretPAGE,totalPages:totalPAGE,pageUrl:function(type,page,current){return PHT_PAGE + '=' + page;}});
$('.searchPlayers').focus(function(){
	searchPlayers();
});

	
});


function openTeleport(id,name){
	jQuery(function($){
		var d=$('#teleportDialog');
		d.dialog({ title:'Teleport: ' + name ,show:'fade',hide:'fade',autoOpen:true,height:'auto',draggable:true,width:800,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
		$.post( PHT_PAGE,{openTeleport:id}).done(function(data){
			d.dialog('open').html(data);
			
			$('.telePlayer').focus(function(){
				$('#b').val('');
				$('.searchLocation').val('');
				telePlayer();
			});	
			
			$('.searchLocation').focus(function(){
				$('#a').val('')
				$('.telePlayer').val('');
				searchLocation();
			});	
			
			$('#tele').click(function(e){
			e.preventDefault();
				if (($('#a').val()!==''&& $('#b').val()=='')||($('#b').val()!==''&&$('#a').val() =='')){
				var worldspace = '[]';
						if ($('#a').val() !=='') {
						  worldspace = $('#a').val();
						} else if ( $('#b').val() !=='' ) {
							 worldspace = $('#b').val();
						
						}
						var c=confirm(confirmMSG); 	
							if(c==true) {
								var obJ = JSON.stringify({id:id,worldspace:worldspace});
									 $.post( PHT_PAGE, {updatePlayerWorldspace:obJ}).done(function( data ) {
										$('#content').prepend('<div id="re" style="z-index:9999;font-size:13px;position:fixed;width:300px;right:80px;">'+ data +'</div>');
										setTimeout(function(){$('#re').hide('puff',function(){ $(this).remove();});},5000);
									});
								}
						d.dialog('close');
						}	
				});	
		});

	});		
}



function healPlayer(id){
	jQuery(function($){	
		var c=confirm(confirmMSG); 
		if (c == true){
		$.post( PHT_PAGE, {healPlayer: id}).done(function( data ) {	
				$('#content').prepend('<div id="re" style="z-index:9999;font-size:13px;position:fixed;width:300px;right:80px;">'+ data +'</div>');
				setTimeout(function(){$('#re').hide('puff',function(){$(this).remove();});},5000);
			});
		}

	});	
}


function updatePlayerStatus(id,st){
jQuery(function($){	
if ($('table tbody tr.char'+ id).attr('data-status')=='alive'){var set=0;}else if ($('table tbody tr.char'+ id).attr('data-status')=='dead'){var set =1;} 
	var c=confirm(confirmMSG); 
	 if (c==true){
		if(set==1||set==0){
		$('table tbody tr.char' + id).removeAttr('data-status');
			var obJ = JSON.stringify( {status:set,id:id} );
			$.post( PHT_PAGE, {playerStatus: obJ}).done(function( data ) {
			var select = $('table tbody tr.char' + id +' td:nth-child(6) span');		
			if (set == 1 ) {
					select.empty().append('<b style="color:#2DB300;">&#xf087;</b>');
					$('table tbody tr.char' + id).attr('data-status','alive');	
					$('.status').addClass('alive');
					$('.status').empty().append('&#xf087;');
					$('.status').removeClass('dead');
					
			}else if( set == 0 ) {
					select.empty().append('<b style="color:#D90000;">&#xf088;</b>');
					$('table tbody tr.char' + id).attr('data-status','dead');
					$('.status').empty().append('&#xf088;');
					$('.status').addClass('dead');
					$('.status').removeClass('alive');	
			}
			
			$('#content').prepend('<div id="re" style="z-index:9999;font-size:13px;position:fixed;width:300px;right:80px;">'+ data +'</div>');;
			setTimeout(function(){$('#re').hide('puff',function(){$(this).remove();});},5000);
			});
		}
	} 
	});	
}




function updatePlayerDialog(){
	jQuery(function($){
		$.fn.serializeObject = function(){ var o = {}; var a = this.serializeArray(); $.each(a, function(){if (o[this.name] !== undefined) { if (!o[this.name].push) { o[this.name] = [o[this.name]];} o[this.name].push(this.value || ''); } else { o[this.name] = this.value || ''; } }); return o; };
		var c=confirm(confirmMSG); 	
			var formData = $('#playersDialogForm').serializeObject();
			 if ( c == true ) {		
				 var obJ = JSON.stringify( formData );
					$.post( PHT_PAGE, {updatePlayer:obJ}).done(function( data ) {
					$('#content').prepend('<div id="re" style="z-index:9999;font-size:13px;position:fixed;width:300px;right:80px;">'+ data +'</div>');
					setTimeout(function(){$('#re').hide('puff',function(){ $(this).remove();});},5000);
				});
			}
	});		
}

function openPlayerDialog(id,name,uid){
jQuery(function($){
var d=$('#playersDialog');
var d=d.dialog({title:name + ' ' + uid,show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:800,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
$.post(PHT_PAGE,{openPlayerDialog:id}).done(function(data){
	d.dialog('open').html(data);
					searchTools();
						searchItems();
							searchModel();
								searchBackPack();
									searchLocation();
									
			$('#accordion2').accordion({active:false,width:700,collapsible:true,heightStyle:'content'});						
			$('#playersDialogForm').validationEngine();	
			$('#backItemSlots').on('click','.row-delete',function(e){
				e.preventDefault();
				$('#backItemSlots tr:last').remove();
			});
			$('#addBackItemSlot').click(function(e){
			e.preventDefault();
				var newRow = '<tr>'
								+ 
								'<td><button class="none row-delete" type="button"><i class="icon i-delete"></i></button></td>'
								+ 
								'<td><input class="searchItems validate[custom[onlyLetterNumber]] text-input" name="BACKPACK[2][0]" value="" type="text" placeholder="empty slot" data-prompt-position="topLeft:0"/></td>'
								+ 
								'<td><input class="validate[custom[integer]]" name="BACKPACK[2][1]" value="" type="text" data-prompt-position="topLeft:0"/></td>'
								+ 
							'</tr>';
								
				if ( $('#backItemSlots tbody').append(newRow) ) {
					$('input[name="BACKPACK[2][1]"]').spinner({min:1,max:100});
					searchItems();
				}
			});
			$('#backToolSlots').on('click','.row-delete',function(e){
			e.preventDefault();
				$('#backToolSlots tr:last').remove();
			});
			$('#addBackToolSlot').click(function(e) {
			e.preventDefault();
			var newRow = '<tr>' 
						+
						'<td><button class="none row-delete" type="button"><i class="icon i-delete"></i></button></td><td>'
						+
						'<input class="searchTools validate[custom[onlyLetterNumber]] text-input" name="BACKPACK[1][0]" value="" type="text" placeholder="empty slot" data-prompt-position="topLeft:0"/></td>'
						+
						'<td><input class="validate[custom[integer]]" name="BACKPACK[1][1]" value="" type="text" data-prompt-position="topLeft:0"/></td>'
						+
						'</tr>';
							
							
			if ($('#backToolSlots tbody').append(newRow)) {
				$('input[name="BACKPACK[1][1]"]').spinner({min:1,max:100});
				searchTools();
			}	
			});	
			
			$('#save').click(function(e){
			e.preventDefault();
			if($('#playersDialogForm').validationEngine('validate')){
				updatePlayerDialog();
			}
			});
			$('#close').click(function(e){
			e.preventDefault();
				d.dialog('close');
			});
			$('#KILLZ,#HEADSHOTS,#KILLH,#KILLB').spinner({min:0});
			$('input[name="BACKPACK[2][1]"],input[name="BACKPACK[1][1]"]').spinner({min:1,max:100});
			$('#HUMANITY').spinner();
		});
	
	});	
}