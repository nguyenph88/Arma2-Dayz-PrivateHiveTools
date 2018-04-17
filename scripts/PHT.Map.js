/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/


function deleteObject(id) {
jQuery(function($){	
		var URL='index.php?objects';
		var c=confirm(confirmMSG); 		
		if (c===true){
		$.post( URL,{deleteObject:[id]}).done(function(data){
		if(data==true){
			$('#objectDialog').dialog('close');
			if(showVehicles==true){loadVehicles();}
			if(showObjects==true){loadObjects();}	
		}else{
			$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR +'</div>');
		}
			});
		}
});
}


function repairObject(id) {
	jQuery(function($){	
		var URL='index.php?objects';
		var c=confirm(confirmMSG); 
		if (c===true){
		$.post( URL,{repairObject:id}).done(function(data){	
			$('#content').prepend('<div id="re" style="z-index:9999;font-size:13px;position:fixed;width:300px;right:80px;">'+ data +'</div>');
			setTimeout(function(){$('#re').hide('puff',function(){$(this).remove();});},3000);
			});
		}
	});	
}

function refuelObject(id) {
	jQuery(function($){	
		var URL='index.php?objects';
		var c=confirm(confirmMSG); 
		if (c===true) {
		$.post(URL,{refuelObject:id}).done(function(data) {	
			$('#content').prepend('<div id="re" style="z-index:9999;font-size:13px;position:fixed;width:300px;right:80px;">'+ data +'</div>');
			setTimeout(function(){$('#re').hide('puff',function(){$(this).remove();});},3000);
			});
		}

	});	
}


function updateObjectDialog(){
jQuery(function($){
		var URL='index.php?objects';
		$.fn.serializeObject = function(){ var o = {}; var a = this.serializeArray(); $.each(a, function(){if (o[this.name] !== undefined) { if (!o[this.name].push) { o[this.name] = [o[this.name]];} o[this.name].push(this.value || ''); } else { o[this.name] = this.value || ''; } }); return o; };
			var c=confirm(confirmMSG); 
			var formData = $('#objectDialogForm').serializeObject();
			 if (c===true){		
				 var obJ=JSON.stringify(formData);
					$.post(URL,{updateObject:obJ}).done(function( data ) {
					$('#content').prepend('<div id="re" style="z-index:9999;font-size:13px;position:fixed;width:300px;right:80px;">'+ data +'</div>');
					setTimeout(function(){$('#re').hide('puff',function(){ $(this).remove();});},3000);	
				});
			}
	});		
}





function openObjectDialog(id,name){
jQuery(function($){
	var URL='index.php?objects';
	var d=$('#objectDialog');
	var d=d.dialog({title:name + ' ' + id,show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:800,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['auto',57]});
		
		$.post( URL,{openObjectDialog:id}).done(function(data){
			d.dialog('open').html(data);
				searchObjects();
					searchTools();
						searchItems();
							searchBackPack();
								searchLocation();
				
			$('#accordion').accordion({active:false,width:700,collapsible:true,heightStyle:'content'});						
			$('#objectDialogForm').validationEngine();	
			
			$('#INVENTORY0').on('click','.row-delete',function(e){
			e.preventDefault();
				$('#INVENTORY0 tr:last').remove();
			});
			$('#addINVENTORY0').click(function(e) {
				e.preventDefault();
				var newRow = '<tr><td><button class="none row-delete" type="button"><i class="icon i-delete"></i></button></td><td><input class="searchTools validate[custom[onlyLetterNumber]] text-input" name="INVENTORY[0][0]" value="" type="text" placeholder="empty slot" data-prompt-position="topLeft:0"/></td><td><input class="validate[custom[integer]]" name="INVENTORY[0][1]" value="" type="text" data-prompt-position="topLeft:0"/></td></tr>';
				if ( $('#INVENTORY0 tbody').append(newRow) ) {
					$('input[name="INVENTORY[0][1]"]').spinner({min:1,max:100});
					searchTools();
				}
			});
			
			$('#INVENTORY1').on('click','.row-delete',function(e){
			e.preventDefault();
				$('#INVENTORY1 tr:last').remove();
			});
			
			$('#addINVENTORY1').click(function(e) {
			e.preventDefault();
			var newRow = '<tr><td><button class="none row-delete" type="button"><i class="icon i-delete"></i></button></td><td><input class="searchItems validate[custom[onlyLetterNumber]] text-input" name="INVENTORY[1][0]" value="" type="text" placeholder="empty slot" data-prompt-position="topLeft:0"/></td><td><input class="validate[custom[integer]]" name="INVENTORY[1][1]" value="" type="text" data-prompt-position="topLeft:0"/></td></tr>';
			if ( $('#INVENTORY1 tbody').append(newRow) ) {
				$('input[name="INVENTORY[1][1]"]').spinner({min:1,max:100});
				searchItems();
			}	
			});	
			
			
			$('#INVENTORY2').on('click','.row-delete',function(e){
			e.preventDefault();
				$('#INVENTORY2 tr:last').remove();
			});
			$('#addINVENTORY2').click(function(e) {
			e.preventDefault();
			var newRow = '<tr><td><button class="none row-delete" type="button"><i class="icon i-delete"></i></button></td><td><input class="searchBackPack validate[custom[onlyLetterNumber]] text-input" name="INVENTORY[2][0]" value="" type="text" placeholder="empty slot" data-prompt-position="topLeft:0"/></td><td><input class="validate[custom[integer]]" name="INVENTORY[2][1]" value="" type="text" data-prompt-position="topLeft:0"/></td></tr>';
			if ( $('#INVENTORY2 tbody').append(newRow) ) {
				$('input[name="INVENTORY[2][1]"]').spinner({min:1,max:100});
				searchBackPack();
			}	
			});	
			
			
			
			$('#save').click(function(e){
				e.preventDefault();
				var val=$('#objectDialogForm').validationEngine('validate');
				if(val==true){
					updateObjectDialog();
				}
			});
			
			$('#close').click(function(e){
			e.preventDefault();
				d.dialog('close');
			});
			$('input[name="INVENTORY[0][1]"],input[name="INVENTORY[1][1]"],input[name="INVENTORY[2][1]"]').spinner({min:1,max:100});
		});
	
	});	
}





