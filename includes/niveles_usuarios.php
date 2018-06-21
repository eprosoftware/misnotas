<?
	$Aux = new DBUsuario();

	$Aux->conecta();

	$sql ="select b.id id,b.descripcion descripcion,count(*) cantidad from Usuarios a left join NivelUsuario b on a.nivel=b.id group by b.id order by b.descripcion";

	$rs = $Aux->query($sql);
	if($rs){
?>
<table cellpadding="1" cellspacing="0" align="center" class="hnavbg" width="80%">
	<tr><TD class="tituloblanco12"><h2>Nivel de Usuarios</h2></TD></tr>
	<TR><TD>
	<table cellpadding="0" cellspacing="1" width="100%">
		<TR class="hnavbg">
			<TD class="tituloblanco">Area</TD>
			<td class="tituloblanco" align="right">Cantidad</td>
			<td></td>
		</TR>
	<?
	$i=0;
	while ($row=$Aux->getRows($rs)){
		$idarea = $row[id];
		$area = $row[descripcion];
		$cantidad = $row[cantidad];
		$color = $Aux->flipcolor($color);
?>
	<tr bgcolor="<?=$color?>" <?=$Aux->rowEffect($i,$color)?> valign="top">
		<TD bgcolor="<?=$color?>" class="contenidonegro"><?=$area?></TD>
		<td bgcolor="<?=$color?>" class="contenidonegro" align="right"><?=$cantidad?></td>
		<td bgcolor="<?=$color?>" class="contenidonegro"  align="right"><a href="/index.php?p=losusuarios&area=<?=$idarea?>">Ver Lista</a></td>
	</tr>
<?
	}
	?>
	</table>		
<?	}?>
</TD></TR></table>