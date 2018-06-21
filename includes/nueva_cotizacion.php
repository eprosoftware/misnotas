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
include_once str_replace("/includes","",getcwd())."/cfgdir.php";
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd()).'/includes/header.php';

    $Aux = new DBCotizacion();
    $dbuser = new DBUsuario();
    $i = new Indicadores();

        
    $i->setValores();
    //Limpiar UF de Hoy
    $uf_h = $i->getUf();
    $uf_h = $uf_h;
    $uf_hoy = str_replace(",",".",$uf_h);
    //Dolar de Hoy
    $us_hoy = str_replace(",",".",$i->getDolar());
    
    if($us_hoy=="") $us_hoy=0;
    echo "<!--UF:$uf_hoy US:$us_hoy -->";
    
    //$id_user    = $_SESSION['IDUSUARIO'];// $dbuser->getUsuarioId($usuario,$clave);
    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    $u = $dbuser->ElUsuario($id_user);
    $ddel = $u->getEliminarCotizacion();
    
    $nueva = $_GET['nueva'];
    $nro_pagos =$_POST['nro_pagos'];
    
    
    
    $lostipomoneda = $Aux->TraerLosDatos("TipoMoneda","id","descripcion");
    $losproyectistas = $Aux->TraerLosDatos("Usuarios","id","nombre");//," where  tipo_usuario=3");
    $lostiposproyecto = $Aux->TraerLosDatos("TipoProyecto","id","descripcion"," order by descripcion");
    if($nueva==1){
        $nro_cotizacion = $Aux->getNroCotizacion();
    } else {
        $nro_cotizacion = $_GET['nro_cotizacion'];
    }
    if($nro_cotizacion && $nueva!=1){
        $ax = $Aux->get("",$nro_cotizacion);
        $a = $ax['salida'];
        $c = new Cotizacion();
        $c=$a[0];
        if($c){
            $nombre_proyecto    = $c->getNombreProyecto();
            $condiciones        = str_replace("\n","<BR>",$c->getCondiciones());
            $encargado          = $c->getEncargado();
            $fecha              = $c->getFecha();
            $valor_uf           = ($c->getValorUF())?$c->getValorUF():$uf_hoy;
            $valor_us           = ($c->getValorUS())?$c->getValorUS():$us_hoy;
            $estado             = $c->getEstado();
            $elestado           = $Aux->ElDato($estado,"EstadoCotizacion","id","descripcion");
            $vrut               = $c->getRut();
            $razsoc             = $c->getRazonSocial();
            $email              = $c->getEmail();
            $fono               = $c->getFono();
            $direccion          = $c->getDireccion();
            $comuna             = $c->getComuna();
            $nro_pagos          = $c->getNroPagos();
            $tipo_doc           = $c->getTipoDoc();
            $tipo_proyecto      = $c->getTipoProyecto();
            $nro_dias_valido    = $c->getNroDiasValido();
            $moneda             = $c->getTipoMoneda();
            $descuento          = $c->getDescuento();
            $dias_restantes     = $c->getDiasValidosRestantes();
            $fecha_envio        = $c->getFechaEnviado();
            $mensaje_cotiza     = utf8_decode($c->getMensajeCotiza());
            $archivo            = $c->getArchivo();

            $prefijo = str_replace("-","",$fecha);
        }
    } else {

        $valor_uf = str_replace(",",".",$i->getUf());
        $valor_us = str_replace(",",".",str_replace("$","",$i->getDolar()));
        $fecha = date("Y-m-d");
        $elestado="Nuevo";
    }
    $nro_pagos = ($nro_pagos)?$nro_pagos:$Aux->ElDato($id_user,"Configuracion","id_usuario","nro_pagos");
    //$tipo_moneda = ($tipo_moneda)?$tipo_moneda:1;
    $losestados = $Aux->TraerLosDatos("EstadoCotizacion","id","descripcion");
    $lascomunas = $Aux->TraerLosDatos("st_comuna","id","descripcion"," order by descripcion ");
    $lasmonedas = $Aux->TraerLosDatos("TipoMoneda","id","descripcion");
    //$losdescuentos = $Aux->TraerLosDatos("Descuentos","id","descuento");
    $losdocumentos =array();
    $tmp= array();$tmp['txt']="Boleta de Honorarios";$tmp['valor']=1;$losdocumentos[]=$tmp;
    $tmp= array();$tmp['txt']="Factura";$tmp['valor']=2;$losdocumentos[]=$tmp;
    $tmp= array();$tmp['txt']="Factura Exenta";$tmp['valor']=3;$losdocumentos[]=$tmp;
    $lospagos = array();
    $tmp=array(); $tmp['txt']=" 1.-"; $tmp['valor']=1;$lospagos[]= $tmp;
    $tmp=array(); $tmp['txt']=" 2.-"; $tmp['valor']=2;$lospagos[]= $tmp;
    $tmp=array(); $tmp['txt']=" 3.-"; $tmp['valor']=3;$lospagos[]= $tmp;
    $tmp=array(); $tmp['txt']=" 4.-"; $tmp['valor']=4;$lospagos[]= $tmp;
    $tmp=array(); $tmp['txt']=" 5.-"; $tmp['valor']=5;$lospagos[]= $tmp;
    $tmp=array(); $tmp['txt']=" 6.-"; $tmp['valor']=6;$lospagos[]= $tmp;
    $tmp=array(); $tmp['txt']=" 7.-"; $tmp['valor']=7;$lospagos[]= $tmp;
    $tmp=array(); $tmp['txt']=" 8.-"; $tmp['valor']=8;$lospagos[]= $tmp;
    $tmp=array(); $tmp['txt']=" 9.-"; $tmp['valor']=9;$lospagos[]= $tmp;
    $tmp=array(); $tmp['txt']="10.-"; $tmp['valor']=10;$lospagos[]= $tmp;
    $tmp=array(); $tmp['txt']="11.-"; $tmp['valor']=11;$lospagos[]= $tmp;
    $tmp=array(); $tmp['txt']="12.-"; $tmp['valor']=12;$lospagos[]= $tmp;
    
    $lasopciones = array();
    $tmp=array();$tmp['txt']="S&Iacute;";$tmp['valor']=1;$lasopciones[]=$tmp;
    $tmp=array();$tmp['txt']="NO";$tmp['valor']=2;$lasopciones[]=$tmp;
    $adjunta_pdf = 2;
    
    $mayusculas = "onblur='document.f.valor.focus();this.value = this.value.toUpperCase();'";
