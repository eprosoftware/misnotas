<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once str_replace("/includes","",getcwd()).'/cfgdir.php';
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd()).'/includes/header.php';

    $Aux = new DBProyecto();
    $Cot = new DBCotizacion();
    $dbuser = new DBUsuario();

    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    $user = $dbuser->ElUsuario($id_user);
    $tipo = $user->getTipoUsuario();
    $eltipo = $Aux->ElDato($tipo,"TipoUsuario","id","descripcion");

    //$nro = $_GET['nro'];
    //$lauf = $_GET['lauf'];
    $eldetalle = $Aux->getItem("",$nro);

    $ax = $Aux->get("",$nro); $a = $ax['salida'];$p=$a[0];
    $tipo_proyecto = $p->getTipoProyecto();
    $bx = $Cot->get("",$nro); $b = $bx['salida'];$c =$b[0];
    $nro_pagos = $c->getNroPagos();
    
    $losestados = $Aux->ElDato($tipo_proyecto,"TipoProyecto","id","estados");
    $xestados = explode(",",$losestados);    
?>
<table class="table table-bordered table-striped">
<tr>
    <th>Codigo</th>
    <th>Item</th>
    <th></th>  
    <th>Estado</th>
    <?php
    for($j=0;$j<$nro_pagos;$j++){
        ?>
    <th>EP<?=$j+1?></th>
    <?php
    }
    ?>
    <th>%<br>Cob</th>
</tr>
<?php
$total = 0;$total_anticipo =0;$total_entregado=0;$total_aprobado=0;
$total_dtc=0;$total_dt=0;
for($i=0;$i<count($eldetalle);$i++){
    $tmp = $eldetalle[$i];
    $id_item = $tmp->getId();
    $estado_item = utf8_encode($tmp->getEstado());

    $nro_proy = $tmp->getNroProyecto();
    $codigo = $tmp->getCodigo();
    $item = $tmp->getItem();
    $ep = $tmp->getEP();
    $moneda = $tmp->getTipoMoneda();
    $lamoneda = $Aux->ElDato($moneda,"TipoMoneda","id","descripcion");
    $valor_total = $tmp->getValorItem();


    $total+=$valor_total;
    $color=$Aux->flipcolor($color);
    $xmarca = explode(",",$tmp->getEP());
    ?>
<tr <?=$Aux->rowEffect($i, $color)?> >
    <td><?=$codigo?></td>
    <td><?=$item?></td>
    <td align="right"><?=number_format($valor_total,2,",",".")?></td>        
    <td align="right"><?=$estado_item?></td>        
    <?php
    for($j=0;$j<$nro_pagos;$j++){
        ?>
    <td align="right">
    <?php
        if($xmarca[$j]=="1"){
            ?><img src="<?=$base_dir?>/images/tick2.gif" border="0"><?php
        }

    }
    ?>        <td align="right"><?=$por_cobrado?></td>
    <td><div id="salida_item<?=$id_item?>"></div></td>
</tr>
<tr>
    <td></td>
    <td colspan="14">
        <?php
        echo $Aux->showPedidos($id_item, $lauf);
        ?>
    </td>
</tr>
<?php
}
?>
<tr valign="top">
    <td colspan="2"></td>
    <td align="right"><?=number_format($total_dtc,0,",",".")?></td>
    <td align="right"><?=number_format($total_dt,0,",",".")?></td>
    <td colspan="12">&nbsp;</td>
</tr>    
</table>
        
