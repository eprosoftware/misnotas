<?php
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
?>
        
<table class="table table-bordered table-striped">
    <tr>
        <th>Cod</th>
        <th>Descripci&oacute;n</th>
    </tr>
    <?php
define('CHARSET', 'ISO-8859-1');
define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

function html($string) {
    return htmlspecialchars($string, REPLACE_FLAGS, CHARSET);
}
    $Aux = new DBCotizacion();
    
    $Aux->conecta_pdo();
    
    $t = $_GET['t'];
    switch($t){
        case 1:$sql = "select * from Codigos  order by cod";break;
        case 2:$sql = "select * from CodigosPedidos order by cod ";break;
    }
    
    
    $rs=$Aux->query_pdo($sql);
    
    
    if($rs){
        $i=0;
        foreach($rs as $row){
            $cod = $row['cod'];
            $desc = htmlspecialchars($row['descripcion']);
            $color = $Aux->flipcolor($color);
            ?>
    <tr bgcolor="<?=$color?>" <?=$Aux->rowEffect($i, $color,"captura('$cod','$desc')")?> >
        <td bgcolor="<?=$color?>"><?=$cod?></td>
        <td bgcolor="<?=$color?>"><?=$desc?></td>
    </tr>
    <?php
            $i++;
        }
        
    }
?>
</table>        

    