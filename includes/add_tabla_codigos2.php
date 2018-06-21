<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/config.php';

    $Aux = new DBCotizacion();
    
    $cod = $_GET['cod'];
    $desc = $_GET['desc'];
    
    echo "<p>".$Aux->addTableCodigosPedidos($cod,$desc)."</p>";