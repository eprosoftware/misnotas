<table>
    <tr class="hnavbg">
        <td class="tituloblanco">Cod</td>
        <td class="tituloblanco">Descripci&oacute;n</td>
    </tr>
    <?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/config.php';

    $Aux = new DBProyecto();
    
    $Aux->conecta();
    
    $sql = "select * from CodigosPedidos ";
    
    $rs=$Aux->query($sql);
    
    
    if($rs){
        $i=0;
        while($row=$Aux->getRows($rs)){
            $cod = $row['cod'];
            $desc = $row['descripcion'];
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