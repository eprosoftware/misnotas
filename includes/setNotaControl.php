<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';

$Aux = new DBNotas();
$dbuser = new DBUsuario();

$id_user    = $dbuser->getUsuarioId($usuario,$clave);
    
$id = $_GET['id'];
$pos = $_GET['pos'];
$valor = $_GET['valor'];

echo $Aux->updateControl($id, $pos, $valor);