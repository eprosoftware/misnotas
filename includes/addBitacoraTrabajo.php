<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../class/session.php';
include_once '../class/config.php';


    $Aux = new DBBitacoraTrabajo();
    
    
    $tmp = new BitacoraTrabajo();
    $tmp->setFecha($_GET['fecha']);
    $tmp->setIdProyectista($_GET['id_user']);
    $tmp->setNroProyecto($_GET['nro_proyecto']);
    $tmp->setIdItemProyecto($_GET['id_item']);
    $tmp->setNroHoras($_GET['nro_horas']);
    $tmp->setGlosa($_GET['glosa']);
       
    echo $Aux->add($tmp);
    
    