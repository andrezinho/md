<?php
session_start();

include 'lib/EpiCurl.php';
include 'lib/EpiOAuth.php';
include 'lib/EpiTwitter.php';

$consumer_key = 'ZhdPEqOZlE2ud1giNNrd0qRSK';
$consumer_secret = 'f3Tb7Va6Xd6lRruxVyUPQjL3XvQwb7oBRJ0NP9iZhB8K5bkti2';

$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

$error = null;

$login = '<a href="' . $twitterObj->getAuthorizationUrl() . '"><img src="img/sign.png"/></a>';

if (isset($_GET['oauth_token']) || ( isset($_SESSION['oauth_token']) && isset($_SESSION['oauth_token_secret']) )){
    //Acceso
    if (!isset($_SESSION['oauth_token']) || !isset($_SESSION['oauth_token_secret'])){
        //Viene de twitter
        $twitterObj->setToken($_GET['oauth_token']);
        $token = $twitterObj->getAccessToken();
        $_SESSION['oauth_token'] = $token->oauth_token;
        $_SESSION['oauth_token_secret'] = $token->oauth_token_secret;

        $twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
    } else {
        //Ya nos dio acceso
        $twitterObj->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
    }
    $user = $twitterObj->get_accountVerify_credentials();
    $datos = "Bienvenido $user->name! Tienes $user->followers_count seguidores y te encuentras en $user->location";
    
} elseif (isset($_GET['denied'])){
    $error = 'Debes permitir acceso a tu cuenta de twitter';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="css/style.css" />
        <title>JV Software | Tutorial 7</title>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <h1>Login con Twitter</h1>
            </div>
            <div id="navegacion">
                <?php if (isset($_GET['oauth_token'])
                        || ( isset($_SESSION['oauth_token'])
                                && isset($_SESSION['oauth_token_secret']) )){

                                    echo $datos;
                                }
                                else {
                                    echo $login;
                                }

                        echo $error;
                ?>
            </div>
            <div id="contenido">
                <h2>Pagina de incio</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur posuere fringilla
                    mauris. Cras ultricies elementum nulla, eu pellentesque ante lobortis vel. Nullam erat
                    purus, tristique nec interdum ut, sodales vitae nulla. Praesent fermentum, lacus hendrerit
                    hendrerit fermentum, purus enim hendrerit risus, vitae lobortis lectus erat eu mi.
                    Praesent sit amet magna lacus. Curabitur sapien turpis, scelerisque vitae dictum vel,
                    consectetur non quam. Integer eros lorem, vulputate in facilisis vel, porttitor et
                    sapien. Cras commodo placerat est, vitae iaculis risus tempus sed. Integer imperdiet
                    aliquam faucibus. Suspendisse vitae vehicula sapien. Sed mollis dapibus sodales. Donec
                    auctor semper magna non tristique.
                </p>
            </div>
        </div>
    </body>
</html>
