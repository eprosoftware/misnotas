<?php	
    include_once 'cfgdir.php';
    include "class/config.php";
    include "includes/header.php";
    include "class/recaptchalib.php";
    
    $titulo_pag="Mis Calificaciones";

// your secret key
$secret = "6LdJCAsUAAAAAHk9LSCnXzKBo6AzQXolP3ka13ap";

 
// empty response
$response = null;
 
// check secret key
$reCaptcha = new ReCaptcha($secret);    
// if submitted check response
if ($_POST["g-recaptcha-response"]) {
    $response = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
}
?>
<head>
    <style>
        div {
    display: flex;
    justify-content: center;
    align-content: center;
    flex-direction: column;
}

    </style>
    <link href='/images/favicon.ico' rel='shortcut icon' type='image/x-icon'>
    <script src='https://www.google.com/recaptcha/api.js?hl=es'></script>
</head>
<script>
  var xmlhttp = false;
  //Check if we are using IE.
  try {
    //If the Javascript version is greater than 5.
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    //alert ("You are using Microsoft Internet Explorer.");
  } catch (e) {
    //If not, then use the older active x object.
    try {
      //If we are using Internet Explorer.
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      //alert ("You are using Microsoft Internet Explorer");
    } catch (E) {
      //Else we must be using a non-IE browser.
      xmlhttp = false;
    }
  }
  //If we are using a non-IE browser, create a javascript instance of the object.
  if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
    xmlhttp = new XMLHttpRequest();
    //alert ("You are not using Microsoft Internet Explorer");
  }
  function makerequest(serverPage, objID) {
    var obj = document.getElementById(objID);
    xmlhttp.open("GET", serverPage);
    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        obj.innerHTML = xmlhttp.responseText;
      }
    }
    xmlhttp.send(null);
  }
function verificaUsuario(usuario){
	//alert('/includes/verificaUsuario.php?usuario='+usuario);
	makerequest("/includes/verificaUsuario.php?usuario="+usuario,"es_usuario");
}
</script>
<body leftmargin="0" topmargin="0" onload="document.forms[0].usuario.focus()">
    <br>
<div class="container">
    <center>
    <div class="row">
        <div class="col-md-4">
            <img src="/images/logo_eprosoft.png">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading"><h3>Acceso <br>Mis Notas</h3></div>
            <div class="panel-body">
        <?php if (isset($_SERVER['HTTP_USER_AGENT'])){// && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') == false)){?>
        <table cellpadding="1" cellspacing="1" style="border-radius:10px 10px 10px 10px">
            <tr>
                <td><form action="valida.php" name="formulario" method="POST">
                        <table cellpadding="1" cellspacing="1" bgcolor="#FFFFFF">
                        <tr>
                            <td align="center"><input type="text" class="login_text_box" name=usuario onblur="verificaUsuario(this.value);" placeholder="Usuario"></td>
                        </tr>
                        <tr>
                            <td><div id="es_usuario"></div></td>
                        </tr>
                        <?php if($_SERVER['HTTP_HOST']=="misnotas.eprosoft.cl"){?>
                        <tr>
                            <TD align="center"><div class="g-recaptcha" data-sitekey="6Lc4uzQUAAAAAB1S1FJRUwyeS4X-PCFurMpEpTsX"></div></TD>
                        </tr>
                        <?php }?>
                        <?php if($_SERVER['HTTP_HOST']=="misnotas.xepro.net"){?>
                        <tr>
                            <TD align="center"><div class="g-recaptcha" data-sitekey="6LdJCAsUAAAAAA7XZv8sCX53927AJRQ0hqofw02f"></div></TD>
                        </tr>    
                        <?php }?>                        
                        
                        <tr>
                            <td align="center"><br>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Iniciar Sesi&oacute;n</button>
                            </td>
                        </tr>
                        <tr>
                            <td  align="right" >
                            <?php
                                $browser=$_SERVER['HTTP_USER_AGENT'];
                                echo "<!--$browser ".strpos($browser,"Opera")."-->";
                                if(strstr($browser,"Firefox")) {?><img src="<?=$base_site?>/images/firefox.gif" border="0"><?php }
                                else if(strstr($browser,"Chrome")) {?><img src="<?=$base_site?>/images/chrome.gif" border="0"><?php }
                                else if(strstr($browser,"Safari")) {?><img src="<?=$base_site?>/images/safari.gif" border="0"><?php }
                                else if(strstr($browser,"Opera")) {?><img src="<?=$base_site?>/images/opera.gif" border="0"><?php }
                            ?>
                            </td>
                        </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>
        <?php } else {?>
        <center>
        <img src="<?php $ups=rand(0,1);if($ups==1){?><?=$base_site?>/images/fox-ms.gif<?php } else{?><?=$base_site?>/images/fox-atacando-ie.gif<?php }?>" border=0>
        <h2>ALERTA: Para acceder a este sistema,<br>Favor Utilize Firefox,Chrome o Safari como su navegador de p&aacute;ginas web. 
            <br><a href="http://www.mozilla.org/es-ES/firefox/new/">Descargar Firefox&nbsp;<img src="/images/firefox.gif" border="0"/></a>
            <br><a href=http://www.google.com/chrome?hl=es-419&brand=CHJL&utm_campaign=es-419&utm_source=es-419-cl-ha-BKWS&utm_medium=ha">Descargar Google Chrome&nbsp;<img src="/images/chrome.gif" border="0"/></a>
            <br><img src="/images/navegadores.jpg" border="0">
            <br>Gracias</h2>        
        </center>
         <?php }?>                
            </div>
        </div>
        </div>
    </div>
    </center>
</div>

</body>
</html>
