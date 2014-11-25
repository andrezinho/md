<!DOCTYPE html>
<html class="noIE" lang="en-US">
<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
<meta content="Flatroshop online shopping point" name="description">
<meta content="logoby.us" name="author">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<title>Muchos Descuentos</title>
<link href="css/normalize.css" rel="stylesheet" type="text/css"/>
<link href="css/bootstrap.css" rel="stylesheet">

<link href="css/custom.css" rel="stylesheet" type="text/css" />
<link href="css/skin/color.css" id="colorstyle" rel="stylesheet">
<script src="js/retina-1.1.0.min.js" type="text/javascript"></script>

<link type="text/css" href="css/jquery-ui.min.css" rel="stylesheet" />
<link type="text/css" href="css/jquery-ui.structure.min.css" rel="stylesheet" />
<link type="text/css" href="css/jquery-ui.theme.min.css" rel="stylesheet" />

<link href="css/layout.css" rel="stylesheet" type="text/css" />
<link href="css/cssmenu.css" rel="stylesheet" type="text/css" />
<link href="css/style_forms.css" rel="stylesheet" type="text/css" />
<link href="css/ui.jqgrid.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>    
<script type="text/javascript" src="js/menus.js"></script>
<script type="text/javascript" src="js/session.js"></script>
<script type="text/javascript" src="js/required.js"></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<script type="text/javascript" src="js/utiles.js"></script>
<script type="text/javascript" src="js/js-layout.js"></script>
<script type="text/javascript" src="js/pag.js"></script>
<script type="text/javascript" src="js/jquery.jqGrid.min.js"></script> 
<!-- <script type="text/javascript" src="js/jquery.jqGrid.src.js"></script> -->
<script type="text/javascript" src="js/grid.locale-es.js"></script>

</head>
<body>
<header> 
  <div class="c-top" style="background: #EEEEEE; padding: 5px 0 0 0; margin-top: -8px; box-shadow: 3px 2px 5px #ccc;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="topheadrow">
          <a href="index.html"><img src="images/logo-icon.png" class="logo-icon" style="width:43px;height:43px; margin-top: 2px;" /></a>

          <ul class="nav nav-pills pull-right">          
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" data-hoView="dropdown" href="#a"><?php echo strtoupper($_SESSION['perfil']); ?> <i class="fa fa-angle-down fa-fw"></i> </a>            </li>            
            <li class="dropdown"> <a class="dropdown-toggle" data-hoView="dropdown" data-toggle="dropdown" href="#a"> <i class="fa fa-user fa-fw"></i> <span class="hidden-xs"> <?php echo strtoupper($_SESSION['name']); ?></span></a>
              <div class="loginbox dropdown-menu"> 
                Conectarse con:<br>
                  <div class="social-icons">
                    <ul>
                      <li class="icon google-plus"><a href="#a"><i class="fa fa-google-plus fa-fw"></i></a></li>
                      <li class="icon twitter"><a href="#a"><i class="fa fa-twitter fa-fw"></i></a></li>
                      <li class="icon facebook"><a href="#a"><i class="fa fa-facebook fa-fw"></i></a></li>
                    </ul>
                  </div>               
               <br><br>
               <div><hr> Login:</div>
                
                <form>
                  <div class="form-group"> <i class="fa fa-user fa-fw"></i>
                    <input class="form-control" id="InputUserName" placeholder="Username" type="text" data-validation="required">
                  </div>
                  <div class="form-group"> <i class="fa fa-lock fa-fw"></i>
                    <input class="form-control" id="InputPassword" placeholder="Password" type="password" data-validation="required">
                  </div>
                  <button class="btn medium color1 pull-right" type="submit">Entrar</button>
                </form>
                <a href="#">¿Olvidaste tu contrase&nacute;a?</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
 </div> 
</header>
<div class="row clearfix f-space20"></div>
<div class="container" >
    <div class="row clearfix" style="width: 1140px;margin-left: 0px;">
      <div>         
        <div class="menu-links hidden-xs head_nav">         
         </div>
        <div class="clearfix"></div>
      </div>
    </div>
</div>
<div class="container" >    
    <?php echo $content; ?>
</div>
<footer class="footer"></footer>
</body>
</html>