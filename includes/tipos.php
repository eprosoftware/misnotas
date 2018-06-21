<?php
include_once str_replace("/includes","",getcwd()).'/cfgdir.php';
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd())."/includes/header.php";


    $tabla=         $_GET['tabla'];
    $titulo=        $_GET['titulo'];
    $descripcion=   $_POST['descripcion'];
    $tipo=          $_GET['tipo'];
    $comando=       $_POST['comando'];
    $ids =          $_POST['ids'];
    
    $x = new DBNucleo();
    $x->conecta();
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
function poner(x){
	document.forms[0].comando.value=x;
	MiSubmit("<?=$base_dir?>/index.php?p=tipos&tabla=<?=$tabla?>&titulo=<?=$titulo?>");
}
</script>

<div class="panel panel-default">
    <div class="panel-heading"><h2><?=$titulo?></h2></div>
    <div class="panel-body">
        
<form action="" method="POST">
<input type=hidden name=comando>
<table class="table table-bordered table-striped">
<tr>
    <td>
<table class="table table-bordered table-striped">
<tr >
    <td>Descripci&oacute;n</td>
</tr>
<tr>
    <td><input type=hidden name=id>
    <input type="text" name="descripcion" value="<?=$descripcion?>" class="form-control" onblur="this.value = this.value.toUpperCase();"></td>
</tr>
<tr>
    <td>
<a href="javascript:poner(1);" class="btn btn-primary">Agregar</a>&nbsp;
<a href="javascript:poner(3);" class="btn btn-primary">Modificar</a>&nbsp;
<a href="javascript:poner(2);" class="btn btn-danger">Eliminar</a>
    </td>
</tr>
</table>
    </td>
</tr>
<tr> 
    <td>
<table class="table table-bordered table-striped">
<tr>
    <th>ID</th>
    <th>Descripci&oacute;n</th>
</tr>
<?php

        //echo "<p>Comando:$comando</p>";	
	switch ($comando){
	case 1://Agregar Concepto
		$sql = "insert $tabla(descripcion) values(\"$descripcion\")";
		//echo "<p>SQL:$sql</p>";
		$rs = $x->query_pdo($sql);
		break;
	case 2://Eliminar Concepto
		$sql = "delete from $tabla where ID = $ids";
		//echo "<p>SQL:$sql</p>";
		$rs = $x->query_pdo($sql);
		break;
	case 3://Modificar Concepto
		$sql = "update $tabla set descripcion=:descripcion where ID = :ids";
                $st = $x->pdo->prepare($sql);
                $st->bindParam(":descripcion",$descripcion);
                $st->bindParam(":ids",$ids);
                
		//echo "<p>SQL:$sql</p>";
		$st->execute();
		break;
	}

	$sql = "select * from $tabla";
	$rs = $x->query_pdo($sql);
	if ($rs)
	foreach($rs as $campos){
		$id = $campos['id'];
		$descripcion = $campos['descripcion'];
		$bgcolor=$x->flipcolor($bgcolor);
?>
<tr>
    <td>
    <input type=radio name=ids value=<?=$id?> cols=80 onclick="document.forms[0].descripcion.value='<?=$descripcion?>'"> <?=$id?>
    </td>
    <td><?= utf8_encode($descripcion)?></td>
</tr>
<?php
	}
?>
</table>
</td>
</tr>
</table>
</form>        
        
    </div>
</div>

