<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd()).'/includes/header.php';

    $Aux = new DBCotizacion();
        
    $nro  = $_GET['nro'];
    $lauf = $_GET['lauf'];
    $elus = $_GET['elus'];
    $ddel = $_GET['ddel'];
    $nropagos = $_GET['nropagos'];
    $descuento = $_GET['descuento'];
    
    $eldetalle = $Aux->getItem("",$nro);
    
    ?>
<!--P:<?=$nropagos?>-->

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Codigo</th>
            <th>Item</th>
            <th>Moneda</th>
            <?php
            for ($i=0;$i<$nropagos;$i++){
                ?>
            <th>P<?=$i+1?></th>        
            <?php

            }
            ?>
            <th>Total Item</th>
            <th colspan="2"></th>
        </tr>
    </thead>
<?php
$xtotal=array(array(),array());$total=0;
$total_anticipo =0;$total_entregado=0;$total_aprobado=0;
$color="";
for($i=0;$i<count($eldetalle);$i++){
    $tmp = $eldetalle[$i];
    $id_cot = $tmp->getId();
    $nro_cot = $tmp->getNroCotizacion();
    $codigo = $tmp->getCodigo();
    $item = $tmp->getItem();
    $moneda = $tmp->getTipoMoneda();
    $lamoneda = $Aux->ElDato($moneda,"TipoMoneda","id","descripcion");
    $valor_total = $tmp->getValorTotal();
    $pagos = $tmp->getPagos();
    $xpagos = explode(",",$pagos);
    if($valor_total>0){
        $anticipo     = $tmp->getPagoAnticipo();$total_anticipo+=$anticipo;
        $por_anticipo = ($anticipo/$valor_total) *100;
        $entrega      = $tmp->getPagoEntrega();$total_entregado+=$entrega;
        $por_entrega  = ($entrega/$valor_total) *100;
        $aprobado     = $tmp->getPagoAprobacion();$total_aprobado+=$aprobado;
        $por_aprobado = ($aprobado/$valor_total) *100;
    } else {
        $anticipo=0;$entrega=0;$aprobado=0;
        $por_anticipo=0;$por_entrega=0;$por_aprobado=0;
    }
    $total+=$valor_total;
    $color=$Aux->flipcolor($color);
    ?>
<tr >
    <td><?=$codigo?></td>
    <td><?=$item?></td>
    <td align="center"><?=$lamoneda?></td>
    <?php

    for($j=0;$j<$nropagos;$j++){
        $v =$xpagos[$j];

        $vv = number_format( $valor_total* ($v/100) ,2,",","."); 
        $xtotal[$moneda][$j]+=$valor_total* ($v/100);
        $por = $v;
        ?>
    <td align="right"><?=$vv?> (<?=$v?>%)</td>        
    <?php
    }
    ?>
    <td align="right"><?=number_format($valor_total,2,",",".")?></td>
    <td><div id="salida<?=$id_cot?>"><?php if($ddel==1){?><button class="btn btn-danger btn-sm" onclick="if(confirm('Desea eliminar el Item?')) {requestPage('includes/delItem.php?iddel=<?=$id_cot?>','salida<?=$id_cot?>');}"><i class="glyphicon glyphicon-trash"></i></button><?php }?></div></td>

</tr>
<?php
}
?>
<tr class="info" valign="top">
    <td  colspan="2">TOTAL NETO</td>
    <td></td>
    <?php
    for($i=0;$i<$nropagos;$i++){
        $t = $xtotal[$moneda][$i];
        ?>
<td align="right" ><?=number_format($t,2,",",".")?></td>            
        <?php

    }
    ?>
    <td colspan="2" align="right"><?=number_format($total,2,",",".")?>&nbsp;<?=$Aux->ElDato($moneda,"TipoMoneda","id","descripcion")?><input type="hidden" name="valor_neto" value="<?=$total?>"></td>
</tr>
<?php if($xtotal[3][0]>0){//Hay Dolares?>
<tr class="info" valign="top">
    <td  colspan="2">TOTAL NETO Dolares</td>
    <td></td>
    <?php
    $total_d=0;
    for($i=0;$i<$nropagos;$i++){
        $t = $xtotal[3][$i];
        $total_d+=$t;
        ?>
<td align="right" ><?=number_format($t,2,",",".")?></td>            
        <?php

    }
    ?>
    <td colspan="2" align="right">$<?=number_format($total_d,2,",",".")?>&nbsp;USD<input type="hidden" name="valor_neto_us" value="<?=$total_d?>"></td>
</tr>  
<?php }?>
<tr class="warning" valign="top">
    <td  colspan="2">TOTAL NETO $</td>
    <td></td>
    <?php

    for($i=0;$i<$nropagos;$i++){
        switch($moneda){
            case 1: $valor_ajuste = $lauf;break;
            case 2: $valor_ajuste = 1;break;
            case 3: $valor_ajuste = $dolas;break;    

        }
        $t = $xtotal[$moneda][$i] * $valor_ajuste ;
        ?>
<td align="right" ><?=($t>0)? "$".number_format($t,0,",","."):"---"?></td>
        <?php

    }
    ?>        
    <td colspan="2" align="right"><?=($total>0)?"$".number_format($total*$valor_ajuste,0,",","."):""?><input type="hidden" name="valor_neto_pesos" value="<?=$total*$lauf?>"></td>
