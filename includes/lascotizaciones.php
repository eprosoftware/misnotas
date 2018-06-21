<?php
    include_once str_replace("/includes","",getcwd()).'/includes/header.php';
    include_once str_replace("/includes","",getcwd()).'/class/config.php';
    

    $Aux = new DBCotizacion();
    $dbuser = new DBUsuario();

    $primero    = ($_GET['primero'])?$_GET['primero']:$_POST['primero'];
    $pag_show   = ($_GET['pag_show'])?$_GET['pag_show']:$_POST['pag_show'];
    $lapag      = $_GET['lapag'];
    $limite     = ($_GET['limite'])?$_GET['limite']:$_POST['limite'];
    $inicio     = $_GET['inicio'];
    $tipo_modulo = ($_POST['tipo_modulo'])?$_POST['tipo_modulo']:$_GET['tipo_modulo'];
    $fecha1 = ($_POST['fecha1'])?$_POST['fecha1']:$_GET['fecha1'];
    $fecha2 = ($_POST['fecha2'])?$_POST['fecha2']:$_GET['fecha2'];

        $ordenarpor     = ($_POST['ordenarpor'])?$_POST['ordenarpor']:$_GET['ordenarpor'];
        $tipo_orden     = ($_POST['tipo_orden'])?$_POST['tipo_orden']:$_GET['tipo_orden'];

    $limite     = ($limite)?$limite:10;
    $primero    = ($primero)?$primero:1;
    $inicio     = ($inicio)?$inicio:0;
    $pag_show   = (!$pag_show)?15:$pag_show;
    $lapag      = (!$lapag)?1:$lapag;    
    
    $id_user  = $dbuser->getUsuarioId($usuario,$clave);
    $user = $dbuser->ElUsuario($id_user);
    $tipo = $user->getTipoUsuario();
    $eliminar_coti = $user->getEliminarCotizacion();
    //echo "<p>IU:$id_user EC:$eliminar_coti</p>";
    
    $estado = ($_GET['estado'])?$_GET['estado']: $_POST['estado'];
    $nro_cotizacion=$_POST['nro_cotizacion'];
    $descripcion = $_POST['descripcion'];
    $orden = ($_POST['orden'])?$_POST['orden']:$_GET['orden'];
    $tipo_orden = ($_POST['tipo_orden'])?$_POST['tipo_orden']:$_GET['tipo_orden'];
    $anno = ($_POST['anno'])?$_POST['anno']:$_GET['anno'];
    $mes = ($_POST['mes'])?$_POST['mes']:$_GET['mes'];

    $orden = ($orden)?$orden:2;
    $tipo_orden = ($tipo_orden)?$tipo_orden:2;
    
    $estado =($estado)?$estado:"1,2,3,4";
    $ax = $Aux->get("",$nro_cotizacion,$descripcion,$estado,$orden,$tipo_orden,$anno,$mes,$primero,$limite);
    $lascotizaciones = $ax['salida'];
    $nrofilas = $ax['nrofilas'];
    
    $losestados = $Aux->TraerLosDatos("EstadoCotizacion","id","descripcion");
    $losmeses = $Aux->TraerLosDatos("Meses","id","descripcion");
    

    
    $losordenes=array();
    $tmp=array();$tmp['valor']=1;$tmp['txt']="Nro.Cotizacion";$losordenes[]=$tmp;
    $tmp=array();$tmp['valor']=2;$tmp['txt']="Fecha";$losordenes[]=$tmp;
    $lostiposO=array();
    $tmp=array();$tmp['valor']=1;$tmp['txt']="&UpArrow; Asc";$lostiposO[]=$tmp;
    $tmp=array();$tmp['valor']=2;$tmp['txt']="&DownArrow; Desc";$lostiposO[]=$tmp;        
    ?>
<div class="panel panel-default">
    <div class="panel-heading"><h2>Cotizaciones</h2></div>
    <div class="panel-body">
            <form action="/index.php?p=lascotizaciones" method="POST" name="f">
            <table class="table table-bordered table-striped">
                <tr>
                    <td><input type="text" size="5" name="nro_cotizacion" value="<?=$nro_cotizacion?>" placeholder="Nro. Cotiza" class="form-control"></td>
                    <td><input type="number" name="anno" value="<?=$anno?>" placeholder="A&ntilde;o" class="form-control"></td>
                    <td><?=$Aux->SelectArray($losmeses,"mes","Seleccione Mes",$mes)?></td>
                    <td><input type="text" size="30" name="descripcion" value="<?=$descripcion?>" placeholder="Descripci&oacute;n:" class="form-control"></td>
                    <td><?=$Aux->SelectArray($losestados,"estado","Seleccione Estado",$estado)?></td>
                    <td><?=$Aux->SelectArray($losordenes,"orden","Ordenar Por",$orden)?><?=$Aux->SelectArray($lostiposO,"tipo_orden","&UpArrow; &DownArrow;",$tipo_orden)?>
                    </td>
                    <td>Nro.Registros:<input type="text" size="2" name="limite" value="<?=$limite?>" class="form-control"></td>
                    <td><button type="submit" class="btn btn-primary" name="a"><i class="glyphicon glyphicon-filter"></i>&nbsp;Aplicar Filtro</button></td>
                </tr>
            </table>
            </form>        
    </div>
