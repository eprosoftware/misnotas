<?php 
    session_start();
    include_once str_replace("/includes","",getcwd()).'/cfgdir.php';
    include_once str_replace("/includes","",getcwd()).'/class/config.php';

include "class/recaptchalib.php";
        
if($_SERVER['HTTP_HOST']=="misnotas.xepro.net"){
    $privatekey = "6LdJCAsUAAAAAHk9LSCnXzKBo6AzQXolP3ka13ap";
}
if($_SERVER['HTTP_HOST']=="misnotas.eprosoft.cl"){
    $privatekey = "6Lc4uzQUAAAAAPrjp4B5Y6F9CwU8sG3MSRmGtohK";
}

$reCaptcha = new ReCaptcha($privatekey);    

if ($_POST["g-recaptcha-response"]) {
    $response = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
}

//echo "<h1>R:".($response->success)?"OK":"NOT"."</h1>";

	$user = new DBUsuario();
	$usuario = $_POST['usuario'];
        $clave   = $_POST['clave'];
        $clave_old = $_POST['clave_old'];
        $clave_new = $_POST['clave_new'];
        $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
	$_SESSION['is_logged']=false;
	if ($response->success ){
		if ($usuario && $clave){
			$iduser = $user->getUsuarioId($usuario,$clave);
			$_SESSION['USUARIO']=$usuario;
			$_SESSION['CLAVE']=$clave;
                        $_SESSION['IDUSUARIO']=$iduser;
		} else if ($clave_old && $clave_new){
			//echo "<p>Clave Old:$clave_old Clave New:$clave_new</p>";
			$iduser = $user->getUsuarioId($usuario,$clave_old);
			//echo "<p>ID User:$iduser</p>";
			$estado = $user->updateClave($iduser,$clave_old,$clave_new);
			if ($estado){
				$_SESSION['USUARIO']=$usuario;
				$_SESSION['CLAVE']=$clave_new;
				$ok_cambio=true;
				?><script>//document.location="/login.php";</script><?php
			} else {
				$iduser=0;$ok_cambio=false;
				
			}
		}
	}
	if ($iduser>0) $_SESSION['is_logged']=true;

	$eluser = $user->ElUsuario($iduser);
	$nombre = $eluser->getNombre();
	$titulo_pag="Cotizaciones y Proyectos .:EproSoftware EIRL:.";

	include("includes/header.php")
?>
<link rel="stylesheet" href="styles.css" type="text/css">
<script type="text/javascript">
function delayer(){
	   document.location = "/login.php";
}
</script>
<body <?=($iduser==0 )?"onLoad=\"setTimeout('delayer()', 600)\"":""?>>
<table width="100%" cellspacing="0" cellpadding="0">
<tr>
    <td height="80" colspan="2" valign="top">
        <a href="/index.php"><img src="<?=logoHoy()?>" border="0"></a>
    </td>
</tr>
<?php if ($iduser>0 ){?>
<tr>
    <td height="80" colspan="2" valign="top">
        <br><br><br><br><br><br><br><br><br>
        <center><br><br><font face=arial color="#CCCCCC">
        <h2>Inicio de session OK</h2>
        <h2>Usuario conectado <?=$nombre?></h2>
        <h2>Ud. se esta conectando desde : <?=$REMOTE_ADDR?></h2>
        </font>
        <br><input type="button" onclick="document.location='/index.php'" value="Entrar">
        <br><br><br>
        </center>
        <script>document.location="/index.php"</script>
    </td>
</tr>
<?php } else { //La Clave no corresponde
?>
<tr>
    <td height="80" colspan="2"><br><br><br><br><br><br><br><br><br><br>
<table width="100%" align="center" valign="center">
<tr><td colspan="2">
	<table cellpadding=2 cellspacing=0 bgcolor="#e0f0f0" align="center" width=761 >
	<tr><td>
		<table width="100%" cellpadding=1 cellspacing=0 >
		<tr width=761>
		<td width=761><h4><font face="arial,helvetica" color="#9cc2dc"><?=$titulo?></font></h4></td></trR>
		<tr><td align="center">
		<h2><font color="#9999cc">
		La clave no corresponde o <br>bien el c&oacute;digo de seguridad no concuerda.<br>
		Vuelva a intenarlo mas tarde, Gracias.</font></h2>
		<br>
		<p><font size=1 color=navy>Ud. ser&aacute; redireccionado a la entrada en 4 segundos.</font></p>
		</td></tr>
		<tr>
                    <TD align="center">
                        <h2><font color="#9999cc"><?php if($iduser==-1 && !$ok_cambio){?>Esta utilizando su antigua clave como nueva.
		<?php }?></font></h2></TD>
                </tr>
		</table>
	</td></tr>
	</table><br><br>
</td></tr>
<?php	session_destroy  ();}?>
  <tr>
    <td height="52" colspan="2" class="footer" align="right">&nbsp;<a href="http://www.eprosoft.cl" class="titulonegro"><font size=1><b>Epro Software (c) 2006,2017</b></font></a></td>
  </tr>
</table></td></tr></table>
</body>
</html>
