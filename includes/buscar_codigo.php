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
        
	$db = new DBCotizacion();
	$loscodigos = $db->TraerLosDatos("Codigos","cod","descripcion"," where cod like '$buscar%' order by descripcion ");
	if (count($loscodigos)>0){
?>
<script>
    <?=$f.str_campo?>.value = <?=$elcodigo?>;
</script>
<table>
<tr>
    <td><?=$db->SelectArrayBig($loscodigos,$campo,"----",$valor,"","document.f.str_$campo.value=this.options[this.selectedIndex].text;")?></td>
</tr>
</table>
<?php } else {?>
<input type="button" value="Nuevo Cod.">
<?php } ?>
