/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/

function searchCurrency(){
	jQuery(function($){	
		$('.searchCurrency').autocomplete({minLength:1,source:function(request,response){
		
		$.getJSON('ajax.php?searchCurrency&token='+ PHT_TOKEN,request,function(data){
				if(data.length !== 0){
					response(data);
				}
			});
		}
		}).each(function() {$(this).data('ui-autocomplete')._renderItem = function (ul, item) { return $('<li>').append('<a style="border-bottom:solid 1px #fff"><img style="height:35px;width:35px;" src="style/images/items/' + item.value.toLowerCase() + '.png" alt="" />' + item.value + '</a>') .appendTo(ul);};});
	});	
}

function searchTools(){
	jQuery(function($){	
		$('.searchTools').autocomplete({minLength:1,source:function(request,response){
		$.getJSON('ajax.php?searchTools&token='+ PHT_TOKEN, request,function(data){
			if ( data.length !== 0 ) {
				response(data);
				}
			});
		}
		
		}).each(function() {$(this).data('ui-autocomplete')._renderItem = function (ul, item) { return $('<li>').append('<a style="border-bottom:solid 1px #fff"><img style="height:35px;width:35px;" src="style/images/items/' + item.value.toLowerCase() + '.png" alt="" />' + item.value + '</a>') .appendTo(ul);};});
	});	
}

function searchItems(){
	jQuery(function($){	
		$('.searchItems').autocomplete({minLength:1,source:function(request,response){
		
		$.getJSON('ajax.php?searchItems&token='+ PHT_TOKEN,request,function(data){
		if ( data.length !== 0 ) {
			response(data);
			}
		});
		
		}
		}).each(function() {$(this).data('ui-autocomplete')._renderItem = function (ul, item) { return $('<li>').append('<a style="border-bottom:solid 1px #fff"><img style="height:35px;width:35px;" src="style/images/items/' + item.value.toLowerCase() + '.png" alt="" />' + item.value + '</a>') .appendTo(ul);};});
	});	
}

function searchModel(){
	jQuery(function($){
		$('.searchModel').autocomplete({minLength:1,source:function(request,response){
		$.getJSON('ajax.php?searchModel&token='+ PHT_TOKEN,request,function(data){
		if ( data.length !== 0 ) {
			response(data);
			}
		});
		}
		}).each(function() {$(this).data('ui-autocomplete')._renderItem = function (ul, item) { return $('<li>').append('<a style="border-bottom:solid 1px #fff"><img style="height:45px;width:30px;" src="style/images/models/' + item.value.toLowerCase() + '.png" alt="" />' + item.value + '</a>') .appendTo(ul);};});
	});	
}


function searchBackPack(){
	jQuery(function($){
		$('.searchBackPack').autocomplete({minLength:1,source:function(request,response){
			$.getJSON('ajax.php?searchBackPack&token='+ PHT_TOKEN,request,function(data){
				if ( data.length !== 0 ) {
					response(data);
				}
			});
		}
		}).each(function() {$(this).data('ui-autocomplete')._renderItem = function (ul, item) { return $('<li>').append('<a style="border-bottom:solid 1px #fff"><img style="height:35px;width:35px;" src="style/images/items/' + item.value.toLowerCase() + '.png" alt="" />' + item.value + '</a>') .appendTo(ul);};});
	});	
}	


function searchObjects(){
	jQuery(function($){
		$('.searchObjects').autocomplete({minLength:1,source:function(request,response){
			$.getJSON('ajax.php?searchObjects&token='+ PHT_TOKEN,request,function(data){
				if ( data.length !== 0 ) {
					response(data);
				}
			});
		}
		}).each(function() {$(this).data('ui-autocomplete')._renderItem = function (ul, item) { return $('<li>').append('<a style="border-bottom:solid 1px #fff"><img style="height:35px;width:35px;" src="style/images/objects/' + item.value.toLowerCase() + '.png" alt="" />' + item.value + '</a>') .appendTo(ul);};});
	});	
}	


