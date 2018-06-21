<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/session.php';
include_once '../class/config.php';

    $Aux = new DBProyecto();
    $dbuser = new DBUsuario();

   
    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    
    $id = $_POST['id'];
    $nro_proyecto = $_POST['nro_proyecto'];
    $fecha = date("Y-m-d H:i:s");
    $item = $_POST['item'];
    $codigo_despacho = $_POST['codigo_despacho'];
    $estado_despacho = $_POST['estado'];
    
    $tmp = new Despacho();
    
    $tmp->setId($id);
    
    $tmp->setNroProyecto($nro_proyecto);
    $tmp->setIdItemProyecto($item);
    $tmp->setCodigoDespacho($codigo_despacho);
    $tmp->setEstadoDespacho($estado_despacho);
    $tmp->setQuienDespacha($id_user);
    if($id){
        $tmp->setFechaAprobacion($fecha);
        echo $Aux->updateDespacho($tmp);
    } else {
        $tmp->setFechaDespacho($fecha);
        echo $Aux->addDespacho($tmp);
        /* Enviar Correo Despachos*/
        $asunto = "Se ha realiazo un Despacho en proyecto #$nro_proyecto";
        $from = "sistema_pavimentos@ryv.cl";
        $mail = new htmlMimeMail5();
        $mail->setFrom($from);
        $mail->setSubject($asunto);
        $mail->setPriority('high');
        //$mail->setText('Sample text');
        $mensaje ="<html><body><table>"
                . "<tr><td>Nro.Proyecto:</td><td>$nro_proyecto</td></tr>"
                . "<tr><td>ITEM:$item|</td><td>$item</td></tr>"
                . "<tr><td>C&oacute;digo Depacho:</td><td>$codigo_despacho</td></tr>"
                . "<tr><td>Estado Depacho:</td><td>$estado_despacho</td></tr>"
                . "</table></body></html>";
        $mail->setHTML($mensaje);
        $mail->setSMTPParams('smtp.gmail.com', '587', 'EHLO', TRUE, 'eprosoft@gmail.com', 'epro..321');
        //$para = "proyectospav@ryv.cl,eroman@eprosoft.cl";//proyectospav@ryv.cl
        $para = $Aux->ElDato(1,"Configuracion","id","correo_despachos");

        $mail->send(explode(",",$para));        
        $p = explode(",",$para);
        echo "Correo enviado a ".$p[0];        
    }
    
    
    
    ?>
<script>
    window.close();
</script>    
    