function updatePlayerDialog(){
	jQuery(function($){
		$.fn.serializeObject = function(){ var o = {}; var a = this.serializeArray(); $.each(a, function(){if (o[this.name] !== undefined) { if (!o[this.name].push) { o[this.name] = [o[this.name]];} o[this.name].push(this.value || ''); } else { o[this.name] = this.value || ''; } }); return o; };
		var c=confirm(confirmMSG); 	
		var URL='index.php?players';

			var formData = $('#playersDialogForm').serializeObject();
			 if ( c == true ) {		
				 var obJ = JSON.stringify( formData );
					$.post( URL, {updatePlayer:obJ}).done(function( data ) {
					$('#content').prepend('<div id="re" style="z-index:9999;font-size:13px;position:fixed;width:300px;right:80px;">'+ data +'</div>');
					setTimeout(function(){$('#re').hide('puff',function(){ $(this).remove();});},5000);
				});
			}
	});		
}




function updatePlayerStatus(id,set){
jQuery(function($){	var URL='index.php?players';
var c=confirm(confirmMSG); 	
	var st=1;
	if(set == 1){ 
	st=0;
	} else if(set == 0){ 
	st=1;
	} 
	if (c==true){
			var obJ=JSON.stringify( {status:st,id:id} );
			$.post(URL,{playerStatus: obJ}).done(function(data){
				$('#content').prepend('<div id="re" style="z-index:9999;font-size:13px;position:fixed;width:300px;right:80px;">'+ data +'</div>');;
				setTimeout(function(){$('#re').hide('puff',function(){$(this).remove();});},3000);
			});
		
		if(st == 1 ){
			$('.status').addClass('alive');
			$('.status').empty().append('&#xf087;');
			$('.status').removeClass('dead');
			
		}else if(st == 0 ){
			$('.status').empty().append('&#xf088;');
			$('.status').addClass('dead');
			$('.status').removeClass('alive');
		}
	} 
	
	});	
}


function healPlayer(id){jQuery(function($){var URL='index.php?players';var c=confirm(confirmMSG);if(c==true){$.post(URL,{healPlayer:id}).done(function(data){$('#content').prepend('<div id="re" style="z-index:9999;font-size:13px;position:fixed;width:300px;right:80px;">'+ data +'</div>');setTimeout(function(){$('#re').hide('puff',function(){$(this).remove();});},5000);});}});}



function openPlayerDialog(id,name,uid){
jQuery(function($){

var d=$('#playersDialog');
var d=d.dialog({title:name + ' ' + uid,show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:800,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
var URL='index.php?players';

$.post(URL,{openPlayerDialog:id}).done(function(data){
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