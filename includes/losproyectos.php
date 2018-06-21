<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//echo "<p>DIR:".getcwd()."</p>";
include_once str_replace("/includes","",getcwd()).'/cfgdir.php';
//include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd())."/includes/header.php";

    $primero    = ($_GET['primero'])?$_GET['primero']:$_POST['primero'];
    $pag_show   = ($_GET['pag_show'])?$_GET['pag_show']:$_POST['pag_show'];
    $lapag      = $_GET['lapag'];
    $limite     = ($_GET['limite'])?$_GET['limite']:$_POST['limite'];
    $inicio     = $_GET['inicio'];
    $tipo_modulo = ($_POST['tipo_modulo'])?$_POST['tipo_modulo']:$_GET['tipo_modulo'];
    $fecha1 = ($_POST['fecha1'])?$_POST['fecha1']:$_GET['fecha1'];
    $fecha2 = ($_POST['fecha2'])?$_POST['fecha2']:$_GET['fecha2'];

        $ordenarpor     = ($_POST['ordenarpor'])?$_POST['ordenarpor']:$_GET['ordenarpor'];
        $orden          = ($_POST['orden'])?$_POST['orden']:$_GET['orden'];
        $tipo_orden     = ($_POST['tipo_orden'])?$_POST['tipo_orden']:$_GET['tipo_orden'];

        $ordenarpor = ($ordenarpor)?$ordenarpor:2;
        $tipo_orden = ($tipo_orden)?$tipo_orden:2;
        
    $limite     = ($limite)?$limite:10;
    $primero    = ($primero)?$primero:1;
    $inicio     = ($inicio)?$inicio:0;
    $pag_show   = (!$pag_show)?15:$pag_show;
    $lapag      = (!$lapag)?1:$lapag;    
    
    
    $Aux = new DBProyecto();
    $dbuser = new DBUsuario();

    $jefe               = ($_GET['jefe'])?$_GET['jefe']:$_POST['jefe'];
    $proyectista        = ($_GET['proyectista'])?$_GET['proyectista']:$_POST['proyectista'];
    $nro_proy           = ($_GET['nro_proy'])?$_GET['nro_proy']:$_POST['nro_proy'];
    $estado             = ($_GET['estado'])?$_GET['estado']:$_POST['estado'];
    $nombre_proyecto    = ($_GET['nombre_proyecto'])?$_GET['nombre_proyecto']:$_POST['nombre_proyecto'];
    $orden              = ($_GET['orden'])?$_GET['orden']:$_POST['orden'];
    $tipo_orden         = ($_GET['tipo_orden'])?$_GET['tipo_orden']:$_POST['tipo_orden'];
    $proy_abierto       = ($_GET['proy_abierto'])?$_GET['proy_abierto']:$_POST['proy_abierto'];
    $anno               = $_POST['anno'];
    $orden =($orden)?$orden:1;
    $tipo_orden = ($tipo_orden)?$tipo_orden:2;
    
    $id_user        = $dbuser->getUsuarioId($usuario,$clave);
    $user           = $dbuser->ElUsuario($id_user);
    $tipo           = $user->getTipoUsuario();
    $eliminar_proy  = $user->getEliminarProyecto();
    $editar_proy    = $user->getEditarProyectos();
    
    $eltipo = $Aux->ElDato($tipo,"TipoUsuario","id","descripcion");
    //if(!isset($estado)) $estado="1,2";
    $ax = $Aux->get("",$nro_proy,$estado,$proyectista,$nombre_proyecto,$jefe,$orden,$tipo_orden,$anno,$primero,$limite);
    $losproyectos = $ax['salida'];
    $nrofilas = $ax['nrofilas'];
    
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
    openWindow("<?=$base_dir?>/includes/dar_conformidad.php?id_ped="+ped,"Winped"+ped,500,300);
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
    document.location="<?=$base_dir?>/index.php?p=losproyectos&nro_proy="+n+"&proyectista="+proyectista+"&jefe="+j+"&estado="+estado+"&nombre_proyecto="+nom+"&orden="+o+"&tipo_orden="+t+"&proy_abierto="+a;
}
</script>

<div class="panel panel-default">
    <div class="panel-heading"><h2>Proyectos</h2></div>
    <div class="panel-body">
        <form action="<?=$base_dir?>/index.php?p=losproyectos" name="f" method="POST">
                    <table class="table table-bordered table-striped">
                        <tr valign="top">
                            <td>Nro.Proyecto:<input type="text" size="5" name="nro_proy" value="<?=$nro_proy?>" class="form-control"></td>
                            <td>A&ntilde;o:<input size="4" type="number" name="anno" value="<?=$anno?>"  class="form-control"></td>
                            <td>Nombre Proyecto:<input type="text" size="50" name="nombre_proyecto" value="<?=$nombre_proyecto?>" class="form-control"></td>
                            <td class="celda_bordes">
                                <table>
                                    <tr><td>Jefe:</td><td><?=$Aux->SelectArray($losjefes,"jefe","----",$jefe,"","requestPage('/includes/losproyectistas.php?jefe='+this.value,'proyectista_div')")?></td></tr>
                                    <tr><td>Proyectista:</td><td><div id="proyectista_div"><?=$Aux->SelectArray($losproyectistas,"proyectista","----",$proyectista)?></div></td></tr>
                                    <tr><td>Estado:</td><td><?=$Aux->SelectArray($losestados,"estado","----",$estado)?></td>                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <table width="100%">
                                    <tr>
                                        <td><input size="3" type="number" name="limite" value="<?=$limite?>" class="form-control"></td>
                                        <td><?=$Aux->SelectArray($losordenes,"orden","Ordenar Por",$orden)?></td>
                                        <td><?=$Aux->SelectArray($lostiposO,"tipo_orden","&UpArrow; &DownArrow;",$tipo_orden)?></td>
                                        <td><button name="a" class="btn btn-primary"><i class="glyphicon glyphicon-filter"></i>Aplicar Filtro</button></td>
                                        <td><a href="/includes/losproyectos_csv.php?jefe=<?=$jefe?>&proyectista=<?=$proyectista?>&nro_proyecto=<?=$nro_proy?>&estado=<?=$estado?>&nombre_proyecto=<?=$nombre_proyecto?>&orden=<?=$orden?>&tipo_orden=<?=$tipo_orden?>">Descargar CSV</a></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
        </form>        
    </div>
