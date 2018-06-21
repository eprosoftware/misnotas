<?php
    include_once str_replace("/includes","",getcwd()).'/class/config.php';

    $Aux = new DBUsuario();

    $usr = $Aux->ElUsuario("",$usuario);

    if($usr) {
            $idusuario=$usr->getId(); 
            $dias_cambio_clave = $usr->getNroDiasCambioClave();
    } else $idusuario=0;

    if ($idusuario>0){?>	
<table width="100%">
	<?php if ($dias_cambio_clave>20) { ?>
	<tr><TD ><p align="justify">Han pasado ya <?=$dias_cambio_clave?> dias desde que cambio la clave, <br>por favor cambie su clave, Gracias</p></TD></tr>	
	<tr><TD><td align="right"><input type="password" class="pass2_text_box" name="clave_old"  placeholder="Clave Antigua"></td></tr>
	<tr><TD><td align="right"><input type="password"  class="pass_text_box" name="clave_new"  placeholder="Nueva Clave"></td></tr>
	<?php } else {?>
	<tr><td align="center"><input type="password" class="pass_text_box" name="clave" placeholder="Contrase&ntilde;a"></td></tr>
	<?php }?>
</table>
<?php
	} else {
?>
<span class="titulorojo">Usuario NO Valido.</span>
<?php }
