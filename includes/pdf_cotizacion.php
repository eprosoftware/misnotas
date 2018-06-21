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
//include_once '../class/session.php';
$sitio = "proyectos.eprosoft.cl";//eproproy.xepro.net";//$_SERVER['HTTP_HOST'];//"eproproy.xepro.net";
$proto = "http";//$_SERVER["HTTP_X_FORWARDED_PROTO"];

include_once str_replace("/includes","",getcwd())."/cfgdir.php";
include_once str_replace("/includes","",getcwd()).'/class/config.php';

    $Aux = new DBCotizacion();
    $dbuser = new DBUsuario();

    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    $nro_cotizacion = $_GET['nro_cotizacion'];
    $descarga = $_GET['descarga'];
    $lauf = $_GET['lauf'];
    $email = $_GET['email'];
    $tipo_doc=$_GET['tipo_doc'];
    $adjunta_pdf = $_GET['adjunta_pdf'];
    $mensaje = nl2br($_GET['mensaje']);
    
    $dir = DIR."/lib_archivos/";
    
    if($nro_cotizacion){
        $ax = $Aux->get("",$nro_cotizacion);$a = $ax['salida'];
        $c=$a[0];
        
        $nombre_proyecto =  utf8_encode( $c->getNombreProyecto());
        $encargado = $c->getEncargado();
        $fecha = $c->getFecha();
        $condiciones = $c->getCondiciones();
        
        $elencargado = $Aux->ElDato($encargado,"Usuarios","id","nombre");
        $valor_uf = $c->getValorUF();
        $valor_cotizacion = $c->getValorCotizacion();
        $valor_cotizacion_uf = $c->getValorCotizacionUF();
        $descuento = $c->getDescuento();
        $archivo = $c->getArchivo();
        
        $tipo_moneda = $c->getTipoMoneda();
        switch($tipo_moneda){
            case 1: $lauf = $lauf;break;
            case 2: $lauf = 1;break;
            case 3: $lauf = 'tipocambio dolar';break;
        }
        
        $rut                = $c->getRut();
        $razsoc             = $c->getRazonSocial();
        $email              = $c->getEmail();
        $fono               = $c->getFono();
        $direccion          = $c->getDireccion();
        $comuna             = $c->getComuna();
        $lacomuna           = $Aux->cleanHTMLChar($Aux->ElDato($comuna,"st_comuna","id","descripcion"));
        $nropagos           = $c->getNroPagos();
        $tipo_doc           = $c->getTipoDoc();     
        $nro_dias_valido    = $c->getNroDiasValido();
        $descuento          = $c->getDescuento();
        $dias_restantes     = $c->getDiasValidosRestantes();
        $fecha_envio        = $c->getFechaEnviado();
        
        $prefijo = str_replace("-","0",$fecha);
    }
    $logo_img = "logo_eprosoftCL.png";
?>

