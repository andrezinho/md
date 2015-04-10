var host=window.location.host;
host=host+"/md";
//host=host;
$(function(){
var idp=$("#idp").val();
$.get('http://'+host+'/model/timer.php','idp='+idp,function(datos){
		//$("").show().html(datos);
		var fecha=datos[0].fecha_fin;
		var hora=datos[0].hora_fin;

		t = fecha.split('-');
		a = t[0];
		m = t[1];
		d = t[2]; 

		t1=hora.split(':');
		h = t1[0];
		mi = t1[1];
		s = t1[2];

		setInterval("finaliza(a,m,d,h,mi,s);",1000);


	},'json');


//finaliza(2015,0,17,12,0,0);
});
function finaliza(a,m,d,h,mi,s){
		
	  var note = $('#note');
		fech=new Date(a,m,d,h,mi,s);
		ts = fech;
		newYear = true;
	
	if((new Date()) > ts){
		// The new year is here! Count towards something else.
		// Notice the *1000 at the end - time must be in milliseconds
		//ts = (new Date()).getTime() + 10*24*60*60*1000;
		ts= (fech);
		newYear = false;
	}
		
	$('#countdown').countdown({
		timestamp	: ts,
		callback	: function(days, hours, minutes, seconds){
			
			var message = "";
			
			message += days    + "d" + ( days==1 ? '':'') + ":";
			message += hours   + "h" + ( hours==1 ? '':'') + ":";
			message += minutes + "m" + ( minutes==1 ? '':'') + ":";
			message += seconds + "s" + ( seconds==1 ? '':'') + "";
			
			if(newYear){
				message += "";
			}
			else {

				message += "<br>Oferta Finalizada";
				$("#comprar").css({background:"#ccc"});
				$("#comprar").css({"pointer-events":"none"});
                                $(".product-details").css({background:"#ccc"});
                                $(".product-details").css({"pointer-events":"none"});
			}
			//alert(message);
			note.html(message);
		}
	});
	}

