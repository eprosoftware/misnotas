<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/config.php';

    $Aux = new DBCotizacion();
    $nro_cotizacion=$_GET['nro_cotizacion'];
    $cot = $Aux->get("",$nro_cotizacion);
    
    if($cot){
        echo "OJO YA Existe este numero de Cotizacion";
    } else {
        echo "OK - Libre";
    }