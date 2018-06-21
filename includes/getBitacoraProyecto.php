<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once str_replace("/includes","",getcwd()).'/cfgdir.php';
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd()).'/includes/header.php';

    $Aux = new DBProyecto();
    $dbuser = new DBUsuario();

    $id_user= $dbuser->getUsuarioId($usuario,$clave);
    $user   = $dbuser->ElUsuario($id_user);
    $tipo   = $user->getTipoUsuario();
    $eltipo = $Aux->ElDato($tipo,"TipoUsuario","id","descripcion");

    $nro = (isset($nro))?$nro:$_GET['nro'];
    
    $eldetalle = $Aux->getBitacora($nro);
    //echo "<p>NRO.PROY:$nro</p>";
?>
<table class="table table-bordered table-striped">
<tr>
    <td>Fecha</td>
    <td>Autor</td>
    <td width="75%">Anotaci&oacute;n</td>
    <td colspan="2"></td>
</tr>
<?php
for($i=0;$i<count($eldetalle);$i++){
    $tmp = $eldetalle[$i];
    $id_bit = $tmp->getId();
    $fecha = $tmp->getFecha();
    $id_usuario = $tmp->getIdUsuario();
    $elautor = $Aux->ElDato($id_usuario,"Usuarios","id","alias");
    $anotacion_bitacora = utf8_decode($tmp->getAnotacion());
    $archivo = $tmp->getArchivo();

    $color=$Aux->flipcolor($color);
    ?>
<tr valign="top">
    <td><?=$fecha?></td>
    <td><?=$elautor?></td>
    <td><?=$anotacion_bitacora?></td>
    <td><?php if($archivo){?><a href="<?=$base_dir?>/lib_archivos/<?=$archivo?>" target="_blank"><img src="<?=$base_dir?>/images/adjunto.gif" bordeR="0"></a><?php }?></td>
    <td><button type="button" onclick="eliminarBit(<?=$id_bit?>)" class="btn btn-danger">Eliminar</button></td>
    <td><div id="elim<?=$id_bit?>"></div></td>
</tr>
<?php
}
?>
<tr valign="top">
    <td colspan="13">&nbsp;</td>
</tr>
</table>
