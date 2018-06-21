<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/config.php';

$Aux=new DBProyecto();

$jefe = $_GET['jefe'];
$proyectista = $_GET['proyectista'];

$losproyectistas = $Aux->TraerLosDatos("Usuarios","id","nombre", " where jefe=$jefe");

?>
<?=$Aux->SelectArrayBig($losproyectistas, "proyectista", "Seleccione Proyectista", $proyectista);