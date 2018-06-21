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
include_once str_replace("/includes","",getcwd())."/class/config.php";

    $Aux = new DBCotizacion();
    $dbuser = new DBUsuario();

    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    $nro_cotizacion = $_GET['nro_cotizacion'];
    $descarga = $_GET['descarga'];
    $lauf = $_GET['lauf'];
    $email = $_GET['email'];
    $tipo_doc=$_GET['tipo_doc'];
    $adjunta_pdf = $_GET['adjunta_pdf'];
    
    $dir = HOMEDIR."/lib_archivos/";
    
    if($nro_cotizacion){
        $ax = $Aux->get("",$nro_cotizacion);
        $a= $ax['salida'];$c=$a[0];
        
        $nombre_proyecto = $c->getNombreProyecto();
        $encargado = $c->getEncargado();
        $fecha = $c->getFecha();
        $condiciones = $c->getCondiciones();
        $elencargado = $Aux->ElDato($encargado,"Usuarios","id","nombre");
        $valor_uf = $c->getValorUF();
        $lauf = $valor_uf;
        $valor_cotizacion = $c->getValorCotizacion();
        $valor_cotizacion_uf = $c->getValorCotizacionUF();
        $descuento = $c->getDescuento();
        
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
        $lacomuna           = $Aux->ElDato($comuna,"st_comuna","id","descripcion");
        $nropagos           = $c->getNroPagos();
        $tipo_doc           = $c->getTipoDoc();     
        $nro_dias_valido    = $c->getNroDiasValido();
        $descuento          = $c->getDescuento();
        
        $prefijo = str_replace("-","0",$fecha);
    }
    $sitio = "eprosoftware.net";
?>
<table width="100%">
    <tr>
        <td>
            <table width="100%">
                <tr valign="top">
                    <td width="50%">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h2><b>COTIZACI&Oacute;N</b></h2></div>
                            <div class="panel-body">
                                <table width="100%">
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
                                <?php if($descuento>0){?>
                                <tr>
                                    <td>Descuento Aplicado</td>
                                    <td><?=$descuento?>%</td>
                                </tr>
                                <?php }?>
                            </table>
                            </div>
                        </div>
                    </td>
                    <td width="50%">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h2><b>DATOS DEL CLIENTE</b></h2></div>
                            <div class="panel-body">
                                <table width="100%">
                                    <tr>
                                        <td>Rut Cliente:</td>
                                        <td><?=$rut?></td>
                                    </tr>
                                    <tr>
                                        <td>Raz&oacute;n Social/Nombre:</td>
                                        <td><?=$razsoc?></td>
                                    </tr>   
                                    <tr>
                                        <td>E-mail:</td>
                                        <td><?=$email?></td>
                                    </tr>
                                    <tr>
                                        <td>Telefono/Celular:</td>
                                        <td><?=$fono?></td>
                                    </tr>
                                    <tr>
                                        <td>Direcci&oacute;n:</td>
                                        <td><?=$direccion?></td>
                                    </tr>
                                    <tr>
                                        <td>Comuna:</td>
                                        <td><?=$lacomuna?></td>
                                    </tr>

                                </table>                                
                            </div>                        

                    </td>                    
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td><?php 
        if($nro_dias_valido>0)
            echo "<div class='alert alert-warning'>Esta cotizaci&oacute;n tiene una validez por $nro_dias_valido dias.</div>";
            ?>
        </td>
    </tr>


<?php
    $eldetalle = $Aux->getItem("",$nro_cotizacion);
    ?>
    <tr>
        <td>
            <div class="panel panel-default">
                <div class="panel-heading"><b>DETALLE COTIZACI&Oacute;N</b></div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                    <tr class="default">
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
                        </thead>
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
                        <td><?=$codigo?></td>
                        <td><?=$item?></td>
                        <td align="center"><?=$lamoneda?></td>
                <?php

                        for($j=0;$j<$nropagos;$j++){
                            $v =$xpagos[$j];

                            $vv = number_format( $valor_total* ($v/100) ,2,",","."); 
                            $xtotal[$j]+=$valor_total* ($v/100);
                            $por = $v;
                            ?>
                        <td align="right"><?=$vv?> (<?=$v?>%)</td>        
                        <?php
                        }
                        ?>        
                        <td align="right"><?=$valor_total?></td>
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
                    <tr valign="top">
                        <td colspan="2">TOTAL NETO $</td>
                        <td></td>
                        <?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = $xtotal[$i] * $lauf;
                            ?>
                <td align="right" ><?=($t>0)? "$".number_format($t,0,",","."):"---"?></td>
                            <?php

                        }
                        ?>        
                        <td colspan="2" align="right"><?=($total>0)?"$".number_format($total*$lauf,0,",","."):""?><input type="hidden" name="valor_neto_pesos" value="<?=$total*$lauf?>"></td>
                    </tr>  
                </table>
                </div>
            </div>
        </td>
    </tr>

    <tr>
       <td align="center">
            <table class="table table-bordered table-striped">
                <tr valign="top">
                    <td>
                    <?php switch($tipo_doc) {
                        case 1: ?>
                    <!--Boleta de Honorarios -->
                    <table width="100%"  cellspacing="1" cellpadding="1">
                        <tr>
                            <td colspan="<?=$nropagos+1?>" class="tituloblanco12">BOLETA DE HONORARIO</td>
                            <td>TOTAL</td>
                        </tr>
                        <?php if($descuento>0){
                                    $porc_descuento = (100-$descuento)/100;?>
                        
                        <tr  valign="top">
                            <td>TOTAL Descuento (<?=$descuento?>%)</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = ($xtotal[$i] * $lauf) * $porc_descuento;
                            ?>
                            <td align="right" ><?=number_format($t,0,",",".")?></td>                            
                            <?php
                        }
?>                            
                            <td align="right"><?=number_format(($lauf*$total)*$porc_descuento,0,",",".")?></td>
                        </tr>                        
                        <?php } else { $porc_descuento=1; }?>                        
                        <tr>
                            <td >Boleta Hono. Retenci&oacute;n 10%</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = ($xtotal[$i] * $lauf)*$porc_descuento;
                            ?>
                            <td align="right" ><?=number_format($t*((100/90)*0.1),0,",",".")?></td>                            
                            <?php
                        }
                        $total_boleta = ($lauf*$total) * $porc_descuento;
