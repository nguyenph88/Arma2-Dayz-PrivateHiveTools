jQuery(document).ready(function($){

$('#paginate').bootstrapPaginator({numberOfPages:15,size:'small',alignment:'left',currentPage:curretPAGE,totalPages:totalPAGE,pageUrl:function(type,page,current){return PHT_PAGE + '=' + page;}});

var addItemPool = $('#addItemPoolDialog').dialog({show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:650,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
$('#openAddItemPool').click(function(e){
		e.preventDefault();
		var form = $('#addItemPoolDialogForm');
		addItemPool.dialog('open');		
		clearForm(form);
		form.validationEngine();	
		$('.close').click(function(){addItemPool.dialog('close');});
		$('.submit').click(function(){
		$.fn.serializeObject=function(){var o={};var a=this.serializeArray();$.each(a,function(){if(o[this.name] !== undefined){if(!o[this.name].push){o[this.name]=[o[this.name]];}o[this.name].push(this.value||'');}else{o[this.name]=this.value||'';}});return o;};
			var val=form.validationEngine('validate');
			var data=form.serializeObject();	
			if ( val == true ) { 
				var obJ=JSON.stringify(data);
				$.post(PHT_PAGE, {addItemPool:obJ}).done(function(data) {				
					if ( data == true ) {
						window.location.reload(); 	
					} else {
						$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR + data +'</div>');
					}
				});	
			}
		});	
});	


});

function updateItemPoolDialog(){
	jQuery(function($){
		$.fn.serializeObject = function(){ var o = {}; var a = this.serializeArray(); $.each(a, function(){if (o[this.name] !== undefined) { if (!o[this.name].push) { o[this.name] = [o[this.name]];} o[this.name].push(this.value || ''); } else { o[this.name] = this.value || ''; } }); return o; };
		var dat=$('#ItemPoolDialogForm'); 
		var c=confirm(confirmMSG); 
		var formDat=dat.serializeObject();
		if (c==true){		
			var obJ = JSON.stringify(formDat);
			$.post( PHT_PAGE,{updateItemPool:obJ}).done(function(data){ 	
				if ( data == true ) {
						window.location.reload(); 	
				} else {
					$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR + data +'</div>');
				}
			});
		}
	});		
}


function openItemPoolDialog(id){
jQuery(function($){
var d=$('#ItemPoolDialog'); 
if(d==true){d.remove();}
var	d=d.dialog({show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:650,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
		
		$.post(PHT_PAGE,{openItemPoolDialog:id}).done(function(data){
		
			d.dialog('open').html(data);
			
			$('#ItemPoolDialogForm').validationEngine();
			
			$('.save').click(function(e){
				e.preventDefault();
				var val=$('#ItemPoolDialogForm').validationEngine('validate');
				if(val==true){
					updateItemPoolDialog();
					}
			});
			$('.close').click(function(e){
				e.preventDefault();
				d.dialog('close');
			});
		});
	});	
}