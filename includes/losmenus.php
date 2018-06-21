<?php
include_once str_replace("/includes","",getcwd()).'/cfgdir.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';

    
    $Aux = new DBMenu();
    
    $id_del = $_GET['id_del'];
    if($id_del)
    {
            $aa = $Aux->del($id_del);
    }

    $info = $Aux->ElMenu();
?>
<html>
<head>
<script language="javascript">
function MiSubmit(ruta)
{
	if(ruta)
	{
		document.formulario.action = ruta;
		document.formulario.submit();
	}
}
function eliminar(id,url)
{
	if(id)
	{
		if(confirm("Desea Eliminar el Menu"))
			MiSubmit("/index.php?p=losmenus&id_del="+id);
	}
}
function elestado(id,estado)
{
	MiSubmit("<?echo $PHP_SELF;?>?id_est="+id+"&estado="+estado);
}
function responder(id)
{
	alert("Aun no disponible");
}
</script>
<script language="javascript" src="../js/libreria.js"></script>
<link rel="stylesheet" href="../styles/general_styles.css" type="text/css">
</head>
<body text='#000000' bgcolor='#FFFFFF' link='blue' vlink='blue'>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Sistema de Men&uacute;s</h2></div>
        <div class="panel-body">
            
<form method="POST" name="formulario">
<?php
if($info[0])
{
?>
<a href="javascript:openWindow('/includes/nuevo_menu.php','Menux',600,200)" class="btn btn-primary">Ingresar Men&uacute; Nivel Principal</a>

	<table class="table table-bordered table-striped table-hover">
	<tr>
            <th bgcolor="#d3d3d3">Nombre Menu</th>
            <th bgcolor="#d3d3d3">Men&uacute;</th>
            <th bgcolor="#d3d3d3" >&nbsp;</th>
            <th bgcolor="#d3d3d3" align="right">Orden</th>
            <th bgcolor="#d3d3d3" align="right">Eliminar</th>
	</tr>
	<?php
	$i=0;
	$bgcolor = "lightyellow";
	while($info[$i])
	{
		$bgcolor=$Aux->flipcolor($bgcolor);
		$datos = $info[$i];
		$id = $datos->getId();
		$nombre_menu = $datos->getNombre();
		$descripcion = utf8_encode($datos->getDescripcion());
		$orden=$datos->getOrden();
		?>
		<tr>
			<td><?=$nombre_menu?></td>
			<td>
                            <a href="javascript: openWindow('/includes/nuevo_menu.php?id=<?=$id;?>&lenguaje=<?=$lenguaje?>','NuevoMenu',500,270)" class="btn btn-primary btn-block"><i class="glyphicon glyphicon-pencil"></i>&nbsp;<?=$descripcion;?></a>
			</td>
			<td>
                            <a href="javascript:openWindow('/includes/lossubmenus.php?idmenu=<?=$id;?>&lenguaje=<?=$lenguaje?>','SubMenu',500,400)" class="btn btn-primary"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Submen&uacute;s</a>
			</td>
			<td ><?=$orden?></td>
                        <td><button class="btn btn-danger" onclick="eliminar(<?=$id?>,'')">Eliminar</button></td>
		</tr>
		<?php
		$i++;
	}
	?>
	</table>

<?php
}
?>
</form>
            
        </div>
    </div>

</body>
</html>
