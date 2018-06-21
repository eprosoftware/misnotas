<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd()).'/includes/header.php';

$Aux = new DBCotizacion();

if(isset($nropagos)) {
    $nro_pagos=$nropagos;
} else {
    $nro_pagos = $_GET['nro_pagos'];
}

if(isset($ddel)){
    $per_del=$ddel;
} 
$lostipomoneda = $Aux->TraerLosDatos("TipoMoneda","id","descripcion");

?>
<!--NP:<?=$nro_pagos?>-->
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>C&oacute;digo</th>
        <th>Item</th>
        <th>Moneda</th>
        <th>Valor Total</th>
<?php
for($i=0;$i<$nro_pagos;$i++){
    ?>
        <th>P<?=$i+1?> %</th>
<?php
}
?>
        <th><input type="hidden" size="2" name="total_por"></th>
        <th></th>
    </tr>
    </thead>
    <tr valign="top">
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr valign="center">
                    <td><input type="text" size="6" name="codigo" onkeydown="buscarCodigo(this.value);" onblur="document.f.valor.focus();this.value = this.value.toUpperCase();" class="form-control"><br></td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr><td><a href="javascript:layerTabla();"><i class="glyphicon glyphicon-search"></i></a><div id="tabla_codigos" class="tabla_codigos" style="display: none;z-index:10;position:absolute;float:left;"></div></td>
                            <td><a href="javascript:agregar_codigo();"><i class="glyphicon glyphicon-plus"></i></a></td></td><td><div id="salida_codigo"></div></td></tr>                                        
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td><div id="item_div"><textarea class="form-control" rows="3" name="str_item" onblur="this.value = this.value.toUpperCase();"></textarea></div></td>
        <td><?=$Aux->SelectArray($lostipomoneda, "tipo_moneda", "---", $tipo_moneda);?></td>
        <td><input type="text" id="valor" name="valor"  class="form-control"></td>    
<?php
for($i=0; $i<$nro_pagos;$i++){
    ?>
        <td><input type="text"  class="form-control" id="p<?=$i+1?>" onblur="actualiza_por_new(<?=$nro_pagos?>,<?=$i+1?>);">
            <br><input type="text" id="v<?=$i+1?>" size="6" disabled> </td>
<?php 
}
?>
        <td><input type="text" id="tot_por" disabled size="3"></td>
        <td>
            <table width="100%">
                <tr>
                    <td><button type="button" class="btn btn-primary" onclick="nuevo_item(<?=$per_del?>);">Agregar Item</button></td>
                    <td><div id="salida_cotiza2"></div></td>
                </tr>
            </table>

        </td>
    </tr>
</table>