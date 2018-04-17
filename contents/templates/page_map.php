<?php defined('PRIVATEHIVETOOLS')||die(@header('HTTP/1.0 404 Not Found'))?>
$[CONTENTSCRIPTS]
<div class="container"><div id="GPS"><div class="gps"><div class="gpsA"></div><div class="gpsX"><div id="X"></div></div><div class="gpsY"><div id="Y"></div></div></div></div><div id="map"></div></div>
<div id="mapMenu" style="display:none;">
	<button style="width:120px;padding:0.3em;" id="showTracker" type="button">Tracking OFF</button>
	<br />
	<button style="width:120px;padding:0.3em;" id="showPlayers" type="button">Players OFF</button>
	<br />
	<button style="width:120px;padding:0.3em;" id="showVehicles" type="button">Vehicles OFF</button>
	<br />
	<button style="width:120px;padding:0.3em;" id="showObjects" type="button">Objects OFF</button>
	<br />
	<button style="width:120px;padding:0.3em;" id="showLocations" type="button">Locations ON</button>
 </div>
 
 <div id="spawn" style="display:none;">
		<div class="container">
			<form id="spawnForm" accept-charset="UTF-8">		
					<fieldset>
						<label for="worldspace">Worldspace:</label>
						<input name="worldspace" value="" type="text" id="worldspace" data-prompt-position="bottomLeft:0" />
						<br />
						<h2>Object</h2>
							<label for="classname">Classname:</label>
							<input class="searchObjects" name="classname" value="" type="text" id="classname" />
						<br />
							<label for="characterid">Char-ID:</label>
							<input name="characterid" value="0" type="text" id="characterid"  placeholder="0  = Default"/>
						<br /><br />
						<h2>Player</h2>
							<label>Player:</label>
							<input class="searchPlayers" name="search[input]" placeholder="PlayerName / PlayerUID / CharID" />
							<input type="hidden" name="charID" />
						<br />
					</fieldset>
				</form>
		 </div>
	<br />
	<button id="SpawnThis" type="button">Spawn</button>
 </div>
 
<div id="playersDialog" style="display:none;"></div>
<div id="objectDialog" style="display:none;"></div>
<div id="trashCan" style="display:none;"><div class="container" style="height:200px;width:215px;overflow:auto;"><form id="trashCanForm" accept-charset="UTF-8"></form></div><br /><button id="deleteTrash" style="padding:0.3em;margin:0.3em;" type="button">$[_delete]</button></div>		

