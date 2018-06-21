<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once str_replace("/includes","",getcwd())."/cfgdir.php";
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd()).'/includes/header.php';

    $Aux = new DBCotizacion();
    
    $nro_cotizacion  = $_GET['nro_cotizacion'];
    $nombre_proyecto = $_GET['nombre_proy'];
    $encargado       = $_GET['encargado'];
    $creadopor       = $_GET['creadopor'];
    $nropagos        = $_GET['nropagos'];
    $valor_uf        = str_replace(",",".",$_GET['uf']);
    $valor_total     = $_GET['valor_total'];
    
    $tmp = new Cotizacion();
    $fecha = date("Y-m-d");
    
    $tmp->setFecha($fecha);
    $tmp->setNroCotizacion($nro_cotizacion);
    $tmp->setNombreProyecto(trim($nombre_proyecto));
    $tmp->setEncargado($encargado);
    $tmp->setCreadoPor($creadopor);
    $tmp->setValorUF($valor_uf);
    $tmp->setValorCotizacion($valor_total*$valor_uf);
    $tmp->setValorCotizacionUF($valor_total);
    $tmp->setEstado(1);
    echo "Cotizaci&oacute;n creada :".$Aux->add($tmp);
    
?>