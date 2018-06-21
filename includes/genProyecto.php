<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    include_once str_replace("/includes","",getcwd()).'/class/session.php';
    include_once str_replace("/includes","",getcwd()).'/class/config.php';
    include_once str_replace("/includes","",getcwd()).'/includes/header.php';

$Aux = new DBProyecto();
$Cot = new DBCotizacion();
$dbuser = new DBUsuario();
$iduser = $dbuser->getUsuarioId($usuario,$clave);
    
$Aux->conecta();

$nro_cotizacion = $_GET['nro_cotizacion'];

$ax = $Cot->get("",$nro_cotizacion);
$a = $ax['salida'];
$c = $a[0];
echo $Aux->genProyecto($c,$iduser);



