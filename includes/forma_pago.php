<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
   
include_once '../class/session.php';
include_once '../class/config.php';
include_once 'header.php';

    $Aux = new DBCotizacion();
    $Aux->conecta_pdo();
    $dbuser = new DBUsuario();

    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    
    $id_item = $_GET['id_item'];
    
    $sql = "select * from ItemProyecto where id=$id_item";
    echo "<p>SQL: $sql</p>";
    $rs = $Aux->query_pdo($sql);
    if($rs){
        foreach ($rs as $row){
            $item_contratado    = $row['item_contratado'];
            $nro_proyecto       = $row['nro_proyecto'];
            $pago_anticipo      = $row['pago_anticipo'];
            $pago_entrega       = $row['pago_entrega'];
            $pago_aprobacion    = $row['pago_aprobacion'];
            $tipo_moneda        = $row['tipo_moneda'];
            $valor_item         = $row['valor_item'];
        }
        $elitem = $Aux->ElDato($item_contratado,"Codigos","cod","descripcion");
        
        $ep1 = ($pago_anticipo/$valor_item)*100;
        $ep2 = ($pago_entrega/$valor_item)*100;
        $ep3 = ($pago_aprobacion/$valor_item)*100;
    }
    $lostipomoneda = $Aux->TraerLosDatos("TipoMoneda","id","descripcion");
?>    
<form action="procesar_item.php" name="f" method="POST">
    <input type="hidden" name="id_item" value="<?=$id_item?>">
<table>
<tr>
        <td colspan="2">
            <table with="100%">
                <tr class="hnavbg">
                    <td class="tituloblanco12">C&oacute;digo</td>
                    <td class="tituloblanco12">Item</td>
                    <td class="tituloblanco12">Moneda</td>
                    <td class="tituloblanco12">Valor Total</td>
                    <td class="tituloblanco12">Anticipo %</td>
                    <td class="tituloblanco12">Entrega<br>Cliente %</td>
                    <td class="tituloblanco12">Aprobaci&oacute;n %</td>
                    <td><input type="hidden" size="2" name="total_por"></td>
                </tr>
                <tr valign="top">
                    <td><input value="<?=$item_contratado?>" type="text" size="6" name="codigo" onkeydown="buscarCodigo(this.value);" onblur="document.f.valor.focus();this.value = this.value.toUpperCase();"><br>
                        <table>
                            <tr>
                                <td><a href="javascript:layerTabla();"><img src="/images/lupa.gif" border="0"></a></td>
                                <td><a href="javascript:agregar_codigo();"><img src="/images/plus_inline.gif"></a></td></td>
                                <td><div id="salida_codigo"></div></td>
                            </tr>
                            <tr>
                                <td colspan="2"><div id="tabla_codigos" class="tabla_codigos" style="display: none"></div></td>
                            </tr>
                        </table>
                    <td><div id="item_div"><textarea cols="40" rows="3" name="str_item"><?=$elitem?></textarea></div></td>
                    <td><?=$Aux->SelectArrayBig($lostipomoneda, "tipo_moneda", "Seleccione Moneda", $tipo_moneda);?></td>
                    <td><input type="text" name="valor" size="6" value="<?=$valor_item?>"></td>
                    
                    <td><input type="text" size="2" name="por_anticipo" onblur="actualiza_por();document.f.por_entrega.focus();" value="<?=$ep1?>"><br><input type="text" name="anticipo" size="4" value="<?=$pago_anticipo?>"> </td>
                    <td><input type="text" size="2" name="por_entrega" onblur="actualiza_por();document.f.por_aprobado.focus();" value="<?=$ep2?>"><br><input type="text" name="entrega" size="4" value="<?=$pago_entrega?>"></td>
                    <td><input type="text" size="2" name="por_aprobado" onblur="actualiza_por();" value="<?=$ep3?>"><br><input type="text" name="aprobado" size="4" value="<?=$pago_aprobacion?>"></td>
                </tr>   
                <tr>
                    <td colspan="2">
                        <table>
                            <tr>
                                <td><input type="submit" name="b2" value="Modifcar"></td>
                                <td><div id="salida_cotiza"></div></td>
                            </tr>
                        </table>
                        
                    </td>
                    
                    <td colspan="3"><div id="newitem_div"></div></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</form>