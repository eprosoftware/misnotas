<?php

/* 
 * Listado de Items por Proyectos
 * Filtros 
 * 
 */

include_once str_replace("/includes","",getcwd()).'/cfgdir.php';
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd())."/includes/header.php";

    $Aux = new DBProyecto();
    $dbuser = new DBUsuario();
    
    $Aux->conecta_pdo();
    
    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    $user = $dbuser->ElUsuario($id_user);    
    
    $editar_proy = $user->getEditarProyectos();
    
    $jefe           = ($_GET['jefe'])?$_GET['jefe']:$_POST['jefe'];
    $encargado      = ($_GET['encargado'])?$_GET['encargado']:$_POST['encargado'];
    $orden          = ($_GET['orden'])?$_GET['orden']:$_POST['orden'];
    $tipo_orden     = ($_GET['tipo_orden'])?$_GET['tipo_orden']:$_POST['tipo_orden'];
    $por_cobrado    = ($_GET['por_cobrado'])?$_GET['por_cobrado']:$_POST['por_cobrado'];
    $taller         = ($_GET['taller'])?$_GET['taller']:$_POST['taller'];
    $taller_segui   = ($_GET['taller_segui'])?$_GET['taller_segui']:$_POST['taller_segui'];
    $solo_segui     = ($_GET['solo_segui'])?$_GET['solo_segui']:$_POST['solo_segui'];
    $finalizado     = ($_GET['finalizado'])?$_GET['finalizado']:$_POST['finalizado'];
    $oc             = ($_GET['oc'])?$_GET['oc']:$_POST['oc'];
    $hes            = ($_GET['hes'])?$_GET['hes']:$_POST['hes'];
    
    $sql = "select distinct porcentaje_pagado+0 p from ItemProyecto order by p desc";
    $rs = $Aux->query_pdo($sql);
    if($rs){
        $losporcentajes = array();
        foreach($rs as $row){
            $tmp=array();
            $tmp['txt']=$row[0];
            $tmp['valor']=$row[0];
            $losporcentajes[]=$tmp;
        }
    }
    
    $sql = "select a.nro_proyecto,a.nombre_proyecto,b.item_contratado,b.valor_item,"
            . "(select jefe from Usuarios where id=proyectista_asignado) jefe ,"
            . "a.proyectista_asignado,taller,seguimiento_taller,solo_seguimiento,finalizado,"
            . "oc,hes,ep1,ep2,ep3,porcentaje_pagado,pago_anticipo,pago_entrega,pago_aprobacion"
            
            . "from Proyecto a,ItemProyecto b "
            . "where a.nro_proyecto=b.nro_proyecto and a.estado<3 ";
    if($jefe) $sql.= " and getJefe(a.proyectista_asignado)=$jefe ";
    if($encargado) $sql.= " and a.proyectista_asignado=$encargado";
    if($por_cobrado) $sql.=" and b.porcentaje_pagado = '$por_cobrado' ";
    
    $xsql=array();
    if($taller=="on")       $xsql[]= "b.taller=1";
    if($taller_segui=="on") $xsql[]= "b.seguimiento_taller=1";
    if($solo_segui=="on")   $xsql[]= "b.solo_seguimiento=1";
    if($finalizado=="on")   $xsql[]= "b.finalizado=1";
    if($oc=="on")           $xsql[]= "b.oc==1";
    if($hes=="on")          $xsql[]="hes==1";
    
    if($taller||$taller_segui||$solo_segui||$oc||$hes||$finalizado)
        $sql.= " and (".implode(" or ",$xsql).")";
    
    
    //echo "<p>TALLER: ".$taller."</p>";
    if($orden){
        switch($orden){
            case 1:$sql.=" order by a.nro_proyecto";break;
            case 2:$sql.=" order by b.item_contratado";break;
            case 3:$sql.=" order by getJefe(a.proyectista_asignado)";break;
            case 4:$sql.=" order by a.proyectista_asignado";break;
            case 5:$sql.=" order by DTA";break;
            case 6:$sql.=" order by DTC";break;
        }
    }
    if($orden && $tipo_orden){
        switch($tipo_orden){
            case 1: $sql.=" asc";break;
            case 2: $sql.=" desc";break;
        }            
    }
    //echo "<p>SQL: $sql </p>";    
    
    $rs = $Aux->query_pdo($sql);
    $losjefes = $Aux->TraerLosDatos("Usuarios","id","nombre", " where tipo_usuario in (2,3)");
    if($jefe)
        $losproyectistas = $Aux->TraerLosDatos("Usuarios","id","nombre", " where tipo_usuario>2 and jefe=$jefe");
    else
        $losproyectistas = $Aux->TraerLosDatos("Usuarios","id","nombre", " where tipo_usuario>2 ");
    $losordenes=array();
    $tmp=array();$tmp['valor']=1;$tmp['txt']="Nro.Proyecto";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=2;$tmp['txt']="Item";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=3;$tmp['txt']="Jefe";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=4;$tmp['txt']="Proyectista";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=5;$tmp['txt']="Dias Taller Abiertos";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=6;$tmp['txt']="Dias Taller Cerrados";$losordenes[]=$tmp;
    $lostiposO=array();
    $tmp=array();$tmp['valor']=1;$tmp['txt']="&UpArrow; Asc";$lostiposO[]=$tmp;
    $tmp=array();$tmp['valor']=2;$tmp['txt']="&DownArrow; Desc";$lostiposO[]=$tmp;
