var amigable 	= (function() {
	var tildes = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç", 
		conver = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
      	cuerpo 	= {};
 
 	for (var i=0, j=tildes.length; i<j; i++ ) { 
		cuerpo[tildes.charAt(i)] = conver.charAt(i);
	}
 
	return function(str) {
		var salida = [];
		for( var i = 0, j = str.length; i < j; i++) {
			var c = str.charAt( i );
			if(cuerpo.hasOwnProperty(str.charAt(i))) {
				salida.push(cuerpo[c]);
			} else {
				salida.push(c);
			}
		}
		return salida.join('').replace(/[^-A-Za-z0-9]+/g, '-').toLowerCase();
	}
})();