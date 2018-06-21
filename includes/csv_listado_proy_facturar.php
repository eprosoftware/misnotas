<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//include '/home/eroman/desa/syspavimentos/class/config.php';
include '/home/syspav/class/config.php';

    $Aux = new DBProyecto();
    $dbuser = new DBUsuario();
    
    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    
    $estado = $_GET['estado'];
    $fechad = $_POST['fecha_desde'];
    $fechah = $_POST['fecha_hasta'];
    $ffechad = $_POST['ffecha_desde'];
    $ffechah = $_POST['ffecha_hasta'];
    $orden = $_POST['orden'];
    $tipo_orden = $_POST['tipo_orden'];
    
    $item_cobrados = $Aux->getItemPorFacturar($estado,$fechad,$fechah,$ffechad,$ffechah,$orden,$tipo_orden);
    
    $losestados = $Aux->TraerLosDatos("EstadoFactura", "id", "descripcion");
    
    $losordenes=array();
    $tmp=array();$tmp['valor']=1;$tmp['txt']="Nro.Proyecto";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=2;$tmp['txt']="Fecha Procesado";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=3;$tmp['txt']="Fecha Facturado";$losordenes[]=$tmp;
    $lostiposO=array();
    $tmp=array();$tmp['valor']=1;$tmp['txt']="Ascendente";$lostiposO[]=$tmp;
    $tmp=array();$tmp['valor']=2;$tmp['txt']="Descendente";$lostiposO[]=$tmp;    
    
    $fechaFile = date("Y_m_d");
    $file = DIR."/lib_archivos/list_proy_factura$iduser$fechaFile.csv";    
    $fname = "list_proy_factura$iduser$fechaFile.csv";
    
    header("Content-disposition: attachment; filename=$fname");
    header("Content-type: application/octet-stream");
    $separador=";";
    $titulo ="Nro. Proy".$separador;
    $titulo.="Fecha S.".$separador;
    $titulo.="Descripcion".$separador;
    $titulo.="Moneda".$separador;
    $titulo.="Concepto".$separador;
    $titulo.="Monto".$separador;
    $titulo.="Estado Factura".$separador;
    $titulo.="Nro.Factura".$separador;
    $titulo.="Fecha Facturado\n";
    
    $fp = fopen($file,"w");
    fwrite($fp,$titulo);
    
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
            
            $linea = $nro_proyecto.$separador;
            $linea.= $fecha.$separador;
            $linea.= $descripcion.$separador;
            $linea.= $lamoneda.$separador;
            $linea.= $st_concepto.$separador;
            $linea.= number_format($monto,2,",",".").$separador;
            $linea.= $elestado.$separador;
            $linea.= $nro_factura.$separador;
            $linea.= $fecha_facturado."\n";
            fwrite($fp,$linea);
        }
        fclose($fp);

        readfile(DIR."/lib_archivos/list_proy_factura$iduser$fechaFile.csv");            
    ?>
            