?>
<script>
    function descargar_archivo(){
        p = document.f.encargado.options[document.f.encargado.selectedIndex].value;
        o = document.f.orden.options[document.f.orden.selectedIndex].value;
        to = document.f.tipo_orden.options[document.f.tipo_orden.selectedIndex].value;
        por = document.f.por_cobrado.options[document.f.por_cobrado.selectedIndex].value;
        t = document.f.taller.value;
        st = document.f.seguimiento_taller.value;
        ss = document.f.solo_segui.value;
        f = document.f.finalizado.value;
        oc = document.f.oc.value;
        hes = document.f.hes.value;
        document.location="/includes/csv_listado_item_proyectos.php?encargado="+p+"&orden="+o+"&tipo_orden="+to+"&por_cobrado="+por+"&taller="+t+"&taller_segui="+st+"&solo_segui="+ss+"&finalizado="+f+"&oc="+oc+"&hes="+hes;
    }
</script>
<table cellspacing="1"  cellpadding="0">
    <tr>
        <td colspan="16"><h1>Listado Item Proyectos</h1></td>
    </tr>
    <tr>
        <td colspan="16">
            <form name="f" action="/index.php?p=listado_item_proyectos" method="POST">
            <table>
                <tr>
                    <td>Jefe</td>
                    <td>Proyectista</td>
                    <td colspan="2">Ordenar Por</td>
                </tr>
                <tr>
                    <td><?=$Aux->SelectArrayBig($losjefes,"jefe","----",$jefe,"","requestPage('/includes/losproyectistas.php?jefe='+this.value,'proyectista_div')")?></td>
                    <td><div id="proyectista_div"><?=$Aux->SelectArrayBig($losproyectistas,"encargado","----",$encargado)?></div></td>
                    <td><?=$Aux->SelectArrayBig($losordenes,"orden","Seleccione Orden",$orden)?></td>
                    <td><?=$Aux->SelectArrayBig($lostiposO,"tipo_orden","Sel. Tipo Orden",$tipo_orden)?></td>
                </tr>
                <tr>
                    <td colspan=4">
                        <table>
                            <tr>
                                <td>%Cobrado<?=$Aux->SelectArrayBig($losporcentajes,"por_cobrado","----",$por_cobrado)?></td>
                                <td><input type="submit" value="Aplicar Filtro" name="a"  class="botonfiltro"></td>
                                <td><a href="/includes/csv_listado_item_proyectos.php?encargado=<?=$encargado?>&orden=<?=$orden?>&tipo_orden=<?=$tipo_orden?>&por_cobrado=<?=$por_cobrado?>&taller=<?=$taller?>&taller_segui=<?=$taller_segui?>&solo_segui=<?=$solo_segui?>&finalizado=<?=$finalizado?>">Descargar Archivo</a></td>
                                <td><div id="elarchivo"></div></td>                                  
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="celda_bordes">
                        <table width="100%">
                            <tr class="hnavbg">
                                <td colspan="6" class="tituloblanco12">Estados &Iacute;tem Proyecto</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="taller" <?=($taller=="on")?"checked":""?>>Taller </td>
                                <td><input type="checkbox" name="taller_segui" <?=($taller_segui=="on")?"checked":""?>>Segui. y Taller</td>
                                <td><input type="checkbox" name="solo_segui" <?=($solo_segui=="on")?"checked":""?>>Solo Segui.</td>                                
                                <td><input type="checkbox" name="finalizado" <?=($finalizado=="on")?"checked":""?>>Finalizado</td>                                
                                <td><input type="checkbox" name="oc" <?=($oc=="on")?"checked":""?>>OC</td>
                                <td><input type="checkbox" name="hes" <?=($hes=="on")?"checked":""?>>HES</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            </form>
        </td>
    </tr>
    <tr class="hnavbg">
        <td class="tituloblanco12">Nro. Proyecto</td>
