<script language="javascript">
function MiSubmit(ruta)
{
        if(ruta)
        {
              document.forms[0].action = ruta;
              document.forms[0].submit();
        }
}
function poner(x){
	document.forms[0].comando.value=x;
	MiSubmit("<?echo "$PHP_SELF?tipo=$tipo"?>");
}
function llenar(x,y){
	formulario.descripcion.value=x;
	formulario.abreviacion.value=y;
}
</script>
<form action="" method=POST name="formulario">
<input type="hidden" name=t value="<?=$t?>">
<input type=hidden name=comando>
<input type=hidden name=tabla value="<? echo $tabla?>">
<input type=hidden name=titulo value="<? echo $titulo?>">
<table cellspacing=0 cellpadding=1 class=th align="center">
<tr class="th"><TD class="titulonegro"><?echo $titulo?></TD></tr>
<tr><td>
<table cellspacing=0 cellpadding=1>
<tr class=th><td class="titulonegro">Descripci&oacute;n</td><td class="titulonegro">Abreviaci&#243;n</td></tr>
<tr><td><input type=hidden name=id>
    <input type=text name=descripcion value="<?echo $descripcion?>" size=50 class="contenidonegro"></td>
    <td><input type=text name=abreviacion value="<?echo $abreviacion?>" size=50 class="contenidonegro"></td>
<tr>
<tr class=row_on><td colspan=2>
<a href="javascript:poner(1);" class="titulonegro">Agregar</a>&nbsp;|&nbsp;
<a href="javascript:poner(3);" class="titulonegro">Modificar</a>&nbsp;|&nbsp;
<a href="javascript:poner(2);" class="titulonegro">Eliminar</a>
</td></tr>
</table>
<table cellspacing=0 cellpadding=1 bgcolor=white width="100%">
<tr class="th"><td>ID</td><td>Descripci&oacute;n</td><td>Abrev.</td></tr>
<?
	$x = new DBVarios();
	$x->conecta();
        //echo "<p>Comando:$comando</p>";	
	switch ($comando){
	case 1://Agregar Concepto
		$sql = "insert $tabla(descripcion,abreviacion) values(\"$descripcion\",\"$abreviacion\")";
		//echo "<p>SQL:$sql</p>";
		$rs = mysql_query($sql);
		break;
	case 2://Eliminar Concepto
		$sql = "delete from $tabla where ID = $ids";
		//echo "<p>SQL:$sql</p>";
		$rs = mysql_query($sql);
		break;
	case 3://Modificar Concepto
		$sql = "update $tabla set descripcion=\"$descripcion\",abreviacion=\"$abreviacion\" where ID = $ids";
		//echo "<p>SQL:$sql</p>";
		$rs = mysql_query($sql);
		break;
	}

	$sql = "select * from $tabla";
	$rs = mysql_query($sql);
	if ($rs)
	while($campos = mysql_fetch_array($rs)){
		$id = $campos[id];
		$descripcion = $campos[descripcion];
		$abrev = $campos[abreviacion];
		$bgcolor=$x->flipcolor($bgcolor);
?>
<tr bgcolor="<?=$bgcolor?>">
<td>
<input type=radio name=ids value=<?=$id?> cols=80 onclick="llenar('<?=$descripcion?>','<?=$abrev?>')"> <?=$id?>
</td>
<td><?=$descripcion?></td>
<td><?=$abrev?></td></tr>
<?
	}
?>
</table>
</td></tr></table>
</form>
