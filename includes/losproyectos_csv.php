<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once getcwd().'/class/config.php';

    $Aux = new DBProyecto();
    $dbuser = new DBUsuario();

    
    $jefe = $_GET['jefe'];
    $proyectista=$_GET['proyectista'];
    $nro_proyecto = $_GET['nro_proyecto'];
    $estado = $_GET['estado'];
    $nombre_proyecto = $_GET['nombre_proyecto'];
    $orden =$_GET['orden'];
    $tipo_orden=$_GET['tipo_orden'];
    
    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    $user = $dbuser->ElUsuario($id_user);
    $tipo = $user->getTipoUsuario();
    $eliminar_proy = $user->getEliminarProyecto();
    
    $fechaFile = date("Y_m_d");
    $file = DIR."/lib_archivos/losproyectos$iduser$fechaFile.csv";    
    $fname = "losproyectos$iduser$fechaFile.csv";
    
    header("Content-disposition: attachment; filename=$fname");
    header("Content-type: application/octet-stream");
    
    $eltipo = $Aux->ElDato($tipo,"TipoUsuario","id","descripcion");
    if(!isset($estado)) $estado="1,2";
    $losproyectos = $Aux->get("",$nro_proyecto,$estado,$proyectista,$nombre_proyecto,$jefe,$orden,$tipo_orden);
    
    $losordenes=array();
    $tmp=array();$tmp['valor']=1;$tmp['txt']="Nro.Proyecto";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=2;$tmp['txt']="Fecha";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=3;$tmp['txt']="Jefe";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=4;$tmp['txt']="Proyectista";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=5;$tmp['txt']="Estado";$losordenes[]=$tmp;
    $lostiposO=array();
    $tmp=array();$tmp['valor']=1;$tmp['txt']="Asc";$lostiposO[]=$tmp;
    $tmp=array();$tmp['valor']=2;$tmp['txt']="Desc";$lostiposO[]=$tmp;     
    
    $fp = fopen($file,"w");
    
    $separador =";";
    $titulo = "Nro.Proyecto".$separador;
    $titulo.= "Fecha".$separador;
    $titulo.= "Nombre Proyecto".$separador;
    $titulo.= "Jefe/Proyectista".$separador."Estado\n";
    fwrite($fp,$titulo);
    $i=0;$total=0;$total_uf=0;
    while($tmp=$losproyectos[$i]){
        $nro        = $tmp->getNroProyecto();
        $fecha      = $tmp->getFechaCreacion();
        $creadopor  = $tmp->getCreadoPor();
        $elcreador = $Aux->ElDato($creadopor,"Usuarios","id","alias");
        $nombre     = $tmp->getNombreProyecto();
        $jefe = $tmp->getJefe();
        $encargado  = $tmp->getProyectistaAsignado();
        $elencargado = $Aux->ElDato($encargado,"Usuarios","id","alias");
        $nombre_encargado = $Aux->ElDato($encargado,"Usuarios","id","nombre");
        $eljefe = $Aux->ElDato($jefe,"Usuarios","id","alias");
        $nombre_jefe= $Aux->ElDato($jefe,"Usuarios","id","nombre");
        $estado     = $tmp->getEstado();
        $elestado = $Aux->ElDato($estado,"EstadoProyecto","id","descripcion");
        $color = $Aux->flipcolor($color);
        
        $linea = $nro.$separador.$fecha.$separador;
        $linea.=$Aux->normalizar_acentos($nombre).$separador;
        $linea.=$nombre_jefe."/".$nombre_encargado.$separador;
        $linea.=$elestado."\n";
        fwrite($fp,$linea);

        $i++;
    }
    fclose($fp);
    
    readfile(DIR."/proyectos/lib_archivos/losproyectos$iduser$fechaFile.csv");    
    ?>

    