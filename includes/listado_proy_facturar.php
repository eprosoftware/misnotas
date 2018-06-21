<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once str_replace("/includes","",getcwd()).'/cfgdir.php';
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd())."/includes/header.php";

    $Aux = new DBProyecto();
    
    $nro_proyecto = $_POST['nro_proyecto'];
    $estado = $_POST['estado'];
    $fechad = $_POST['fecha_desde'];
    $fechah = $_POST['fecha_hasta'];
    $ffechad = $_POST['ffecha_desde'];
    $ffechah = $_POST['ffecha_hasta'];
    $orden = $_POST['orden'];
    $tipo_orden = $_POST['tipo_orden'];
    
    $item_cobrados = $Aux->getItemPorFacturar($nro_proyecto,$estado,$fechad,$fechah,$ffechad,$ffechah,$orden,$tipo_orden);
    
    $losestados = $Aux->TraerLosDatos("EstadoFactura", "id", "descripcion");
    
    $losordenes=array();
    $tmp=array();$tmp['valor']=1;$tmp['txt']="Nro.Proyecto";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=2;$tmp['txt']="Fecha Procesado";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=3;$tmp['txt']="Fecha Facturado";$losordenes[]=$tmp;
    $lostiposO=array();
    $tmp=array();$tmp['valor']=1;$tmp['txt']="Ascendente";$lostiposO[]=$tmp;
    $tmp=array();$tmp['valor']=2;$tmp['txt']="Descendente";$lostiposO[]=$tmp;    
?>
<script>
function actualiza(id,p1,p2){ 
    requestPage('/includes/actualizaItemFacturar.php?id='+id+'&nro_factura='+p1+'&fecha_facturado='+p2,'act'+id);
}
</script>
<h1>Listado de Item Proyecto por Cobrar</h1>
<form action="/index.php?p=listado_proy_facturar" name="f" method="POST">
<table>
    <tr>
       <td class="celda_bordes">
            <table width="100%">
                <tr>
                    <td colspan="4">Fecha Proceso</td>
                    <td colspan="4">Fecha Facturado</td>
                </tr>
                <tr>
                    <td>Desde:</td>
                    <td><input name="fecha_desde" id="fecha_desde" size="12" type="text" value="<?=$fecha_desde?>" onkeypress="return dontKey(Event);">
<script language="JavaScript">
var A_CALTPL = {
    'months' : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    'weekdays' : ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
    'yearscroll': true,
    'weekstart': 1,
    'centyear'  : 70,
    'imgpath' : 'img/'
}
new tcal ({
    'controlname': 'fecha_desde'
},A_CALTPL );

</script></td>
                    <td>Hasta:</td>
                    <td><input name="fecha_hasta" id="fecha_hasta" size="12" type="text" value="<?=$fecha_hasta?>" onkeypress="return dontKey(Event);">
<script language="JavaScript">
var A_CALTPL = {
    'months' : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    'weekdays' : ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
    'yearscroll': true,
    'weekstart': 1,
    'centyear'  : 70,
    'imgpath' : 'img/'
}
new tcal ({
    'controlname': 'fecha_hasta'
},A_CALTPL );

</script></td>
                    <td>Desde:</td>
                    <td><input name="ffecha_desde" id="ffecha_desde" size="12" type="text" value="<?=$fecha_desde?>" onkeypress="return dontKey(Event);">
<script language="JavaScript">
var A_CALTPL = {
    'months' : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    'weekdays' : ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
    'yearscroll': true,
    'weekstart': 1,
    'centyear'  : 70,
    'imgpath' : 'img/'
}
new tcal ({
    'controlname': 'ffecha_desde'
},A_CALTPL );

</script></td>
                    <td>Hasta:</td>
                    <td><input name="ffecha_hasta" id="ffecha_hasta" size="12" type="text" value="<?=$fecha_hasta?>" onkeypress="return dontKey(Event);">
<script language="JavaScript">
var A_CALTPL = {
    'months' : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    'weekdays' : ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
    'yearscroll': true,
    'weekstart': 1,
    'centyear'  : 70,
    'imgpath' : 'img/'
}
new tcal ({
    'controlname': 'ffecha_hasta'
},A_CALTPL );

