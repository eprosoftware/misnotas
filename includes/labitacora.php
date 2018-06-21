<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/session.php';
include_once '../class/config.php';
include_once 'header.php';

    $nro_bitacora = $_GET['nro_bitacora'];
    $Aux = new DBProyecto();
    
    $labitacora = $Aux->getBitacora($nro_proyecto);
    ?>
<table>
    <tr>
        <td>ID</td>
        <td>Fecha</td>
        <td>Anotaci&oacute;n</td>
    </tr>
    <?php
    for($i=0;$i<count($labitacora);$i++){
        $tmp = $labitacora[$i];
        $fecha = $tmp->getFecha();
        $anotacion = $tmp->getAnotacion();
        $color = $Aux->flipcolor($color);
        ?>
    <tr bgcolor="<?=$color?>">
        <td><?=number_format($i+1,0,",",".")?></td>
        <td><?=$fecha?></td>
        <td><?=$anotacion?></td>
    </tr>
    <?php
    }
    ?>
</table>
    