/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
jQuery(document).ready(function($){

$('#paginate').bootstrapPaginator({numberOfPages:15,size:'small',alignment:'left',currentPage:curretPAGE,totalPages:totalPAGE,pageUrl:function(type,page,current){return PHT_PAGE + '=' + page;}});
var parseTrader = $('#parseTrader').dialog({show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:'auto',modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
$('#openParseTrader').click(function(){
	parseTrader.dialog('open');
		$('#submitParseTrader').click(function(e){	
	e.preventDefault();
		var url=PHT_PAGE +'&parseTraderPool=true';
		var data=$.trim($('textarea[name="sqf"]').val().replace('\t',''));
		data=btoa(data);
		if ( data !== '' ) { 
			$.post( url,{value:data}).done(function(data){ 
			if( data == true ) {
					window.location.reload(); 	
				} else {
						$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR + data +'</div>');
					}
			
			});	
		}
	});
});	


var addTrader = $('#addTraderDialog').dialog({show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:650,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});

$('#openAddTrader').click(function(e){
	e.preventDefault();	
		var form=$('#addTraderDialogForm');	
		clearForm(form);
		addTrader.dialog('open');			
		form.validationEngine();	
		$('#tids1').on('click','.row-delete',function(e){
		e.preventDefault();
			$('#tids1 tr:last').remove();
		});
		$('#addtid1').click(function(e) {
		e.preventDefault();
		var newRow = '<tr>'
							 + '<td><button class="none row-delete" type="button"><i class="icon i-delete"></i></button></td>'
							 + '<td><input class="validate[required] text-input" name="tid0" value="" type="text" data-prompt-position="bottomLeft:0" /></td>'
							 + '<td><input style="width:80px;" class="validate[required,custom[integer],minSize[1]]" name="tid1" value="" type="text" data-prompt-position="bottomLeft:0" /></td>'
							 + '</tr>';
			 $('#tids1 tbody').append(newRow);
		});
		$('.close').click(function(e){
		e.preventDefault();
			addTrader.dialog('close');
		});
		$('.submit').click(function(e){
		e.preventDefault();
		$.fn.serializeObject=function(){var o={};var a=this.serializeArray();$.each(a,function(){if(o[this.name] !== undefined){if(!o[this.name].push){o[this.name]=[o[this.name]];}o[this.name].push(this.value||'');}else{o[this.name]=this.value||'';}});return o;};
			var val=form.validationEngine('validate');
			var data=form.serializeObject();	
			if ( val == true ) { 
			 var obJ=JSON.stringify(data);
			$.post( PHT_PAGE, {addTrader:obJ}).done(function(data){ 	
			if( data == true ) {
				window.location.reload(); 	
					} else {
						$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR + data +'</div>');
					}
				});
			}
		});	
});	
});


function updateTraderDialog(){
	jQuery(function($){
		$.fn.serializeObject = function(){ var o = {}; var a = this.serializeArray(); $.each(a, function(){if (o[this.name] !== undefined) { if (!o[this.name].push) { o[this.name] = [o[this.name]];} o[this.name].push(this.value || ''); } else { o[this.name] = this.value || ''; } }); return o; };
		var dat=$('#traderDialogForm'); 
		var c=confirm(confirmMSG); 
		var formDat=dat.serializeObject();
		if (c==true){		
			var obJ = JSON.stringify(formDat);
			$.post( PHT_PAGE,{updateTrader:obJ}).done(function(data){ 	
				if ( data == true ) {
						window.location.reload(); 	
				} else {
					$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR + data +'</div>');
				}
			});
		}
	});		
}


function openTraderDialog(id){
jQuery(function($){
var d=$('#TraderDialog');
var	d=d.dialog({show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:650,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
		$.post( PHT_PAGE ,{openTraderDialog:id}).done(function(data){
		d.dialog('open').html(data);
		$('#traderDialogForm').validationEngine();
		$('#tids').on('click','.row-delete',function(e){
			e.preventDefault();
			$('#tids tr:last').remove();
		});
		$('#addtid').click(function(e) {
			e.preventDefault();
				var newRow = '<tr>'
							 + '<td><button class="none row-delete" type="button"><i class="icon i-delete"></i></button></td>'
							 + '<td><input class="validate[required] text-input" name="tid0" value="" type="text" data-prompt-position="bottomLeft:0" /></td>'
							 + '<td><input style="width:80px;" class="validate[required,custom[integer],minSize[1]]" name="tid1" value="" type="text" data-prompt-position="bottomLeft:0" /></td>'
							 + '</tr>';
		$('#tids tbody').append(newRow);
		});	
		$('.save').click(function(e){
			e.preventDefault();
			var val=$('#traderDialogForm').validationEngine('validate');if(val==true){updateTraderDialog();}
		});
		$('.close').click(function(e){
		e.preventDefault();
			d.dialog('close');
		});
		});
	});	
}