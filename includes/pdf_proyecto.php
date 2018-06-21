<?php
/*
 * Diseñado y desarrollado por Epro Software (c)2014
 * Bajo Licencia GNU
 * Cualquier cambio debe ser avisado a Epro Software
 */

/**
 * Nueva Cotización
 *
 * @author eroman
 * Fecha: 2014-05-18
 * 
 */
ob_start();
include_once '../class/session.php';
include_once '../class/config.php';


    $Aux = new DBProyecto();
    $dbuser = new DBUsuario();

    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    
    $nro_proyecto = $_GET['nro_proyecto'];
    $descarga = $_GET['descarga'];
    $dir = HOMEDIR."/lib_archivos/";
    
    $lostipomoneda = $Aux->TraerLosDatos("TipoMoneda","id","descripcion");
    $losproyectistas = $Aux->TraerLosDatos("Usuarios","id","nombre");

    if($nro_proyecto){
        $a = $Aux->get("",$nro_proyecto);$p=$a[0];
        
        $nombre_proyecto = $p->getNombreProyecto();
        $encargado = $p->getProyectistaAsignado();
        $fecha_creacion = $p->getFechaCreacion();
        $valor_uf = $p->getValorUF();
    } else {
        $i = new Indicadores();
        $valor_uf = $i->getUf();
        $fecha_creacion = date("Y-m-d");
    }
    $tipo_moneda = ($tipo_moneda)?$tipo_moneda:1;
?>
<table width="100%">
    <tr>
        <td colspan="2" class="titulonegro12"><img src="http://pavimentos.ruzyvukasovic.cl/images/logo_rv.jpg" border="0"></td>
    </tr>  
    <tr>
        <td>Nro. Proyecto:</td>
        <td><h2><?=substr("00000000$nro_proyecto",-5)?></h2></td>
    </tr>
    <tr>
        <td>Fecha Sistema:</td>
        <td><?=$fecha_creacion?></td>
    </tr>
    <tr>
        <td>Nombre Proyecto:</td>
        <td><?=$nombre_proyecto?></td>
    </tr>
    <tr>
        <td>Proyectista:</td>
        <td><?=$Aux->ElDato($encargado,"Usuarios","id","nombre")?></td>
    </tr>
</table>
<?php
    $eldetalle = $Aux->getItem("",$nro_proyecto);
?>
<br>
<table width="100%" border="0">
    <tr>
        <th colspan="13">Detalle Pedidos Proyecto</th>    
    </tr>    

    <?php
    $total = 0;$total_anticipo =0;$total_entregado=0;$total_aprobado=0;
    $total_dias_taller_cerrados=0;$total_dias_taller=0;
    for($i=0;$i<count($eldetalle);$i++){
        $tmp = $eldetalle[$i];
        $id_item = $tmp->getId();
        
        $dias_taller_cerrados = $Aux->getDiasTallerCerrados($id_item);
        $total_dias_taller_cerrados+=$dias_taller_cerrados;
        $fecha_in = $Aux->ElDato($id_item,"TiempoTaller","id_item","fecha_in","estado=1");
        $fecha_out = $Aux->ElDato($id_item,"TiempoTaller","id_item","fecha_out","estado=1");
        
        if(!isset($fecha_out) && isset($fecha_in)){
            $delta_taller = $Aux->dateDiff ($fecha_in, date("Y-m-d"));
        } else if(isset($fecha_in)){
            $delta_taller = $Aux->dateDiff ($fecha_in, $fecha_out);
        } else $delta_taller=0;
        $total_dias_taller+=$delta_taller;
        $nro_proy = $tmp->getNroProyecto();
        $codigo = $tmp->getCodigo();
        $item = $tmp->getItem();
        $ep1 = $tmp->getEP1();
        $ep2 = $tmp->getEP2();
        $ep3 = $tmp->getEP3();
        $taller = $tmp->getTaller();
        $seguimiento_taller = $tmp->getSeguimientoTaller();
        $solo_seguimiento = $tmp->getSoloSeguimiento();
        $oc = $tmp->getOC();
        $hes = $tmp->getHES();
        $moneda = $tmp->getTipoMoneda();
        $lamoneda = $Aux->ElDato($moneda,"TipoMoneda","id","descripcion");
        $valor_total = $tmp->getValorItem();
        $anticipo = $tmp->getPagoAnticipo();$total_anticipo+=$anticipo;
        $por_anticipo = number_format(($anticipo/$valor_total) *100,0);
        $entrega = $tmp->getPagoEntrega();$total_entregado+=$entrega;
        $por_entrega = number_format(($entrega/$valor_total) *100,0);
        $aprobado = $tmp->getPagoAprobacion();$total_aprobado+=$aprobado;
        $por_aprobado = number_format(($aprobado/$valor_total) *100,0);
        
        $por_cobrado = 0;
        if($ep1==1) $por_cobrado+=$por_anticipo;
        if($ep2==1) $por_cobrado+=$por_entrega;
        if($ep3==1) $por_cobrado+=$por_aprobado;
        $total+=$valor_total;
        $color=$Aux->flipcolor($color);

        echo $Aux->showPedidosX($id_item);
    }
    ?>
    
    <tr>
        <td colspan="13"><hr></td>
    </tr>

