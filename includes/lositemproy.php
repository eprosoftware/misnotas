<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/session.php';
include_once '../class/config.php';

    $Aux = new DBProyecto();
    $valor = $_GET['valor'];
    
    if(is_numeric($valor)){
        $nro_proyecto=$valor;
        $lositem = $Aux->TraerLosDatos("ItemProyecto","id","descripcion"," where nro_proyecto=$nro_proyecto");
    } else {
        $descripcion = $valor;
        $a = $Aux->get("","","","",$descripcion);$p=$a[0];
        $lositem = $Aux->TraerLosDatos("ItemProyecto","id","descripcion"," where nro_proyecto=".$p->getNroProyecto());
    }

    
    
    echo $Aux->SelectArrayBig($lositem,"id_item_proyecto","Seleccione Item",$id_item_proyecto);