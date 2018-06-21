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

include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd()).'/includes/header.php';

    $Aux = new DBCotizacion();
    $dbuser = new DBUsuario();

    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    $nro_cotizacion = $_GET['nro_cotizacion'];
    $descarga = $_GET['descarga'];

    if($nro_cotizacion){
        $a = $Aux->get("",$nro_cotizacion);$c=$a[0];
        
        $nombre_proyecto = $Aux->cleanHTMLChar($c->getNombreProyecto());
        $fecha              = $c->getFecha();
        $encargado = $c->getEncargado();
        $estado = $c->getEstado();
        $elencargado = $Aux->ElDato($encargado,"Usuarios","id","nombre");
        $lauf = $c->getValorUF();
        $nropagos = $c->getNroPagos();
        
        $prefijo = str_replace("-","",$fecha);
    }
?>
<table>
    <tr>
        <td class="celda_bordes">
<table>
    <tr>
        <td><h1>Cotizaci&oacute;n: <?=substr($prefijo."0$nro_cotizacion",-15)?></h1></td>
    </tr>    
    <tr>
        <td>Nro. Cotizaci&oacute;n:</td><td><h2><?=substr($prefijo."0$nro_cotizacion",-15)?></h2></td>
    </tr>
    <tr>
        <td>Nombre Proyecto:</td><td><?=$nombre_proyecto?></td>
    </tr>
    <?php if($estado==3){?>
    <tr>
        <td><a href="javascript:openWindow('/includes/ver_proyecto.php?nro_proyecto=<?=$nro_cotizacion?>','Proyecto<?=$nro_cotizacion?>',800,600)">Ir al proyecto</a></td>
    </tr>
    <?php }?>
    <!--<tr>
        <td>Encargado:</td><td><?=$elencargado?></td>
    </tr>
    <tr>
        <td>Valor UF:</td><td><?=number_format($lauf,2,",",".")?></td>
    </tr>-->
    <tr class="hnavbg">
        <td class="tituloblanco12" colspan="2">Detalle Cotizaci&oacute;n</td>    
    </tr>
    <tr>
        <td colspan="2">
<?php
    $eldetalle = $Aux->getItem("",$nro_cotizacion);
    ?>
<table width="100%">
    <tr><td class="celda_bordes">
    <table width="100%">
    <tr class="hnavbg">
        <td class="tituloblanco12">Codigo</td>
        <td class="tituloblanco12">Item</td>
        <td class="tituloblanco12">Moneda</td>
        <?php
        for($i=0;$i<$nropagos;$i++){
            ?>
        <td class="tituloblanco12">P<?=$i+1?></td>
        <?php
        }
        ?>
        <td class="tituloblanco12">Total Item</td>
    </tr>
    <?php
    $total = 0;$total_anticipo =0;$total_entregado=0;$total_aprobado=0;
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
        <td bgcolor="<?=$color?>"><?=$lamoneda?></td>
        <?php
        
        for($j=0;$j<$nropagos;$j++){
            $v =$xpagos[$j];
            
            $vv = number_format( $valor_total* ($v/100) ,2,",","."); 
            $xtotal[$moneda][$j]+=$valor_total* ($v/100);
            $por = $v;
            ?>
        <td bgcolor="<?=$color?>" align="right"><?=$vv?> (<?=$v?>%)</td>        
        <?php
        }
        ?>
        <td bgcolor="<?=$color?>" align="right"><?=$valor_total?></td>
    </tr>
    <?php
    }
    ?>
    <tr class="hnavbg" valign="top">
        <td  class="tituloblanco12" colspan="2">TOTAL NETO</td>
        <td></td>
        <?php
        for($i=0;$i<$nropagos;$i++){
            $t = $xtotal[$moneda][$i];
            ?>
<td class="tituloblanco12" align="right" ><?=number_format($t,2,",",".")?></td>            
            <?php
     
        }
        ?>
        <td colspan="2" class="tituloblanco12" align="right"><?=number_format($total,2,",",".")?>&nbsp;UF<input type="hidden" name="valor_neto" value="<?=$total?>"></td>
    </tr>
    <tr class="hnavbg" valign="top">
        <td  class="tituloblanco12" colspan="2">TOTAL NETO $</td>
        <td></td>
        <?php
        for($i=0;$i<$nropagos;$i++){
            switch($moneda){
                case 1: $valor_ajuste = $lauf;break;
                case 2:$valor_ajuste = 1;break;
                case 3:$valor_ajuste = $valor_us;
            }
            $t = $xtotal[$moneda][$i] * $valor_ajuste;
            ?>
<td class="tituloblanco12" align="right" ><?=($t>0)? "$".number_format($t,0,",","."):"---"?></td>
            <?php
     
        }
        ?>        
        <td colspan="2" class="tituloblanco12" align="right"><?=($total>0)?"$".number_format($total*$valor_ajuste,0,",","."):""?><input type="hidden" name="valor_neto_pesos" value="<?=$total*$lauf?>"></td>
    </tr>   
    </table></td></tr></table>
                
                
            </td>
    </tr>
</table>
        </td></tr></table>

<?php

    $home =str_replace("/includes","",getcwd());
    
    $dir = str_replace("/includes","",getcwd())."/lib_archivos/";
    $tick = $nro_cotizacion."-".date("Y-m-d");//$Aux->ticks();
    $filename = "$dir/cotiza_$tick.html";
    $fp=fopen($filename,"w");

    fwrite($fp,ob_get_contents());

    ob_end_clean();
    //echo "<p>Escribiendo $filename Largo:(".ob_get_length().")</p>";
    fclose($fp);

    $fp=fopen($filename,"r");
    $mensaje=fread($fp,filesize($filename));
    fclose($fp);
    if($descarga==1)
    try
    {
        $pdf = new HTML2FPDF(); // Creamos una instancia de la clase HTML2FPDF

        $pdf->AddPage(); // Creamos una página
        $pdf->WriteHTML($mensaje);//Volcamos el HTML contenido en la variable $html para crear el contenido del PDF
        $pdf->Output("Cotizacion$tick.pdf", 'D');//Volcamos el pdf generado con nombre ‘doc.pdf’. En este caso con el parametro ‘D’ forzamos la descarga del mismo.
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
    else {
        echo $mensaje;    

       
    }
?>
