<<<<<<< HEAD
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
alert(menu);
   $("#categorias").append(menu);
},'json');	


});
=======
$(document).ready(function(){	
	/*$("#icon_facebook").click(function(){
			name_f=$("#nombre_f").val();
			ape_f=$("#apellido_f").val();
			id_f=$("#id_f").val();
			mail_f=$("#email_f").val(); alert(name_f);

			$.get("modelo/adduser_face.php",'name='+name_f+'&lastname='+ape_f+'&email='+mail_f+'&id='+id_f,function(data){
			 alert(data); });
		});
*/
});
>>>>>>> 71a0256e2c58410598ff6b0fd762e8ef33e9eacc
