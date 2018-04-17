jQuery(document).ready(function($){
$('#vacuum').click(function(e){e.preventDefault();var c=confirm(confirmMSG);if(c==true){$.post(PHT_PAGE,{vacuum:true}).done(function(data){if( data == true ){$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_SUCCESS_EXEC +'</div>');setTimeout(function(){$('#re').hide('puff',function(){ $(this).remove();});},3000);} else {$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR + data +'</div>');}});}});
$('#delCharacter7').click(function(e){e.preventDefault();var c=confirm(confirmMSG);if(c==true){$.post(PHT_PAGE,{delCharacter7:true}).done(function(){window.location.reload();});}});
$('#delCharacter14').click(function(e){e.preventDefault();var c=confirm(confirmMSG);if(c==true){$.post(PHT_PAGE,{delCharacter14:true}).done(function(){window.location.reload();});}});
$('#delCharacter28').click(function(e){e.preventDefault();var c=confirm(confirmMSG); if(c==true){$.post(PHT_PAGE,{delCharacter28:true}).done(function(){window.location.reload();});}});
$('#delCharacter365').click(function(e){e.preventDefault();var c=confirm(confirmMSG); if(c==true){$.post(PHT_PAGE,{delCharacter365:true}).done(function(){window.location.reload();});}});
$('#truncCharacters').click(function(e){e.preventDefault();var c=confirm(confirmMSG); if(c==true){$.post(PHT_PAGE,{truncCharacters:true}).done(function(){window.location.reload();});}});
$('#delCharacterDeaths').click(function(e){e.preventDefault();var c=confirm(confirmMSG); if(c==true){$.post(PHT_PAGE,{delCharacterDeaths:true}).done(function(){window.location.reload();});}});
$('#truncObjects').click(function(e){e.preventDefault();var c=confirm(confirmMSG); if(c==true){$.post(PHT_PAGE,{truncObjects:true}).done(function(){window.location.reload();});}});
$('#delObjectDamage').click(function(e){e.preventDefault();var c=confirm(confirmMSG); if(c==true){$.post(PHT_PAGE,{delObjectDamage:true}).done(function(){window.location.reload();});}});
$('#delObjectVehicles').click(function(e){e.preventDefault();var c=confirm(confirmMSG);if(c==true){$.post(PHT_PAGE,{delObjectVehicles:true}).done(function(){window.location.reload();});}});
$('#delObjectObjects').click(function(e){e.preventDefault();var c=confirm(confirmMSG); if(c==true){$.post(PHT_PAGE,{delObjectObjects:true}).done(function(){window.location.reload();});}});
$('#delObjectEmptyVehicle').click(function(e){e.preventDefault();var c=confirm(confirmMSG);if(c==true){$.post(PHT_PAGE,{delObjectEmptyVehicle:true}).done(function(){window.location.reload();});}});
$('#delObjectEmptyObjects').click(function(e){e.preventDefault();var c=confirm(confirmMSG);if(c==true){$.post(PHT_PAGE,{delObjectEmptyObjects:true}).done(function(){window.location.reload();});}});
$('#delObject7').click(function(e){e.preventDefault();var c=confirm(confirmMSG);if(c==true){$.post(PHT_PAGE,{delObject7:true}).done(function(){window.location.reload();});}});
$('#delObject14').click(function(e){e.preventDefault();var c=confirm(confirmMSG); if(c==true){$.post(PHT_PAGE,{delObject14:true}).done(function(){window.location.reload();});}});
$('#delObject28').click(function(e){e.preventDefault();var c=confirm(confirmMSG); if(c==true){$.post(PHT_PAGE,{delObject28:true}).done(function(){window.location.reload();});}});
$('#delObject365').click(function(e){e.preventDefault();var c=confirm(confirmMSG); if(c==true){$.post(PHT_PAGE,{delObject365:true}).done(function(){window.location.reload();});}});
});
function delByObjectClass(value){var c=confirm(confirmMSG);if(c==true){$.post(PHT_PAGE,{delByObjectClass:value}).done(function(){window.location.reload();});}}