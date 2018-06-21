<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/config.php';

    $Aux = new DBProyecto();
    
    $id_pedido = $_GET['id_ped'];
    $fecha_recepcion = $_GET['fecha_recepcion'];
    $comentario = $_GET['comentario'];
    $id_user = $_GET['id_user'];
    echo "<p>".$Aux->DarConformidad($id_user,$id_pedido,$fecha_recepcion,$comentario)."</p>";