function searchLocation(){
	jQuery(function($){
		$('.searchLocation').autocomplete({minLength:1,
		source:function(request,response){
			$.getJSON('ajax.php?searchLocation&token='+ PHT_TOKEN,request,function(data){
			response($.map(data.location, function(el, index){ 
			return { space: el.space, desc: el.desc};
			}));
		});
		},
		select: function( event, ui ) {
		$('input[name=\'DESCRIPTION\']').val( ui.item.desc );
		$('input[name=\'WORLDSPACE\']').val( ui.item.space );
		$('#b').val( ui.item.space );
		return false;
		}
		}).data('ui-autocomplete')._renderItem = function (ul, item) {
		return $('<li>').append('<a style="border-bottom:solid 1px #fff"><b>' + item.desc + '</b><br />' + item.space + '</a>').appendTo(ul);
		};  
	});	
}

function telePlayer(){
jQuery(function($){
		$('.telePlayer').autocomplete({
		minLength:1,
		source:function(request,response){		
		$.getJSON('ajax.php?searchPlayers&token='+ PHT_TOKEN,request,function(data){
		response($.map(data.players, function(el, index){ 	
		return { uid: el.uid, name: el.playername, worldspace: el.worldspace}; }));});},		
		select: function( event, ui ) {
		$('input[name=\'playerName\']').val( ui.item.name );
		$('#a').val( ui.item.worldspace );
		$('#pSpace').val( ui.item.worldspace );
		return false;
		}
		}).data('ui-autocomplete')._renderItem = function (ul, item) {
		return $('<li>').append('<a style="border-bottom:solid 1px #fff"><b>' + item.name + '</b><br />' + item.uid + '</a>').appendTo(ul);
		};    
	});	
}


function selectPlayer(){
jQuery(function($){
		$('#selectP').autocomplete({
		minLength:1,
		source:function(request,response){		
		$.getJSON('ajax.php?searchPlayers&token='+ PHT_TOKEN,request,function(data){
		response($.map(data.players, function(el, index){ 	
		return { uid: el.uid, name: el.playername, worldspace: el.worldspace}; }));});},		
		select: function( event, ui ) {
		$('input[name=\'playerName\']').val( ui.item.name );
		$('#pSpace').val( ui.item.worldspace );
		return false;
		}
		}).data('ui-autocomplete')._renderItem = function (ul, item) {
		return $('<li>').append('<a style="border-bottom:solid 1px #fff"><b>' + item.name + '</b><br />' + item.uid + '</a>').appendTo(ul);
		};    
	});	
}





function searchPlayers(){
jQuery(function($){
		$('.searchPlayers').autocomplete({
		minLength:1,
		source:function(request,response){		
		$.getJSON('ajax.php?searchPlayers&token='+ PHT_TOKEN,request,function(data){
		response($.map(data.players, function(el, index){ 	
		return { id: el.id, uid: el.uid, name: el.playername, worldspace: el.worldspace}; }));});},		
		select: function( event, ui ) {
		$('input[name=\'search[input]\']').val( ui.item.name );
		$('input[name=\'search[uid]\']').val( ui.item.uid );
		$('input[name=\'charID\']').val( ui.item.id );
		return false;
		}
		}).data('ui-autocomplete')._renderItem = function (ul, item) {
		return $('<li>').append('<a style="border-bottom:solid 1px #fff"><b>' + item.name + '</b><br />' + item.uid + '</a>').appendTo(ul);
		};    
	});	
}


function searchHiveObjects(){
jQuery(function($){
		$('.searchHiveObjects').autocomplete({minLength:1,
		source:function(request,response){		
		$.getJSON('ajax.php?searchHiveObjects&token='+ PHT_TOKEN,request,function(data){
		response($.map(data.objects, function(el, index){ return { oid:el.id, name:el.classname};}));});},
		select: function( event, ui ) {
		$('input[name=\'search[input]\']').val( ui.item.name );
		$('input[name=\'search[id]\']').val( ui.item.oid );
		return false;
		}
		}).data('ui-autocomplete')._renderItem = function (ul, item) {
		return $('<li>').append('<a style="border-bottom:solid 1px #fff"><img style="height:35px;width:35px;" src="style/images/objects/' + item.name.toLowerCase() + '.png" alt="" /><b>' + item.name + '</b></a>').appendTo(ul);
		};    
	});	
}