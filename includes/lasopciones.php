<?php
	include("../class/config.php");
	include("header.php");

	$Aux  = new DBMenu();
	$Aux1 = new DBSubMenu();
	$id_del = $_GET['id_del'];
        $idmenu = $_GET['idmenu'];
        $idsubmenu = $_GET['idsubmenu'];
        
	if($id_del)
	{
		$aa = $Aux1->del($id_del);
    ?>
    <script>window.location = window.location;
        self.close();
    </script>
    <?php                
	}
	$info = $Aux->LosSubmenus($idmenu,$idsubmenu,"2");
	$xmenu = $Aux->ElMenu($idmenu);
	$xsubmenu = $Aux1->ElSubMenu($idsubmenu);

	$elmenu = $Aux->cleanHTMLChar($xmenu[0]->getDescripcion());
	$elsubmenu = $xsubmenu->getDescripcion();
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
function eliminar(id)
{
    if(confirm("Desea Eliminar la opcion?")){
        MiSubmit("<?=$PHP_SELF;?>?id_del="+id);
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
<link rel="stylesheet" href="../styles/general_styles.css" type="text/css">
</head>
<body text='#000000' bgcolor='#FFFFFF' link='blue' vlink='blue'>
    
    <div class="panel panel-primary">
        <div class="panel-heading"><h2>Sub Menu: <?="$elmenu --> $elsubmenu "?></h2></div>
        <div class="panel-body">
            
<form method="POST" name="formulario">
<input type="hidden" name="idmenu" value="<?echo $idmenu;?>">
<input type="hidden" name="idsubmenu" value="<?echo $idsubmenu;?>">
<a href="javascript:openWindow('nuevo_submenu.php?idmenu=<?=$idmenu?>&idsubmenu=<?=$idsubmenu?>','NuevoSubMenu',500,280)" class="btn btn-primary">Ingresar SubMenu/Link</a>
<?php
if($info[0])
{
?>
	<table class="table table-bordered table-striped table-hover">
	<tr>
		<th >Nombre</th>
		<th >Men&uacute;</th>
		<th >SubMen&uacute;</th>
		<th >&nbsp;</th>
		<th >&nbsp;</th>
		<th >Orden</th>
		<th >Ancho</th>
		<th >Eliminar</th>
	</tr>
	<?php
	$i=0;

	while($info[$i])
	{
		$bgcolor=$Aux->flipcolor($bgcolor);
		$datos = $info[$i];
		$bgcolor=$Aux->flipcolor($bgcolor);
		$datos = $info[$i];
		$id     = $datos->getId();
		$nombre = $datos->getNombre();
		$descripcion = $Aux->cleanHTMLChar($datos->getDescripcion());
		$tipo   = $datos->getTipo();
		$ancho = $datos->getAncho();
		$orden = $datos->getOrden();
		?>
		<tr>
                    <td><?=$nombre?></td>
                    <td><?=$elmenu;?></td>
                    <td><?=$elsubmenu;?></td>
                    <td>
                        <a href="javascript:openWindow('nuevo_submenu.php?id=<?=$id?>&idsubmenu=<?=$idsubmenu;?>&idmenu=<?=$idmenu;?>','Opciones<?=$id?>',500,250)" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i>&nbsp;<?=$descripcion;?></a>
                    </td>
                    <td>
                            <?=$link;?>
                    </td>
                    <td><?=$orden;?></td>
                    <td><?=$ancho;?></td>
                    <td><?=$Aux->deleteEffect($id,$i)?></td>
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
