jQuery(document).ready(function($){

$('#paginate').bootstrapPaginator({numberOfPages:15,size:'small',alignment:'left',currentPage:curretPAGE,totalPages:totalPAGE,pageUrl:function(type,page,current){return PHT_PAGE + '=' + page;}});
var addObject = $('#addObjectDialog').dialog({show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:650,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
$('#openAddObjectDialog').click(function(e){
	e.preventDefault();
		var form = $('#addObjectDialogForm');
		addObject.dialog('open');		
		clearForm(form);
		$('.close').click(function(e){
			e.preventDefault();
			addObject.dialog('close');
		});
		
				form.validationEngine();	

	$('.submit').click(function(e){
		if ( $('#classname').val() !== '' ){
					e.preventDefault();
					$.fn.serializeObject=function(){var o={};var a=this.serializeArray();$.each(a,function(){if(o[this.name] !== undefined){if(!o[this.name].push){o[this.name]=[o[this.name]];}o[this.name].push(this.value||'');}else{o[this.name]=this.value||'';}});return o;};
					var data=form.serializeObject();	
						var obJ=JSON.stringify(data);
						$.post(PHT_PAGE, {addObject:obJ}).done(function(data) {				
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

function updateObjectPoolDialog(){
	jQuery(function($){
		$.fn.serializeObject = function(){ var o = {}; var a = this.serializeArray(); $.each(a, function(){if (o[this.name] !== undefined) { if (!o[this.name].push) { o[this.name] = [o[this.name]];} o[this.name].push(this.value || ''); } else { o[this.name] = this.value || ''; } }); return o; };
		var dat=$('#ObjectPoolDialogForm'); 
		var c=confirm(confirmMSG); 
		var formDat=dat.serializeObject();
		if (c==true){		
			var obJ = JSON.stringify(formDat);
			$.post( PHT_PAGE,{updateObjectPool:obJ}).done(function(data){ 	
				if ( data == true ) {
						window.location.reload(); 	
				} else {
					$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR + data +'</div>');
				}
			});
		}
	});		
}


function openObjectPoolDialog(id){
jQuery(function($){
var d=$('#ObjectPoolDialog'); 
var	d=d.dialog({show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:650,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
		
		$.post( PHT_PAGE,{openObjectPoolDialog:id}).done(function(data){
		
			d.dialog('open').html(data);
			
			$('#ObjectPoolDialogForm').validationEngine();
			
			$('.save').click(function(e){
				e.preventDefault();
				var val=$('#ObjectPoolDialogForm').validationEngine('validate');
				if(val==true){
					updateObjectPoolDialog();
					}
			});
			$('.close').click(function(e){
				e.preventDefault();
				d.dialog('close');
			});
		});
	});	
}