?>                      
                            <td align="right"><?=number_format($total_boleta*((100/90)*0.1),0,",",".")?></td>
                        </tr>   
                        <tr valign="top">
                            <td class="titulonegro12">TOTAL</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = ($xtotal[$i] * $lauf)*$porc_descuento;
                            ?>
                            <td align="right" ><?=number_format($t*(100/90),0,",",".")?></td>
                            <?php
                        }
                        $total_boleta = ($lauf*$total) * $porc_descuento;
?>                            
                            <td align="right">$<?=number_format($total_boleta*(100/90),0,",",".")?></td>
                        </tr> 
                        
                    </table>
                    
                    <?php break;?>
                    <?php case 2:?>
                    <!--Factura + IVA-->
                    <table width="100%" cellspacing="1" cellpadding="1">
                        <tr>
                            <td colspan="<?=$nropagos+1?>">FACTURA</td>
                            <td >TOTAL</td>
                        </tr>
                        <?php if($descuento>0){
                                    $porc_descuento = (100-$descuento)/100;?>
                        
                        <tr  valign="top">
                            <td class="titulonegro12" >TOTAL Descuento (<?=$descuento?>%)</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = ($xtotal[$i] * $lauf) * $porc_descuento;
                            ?>
                            <td align="right" ><?=number_format($t,0,",",".")?></td>                            
                            <?php
                        }
?>                            
                            <td align="right"><?=number_format(($lauf*$total)*$porc_descuento,0,",",".")?></td>
                        </tr>                        
                        <?php } else { $porc_descuento=1; }?>                        
                        <tr valign="top">
                            <td class="titulonegro12" >IVA</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = ($xtotal[$i] * $lauf) * $porc_descuento;
                            ?>
                            <td align="right" ><?=number_format(($t*1.19)-$t,0,",",".")?></td>                            
                            <?php
                        }
                        $total_iva = ($lauf*$total)*$porc_descuento;
?>
                            <td align="right"><?=number_format(($total_iva *1.19)-$total_iva,0,",",".")?></td>
                        </tr>          
                        <tr  valign="top">
                            <td class="titulonegro12" >TOTAL + iva</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = ($xtotal[$i] * $lauf)*$porc_descuento;
                            ?>
                            <td align="right" ><?=number_format($t*1.19,0,",",".")?></td>                            
                            <?php
                        }
                        $total_final = ($lauf*$total)*$porc_descuento;
?>                            
                            <td align="right"><?=number_format($total_final*1.19,0,",",".")?></td>
                        </tr>        
                    </table>
                    
                    <?php break; ?>
                    <?php case 3:?>
                    <!--Factura Exenta-->
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td >FACTURA EXENTA</td>
                            <?php 
                            for ($p=0;$p<$nropagos;$p++){
                                echo "<td>P".($p+1)."</td>";
                            }
                            ?>
                            <td >TOTAL</td>
                        </tr>
                        <tr  valign="top">
                            <td>TOTAL</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = $xtotal[$i] * $lauf;
                            ?>
                            <td align="right" ><?=number_format($t,0,",",".")?></td>                            
                            <?php
                        }
?>                            
                            <td align="right"><?=number_format($lauf*$total,0,",",".")?></td>
                        </tr>  
                        <?php if($descuento>0){
                                    $porc_descuento = (100-$descuento)/100;?>
                        
                        <tr  valign="top">
                            <td>TOTAL con Descuento (<?=$descuento?>%)</td>
<?php
                        for($i=0;$i<$nropagos;$i++){
                            $t = $xtotal[$i] * $lauf * $porc_descuento;
                            ?>
                            <td align="right" ><?=number_format($t,0,",",".")?></td>                            
                            <?php
                        }
?>                            
                            <td align="right"><?=number_format($lauf*$total*$porc_descuento,0,",",".")?></td>
                        </tr>                        
                        <?php }?>
                    </table>
                    
                    <?php break; }?>                    
                    </td>
                </tr>
            </table>
        </td>
    </tr>        
</table>
    

