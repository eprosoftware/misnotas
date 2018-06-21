<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once str_replace("/includes","",getcwd()).'/class/config.php';

    $Aux = new DBProyecto();
    
    $id = $_GET['id'];
    $nombre_proyecto = $_GET['nombre_proyecto'];
    $proyectista = $_GET['proyectista'];
    $estado = $_GET['estado'];
    $valor_cobrado = $_GET['valor_cob'];
    
    echo $Aux->updateProyecto($id,$nombre_proyecto,$proyectista,$estado,$valor_cobrado);