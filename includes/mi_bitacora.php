<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once str_replace("/includes","",getcwd()).'/cfgdir.php';
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd())."/includes/header.php";

    $Aux = new DBBitacoraTrabajo();
    $dbuser = new DBUsuario();

    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    $user = $dbuser->ElUsuario($id_user);
    $tipo = $user->getTipoUsuario();
    $eliminar_bitacora = $user->getEliminarMiBitacora();
    
    $fecha = date("Y-m-d");
    $labitacora = $Aux->get($id_user);
?>

<table align="center">
    <tr>
        <td class="titulonegro12">Bit&aacute;cora Trabajo</td>
    </tr>
    <tr>
        <td class="celda_bordes">
            <table width="100%">
               <tr class="hnavbg">
                    <td class="tituloblanco12">Fecha</td>
                    <td class="tituloblanco12">Nro. Proyecto</td>
                    <td class="tituloblanco12">Nombre Proyecto</td>
                    <td class="tituloblanco12">Item</td>
                    <td class="tituloblanco12">Proyectista</td>
                    <td class="tituloblanco12">Nro. Horas</td>
                    <td class="tituloblanco12">Glosa</td>
                    <td></td>
                </tr>
<?php
    $total_horas=0;
    for($i=0;$i<count($labitacora);$i++){
        $tmp = $labitacora[$i];
        $id_bit = $tmp['id'];
        $fecha = $tmp['fecha'];
        $id_proy = $tmp['proyectista'];
        $id_item = $Aux->ElDato($tmp['id_item'],"ItemProyecto","id","item_contratado");
        $elproyectista = $Aux->ElDato($id_proy,"Usuarios","id","nombre");
        $nro_proy = $tmp['nro_proyecto'];
        $nombre_proyecto = $Aux->ElDato($nro_proy,"Proyecto","nro_proyecto","nombre_proyecto");
        $nro_horas = $tmp['nro_horas'];$total_horas += $nro_horas;
        $glosa = $tmp['glosa'];
        $color = $Aux->flipcolor($color);
        
        ?>
                <tr bgcolor="<?=$color?>">
                    <td><?=$fecha?></td>
                    <td><?=$nro_proy?></td>
                    <td><?=$nombre_proyecto?></td>
                    <td><?=$id_item?></td>
                    <td><?=$elproyectista?></td>
                    <td align="right"><?=$nro_horas?></td>
                    <td><?=$glosa?></td>
                    <td><?php if($eliminar_bitacora==1){?><input type="button" value="Eliminar" name="b<?=$i?>" onclick="if(confirm('Quiere Eliminar la anotacion?'))requestPage('/includes/eliminar_mibitacora.php?id_bit=<?=$id_bit?>','msg_pry<?=$i?>');"  class="botonred"><?php }?> <div id="msg_pry<?=$i?>"></div></td>
                </tr>                
                <?php
    }
?>
                <tr>
                    <td colspan="5">Total Horas</td>
                    <td align="right"><?=$total_horas?></td>
                    <td></td>
                </tr>    
            </table>
            </form>
        </td>
    </tr>
</table>    