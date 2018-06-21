<?php
	include("../class/config.php");
	include("../includes/header.php");

	$Aux = new DBSubMenu();
	$menu = new SubMenu();
        
        $comando = $_GET['comando'];
                
        $id             = $_GET['id'];
        $idmenu         = $_GET['idmenu'];
        $idsubmenu      = ($_GET['idsubmenu'])?$_GET['idsubmenu']:" 0";
	$nombre         = $_POST['nombre'];
        $descripcion    = $_POST['descripcion'];
        $ancho          = $_POST['ancho'];
        $clase          = $_POST['clase'];
        $tipo           = $_POST['tipo'];
        

        $link           = $_POST['link'];
        $orden          = $_POST['orden'];
        
        $menu->setNombre($nombre);
	$menu->setDescripcion($descripcion);
	$menu->setAncho($ancho);
	$menu->setLink($link);
	$menu->setOrden($orden);
	$menu->setClase($clase);
	$menu->setTipo($tipo);
	$menu->setIdMenu($idmenu);
        $menu->setIdSubMenu($idsubmenu);

        if($comando==1){
            if (!$id){
                    $Aux->add($menu);
            } else {
                    if ($comando==1){
                            $menu->setId($id);
                            $Aux->update($menu);
                    }
            }
        }
	if($id)
		$info = $Aux->ElSubmenu($id);
	if($info)
	{
		$id 		= $info->getId();
		$nombre 	= $info->getNombre();
		$clase 		= $info->getClase();
		$idmenu 	= $info->getIdMenu();
                $idsubmenu      = $info->getIdSubMenu();
		$descripcion	= $info->getDescripcion();
		$link		= $info->getLink();
		$ancho		= $info->getAncho();
		$tipo		= $info->getTipo();
		$orden		= $info->getOrden();
	}
	$lasclasesmenu = $Aux->TraerLosDatos("MenuClases","descripcion","descripcion");
	$lostipos = array();
	$tmp=array();$tmp[valor]=3;$tmp[txt]="SubMenu";$lostipos[]=$tmp;
	$tmp=array();$tmp[valor]=2;$tmp[txt]="Link";$lostipos[]=$tmp;
?>
<html>
<head>
<script language="Javascript">
function MiSubmit(ruta)
{
        if(ruta)
        {
                document.formulario.action = ruta;
                document.formulario.submit();
        }
}
function validar()
{
	if(!document.formulario.nombre.value)
	{
		alert("Debe ingresar el nombre");
		document.formulario.nombre.focus();
		return false;
	}
	MiSubmit("<?=$PHP_SELF?>?idmenu=<?=$idmenu?>&idsubmenu=<?=$idsubmenu?>&id=<?=$id?>&comando=1");
}
</script>
<script>
window.opener.location = window.opener.location;
<?php if ($comando==1){?>
self.close();
<?php }?>
</script>
<link rel="stylesheet" href="../styles/general_styles.css" type="text/css">
</head>
<body>
    <div class="panel panel-primary">
        <div class="panel-heading"><h2>SubMenu</h2></div>
        <div class="panel-body">
            
<form method="post" name="formulario" action="">
<input type="hidden" name="id" value="<?=$id;?>">
<input type="hidden" name="idmenu" value="<?=$idmenu;?>">

    

	<table border="0" width="100%" align="center" cellspacing="0" cellpading="2" bgcolor="#FFFFFF">
	<tr class="toppanel">
		
	</tr>
	<tr>
            <td><label>Nombre</label></td>
		<td colspan="3">
			<input type="text" name="nombre" value="<?=$nombre;?>" class="form-control">
		</td>
	</tr>
	<tr>
		<td>Descripcion</td>
		<td colspan="3" class="contenidonegro">
			<input type="text" name="descripcion" value="<?=$descripcion;?>" class="form-control">
		</td>
	</tr>
	<tr>
		<td>Clase</td>
		<td colspan="3" class="contenidonegro">
			<?=$Aux->SelectArray($lasclasesmenu,"clase","----",$clase);?>
		</td>
	</tr>
	<tr>
		<td>Ancho</td>
		<td class="contenidonegro"><input type="text" name=ancho value="<?=$ancho?>"  class="form-control"></td>
	</tr>
	<tr>
		<td>Orden</td>
		<td class="contenidonegro"><input type="text" name=orden value="<?=$orden?>"  class="form-control"></td>
	</tr>
	<tr>
		<td>Enlace</td>
		<td class="contenidonegro" colspan=3><input type="text"  class="form-control" name=link value="<?=$link?>"></td>
	</tr>	
	<tr>
		<td>Tipo de SubMenu:</td>
		<td class="contenidonegro" colspan=3>
		<?=$Aux->SelectArray($lostipos,"tipo","----",$tipo);?></td>
	</tr>	
	<tr>
		<td colspan="4">
                    <button type="button" class="btn btn-primary" onClick="validar();">Aceptar</button>
			&nbsp;
                        <button type="button" class="btn btn-danger" onClick="history.back();">Cancelar</button>
		</td>
	</tr>
	</table>
	
</form>            
            
        </div>
    </div>

</body>
</html>