<script>
//<![CDATA[
var line={},color={},intVal1=0,intVal2=0,intVal3=0,showVehicles=false,showObjects=false,showPlayers=false,showTracker=false,showLocations=true,loadVehicles,loadObjects,addTrash;
jQuery(document).ready(function($){
$('#GPS').draggable();
$('#mapMenu').dialog({autoOpen:true,closeOnEscape:false,resizable:false,width:'auto',height:230,position:[360,260],dialogClass:'no-close'});	
$('#trashCan').dialog({title:'Object $[_waste]',autoOpen:false,closeOnEscape:false,resizable:false,width:220,height:310,position:[360,520],dialogClass:'',close:function(ev, ui){$('#trashCanForm').empty();}});	
$('#spawn').dialog({title:'Spawn',autoOpen:false,closeOnEscape:true,resizable:false,width:'auto',height:'auto',position:['center',50],dialogClass:'',close:function(ev, ui){$('#spawnForm input').val('');}});	

var map=new L.map('map',{minZoom:$[MAPminZoom],maxZoom:$[MAPmaxZoom]}).setView($[MAPsetView]);
L.tileLayer('maps/$[MAPname]/{z}/{x}/{y}.png',{tms:true,continuousWorld:true,attribution:'Created by Nightmare - <a href="http://n8m4re.de">N8M4RE.DE</a>'}).addTo(map);

var vehicles=new L.MarkerClusterGroup({chunkedLoading:true});
var objects=new L.MarkerClusterGroup({chunkedLoading:true});
var location=new L.FeatureGroup();
var players=new L.FeatureGroup();
var popup=new L.popup();
var LocationIcon=L.Icon.Label.extend({options:{iconUrl:'style/images/icons/iconStatic.png',shadowUrl:null,iconSize:new L.Point(8, 8),iconAnchor:new L.Point(0, 1),labelAnchor:new L.Point(2, 0),wrapperAnchor:new L.Point(12, 13),labelClassName:'locationLabel'}});
var PlayerIcon=L.Icon.Label.extend({options:{iconUrl:'style/images/icons/null.gif',shadowUrl:null,iconSize: new L.Point(18, 18),iconAnchor: new L.Point(0, 1),labelAnchor: new L.Point(-15, 10),wrapperAnchor: new L.Point(12, 13),labelClassName: 'playerLabel'}});	

function clearPolyLines(){var i=0;for(i in line){if(typeof line[i] !== 'undefined'){map.removeLayer(line[i]);}}}
function gpsX(pixel){pixel=Math.round( $[MAPgpsX] );if( pixel < 0 ){pixel=0;}else{if ( pixel >= $[MAPlimitGPSX] ){pixel=$[MAPlimitGPSX];}}return pixel;}
function gpsY(pixel){pixel=Math.round( $[MAPgpsY] );if( pixel < $[MAPlimitGPSY] ){pixel=$[MAPlimitGPSY];}return pixel;}
function updateGPS(pixel){var X=map.project(pixel.latlng,$[MAPmaxZoom]).x;var Y=map.project(pixel.latlng,$[MAPmaxZoom]).y;$('#X').html(gpsX(X));$('#Y').html(gpsY(Y));}
function loadLocations(){location.clearLayers();$.getJSON(PHT_PAGE + '&returnLocations=true',function(data){if(data.length !==0){for(var i=0;i<data.length;i++){location.addLayer( new L.Marker([data[i].latte, data[i].lange],{clickable:false,icon:new LocationIcon({labelText:data[i].label })}));}}map.addLayer(location);});}

function setMarkerObjects(id,classname,markerX,markerY){
	var X = $[MAPmarkerX];
	var Y = $[MAPmarkerY];
	var Z = $[MAPmaxZoom];
	var latlng = map.unproject([X,Y],Z);
	var m=new L.Marker(latlng,{icon: new L.AwesomeMarkers.icon({markerColor:'black', prefix:'fa', extraClasses:'icon i-objectPool',iconColor:'red'})})
	.on('click',function(e){openObjectDialog(id,classname);})
	.on('mouseover',function(e){e.target.bindPopup('<p>'+ id +'</p><p>' + classname + '</p> <img src="style/images/objects/' + classname.toLowerCase() + '.png" alt="" /><br /><br /><a style="padding:0.3em;" onclick="addTrash('+ id +',\''+ classname +'\');" href="#">$[_addToWaste]</a>').openPopup();});
	objects.addLayer(m);		
}	

function setMarkerVehicles(id,classname,markerX,markerY){
	var X = $[MAPmarkerX];
	var Y = $[MAPmarkerY];
	var Z = $[MAPmaxZoom];
	var latlng = map.unproject([X,Y],Z);	
	var m=new L.Marker(latlng,{icon: new L.AwesomeMarkers.icon({markerColor:'black', prefix:'fa', extraClasses:'icon i-objects',iconColor:'red'})})
	.on('click',function(e){openObjectDialog(id,classname);})
	.on('mouseover',function(e){e.target.bindPopup('<p>'+ id +'</p><p>' + classname + '</p> <img src="style/images/objects/' + classname.toLowerCase() + '.png" alt="" /><br /><br /><a style="padding:0.3em;" onclick="addTrash('+ id +',\''+ classname +'\');" href="#">$[_addToWaste]</a>').openPopup();});
	vehicles.addLayer(m);	
}	

function setMarkerPlayers(id,uid,name,markerX,markerY){
	var X = $[MAPmarkerX];
	var Y = $[MAPmarkerY];
	var Z = $[MAPmaxZoom];
	var latlng = map.unproject([X,Y],Z);
	if ( typeof line[id] !== 'undefined' && showTracker === true) {line[id].addLatLng(latlng);}
	
		var m = new L.Marker(latlng,{icon:new PlayerIcon({ labelText:name,  color: color[id] })})
		//var m=new L.Marker(latlng,{icon: new L.AwesomeMarkers.icon({markerColor:'black', prefix:'fa', extraClasses:'icon i-objects',iconColor:'red'})})
		//.on('mouseover',function(e){e.target.bindPopup('<p>CharID: '+ id +'</p><p>' + name + '</p>')})
		.on('click',function(){openPlayerDialog(id,name,uid);});
		var c = new L.circle(latlng,1000,{ color: color[id], fillColor:color[id], opacity:1, fillOpacity:1 } );

	players.addLayer(m);
	players.addLayer(c);	
}	

(function(){
	loadVehicles=function(){
		vehicles.clearLayers(map);
		vehicles.removeLayers(map);
		map.removeLayer(vehicles);		
		$.getJSON(PHT_PAGE + '&returnVehicles=true',function(data) {
			if ( data.length !== 0 ) {	
				$.each(data,function(id,val){setMarkerVehicles(id,val.classname,val.markerX,val.markerY);});	
				map.addLayer(vehicles);
			}
		});	
	};
}());

(function(){
	loadObjects=function(){
		objects.clearLayers();
		map.removeLayer(objects);
		$.getJSON(PHT_PAGE + '&returnObjects=true',function(data) {
			if ( data.length !== 0 ) {	
				$.each( data, function(id,val){setMarkerObjects(id,val.classname,val.markerX,val.markerY);});	
				map.addLayer(objects);
			}
		});	
	};
}());

function loadPlayers(){
	players.clearLayers(map);
	map.removeLayer(players);
	$.getJSON( PHT_PAGE + '&returnPlayers=true' ).done(function(data){			
	if ( data.length !== 0 ) {						
		$.each(data,function(id,val){		
			if (typeof line[id]==='undefined'){				
				color[id] = getColor();
				line[id] = new L.polyline([],{color:color[id],opacity:1,weight:5,clickable:true}).on('click',function(e){openPlayerDialog(id,val.name,val.uid)});
				map.addLayer(line[id]);
			} 
			setMarkerPlayers(id,val.uid,val.name,val.markerX,val.markerY);
			});
		map.addLayer(players);		
		} 
	});
}

$('#showTracker').click(function(e){	
	e.preventDefault();
	if(showTracker===false){
	$(this).text('Tracking ON');
	$(this).parent().addClass('active');
	showTracker=true;
	}else if(showTracker===true){
	$(this).text('Tracking OFF');
	$(this).parent().removeClass('active');
	showTracker=false;
	clearPolyLines();
	}
});

$('#showPlayers').click(function(e){	
	e.preventDefault();
	if(showPlayers===false){
	$(this).text('Players ON');
	$(this).parent().addClass('active');	
	showPlayers=true;
	loadPlayers();
	intVal1 = setInterval(loadPlayers,5000);
	}else if(showPlayers===true){
	$(this).text('Players OFF');
	$(this).parent().removeClass('active');
	showPlayers=false;
	clearInterval(intVal1);
	players.clearLayers();
	map.removeLayer(players);
	}
});

$('#showObjects').click(function(e){
	e.preventDefault();
	if(showObjects===false){
	$(this).text('Objects ON');
	$(this).parent().addClass('active');
	showObjects=true;
	loadObjects();		
	}else if(showObjects===true){
	$(this).text('Objects OFF');
	$(this).parent().removeClass('active');
	showObjects=false;
	objects.clearLayers();
	map.removeLayer(objects);
	}
});

$('#showVehicles').click(function(e){
	e.preventDefault();
	if(showVehicles===false){
	$(this).text('Vehicles ON');
	$(this).parent().addClass('active');
	showVehicles=true;
	loadVehicles();
	intVal2 = setInterval(loadVehicles,20000);
	}else if(showVehicles===true){
	$(this).text('Vehicles OFF');
	$(this).parent().removeClass('active');
	showVehicles=false;
	clearInterval(intVal2);
	vehicles.clearLayers();
	map.removeLayer(vehicles);
	}
});

$('#showLocations').click(function(e){
	e.preventDefault();
	if(showLocations===false){
	$(this).text('Locations ON');
	$(this).parent().addClass('active');
	showLocations=true;
	loadLocations();	
	}else if(showLocations===true){
	$(this).text('Locations OFF');
	$(this).parent().removeClass('active');
	showLocations=false;
	map.removeLayer(location);
	}
});

addTrash=function(id,classname){$('#trashCan').dialog('open');$('#trashCan #trashCanForm').append( '<li class="OB'+id+'" >'+id+':'+classname+' <input name="ids[]" value="'+id+'" type="hidden" /></li>');var a=$('li.OB'+id );if(a.length>1){a.remove();}    }
$('#deleteTrash').click(function(e){e.preventDefault();
	var c=confirm(confirmMSG); 
	if(c===true){
	var form=$('#trashCanForm');
	var data=form.serializeArray();
		data.push({name:'deleteObjects',value:true})
		$.post(PHT_PAGE,data).done(function(data){if(data===false){$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR + '</div>');}});
		$('input[name="ids[]"]').remove();
		$('#trashCanForm li').remove();
		$('#trashCan').dialog('close');
		if(showVehicles==true){loadVehicles();}
		if(showObjects==true){loadObjects();}
	}
});

$('#sumitMapForm').click(function(event){

		var data = $('#mapForm').serializeArray();
		data.push({name:'set',value:'test'});
		$.post('ajaxMap.php',data,
		function(data){
			$('#result1').html(data);
		});
});	

function onMapClick(pixel){
	$('#spawn').dialog('open');
	searchObjects();
	searchPlayers();	
	var X = Number( map.project(pixel.latlng,$[MAPmaxZoom]).x );
	var Y = Number( map.project(pixel.latlng,$[MAPmaxZoom]).y );	
	Y = ( $[MAPsize] + $[MAPvar] ) - Y;
	//X = <?=$MAP['size'] - $MAP['var'];?> + X;
	Y=Y.toPrecision(6); 
	X=X.toPrecision(6);
	$('#worldspace').val('[0,[' + X + ',' + Y + ',0]]');
	//popup.setLatLng(pixel.latlng);
	//popup.setContent( '[0,[' + X + ',' + Y + ',0]]').openOn(map);
	
	var f1=$('input[name="worldspace"]');
	var f2=$('input[name="classname"]');
	var f3=$('input[name="characterid"]');
	var f4=$('input[name="charID"]');
	var f5=$('input[name="search[input]"]');
	
	$('.searchObjects').focus(function(){f5.val('');f4.val('');f3.val('0');});		
	$('.searchPlayers').focus(function(){f2.val('');f3.val('');});	
		
	$('#SpawnThis').click(function(){				
		$.fn.serializeObject=function(){var o={};var a=this.serializeArray();$.each(a,function(){if(o[this.name] !== undefined){if(!o[this.name].push){o[this.name]=[o[this.name]];}o[this.name].push(this.value||'');}else{o[this.name]=this.value||'';}});return o;};
		var form=$('#spawnForm');
		var data=form.serializeObject();	
		var obJ=JSON.stringify(data);	
		if( f1.val() !=='' && f2.val() !=='' && f3.val() !=='' ){
			$.post(PHT_PAGE, {insertObject:obJ}).done(function(data){if(data === false){$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR + '</div>');}});
		}
			
		if( f1.val() !=='' && f4.val()!=='' && f5.val() !=='' ){
		var ob=JSON.stringify({id:f4.val(), worldspace:f1.val() });
		$.post(PHT_PAGE,{updatePlayerWorldspace:ob}).done(function(data){if(data === false){$('#content').prepend('<div id="re" style="z-index:9999;font-size:18px;position:fixed;width:300px;right:80px;">'+ PHT_ERROR + '</div>');}});
		}
		$('#spawn').dialog('close');	
});	
	
}
$('#SpawnThis').click(function(){
if(showPlayers==true){loadPlayers();}
if(showVehicles==true){loadVehicles();}
if(showObjects==true){loadObjects();}	
});	
		
loadLocations();
map.on('mousemove', updateGPS);
map.on('click', onMapClick);

/**
$('#map').dblclick(function(){
	$('#test').dialog('open');
	map.on('click', function(e) {
		var Y = e.latlng.lat;
		var X = e.latlng.lng;
		$("input[name='X']").val(X);
		$("input[name='Y']").val(Y);
	});
});
**/

});
//]]>
</script>