$(document).ready(function() {           
     str = 'controller=config&action=get';
     $("#title-banner").css("display","none");
     $("#title-banner").show("slide",750);            
     maxwindow();
     $(window).resize(function(){maxwindow();});
     $.get('index.php','controller=Index&action=Menu',function(menu){          
          $("#menu").empty();                    
          var opciones_menu = menu;
          w = $(document).width();                
          $(".head_nav").generaMenu(opciones_menu);                
      },'json');
     $("#box-frm-m").dialog({
      modal:true,
      autoOpen:false,
      width:'auto',
      height:'auto',
      resizing:true
     });
     $("#change_passw").click(function(){      
      $("#box-frm-m").dialog({buttons: {
                  'Cerrar': function(){ $(this).dialog('close');},
                  'Cambiar Password':function(){save_change();}
                },
                title:'Cambio de Password'});
      $.get('index.php','controller=user&action=change_passw',function(data){        
        $("#box-frm-m").empty().append(data);
        $("#box-frm-m").dialog("open");
      });
      

     });
           var $floatingbox = $('#site_head'); 
           if($('#body').length > 0)
           {
            var bodyY = parseInt($('#body').offset().top);
            var originalX = $floatingbox.css('margin-left');
            $(window).scroll(function ()
            {                        
             var scrollY = $(window).scrollTop();
             var isfixed = $floatingbox.css('position') == 'fixed';

             if($floatingbox.length > 0){
                if ( scrollY > bodyY && !isfixed ) {                                
                          $floatingbox.stop().css({
                            position: 'fixed',                                  
                            marginLeft: 0,
                            top:0
                          });
                  } else if ( scrollY < bodyY && isfixed ) {
                            $floatingbox.css({
                            position: 'absolute',
                            top:0,
                            marginLeft: originalX
                  });
               }		
             }
         });
       }             
       
  });
//document.oncontextmenu = function(){ return false; }
function maxwindow()
{
  var h = $(window).height();    
  $(".div_container").css('minHeight',(h-135));  
}

function validateMail(idMail)
{
    //Creamos un objeto 
    object=document.getElementById(idMail);
    valueForm=object.value;

    // Patron para el correo
    var patron=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    if(valueForm.search(patron)==0)
    {
        //Mail correcto
        object.style.color="#000";
        return true;
    }
    //Mail incorrecto
    object.style.color="#f00";
    return false;
}
function save_change()
{
   var bval = true;
   bval = bval && $("#passw").required();
   bval = bval && $("#npassw").required();
   bval = bval && $("#rpassw").required();
   if(bval)
   {
      var npassw = $("#npassw").val(),
          rpassw = $("#rpassw").val(),
          passw  = $("#passw").val();
      if(npassw==rpassw)
      {
        $.post('index.php','controller=user&action=change_passw_send&npassw='+npassw+'&rpassw='+rpassw+'&passw='+passw,function(data)
        {
           if(data.res=="1"){alert(data.msg); $("#box-frm-m").dialog("close"); }
            else {$("#pass_d").empty().append(data.msg);$("#pass_d").show("slow");}
        },'json');
      }
   }
}