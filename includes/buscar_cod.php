<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

	include_once str_replace("/includes","",getcwd()).'/class/config.php';
        
        $campo = $_GET['campo'];
        $buscar = $_GET['buscar'];
        $valor = $_GET['valor'];
        
	$Aux = new DBCotizacion();

        $elcodigo = $Aux->ElDato($buscar,"Codigos","cod","descripcion");

?>
<textarea cols="40" rows="3" name="str_item" onblur="this.value = this.value.toUpperCase();"><?=htmlspecialchars($elcodigo)?></textarea>

