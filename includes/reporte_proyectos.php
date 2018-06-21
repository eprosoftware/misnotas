<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/session.php';
include_once '../class/config.php';
include_once 'header.php';


function ver_proyecto($nro_proyecto){
    $Aux = new DBProyecto();
    $dbuser = new DBUsuario();

    if($nro_proyecto){
        $a = $Aux->get("",$nro_proyecto);
        $p = $a[0];
        $nombre_proyecto = $p->getNombreProyecto();
        $encargado = $p->getProyectistaAsignado();
        $fecha_creacion = $p->getFechaCreacion();
        $valor_uf = $p->getValorUF();
    }
    $tipo_moneda = ($tipo_moneda)?$tipo_moneda:1;
?>
<table width="100%">
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
    <tr class="hnavbg">
        <td class="tituloblanco12" colspan="2">Detalle Trabajos</td>    
    </tr>
    <tr>
        <td colspan="2"><div id="det_proyecto"><?php
        $nro = $nro_proyecto;
        include "verItemProyecto.php";
                ?></div></td>
    </tr>  
    <tr class="hnavbg">
        <td class="tituloblanco12" colspan="2">Bitacora</td>    
    </tr>    
    <tr>
        <td colspan="2"><div id="det_pedidos"><?php
            $nro = $nro_proyecto;
            include "getBitacoraProyecto.php";
        ?></div></td>
    </tr>     
</table>
<?php
}
    $Aux = new DBProyecto();
    $dbuser = new DBUsuario();

    $comando = $_POST['comando'];
    $jefe               = ($_GET['jefe'])?$_GET['jefe']:$_POST['jefe'];
    $proyectista        = ($_GET['proyectista'])?$_GET['proyectista']:$_POST['proyectista'];
    $nro_proy           = ($_GET['nro_proy'])?$_GET['nro_proy']:$_POST['nro_proy'];
    $estado             = ($_GET['estado'])?$_GET['estado']:$_POST['estado'];
    $nombre_proyecto    = ($_GET['nombre_proyecto'])?$_GET['nombre_proyecto']:$_POST['nombre_proyecto'];
    $orden              = ($_GET['orden'])?$_GET['orden']:$_POST['orden'];
    $tipo_orden         = ($_GET['tipo_orden'])?$_GET['tipo_orden']:$_POST['tipo_orden'];
    
    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    $user = $dbuser->ElUsuario($id_user);
    $tipo = $user->getTipoUsuario();
    $eliminar_proy = $user->getEliminarProyecto();
    $editar_proy = $user->getEditarProyectos();
    
    $eltipo = $Aux->ElDato($tipo,"TipoUsuario","id","descripcion");
    if(!isset($estado)) $estado="1,2";
    if($comando==1)
        $losproyectos = $Aux->get("",$nro_proy,$estado,$proyectista,$nombre_proyecto,$jefe,$orden,$tipo_orden);
    $losproyectistas = $Aux->TraerLosDatos("Usuarios","id","nombre", " where tipo_usuario>2");
    $losjefes = $Aux->TraerLosDatos("Usuarios","id","nombre", " where tipo_usuario in (2,3)");
    $losestados = $Aux->TraerLosDatos("EstadoProyecto","id","descripcion");
    
    $losordenes=array();
    $tmp=array();$tmp['valor']=1;$tmp['txt']="Nro.Proyecto";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=2;$tmp['txt']="Fecha";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=3;$tmp['txt']="Jefe";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=4;$tmp['txt']="Proyectista";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=5;$tmp['txt']="Estado";$losordenes[]=$tmp;
    $lostiposO=array();
    $tmp=array();$tmp['valor']=1;$tmp['txt']="&UpArrow; Asc";$lostiposO[]=$tmp;
    $tmp=array();$tmp['valor']=2;$tmp['txt']="&DownArrow; Desc";$lostiposO[]=$tmp;     
    ?>
<script>
function dar_conformidad(ped){
    openWindow("/includes/dar_conformidad.php?id_ped="+ped,"Winped"+ped,500,300);
    document.location="/index.php";
}
function filtrar(){
    n         = document.f.nro_proy.value;
    nom       = document.f.nombre_proyecto.value;
    j = document.f.jefe.options[document.f.jefe.selectedIndex].value;
    proyectista = document.f.proyectista.options[document.f.proyectista.selectedIndex].value;
    estado    = document.f.estado.options[document.f.estado.selectedIndex].value;
    o = document.f.orden.options[document.f.orden.selectedIndex].value;
    t = document.f.tipo_orden.options[document.f.tipo_orden.selectedIndex].value;
    a = document.f.proy_abierto.value;
    document.location="/index.php?p=losproyectos&nro_proy="+n+"&proyectista="+proyectista+"&jefe="+j+"&estado="+estado+"&nombre_proyecto="+nom+"&orden="+o+"&tipo_orden="+t+"&proy_abierto="+a;
}
</script>