<!--        <td class="tituloblanco12">Nombre</td>-->
        <td class="tituloblanco12">Item</td>
        <td class="tituloblanco12">UF</td>
<!--        <td class="tituloblanco12">Descripcion</td>-->
        <td class="tituloblanco12">Jefe</td>
        <td class="tituloblanco12">Proyec.<br>Asignado</td>
        <td class="tituloblanco12">Dias<br>En Taller<br>Cerrados</td>
        <td class="tituloblanco12">Dias<br>En Taller</td>
        <td class="tituloblanco12">Taller</td>
        <td class="tituloblanco12">Segui.<br>y Taller</td>
        <td class="tituloblanco12">Solo<br>Segui.</td>
        <td class="tituloblanco12">Fina.</td>
        <td class="tituloblanco12">OC&nbsp;&nbsp;</td>
        <td class="tituloblanco12">HES</td>
        <td class="tituloblanco12">EP1</td>
        <td class="tituloblanco12">EP2</td>
        <td class="tituloblanco12">EP3</td>
        <td class="tituloblanco12">%<br>Cobrado</td>
        <td></td>
    </tr>

    <?php
    $filtros="&encargado=$encargado&orden=$orden&tipo_orden=$tipo_orden&por_cobrado=$por_cobrado";
    $filtros.="&taller=$taller&taller_segui=$taller_segui&solo_segui=$solo_segui&finalizado=$finalizado";
    $filtros.="&oc=$oc&hes=$hes";
    
    $total = 0;$total_anticipo =0;$total_entregado=0;$total_aprobado=0;
    $i=0;
    foreach($rs as $row){
        $id_item = $row['id'];
        $nro_proyecto = $row['nro_proyecto'];
        $nombre = $row['nombre_proyecto'];
        $id_encargado = $row['proyectista_asignado'];
        $jefe = $row['jefe'];
        //$id_encargado = $Aux->ElDato($nro_proyecto,"Proyecto","nro_proyecto","proyectista_asignado");
        $eljefe = $Aux->ElDato($jefe,"Usuarios","id","alias");
        $elproyectista = $Aux->ElDato($id_encargado,"Usuarios","id","alias");
        $dias_taller_cerrados = $row['DTC'];
        $dias_taller_abiertos = $row['DTA'];
        
        $nro_proy = $row['nro_proyecto'];
        $codigo = $row['item_contratado'];
        $valor_item = $row['valor_item'];
        $item = $row['descripcion'];
        $ep1 = $row['ep1'];
        $ep2 = $row['ep2'];
        $ep3 = $row['ep3'];
        $taller = $row['taller'];
        $seguimiento_taller = $row['seguimiento_taller'];
        $solo_seguimiento = $row['solo_seguimiento'];
        $finalizado = $row['finalizado'];
        $porcob = $row['porcentaje_pagado'];
        $oc = $row['oc'];
        $hes = $row['hes'];
        $moneda = $row['tipo_moneda'];
        $lamoneda = $Aux->ElDato($moneda,"TipoMoneda","id","descripcion");
        $valor_total = $row['valor_item'];
        $anticipo = $row['pago_anticipo'];$total_anticipo+=$anticipo;
        $por_anticipo = number_format(($anticipo/$valor_total) *100,0);
        $entrega = $row['pago_entrega'];$total_entregado+=$entrega;
        $por_entrega = number_format(($entrega/$valor_total) *100,0);
        $aprobado = $row['pago_aprobacion'];$total_aprobado+=$aprobado;
        $por_aprobado = number_format(($aprobado/$valor_total) *100,0);
        
        $por_cobrado = 0;
        if($ep1==1) $por_cobrado+=$por_anticipo;
        if($ep2==1) $por_cobrado+=$por_entrega;
        if($ep3==1) $por_cobrado+=$por_aprobado;
        
        
        
        $total+=$valor_total;
        $color=$Aux->flipcolor($color);
        ?>
    <tr <?=$Aux->rowEffect($i, $color)?> >
        <td bgcolor="<?=$color?>" align="right"><?=$nro_proyecto?>&nbsp;<?php if($editar_proy==1){?><input type="button" value="Editar" name="b<?=$i?>" onclick="document.location='/index.php?p=nuevo_proyecto&lip=1&nro_proyecto=<?=$nro_proy?>&orden=<?=$orden?>&tipo_orden=<?=$tipo_orden?><?=$filtros?>';" class="boton"><?php }?></td>
<!--        <td bgcolor="<?=$color?>"><?=$nombre?></td>-->
        <td bgcolor="<?=$color?>" align="center"><?=$codigo?></td>
        <td bgcolor="<?=$color?>" align="center"><?=number_format($valor_item,2,",",".")?></td>
<!--        <td bgcolor="<?=$color?>"><?=$item?></td>-->
        <td bgcolor="<?=$color?>" align="center"><?=$eljefe?></td>
        <td bgcolor="<?=$color?>" align="center"><?=$elproyectista?></td>
        <td bgcolor="<?=$color?>" align="right"><?=($dias_taller_cerrados>0)?$dias_taller_cerrados:""?></td>
        <td bgcolor="<?=$color?>" align="right"><?=($dias_taller_abiertos)?$dias_taller_abiertos:""?></td>
        <td bgcolor="<?=$color?>"><?php if($tipo==1||$tipo==2||$tipo==3){?><input type="button" size="3" name="taller_<?=$id_item?>" value =" " onclick="marca_taller(<?=$id_item?>)"><?php }?><?=$Aux->marca($taller)?></td>
        <td bgcolor="<?=$color?>"><?php if($tipo==1||$tipo==2||$tipo==3){?><input type="button" size="3" name="sequitaller_<?=$id_item?>" value =" " onclick="marca_seguitaller(<?=$id_item?>)"><?php }?><?=$Aux->marca($seguimiento_taller)?></td>
        <td bgcolor="<?=$color?>"><?php if($tipo==1||$tipo==2||$tipo==3){?><input type="button" size="3" name="solosegui_<?=$id_item?>" value =" " onclick="marca_solosegui(<?=$id_item?>)"><?php }?><?=$Aux->marca($solo_seguimiento)?></td>
        <td bgcolor="<?=$color?>"><?php if($tipo==1||$tipo==2||$tipo==3){?><input type="button" size="3" name="finalizado_<?=$id_item?>" value =" " onclick="marca_finalizado(<?=$id_item?>)"><?php }?><?=$Aux->marca($finalizado)?></td>
        <td bgcolor="<?=$color?>"><?=$Aux->marca($oc)?></td>
        <td bgcolor="<?=$color?>"><?=$Aux->marca($hes)?></td>
        <td bgcolor="<?=$color?>" align="right"><?=$Aux->marca($ep1)?><?=$por_anticipo?>%</td>
        <td bgcolor="<?=$color?>" align="right"><?=$Aux->marca($ep2)?><?=$por_entrega?>%</td>
        <td bgcolor="<?=$color?>" align="right"><?=$Aux->marca($ep3)?><?=$por_aprobado?>%</td>
        <td bgcolor="<?=$color?>" align="right"><?="$por_cobrado ($porcob)"?></td>
        <td bgcolor="<?=$color?>"><input type="button" value="Ver" name="b<?=$i?>" onclick="requestPage('/includes/ver_proyecto.php?nro_proyecto=<?=$nro_proyecto?>','det<?=$i?>');" class="boton"></td>
        <td><div id="salida_item<?=$id_item?>"></div></td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="15" class="celda_bordes"><div id="det<?=$i?>"></div></td>
    </tr>
    <?php
        $i++;
    }
    ?>
    <tr class="hnavbg" valign="top">
        <td colspan="18">Se encontrar&oacute;n <?=$i?> &iacute;tem&nbsp;</td>
    </tr>

    </table>