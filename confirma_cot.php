<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once str_replace("/includes","",getcwd())."/cfgdir.php";
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd()).'/includes/header.php';
?>
<br><br>
<center>
    <img src='<?=$base_dir?>/images/logo_eprosoftCL_ver2.png' border='0'><br><br>
<?php
$Aux = new DBCotizacion();

$nrocot = ($_GET['nrocot'])?$_GET['nrocot']:$_POST['nrocot'];
$reparo = $_GET['reparo'];
$elreparo = $_GET['elreparo'];
$c = $_POST['c'];
$elreparo = $_POST['elreparo'];

if($c==1){
    $Aux->uptEstado($nrocot,6); //Con Reparo
    $Aux->addReparo($nrocot,$elreparo);
?><h2>Se ha notificado su Reparo, esperamos poder resolverlo, Gracias</h2><?php    
}

if($reparo!=1 && $c!=1){
$Aux->uptEstado($nrocot,2); //Confirma
echo "<h2>Cotizaci&oacute;n Confirmada!!!</h2>";
echo "<h1>Gracias !!</h1>";
} else if($c!=1){
        $Aux->uptEstado($nrocot,6); //Con Reparo
    ?>
<form action='' method="POST" name='f'>
    <input type='hidden' name='c' value='1'>
    <input type='hidden' name='reparo' value='<?=$reparo?>'>
<table width="600">
    <tr>
        <td>Disculpa si la cotizaci&oacute;n no se acomoda a lo que esperabas,cuentanos cuales son tus reparos para ver que podemos hacer al respecto;</td>
    </tr>
    <tr>
        <td><textarea name='elreparo' cols='80' rows='5'><?=$elreparo?></textarea></td>
    </tr>
    <tr>
        <td><button type="submit" class="btn btn-primary btn-lg">Enviar Reparos a la Cotizaci&oacute;n</button></td>
    </tr>
</table>
</form>
</center>
<?php
}

