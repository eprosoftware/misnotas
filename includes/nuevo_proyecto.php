<?php
/*
 * Diseñado y desarrollado por Epro Software EIRL(c)2014
 * Cualquier cambio debe ser avisado a Epro Software
 */

/**
 * Nueva Cotización
 *
 * @author eroman
 * Fecha: 2014-05-18
 * 
 */

include_once str_replace("/includes","",getcwd())."/cfgdir.php";
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd()).'/includes/header.php';

    $Aux = new DBProyecto();
    $dbuser = new DBUsuario();

    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    $user = $dbuser->ElUsuario($id_user);
    $tipo = $user->getTipoUsuario();
    $asignar_proyectista = $user->getAsignarProyectista();
    $asignar_estado_proyecto = $user->getAsignarEstadoProyecto();
    
    $eltipo = $Aux->ElDato($tipo,"TipoUsuario","id","descripcion");
    
    $lip     = $_GET['lip'];
    $nueva   = $_GET['nueva'];
    $comando = $_GET['comando'];
    
    $anotacion_bit = $_POST['anotacion_bit'];
    $encargado      = $_GET['encargado'];
    $orden          = $_GET['orden'];
    $tipo_orden     = $_GET['tipo_orden'];
    $por_cobrado    = $_GET['por_cobrado'];
    $taller         = $_GET['taller'];
    $taller_segui   = $_GET['taller_segui'];
    $solo_segui     = $_GET['solo_segui'];
    $finalizado     = $_GET['finalizado'];
    $oc             = $_GET['oc'];
    $hes            = $_GET['hes'];    
    $jefe           = $_GET['jefe'];
    $proyectista    = $_GET['proyectista'];
    //$archivo = $_POST['archivo'];
    
    $nro_proyecto = $_GET['nro_proyecto'];
    
    if($comando==1){
        if($_FILES['archivo']){
            //echo "<p>EL ARCHIVO ESTA</p>";
            $tmp_name = $_FILES["archivo"]["tmp_name"];
            $name = $_FILES["archivo"]["name"];

            if(is_uploaded_file($_FILES['archivo']['tmp_name'])){

                //echo "<p>VAMOS A MOVER EL ARCHIVO AL SERVIDOR</p>";
                $fecha = date("Y-m-d H:i:s");

                $imgFile = $_FILES['archivo']['name'] ; 
                $imgFile = str_replace(' ','_',$imgFile); 
                $tmp_name = $_FILES['archivo']['tmp_name']; 

                $tipoarchivo =$_FILES['archivo']['type'];  

                if (!((strpos($tipoarchivo,"pdf")||strpos($tipoarchivo,"PDF")|| 
                       strpos($tipoarchivo,"png")|| strpos($tipoarchivo,"PNG")|| 
                        strpos($tipoarchivo,"gif")|| strpos($tipoarchivo,"GIF")||
                        strpos($tipoarchivo,"jpeg")|| strpos($tipoarchivo,"JPEG") 
                        ))){  
                   echo "Lo sentimos,no puede subir este tipo de archivo $tipoarchivo."; 
                } else { 

                   $eldir = DIR."/lib_archivos/";
                   if(move_uploaded_file($tmp_name, $eldir.$imgFile)) 
                   { 
                        echo "Se Guardo correctamente sus archivos que ingreso son: <br>"; 
                        echo "Nombre:".$_FILES['archivo']['name']."<br>"; 
                        echo "Tipo Archivo: <i>".$_FILES['archivo']['type']."</i><br>"; 
                        echo "Peso: <i>".$_FILES['archivo']['size']." bytes</i><br>"; 
                   }
                    $tmp = new BitacoraProyecto();
                    $fecha = date("Y-m-d H:i:s");
                    $tmp->setFecha($fecha);

                    $tmp->setNroProyecto($nro_proyecto);
                    $tmp->setIdUsuario($id_user);
                    $tmp->setAnotacion($anotacion_bit);
                    $tmp->setArchivo($_FILES['archivo']['name']);

                    echo $Aux->addBitacora($tmp);
                }
                fclose($fp);
             } else {
                echo "<p>PLOP</p>";
            }
        } else {
            echo "<p>SORRY NO ENCONTRE EL ARCHIVO</p>";

        }        
    }    
    
    $filtros="&encargado=$encargado&orden=$orden&tipo_orden=$tipo_orden&por_cobrado=$por_cobrado";
    $filtros.="&taller=$taller&taller_segui=$taller_segui&solo_segui=$solo_segui&finalizado=$finalizado";
    $filtros.="&oc=$oc&hes=$hes&nro_proyecto=$nro_proyecto&jefe=$jefe&proyectista=$proyectista";
    $filtros.="&orden=$orden&tipo_orden=$tipo_orden&estado=$estado";
    
    
    
    $fecha_hoy = date("Y-m-d");
    $lostipomoneda = $Aux->TraerLosDatos("TipoMoneda","id","descripcion");
    $losproyectistas = $Aux->TraerLosDatos("Usuarios","id","nombre");//, " where tipo_usuario>2");
    $losestados = $Aux->TraerLosDatos("EstadoProyecto","id","descripcion");
    
    if($nueva==1){
        $nro_proyecto = $Aux->getNroCotizacion();
    } else {
        $nro_proyecto = $_GET['nro_proyecto'];
    }
    if($nro_proyecto && $nueva!=1){
        $p = $Aux->getProyecto("",$nro_proyecto);
        
        $id_proy = $p->getId();
        $nombre_proyecto = $p->getNombreProyecto();
        $proyectista = $p->getProyectistaAsignado();
        $elproyectista = $Aux->ElDato($encargado,"Usuarios","id","nombre");
        $fecha_creacion = $p->getFechaCreacion();
        $valor_cobrado = $p->getValorPesos();
        //echo "<p>VP:$valor_cobrado</p>";
        $estado = $p->getEstado();
        $elestado = $Aux->ElDato($estado,"EstadoProyecto","id","descripcion");
        $valor_uf = $p->getValorUF();
        $tipo_proyecto = $p->getTipoProyecto();
    } else {
        $i = new Indicadores();
        $valor_uf = $i->getUf();
        $fecha_creacion = date("Y-m-d");
    }
    $tipo_moneda = ($tipo_moneda)?$tipo_moneda:1;