<table width="100%">
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td colspan="2"><img src="<?=$proto."://".$_SERVER['HTTP_HOST']?>/images/<?=$logo_img?>" border="0"></td>
                </tr>
                <?php if($mensaje){?>
                <tr>
                    <td colspan="2"><h2><b>MENSAJE</b></h2></td>
                </tr>
                <tr>
                    
                    <td colspan="2"><?=$mensaje?><br></td>
                </tr>
                <?php }?>
                <tr>
                    <td width="50%">
                        <table width="100%">
                            <tr>
                                <td colspan="2" class="titulonegro12"><h2><b>COTIZACI&Oacute;N</b></h2></td>
                            </tr>
                            <tr>
                                <td>Nro. Cotizaci&oacute;n:</td><td><h2><?=substr($prefijo."0$nro_cotizacion",-15)?></h2></td>
                            </tr>
                            <tr>
                                <td>Fecha:</td><td><?=$fecha?></td>
                            </tr>
                            <tr>
                                <td>Descripci&oacute;n:</td><td><?=$nombre_proyecto?></td>
                            </tr>
                            <tr>
                                <td>Condiciones:</td>
                                <td><?=$condiciones?></td>
                            </tr>
                            <?php if($tipo_moneda==1){?>
                            <tr>
                                <td>Valor UF utilizado:</td>
                                <td><?=number_format($lauf,2,",",".")?></td>
                            </tr>
                            <?php }?>
                            <tr>
                                <td colspan="2">
                                <?php
                                    if($dias_restantes>0){
                                        echo "Restan $dias_restantes dias ";
                                    } else {
                                        echo "El plazo lleva vencido ".-1*$dias_restantes." dias";
                                    }
                                ?>
                                </td>
                            </tr>                            
                            <?php if($descuento>0){?>
                            <tr>
                                <td>Descuento Aplicado</td>
                                <td><?=$descuento?>%</td>
                            </tr>
                            <?php }?>
                        </table>
                    </td>
                    <td width="50%">
                        <table width="100%">
                            <tr>
                                <td colspan="2"><h2><b>DATOS DEL CLIENTE</b></h2></td>
                            </tr>
                            <tr>
                                <td align="right">Rut Cliente:</td>
                                <td><?=$rut?></td>
                            </tr>
                            <tr>
                                <td align="right">Raz&oacute;n Social/Nombre:</td>
                                <td><?=$razsoc?></td>
                            </tr>   
                            <tr>
                                <td align="right">E-mail:</td>
                                <td><?=$email?></td>
                            </tr>
                            <tr>
                                <td align="right">Telefono/Celular:</td>
                                <td><?=$fono?></td>
                            </tr>
                            <tr>
                                <td align="right">Direcci&oacute;n:</td>
                                <td><?=$direccion?></td>
                            </tr>
                            <tr>
                                <td align="right">Comuna:</td>
                                <td><?=$lacomuna?></td>
                            </tr>

                        </table>
                    </td>                    
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td><?php 
        if($nro_dias_valido>0){
            echo "Esta cotizaci&oacute;n tiene una validez por $nro_dias_valido dias.";
        }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td align="center"><a href="<?=$proto?>://<?=$sitio?>/confirma_cot.php?nrocot=<?=$nro_cotizacion?>" target="_blank"><img src="<?=$proto?>://<?=$sitio?>/images/img_ok.png" width="100" border="0"></a></td>
                    <td align="center"><a href="<?=$proto?>://<?=$sitio?>/confirma_cot.php?reparo=1&nrocot=<?=$nro_cotizacion?>" target="_blank"><img src="<?=$proto?>://<?=$sitio?>/images/img_nook.png" width="100" border="0"></a></td>
                </tr>
                <tr>
                    <td><a href="<?=$proto?>://<?=$sitio?>/confirma_cot.php?nrocot=<?=$nro_cotizacion?>" target="_blank">Para Confirmar la cotizaci&oacute;n y generar la nota de Venta, presione aqu&iacute;</a></td>
                    <td><a href="<?=$proto?>://<?=$sitio?>/confirma_cot.php?reparo=1&nrocot=<?=$nro_cotizacion?>" target="_blank">Si no esta de acuerdo o tiene alg&uacute;n reparo, favor pinchar este link</a></td>
                </tr>
            </table>
        </td>
    </tr>

