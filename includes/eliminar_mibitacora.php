<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/session.php';
include_once '../class/config.php';

$Aux = new DBBitacoraTrabajo();

$id_bit = $_GET['id_bit'];

echo $Aux->del($id_bit);