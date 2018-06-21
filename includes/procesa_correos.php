<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once DIR.'/class/config.php';

    $Aux = new DBNucleo();
    
    $Aux->conecta_pdo();
    
    $nro_pagos         = $Aux->getN($_POST['nro_pagos']);
    $correo_cotizacion = $_POST['correo_cotizacion'];
    $correo_pavimentos = $_POST['correo_pavimentos'];
    $correo_pedidos    = $_POST['correo_pedidos'];
    $correo_despachos  = $_POST['correo_despachos'];
    $id_usuario        = $_POST['id_usuario'];
    
    $sql = "update Configuracion set correo_cotizacion='$correo_cotizacion',"
            . "correo_pavimentos='$correo_pavimentos',"
            . "correo_pedidos='$correo_pedidos',"
            . "correo_despachos='$correo_despachos',"
            . "nro_pagos=$nro_pagos "
            . "where id_usuario= $id_usuario";
    
    //echo "<p>SQL: $sql </p>";
    $rs = $Aux->query_pdo($sql);
    
    if($rs){
        echo "<h1>Datos Actualizados</h1>";
    } else {
        echo mysql_errno();
    }
?>