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

include_once '../class/session.php';
include_once '../class/config.php';
include_once 'header.php';

    $Aux = new DBProyecto();
    
    $nro        = $_GET['nro'];
    $codigo     = $_GET['codigo'];
    $id_item    = $_GET['id_item'];
    $item       = $_GET['item'];
    $comentario = $_GET['comentario'];
    
    $marca_conformidad  = $_GET['marca_conformidad'];
    $estado             = $_GET['estado'];
    $realizado_por      = $_GET['realizado_por'];
    $fecha    = $_GET['fecha'];
    
    $tmp = new PedidoProyecto();
    
    $tmp->setNroProyecto($nro);
    $tmp->setIdItemProyecto($id_item);
    $tmp->setCodigo($codigo);
    $tmp->setItem($item);
    $tmp->setComentario($comentario);
    $tmp->setMarcaConformidad($marca_conformidad);
    $tmp->setEstado($estado);
    $tmp->setRealizadoPor($realizado_por);
    $tmp->setFechaRecepcion($fecha);
    
    echo "<p>Se creo Item ID:".$Aux->addPedido($tmp)."</p>";
    
    $asunto = "Se ha realiazo Pedido en proyecto #$nro";
    $from = "sistema_pavimentos@ryv.cl";
    $mail = new htmlMimeMail5();
    $mail->setFrom($from);
    $mail->setSubject($asunto);
    $mail->setPriority('high');
    //$mail->setText('Sample text');
    $mensaje ="<html><body><table>"
            . "<tr><td>Nro.Proyecto:</td><td>$nro</td></tr>"
            . "<tr><td>ITEM:$codigo</td>"
            . "<td>$item</td></tr>"
            . "<tr><td colspan='2'>$comentario</td></tr>"
            . "</table></body></html>";
    $mail->setHTML($mensaje);
    $mail->setSMTPParams('smtp.gmail.com', '587', 'EHLO', TRUE, 'eprosoft@gmail.com', 'epro..321');
    //$para = "proyectospav@ryv.cl,eroman@eprosoft.cl";//proyectospav@ryv.cl
    $para = $Aux->ElDato(1,"Configuracion","id","correo_pedidos");

    $mail->send(explode(",",$para));        
    $p = explode(",",$para);
    echo "Correo enviado a ".$p[0];
   
?>