<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/config.php';

$Aux = new DBCotizacion();

$nrocot = $_GET['nrocot'];

$Aux->uptEstado($nrocot,2); //Confirma
echo "Confirma Cotizaci&oacute;n!!!";


