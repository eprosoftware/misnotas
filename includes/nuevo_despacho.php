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
    $nro_proyecto = $_GET['nro_proyecto'];
    $id = $_GET['id'];
    
    if(!isset($id)) $estado=1;
    if($id){
        $a = $Aux->getDespachos($id);$d=$a[0];
        $item = $d['id_itemproyecto'];
        $codigo_despacho = $d['codigo_despacho'];
        $estado = $d['estado_despacho'];
    } else {
        $item = $_GET['id_item'];
    }    
    $fecha = date("Y-m-d H:i:s");
    
    $elitem = $Aux->ElDato($item,"Codigos","cod","descripcion");
    $loscoddespacho = $Aux->TraerLosDatos("CodigosDespacho","cod","descripcion");
    $losestados = $Aux->TraerLosDatos("EstadoDespacho","id","descripcion");
    

?>
<script>
function procesar(){
    
}
</script>
<table align="center" width="80%"><tr><td class="celda_bordes">
            <form action="procesar_despacho.php" method="POST">
                <input type="hidden" name="id" value="<?=$id?>"> 
                <input type="hidden" name="fecha" value="<?=$fecha?>">
                <input type="hidden" name="nro_proyecto" value="<?=$nro_proyecto?>">
                <input type="hidden" name="item" value="<?=$item?>">
<table width="100%">
    <tr class="hnavbg">
        <td class="tituloblanco12" colspan="2"><h2><b>DESPACHO ITEM</b></h2></td>
    </tr>
    <tr>
        <td>Nro. Proyecto</td>
        <td><?=$nro_proyecto?></td>
    </tr>
    <tr>
        <td>Fecha Sistema</td>
        <td><?=$fecha?></td>
    </tr>
    <tr>
        <td>Item Proyecto</td>
        <td><?=$elitem?></td>
    </tr>
    <tr>
        <td>C&oacute;digoDespacho</td>
        <td><?=$Aux->SelectArrayBig($loscoddespacho,"codigo_despacho","Seleccione Codigo Despacho",$codigo_despacho)?></td>
    </tr>
    <tr>
        <td>Estado Despacho</td>
        <td><?=$Aux->SelectArrayBig($losestados,"estado","Seleccione estado",$estado)?></td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="submit" class="textobig" value="<?=($id)?"Modificar":"Ingresar Despacho"?>">
        </td>
    </tr>
</table></form>
        </td></tr></table>            