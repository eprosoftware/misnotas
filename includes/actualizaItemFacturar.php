<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../class/config.php';

    $Aux = new DBProyecto();
    
    $id_item_fact    = $_GET['id'];
    $nro_factura     = $_GET['nro_factura'];
    $fecha_facturado = $_GET['fecha_facturado'];
    
    echo $Aux->updateItemFacturar($id_item_fact,$nro_factura,$fecha_facturado);