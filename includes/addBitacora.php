<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once str_replace("/includes","",getcwd())."/cfgdir.php";
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';

    $Aux = new DBProyecto();
    
    $tmp = new BitacoraProyecto();
    $fecha = date("Y-m-d H:i:s");
    $tmp->setFecha($fecha);
    
    $tmp->setNroProyecto($_GET['nro_proyecto']);
    $tmp->setIdUsuario($_GET['id_usuario']);
    $tmp->setAnotacion($_GET['anotacion']);
    
    echo $Aux->addBitacora($tmp);
    
    