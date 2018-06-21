<?php

/*
 * Diseñado y desarrollado por Epro Software (c)2014
 * Bajo Licencia GNU
 * Cualquier cambio debe ser avisado a Epro Software
 */

/**
 * Agrega Item en la cotización
 *
 * @author eroman
 * Fecha: 2014-05-18
 * 
 */
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd()).'/includes/header.php';

    $Aux = new DBCotizacion();
    $Aux->conecta_pdo();
    
    $nro        = $_GET['nro'];
    $codigo     = $_GET['codigo'];
    $item       = $_GET['item'];
    $moneda     = $_GET['moneda'];
    $valor      = $_GET['valor'];
    $nropagos   = $_GET['nropagos'];
    $lospagos   = $_GET['lospagos'];
    
    $pagos      = $_GET['pagos'];
    
    $xpagos = explode(",",$pagos);
    
    $anticipo   = str_replace(",",".",$_GET['anticipo']);
    $entrega    = str_replace(",",".",$_GET['entrega']);
    $aprobado   = str_replace(",",".",$_GET['aprobado']);
    
    $a = $Aux->get("",$nro);$cx =$a['salida'];
    $c = $cx[0];
    $estado = $c->getEstado();
    $tmp = new ItemCotizacion();
    
    $tmp->setNroCotizacion($nro);
    $tmp->setCodigo($codigo);
    $tmp->setItem($item);
    $tmp->setTipoMoneda($moneda);
    $tmp->setValorTotal($valor);
    $tmp->setPagoAnticipo($anticipo);
    $tmp->setPagoEntrega($entrega);
    $tmp->setPagoAprobacion($aprobado);
    $tmp->setPagos(substr($lospagos,0,  strlen($lospagos)-1));
    
    $salida = "<p>Se creo Item ID:[$id]</p>";
    if(isset($c) && false){
        if ($estado==3){//Proyecto Generado , Crear Tarea en Proyecto
            $p = new DBProyecto();
            $item = new ItemProyecto();

            $item->setNroProyecto($tmp->getNroCotizacion());
            $item->setCodigo($tmp->getCodigo());
            $item->setItem($tmp->getItem());
            $item->setTipoMoneda($tmp->getTipoMoneda());
            $item->setPagoAnticipo($tmp->getPagoAnticipo());
            $item->setPagoEntrega($tmp->getPagoEntrega());
            $item->setPagoAprobacion($tmp->getPagoAprobacion());
            $item->setTipoMoneda($tmp->getTipoMoneda());
            $item->setValorItem($tmp->getValorTotal());

            $id_item = $p->addItemProyecto($item);
            $salida+= "<p>Se creo Item ID Proyecto:$id_item</p>";
        }
    }
    echo $Aux->addItem($tmp);
    
?>