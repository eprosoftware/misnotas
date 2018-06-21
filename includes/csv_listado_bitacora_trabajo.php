<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//include '/home/eroman/desa/syspavimentos/class/config.php';
include '/home/syspav/class/config.php';

    $Aux = new DBBitacoraTrabajo();
    $dbuser = new DBUsuario();

    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    $user = $dbuser->ElUsuario($id_user);
    $tipo = $user->getTipoUsuario();
    
    $nro_proyecto = $_GET['nro_proyecto'];
   
    $glosa = $_GET['glosa'];
    $proyectista = $_GET['proyectista'];
    $id_item = $Aux->ElDato($tmp['id_item'],"ItemProyecto","id","item_contratado");
    $fecha1 = $_GET['fecha1'];
    $fecha2 = $_GET['fecha2'];
    $jefe = $_GET['jefe'];
    
    $fechaFile = date("Y_m_d");
    $file = DIR."/lib_archivos/listado_bitacora$iduser$fechaFile.csv";    
    $fname = "listado_bitacora$iduser$fechaFile.csv";
    
    header("Content-disposition: attachment; filename=$fname");
    header("Content-type: application/octet-stream");
    
    $fecha = date("Y-m-d");
    $labitacora = $Aux->get($proyectista,$nro_proyecto,"",$glosa,$fecha1,$fecha2,$jefe);
    
    $eltipo = $Aux->ElDato($tipo,"TipoUsuario","id","descripcion");
    if(!isset($estado)) $estado="1,2";
    $losproyectos = $Aux->get("",$nro_proyecto,$estado,$encargado,$nombre_proyecto);
    $losproyectistas = $Aux->TraerLosDatos("Usuarios","id","nombre", " where tipo_usuario>2");
    $losjefes = $Aux->TraerLosDatos("Usuarios","id","nombre", " where tipo_usuario in (2,3)");

    $separador = ";";
    $titulo = "Fecha".$separador;
    $titulo.= "Nro.Proyecto".$separador;
    $titulo.= "Nombre Proyecto".$separador;
    $titulo.= "Item".$separador;
    $titulo.= "Proyectista".$separador;
    $titulo.= "Jefe".$separador;
    $titulo.= "Nro. Horas".$separador;
    $titulo.= "Glosa\n";
    $fp = fopen($file,"w");
    fwrite($fp,$titulo);
    
    $total_horas=0;
    for($i=0;$i<count($labitacora);$i++){
        $tmp = $labitacora[$i];
        $fecha = $tmp['fecha'];
        $id_proy = $tmp['proyectista'];
        $elproyectista = $Aux->ElDato($id_proy,"Usuarios","id","nombre");
        $nro_proy = $tmp['nro_proyecto'];
        $item = $Aux->ElDato($tmp['id_item'],"ItemProyecto","id","item_contratado");
        $nombre_proyecto = $Aux->ElDato($nro_proy,"Proyecto","nro_proyecto","nombre_proyecto");
        $nro_horas = $tmp['nro_horas'];$total_horas += $nro_horas;
        $glosa = $tmp['glosa'];
        $id_jefe =$tmp['jefe'];$eljefe = $Aux->ElDato($id_jefe,"Usuarios","id","nombre");
        $color = $Aux->flipcolor($color);
        
        $linea =$fecha.$separador;
        $linea.= $nro_proy.$separador;
        $linea.= $Aux->normalizar_acentos($nombre_proyecto).$separador;
        $linea.= $item.$separador;
        $linea.= $elproyectista.$separador;
        $linea.= $eljefe.$separador;
        $linea.= $nro_horas.$separador;
        $linea.= $Aux->normalizar_acentos($glosa)."\n";
        
        fwrite($fp,$linea);
    }
    fclose($fp);
    
    readfile(DIR."/lib_archivos/listado_bitacora$iduser$fechaFile.csv");    
?>
    