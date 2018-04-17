jQuery(document).ready(function($){

$('#paginate').bootstrapPaginator({numberOfPages:15,size:'small',alignment:'left',currentPage:curretPAGE,totalPages:totalPAGE,pageUrl:function(type,page,current){return PHT_PAGE + '=' + page;}});

var addLocation = $('#addLocationDialog').dialog({show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:650,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
$('#openAddLocation').click(function(e){
	e.preventDefault();
		var form = $('#addLocationDialogForm');
		addLocation.dialog('open');		
		clearForm(form);
		form.validationEngine();	
		$('.close').click(function(){addLocation.dialog('close');});
		$('.submit').click(function(){
		$.fn.serializeObject=function(){var o={};var a=this.serializeArray();$.each(a,function(){if(o[this.name] !== undefined){if(!o[this.name].push){o[this.name]=[o[this.name]];}o[this.name].push(this.value||'');}else{o[this.name]=this.value||'';}});return o;};
			var val=form.validationEngine('validate');
			var data=form.serializeObject();	
			if ( val == true ) { 
				var obJ=JSON.stringify(data);
				$.post( PHT_PAGE, {addLocation:obJ}).done(function(data) {				
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

function updateLocationPoolDialog(){
	jQuery(function($){
		$.fn.serializeObject = function(){ var o = {}; var a = this.serializeArray(); $.each(a, function(){if (o[this.name] !== undefined) { if (!o[this.name].push) { o[this.name] = [o[this.name]];} o[this.name].push(this.value || ''); } else { o[this.name] = this.value || ''; } }); return o; };
		var dat=$('#locationPoolDialogForm'); 
		var c=confirm(confirmMSG); 
		var formDat=dat.serializeObject();
		if (c==true){		
			var obJ = JSON.stringify(formDat);
			$.post( PHT_PAGE,{updateLocation:obJ}).done(function(data){ 	
				if ( data == true ) {
						window.location.reload(); 	
				} else {
					$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR + data +'</div>');
				}
			});
		}
	});		
}


function openLocationPoolDialog(id){
jQuery(function($){
var d=$('#LocationPoolDialog'); 
if(d==true){d.remove();}
var	d=d.dialog({show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:650,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
		
		$.post( PHT_PAGE,{openLocationPoolDialog:id}).done(function(data){
		
			d.dialog('open').html(data);
			
			$('#locationPoolDialogForm').validationEngine();
			
			$('.save').click(function(e){
			e.preventDefault();
				var val=$('#locationPoolDialogForm').validationEngine('validate');
				if(val==true){
					updateLocationPoolDialog();
					}
			});
			$('.close').click(function(e){
				e.preventDefault();
				d.dialog('close');
			});
		});
	});	
}