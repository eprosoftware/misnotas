<?php
    include_once str_replace("/includes","",getcwd())."/class/config.php";
    
    $Aux = new DBUsuario();
    $tmp = new Usuario();
    
    $activo = $_GET['activo'];
    $id_del = $_GET['id_del'];    
    $jefe = $_GET['jefe'];
    
    if($id_del)
    {
        $aa = $Aux->DelUsuario($id_del," $activo");
    }
    $users = $Aux->LosUsuarios(""," $activo",$jefe);	
    $losjefes = $Aux->TraerLosDatos("Usuarios","id","nombre"," order by nombre");
?>
<html>
<head>
<script src="js/functions.js" type="text/javascript" language="javascript"></script>
<script language="javascript">
<!--
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
		if(confirm("Desea Eliminar el Usuario?"))
			MiSubmit("<?=$PHP_SELF?>?p=losusuarios&activo=1&id_del="+id);
	}
}
function elestado(id,estado)
{
	MiSubmit("<?=$PHP_SELF?>?id_est="+id+"&estado="+estado);
}
function responder(id)
{
	alert("Aun no disponible");
}
-->
</script>
<script language="javascript" src="/js/libreria.js"></script>
<link rel="stylesheet" href="/styles/general_styles.css" type="text/css">
</head>
<body text='#000000' bgcolor='#FFFFFF' link='blue' vlink='blue'>
    <div class="panel panel-default">
        <div class="panel-heading"><h2><?=($activo==" 1")?"Usuarios Activos":"Usuarios Eliminados"?></h2></div>
        <div class="panel-body">

<form method="POST" name="formulario">
<input type="hidden" name=activo value="<?=$activo?>">

<table class="table table-bordered table-striped table-hover">
<?php
if($users[0]){?>
<tr>
    <td>JEFE</td>
    <td colspan="3"><?=$Aux->SelectArray($losjefes,"jefe","Seleccione Jefe",$jefe,"","document.location='/index.php?p=losusuarios&activo=$activo&jefe='+this.value")?></td>
    <td colspan="3"><a href="/index.php?p=nuevo_usuario&activo=<?=$activo?>" class="btn btn-white"><span class="glyphicon glyphicon-user"></span>&nbsp;Nuevo Usuario</a></td>
    <td colspan="5"></td>
</tr>

<tr>
        <th>Rut</th>
        <th>Usuario&nbsp;</th>
        <th>Alias&nbsp;</th>
        <th>Nombre&nbsp;</th>
        <th>Email&nbsp;</th>
        <th>Telefono&nbsp;</th>
        <th>Celular&nbsp;</th>
        <th>Tipo Usuario&nbsp;</th>
        <th>Jefe&nbsp;</th>
        <th>dias clave</th>
        <th>Ult. Acceso</th>
        <th></th>
</tr>

	<?php
	$i=0;
	while($tmp=$users[$i])
	{
		$bgcolor=$Aux->flipcolor($bgcolor);
		$id		= $tmp->getId();
                $rut            = $tmp->getRut();
		$usuario	= $tmp->getUsuario();
		$alias		= $tmp->getAlias();
		$clave		= $tmp->getClave();
		$nombre		= $tmp->getNombre();
		$tipo_usuario   = $tmp->getTipoUsuario();
                $eltipoU = $Aux->ElDato($tipo_usuario,"TipoUsuario","id","descripcion");
                $id_jefe        = $tmp->getJefe();
                $eljefe         = $Aux->ElDato($id_jefe,"Usuarios","id","nombre");

		$email		= $tmp->getEmail();
		$menu		= $tmp->getMenu();
		$activo		= $tmp->getActivo();
		$fono		= $tmp->getFono();
		$celular	= $tmp->getCelular();
		$cumpleanos	= $tmp->getFechaCumpleanos();
                $fecha_mod_clave= $tmp->getFechaModClave();
                $ult_acceso     = $tmp->getUltAcceso();
                
		$dias_cambio_clave = $tmp->getNroDiasCambioClave();
		?>
<tr >
    <td><?=$rut?></td>
    <td><a href="/index.php?p=nuevo_usuario&id=<?=$id?>&activo=<?=$activo?>" class="titulonegro"><?=$usuario?></a></td>
    <td><?=$alias?></td>
    <td><?=$nombre?></td>
    <td><?=$email?></td>
    <td align="right"><?=$fono?></td>
    <td align="right"><?=$celular?></td>
    <td><?=$eltipoU?></td>
    <td><?=$eljefe?></td>
    <td align="center"><?=$dias_cambio_clave?></td>
    <td><?=$ult_acceso?></td>
    <td>
        <button type="button" onclick="eliminar(<?=$id;?>)" class="btn btn-danger">Eliminar</button>
            
    </td>
</tr>
		<?php
		$i++;
	}
	?>

<tr>
    <td colspan="12">Total de usuarios encontrados <?=$i?></td>
</tr>
<?php
} else {
?>
<tr><td colspan=12><div class="alert alert-danger">No se Encontraron usuarios</div></td></tr>
<?php }?>
</table>

</form>
            
        </div>
    </div>

</body>
</html>