?>
<script>
function poner_fecha(obj,valor){
    elem =  document.getElementById(obj);
    //obj_section =  document.getElementById(section);
    if (elem)
        elem.value = valor;
    else
        alert("No se asigno elem");
    //toggleLayer(section);
}


function addValor(id,tp,ttrab,glosa,fecha_glosa,valor,moneda,a,e,ap,pa,pe,pp,trabajos){
    document.forms[0].monedadet.value = moneda;
    if (actualiza_por() )
        makerequest('/syscot/includes/showDetalleCot.php?show=1&c=1&id='+id+
                             '&idtipoproyecto='+tp+
                             '&trabajo='+ttrab+
                             '&monedadet='+moneda+
                             '&glosa='+glosa+
                             '&fecha_glosa='+fecha_glosa+
                             '&valor='+valor+
                             '&anticipo='+a+
                             '&entrega='+e+
                             '&aprobado='+ap+
                             '&poranticipo='+pa+
                             '&porentrega='+pe+
                             '&poraprobado='+pp+
                             '&trabajos_seleccionados='+trabajos,'detalle_cot');

      
        
}

function validar(){
	MiSubmit('/includes/procesacotizacion.php?c=1')
}
function buscar_contacto(campo,valor,eldiv){
	makerequest("/includes/busca_contactos.php?campo="+campo+"&nombre="+valor,eldiv);
}
function buscar_cliente(campo,valor,eldiv){
	makerequest("/includes/buscar_clientes.php?tipos=1&campo="+campo+"&nombre="+valor,eldiv);
}
function uptTipoTrabajo(t){
    makerequest('/includes/showTipoTrabajo.php?escotiza=1&idtipoproyecto='+t,'lostipos');
    
}
function moduf(){
}
function crear_pdf(){
    uf = document.getElementById('valor_uf').value;
    e = document.f.email.value;
    o = document.getElementById("tipo_doc");
    t = o.options[o.selectedIndex].value;
    p = document.getElementById("adjunta_pdf");
    pf =p.options[p.selectedIndex].value;
    m = document.f.mensaje_cotiza.value;
    
    if(confirm('Desea enviar el pdf a '+e+' ?') && e!=""){
        if(t>0){
        alert('/includes/pdf_cotizacion.php?nro_cotizacion=<?=$nro_cotizacion?>&descarga=1&lauf='+uf+'&email='+e+'&tipo_doc='+t+'&adjunta_pdf='+pf+'&mensaje='+m);    
        openWindow('/includes/pdf_cotizacion.php?nro_cotizacion=<?=$nro_cotizacion?>&descarga=1&lauf='+uf+'&email='+e+'&tipo_doc='+t+'&adjunta_pdf='+pf+'&mensaje='+m,'salida_cotiza',260,100);
    } else {
        alert("Tiene que seleccionar un tipo de documento,Gracias");
        document.f.tipo_doc.focus();
    }
    } else {
        alert("Tienes que ingresar un E-Mail valido");
        document.f.email_pdf.focus();
    }
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
    requestPage('/includes/add_tabla_codigos.php?cod='+cod+'&desc='+desc,'salida_codigo');
}