<?php
    $eldetalle = $Aux->getItem("",$nro_cotizacion);
    ?>
    <tr><td><b>DETALLE COTIZACI&Oacute;N</b></td></tr>
    <tr>
        <td>
            <table width="100%" border="1" cellpadding="1" cellspacing="0">
                <tr>
                    <th>Codigo</th>
                    <th>Item</th>
                    <th>Moneda</th>
                    <?php
                    for($i=0;$i<$nropagos;$i++){
                        ?>
                    <th>P<?=($i+1)?></th>
                    <?php
                    }
                    ?>
                    <th>Total Item</th>
                </tr> 
                <?php
                $total = 0;
                $total_anticipo = 0;
                $total_entregado=0;
                $total_aprobado=0;
                for($i=0;$i<count($eldetalle);$i++){
                    $tmp = $eldetalle[$i];
                    $id_cot = $tmp->getId();
                    $nro_cot = $tmp->getNroCotizacion();
                    $codigo = $tmp->getCodigo();
                    $item = $Aux->convertir_especiales_html($tmp->getItem());
                    $moneda = $tmp->getTipoMoneda();
                    $lamoneda = $Aux->ElDato($moneda,"TipoMoneda","id","descripcion");
                    $valor_total = $tmp->getValorTotal();
                    $pagos = $tmp->getPagos();
                    $xpagos = explode(",",$pagos);

                    if($valor_total>0){
                         $anticipo = $tmp->getPagoAnticipo();$total_anticipo+=$anticipo;
                        $por_anticipo = ($anticipo/$valor_total) *100;
                        $entrega = $tmp->getPagoEntrega();$total_entregado+=$entrega;
                        $por_entrega = ($entrega/$valor_total) *100;
                        $aprobado = $tmp->getPagoAprobacion();$total_aprobado+=$aprobado;
                        $por_aprobado = ($aprobado/$valor_total) *100;
                    } else {
                        $anticipo=0;$entrega=0;$aprobado=0;
                        $por_anticipo=0;$por_entrega=0;$por_aprobado=0;
                    }

                    $total+=$valor_total;
                    $color=$Aux->flipcolor($color);
                    ?>
                <tr>
                    <td bgcolor="<?=$color?>"><?=$codigo?></td>
                    <td bgcolor="<?=$color?>"><?=$item?></td>
                    <td bgcolor="<?=$color?>" align="center"><?=$lamoneda?></td>
            <?php

                    for($j=0;$j<$nropagos;$j++){
                        $v =$xpagos[$j];

                        $vv = number_format( $valor_total* ($v/100) ,2,",","."); 
                        $xtotal[$j]+=$valor_total* ($v/100);
                        $por = $v;
                        ?>
                    <td bgcolor="<?=$color?>" align="right"><?=$vv?> (<?=$v?>%)</td>        
                    <?php
                    }
                    ?>        
                    <td align="right" bgcolor="<?=$color?>"><?=$valor_total?></td>
                </tr>
                <?php
                }
                ?>

                <tr class="hnavbg" valign="top">
                    <td  class="tituloblanco12" colspan="2">TOTAL NETO</td>
                    <td></td>
                    <?php
                    for($i=0;$i<$nropagos;$i++){
                        $t = $xtotal[$i];
                        ?>
            <td class="tituloblanco12" align="right" ><?=number_format($t,2,",",".")?></td>            
                        <?php

                    }
                    ?>
                    <td colspan="2" class="tituloblanco12" align="right"><?=number_format($total,2,",",".")?>&nbsp;<?=($tipo_moneda==1)?"UF":""?><input type="hidden" name="valor_neto" value="<?=$total?>"></td>
                </tr>
                <tr class="hnavbg" valign="top">
                    <td  class="tituloblanco12" colspan="2">TOTAL NETO $</td>
                    <td></td>
                    <?php
                    for($i=0;$i<$nropagos;$i++){
                        $t = $xtotal[$i] * $lauf;
                        ?>
            <td class="tituloblanco12" align="right" ><?=($t>0)? "$".number_format($t,0,",","."):"---"?></td>
                        <?php

                    }
                    ?>        
                    <td colspan="2" class="tituloblanco12" align="right"><?=($total>0)?"$".number_format($total*$lauf,0,",","."):""?><input type="hidden" name="valor_neto_pesos" value="<?=$total*$lauf?>"></td>
                </tr>  
            </table>
        </td>
    </tr>
    <tr>
       <td class="celda_bordes">
            <table border="1" width="100%" cellspacing="0" cellpadding="1">
                <tr valign="top">
                    <?php if($tipo_doc==1){?>
                    <td class="celda_bordes"><!--Boleta de Honorarios -->
                    <table width="100%"  cellspacing="1" cellpadding="1">
                        <tr>
                            <td colspan="<?=$nropagos+1?>" class="tituloblanco12">BOLETA DE HONORARIO</td>
                            <td>TOTAL</td>
                        </tr>
                        <?php if($descuento>0){
                                    $porc_descuento = (100-$descuento)/100;?>
                        
                        <tr  valign="top">
                            <td bgcolor="<?=$color?>" class="titulonegro12" >TOTAL Descuento (<?=$descuento?>%)</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = ($xtotal[$i] * $lauf) * $porc_descuento;
                            ?>
                            <td bgcolor="<?=$color?>" align="right" ><?=number_format($t,0,",",".")?></td>                            
                            <?php
                        }
?>                            
                            <td bgcolor="<?=$color?>" align="right"><?=number_format(($lauf*$total)*$porc_descuento,0,",",".")?></td>
                        </tr>                        
                        <?php } else { $porc_descuento=1; }?>                        
                        <tr>
                            <td bgcolor="<?=$color?>" class="tituloblanconegro12">Boleta Hono. Retenci&oacute;n 10%</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = ($xtotal[$i] * $lauf)*$porc_descuento;
                            ?>
                            <td bgcolor="<?=$color?>" align="right" ><?=number_format($t*((100/90)*0.1),0,",",".")?></td>                            
                            <?php
                        }
                        $total_boleta = ($lauf*$total) * $porc_descuento;
