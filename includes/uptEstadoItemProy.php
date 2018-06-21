<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once str_replace("/includes","",getcwd()).'/class/config.php';
    

$Aux = new DBProyecto();

$estado = $_GET['estado'];
$iditem = $_GET['iditem'];

echo $Aux->uptEstado($estado,$iditem);