function modificar_cotiza(id_user){
    nro         = document.f.nro_cotizacion.value;
    nombre_proy = document.f.nombre_proyecto.value;
    e           = document.f.encargado.options[document.f.encargado.selectedIndex].value;
    valor       = document.f.valor_neto.value;
    uf          = document.f.valor_uf.value;
    us          = document.f.valor_us.value;
    c           = document.f.condiciones.value;
    rut         = document.f.vrut.value;
    rz          = document.f.razsoc.value;
    email       = document.f.email.value;
    fono        = document.f.fono.value;
    direccion   = document.f.direccion.value;
    com         = document.f.comuna.options[document.f.comuna.selectedIndex].value;
    np          = document.f.nro_pagos.options[document.f.nro_pagos.selectedIndex].value;
    td          = document.f.tipo_doc.options[document.f.tipo_doc.selectedIndex].value;
    tp          = document.f.tipo_proyecto.options[document.f.tipo_proyecto.selectedIndex].value;
    est         = document.f.estado.options[document.f.estado.selectedIndex].value;
    nd          = document.f.nro_dias_valido.value;
    de          = document.f.descuento.value;
    mc          = document.f.mensaje_cotiza.value;
    tm = document.getElementById('moneda').options[document.getElementById('moneda').selectedIndex].value;
    //alert('/includes/modificar_cotiza.php?valor_uf='+uf+'&valor_us='+us+'&creadopor='+id_user+'&nro_cotizacion='+nro+'&nombre_proy='+nombre_proy+'&valor_total='+valor+'&encargado='+e+'&condiciones='+c+'&rut='+rut+'&razsoc='+rz+'&email='+email+'&fono='+fono+'&direccion='+direccion+'&comuna='+com+'&nropagos='+np+'&tipo_doc='+td+'&tipo_proyecto='+tp+'&nro_dias_valido='+nd+'&estado='+est+'&tipo_moneda='+tm+'&descuento='+de +'&mensaje_cotiza='+mc);
    requestPage('/includes/modificar_cotiza.php?valor_uf='+uf+'&valor_us='+us+'&creadopor='+id_user+'&nro_cotizacion='+nro+'&nombre_proy='+nombre_proy+'&valor_total='+valor+'&encargado='+e+'&condiciones='+c+'&rut='+rut+'&razsoc='+rz+'&email='+email+'&fono='+fono+'&direccion='+direccion+'&comuna='+com+'&nropagos='+np+'&tipo_doc='+td+'&tipo_proyecto='+tp+'&nro_dias_valido='+nd+'&estado='+est+'&tipo_moneda='+tm+'&descuento='+de +'&mensaje_cotiza='+mc,'salida_cotiza');    
    
}
function validaForm(){
    // Campos de texto
    if($("#nombre_proyecto").val() == ""){
        alert("El campo Nombre no puede estar vacío.");
        $("#nombre_proyecto").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
    }
    if($("#condiciones").val() == ""){
        alert("El campo Apellidos no puede estar vacío.");
        $("#apellidos").focus();
        return false;
    }
    return true; // Si todo está correcto
}

