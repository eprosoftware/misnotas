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
    
    $nro  = $_GET['nro'];
    $lauf = $_GET['lauf'];
    $tipo_doc = $_GET['tipo_doc'];
    $eldetalle = $Aux->getItem("",$nro);
    
    ?>
<table width="100%" align="center" cellspacing='0' cellpadding='0'>
    <tr class='hnavbg'><td class="celda_bordes">
    <table width="100%" cellspacing='1' cellpadding='2'>
    <tr class="hnavbg">
        <td class="tituloblanco12">Codigo</td>
        <td class="tituloblanco12">Item</td>
        <td class="tituloblanco12">Moneda</td>
        <td class="tituloblanco12">P1</td>
        <td class="tituloblanco12">P2</td>
        <td class="tituloblanco12">P3</td>
        <td class="tituloblanco12">Total Item</td>
    </tr>
    <?php
    $total = 0;$total_anticipo =0;$total_entregado=0;$total_aprobado=0;
    $color="";
    for($i=0;$i<count($eldetalle);$i++){
        $tmp = $eldetalle[$i];
        $id_cot = $tmp->getId();
        $nro_cot = $tmp->getNroCotizacion();
        $codigo = $tmp->getCodigo();
        $item = $Aux->convertir_especiales_html($tmp->getItem());
        $moneda = $tmp->getTipoMoneda();
        $lamoneda = $Aux->ElDato($moneda,"TipoMoneda","id","descripcion");
        $valor_total = $tmp->getValorTotal();
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
    <tr <?=$Aux->rowEffect($i, $color)?> >
        <td bgcolor="<?=$color?>"><?=$codigo?></td>
        <td bgcolor="<?=$color?>"><?=$item?></td>
        <td bgcolor="<?=$color?>" align="center"><?=$lamoneda?></td>
        <td bgcolor="<?=$color?>" align="right"><?=$anticipo?> (<?=$por_anticipo?>%)</td>
        <td bgcolor="<?=$color?>" align="right"><?=$entrega?> (<?=$por_entrega?>%)</td>
        <td bgcolor="<?=$color?>" align="right"><?=$aprobado?> (<?=$por_aprobado?>%)</td>
        <td bgcolor="<?=$color?>" align="right"><?=$valor_total?></td>
    </tr>
    <?php
    }
    ?>
    <tr><td colspan="7"><hr></td></tr>    
    <tr valign="top">
        <td class="titulonegro12" colspan="3" align="right">NETO :</td>
        <td class="titulonegro12" align="right" ><?=number_format($total_anticipo,2,",",".")?></td>
        <td class="titulonegro12" align="right" ><?=number_format($total_entregado,2,",",".")?></td>
        <td class="titulonegro12" align="right" ><?=number_format($total_aprobado,2,",",".")?></td>
        <td class="titulonegro12" align="right"><?=number_format($total,2,",",".")?>&nbsp;UF<input type="hidden" name="valor_neto" value="<?=$total?>"></td>
    </tr>
    <tr valign="top">
        <td class="titulonegro12" colspan="3" align="right">NETO ($):</td>
        <td class="titulonegro12" align="right" ><?=($total_anticipo>0)? "$".number_format($total_anticipo*$lauf,0,",","."):""?></td>
        <td class="titulonegro12" align="right" ><?=($total_entregado>0)?"$".number_format($total_entregado*$lauf,0,",","."):""?></td>
        <td class="titulonegro12" align="right" ><?=($total_aprobado>0)?"$".number_format($total_aprobado*$lauf,0,",","."):""?></td>
        <td class="titulonegro12" align="right"><?=($total>0)?"$".number_format($total*$lauf,0,",","."):""?><input type="hidden" name="valor_neto_pesos" value="<?=$total*$lauf?>"></td>
    </tr>    
<?php if($tipo_doc==1){?>
    <tr>
        <td class="titulonegro12" colspan="3" align="right">Boleta Hono. Retenci&oacute;n 10% :</td>
        <td class="titulonegro12" align="right" ><?=number_format($lauf*$total_anticipo*0.10,0,",",".")?></td>
        <td class="titulonegro12" align="right" ><?=number_format($lauf*$total_entregado*0.10,0,",",".")?></td>
        <td class="titulonegro12" align="right" ><?=number_format($lauf*$total_aprobado*0.10,0,",",".")?></td>
        <td class="titulonegro12" align="right"><?=number_format($lauf*$total*0.10,0,",",".")?></td>
    </tr>   
    <tr valign="top">
        <td class="titulonegro12" colspan="3" align="right">TOTAL + 10%</td>
        <td class="titulonegro12" align="right" ><?=number_format($lauf*$total_anticipo*1.10,0,",",".")?></td>
        <td class="titulonegro12" align="right" ><?=number_format($lauf*$total_entregado*1.10,0,",",".")?></td>
        <td class="titulonegro12" align="right" ><?=number_format($lauf*$total_aprobado*1.10,0,",",".")?></td>
        <td class="titulonegro12" align="right">$<?=number_format($lauf*$total*1.10,0,",",".")?></td>
    </tr> 
<?php } elseif ($tipo_doc==2){ //FACTURA?>
    <tr valign="top">
        <td class="titulonegro12" colspan="3" align="right">IVA:</td>
        <td class="titulonegro12" align="right" ><?=number_format($lauf*$total_anticipo*0.19,0,",",".")?></td>
        <td class="titulonegro12" align="right" ><?=number_format($lauf*$total_entregado*0.19,0,",",".")?></td>
        <td class="titulonegro12" align="right" ><?=number_format($lauf*$total_aprobado*0.19,0,",",".")?></td>
        <td class="titulonegro12" align="right"><?=number_format($lauf*$total*0.19,0,",",".")?></td>
    </tr>          
    <tr valign="top">
        <td class="titulonegro12" align="right" align="right" colspan="3">TOTAL + IVA :</td>
        <td class="titulonegro12" align="right" ><?=number_format($lauf*$total_anticipo*1.19,0,",",".")?></td>
        <td class="titulonegro12" align="right" ><?=number_format($lauf*$total_entregado*1.19,0,",",".")?></td>
        <td class="titulonegro12" align="right" ><?=number_format($lauf*$total_aprobado*1.19,0,",",".")?></td>
        <td class="titulonegro12" align="right">$<?=number_format($lauf*$total*1.19,0,",",".")?></td>
    </tr>        

<?php }?>



            
   

    </table></td></tr></table>