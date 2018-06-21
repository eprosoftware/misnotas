<?php
    include_once '../class/config.php';
    
    $Aux =new DBUsuario();

    $grupo = $_POST['grupo'];
    $comando = $_GET['comando'];
    $a_menu = $_POST['a_menu'];
    $submenu = $_POST['submenu'];
    
    $Aux->conecta();
    $losgrupos = $Aux->TraerLosDatos("TipoUsuario","id","descripcion"," order by descripcion");

    switch($comando){
    case 2:	
            $menustr    = ($a_menu)?implode(",",$a_menu):"";
            $submenustr = ($submenu)?implode(",",$submenu):"";

            $Aux->uptPerfilMenu($grupo,$menustr,$submenustr);
    }
    $tmp = $Aux->getMenuNivel($grupo);

    $menu       = $tmp['menu'];
    $submenu    = $tmp['submenu'];
    //$menu = explode(",",$Aux->ElDato($grupo,"NivelUsuario","id","menu"));
    ///$submenu = explode(",",$Aux->ElDato($grupo,"NivelUsuario","id","submenu"));
  
?>
<form name="formulario" action="" method="POST">
<table width="90%" align="center">
<TR><TD class="hnavbg"><h2>Perfil Men&uacute</h2></TD></TR>
<tr><TD>
	<table width="100%" align="center">
		<TR><TD><b>Nivel</b>:<?=$Aux->SelectArray($losgrupos,"grupo","----",$grupo,"","MiSubmit('/index.php?p=losperfiles')");?></td>
                    <TD colspan="2" align="right"><input type="button" name=aa value="Actualizar" onclick="MiSubmit('/index.php?p=losperfiles&comando=2')"></td></TR>
		<tr><TD colspan="2"><?php include("usuario_menu.php");?></TD></tr>
	</table>
</TD></tr>
</table>
</form>