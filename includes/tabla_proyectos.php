<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include_once getcwd()."/cfgdir.php";
//include_once getcwd().'/class/session.php';
include_once getcwd().'/class/config.php';
include_once 'header.php';


    $Aux= new DBProyecto();
    $Aux->conecta_pdo();
    $sql = "select estado,count(*) from Proyecto group by estado";
    
    $rs = $Aux->query_pdo($sql);
?>
<table class="table table-bordered table-striped">
    <tr valign="top">
        <td width="50%">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Proyectos</h2></div>
                <div class="panel-body">
                    
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>Estado Proyectos</td>
                            <td>Cantidad</td>
                        </tr>
                    <?php

                        if($rs){
                            $tot = 0;
                            foreach ($rs as $row){
                                $estado = $row[0];
                                $elestado = $Aux->ElDato($estado,"EstadoProyecto","id","descripcion");
                                $cant = $row[1];
                                $tot+=$cant;
                                ?>
                    <tr>
                        <td><a href="/index.php?p=losproyectos&estado=<?=$estado?>"><?=$elestado?></a></td>
                        <td align="right"><?=$cant?></td>
                    </tr>

                    <?php
                            }


                        }
                        ?>
                    <tr>
                        <td>Total</td>
                        <td align="right"><?=$tot?></td>
                    </tr>
                    </table>
                    
                </div>
            </div>

        </td>
<?php
    $sql = "select estado,count(*) from Cotizacion group by estado";
    
    $rs = $Aux->query_pdo($sql);  
?>
        <td width="50%">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Cotizaciones</h2></div>
                <div class="panel-body">
                    
                    <table class="table table-bordered table-striped">
                            <tr>
                                <td>Estado Cotizaciones</td>
                                <td>Cantidad</td>
                            </tr>
                            <?php
                                if($rs){
                            $tot = 0;
                            foreach ($rs as $row){
                                $estado = $row[0];
                                $elestado = $Aux->ElDato($estado,"EstadoCotizacion","id","descripcion");
                                $cant = $row[1];
                                $tot+=$cant;
                                ?>
                    <tr>
                        <td><a href="/index.php?p=lascotizaciones&estado=<?=$estado?>"><?=$elestado?></a></td>
                        <td align="right"><?=$cant?></td>
                    </tr>

                    <?php
                            }


                        }
                        ?>
                    <tr>
                        <td >Total</td>
                        <td align="right"><?=$tot?></td>
                    </tr>
                        </table>                    
                    
                </div>
            </div>
    
        </td>
    </tr>
</table>
