<?php
    include_once str_replace("/includes","",getcwd())."/cfgdir.php";
    include_once str_replace("/includes","",getcwd()).'/class/config.php';

    $codigo = $_POST['codigo'];
    $tabla=$_GET['tabla'];
    $titulo=$_GET['titulo'];
    $descripcion=$_POST['descripcion'];
    $tipo=$_GET['tipo'];
    $comando=$_POST['comando'];
    $ids = $_POST['ids'];
    
    $x = new DBNucleo();
    $x->conecta_pdo();
?>
<script language="javascript">
function MiSubmit(ruta)
{
        if(ruta)
        {
              document.forms[0].action = ruta;
              document.forms[0].submit();
        }
}
function colocar(x,y){
    document.forms[0].codigo.value=x;
    document.forms[0].descripcion.value=y;
}
function poner(x){
	document.forms[0].comando.value=x;
	MiSubmit("<?=$base_dir?>/index.php?p=tipos_codigos&tabla=<?=$tabla?>&titulo=<?=$titulo?>");
}
</script>
<form action="" name="f" method="POST">
<input type=hidden name=comando>
<div class="panel panel-default">
    <div class="panel-heading"><h2><?=$titulo?></h2></div>
    <div class="panel-body">
        
<table class="table table-bordered table-striped">
<tr>
    <td>
        <table class="table table-bordered table-striped">
        <tr>
            <th>C&oacute;digo<br>(Max.15 car.)</th>
            <th>Descripci&oacute;n</th>
        </tr>
        <tr>
            <td><input type="text" name="codigo" value="<?=$codigo?>" class="form-control" onblur="this.value = this.value.toUpperCase();"></td>
            <td><input type="hidden" name="id">
            <input type="text" name="descripcion" value="<?=$descripcion?>" size=50 class="form-control" onblur="this.value = this.value.toUpperCase();"></td>
        <tr>
        <tr><td colspan="2">
        <a href="javascript:poner(1);" class="btn btn-primary">Agregar</a>&nbsp;
        <a href="javascript:poner(3);" class="btn btn-primary">Modificar</a>&nbsp;
        <a href="javascript:poner(2);" class="btn btn-danger">Eliminar</a>
        </td></tr>
        </table>
    </td>
</tr>
<table class="table table-bordered table-striped">
<tr>
    <th>ID</th>
    <th>Cod.</th>
    <th>Descripci&oacute;n</th>
</tr>
<?php

        //echo "<p>Comando:$comando</p>";	
	switch ($comando){
	case 1://Agregar Concepto
		$sql = "insert $tabla(cod,descripcion) values('$codigo','$descripcion')";
		//echo "<p>SQL:$sql</p>";
		$rs = $x->query_pdo($sql);
		break;
	case 2://Eliminar Concepto
		$sql = "delete from $tabla where ID = $ids";
		//echo "<p>SQL:$sql</p>";
		$rs = $x->query_pdo($sql);
		break;
	case 3://Modificar Concepto
		$sql = "update $tabla set cod='$codigo',descripcion='$descripcion' where ID = $ids";
		//echo "<p>SQL:$sql</p>";
		$rs = $x->query_pdo($sql);
		break;
	}

	$sql = "select * from $tabla";
	$rs = $x->query_pdo($sql);
	if ($rs)
            foreach ($rs as $campos){
		$id = $campos['id'];
                $cod = $campos['cod'];
		$descripcion = $campos['descripcion'];
		$bgcolor=$x->flipcolor($bgcolor);
?>
<tr>
    <td>
    <input type=radio name=ids value=<?=$id?> cols="80" onclick="colocar('<?=$cod?>','<?=$descripcion?>');"> <?=$id?>
    </td>
    <td><?=$cod?></td>
    <td><?=$descripcion?></td>
</tr>
<?php
	}
?>
</table>
    </td>
</tr>
</table>        
        
    </div>
</div>

</form>
