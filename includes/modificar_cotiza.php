<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd()).'/includes/header.php';

    $Aux = new DBCotizacion();
    
    $nro_cotizacion  = $_POST['nro_cotizacion'];
    $nombre_proyecto = $_POST['nombre_proyecto'];
    $encargado       = $_POST['encargado'];
    $creadopor       = $_GET['creadopor'];
    $condiciones     = $_POST['condiciones'];
    $valor_total     = $_POST['valor_total'];
    $email           = $_POST['email'];
    $rut             = $_POST['vrut'];
    $razsoc          = $_POST['razsoc'];
    $direccion       = $_POST['direccion'];
    $telefono        = $_POST['fono'];
    $comuna          = $_POST['comuna'];
    $nropagos        = $_POST['nro_pagos'];
    $tipo_doc        = $_POST['tipo_doc'];
    $tipo_proyecto   = $_POST['tipo_proyecto'];
    $nro_dias_valido = $_POST['nro_dias_valido'];
    $estado          = $_POST['estado'];
    $tipo_moneda     = $_POST['moneda'];
    $descuento       = $_POST['descuento'];
    //$archivo = $_POST['archivo'];
    $mensaje_cotiza  = utf8_encode(nl2br($_POST['mensaje_cotiza']));
    
    
    $valor_uf        = $_POST['valor_uf'];
    $valor_us        = $_POST['valor_us'];

    
    
    $tmp = new Cotizacion();
    $fecha = date("Y-m-d");

    if(isset($_FILES['archivo'])){ //Si Hay Documentos se suben
        $tmp_name = $_FILES["archivo"]["tmp_name"];
        $name = $_FILES["archivo"]["name"];

        if (is_uploaded_file($_FILES['archivo']['tmp_name'])){ 
            $imgFile = $_FILES['archivo']['name'] ; 
            $imgFile = str_replace(' ','_',$imgFile); 
            $tmp_name = $_FILES['archivo']['tmp_name']; 

            $tipoarchivo = $_FILES['archivo']['type'];  

            if (!((strpos($tipoarchivo,"gif")||strpos($tipoarchivo,"jpeg")|| 
               strpos($tipoarchivo,"jpg")|| strpos($tipoarchivo,"png")||
               strpos($tipoarchivo,"pdf")|| strpos($tipoarchivo,"msword")|| 
               strpos($tipoarchivo,"mp3")|| strpos($tipoarchivo,"mp4")||                            
               strpos($tipoarchivo,"ppt")|| strpos($tipoarchivo,"xls")|| 
               strpos($tipoarchivo,"jar")|| strpos($tipoarchivo,"xls")||
               strpos($tipoarchivo,"ppt")|| strpos($tipoarchivo,"avi")||
               strpos($tipoarchivo,"txt")) )){  
               echo "Lo sentimos,no puede subir este tipo de archivo $tipoarchivo."; 
            } else { 
               $eldir = str_replace("/includes","",getcwd())."/lib_archivos/";
               if(move_uploaded_file($tmp_name, $eldir.$imgFile)) 
               { 
                    echo "Se Guardo correctamente sus archivos que ingreso son: <br>"; 
                    echo "Nombre:".$_FILES['archivo']['name']."<br>"; 
                    echo "Tipo Archivo: <i>".$_FILES['archivo']['type']."</i><br>"; 
                    echo "Peso: <i>".$_FILES['archivo']['size']." bytes</i><br>"; 
                    $tmp->setArchivo($imgFile);
                    //$tmp->setNombreArchivo($imgFile);                               
               } 
            } 
        } else {
            echo "<p>Algun problema al cargar el archivo, PLOP!!!</p>";
        }
    } else {
        echo "<p>Parece no hay archivo N:".$_FILES['archivo']['name']."</p>";
        $tmp->setArchivo("");
    }
        
        
        
    $tmp->setFecha($fecha);
    $tmp->setNroCotizacion($nro_cotizacion);
    $tmp->setNombreProyecto(trim($nombre_proyecto));
    $tmp->setCondiciones(trim($condiciones));
    $tmp->setEncargado($encargado);
    $tmp->setCreadoPor($creadopor);
    switch($tipo_moneda){
        case 1:$tmp->setValorCotizacion($valor_total*$valor_uf);break;
        case 2:$tmp->setValorCotizacion($valor_total);break;
    }
    
    $tmp->setValorCotizacionUF($valor_total);
    $tmp->setValorUF($valor_uf);
    $tmp->setValorUS($valor_us);
    $tmp->setRut($rut);
    $tmp->setRazonSocial($razsoc);
    $tmp->setEmail($email);
    $tmp->setFono($telefono);
    $tmp->setDireccion($direccion);
    $tmp->setComuna($comuna);
    $tmp->setEstado(1);
    $tmp->setNroPagos($nropagos);
    $tmp->setTipoDoc($tipo_doc);
    $tmp->setTipoProyecto($tipo_proyecto);
    $tmp->setNroDiasValido($nro_dias_valido);
    $tmp->setEstado($estado);
    $tmp->setTipoMoneda($tipo_moneda);
    $tmp->setDescuento($descuento);
    $tmp->setMensajeCotiza($mensaje_cotiza);
    
    echo "<div class=alert alert-success'>Cotizaci&oacute;n Actualizada:".$Aux->update($tmp)."</div>";
    
?>
<script>
    document.location="/index.php?p=nueva_cotizacion&nro_cotizacion=<?=$nro_cotizacion?>";
</script>