/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
jQuery(document).ready(function($){


var a=$('#addBlacklist').dialog({show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:650,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
$('#openAddBlacklist').click(function(e){
e.preventDefault();	
a.dialog('open');
var form=$('#addBlacklistDialogForm');
clearForm(form);
		$('.submit').click(function(e){
			e.preventDefault();
			$.fn.serializeObject=function(){var o={};var a=this.serializeArray();$.each(a,function(){if(o[this.name] !== undefined){if(!o[this.name].push){o[this.name]=[o[this.name]];}o[this.name].push(this.value||'');}else{o[this.name]=this.value||'';}});return o;};
				var val=form.validationEngine('validate');
				var data=form.serializeObject();	
				if (val==true) { 
					 var obJ=JSON.stringify(data);
					$.post( PHT_PAGE, {addItem:obJ}).done(function(data){ 	
						if( data == true ) {
								window.location.reload(); 	
							} else {
								$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR +'</div>');
							}
					});
				}
		});	
		
	$('.close').click(function(e){e.preventDefault();a.dialog('close');});
});	

});	