</div>
<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th>Nro. Proyecto</th>
        <th>Fecha</th>
        <th>Nombre Proyecto</th>
        <th>Cliente</th>
        <th>J/Pry</th>
        <!--<th>Creado Por</th>-->
        <th>Estado</th>
        <th></th>
        <th colspan="3"></th>
    </tr>
    </thead>
    <?php
    $i=0;$total=0;$total_uf=0;$xnroproy=array();
    while($tmp=$losproyectos[$i]){
        $nro        = $tmp->getNroProyecto();
        $id = $tmp->getId();
        $cliente  = $Aux->ElDato($nro,"Cotizacion","nro_cotizacion","razon_soc");
        $xnroproy[]=$nro;
        $fecha      = $tmp->getFechaCreacion();
        $creadopor  = $tmp->getCreadoPor();
        $elcreador = $Aux->ElDato($creadopor,"Usuarios","id","alias");
        $nombre     = $Aux->cleanHTMLChar($tmp->getNombreProyecto());
        $jefe = $tmp->getJefe();
        $encargado  = $tmp->getProyectistaAsignado();
        $elencargado = $Aux->ElDato($encargado,"Usuarios","id","alias");
        $nombre_encargado = $Aux->ElDato($encargado,"Usuarios","id","nombre");
        $eljefe = $Aux->ElDato($jefe,"Usuarios","id","alias");
        $nombre_jefe= $Aux->ElDato($jefe,"Usuarios","id","nombre");
        $estado     = $tmp->getEstado();
        $valor = $tmp->getValorPesos();
        $total+=$valor;
        $elestado = $Aux->ElDato($estado,"EstadoProyecto","id","descripcion");
        $color = $Aux->flipcolor($color);
        ?>
    <tr <?=$Aux->rowEffect($i, $color)?>>
        <td align="right"><?=$nro?></td>
        <td><?=$fecha?></td>
        <td><?=$nombre?></td>
        <td><?=$cliente?></td>
        <td><i class="fa fa-user-md"></i><?="$eljefe/$elencargado"?></td>
        <!--<td><?=$elcreador?></td>-->
        <td><?=$elestado?></td>
        <td align="right"><?=number_format($valor,0,",",".")?></td>
        <td><?php if($tipo!=4 && $editar_proy==1){?>
            <button name="b<?=$i?>" onclick="document.location='/index.php?p=nuevo_proyecto&nro_proyecto=<?=$nro?>&orden=<?=$orden?>&tipo_orden=<?=$tipo_orden?>&jefe=<?=$jefe?>&proyectista=<?=$proyectista?>&nombre_proyecto=<?=$nombre_proyecto?>';" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i>&nbsp;Editar</button><?php }?></td>
        <td><button name="b<?=$i?>" onclick="showRow('row<?=$i?>');requestPage('<?=$base_dir?>/includes/ver_proyecto.php?nro_proyecto=<?=$nro?>','proy<?=$i?>');" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i>&nbsp;Ver</button></td>
        <td><?php if($eliminar_proy==1){?>
            <button name="b<?=$i?>" onclick="if(confirm('Quiere Eliminar el proyecto?'))requestPage('<?=$base_dir?>/includes/eliminar_proyecto.php?nro_proyecto=<?=$nro?>','msg_pry<?=$i?>');"  class="btn btn-danger">Eliminar</button><?php }?> <div id="msg_pry<?=$i?>"></div></td>
    </tr>
    <tr id="row<?=$i?>" style="display: none">
        <td colspan="2"></td>
        <td colspan="9" class="celda_bordes"><div id="proy<?=$i?>">

            </div>
        </td>
    </tr>
    <?php
        $i++;
    }
    ?>
    <tr>
        <td colspan="6">Se encontrar&oacute;n <?=$nrofilas?> Proyectos&nbsp;</td>
        <td align="right"><?=number_format($total,0,",",".")?></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td align="center" colspan="10">
    <?php
            if ($limite>0){
                    $f = $nrofilas / $limite;
                    $nropag = $Aux->round_up($f);
            }
            if ($nropag > 0){
                    if (!$lapag) $lapag=1;
                    $url="$base_dir/includes/losproyectos.php?anno=$anno&mes=$mes&orden=$orden&tipo_orden=$tipo_orden";
                    $Aux->Paginador($url,"main_section",$lapag,$nropag,$primero,$limite,$inicio,$pag_show);
            }
    ?>
        </td>
    </tr>    
</table>





    