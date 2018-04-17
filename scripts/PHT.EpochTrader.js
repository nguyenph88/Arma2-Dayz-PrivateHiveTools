/****************************
PrivateHiveTools by Nightmare
http://n8m4re.de
*****************************/
jQuery(document).ready(function($){

$('#paginate').bootstrapPaginator({numberOfPages:15,size:'small',alignment:'left',currentPage:curretPAGE,totalPages:totalPAGE,pageUrl:function(type,page,current){return PHT_PAGE + '=' + page;}});

/**ignore enter key**/
$('input[name="qty"],input[name="sell[0]"],input[name="sell[1]"],input[name="buy[0]"],input[name="buy[1]"]').keydown(function(event){if(event.keyCode == 13){event.preventDefault();}});
	
	
$('.tooltip').tooltip({
	track:true,
	items:'[data-dir]',
	content:function(){
		var dir =$(this).attr('data-dir');
		return '<img class="tippics" src="'+ dir +'" alt="" />';
	}
});

$('.searchTraderHiveData').autocomplete({minLength:1,source:function(request,response){		
$.getJSON('ajax.php?searchTraderHiveData&token='+ PHT_TOKEN,request,function(data){response($.map(data.objects,function(el,index){return {id:el.id,name:el.item};}));});},select:function(event,ui){$('input[name=\'search[input]\']').val(ui.item.name);$('input[name=\'search[id]\']').val(ui.item.id);return false;}
}).data('ui-autocomplete')._renderItem = function (ul, item){return $('<li>').append('<a style="border-bottom:solid 1px #fff"><b>' + item.name + '</b></a>').appendTo(ul);};   

	
$('input[name="buy[1]"]').focus(function(){
	searchCurrency();
	$(this).bind('change keyup', function(e) {	
		if (e.type=='change' || e.keyCode== 13){
			var max=12;
			var url='ajax.php?updateTraderData=buy&token='+ PHT_TOKEN;
			var dataId = $(this).attr('data-id');
			var buy0 = $('#buy0-' + dataId ).val();
			var buy1 = $(this).val();
			
			if ( !isNaN(buy0) && buy1 !=='') {
				var data = [buy0,buy1,1];
				if ( data instanceof Array ) {
					$.post(url,{id:dataId,value:data}).done();
					//console.log(data);
				}
			}
		}	
	});
 });	
	
	
$('input[name="sell[1]"]').focus(function(){
	searchCurrency();
	$(this).bind('change keyup', function(e) {	
		if (e.type=='change' || e.keyCode== 13){
			var max=12;
			var url='ajax.php?updateTraderData=sell&token='+ PHT_TOKEN;
			var dataId = $(this).attr('data-id');
			var sell0 = $('#sell0-' + dataId ).val();
			var sell1 = $(this).val();
			
			if ( !isNaN(sell0) && sell1 !=='') {
				var data = [sell0,sell1,1];
				
				if ( data instanceof Array ) {
					$.post(url,{id:dataId,value:data}).done();
					//console.log(data);
				}
			}
		}		
	});
 });	
	

$('input[name="buy[0]"]').spinner();
$('input[name="buy[0]"]').focus(function(){
	var max=12;
	var url='ajax.php?updateTraderData=buy&token='+ PHT_TOKEN;
	var dataId = $(this).attr('data-id');
		$(this).spinner({min:0,max:max,stop:function(event,ui){
			var buy0 = this.value;
			var buy1 = $('#buy1-' + dataId ).val();
			
			if ( !isNaN(buy0) && buy1 !=='') {
				var data = [buy0,buy1,1];
				
				if ( data instanceof Array ) {
					$.post(url,{id:dataId,value:data}).done();
					//console.log(data);
				}
			}

		}
	});
}); 


$('input[name="sell[0]"]').spinner();
$('input[name="sell[0]"]').focus(function(){
	var max=12;
	var url='ajax.php?updateTraderData=sell&token='+ PHT_TOKEN;
	var dataId = $(this).attr('data-id');
		
		$(this).spinner({min:0,max:max,stop:function(event,ui){
			
			var sell0 = this.value;
			var sell1 = $('#sell1-' + dataId ).val();
			
			if ( !isNaN(sell0) && sell1 !=='') {
				var data = [sell0,sell1,1];
				
				if ( data instanceof Array ) {
					$.post(url,{id:dataId,value:data}).done();
					//console.log(data);
				}
			}

		}
	});
});
	 
	
$('input[name="qty"]').spinner();
	$('input[name="qty"]').focus(function(){
		var max=999;
		var url='ajax.php?updateTraderData=qty&token='+ PHT_TOKEN;
		var dataId = $(this).attr('data-id');
			$(this).spinner({min:0,max:max,stop:function(event,ui){
				var data = this.value;
				if ( data > max ){
				data=max;
				}
				if ( !isNaN(data) ){
					$.post(url,{id:dataId,value:data}).done();
					console.log(data);
				}
			}
		});
});
	
	
var addItem = $('#addItem').dialog({show:'fade',hide:'fade',autoOpen:false,height:'auto',draggable:true,width:600,modal:false,resizable:false,dialogClass:'',closeOnEscape:true,position:['center',50]});
$('#openAddItem').click(function(e){
		e.preventDefault();
		searchCurrency();
		addItem.dialog('open');
		$('#qty').spinner({min:0,max:999});
		$('#buy').spinner({min:0,max:12});
		$('#sell').spinner({min:0,max:12});
		
		
		$('#submitAddItem').click(function(e){
			e.preventDefault();
			$.fn.serializeObject=function(){var o={};var a=this.serializeArray();$.each(a,function(){if(o[this.name] !== undefined){if(!o[this.name].push){o[this.name]=[o[this.name]];}o[this.name].push(this.value||'');}else{o[this.name]=this.value||'';}});return o;};

			var val=$('#addItemForm').validationEngine('validate');
			var url='ajax.php?insertTraderData=true&token='+ PHT_TOKEN;
			var data=$('#addItemForm').serializeObject();
			
			if ( val == true ) { 
			 var data=JSON.stringify(data);
				$.post( url, {value:data}).done(function(data) {
				$('#content').prepend('<div id="re" style="z-index:9999;font-size:13px;position:fixed;width:300px;right:80px;">'+ data +'</div>');
					setTimeout(function(){$('#re').hide('puff',function(){ $(this).remove();});},5000);		
				});	
			}
		});
		
});	


});