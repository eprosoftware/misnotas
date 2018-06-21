<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/config.php';

    $Aux = new DBProyecto();
    
    $nro = (isset($nro))?$nro:$_GET['nro'];
    $id_item_proyecto (isset($id_item_proyecto))?$id_item_proyecto:$_GET['id_item_proyecto'];
    $lauf =(isset($lauf))?$lauf: $_GET['lauf'];
    $eldetalle = $Aux->getPedidos("",$id_item_proyecto,$nro);
    
    ?>
<table width="100%" align="center">
    <tr><td class="celda_bordes">
    <table width="100%">
    <tr class="hnavbg">
        <td class="tituloblanco12">Fecha P.</td>
        <td class="tituloblanco12">Codigo</td>
        <td class="tituloblanco12">Item</td>
        <td class="tituloblanco12">Comentario</td>
        <td class="tituloblanco12">Fecha Recepci&oacute;n</td>
        <td class="tituloblanco12">Ticket Conformidad</td>
        <td colspan="2"></td>
    </tr>
    <?php
    $total = 0;$total_anticipo =0;$total_entregado=0;$total_aprobado=0;
    for($i=0;$i<count($eldetalle);$i++){
        $tmp = $eldetalle[$i];
        $id_ped = $tmp->getId();
        $fecha = $tmp->getFecha();
        $nro_proy = $tmp->getNroProyecto();
        $codigo = $tmp->getCodigo();
        $item = $tmp->getItem();
        $comentario = $tmp->getComentario();
        $fecha_recepcion = $tmp->getFechaRecepcion();
        $ticket_conformidad = $tmp->getMarcaConformidad();
        $usuario_conformidad = $tmp->getUsuarioConformidad();
        $elusuario = $Aux->ElDato($usuario_conformidad,"Usuarios","id","nombre");
        
        $total+=$valor_total;
        $color=$Aux->flipcolor($color);
        $dias = $Aux->dateDiff($fecha,date("Y-m-d"));
        if($dias>30){
            $fi="<font color='blue'><b>";
            $ff="</b></font>";            
        } else if($dias>21){
            $fi="<font color='darkred'><b>";
            $ff="</b></font>";            
        } else if($dias>15) {
            $fi="<font color='green'><b>";
            $ff="</b></font>";
        } else {
            $fi="";
            $ff="";            
        }        
        ?>
    <tr <?=$Aux->rowEffect($i, $color)?> >
        <td bgcolor="<?=$color?>"><?=$fi.$fecha.$ff?>(<?=$dias?>)</td>
        <td bgcolor="<?=$color?>"><?=$codigo?></td>
        <td bgcolor="<?=$color?>"><?=$item?></td>
        <td bgcolor="<?=$color?>"><?=$comentario?></td>
        <td bgcolor="<?=$color?>"><?=$fecha_recepcion?></td>
        <td bgcolor="<?=$color?>" align="center"><?php if($ticket_conformidad!=1){?>
            <input type="button" name="b<?=$id_ped?>" value="Dar Conformidad" onclick="dar_conformidad(<?=$id_ped?>)">
    <?php } else if($ticket_conformidad==1){?>
            <img src="/images/tick2.gif" border="0">(<?=$elusuario?>)
    <?php } else {?>
            ----
            <?php }?>
        </td>
        <td bgcolor="<?=$color?>"><?=$Aux->deleteEffect($id_ped, $id_ped)?></td><td><div id="ped<?=$id_ped?>"></div></td>
    </tr>
    <?php
    }
    ?>
    </table></td></tr>
</table>