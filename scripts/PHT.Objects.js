/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
jQuery(document).ready(function($){

$('#paginate').bootstrapPaginator({numberOfPages:15,size:'small',alignment:'left',currentPage:curretPAGE,totalPages:totalPAGE,pageUrl:function(type,page,current){return PHT_PAGE + '=' + page;}});
$('.searchHiveObjects').focus(function(){searchHiveObjects();});

$('.tooltip').tooltip({
	track:true,
	items:'[data-dir]',
	content:function(){
		var dir =$(this).attr('data-dir');
		return '<img class="tippics" src="'+ dir +'" alt="" />';
	}
});

});


function deleteObject(id) {
	jQuery(function($){	
		var URL='index.php?objects';
		var c=confirm(confirmMSG); 
		if (c===true){
		$.post( URL,{deleteObject:[id]}).done(function(data){
		if( data == true ) {
					window.location.reload(); 	
				} else {
						$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR + '</div>');
					}
			});
		}
	});
}	
	
var addObject = $('#addObjectDialog').dialog({show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:650,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
$('#openAddObjectDialog').click(function(e){
	e.preventDefault();
		var form = $('#addObjectDialogForm');
		addObject.dialog('open');	
		clearForm(form);
		form.validationEngine();

		$('#selectP').focus(function(e){
			e.preventDefault();
			selectPlayer();
		});	
		
		$('.searchObjects').focus(function(e){
			e.preventDefault();
			searchObjects();
		});	
		
		$('.close').click(function(e){
			e.preventDefault();
			addObject.dialog('close');
		});
		
		$('.submit').click(function(e){
		e.preventDefault();
		$.fn.serializeObject=function(){var o={};var a=this.serializeArray();$.each(a,function(){if(o[this.name] !== undefined){if(!o[this.name].push){o[this.name]=[o[this.name]];}o[this.name].push(this.value||'');}else{o[this.name]=this.value||'';}});return o;};
			var val=form.validationEngine('validate');
			var data=form.serializeObject();	
			if ( val == true ) { 
				var obJ=JSON.stringify(data);
				$.post(PHT_PAGE, {insertObject:obJ}).done(function(data) {				
					if ( data == true ) {
						window.location.reload(); 	
					} else {
						$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR + data +'</div>');
					}
				});	
			}
		});	
});	





function openTeleport(id,name){
	jQuery(function($){
		var d=$('#teleportDialog');
		if(d==true){d.remove();}
		d.dialog({ title:'Teleport: ' + name + ' ' + id,show:'fade',hide:'fade',autoOpen:true,height:'auto',draggable:true,width:800,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
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
									 
										$.post( PHT_PAGE, {updateObjectWorldspace:obJ}).done(function( data ) {
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


function repairObject(id) {
	jQuery(function($){	
		var c = confirm(confirmMSG); 
		if ( c == true ) {
		$.post( PHT_PAGE, {repairObject: id}).done(function( data ) {	
			$('table tbody tr.ob' + id +' td:nth-child(5)')
				.empty()
					.append('<p>0%</p>');
							$('#content').prepend('<div id="re" style="z-index:9999;font-size:13px;position:fixed;width:300px;right:80px;">'+ data +'</div>');
				setTimeout(function(){$('#re').hide('puff',function(){$(this).remove();});},4000);
			});
		}
	});	
}

function refuelObject(id) {
	jQuery(function($){	
		var c = confirm(confirmMSG); 
		if ( c == true ) {
		$.post( PHT_PAGE, {refuelObject: id}).done(function( data ) {	
		
			$('table tbody tr.ob' + id +' td:nth-child(6)')
				.empty()
					.append('<p>100%</p>');
						$('#content').prepend('<div id="re" style="z-index:9999;font-size:13px;position:fixed;width:300px;right:80px;">'+ data +'</div>');
				setTimeout(function(){$('#re').hide('puff',function(){$(this).remove();});},4000);
			});
		}

	});	
}

function updateObjectDialog(){
	jQuery(function($){
		$.fn.serializeObject = function(){ var o = {}; var a = this.serializeArray(); $.each(a, function(){if (o[this.name] !== undefined) { if (!o[this.name].push) { o[this.name] = [o[this.name]];} o[this.name].push(this.value || ''); } else { o[this.name] = this.value || ''; } }); return o; };
		var c = confirm(confirmMSG); 
		
			var formData = $('#objectDialogForm').serializeObject();
			 if ( c == true ) {		
				 var obJ = JSON.stringify( formData );
					$.post( PHT_PAGE, {updateObject:obJ}).done(function( data ) {
					$('#content').prepend('<div id="re" style="z-index:9999;font-size:13px;position:fixed;width:300px;right:80px;">'+ data +'</div>');
						setTimeout(function(){$('#re').hide('puff',function(){ $(this).remove();});},4000);	
					});
			}
	});		
}


function openObjectDialog(id,name){
jQuery(function($){
	var d=$('#objectDialog');
	var d=d.dialog({title:name + ' ' + id,show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:800,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['auto',57]});
		
		$.post( PHT_PAGE,{openObjectDialog:id}).done(function(data){
			d.dialog('open').html(data);
				searchObjects();
					searchTools();
						searchItems();
							searchBackPack();
								searchLocation();
				
			$('#accordion').accordion({width:700,collapsible:true,heightStyle:'content'});						
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