?>                      
                            <td bgcolor="<?=$color?>" align="right"><?=number_format($total_boleta*((100/90)*0.1),0,",",".")?></td>
                        </tr>   
                        <tr valign="top">
                            <td bgcolor="<?=$color?>" class="titulonegro12">TOTAL</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = ($xtotal[$i] * $lauf)*$porc_descuento;
                            ?>
                            <td bgcolor="<?=$color?>" align="right" ><?=number_format($t*(100/90),0,",",".")?></td>
                            <?php
                        }
                        $total_boleta = ($lauf*$total) * $porc_descuento;
?>                            
                            <td bgcolor="<?=$color?>" align="right">$<?=number_format($total_boleta*(100/90),0,",",".")?></td>
                        </tr> 
                        
                    </table>
                    </td>
                    <?php }?>
                    <?php if($tipo_doc==2){?>
                    <td class="celda_bordes"><!--Factura + IVA-->
                    <table width="100%" cellspacing="1" cellpadding="1">
                        <tr>
                            <td colspan="<?=$nropagos+1?>">FACTURA</td>
                            <td >TOTAL</td>
                        </tr>
                        <?php if($descuento>0){
                                    $porc_descuento = (100-$descuento)/100;?>
                        
                        <tr  valign="top">
                            <td bgcolor="<?=$color?>" class="titulonegro12" >TOTAL Descuento (<?=$descuento?>%)</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = ($xtotal[$i] * $lauf) * $porc_descuento;
                            ?>
                            <td bgcolor="<?=$color?>" align="right" ><?=number_format($t,0,",",".")?></td>                            
                            <?php
                        }
?>                            
                            <td bgcolor="<?=$color?>" align="right"><?=number_format(($lauf*$total)*$porc_descuento,0,",",".")?></td>
                        </tr>                        
                        <?php } else { $porc_descuento=1; }?>                        
                        <tr valign="top">
                            <td bgcolor="<?=$color?>" class="titulonegro12" >IVA</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = ($xtotal[$i] * $lauf) * $porc_descuento;
                            ?>
                            <td bgcolor="<?=$color?>" align="right" ><?=number_format(($t*1.19)-$t,0,",",".")?></td>                            
                            <?php
                        }
                        $total_iva = ($lauf*$total)*$porc_descuento;
?>
                            <td bgcolor="<?=$color?>" align="right"><?=number_format(($total_iva *1.19)-$total_iva,0,",",".")?></td>
                        </tr>          
                        <tr  valign="top">
                            <td bgcolor="<?=$color?>" class="titulonegro12" >TOTAL + iva</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = ($xtotal[$i] * $lauf)*$porc_descuento;
                            ?>
                            <td bgcolor="<?=$color?>" align="right" ><?=number_format($t*1.19,0,",",".")?></td>                            
                            <?php
                        }
                        $total_final = ($lauf*$total)*$porc_descuento;
?>                            
                            <td bgcolor="<?=$color?>" align="right"><?=number_format($total_final*1.19,0,",",".")?></td>
                        </tr>        
                    </table>
                    </td>
                    <?php }?>
                   <?php if($tipo_doc==3){?>
                    <td class="celda_bordes"><!--Factura Exenta-->
                    <table width="100%" cellspacing="1" cellpadding="1">
                        <tr>
                            <td colspan="<?=$nropagos+1?>">FACTURA EXENTA</td>
                            <td >TOTAL</td>
                        </tr>
         
                        <tr  valign="top">
                            <td bgcolor="<?=$color?>" class="titulonegro12" >TOTAL</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = $xtotal[$i] * $lauf;
                            ?>
                            <td bgcolor="<?=$color?>" align="right" ><?=number_format($t,0,",",".")?></td>                            
                            <?php
                        }
?>                            
                            <td bgcolor="<?=$color?>" align="right"><?=number_format($lauf*$total,0,",",".")?></td>
                        </tr>  
                        <?php if($descuento>0){
                                    $porc_descuento = (100-$descuento)/100;?>
                        
                        <tr  valign="top">
                            <td bgcolor="<?=$color?>" class="titulonegro12" >TOTAL con Descuento (<?=$descuento?>%)</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = $xtotal[$i] * $lauf * $porc_descuento;
                            ?>
                            <td bgcolor="<?=$color?>" align="right" ><?=number_format($t,0,",",".")?></td>                            
                            <?php
                        }
