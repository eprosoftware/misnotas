<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$nro = $_GET['nro'];
if ($nrop) $nro=$nrop;

include_once str_replace("/includes","",getcwd()).'/cfgdir.php';
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd())."/includes/header.php";

    $Aux = new DBProyecto();
    $Cot = new DBCotizacion();
    
    $dbuser = new DBUsuario();
    
    $Aux->conecta_pdo();
    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    
    $user = $dbuser->ElUsuario($id_user);
    $puede_despachar    = $user->getDespachar();
    $eliminar_itemproy  = $user->getEliminarItemProyecto();
    $pagos_oc_hes       = $user->getEstadosPagoOC_HES();
    $editar_item_proy   = $user->getEditarItemProyectos();
    
    
    $tipo = $user->getTipoUsuario();
    $eltipo = $Aux->ElDato($tipo,"TipoUsuario","id","descripcion");

    
    $ax = $Aux->get("",$nro); $a = $ax['salida'];$p=$a[0];
    $tipo_proyecto = $p->getTipoProyecto();
    $bx = $Cot->get("",$nro); $b=$bx['salida'];$c =$b[0];
    $nro_pagos = $c->getNroPagos();
    
    
    $losestados = $Aux->ElDato($tipo_proyecto,"TipoProyecto","id","estados");
    $xestados = explode(",",$losestados);
    
    $eldetalle = $Aux->getItem("",$nro);
    
?>
<div id="out_det"></div>
<table class="table table-bordered table-striped">
<tr>
    <th>Cod</th>
    <th>Item</th>
    <th>Valor</th>
    <th>Estado</th>

    <?php
    for($j=0;$j<$nro_pagos;$j++){
        ?>
    <th>EP<?=$j+1?></th>
    <?php
    }
    ?>
    <th>%<br>Cob</th>
    <th colspan="2"></th>
</tr>
<?php
$total = 0;$total_anticipo =0;$total_entregado=0;$total_aprobado=0;
$total_dtc=0;$total_dt=0;

for($i=0;$i<count($eldetalle);$i++){
    $tmp = $eldetalle[$i];
    $id_item = $tmp->getId();
    $estado = $tmp->getEstado();

    $nro_proy = $tmp->getNroProyecto();
    $codigo = $tmp->getCodigo();
    $item = $Aux->cleanHTMLChar($tmp->getItem());
    $ep = $tmp->getEP();

    $moneda = $tmp->getTipoMoneda();
    $lamoneda = $Aux->ElDato($moneda,"TipoMoneda","id","descripcion");
    $valor_total = $tmp->getValorItem();


    $por_cobrado = 0;

    $total+=$valor_total;
    $id_estado_despacho = $Aux->ElDato($nro_proy,"Despacho","nro_proyecto","estado_despacho"," id_itemproyecto='$codigo'");
    //$estado_despacho = $Aux->ElDato($id_estado_despacho,"EstadoDespacho","id","descripcion");
    $color=$Aux->flipcolor($color);
    $xmarca = explode(",",$tmp->getEP());
    //echo "<P>EP:".$tmp->getEP()."<P>";
    ?>
<tr>
    <td><?=$codigo?></td>
    <td><?=$item?></td>
    <td align="right"><?=number_format($valor_total,2,",",".")?></td>
    <td><?=$estado?> - <?=$Aux->getEstadosTipoProyecto($tipo_proyecto,"estado","$estado", $id_item,$base_dir)?></td>


    <?php
    for($j=0;$j<$nro_pagos;$j++){
        ?>
    <td align="right"><input type="button" size="3" name="ep_<?=$id_item?>" value =" " onclick="marca_ep(<?=$j?>,<?=$id_item?>)">
    <?php
        if($xmarca[$j]=="1"){
            ?><img src="<?=$base_dir?>/images/tick2.gif" border="0"><?php
        }

    }
    ?>
    </td>
    <td align="right"><?=$por_cobrado?></td>

    <td><div id="salida_item<?=$id_item?>"></div></td>
    <td>
        <table>
            <tr>
                <td><?php if($finalizado!=1){?><button onclick="agregarPedido(<?=$id_item?>)" class="btn btn-primary">Agregar Pedido</button><?php }?></td>
            </tr>
            <tr>
                <td><?php if($puede_despachar==1){?><button onclick="pedirDespacho(<?=$nro_proy?>,'<?=$codigo?>')" class="btn btn-primary">Pedir Despacho</button><?php }?></td>
                <?php if ($id_estado_despacho){?>
                <td><button onclick="verDespacho(<?=$nro_proy?>,'<?=$codigo?>',<?=$i?>)" class="btn btn-primary">ver Despachos</button></td>
                <?php }?>
            </tr>
            <?php if($editar_item_proy==1){?>
            <tr>
                <td><button class="btn btn-primary" onclick="editarItem(<?=$id_item?>)">Editar</button></td>
            </tr>
            <?php }?>
            <tr>
                <td><?php if($eliminar_itemproy==1){?><button onclick="if(confirm('Esta seguro?')) eliminar_itemproy(<?=$nro_proy?>,<?=$id_item?>);" class="btn btn-danger">Eliminar</button><?php }?></td>
                <td><div id="salida_det<?=$id_item?>"></div></td>
            </tr>
        </table>
    </td>

</tr>
<tr>
    <td></td><td colspan="19"><div id="detalle_<?=$i;?>"></div></td>
</tr>
<tr>
    <td></td>
    <td colspan="19"  class="celda_bordes">
        <?php
        echo $Aux->showPedidos($id_item, $lauf);
        ?>
    </td>
</tr>
<?php
}
?>
<tr class="hnavbg" valign="top">
    <td colspan="2"></td>
    <td align="right"><?=$total_dtc?></td>
    <td  align="right"><?=$total_dt?></td>
    <td colspan="16">&nbsp;</td>
</tr>
</table>