$(document).on('ready',function(){       
    $('#modbtn').click(function(){
        var url = "/includes/modificar_cotiza.php?valor_uf=<?=$uf_hoy?>&valor_us=<?=$us_hoy?>&creadopor=<?=$id_user?>&valor_total=<?=$valor_total?>";
        $.ajax({                        
           type: "POST",                 
           url: url,                     
           data: $("#f").serialize(), 
           success: function(data)             
           {
             $('#formulario').html(data);               
           }
       });
    });
});


function layerTabla(){
    var obj = document.getElementById('layerTabla');
    toggleLayer('tabla_codigos');
    requestPage('/includes/tabla_codigos.php?t=1','tabla_codigos');
    //requestPage('/includes/tipos_codigos.php&titulo=Codigos','tabla_codigos');
}
function crear_proyecto(){
    requestPage('/includes/crear_proyecto.php?nro=<?=$nro_cotizacion?>','salida_cotiza');
}
function buscar_rut(r){
    requestPage('/includes/buscar_rut.php?rut='+r,'datosCliDiv');
}
function buscar_cli(n){
    requestPage('/includes/buscar_cli.php?nombre='+n,'datosCliDiv');
}
</script>
    <div class="panel panel-default">
        <div class="panel-heading">
            <table width="100%">
                <tr>
                    <td><h1><b><!--(<?=$usuario?>:<?=$id_user?>)-->COTIZACI&Oacute;N <?=substr("00000000$nro_cotizacion",-5)?></b></h1></td>
                    <td align="right"><button class="btn btn-primary pull-right" onclick="document.location='/index.php?p=lascotizaciones'">Volver</button></td>
                </tr>
            </table>
        </div>
        <div class="panel-body">