</div>
<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>Nro.</th>
            <th width="130">Fecha</th>
            <th>Nombre Proyecto</th>
            <th>Cliente</th>
            <!--<th>Creado Por</th>-->
            <th>Estado</th>
            <th>Moneda</th>
            <th>Valor UF</th>
            <th colspan="5">Operaciones</th>
        </tr>
    </thead>
    <?php
    $i=0;$total=array();$total_uf=0;
    while($tmp=$lascotizaciones[$i]){
        $nro        = $tmp->getNroCotizacion();
        $fecha      = $tmp->getFecha();
        $creadopor  = $tmp->getCreadoPor();
        $elcreador = $Aux->ElDato($creadopor,"Usuarios","id","nombre");
        $nombre     = $tmp->getNombreProyecto();
        $encargado  = $tmp->getEncargado();
        $elencargado = $Aux->ElDato($encargado,"Usuarios","id","nombre");
        $tipo_moneda = $tmp->getTipoMoneda();
        $lamoneda = $Aux->ElDato($tipo_moneda,"TipoMoneda","id","descripcion");
        $uf_aplicada = $tmp->getValorUF();
        $valor      = $tmp->getValorCotizacion();
        $valor_uf   = $tmp->getValorCotizacionUF();
        $cliente = $tmp->getRazonSocial();
        
        //$total[$tipo_moneda]+=$valor;
        $total_uf+=$valor_uf;
        
        switch($tipo_moneda){
            case 1: $total[$tipo_moneda]+=$valor_uf;break;
            case 2: $total[$tipo_moneda]+=$valor;break;
        }
        $estado     = $tmp->getEstado();
        $elestado = $Aux->ElDato($estado,"EstadoCotizacion","id","descripcion");
        $color = $Aux->flipcolor($color);
        ?>
    <tr>
        <td align="right"><?=$nro?></td>
        <td><?=$fecha?></td>
        <td><?=$nombre?></td>
        <td><?=$cliente?></td>
        <!--<td><?=$elcreador?></td>-->
        <td><?=$elestado?></td>
        <td><?=$lamoneda?></td>
        
        <td align="right"><?=number_format($valor_uf,2,",",".")?></td>
        <td><button name="b<?=$i?>" onclick="document.location='/index.php?p=nueva_cotizacion&nro_cotizacion=<?=$nro?>';" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i>&nbsp;Editar</button></td>
        <td><button name="b<?=$i?>" onclick="showRow('row<?=$i?>');requestPage('/includes/show_cotizacion.php?nro_cotizacion=<?=$nro?>','coti<?=$i?>');" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i>&nbsp;Ver</button></td>
        <td><?php if($estado==2){?><button name="b<?=$i?>" onclick="if(confirm('Desea generar el Proyecto?')) requestPage('/includes/genProyecto.php?nro_cotizacion=<?=$nro?>','coti<?=$i?>');" class="btn btn-primary">Generar Proyecto</button><?php }?></td>
        <td><?php if($eliminar_coti==1){?><button name="b<?=$i?>" onclick="if(confirm('Esta seguro de querer eliminarla?'))requestPage('/includes/eliminar_cotizacion.php?nro_cotizacion=<?=$nro?>','msg_cot<?=$i?>');" class="btn btn-danger">Eliminar</button><?php }?></td>        
        <td><div id="msg_cot<?=$i?>"></div></td>
    </tr>
    <tr id="row<?=$i?>" style="display: none">
        <td></td><td></td>
        <td colspan="10" align="right"><div id="coti<?=$i?>"></div></td>
    </tr>
    <?php
        $i++;
    }
    if($i==0){
        ?>
    <tr>
        <td colspan="12" class="titulonegro12">Lo sentimos, pero no se Encontraron cotizaciones</td>
    </tr>
            <?php
    }
    ?>
    <tr>
        <td colspan="6">Se encontrar&oacute;n <?=$i?> cotizaciones</td>
        <td colspan="2" align="right">
            <table class="table table-bordered">
                <tr>
                    <?php
                    for($k=1;$k<4;$k++){
                        $lamoneda = $Aux->ElDato($k,"TipoMoneda","id","descripcion");
                        $t = $total[$k];
                        if($t>0){
                            switch($k){
                                case 1:
                                case 3:
                                    echo "<td align='right'>$lamoneda:".number_format($t,2,",",".")."&nbsp;</td>";
                                    break;
                                case 2:
                                    echo "<td align='right'>$lamoneda:".number_format($t,0,",",".")."&nbsp;</td>";
                                    break;                            
                            }
                        }    
                    }
                    ?>
                </tr>
            </table>
        </td>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td align="center" colspan="12">
    <?php
            if ($limite>0){
                    $f = $nrofilas / $limite;
                    $nropag = $Aux->round_up($f);
            }
            if ($nropag > 0){
                    if (!$lapag) $lapag=1;
                    $url="/proyectos/includes/lascotizaciones.php?anno=$anno&mes=$mes&orden=$orden&tipo_orden=$tipo_orden";
                    $Aux->Paginador($url,"main_section",$lapag,$nropag,$primero,$limite,$inicio,$pag_show);
            }
    ?>
        </td>
    </tr>
</table>

    