<html>
<?php
	include("../class/config.php");
	include("../includes/header.php");

	$Aux = new DBMenu();
	$Aux1 = new DBSubMenu();
        
        $idmenu = $_GET['idmenu'];
        $id_del = $_GET['id_del'];
	if($id_del)
	{
		$aa = $Aux1->del($id_del);
    ?>
    <script>window.location = window.location;
        self.close();
    </script>
    <?php
	}
	$menu= $Aux->ElMenu($idmenu);
	if ($menu[0]) $elmenuprincipal = $menu[0]->getDescripcion();
	$info = $Aux->LosSubmenus($idmenu," 0","3,2");
	if(!$idmenu)
	{
		
	}
	else
	{

		$i=0;
		while($salida[$i])
		{
			$datos = $salida[$i];
			$tmp["id"] = $datos->getId();
			$tmp["valor"] = $datos->getId();
			$tmp["txt"] = $datos->getDesc();
			$tmp["nombre"] = $datos->getDesc();
			$info[] = $tmp;
			$i++;
		}
	}
?>
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
	if(id)
	{
		if(confirm("Desea Eliminar el SubMen?"))
			MiSubmit("<?echo $PHP_SELF;?>?id_del="+id);
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
</head>
<body text='#000000' bgcolor='#FFFFFF' link='blue' vlink='blue'>
    
    <div class="panel panel-primary">
        <div class="panel-heading"><h2>Menu:<?=$elmenuprincipal?></h2></div>
        <div class="panel-body">
            
<form method="POST" name="formulario">
<input type="hidden" name="idmenu" value="<?=$idmenu;?>">
<a href="javascript:openWindow('nuevo_submenu.php?idmenu=<?=$idmenu?>','NuevoSubMenu',500,260)" class="btn btn-primary">Ingresar SubMenu/Link</a>
<?php
if($info[0])
{
?>
	<table class="table table-bordered table-striped table-hover">
            <thead>
	<tr>
		<th >Nombre</th>
		<th >SubMen&uacute;</span></th>
		<th >&nbsp;</span></th>
		<th  align="right">Orden</span></th>
		<th  align="right">Ancho</span></th>
		<th  align="right">Eliminar</span></th>
	</tr>
            </thead>
	<?php
	$i=0;
	
	while($info[$i])
	{
		$datos = $info[$i];
		$id     = $datos->getId();
		$nombrem = $datos->getNombre();
		$nombre = $Aux->cleanHTMLChar($datos->getDescripcion());
		$tipo   = $datos->getTipo();
		$orden  = $datos->getOrden();
		$ancho = $datos->getAncho();
		?>
		<tr>
			<td  ><?=$nombrem?></td>
			<td >
				<a href="javascript:openWindow('nuevo_submenu.php?id=<?=$id;?>&lenguaje=<?=$lenguaje?>','ElSubMenu',520,280)" ><?= $nombre;?></a>
			</td>
			<td >
			<?php if($tipo==3){?>
                        <a href="javascript:openWindow('lasopciones.php?idsubmenu=<?=$id;?>&idmenu=<?=$idmenu;?>&lenguaje=<?=$lenguaje?>','Opciones',580,320)" class="btn btn-primary" ><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Ver Links</a>
			<?php }?>
			</td>
			<td  class="contenidonegro" align="right"><?=$orden?></td>
			<td  class="contenidonegro" align="right"><?=$ancho?></td>
			<td  align="right">
				<a href="javascript:eliminar(<?echo $id;?>)" onmouseover="x<?echo $id;?>.src='/images/cross_on.gif'" onmouseout="x<?echo $id;?>.src='/images/cross_off.gif'"><img src="/images/cross_off.gif" name="x<?echo $id;?>" border="0"></a>
			</td>
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