</script></td>                    
                </tr>                                    
            </table>
        </td>        
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>Nro. Proy:<input type="text" name="nro_proyecto" size="8" value="<?=$nro_proyecto?>"></td>
                    <td>Ordenar Por:</td>
                    <td><?=$Aux->SelectArrayBig($losordenes,"orden","Seleccione Orden",$orden)?></td>
                    <td><?=$Aux->SelectArrayBig($lostiposO,"tipo_orden","Sel. Tipo Orden",$tipo_orden)?></td>
                    <td>Filtrar Estado Factura: <?=$Aux->SelectArrayBig($losestados,"estado","Seleccione Estado",$estado)?></td>
                    <td><input type="submit" value="Aplicar Filtro" name="a"></td>     
                    <td><a href="/includes/csv_listado_proy_facturar.php?estado=<?=$estado?>&fechad=<?=$fechad?>&fechah=<?=$fechah?>&ffechad=<?=$ffechad?>&ffechah=<?=$ffechah?>&orden=<?=$orden?>&tipo_orden=<?=$tipo_orden?>">Descargar CSV</a></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>

    </tr>
    <tr><td class="celda_bordes">
<table>
    <tr class="hnavbg">
        <td class="tituloblanco12">Nro Proy</td>
        <td class="tituloblanco12">Proyecto</td>
        <td class="tituloblanco12" width="100">Fecha S.</td>
        <td class="tituloblanco12">Descripci&oacute;n</td>
        <td class="tituloblanco12">Moneda</td>
        <td class="tituloblanco12">Concepto</td>
        <td class="tituloblanco12">Monto</td>
        <td class="tituloblanco12">Estado Factura</td>
        <td class="tituloblanco12">Nro. Factura</td>
        <td class="tituloblanco12">Fecha Facturado</td>
        <td></td>
        <td></td>
    </tr>
    <?php
        $total_monto=0;
        for($i=0;$i<count($item_cobrados);$i++){
            $tmp = $item_cobrados[$i];
            $id = $tmp['id'];
            $fecha = $tmp['fecha_proceso'];
            $descripcion = $tmp['descripcion'];
            $concepto = $tmp['concepto'];
            switch($concepto){
                case 1: $st_concepto="ANTICIPO";break;
                case 2: $st_concepto="ENTREGA";break;
                case 3: $st_concepto="APROBADO";break;
            }
            $nro_proyecto = $tmp['nro_proyecto'];
            $nombre_proyecto = $Aux->ElDato($nro_proyecto,"Proyecto","nro_proyecto","nombre_proyecto");
            $moneda = $tmp['moneda'];
            $monto = $tmp['monto'];$total_monto+=$monto;
            $anticipo = $tmp['pago_anticipo'];
            $entrega = $tmp['pago_entrega'];
            $aprobado = $tmp['pago_aprobado'];
            $lamoneda = $Aux->ElDato($moneda,"TipoMoneda","id","descripcion");
            $estado = $tmp['estado_factura'];
            $elestado = $Aux->ElDato($estado,"EstadoFactura","id","descripcion");
            $fecha_facturado = $tmp['fecha_facturado'];
            $nro_factura = $tmp['nro_factura'];
            ?>
    <tr>
        <td><?=$nro_proyecto?></td>
        <td><?=$nombre_proyecto?></td>
        <td><?=$fecha?></td>
        <td><?=$descripcion?></td>
        <td><?=$lamoneda?></td>
        <td><?=$st_concepto?></td>
        <td align="right"><?=number_format($monto,2,",",".")?></td>
        <td><?=$elestado?></td>
        <td align="right"><?php if($estado==1){?>
            <input type="text" name="nro_factura_<?=$id?>" value="<?=$nro_factura?>" size="10">
        <?php } else if($estado==2){?>
            <?=number_format($nro_factura,0,",",".")?>
        <?php }?>
        </td>
        <td align="center"><?php if($estado==1){?>
            <input name="fecha_facturado_<?=$id?>" id="fecha_facturado_<?=$id?>" size="12" type="text" value="<?=$fecha_facturado?>" onkeypress="return dontKey(Event);">
<script language="JavaScript">
        var A_CALTPL = {
		'months' : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		'weekdays' : ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		'yearscroll': true,
		'weekstart': 1,
		'centyear'  : 70,
		'imgpath' : 'img/'
	}
	new tcal ({
		'controlname': 'fecha_facturado_<?=$id?>'
	},A_CALTPL );
        
        </script> <?php } else {?>
        <?=$fecha_facturado?>
        <?php }?>
        </td>
        <td><?php if($estado==1){?><input type="button" value="ACTUALIZA" name="b<?=$id?>" onclick="actualiza(<?=$id?>,document.f.nro_factura_<?=$id?>.value,document.f.fecha_facturado_<?=$id?>.value)"><?php }?></td>
        <td><div id="act<?=$id?>"></div></td>
    </tr>
    <?php
        }
    ?>
    <tr class="hnavbg">
        <td class="tituloblanco12" colspan="6">TOTAL</td>
        <td class="tituloblanco12" align="right"><?=number_format($total_monto,2,",",".")?></td>
        <td colspan="4"></td>
    </tr>
</table></td></tr></table>
</form>            