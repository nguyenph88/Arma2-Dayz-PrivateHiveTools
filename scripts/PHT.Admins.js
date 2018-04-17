/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
jQuery(document).ready(function($){

$('#paginate').bootstrapPaginator({numberOfPages:15,size:'small',alignment:'left',currentPage:curretPAGE,totalPages:totalPAGE,pageUrl:function(type,page,current){return PHT_PAGE + '=' + page;}});

var addAdmin = $('#addAdminDialog').dialog({show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:650,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
$('#openAddAdmin').click(function(e){
e.preventDefault();	
addAdmin.dialog('open');
var form=$('#addAdminDialogForm');
clearForm(form);
		
		$('#genpw').pGenerator({'bind': 'click','passwordElement':'.pwout','passwordLength':15,'uppercase':true,'lowercase':true,'numbers':true,'specialChars':false,'onPasswordGenerated': function(generatedPassword) {
		$('#pwout').attr('value',generatedPassword);}});

		$('.submit').click(function(e){
			e.preventDefault();
			$.fn.serializeObject=function(){var o={};var a=this.serializeArray();$.each(a,function(){if(o[this.name] !== undefined){if(!o[this.name].push){o[this.name]=[o[this.name]];}o[this.name].push(this.value||'');}else{o[this.name]=this.value||'';}});return o;};
				var val=form.validationEngine('validate');
				var data=form.serializeObject();	
				if (val==true) { 
					 var obJ=JSON.stringify(data);
					$.post( PHT_PAGE, {addAdmin:obJ}).done(function(data){ 	
						if( data == true ) {
								window.location.reload(); 	
							} else {
								$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR +data +'</div>');
							}
					});
				}
		});	
		
	$('.close').click(function(e){e.preventDefault();addAdmin.dialog('close');});
});	

});	


function changePass(id){

var input=$('input[name="password2"]').val('');	

var a=$('#changePassDialog').dialog({show:'fade',hide:'fade',autoOpen:true,height:'auto',draggable:true,width:650,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});

$('#genpw2').pGenerator({'bind': 'click','passwordElement':'.pwout2','passwordLength':15,'uppercase':true,'lowercase':true,'numbers':true,'specialChars':false,'onPasswordGenerated': function(generatedPassword) {
$('#pwout2').attr('value',generatedPassword);}});

	$('.submit').click(function(e){
		e.preventDefault();
			var val=input.validationEngine('validate');
			if ( val == false ) { 
				 var obJ=JSON.stringify({id:id,password:input.val()});
				$.post( PHT_PAGE, {changePass:obJ}).done(function(data){ 	
				if( data == true ) {
					window.location.reload(); 	
						} else {
							$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR +'</div>');
						}
					});
				}
		});	
		
		
		
	$('.close').click(function(e){e.preventDefault();a.dialog('close');});
}





function changePerm(id){


var a=$('#changePermDialog').dialog({show:'fade',hide:'fade',autoOpen:true,height:'auto',draggable:true,width:650,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});

	$('.submit').click(function(e){
	permList = [];
	$('option:selected').each(function() {
			permList.push($(this).val())
		});

		e.preventDefault();
				 var obJ=JSON.stringify({id:id, permissions:permList });
				$.post( PHT_PAGE, {changePerm:obJ}).done(function(data){ 	
				if( data == true ) {
					window.location.reload(); 	
						} else {
							$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR + data +'</div>');
						}
					});
		
		});	
		
		
		
	$('.close').click(function(e){e.preventDefault();a.dialog('close');});
}







