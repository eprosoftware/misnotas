<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/session.php';    
include_once '../class/config.php';
include_once 'header.php';

    $Aux = new DBProyecto();
    
    $nro_proyecto   = $_POST['nro_proyecto'];
    $item           = $_POST['item'];
    $cod_despacho   = $_POST['cod_despacho'];
    $fecha_desde    = $_POST['fecha_desde'];
    $fecha_hasta    = $_POST['fecha_hasta'];
    $orden          = $_POST['orden'];
    $tipo_orden     = $_POST['tipo_orden'];
    
    $losdespachos = $Aux->getDespachos("",$nro_proyecto,$item,$cod_despacho,$fecha_desde,$fecha_hasta,$orden,$tipo_orden);
    $lositems = $Aux->TraerLosDatos("Codigos","cod","concat('(',cod,')',descripcion)");
    $loscoddespachos = $Aux->TraerLosDatos("CodigosDespacho","cod","concat('(',cod,')',descripcion)");
    $losordenes=array();
    $tmp=array();$tmp['valor']=1;$tmp['txt']="Nro.Proyecto";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=2;$tmp['txt']="Item";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=3;$tmp['txt']="Cod. Despacho";$losordenes[]=$tmp;
    $lostiposO=array();
    $tmp=array();$tmp['valor']=1;$tmp['txt']="Asc";$lostiposO[]=$tmp;
    $tmp=array();$tmp['valor']=2;$tmp['txt']="Desc";$lostiposO[]=$tmp;    
    
    $dir = "/home/eroman/desa/syspavimentos/";
    //$dir = "/home/syspav/";
    $tick = $Aux->ticks();
    $fp = fopen("$dir/lib_archivos/list_desp_$tick.csv","a");
        ?>
<table>
    <tr>
        <td>Despachos</td>
    </tr>
    <tr>
        <td class="celda_bordes">
            <form action="/index.php?p=listado_despachos" method="POST" name="f">
            <table>
                <tr>
                    <td >Nro. Proyecto:<input type="text" size="5" name="nro_proyecto" value="<?=$nro_proyecto?>"></td>
                    <td>Ordenar Por:<?=$Aux->SelectArrayBig($losordenes,"orden","Seleccione Orden",$orden)?><?=$Aux->SelectArrayBig($lostiposO,"tipo_orden","Sel. Tipo Orden",$tipo_orden)?>
                    </td>
                </tr>
                <tr>
                    <td>Item:<?=$Aux->SelectArrayBig($lositems,"item","---",$item)?></td>
                    <td>Cod. Despacho:<?=$Aux->SelectArrayBig($loscoddespachos,"cod_despacho","---",$cod_despacho)?></td>
                </tr>
                <tr>
                    <td colspan="2">Fecha Despacho Desde:<input name="fecha_desde" id="fecha_desde" size="12" type="text" value="<?=$fecha_desde?>" >
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
        
        </script> Hasta: <input name="fecha_hasta" id="fecha_hasta" size="12" type="text" value="<?=$fecha_hasta?>" >
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
                </tr>
                <tr>
                    <td><input type="submit" value="Aplicar Filtro"></td>
                    <td><a href="/lib_archivos/list_desp_<?=$tick?>.csv">Descarga CSV</a></td>
                </tr>
            </table>
            </form>
        </td>
    </tr>
    <tr>
        <td class="celda_bordes">
<?php if(count($losdespachos)>0){ ?> 
<table width="100%">
    <tr class="hnavbg">
        <td class="tituloblanco12">Fecha<br>Despacho</td>
        <td class="tituloblanco12">Dias<br>Transcurridos</td>
        <td class="tituloblanco12">Nro Proyecto</td>
        <td class="tituloblanco12">Item</td>
        <td class="tituloblanco12">C&oacute;digo<br>Despacho</td>
        <td class="tituloblanco12">Fecha<br>Aprobacion</td>
        <td class="tituloblanco12">Estado</td>
        <td class="tituloblanco12">Despachado<br>Por</td>
        <td class="tituloblanco12">Editar</td>
    </tr>
    <?php
    for($i=0;$i<count($losdespachos);$i++){
        $tmp = $losdespachos[$i];
        $id=$tmp['id'];
        $fecha_despacho = $tmp['fecha_despacho'];
        $dias_trans = $tmp['dias_trans'];
        $nro_proyecto = $tmp['nro_proyecto'];
        $item = $tmp['id_itemproyecto'];
        $codigo_despacho = $tmp['codigo_despacho'];
        $fecha_aproba = $tmp['fecha_aprobacion'];
        $estado = $tmp['estado_despacho'];
        $elestado = $Aux->ElDato($estado,"EstadoDespacho","id","descripcion");
        $quien = $tmp['quien_despacha'];
        $quien_despacha = $Aux->ElDato($quien,"Usuarios","id","nombre");
        $color = $Aux->flipcolor($color);
        ?>
    <tr bgcolor="<?=$color?>">
        <td><?=$fecha_despacho?></td>
        <td align="right"><?=$dias_trans?></td>
        <td align="right"><?=$nro_proyecto?></td>
        <td><?=$item?></td>
        <td><?=$codigo_despacho?></td>
        <td><?=$fecha_aproba?></td>
        <td><?=$elestado?></td>
        <td><?=$quien_despacha?></td>
        <td><?php if($estado!=2){?><input type="button" value="Editar" onclick="openWindow('/includes/nuevo_despacho.php?id=<?=$id?>&nro_proyecto=<?=$nro_proyecto?>','Despacho<?=$id?>',800,300)" class="boton"><?php }?></td>
    </tr>
    <?php
        $sp = ";";
        $linea=$fecha_despacho.$sp.$dias_trans.$sp.$nro_proyecto.$sp;
        $linea.=$item.$sp.$codigo_despacho.$sp.$fecha_aproba.$sp;
        $linea.=$elestado.$sp.$quien_despacha."\n";
        fwrite($fp,$linea);
    }
    fclose($fp);
    ?>
</table>
<?php }?>            
        </td>
    </tr>
</table>