</tr> 
<?php if($descuento>0){
            $porc_descuento = (((100-$descuento)/100));

    ?>
<tr class="hnavbg" valign="top">
    <td  colspan="2">Total con Descuento (<?=$descuento?>%)</td>
    <td></td>
    <?php

    for($i=0;$i<$nropagos;$i++){
        switch($moneda){
            case 1: $valor_ajuste = $lauf;break;
            case 2: $valor_ajuste = 1;break;
            case 3: $valor_ajuste = $dolas;break;    

        }
        $t = $xtotal[$moneda][$i] * $valor_ajuste ;
        ?>
<td align="right" ><?=($t>0)? "$".number_format($t*$porc_descuento,0,",","."):"---"?></td>
        <?php

    }
    ?>        
    <td colspan="2" align="right"><?=($total>0)?"$".number_format($total*$valor_ajuste*$porc_descuento,0,",","."):""?><input type="hidden" name="valor_neto_pesos" value="<?=$total*$lauf?>"></td>
</tr>         
<?php } else {
    $porc_descuento=1;
}
?>
<tr>
    <td colspan="<?=$i+5?>">
        <table width="100%" cellspacing="0" cellpadding="1">
            <tr valign="top">
            <td><!--Boleta de Honorarios -->
                <table class="table table-bordered table-striped">
                    <tr class="success">
                        <td colspan="<?=$nropagos+1?>">BOLETA DE HONORARIO
                        <td>TOTAL</td>
                    </tr>
                    <tr >
                        <td>Boleta Hono. Retenci&oacute;n 10%</td>
                        <?php
    for($i=0;$i<$nropagos;$i++){
        switch($moneda){
            case 1: $valor_ajuste = $lauf;break;
            case 2: $valor_ajuste = 1;break;
            case 3: $valor_ajuste = $dolas;break;    

        }            
        $t = $xtotal[$moneda][$i] * $valor_ajuste;
        ?>
<td align="right" ><?=number_format($t* $porc_descuento*((100/90)*0.1),0,",",".")?></td>                            
        <?php
    }
                        ?>
                        <td align="right"><?=number_format(($valor_ajuste*$total*$porc_descuento)*(100/90*0.1),0,",",".")?></td>
                    </tr>   
                    <tr valign="top">
                        <td>TOTAL + 10%</td>
                        <?php
    for($i=0;$i<$nropagos;$i++){
        switch($moneda){
            case 1: $valor_ajuste = $lauf;break;
            case 2: $valor_ajuste = 1;break;
            case 3: $valor_ajuste = $dolas;break;    

        }            
        $t = ($xtotal[$moneda][$i] * $valor_ajuste) * $porc_descuento ;
        ?>
    <td align="right" ><?=number_format($t*(100/90),0,",",".")?></td>
        <?php
    }
    $total_boleta = $valor_ajuste*$total;
                        ?>                            
                        <td align="right">$<?=number_format(($total_boleta*$porc_descuento)*(100/90),0,",",".")?></td>
                    </tr> 
                </table>
            </td>
            </tr>
            <tr>
            <td><!--Factura-->
                <table class="table table-bordered  table-striped">
                    <tr class="success">
                        <td colspan="<?=$nropagos+1?>">FACTURA
                        <td>TOTAL</td></tr>
                    <tr valign="top">
                        <td class="titulonegro12" >IVA</td>
                        <?php
    for($i=0;$i<$nropagos;$i++){
        switch($moneda){
            case 1: $valor_ajuste = $lauf;break;
            case 2: $valor_ajuste = 1;break;
            case 3: $valor_ajuste = $dolas;break;    

        }            
        $t = ($xtotal[$moneda][$i] * $valor_ajuste) * $porc_descuento;
        ?>
<td align="right" ><?=number_format(($t*1.19)-$t,0,",",".")?></td>                            
        <?php
    }
    $total_iva = ($valor_ajuste*$total)*$porc_descuento;
    ?>
                        <td align="right"><?=number_format(($total_iva*1.19)-$total_iva,0,",",".")?></td>
                    </tr>          
                    <tr  valign="top">
                        <td>TOTAL + iva</td>
                        <?php
    for($i=0;$i<$nropagos;$i++){
        switch($moneda){
            case 1: $valor_ajuste = $lauf;break;
            case 2: $valor_ajuste = 1;break;
            case 3: $valor_ajuste = $dolas;break;    

        }            
        $t = ($xtotal[$moneda][$i] * $valor_ajuste) * $porc_descuento;
        ?>
<td align="right" ><?=number_format($t*1.19,0,",",".")?></td>                            
        <?php
    }
    $total_final = $valor_ajuste*$total;
    ?>                            
                        <td align="right">$<?=number_format((($total_final*$porc_descuento)*1.19),0,",",".")?></td>
                    </tr>        

                </table>
            </td>
            </tr>
            <tr>
            <td ><!--Factura Exenta -->
                    <table class="table table-bordered table-striped">
                        <tr class="success">
                            <td colspan="<?=$nropagos+1?>">FACTURA EXENTA
                            <td>TOTAL</td></tr>

                        <tr  valign="top">
                            <td class="titulonegro12" >TOTAL</td>
                            <?php
        for($i=0;$i<$nropagos;$i++){
            switch($moneda){
                case 1: $valor_ajuste = $lauf;break;
                case 2: $valor_ajuste = 1;break;
                case 3: $valor_ajuste = $dolas;break;    

            }            
            $t = $xtotal[$moneda][$i] * $valor_ajuste *$porc_descuento;
            ?>
<td align="right" ><?=number_format($t,0,",",".")?></td>                            
            <?php
        }
        ?>                            
                            <td align="right">$<?=number_format($valor_ajuste*$total*$porc_descuento,0,",",".")?></td>
                        </tr>        

                    </table>
                </td>                
            </tr>
        </table>
    </td>
</tr>    
</table>
<input type="hidden" name="valor_total" id="valor_total" value="<?=$total?>">