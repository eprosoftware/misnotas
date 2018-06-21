<?php
    include_once "cfgdir.php";
    //include_once getcwd()."/class/session.php";
    include_once getcwd()."/class/config.php";
    include_once getcwd()."/includes/header.php";

    $titulo_pag="Mis Notas.:EproSoftware EIRL:.";


    $dbuser = new DBUsuario();

    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    $eluser 	= $dbuser->ElUsuario($id_user);
    $menu_usr 	= $eluser->getMenu();//asort($menu_usr);
    $submenu_usr    = $eluser->getSubMenu();//asort($submenu_usr);
    $nombre_usuario = $eluser->getNombre();

    $ip = $_SERVER["REMOTE_ADDR"];
    $p  = $_GET['p'];
    $w  = $_GET['w'];
    $t  = $_GET['t'];
?>
<script language="Javascript" src="<?=$base_site?>/js/libreria.js"></script>
<script language="javascript" src="<?=$base_site?>/js/functions.js" type="text/javascript" ></script>
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
</script>
<body leftmargin="0" topmargin="0" >
    <div class="container-fluid">
        <table class="table table-bordered table-condensed">
            <tr>
                <td>
<a href="/index.php"><img src="<?=logoHoy()?>" border="0" height="80"></a>
                </td>
            </tr>
            <tr>
                <td><?php include("barramenu.php");?></td>
            </tr>
            <tr>
                <td>
                    <div id="main_section">
        <?php	
            if ($p)         include(getcwd()."/includes/$p.php");
            else if ($t)    include(getcwd()."/includes/$t.php");
            else if ($w)    include(getcwd()."/includes/$w.php");
            else            include("main.php");
        ?>
                    </div>
                </td>
            </tr>
         <tr valign="center">
            <td height="52" colspan="2" background="/images/index_footer_bg_1.gif" align="right">
                <a href="http://www.eprosoft.cl" class="tituloblanco" target="_blank"><img src="/images/logo_eprosoft.png" height="20" border="0">
                &nbsp;<font size=1><b>(c) 2014 <?=(date("Y"))>2014?",".date("Y"):"";?></b></font></a>
            </td>
        </tr>
        <?php 
        if ($print==1) {?><script>window.print();</script><?php }?>
        </table>
    </div>

    <!-- SmartMenus jQuery plugin -->
    <script type="text/javascript" src="/dist/jquery.smartmenus.js"></script>

    <!-- SmartMenus jQuery init -->
    <script type="text/javascript">
    	$(function() {
    		$('#main-menu').smartmenus({
    			subMenusSubOffsetX: 1,
    			subMenusSubOffsetY: -8
    		});
    	});
    </script>    
</body>
</html>