<div id="formulario">
    <form action="/index.php?p=modificar_cotiza" method="POST" name="f" id="f" enctype="multipart/form-data">
        <input type="hidden" name="valor_uf" id="valor_uf" value="<?=$valor_uf?>">
        <input type="hidden" name="valor_us" id="valor_us" value="<?=$valor_us?>">
    <table width="100%">
        <tr>
            <td>  
                <table class="table table-bordered table-striped">
                    <tr valign="top">
                        <td>
                            <div class="panel panel-default">
                                <div class="panel-heading"><h2>Datos Cotizaci&oacute;n</h2></div>
                                <div class="panel-body">
                                    <table style="border-radius: 10px 10px 10px 10px">
                                        <tr valign="top">
                                            <td>
                                                <table class="table table-bordered" style="border-radius: 10px 10px 10px 10px">
                                                    <tr>
                                                        <td align="right">Nro. Cotizaci&oacute;n:</td>
                                                        <td><?php if($nueva==1){?><input type="text" size="4" name="nro_cotizacion" value="<?=$nro_cotizacion?>" onblur="verificar(this.value)"><div id="msg"></div>
                                                        <?php } else {?>
                                                            <font size="5"><?=substr($prefijo."0$nro_cotizacion",-15)?></font><input type="hidden" size="4" name="nro_cotizacion" value="<?=$nro_cotizacion?>">
                                                        <?php }?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right">Fecha Sistema:</td>
                                                        <td><?=$fecha?></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right">Nombre Proyecto (descripci&oacute;n):</td>
                                                        <td><textarea name="nombre_proyecto" rows="4" class="form-control" onblur="this.value = this.value.toUpperCase();"><?=$Aux->cleanHTMLChar($nombre_proyecto)?></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right">Jefe de Proyecto:</td>
                                                        <td><?=$Aux->SelectArray($losproyectistas,"encargado","Seleccionar Encargado",$encargado)?></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right">Condiciones de Pago:</td>
                                                        <td><textarea name="condiciones" cols="40" rows="4" onblur="this.value = this.value.toUpperCase();" class="form-control"><?=$condiciones?></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right">Tipo Proyecto:</td>
                                                        <td><?=$Aux->SelectArray($lostiposproyecto,"tipo_proyecto","Selecciona Tipo",$tipo_proyecto)?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <table width="100%">
                                                                <tr>
                                                                    <td align="right">Tipo Moneda:</td>
                                                                    <td><?=$Aux->SelectArray($lasmonedas,"moneda","---",$moneda)?></td>
                                                                    <td align="right">Nro. Pagos:</td>
                                                                    <td>
                                                                        <table>
                                                                            <tr>
                                                                                <td><?=$Aux->SelectArray($lospagos,"nro_pagos","---",$nro_pagos,"","requestPage('/syscot/includes/showPagos.php?nro_pagos='+this.value,'muestraPagos');");?></td>
                                                                                <td><button type="button" class="btn btn-primary" name="actDet" onclick="requestPage('/includes/getItemCotizacion.php?ddel=<?=$ddel?>&nropagos='+this.value+'&lauf='+document.f.valor_uf.value+'&nro='+document.f.nro_cotizacion.value,'det_cotiza');">Actualizar Detalle</button></td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>                                            
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <table>
                                                                <tr>
                                                                    <td align="right">Nro. Dias Valido:</td>
                                                                    <td><input type="number" name="nro_dias_valido" value="<?=$nro_dias_valido?>" size="3" class="form-control"></td>
                                                                    <td>Correo Enviado <?=$fecha_envio?></td>
                                                                    <td><?php
                                                                    if($dias_restantes>0){
                                                                        echo "Restan $dias_restantes dias ";
                                                                    } else {
                                                                        echo "El plazo lleva vencido ".-1*$dias_restantes." dias";
                                                                    }
                                                                    ?></td>
                                                                </tr>                                            
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <table align="center">
                                                                <tr>
                                                                    <td>Valor UF(Hoy:<?=number_format($uf_hoy,2,",",".")?>)</td>
                                                                    <td>Valor USD(Hoy:<?=($us_hoy)?number_format($us_hoy,2,",","."):"---"?>)</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="right"><input type="text" name="valor_uf" value="<?=$valor_uf?>"  class="form-control"></td>
                                                                    <td align="right"><input type="text" name="valor_us" value="<?=$valor_us?>"  class="form-control"></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right">Estado:</td>
                                                        <td><?=$Aux->SelectArray($losestados,"estado","---",$estado)?>
                                                            <!--<b><font size="3"><?=$elestado?></font></b>--></td>
                                                    </tr>  
                                                    <tr>
                                                        <td align="right">Aplicar % Descuento:</td>
                                                        <td><input type="text" name="descuento" id="descuento"  class="form-control" value="<?=$descuento?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right">Tipo Documento:</td>
                                                        <td align="left"><?=$Aux->SelectArray($losdocumentos,"tipo_doc","--Seleccione el Tipo de documento--",$tipo_doc)?></td>
                                                    </tr> 
                                                    <tr>
                                                        <td align="right">Adjuntar PDF:</td>
                                                        <td align="left"><?=$Aux->SelectArray($lasopciones,"adjunta_pdf","---",$adjunta_pdf)?></td>
                                                    </tr>
                                                </table>                        
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div> 
                        </td>
                        <td>
                            <div class="panel panel-default">
                                <div class="panel-heading"><h2>Datos del Cliente</h2></div>
                                <div class="panel-body">
                                    <div id="datosCliDiv">
                                    <table>
                                        <tr>
                                            <td align="right">Rut Cliente:</td>
                                            <td><input type="text" name="vrut" value="<?=$vrut?>" size="14" onblur="checkRutField(this.value,this);buscar_rut(this.value);" class="form-control">
                                                <input type="hidden" id="rut" name="rut"><input type="hidden" id="dig" name="dig">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right">Raz&oacute;n Social/Nombre:</td>
                                            <td><input type="text" name="razsoc"  class="form-control" value="<?=$razsoc?>" onblur="buscar_cli(this.value);" <?=$mayusculas?>></td>
                                        </tr>   
                                        <tr>
                                            <td align="right">E-mail:</td>
                                            <td><input type="text" name="email" value="<?=$email?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td align="right">Telefono/Celular:</td>
                                            <td><input type="text" name="fono" value="<?=$fono?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td align="right">Direcci&oacute;n:</td>
                                            <td><textarea rows="3" cols="40" name="direccion" <?=$mayusculas?> class="form-control"><?=$direccion?></textarea></td>
                                        </tr>
                                        <tr>
                                            <td align="right">Comuna:</td>
                                            <td><?=$Aux->SelectArray($lascomunas,"comuna","Seleccione Comuna",$comuna)?></td>
                                        </tr>

                                    </table>
                                        </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">Texto Correo</div>
                                    <div class="panel-body">
                                        <textarea name="mensaje_cotiza" cols="60" rows="10"><?=$mensaje_cotiza?></textarea>
                                        <br>
                                        <input type="file" name="archivo" id="archivo" >
                                        <?php if($archivo){?><br>
                                        Archivo Adjunto:<a href="/lib_archivos/<?=$archivo?>" target="_blank"><i class="glyphicon glyphicon-file"></i>&nbsp;<?=$archivo?></a>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                    </tr>

                    <tr>
                        <td colspan="2" align="right">
                            <table>
                                <tr>
                                    <?php if($nueva!=1){?>
                                    <td><button type="submit" name="mod" class="btn btn-primary">Modifcar</button></td>
                                    <?php }else{?>
                                    <td><button type="button" name="b1" onclick="crear_cotiza(<?=$id_user?>);" class="btn btn-primary">Crear Cotizaci&oacute;n</button></td>
                                    <?php }?>

                                    <?php if($nueva!=1 && $estado!=3){?>
                                    <td><!--<input type="button"  name="b3" value="Generar Proyecto" onclick="crear_proyecto();">--></td>
                                    <?php }?>
                                    <td><button name="b4" onclick="crear_pdf();" class="btn btn-primary">Enviar Correo</button></td>
                                </tr>
                            </table>
                            <div id="salida_cotiza"></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div class="panel panel-default">
                    <div class="panel-heading"><h2>Detalle Cotizaci&oacute;n</h2></div>
                    <div class="panel-body">
                        <table width="100%">
                            <tr>
                                <td colspan="2"><div id="salida_cotiza"></div></td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="muestraPagos">
                                    <?php 
                                        $nropagos = $nro_pagos;
                                        include "showPagos.php";?>
                                    </div>
                                </td>
                                <td><div id="newitem_div"></div></td>
                            </tr>
                            <tr>
                                <td colspan="2"><div id="det_cotiza"></div></td>
                            </tr>
                        </table>                            
                    </div>
                </div>    
            </td>
        </tr>
        <tr>
            <td>
                <?php
    $reparos = $Aux->getReparos($nro_cotizacion);
    $tr = count($reparos);
    if(count($tr)>0){
        ?>
                <table class="table table-bordered table-striped">
                    <tr>
                        <td colspan="2" >Reparos realizados por el Cliente a la cotizaci&oacute;n</td>
                    </tr>
                    <tr >
                        <th width="15%">Fecha</th>
                        <th width="85%">Reparo Cliente</th>
                    </tr>
        <?php
        
        for($k=0;$k<$tr;$k++){
            $tmp =  $reparos[$k];
            $fecha = $tmp['fecha'];
            $nota = $tmp['reparo'];
            $color = $Aux->flipcolor($color);
            ?>
                    <tr >
                        <td><?=$fecha?></td>
                        <td><?=$nota?></td>
                    </tr>
                    <?php
        }
        ?>
                </table>
                    <?php
    }
                ?>
            </td>
        </tr>
    </table>
</form>
</div>
        <div id="exito" style="display:none">
            Sus datos han sido recibidos con éxito.
        </div>
        <div id="fracaso" style="display:none">
            Se ha producido un error durante el envío de datos.
        </div>            
        </div>
    </div>

<script>
    requestPage('/includes/getItemCotizacion.php?ddel=<?=$ddel?>&lauf=<?=$valor_uf?>&elus=<?=$valor_us?>&nropagos=<?=$nro_pagos?>&nro=<?=$nro_cotizacion?>&descuento=<?=$descuento?>','det_cotiza');
    /*
    setTimeout(function(){
        requestPage('/syscot/includes/showPagos.php?nro_pagos=<?=$nro_pagos?>','muestraPagos');
        },150);*/
    
</script>
