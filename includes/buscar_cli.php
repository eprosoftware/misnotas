<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/config.php';
include_once 'header.php';

$nombre = $_GET['nombre'];

$Aux = new DBCotizacion();

$Aux->conecta_pdo();

$sql = "select * from Cotizacion where razon_soc like '%$nombre%' limit 1";
$rs = $Aux->query_pdo($sql);
if($rs){
    foreach ($rs as $row){
        $rut = $row['rut'];
        $razsoc = $row['razon_soc'];
        $direccion = $row['direccion'];
        $comuna = $row['comuna'];
        $fono = $row['telefono'];
        $email = $row['email'];
        
    }
}
$lascomunas = $Aux->TraerLosDatos("st_comuna","id","descripcion"," order by descripcion ");
$mayusculas = "onblur='document.f.valor.focus();this.value = this.value.toUpperCase();'";
?>
<table>
<tr>
    <td colspan="2"><h2>Datos del Cliente</h2></td>
</tr>
<tr>
    <td align="right">Rut Cliente:</td>
    <td><input type="text" name="vrut" value="<?=$rut?>" size="14" onblur="checkRutField(this.value,this);buscar_rut(this.value);">
        <input type="hidden" id="rut" name="rut"><input type="hidden" id="dig" name="dig">
    </td>
</tr>
<tr>
    <td align="right">Raz&oacute;n Social/Nombre:</td>
    <td><input type="text" name="razsoc" size="40" value="<?=$razsoc?>"  onblur="buscar_cli(this.value);" <?=$mayusculas?>></td>
</tr>   
<tr>
    <td align="right">E-mail:</td>
    <td><input type="text" name="email" value="<?=$email?>"></td>
</tr>
<tr>
    <td align="right">Telefono/Celular:</td>
    <td><input type="text" name="fono" value="<?=$fono?>"></td>
</tr>
<tr>
    <td align="right">Direcci&oacute;n:</td>
    <td><textarea rows="3" cols="40" name="direccion" <?=$mayusculas?>><?=$direccion?></textarea></td>
</tr>
<tr>
    <td align="right">Comuna:</td>
    <td><?=$Aux->SelectArrayBig($lascomunas,"comuna","Seleccione Comuna",$comuna)?></td>
</tr>

</table>