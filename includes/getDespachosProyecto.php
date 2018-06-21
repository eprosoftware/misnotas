<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/config.php';

    $Aux = new DBProyecto();
    
    $nro = $_GET['nro'];
    $item = $_GET['iditem'];

    $eldetalle = $Aux->getDespachos("",$nro,$item);
    
    ?>
<table width="100%">
    <tr class="hnavbg"><td class="tituloblanco12">Despachos</td></tr>
        
    <tr><td class="celda_bordes">
    <table width="100%">
    <tr class="hnavbg">
        <td class="tituloblanco12">Fecha Des</td>
        <td class="tituloblanco12">Dias Tr</td>
        <td class="tituloblanco12">Nro. Proyecto</td>
        <td class="tituloblanco12">Item</td>
        <td class="tituloblanco12">C&oacute;digo</td>
        <td class="tituloblanco12">Fecha Aprobaci&oacute;n</td>
        <td class="tituloblanco12">Estado</td>
        <td class="tituloblanco12">Despachado Por</td>
    </tr>
    <?php
    $total = 0;$total_anticipo =0;$total_entregado=0;$total_aprobado=0;
    for($i=0;$i<count($eldetalle);$i++){
        $tmp = $eldetalle[$i];
        //$id_ped = $tmp->getId();
        $fecha_despacho = $tmp['fecha_despacho'];
        $fecha_aprobacion = $tmp['fecha_aprobacion'];
        $dias_trans = $tmp['dias_trans'];
        $nro_proy = $tmp['nro_proyecto'];
        $codigo = $tmp['codigo_despacho'];
        $item = $tmp['id_itemproyecto'];
        $quien_despacha = $tmp['quien_despacha'];
        $despachadopor = $Aux->ElDato($quien_despacha,"Usuarios","id","nombre");
        $estado_despacho = $tmp['estado_despacho'];
        $elestado = $Aux->ElDato($estado_despacho,"EstadoDespacho","id","descripcion");
        $total+=$valor_total;
        $color=$Aux->flipcolor($color);

        if($dias>30){
            $fi="<font color='blue'><b>";
            $ff="</b></font>";            
        } else if($dias>21){
            $fi="<font color='darkred'><b>";
            $ff="</b></font>";            
        } else if($dias>15) {
            $fi="<font color='green'><b>";
            $ff="</b></font>";
        } else {
            $fi="";
            $ff="";            
        }        
        ?>
    <tr <?=$Aux->rowEffect($i, $color)?> >
        <td bgcolor="<?=$color?>"><?=$fecha_despacho?></td>
        <td bgcolor="<?=$color?>"><?=$dias_trans?></td>
        <td bgcolor="<?=$color?>"><?=$nro_proy?></td>
        <td bgcolor="<?=$color?>"><?=$item?></td>
        <td bgcolor="<?=$color?>"><?=$codigo?></td>
        <td bgcolor="<?=$color?>"><?=$fecha_aprobacion?></td>
        <td bgcolor="<?=$color?>"><?=$elestado?></td>
        <td bgcolor="<?=$color?>"><?=$despachadopor?></td>
    </tr>
    <?php
    }
    ?>
    </table></td></tr>
</table>