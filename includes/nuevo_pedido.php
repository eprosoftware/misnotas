<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/session.php';
include_once '../class/config.php';
include_once 'header.php';

$id_item = $_GET['id_item'];
$nro = $_GET['nro'];
?>
<script>
function captura(cod,desc){
    //alert('Codigo Capturado:'+cod);
    document.f.codigo.value = cod;
    document.f.str_item.value = desc;
    toggleLayer('tabla_codigos');
}
function layerTabla_pedidos(){
    var obj = document.getElementById('layerTabla');
    toggleLayer('tabla_codigos');
    requestPage('/includes/tabla_codigos_pedidos.php?t=2','tabla_codigos');
    //requestPage('/includes/tipos_codigos.php&titulo=Codigos','tabla_codigos');
}
function agregar_codigo_pedidos(){
    cod = document.f.codigo.value;
    desc = document.f.str_item.value;    
    if(confirm("Esta seguro que quiere agregar este codigo a la tabla de codigos?"))
    requestPage('/includes/add_tabla_codigos2.php?cod='+cod+'&desc='+desc,'salida_codigo');
}
function agregarPedido(id_item){
    cod  = document.f.codigo.value;
    item = document.f.str_item.value;
    com  = document.f.comentario.value;
    //alert('/includes/addPedido.php?fecha='+fecha+'&nro='+nro+'&codigo='+cod+'&item='+item+'&comentario='+com);
    makerequest('/includes/addPedido.php?nro=<?=$nro?>&codigo='+cod+'&item='+item+'&id_item='+id_item+'&comentario='+com,'newPedido_div');
    setTimeout(function(){window.opener.location=window.opener.location;window.close();},100);    
}
</script>

<form action="" name="f" method="POST">
<table align="right">
    <tr class="hnavbg"><td colspan="4" class="tituloblanco12">Detalle Pedidos</td></tr>
    <tr >
        <td>C&oacute;digo</td>
        <td>Item</td>
        <td>Comentario</td>
        <td></td>
    </tr>
    <tr valign="top">
        <td><input type="text" size="6" id="codigo" name="codigo" onkeydown="buscarCodigo(this.value);" onblur="document.f.valor.focus();"><br>
            <table>
                <tr>
                    <td><a href="javascript:layerTabla_pedidos();"><img src="/images/lupa.gif" border="0"></a></td>
                    <td><a href="javascript:agregar_codigo_pedidos();"><img src="/images/plus_inline.gif"></a></td></td>
                    <td><div id="salida_codigo"></div></td>
                </tr>
                <tr>
                    <td colspan="2"><div id="tabla_codigos" class="tabla_codigos" style="display: none"></div></td>
                </tr>
            </table>
        <td><div id="item_div"><textarea cols="40" rows="3" name="str_item"></textarea></div></td>
        <td><textarea name="comentario" cols="40" rows="3" onblur="this.value = this.value.toUpperCase();"><?=$comentario?></textarea></td>
        <td></td>
    </tr> 
    <tr>
        <td colspan="5"><input type="button" value="Aceptar" onclick="agregarPedido(<?=$id_item?>)"></td>
    </tr>
    <tr>
        <td colspan="2">
        </td>

        <td colspan="3"><div id="newPedido_div"></div></td>
    </tr>
</table>
</form>    