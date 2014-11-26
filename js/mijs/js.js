$(document).ready(function(){

$.get('model/menu.php','&',function(data){ //alert(data);
 var menu = "";
   $.each(data,function(i,j){
	menu += "<li class='dropdown'><a href='#'><span class='hidden-sm'>"+j.texto+"</span><i class='fa fa-angle-down fa-fw'></i></a>";

		$.each(j.enlaces,function(k,p){
			menu += "<div class='dropdown-menu quick-cart'>";
			menu += "<div class='qc-row qc-row-heading'><ul>";
			menu += "<li>"+p.texto+"</li>"
			menu += "</ul></div>";
			menu += "</div>";
		})

		menu += "</li>";
	});
   $("#categorias").append(menu);
},'json');	


});