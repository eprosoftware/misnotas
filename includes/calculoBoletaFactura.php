<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once DIR.'/class/config.php';
include_once 'header.php';

$Aux = new DBCotizacion();
$i   = new Indicadores();

$monto    = $_POST['monto'];
$monto_uf = $_POST['monto_uf'];
$uf       = $_POST['uf'];

$uf = ($uf)?$uf:str_replace(",",".",$i->getUf());

if ($monto_uf>0){
    $mon_uf = $monto_uf * $uf;
    $monto_neto_boleta  = $monto_uf * (1/0.90);
    $monto_imp_boleta   = ($monto_uf *(1/0.90))* 0.10 ;
    $monto_iva_factura  = ($monto_uf * (1/0.81))*0.19;
    $monto_total_factura = ($monto_uf * (1/0.81)) ;
    $monto_doc          = $mon_uf;
} elseif($monto>0) {
    $monto_neto_boleta  = $monto * (1/0.90);
    $monto_imp_boleta   = ($monto *(1/0.90))* 0.10 ;
    $monto_iva_factura  = ($monto * (1/0.81))*0.19;
    $monto_total_factura = ($monto * (1/0.81)) ;
    $monto_doc          = $monto;
}
?>
<form action="/index.php?p=calculoBoletaFactura" method="POST">
<table class="table table-bordered table-striped">
    <tr>
        <td><h2>La UF de Hoy es:</h2></td>
        <td><h2>Ingrese Monto Total Boleta:</h2></td>
        <td><h2>Ingrese Monto Total UF:</h2></td>
    </tr>    
    <tr>
        <td><input type="text" size="10" name="uf" value="<?=$uf?>" style="border-radius: 10px;font-size: 23px;height: 30"></td>
        <td><input type="text" size="10" name="monto" value="<?=$monto?>" style="border-radius: 10px;font-size: 23px;height: 30"></td>
        <td><input type="text" size="10" name="monto_uf" value="<?=$monto_uf?>" style="border-radius: 10px;font-size: 23px;height: 30"></td>
    </tr>
    <tr>
        <td colspan="2"><input class="boton" type="submit" value="Realizar Calculo"></td>
    </tr>
    <?php if($monto || $monto_uf){?>
    <tr>
        <td colspan="3">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>
                        <table class="table table-bordered table-striped">
                            <tr><td colspan="2"><h2>Boleta Honorarios</h2></td></tr>
                            <tr class="titulonegro12">
                                <td>Total :</td><td><?=number_format($monto_neto_boleta,0,",",".")?> <?=($monto_uf>0)? "":""?></td>
                            </tr>
                            <tr class="titulonegro12">
                                <td>Impuesto (10%):</td><td><?=number_format($monto_imp_boleta,0,",",".")?></td>
                            </tr>    
                            <tr class="titulonegro12">
                                <td>Neto:</td><td><?=number_format($monto_doc,0,",",".")?></td>
                            </tr>                                
                        </table>
                    </td>
                    <td >
                        <table class="table table-bordered table-striped">
                            <tr><td colspan="2"><h2>Factura</h2></td></tr>
                            <tr class="titulonegro12">
                                <td>Total :</td><td><?=number_format($monto_total_factura,0,",",".")?></td>
                            </tr>
                            <tr class="titulonegro12">
                                <td>IVA (19%):</td><td><?=number_format($monto_iva_factura,0,",",".")?></td>
                            </tr>    
                            <tr class="titulonegro12">
                                <td>Neto:</td><td><?=number_format($monto_doc,0,",",".")?></td>
                            </tr>                                    
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <?php }?>
</table>
</form>