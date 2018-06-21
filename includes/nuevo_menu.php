<html>
<?php
	include("../class/config.php");
	include("../includes/header.php");

        $comando = $_GET['comando'];
        
        
        $id = $_GET['id'];
        
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $ancho = $_POST['ancho'];
        $link = $_POST['link'];
        $orden = $_POST['orden'];
        $clase = $_POST['clase'];
        
	$Aux = new DBMenu();
	$menu = new Menu();
	$menu->setNombre($nombre);
	$menu->setDescripcion($descripcion);
	$menu->setAncho($ancho);
	$menu->setLink($link);
	$menu->setOrden($orden);
	$menu->setClase($clase);

        
	if (!$id){
		$Aux->add($menu);
	} else {
		if ($comando==1){
			$menu->setId($id);
			$Aux->update($menu);
		}
	}

?>
<script>
window.opener.location = window.opener.location;
<? if ($comando==1){?>
self.close();
<?}?>
</script>
<?php
	if ($id)
		$tmp = $Aux->ElMenu($id);

		
	if($tmp)
	{
		$datos = $tmp[0];
		$id = $datos->getId();
		$nombre = $datos->getNombre();
		$descripcion = $datos->getDescripcion();
		$ancho = $datos->getAncho();
		$link = $datos->getLink();
		$orden = $datos->getOrden();
		$clase = $datos->getClase();
	}
	$lasclasesmenu = $Aux->TraerLosDatos("MenuClases","descripcion","descripcion");
?>
<script language="Javascript">
function validar()
{
	if(!document.formulario.nombre.value)
	{
		alert("Debe ingresar el nombre");
		document.formulario.nombre.focus();
		return false;
	}
	MiSubmit("<?=$PHP_SELF?>?id=<?=$id?>&comando=1");
}
</script>
<body onload="document.formulario.nombre.focus();">
<form method="post" name="formulario" action="">
<input type="hidden" name="id" value="<?=$id;?>">
<h2>Nuevo Menu</h2>
<table border="0" width="80%" align="left" cellspacing="1" cellpadding="0" bgcolor="#a8bfdd">
<tr>
	<td>
	<table border="0" width="100%" align="center" cellspacing="0" cellpading="0" bgcolor="#FFFFFF">
	<tr bgcolor="#a8bfdd">
		<td class="titulonegro" colspan="4">Datos</td>
	</tr>
	<tr>
		<td class="titulonegro">Nombre</td>
		<td colspan="3" class="contenidonegro">
			<input type="text" name="nombre" value="<?=$nombre;?>" size="40">
		</td>
	</tr>
	<tr>
		<td class="titulonegro">Descripcion</td>
		<td colspan="3" class="contenidonegro">
			<input type="text" name="descripcion" value="<?=$descripcion;?>" size="40">
		</td>
	</tr>
	<tr>
		<td class="titulonegro">Clase</td>
		<td colspan="3" class="contenidonegro">
			<?=$Aux->SelectArray($lasclasesmenu,"clase","----",$clase);?>
		</td>
	</tr>
	<tr>
		<td class="titulonegro">Ancho</td>
		<td class="contenidonegro"><input type="text" name=ancho value="<?=$ancho?>"></td>
		<td class="titulonegro">Orden</td>
		<td class="contenidonegro"><input type="text" name=orden value="<?=$orden?>" size=2></td>
	</tr>
	<tr>
		<td class="titulonegro">Enlace</td>
		<td class="contenidonegro" colspan=3><input type="text" size=50 name=link value="<?=$link?>"></td>
	</tr>	
	<tr>
		<td colspan="4">
			<input type="button" name="aceptar" value="Aceptar" onClick="validar();">
			&nbsp;&nbsp;&nbsp;
			<input type="button" name="cancelar" value="Cancelar" onClick="history.back();">
		</td>
	</tr>
	</table>
	</td>
</tr>
</table>
</form>
</body>
</html>