?>
<script>

function eliminar(x){
    makerequest("<?=$base_dir?>/includes/delPed.php?iddel="+x,"ped"+x);
    setTimeout(function(){makerequest('/includes/getPedidosProyecto.php?nro='+document.f.nro_proyecto.value,'det_pedidos');},100);        
}
function eliminarBit(x,u){
    //alert("<?=$base_dir?>/includes/delBitProy.php?iddel="+x);
    requestPage("<?=$base_dir?>/includes/delBitProy.php?iddel="+x,'elim'+x);
}
function validar(){
	MiSubmit('<?=$base_dir?>/includes/procesacotizacion.php?c=1')
}

function agregarPedido(id_item){
    nro  = document.f.nro_proyecto.value;
    //cod  = document.f.codigo.value;
    //item = document.f.str_item.value;
    //com  = document.f.comentario.value;
    //alert('/includes/addPedido.php?fecha='+fecha+'&nro='+nro+'&codigo='+cod+'&item='+item+'&comentario='+com);
    //makerequest('/includes/addPedido.php?nro='+nro+'&codigo='+cod+'&item='+item+'&id_item='+id_item+'&comentario='+com,'newPedido_div');
    //setTimeout(function(){makerequest('/includes/getPedidosProyecto.php?nro='+document.f.nro_proyecto.value,'det_pedidos');},100);    
    openWindow('<?=$base_dir?>/includes/nuevo_pedido.php?id_item='+id_item+'&nro='+nro,'Pedido',850,250);
}
function pedirDespacho(nroproy,id_item){
    openWindow('<?=$base_dir?>/includes/nuevo_despacho.php?id_item='+id_item+'&nro_proyecto='+nroproy,'Despacho',700,250);
}
function verDespacho(nroproy,id_item,n){
    requestPage('<?=$base_dir?>/includes/getDespachosProyecto.php?nro='+nroproy+'&iditem='+id_item,'detalle_'+n);
}
function layerTabla(){
    var obj = document.getElementById('layerTabla');
    toggleLayer('tabla_codigos');
    requestPage('<?=$base_dir?>/includes/tabla_codigos.php?t=1','tabla_codigos');
    //requestPage('/includes/tipos_codigos.php&titulo=Codigos','tabla_codigos');
}
function layerTabla2(){
    var obj = document.getElementById('layerTabla');
    toggleLayer('tabla_codigos');
    requestPage('<?=$base_dir?>/includes/tabla_codigos.php?t=2','tabla_codigos');
    //requestPage('/includes/tipos_codigos.php&titulo=Codigos','tabla_codigos');
}
function verificar(n){
    requestPage('<?=$base_dir?>/includes/verificar_nro_cotizacion.php?nro_cotizacion='+n,'msg');
    
    setTimeout(function(){makerequest('<?=$base_dir?>/includes/getItemCotizacion.php?nro='+document.f.nro_cotizacion.value,'det_cotiza');},100);
}
function crear_cotiza(){
    nro         = document.f.nro_cotizacion.value;
    nombre_proy = document.f.nombre_proyecto.value;
    encargado   = document.f.encargado.options[document.f.encargado.selectedIndex].value;
    valor       = document.f.valor_total.value;
    uf          = document.f.valor_uf.value;
    requestPage('<?=$base_dir?>/includes/crear_cotiza.php?valor_uf='+uf+'&creadopor=<?=$id_user?>&nro_cotizacion='+nro+'&nombre_proy='+nombre_proy+'&encargado='+encargado+'&valor_total='+valor,'salida_cotiza');
}
function modificar_cotiza(){
    nro         = document.f.nro_cotizacion.value;
    nombre_proy = document.f.nombre_proyecto.value;
    encargado   = document.f.encargado.options[document.f.encargado.selectedIndex].value;
    valor       = document.f.valor_total.value;
    uf          = document.f.valor_uf.value;
    requestPage('<?=$base_dir?>/includes/modificar_cotiza.php?valor_uf='+uf+'&creadopor=<?=$id_user?>&nro_cotizacion='+nro+'&nombre_proy='+nombre_proy+'&encargado='+encargado+'&valor_total='+valor,'salida_cotiza');
}
function crear_pdf(){
    openWindow('<?=$base_dir?>/includes/pdf_proyecto.php?nro_proyecto=<?=$nro_proyecto?>&descarga=1','salida_cotiza',160,10);
    
}
function captura(cod,desc){
    //alert('Codigo Capturado:'+cod);
    document.f.codigo.value = cod;
    document.f.str_item.value = desc;
    toggleLayer('tabla_codigos');
}
function agregar_codigo(){
    cod = document.f.codigo.value;
    desc = document.f.str_item.value;    
    if(confirm("Esta seguro que quiere agregar este codigo a la tabla de codigos?"))
    requestPage('<?=$base_dir?>/includes/add_tabla_codigos.php?cod='+cod+'&desc='+desc,'salida_codigo');
}
function crear_proyecto(){
    nro = document.f.nro_cotizacion.value;
    requestPage('<?=$base_dir?>/includes/crear_proyecto.php?nro='+nro,'salida_cotiza');
    
}
function dar_conformidad(ped){
    openWindow("<?=$base_dir?>/includes/dar_conformidad.php?id_ped="+ped,"Winped"+ped,500,150);
    setTimeout(function(){makerequest('/includes/getPedidosProyecto.php?nro='+document.f.nro_proyecto.value,'det_pedidos');},100);            
}

