<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once str_replace("/includes","",getcwd()).'/class/config.php';

$from ="recordatorioPagoIVA@eprosoft.cl";
$asunto = "Recordatorio PAGO de IVA EPRO SOFTWARE EIRL 76.347.904-8";
$msj = "<html><body>"
        . "<p>Estimada, Favor Pagar IVA EPRO SOFTWARE EIRL RUT:76.347.904-8</p>"
        . "<p>Gracias</p>"
        . "</body></html>";
$mail = new htmlMimeMail5();
$mail->setFrom($from);
$mail->setSubject($asunto);
$mail->setPriority('high');
//$mail->setText('Sample text');
//$mensaje = str_replace("http://syscot.xepro.net/images/logo_eprosoft.png","logo_eprosoft.png",$mensaje);
$mensaje = $msj;
$mail->setHTML($mensaje);
$mail->addEmbeddedImage(new fileEmbeddedImage(HOMEDIR."/images/logo_eprosoft.png"));
$mail->setSMTPParams('mx1.hostinger.es', '587', 'EHLO', TRUE, 'info@proyectos.eprosoft.cl', '17071969');
//if($adjunta_pdf==1)
//    $mail->addAttachment(new fileAttachment("$dir/Cotizacion$tick.pdf"));
//$para = $Aux->ElDato(1,"Configuracion","id","correo_cotizacion");
//$para.= ",eroman@eprosoft.cl";//cotizacionespav@ryv.cl
$email = "eprosoft@gmail.com";
$para = array($email);

//$mail->setBcc("cotizaciones@eprosoft.cl");
$mail->send($para);
//$p = explode(",",$para);
echo "Correo enviado a ".$para[0];