?>                            
                            <td bgcolor="<?=$color?>" align="right"><?=number_format($lauf*$total*$porc_descuento,0,",",".")?></td>
                        </tr>                        
                        <?php }?>
                    </table>
                    </td>
                    <?php }?>                    
                </tr>
            </table>
        </td>
    </tr>        
</table>
    
<?php
    
    $tick = substr("00000$nro_cotizacion",-5)."-".date("Y-m-d");//$Aux->ticks();
    $dir = DIR."/lib_cotiza/";
    $filename = "$dir/cotiza_$tick.html";
    $fp=fopen($filename,"w");

    fwrite($fp,ob_get_contents());
    echo "<p>Escribiendo $filename Largo:(".ob_get_length().")</p>";
    ob_end_clean();
    
    fclose($fp);

    $fp=fopen($filename,"r");
    $mensaje=fread($fp,filesize($filename));
    //echo $mensaje;
    
    fclose($fp);
    if($descarga==1){
    try
    {
        $pdf =  new HTML2PDF('P','letter','es'); // Creamos una instancia de la clase HTML2FPDF

        //$pdf->AddPage(); // Creamos una página
        $pdf->WriteHTML($mensaje);//Volcamos el HTML contenido en la variable $html para crear el contenido del PDF

        $pdf->Output("$dir/Cotizacion$tick.pdf",'F');//Volcamos el pdf generado con nombre ‘doc.pdf’. En este caso con el parametro ‘D’ forzamos la descarga del mismo.
        
        $from ="cotizaciones@eprosoft.cl";
        $ncotizacion = substr("00000$nro_cotizacion",-5);
        $asunto = "Cotizacion Epro Software Nro.".substr($prefijo."0$nro_cotizacion",-15);
	$msj = "<html><body>"
                . "<p>$mensaje</p>"
                . "</body></html>";
        $mail = new htmlMimeMail5();
	$mail->setFrom($from);
	$mail->setSubject($asunto);
	$mail->setPriority('high');
	//$mail->setText('Sample text');
        //$mensaje = str_replace("http://syscot.xepro.net/images/logo_eprosoft.png","logo_eprosoft.png",$mensaje);
        $mensaje = str_replace("$proto://$sitio/images/logo_eprosoft.png","logo_eprosoft.png",$mensaje);
	$mail->setHTML($mensaje);
        $mail->addEmbeddedImage(new fileEmbeddedImage(HOMEDIR."/images/logo_eprosoft.png"));
        $mail->setSMTPParams('smtp.gmail.com', '587', 'EHLO', TRUE, 'eprosoft@gmail.com', 'epro..321');
        if($adjunta_pdf==1)
            $mail->addAttachment(new fileAttachment("$dir/Cotizacion$tick.pdf"));
        if($archivo){
            $mail->addAttachment(new fileAttachment(HOMEDIR."/lib_archivos/".$archivo));
        }
        //$para = $Aux->ElDato(1,"Configuracion","id","correo_cotizacion");
        //$para.= ",eroman@eprosoft.cl";//cotizacionespav@ryv.cl
        $para = array($email);
        $bc =explode(",","cotizaciones@eprosoftware.net,cotizaciones@eprosoft.cl");
        $mail->setBcc("cotizaciones@eprosoft.cl");
	$mail->send($para);
        //$p = explode(",",$para);
	echo "Correo enviado a ".$para[0];

        //$pdf =  new HTML2PDF('P','letter','es');        
        //$pdf->WriteHTML($mensaje);
        //$pdf->Output("Cotizacion$tick.pdf", 'D');//Volcamos el pdf generado con nombre ‘doc.pdf’. En este caso con el parametro ‘D’ forzamos la descarga del mismo.
        
        //echo $mensaje;
        echo "<br><a href='/lib_cotiza/Cotizacion$tick.pdf'>Descargar PDF</a>";
        $fecha_enviado = date("Y-m-d H:i:s");
        echo "<h1>".$Aux->uptEstado($nro_cotizacion,4,$fecha_enviado)."</h1>";//Enviado por correo
        exit;
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
    } else {
       // echo $mensaje;    

       
    }
    //echo $mensaje;
?>
<script>
    window.close();
</script>