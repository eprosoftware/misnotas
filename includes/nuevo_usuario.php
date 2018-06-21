<?php 
include_once str_replace("/includes","",getcwd()).'/cfgdir.php';
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd())."/includes/header.php";
    
    $Aux = new DBUsuario();

    $id     = $_GET['id'];
    $activo = $_GET['activo'];


    if($id)
    {
        $datos = $Aux->ElUsuario($id);
        $id 	= $datos->getId();
        $rut = $datos->getRut();
        $nombre	= $datos->getNombre();
        $alias  = $datos->getAlias();
        $usr   = $datos->getUsuario();
        $passwd	= $datos->getClave();
        $passwd_old = $datos->getUltClave();
        $email	= $datos->getEmail();
        $fono	= $datos->getFono();
        $celular= $datos->getCelular();
        $menu   = $datos->getMenu();
        $submenu = $datos->getSubMenu();
        $tipo_usuario =$datos->getTipoUsuario();
        $cumpleanos= $datos->getFechaCumpleanos();
        $jefe       = $datos->getJefe();
        
        $permisos = explode(",",$datos->getPermisos());
    }
    $Aux->conecta();
    $lostipos = $Aux->TraerLosDatos("TipoUsuario","id","descripcion");
    $losusuarios = $Aux->TraerLosDatos("Usuarios","id","nombre");
    $lasopciones = $Aux->TraerLosDatos("Respuestas", "id", "descripcion");
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
		alert("Debe ingresar el nombre del usuario");
		document.formulario.nombre.focus();
		return false;
	}
<?php if(!$id){?>
	if(!document.formulario.usr.value)
	{
		alert("Debe ingresar el usuario");
		document.formulario.usuario.focus();
		return false;
	}
	if(!document.formulario.passwd.value)
	{
		alert("Debe ingresar la clave");
		document.formulario.clave.focus();
		return false;
	}
<?php }?>
	if(!document.formulario.email.value)
	{
		alert("Debe ingresar el E-mail");
		document.formulario.email.focus();
		return false;
	}
	MiSubmit("<?=$base_dir?>/index.php?p=procesausuario&id=<?=$id?>&activo=<?=$activo?>");
	}
function carga_menu_usr(id){
	requestPage('<?=$base_dir?>/includes/usuario_menu.php?idgrp='+id,'cuadro_menu');
}        
</script>

</head>
<body>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Datos Usuario</h2></div>
        <div class="panel-body">
            
<form method="post" name="formulario" action="">

