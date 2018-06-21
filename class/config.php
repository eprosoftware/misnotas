<?php
// Datos de la Base de Datos
define("HOST","localhost");
define("DB_USER","root");
define("DB_PASS","123.,321");

define("DB","misnotasdb");

define("_COPYRIGHT","Developed by Epro Software (c) 2014");
define("_TITULO_APP",".:[Epro Software System ]  ");
define("_LOGO","images/logo_emoneyTrans.gif");

// Ruta fisica
define("DIR",str_replace("/includes","",getcwd()));
define("HOMEDIR",str_replace("/includes","",getcwd()));
//echo "<h1>D:".str_replace("/includes","",getcwd())."</h1>";
// Ruta web 
$HTTP_HOST = "misnotas.xepro.net";//eprosoft.cl";
if($HTTP_HOST)
    define("DIRWEB","http://".$HTTP_HOST."/");
else
    define("DIRWEB","http://misnotas.xepro.net");//eprosoft.cl/");
// Aqui comienzan los includes de las clases
include(DIR."/class/Indicadores.class.php");
include(DIR."/class/Conexion.class.php");
include(DIR."/class/DBNucleo.class.php");
include(DIR."/class/DBVarios.class.php");

include(DIR."/class/Menu.class.php");
include(DIR."/class/SubMenu.class.php");
include(DIR."/class/DBMenu.class.php");
include(DIR."/class/DBSubMenu.class.php");


include(DIR."/class/Nota.class.php");
include(DIR."/class/DBNotas.class.php");

include(DIR."/class/Usuario.class.php");
include(DIR."/class/DBUsuario.class.php");

include(DIR."/class/htmlMimeMail5.php");
include(DIR."/class/html2pdf.class.php");	
//Simula Register ON
//	registerGlobals();
?>
