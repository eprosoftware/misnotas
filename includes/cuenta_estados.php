<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$estados = $_GET['estados'];
$xest = explode(",",$estados);
$n = count($xest);
?>
<input type="text" size="3" name="nro_estados" value="<?=$n?>">