function marca_ep(pos,id_item){
    requestPage('<?=$base_dir?>/includes/marca_ep.php?pos='+pos+'&id_item='+id_item,'salida_item'+id_item);
    setTimeout(function(){makerequest('<?=$base_dir?>/includes/getItemProyecto.php?nro='+document.f.nro_proyecto.value,'det_proyecto');},100);            
}
function marca_taller(id_item){
    requestPage('<?=$base_dir?>/includes/marca_taller.php?id_item='+id_item,'salida_item'+id_item);
    setTimeout(function(){makerequest('<?=$base_dir?>/includes/getItemProyecto.php?nro='+document.f.nro_proyecto.value,'det_proyecto');},100);            
}
function marca_seguitaller(id_item){
    requestPage('<?=$base_dir?>/includes/marca_seguitaller.php?id_item='+id_item,'salida_item'+id_item);
    setTimeout(function(){makerequest('<?=$base_dir?>/includes/getItemProyecto.php?nro='+document.f.nro_proyecto.value,'det_proyecto');},100);            
}
function marca_solosegui(id_item){
    requestPage('<?=$base_dir?>/includes/marca_solosegui.php?id_item='+id_item,'salida_item'+id_item);
    setTimeout(function(){makerequest('<?=$base_dir?>/includes/getItemProyecto.php?nro='+document.f.nro_proyecto.value,'det_proyecto');},100);            
}
function marca_finalizado(id_item){
    if(confirm("Esta seguro que quiere finalizar el Item?"))
        requestPage('<?=$base_dir?>/includes/marca_finalizado.php?id_item='+id_item,'salida_item'+id_item);
    setTimeout(function(){makerequest('<?=$base_dir?>/includes/getItemProyecto.php?nro='+document.f.nro_proyecto.value,'det_proyecto');},100);            
}
function marca_hes(id_item){
    requestPage('<?=$base_dir?>/includes/marca_hes.php?id_item='+id_item,'salida_item'+id_item);
    setTimeout(function(){makerequest('<?=$base_dir?>/includes/getItemProyecto.php?nro='+document.f.nro_proyecto.value,'det_proyecto');},100);            
}
function marca_oc(id_item){
    requestPage('<?=$base_dir?>/includes/marca_oc.php?id_item='+id_item,'salida_item'+id_item);
    setTimeout(function(){makerequest('<?=$base_dir?>/includes/getItemProyecto.php?nro='+document.f.nro_proyecto.value,'det_proyecto');},100);            
}
function marca_anticipo(id_item){
    if(confirm("Esta Seguro de enviar a Facturar?"))
    requestPage('<?=$base_dir?>/includes/marca_anticipo.php?id_item='+id_item,'salida_item'+id_item);
    setTimeout(function(){makerequest('<?=$base_dir?>/includes/getItemProyecto.php?nro='+document.f.nro_proyecto.value,'det_proyecto');},100);                
}
function marca_entrega(id_item){
    if(confirm("Esta Seguro de enviar a Facturar?"))
    requestPage('<?=$base_dir?>/includes/marca_entrega.php?id_item='+id_item,'salida_item'+id_item);
    setTimeout(function(){makerequest('<?=$base_dir?>/includes/getItemProyecto.php?nro='+document.f.nro_proyecto.value,'det_proyecto');},100);                
}
function marca_aprobado(id_item){
    if(confirm("Esta Seguro de enviar a Facturar?"))
    requestPage('<?=$base_dir?>/includes/marca_aprobado.php?id_item='+id_item,'salida_item'+id_item);
    setTimeout(function(){makerequest('<?=$base_dir?>/includes/getItemProyecto.php?nro='+document.f.nro_proyecto.value,'det_proyecto');},100);                
}
function modificar(){
    n = document.f.nombre_proyecto.value;
    pr = document.f.proyectista.options[document.f.proyectista.selectedIndex].value;
    e = document.f.estado.options[document.f.estado.selectedIndex].value;
    v = document.f.valor_cobrado.value;
    requestPage('<?=$base_dir?>/includes/modProyecto.php?id=<?=$id_proy?>&nombre_proyecto='+n+'&proyectista='+pr+'&estado='+e+'&valor_cob='+v,'salidaMod');
}
function addBitacora(anotacion){
    //alert('<?=$base_dir?>/includes/addBitacora.php?nro_proyecto=<?=$nro_proyecto?>&fecha=<?=$fecha_hoy?>&id_usuario=<?=$id_user?>&anotacion='+anotacion);
    makerequest('<?=$base_dir?>/includes/addBitacora.php?nro_proyecto=<?=$nro_proyecto?>&fecha=<?=$fecha_hoy?>&id_usuario=<?=$id_user?>&anotacion='+anotacion,'salida_anotacion');
    setTimeout(function(){ 
        makerequest('<?=$base_dir?>/includes/getBitacoraProyecto.php?nro='+document.f.nro_proyecto.value    ,'det_bitacora');    },100);
}
function editarItem(id){
    openWindow('<?=$base_dir?>/includes/forma_pago.php?id_item='+id,'EditarItem',1042,241);
}
</script>
    <div class="panel panel-default">
        <div class="panel-heading"><h1><b>PROYECTO <?=substr("00000000$nro_proyecto",-5)?></b></h1></div>
        <div class="panel-body">


    <input type="hidden" name="id" value="<?=$id_proy?>">
    
    <table class="table table-bordered table-striped">
        <tr>
            <td>
                <table class="table table-bordered table-striped">
                    <tr>
                        <td></td>
                        <td align="right">
                            <button class="btn btn-primary" onclick="document.location='<?=$base_dir?>/index.php?p=<?=($lip==1)?"listado_item_proyectos":"losproyectos"?>';">Volver</button>
                        </td>                        
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>    
                <form action="" method="POST" name="f" enctype="multipart/form-data">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>Nro. Proyecto:</td>
                            <td><?php if($nueva==1){?><input type="text" size="4" name="nro_proyecto" value="<?=$nro_proyecto?>" onblur="verificar(this.value)"><div id="msg"></div>
                            <?php } else {?>
                                <h2><?=substr("00000000$nro_proyecto",-5)?></h2><input type="hidden" size="4" name="nro_proyecto" value="<?=$nro_proyecto?>">
                            <?php }?>
                            </td>
                        </tr>
                        <tr>
                            <td>Fecha Sistema:</td>
                            <td><?=$fecha_creacion?></td>
                        </tr>
                        <tr valign="top">
                            <td>Nombre Proyecto:</td>
                            <td><textarea name="nombre_proyecto" cols="40" rows="4"  onblur="this.value = this.value.toUpperCase();"><?=$nombre_proyecto?></textarea></td>
                        </tr>
                        <tr>
                            <td>Proyectista:</td>
                            <td><?php if($asignar_proyectista==1){
                                            echo $Aux->SelectArrayBig($losproyectistas,"proyectista","Seleccionar Proyectista",$proyectista);
                            } else { echo $elproyectista;}?></td>
                        </tr>
                        <tr>
                            <td>Tipo Proyecto:</td>
                            <td><?=$Aux->ElDato($tipo_proyecto,"TipoProyecto","id","descripcion")?></td>
                        </tr>
                        <tr>
                            <td>Estado</td>
                            <td>
                                <?php 
                                if($asignar_estado_proyecto==1){
                                            echo $Aux->SelectArrayBig($losestados,"estado","Seleccione Estado",$estado);
                                } else {
                                    echo $elestado;
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Valor Cobrado (CLP):</td>
                            <td><?="$".number_format($valor_cobrado,0,",",".")?>
                                <input type="text" size="12" name="valor_cobrado" value="<?=$valor_cobrado?>"></td>
                        </tr>
                        <tr>
                            <td>
                                <button name="mb" onclick="modificar()" class="btn btn-primary">Modificar</button>
                                <button name="mb1" onclick="crear_pdf()" class="btn btn-primary">Enviar Correo/PDF</button>
                                <div id="salidaMod"></div>
                            </td>
                        </tr>
                        <tr class="hnavbg">

                        </tr>

                        <tr>
                            <td colspan="2"><div id="det_proyecto"><?php 
                            $nrop =$nro_proyecto;
                            include 'getItemProyecto.php';
                            ?></div></td>
                        </tr>   
                        <tr class="hnavbg">
                            <td colspan="2">Bitacora Proyecto</td>    
                        </tr>

                        <tr>
                            <td colspan="2">
                                <table>
                                    <tr valign="top">
                                        <td>Anotaci&oacute;n Bit&aacute;cora:</td>
                                        <td><textarea cols="60" rows="3" name="anotacion_bit" onblur="this.value = this.value.toUpperCase();"></textarea></td>
                                        <td><button type="button" name="ab" onclick="addBitacora(document.f.anotacion_bit.value);" class="btn btn-primary">Agregar Anotaci&oacute;n</button></td>
                                        <td><div id="salida_anotacion"></div></td>
                                    </tr>
                                    <tr>
                                        <td>Archivo:</td>
                                        <td><input type="file" name="archivo" class="form-control"> </td>
                                        <td><button type="button" onclick="MiSubmit('<?=$base_dir?>/index.php?p=nuevo_proyecto&comando=1&nro_proyecto=<?=$nro_proyecto?>')" class="btn btn-primary">Subir Archivo</button></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2"><div id="det_bitacora"></div></td>
                        </tr>


                        <tr>
                            <td colspan="2"><div id="det_pedidos"></div></td>
                        </tr>  

                    </table>
                </form>
            </td>
        </tr>
    </table>

            
        </div>
    </div>

<script>
    //requestPage('/includes/getItemProyecto.php?nro=<?=$nro_proyecto?>','det_proyecto');

    setTimeout(function(){ 
        requestPage('<?=$base_dir?>/includes/getBitacoraProyecto.php?nro=<?=$nro_proyecto?>','det_bitacora');    },100);    
    
    //setTimeout(function(){ 
    //    requestPage('/includes/getPedidosProyecto.php?nro=<?=$nro_proyecto?>','det_pedidos');    },150);    
</script>