</table>
<?php

    $tick = substr("00000$nro_proyecto",-5)."-".date("Y-m-d");//$Aux->ticks();
    $filename = "$dir/proyecto_$tick.html";
    $filepdf= "$dir/proyecto_$tick.pdf";
    $fp=fopen($filename,"w");

    fwrite($fp,ob_get_contents());

    ob_end_clean();
    //echo "<p>Escribiendo $filename Largo:(".ob_get_length().")</p>";
    fclose($fp);

    $fp=fopen($filename,"r");
    $mensaje=fread($fp,filesize($filename));
    fclose($fp);
    if ($descarga == 1) {
    try {
        $pdf = new HTML2PDF('P','letter','es'); // Creamos una instancia de la clase HTML2FPDF

        //$pdf->AddPage(); // Creamos una página
        $pdf->WriteHTML($mensaje); //Volcamos el HTML contenido en la variable $html para crear el contenido del PDF

        $pdf->Output("$dir/Proyecto_$nro_proyecto.pdf", 'F'); //Volcamos el pdf generado con nombre ‘doc.pdf’. En este caso con el parametro ‘D’ forzamos la descarga del mismo.
        //$pdf->Output($filepdf); //Volcamos el pdf generado con nombre ‘doc.pdf’. En este caso con el parametro ‘D’ forzamos la descarga del mismo.
        
        $from ="sistemapavimentos@ryv.cl";
        $ncotizacion = substr("00000$nro_proyecto",-5);
        $asunto = "Sistema Pavimentos Proyecto Nro. $nro_proyecto";

        $mail = new htmlMimeMail5();
	$mail->setFrom($from);
	$mail->setSubject($asunto);
	$mail->setPriority('high');
	//$mail->setText('Sample text');
	$mail->setHTML($mensaje);
	$mail->addEmbeddedImage(new fileEmbeddedImage(HOMEDIR."/images/logo_rv.jpg"));
        $mail->setSMTPParams('smtp.gmail.com', '587', 'EHLO', TRUE, 'eprosoft@gmail.com', 'epro..321');
        $mail->addAttachment(new fileAttachment("$dir/Proyecto_$nro_proyecto.pdf"));
        //$para = "proyectospav@ryv.cl,eroman@eprosoft.cl";//proyectospav@ryv.cl
        $para = $Aux->ElDato(1,"Configuracion","id","correo_pavimentos");
        $para.= ",eroman@eprosoft.cl";//proyectospav@ryv.cl
	$mail->send(explode(",",$para));        
        $p = explode(",",$para);
	echo "Correo enviado a ".$p[0];
        echo "<br><a href='/lib_archivos/Proyecto_$nro_proyecto.pdf'>Descargar PDF</a>";
        exit;
    } catch (HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
} else {
    //echo $mensaje;
}
?>
