/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
var curretPAGE=1;
var totalPAGE=1;
jQuery(document).ready(function($){

var url = window.location.href.split('index.php');
var url = url[0];	

$.ajaxSetup({cache:false}); 

$('body').tooltip({track:true});

$('#form').validationEngine();
$('#accordion').accordion({active:false,width:700,collapsible:true,heightStyle:'content'});

$('#epochKeyGen').click(function(e){e.preventDefault();epochKeyGen();});
$('#rconTools').click(function(e){e.preventDefault();rconTools();});


});

function getColor(){var letters ='0123456789ABCDEF'.split('');var color='#';for(var i=0;i<6;i++){color +=letters[Math.round(Math.random()*15)];}return color;}
function clearForm(form){$(':input',form).each(function(){var type=this.type;var tag=this.tagName.toLowerCase();if(type == 'text'){this.value = '';}});};


function epochKeyGen(){
jQuery(function($){
	var input = $('input[name=\'epochKey\']');
	var result = $('#resultKey');
		$('#KeyGen').dialog({autoOpen:true,width:'auto',height:200,resizable:false,position:['auto',57],dialogClass:'',close:function(ev, ui){input.val('');result.val('');}});
		$('#getKey').click(function(e){
			e.preventDefault();
			$.post('ajax.php?token='+ PHT_TOKEN,input.serialize(),function(data){result.val(data);});
		});
		$('#genKey').click(function(e){
			e.preventDefault();
			var number = 1 + Math.floor(Math.random() * 9999);
			$.post('ajax.php?token='+ PHT_TOKEN,input.val(number),function(data){result.val(data);});
		});	 
	});	
}


function rconTools() {
jQuery(function($){
var inValId1 = 0;
var inValId2 = 0;
var rconDialog = function(){$.post('ajax.php?token='+ PHT_TOKEN,{rconTools:true}).done(function( data ) { $('#rconToolsDialog').html(data); });};
var playerData = function(){$.post('ajax.php?token='+ PHT_TOKEN,{rconTools:true,playerData:false}).done();};
playerData();
intValId2 = setInterval(playerData,10000);
$('#content').prepend('<div id="rconToolsDialog" title="RCon" ></div>');	
$('#rconToolsDialog').dialog({autoOpen:false,width:850,height:'auto',minHeight:50,resizable:false,modal:false,draggable:true,position:['center',57],dialogClass:'',close:function(ev, ui){clearInterval(intValId1);clearInterval(intValId2);$(this).dialog('close');}});
rconDialog();
intValId1 = setInterval(rconDialog,15000);
$('#rconToolsDialog').dialog('open');
});
}