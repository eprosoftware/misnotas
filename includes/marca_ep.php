<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once str_replace("/includes","",getcwd()).'/cfgdir.php';
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';

    $Aux = new DBProyecto();
    $pos = $_GET['pos'];
    $id = $_GET['id_item'];
    
    echo $Aux->uptEP($pos,$id);