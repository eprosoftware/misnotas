<?php
    include_once str_replace("/includes","",getcwd()).'/cfgdir.php';
    include_once str_replace("/includes","",getcwd()).'/class/config.php';

    $tabla=$_GET['tabla'];
    $titulo=$_GET['titulo'];
    $descripcion=$_POST['descripcion'];
    $estados = $_POST['estados'];
    $nro_estados = $_POST['nro_estados'];
    $tipo=$_GET['tipo'];
    $comando=$_POST['comando'];
    $ids = $_POST['ids'];
    
    $x = new DBNucleo();
    $x->conecta_pdo();
    
    $tabla = "TipoProyecto";
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
	MiSubmit("<?=$base_dir?>/index.php?p=tipos_proy");
}
function fill(d,n,e){
    document.f.descripcion.value=d;
    document.f.nro_estados.value=n;
    document.f.estados.value=e;
}
function cuenta_estados(e){
    makerequest('<?=$base_dir?>/includes/cuenta_estados.php?estados='+e,'nroesta');
}
</script>

<div class="panel panel-default">
    <div class="panel-heading"><h2>Tipos de Proyecto</h2></div>
    <div class="panel-body">
        
<form name="f" action="" method=POST>
<input type=hidden name=comando>
<table class="table table-bordered table-striped">
<tr>
    <td>
<table cellspacing=0 cellpadding=1>
<tr>
    <td>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Descripci&oacute;n</th>
                <th>Lista de Estados</th>
                <th>#Estados</th>
            </tr>
            <tr valign="top">
                <td><input type=hidden name=id>
                    <input type=text name=descripcion value="<?=$descripcion?>" size="40" onblur="this.value = this.value.toUpperCase();"></td>
                <td><textarea name="estados" cols="40" rows="3"  onblur="this.value = this.value.toUpperCase();cuenta_estados(this.value);"></textarea></td>
                <td><div id="nroesta"><input type="text" name="nro_estados" size="3"></div></td>
            </tr>
        </table>
    </td>
<tr>
<tr>
    <td>
        <a href="javascript:poner(1);" class="btn btn-primary">Agregar</a>&nbsp;
        <a href="javascript:poner(3);" class="btn btn-primary">Modificar</a>&nbsp;
        <a href="javascript:poner(2);" class="btn btn-danger">Eliminar</a>
    </td>
</tr>
<tr>
    <td>     
<table class="table table-bordered table-striped">
<tr>
    <th>ID</th>
    <th>Descripci&oacute;n</th>
    <th>Estados</th>
    <th>Nro. Estatos</th>
</tr>
<?php

        //echo "<p>Comando:$comando</p>";	
	switch ($comando){
	case 1://Agregar Concepto
		$sql = "insert $tabla(descripcion,estados,nro_estados) values('$descripcion','$estados',$nro_estados)";
		//echo "<p>SQL:$sql</p>";
		$rs = $x->query_pdo($sql);
		break;
	case 2://Eliminar Concepto
		$sql = "delete from $tabla where ID = $ids";
		//echo "<p>SQL:$sql</p>";
		$rs = $x->query_pdo($sql);
		break;
	case 3://Modificar Concepto
		$sql = "update $tabla set "
                . "descripcion=:descripcion,"
                . "nro_estados=:nro_estados,"
                . "estados=:estados  "
                . "where ID = :ids";
            
            
		
                $xql = str_replace(":descripcion", $descripcion,$sql);
                $xql = str_replace(":nro_estados",$nro_estados,$xql);
                $xql = str_replace(":estados",  $estados,$xql);
                $xql = str_replace(":ids",$ids,$xql);
                //echo "<p>SQL:$xql</p>";
                
                $st = $x->pdo->prepare($sql);
                $descripcion = utf8_encode($descripcion);
                $estados = utf8_decode($estados);
                $st->bindParam(":descripcion", $descripcion);
                $st->bindParam(":nro_estados",$nro_estados);
                $st->bindParam(":estados",  $estados);
                $st->bindParam(":ids",$ids);
                
		$st->execute();
		break;
	}

	$sql = "select * from $tabla";
	$rs = $x->query_pdo($sql);
	if ($rs)
            foreach ($rs as $campos){
		$id = $campos['id'];
		$descripcion = utf8_encode($campos['descripcion']);
                $nroestados = $campos['nro_estados'];
                $estados = $campos['estados'];
		$bgcolor=$x->flipcolor($bgcolor);
?>
<tr>
    <td>
    <input type=radio name=ids value=<?=$id?> cols=80 onclick="fill('<?=$descripcion?>','<?=$nroestados?>','<?=$estados?>');"> <?=$id?>
    </td>
    <td><?=($descripcion)?></td>
    <td><?=($estados)?></td>
    <td align="right"><?=$nroestados?></td>
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

