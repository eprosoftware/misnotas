<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/config.php';

    $Aux = new DBProyecto();
    
    $nro = $_GET['nro'];
    echo "<p>".$Aux->crearProyecto($nro)."</p>";