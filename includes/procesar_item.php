<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/session.php';
include_once '../class/config.php';
include_once 'header.php';

    $Aux = new DBCotizacion();
    $dbuser = new DBUsuario();

    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    
    $id_item        = $_POST['id_item'];
    $valor_item     = $_POST['valor'];
    $tipo_moneda    = $_POST['tipo_moneda'];
    $anticipo       = str_replace(",",".",$_POST['anticipo']);
    $entrega        = str_replace(",",".",$_POST['entrega']);
    $aprobado       = str_replace(",",".",$_POST['aprobado']);
    
    $sql = "update ItemProyecto "
            . "set valor_item=$valor_item,"
            . "pago_anticipo=$anticipo,"
            . "pago_entrega=$entrega,"
            . "pago_aprobacion=$aprobado"
            . " where id=$id_item";
    echo "<p>SQL: $sql</p>";
    $rs = $Aux->query($sql);
    if($rs){
        echo "<p> OK </p>";
    } else {
        echo "<p>".mysql_error()."</p>";
    }
    