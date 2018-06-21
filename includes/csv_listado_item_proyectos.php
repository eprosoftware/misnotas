<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//include '/home/eroman/desa/syspavimentos/class/config.php';
include '/home/syspav/class/config.php';

    $fecha = date("Y_m_d");
    $file = DIR."/lib_archivos/listado_item_proyectos_$fecha.csv";
    $fname = "listado_item_proyectos_$fecha.csv";

    
    $Aux = new DBProyecto();
    $Aux->conecta();
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
    
    if($encargado>0){
        $nombre_encargado = $Aux->ElDato($encargado,"Usuarios","id","nombre");
        $nombre_encargado = str_replace(" ","_", $nombre_encargado);
        $fname = "listado_item_proyectos_".$nombre_encargado."_".$fecha.".csv";
    }
    
    header("Content-disposition: attachment; filename=$fname");
    header("Content-type: application/octet-stream");    
    
    $sql = "select a.nro_proyecto,a.nombre_proyecto,b.item_contratado,"
            . "b.valor_item,getJefe(a.proyectista_asignado) jefe ,"
            . "a.proyectista_asignado,"
            . "taller,seguimiento_taller,solo_seguimiento,finalizado,"
            . "oc,hes,"
            . "ep1,ep2,ep3,"
            . "porcentaje_pagado,"
            . "getDiasTallerCerrados(b.id) DTC,"
            . "getDiasTaller(b.id) DTA "
            . "from Proyecto a,ItemProyecto b "
            . "where a.nro_proyecto=b.nro_proyecto ";
    if($encargado>0) $sql.= " and a.proyectista_asignado=$encargado";
    if($por_cobrado) $sql.=" and b.porcentaje_pagado=$por_cobrado ";
    
    $xsql=array();
    if($taller=="on") $xsql[]= "b.taller=1";
    if($taller_segui=="on") $xsql[]= "b.seguimiento_taller=1";
    if($solo_segui=="on") $xsql[]= "b.solo_seguimiento=1";
    if($finalizado=="on") $xsql[]= "b.finalizado=1";
    if($oc=="on") $xsql[].= "b.oc==1";
    if($hes=="on") $xsql[]="hes==1";
    if($taller||$taller_segui||$solo_segui||$oc||$hes||$finalizado)
        $sql.= " and (".implode(" or ",$xsql).")";
    
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
    
    //echo "<P>SQL: $sql</p>";
    $rs = $Aux->query($sql);
    $losproyectistas = $Aux->TraerLosDatos("Usuarios","id","nombre", " where tipo_usuario>2");
    
    $fp = fopen($file,"w");
    
    $separador =";";
    $titulo = "Nro.Proyecto".$separador;
    $titulo.= "Nombre".$separador;
    $titulo.= "Item".$separador." ".$separador;
    //$titulo.= "Descripcion".$separador;
    $titulo.= "Proyectista".$separador;
    $titulo.= "Dias Taller Cerrador".$separador;
    $titulo.= "Dias Taller".$separador;
    $titulo.= "Taller".$separador;
    $titulo.= "Segui. y Taller".$separador;
    $titulo.= "Solo Segui.".$separador;
    $titulo.= "Finalizado".$separador;
    $titulo.= "OC".$separador."HES".$separador;
    $titulo.= "EP1".$separador."EP2".$separador."EP3".$separador;
    $titulo.= "% Cobrado\n";
    fwrite($fp,$titulo);
    $total = 0;$total_anticipo =0;$total_entregado=0;$total_aprobado=0;
    while($row = $Aux->getRows($rs)){
        $id_item = $row['id'];
        $nro_proyecto = $row["nro_proyecto"];
        $nombre =$row["nombre_proyecto"];
        $id_encargado = $row["proyectista_asignado"];
        $elproyectista = $Aux->ElDato($id_encargado,"Usuarios","id","nombre");
        $dias_taller_cerrados = $row['DTC'];
        $dias_taller_abiertos = $row['DTA'];
        
        $nro_proy = $row['nro_proyecto'];
        $codigo = $row['item_contratado'];
        $item = $row['descripcion'];
        $ep1 = $row['ep1'];
        $ep2 = $row['ep2'];
        $ep3 = $row['ep3'];
        $taller = $row['taller'];
        $seguimiento_taller = $row['seguimiento_taller'];
        $solo_seguimiento = $row['solo_seguimiento'];
        $finalizado = $row['finalizado'];
        $oc = $row['oc'];
        $hes = $row['hes'];
        $moneda = $row['tipo_moneda'];
        $lamoneda = $Aux->ElDato($moneda,"TipoMoneda","id","descripcion");
        $valor_item = $row['valor_item'];
        $anticipo = $row['pago_anticipo'];$total_anticipo+=$anticipo;
        $por_anticipo = number_format(($anticipo/$valor_total) *100,0);
        $entrega = $row['pago_entrega'];$total_entregado+=$entrega;
        $por_entrega = number_format(($entrega/$valor_total) *100,0);
        $aprobado = $row['pago_aprobado'];$total_aprobado+=$aprobado;
        $por_aprobado = number_format(($aprobado/$valor_total) *100,0);
        $porcentaje_pagado = $row['porcentaje_pagado'];
        
        /*$por_cobrado = 0;
        if($ep1==1) $por_cobrado+=$por_anticipo;
        if($ep2==1) $por_cobrado+=$por_entrega;
        if($ep3==1) $por_cobrado+=$por_aprobado;
        */
        $por_cobrado = $porcentaje_pagado;
        
        $total+=$valor_total;
        $color=$Aux->flipcolor($color);
        $linea = $nro_proyecto.$separador.$nombre.$separador.$codigo.$separador;
        $linea.= number_format($valor_item,2,",",".").$separador.$elproyectista.$separador;
        if($dias_taller_cerrados>0) $linea.=$dias_taller_cerrados.$separador;
        else $linea.="".$separador;
        if($delta_taller) $linea.= $delta_taller.$separador;
        else $linea.="".$separador;
        if($taller){ $linea.= $Aux->marca_X($taller).$separador;}
        else $linea.="".$separador;
        if($seguimiento_taller){$linea.= $Aux->marca_X($seguimiento_taller).$separador;}
        else $linea.="".$separador;
        if($solo_seguimiento){$linea.= $Aux->marca_X($solo_seguimiento).$separador;}
        else $linea.="".$separador;
        if($finalizado){$linea.= $Aux->marca_X($finalizado).$separador;}
        else $linea.="".$separador;        
        $linea.= $Aux->marca_X($oc).$separador;
        $linea.= $Aux->marca_X($hes).$separador;
        $linea.= $Aux->marca_X($ep1).$separador;
        $linea.= $Aux->marca_X($ep2).$separador;
        $linea.= $Aux->marca_X($ep3).$separador;
        $linea.= $por_cobrado."\n";
        fwrite($fp,$linea);
    }
    
    fclose($fp);
    
    readfile(DIR."/lib_archivos/listado_item_proyectos_$fecha.csv");
  ?>