<table>
    <tr class="hnavbg">
        <td colspan="5" class="tituloblanco12">Reporte Proyectos</td>
    </tr>
    <tr>
        <td colspan="5">
            <form action="/index.php?p=reporte_proyectos" name="f" method="POST">
                <input type="hidden" name="comando" value="1">
            <table>
                <tr valign="top">
                    <td>Nro.Proyecto:<input type="text" size="5" name="nro_proy" value="<?=$nro_proy?>" "></td>
                    <td>Nombre Proyecto:<input type="text" size="50" name="nombre_proyecto" value="<?=$nombre_proyecto?>"></td>
                    <td class="celda_bordes">
                        <table>
                            <tr><td>Jefe:</td><td><?=$Aux->SelectArrayBig($losjefes,"jefe","----",$jefe,"","requestPage('/includes/losproyectistas.php?jefe='+this.value,'proyectista_div')")?></td></tr>
                            <tr><td>Proyectista:</td><td><div id="proyectista_div"><?=$Aux->SelectArrayBig($losproyectistas,"proyectista","----",$proyectista)?></div></td></tr>
                            <tr><td>Estado:</td><td><?=$Aux->SelectArrayBig($losestados,"estado","----",$estado)?></td>                    </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table>
                            <tr>
                                <td><?=$Aux->SelectArrayBig($losordenes,"orden","Ordenar Por",$orden)?></td>
                                <td><?=$Aux->SelectArrayBig($lostiposO,"tipo_orden","&UpArrow; &DownArrow;",$tipo_orden)?></td>
                                <td><input type="submit" value="Aplicar Filtro" name="a" class="botonfiltro"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table></form>
        </td>
    </tr>
    <tr class="hnavbg">
        <td class="tituloblanco12">Nro. Proy.</td>
        <td class="tituloblanco12" width="100">Fecha</td>
        <td class="tituloblanco12">Nombre Proyecto</td>
        <td class="tituloblanco12">J/Pry</td>
        <td class="tituloblanco12">Estado</td>
    </tr>
    <?php
    $i=0;$total=0;$total_uf=0;$xnroproy=array();
    while($tmp=$losproyectos[$i]){
        $nro        = $tmp->getNroProyecto();
        $xnroproy[]=$nro;
        $fecha      = $tmp->getFechaCreacion();
        $creadopor  = $tmp->getCreadoPor();
        $elcreador = $Aux->ElDato($creadopor,"Usuarios","id","alias");
        $nombre     = $tmp->getNombreProyecto();
        $jefe = $tmp->getJefe();
        $encargado  = $tmp->getProyectistaAsignado();
        $elencargado = $Aux->ElDato($encargado,"Usuarios","id","nombre");
        $nombre_encargado = $Aux->ElDato($encargado,"Usuarios","id","nombre");
        $eljefe = $Aux->ElDato($jefe,"Usuarios","id","nombre");
        $nombre_jefe= $Aux->ElDato($jefe,"Usuarios","id","nombre");
        $estado     = $tmp->getEstado();
        $elestado = $Aux->ElDato($estado,"EstadoProyecto","id","descripcion");
        $color = $Aux->flipcolor($color);
        ?>
    <tr bgcolor="<?=$color?>" <?=$Aux->rowEffect($i, $color)?>>
        <td align="right" bgcolor="<?=$color?>"><?=$nro?></td>
        <td bgcolor="<?=$color?>"><?=$fecha?></td>
        <td bgcolor="<?=$color?>"><?=$nombre?></td>
        <td bgcolor="<?=$color?>"><img src="/images/index_bullet.gif" title="<?="$nombre_jefe/$nombre_encargado"?>"><?="$eljefe/$elencargado"?></td>
        <td bgcolor="<?=$color?>"><?=$elestado?></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="4" class="celda_bordes"><div id="proy<?=$i?>">
                <?php ver_proyecto($nro);?>
            </div>
        </td>
    </tr>
    <?php
        $i++;
    }
    ?>
    <tr class="hnavbg">
        <td colspan="5">Se encontrar&oacute;n <?=$i?> Proyectos&nbsp;</td>
    </tr>
</table>




    