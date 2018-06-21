<?php
/*
 * Diseñado y desarrollado por Epro Software (c)2014
 * Bajo Licencia GNU
 * Cualquier cambio debe ser avisado a Epro Software
 */

/**
 * Nueva Cotización
 *
 * @author eroman
 * Fecha: 2014-05-18
 * 
 */
include_once str_replace("/includes","",getcwd()).'/cfgdir.php';
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd()).'/includes/header.php';

    $Aux = new DBProyecto();
    $dbuser = new DBUsuario();

    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    
    $nro_proyecto = ($nro_proyecto)?$nro_proyecto:$_GET['nro_proyecto'];
    
    $lostipomoneda = $Aux->TraerLosDatos("TipoMoneda","id","descripcion");
    $losproyectistas = $Aux->TraerLosDatos("Usuarios","id","nombre");

    if($nro_proyecto){
        $ax = $Aux->get("",$nro_proyecto);$a= $ax['salida'];
        $p = $a[0];
        $nombre_proyecto = $p->getNombreProyecto();
        $encargado = $p->getProyectistaAsignado();
        $fecha_creacion = $p->getFechaCreacion();
        $valor_uf = $p->getValorUF();
    } else {
        $i = new Indicadores();
        $valor_uf = $i->getUf();
        $fecha_creacion = date("Y-m-d");
    }
    $tipo_moneda = ($tipo_moneda)?$tipo_moneda:1;
?>
<div class="panel panel-default">
    <div class="panel-heading"><h1>Proyecto #<?=substr("00000000$nro_proyecto",-5)?></h1></div>
    <div class="panel-body">
        <form action="" method="POST" name="f">
        <table class="table table-bordered table-striped">
            <tr>
                <td>Nro. Proyecto:</td>
                <td><?=substr("00000000$nro_proyecto",-5)?></td>
            </tr>
            <tr>
                <td>Fecha Sistema:</td>
                <td><?=$fecha_creacion?></td>
            </tr>
            <tr>
                <td>Nombre Proyecto:</td>
                <td><?=$nombre_proyecto?></td>
            </tr>
            <tr>
                <td>Proyectista:</td>
                <td><?=$Aux->ElDato($encargado,"Usuarios","id","nombre")?></td>
            </tr>
            <!--<tr>
                <td>Valor UF:</td>
                <td><?=number_format($valor_uf,2,",",".")?></td>
            </tr>-->
            <tr class="hnavbg">
                <td class="tituloblanco12" colspan="2">Detalle Trabajos</td>    
            </tr>
            <tr>
                <td colspan="2"><div id="det_proyecto"><?php
                $nro = $nro_proyecto;$lauf=$valor_uf;
                include "verItemProyecto.php";
                        ?></div></td>
            </tr>  
            <tr class="hnavbg">
                <td class="tituloblanco12" colspan="2">Bitacora</td>    
            </tr>    
            <tr>
                <td colspan="2"><div id="det_pedidos"><?php
                    $nrob = $nro_proyecto;
                    $ver_bita =1;
                    include "getBitacoraProyecto.php";
                ?></div></td>
            </tr>     
        </table>
        </form>
    </div>
</div>



