<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../class/session.php';
include '../class/config.php';

$valor=$_GET['valor'];

$Aux = new DBProyecto();

if(is_numeric($valor)){
    $nro_proyecto=$valor;
    $a = $Aux->get("",$nro_proyecto);$p=$a[0];
} else {
    $descripcion = $valor;
    $a = $Aux->get("","","","",$descripcion);$p=$a[0];
}



if(count($a)>0){?>
<table width="100%">
    <tr>
        <td>Nro.Proyecto:<?=$p->getNroProyecto()?></td>
        <td bgcolor="yellow"><?=str_replace($descripcion,"<font color='red'>$descripcion</font>",$p->getNombreProyecto());?></td>        
    </tr>
    <tr>
        <td>Nro.Proyecto:</td>
        <td><input type="text" name="nro_proyecto" value="<?=$p->getNroProyecto();?>" onchange="buscar_proyecto(this.value)" size="6"></td>
    </tr>
</table>
<?php
} else {?>
<table width="100%">
    <tr>
        <td colspan="2"><b><font color="darkred">No se encontro proyecto</font></b></td>
    </tr>
    <tr>
        <td>Nro.Proyecto:</td>
        <td><input type="text" name="nro_proyecto" onchange="buscar_proyecto(this.value)" size="6"></td>
    </tr>
</table>    
    <?php
}
    