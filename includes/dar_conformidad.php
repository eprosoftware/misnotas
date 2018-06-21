<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/session.php';
include_once '../class/config.php';
include_once 'header.php';

    $Aux = new DBProyecto();
    $dbuser = new DBUsuario();

    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    $user = $dbuser->ElUsuario($id_user);
    $tipo = $user->getTipoUsuario();    

    $id_pedido = $_GET['id_ped'];
    $comentario = $Aux->ElDato($id_pedido,"PedidoProyecto","id","comentario");
    
    ?>
<script>
function poner_conforme(){
    com = document.f.comentario.value;
    fecha = document.f.fecha_recepcion.value;
    requestPage('/includes/ponerConformidad.php?id_user=<?=$id_user?>&id_ped=<?=$id_pedido?>&fecha_recepcion='+fecha+'&comentario='+com,'listo');
    setTimeout(function(){ window.close();},100);
}
</script>
<form action="" method="POST" name="f">
<table>
    <tr>
        <td>Comentario:</td>
        <td><textarea cols="40" rows="3" name="comentario"><?=$comentario?></textarea></td>
    </tr>
    <tr>
        <td>Fecha Recepci&oacute;n</td>
        <td><input name="fecha_recepcion" id="fecha_recepcion" size="12" type="text" value="<?=$fecha_recepcion?>" onkeypress="return dontKey(Event);">
                        <script language="JavaScript">
                                var A_CALTPL = {
                                        'months' : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                        'weekdays' : ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                                        'yearscroll': true,
                                        'weekstart': 1,
                                        'centyear'  : 70,
                                        'imgpath' : 'img/'
                                }
                                new tcal ({
                                        'controlname': 'fecha_recepcion'
                                },A_CALTPL );

                        </script></td>
    </tr>
    <tr>
        <td colspan="2"><input type="button" value="Dar Conformidad" onclick="poner_conforme()"></td>
    </tr>
    <tr>
        <td colspan="2"><div id="listo"></div></td>
    </tr>
</table>
</form>