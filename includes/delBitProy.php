<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once str_replace("/includes","",getcwd()).'/class/config.php';

$Aux = new DBProyecto();

$Aux->conecta();
$id_del = $_GET['iddel'];

$b =$Aux->getBitacora("",$id_del);
$archivo = $b->getArchivo();


$dir = DIR."/lib_archivos";
unlink($dir."/".$archivo);
echo " <div class='alert alert-success'>Eliminando $dir / $archivo</div>";

$Aux->delBitacora($id_del);
