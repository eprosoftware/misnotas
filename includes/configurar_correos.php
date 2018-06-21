<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once DIR.'/class/session.php';
include_once DIR.'/class/config.php';
include_once 'header.php';

    $Aux = new DBNucleo();
    $dbuser = new DBUsuario();

    $id_user  = $dbuser->getUsuarioId($usuario,$clave);
    
    $Aux->conecta_pdo();
    
    $sql = "select * from Configuracion where id_usuario=$id_user";
    //echo "<p>SQL: $sql</p>";
    $rs = $Aux->query_pdo($sql);
    if($rs){
        foreach($rs as $row) {;}
        $nro_pagos         = $row['nro_pagos'];
        $correo_cotizacion = $row['correo_cotizacion'];
        $correo_pavimentos = $row['correo_pavimentos'];
        $correo_pedidos    = $row['correo_pedidos'];
        $correo_despachos  = $row['correo_despachos'];
    }

?>
<form action="/index.php?p=procesa_correos" method="POST">
    <input type="hidden" name="id_usuario" value="<?=$id_user?>">
<table><tr><td class="celda_bordes">
<table>
    <tr><td colspan="2">Configuraci&oacute;n de Correos</td></tr>
    <tr>
        <td>Nro. Pagos Cotizaci&oacute;n:</td>
        <td><input type="text" name="nro_pagos" value="<?=$nro_pagos?>" size="3"></td>
    </tr>
    <tr>
        <td>Correo Cotizaci&oacute;n:</td>
        <td><input type="text" name="correo_cotizacion" value="<?=$correo_cotizacion?>"></td>
    </tr>
    <tr>
        <td>Correo Proyectos Pavimentos:</td>
        <td><input type="text" name="correo_pavimentos" value="<?=$correo_pavimentos?>"></td>
    </tr>
    <tr>
        <td>Correo Pedidos Pavimentos:</td>
        <td><input type="text" name="correo_pedidos" value="<?=$correo_pedidos?>"></td>
    </tr>    
    <tr>
        <td>Correo Despachos Pavimentos:</td>
        <td><input type="text" name="correo_despachos" value="<?=$correo_despachos?>"></td>
    </tr>    
    <tr>
        <td colspan="2"><input type="submit" value="Modificar"></td>
    </tr>
</table>    
</td></tr>
</table>            
</form>