<table border="0" width="80%" align="center" cellspacing="0" cellpading="0">
<tr>
	<td>
	<table class="table table-bordered table-striped">
	<tr>
		<td colspan="3" >Datos</td>
                <td><a href="<?=$base_dir?>/index.php?p=losusuarios&activo=<?=$activo?>" class="btn btn-primary">Volver al listado de Usuarios</a></td>
	</tr>
	<tr valign="top">
		<td>Usuario</td>
		<td class="contenidonegro">
		<?php if(!$id){?>
			<input type="text" name="usr" value="<?=$usr;?>">
		<?php }else{
			echo "<font size=3 color=navy><b>$usr</b></font>";
			echo "<input type='hidden' name='usr' value='$usr'>";
		}
		?>
		</td>
		<td>Alias</td>
		<td><input type="text" name="alias" value="<?=$alias;?>"></td>
	</tr>
	<tr>
		<td>Clave</td>
		<td class="contenidonegro" >
		<input type="password" name="passwd" value="<?=$passwd;?>"><a href="javascript:alert('PWD:<?=$passwd?> PWD OLD:<?=$passwd_old?>');"><img src="<?=$base_dir?>/images/index_bullet.gif" border=0></a>
		</td>
            <td>Rut</td>
            <td><input type="text" name="rut" value="<?=$rut?>" onblur="checkRutField(this.value,this)"><input type="hidden" name="dig"></td>
        </tr>
	<tr>
		<td>Nombre</td>
		<td class="contenidonegro">
			<input type="text" name="nombre" value="<?=$nombre;?>" size="40" onblur="this.value = this.value.toUpperCase();">
		</td>
		<td>E-Mail</td>
		<td class="contenidonegro">
			<input type="text" name="email" value="<?echo $email;?>">
		</td>
	</tr>
	<tr>
		<td>Fono:</td>
		<td class="contenidonegro"><input type=text name=fono value="<?=$fono?>"></td>
		<td>Celular:</td>
		<td class="contenidonegro"><input type=text name=celular value="<?=$celular?>"></td>
	</tr>
	<tr>
		<TD>Tipo Usuario:</TD>
		<td class="contenidonegro" colspan="3"><?=$Aux->SelectArray($lostipos,"tipo_usuario","----",$tipo_usuario,"","carga_menu_usr(this.value)")?></td>
	</tr>
	<tr>
		<TD>Jefe:</TD>
		<td class="contenidonegro" colspan="3"><?=$Aux->SelectArray($losusuarios,"jefe","----",$jefe)?></td>
	</tr>   
        
        <tr>
            <td colspan="4" class="celda_bordes">
                <table class="table table-bordered table-striped">
                    <tr>
                        <td>Despachar Item Proyecto</td>
                        <td>Eliminar Cotizaci&oacute;n</td>
                        <td>Eliminar Proyecto</td>
                        <td>Eliminar Item Proyecto</td>
                        <td>Eliminar Mi Bitacora</td>
                        <td>Horario Liberado Bit&aacute;cora</td>
                        <td>Estados Pago OD y HES</td>
                    </tr>
                    
                    <tr>
                        <td><?=$Aux->SelectArray($lasopciones,"permisos[]","----",$permisos[0])?></td>
                        <td><?=$Aux->SelectArray($lasopciones,"permisos[]","----",$permisos[1])?></td>
                        <td><?=$Aux->SelectArray($lasopciones,"permisos[]","----",$permisos[2])?></td>
                        <td><?=$Aux->SelectArray($lasopciones,"permisos[]","----",$permisos[3])?></td>
                        <td><?=$Aux->SelectArray($lasopciones,"permisos[]","----",$permisos[4])?></td>
                        <td><?=$Aux->SelectArray($lasopciones,"permisos[]","----",$permisos[5])?></td>
                        <td><?=$Aux->SelectArray($lasopciones,"permisos[]","----",$permisos[6])?></td>
                    </tr>
                    <tr>
                        <td>Asignar Proyectista</td>
                        <td>Asignar Estado Proyecto</td>
                        <td>Editar Proyectos</td>
                        <td>Editar &Iacute;tem Proyectos</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><?=$Aux->SelectArray($lasopciones,"permisos[]","----",$permisos[7])?></td>
                        <td><?=$Aux->SelectArray($lasopciones,"permisos[]","----",$permisos[8])?></td>
                        <td><?=$Aux->SelectArray($lasopciones,"permisos[]","----",$permisos[9])?></td>
                        <td><?=$Aux->SelectArray($lasopciones,"permisos[]","----",$permisos[10])?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>    
                </table>
            </td>
        </tr>
        <tr>
                <td>Fecha Cumpleanos:(MM/DD)</td>
                <td><input type=text name=cumpleanos value="<?echo $cumpleanos?>"></td>
		<td>Notificar Usuario</td>
		<td class="contenidonegro"><input type="checkbox" name=notificar></td>
        </tr>
	</table>
	</td>
</tr>
	<tr><td colspan="3" bgcolor="#ffffff">
	<table width="100%"><tr><td>
                    <button type="button" name="aceptar" onClick="validar();" class="btn btn-primary"><?=($id)?"Aplicar Cambios":"Crear Usuario"?></button>
	</td></tr>
	</table>
	</td>
	</tr>
        <tr><td>
	<table width="100%">
	<tr>
		<TD class="tituloblanco">Men&uacute;s</TD>
		<TD align="right"></td>
	</tr>
	</table>
</td></tr>
<tr><td><div id=cuadro_menu><?php $idusr=$id;include("usuario_menu.php");?></div></td></tr>

</table>
</form>            
            
        </div>
    </div>
</body>
</html>
