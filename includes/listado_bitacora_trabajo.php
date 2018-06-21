<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/session.php';
include_once '../class/config.php';
//include_once 'header.php';

    $Aux = new DBBitacoraTrabajo();
    $dbuser = new DBUsuario();

    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    $user = $dbuser->ElUsuario($id_user);
    $tipo = $user->getTipoUsuario();
    
    $nro_proyecto = $_GET['nro_proyecto'];
   
    $glosa = $_GET['glosa'];
    $proyectista = $_GET['proyectista'];
    $id_item = $Aux->ElDato($tmp['id_item'],"ItemProyecto","id","item_contratado");
    $fecha1 = $_GET['fecha1'];
    $fecha2 = $_GET['fecha2'];
    $jefe = $_GET['jefe'];
    

    
    $fecha = date("Y-m-d");
    $labitacora = $Aux->get($proyectista,$nro_proyecto,"",$glosa,$fecha1,$fecha2,$jefe);
    
    $eltipo = $Aux->ElDato($tipo,"TipoUsuario","id","descripcion");
    if(!isset($estado)) $estado="1,2";
    $losproyectos = $Aux->get("",$nro_proyecto,$estado,$encargado,$nombre_proyecto);
    $losproyectistas = $Aux->TraerLosDatos("Usuarios","id","nombre", " where tipo_usuario>2");
    $losjefes = $Aux->TraerLosDatos("Usuarios","id","nombre", " where tipo_usuario in (2,3)");
?>
<script>
function filtrar(){
    n = document.f.nro_proyecto.value;
    g = document.f.glosa.value;
    proyectista = document.f.proyectista.options[document.f.proyectista.selectedIndex].value;
    j = document.f.jefe.options[document.f.jefe.selectedIndex].value;
    f1 = document.f.fecha1.value;
    f2 = document.f.fecha2.value;
    
    document.location="/index.php?p=listado_bitacora_trabajo&nro_proyecto="+n+"&proyectista="+proyectista+"&glosa="+g+"&fecha1="+f1+"&fecha2="+f2+'&jefe='+j;
}
</script>
<table align="center">
    <tr>
        <td class="titulonegro12">Bit&aacute;cora Trabajo</td>
    </tr>
    <tr>
        <td>
            <form action="" name="f" method="POST">
            <table>
                <tr>
                    <td colspan="4">
                        <table>
                            <tr>
                                <td>Fecha Desde:</td>
                                <td><input name="fecha1" id="fecha1" size="12" type="text" value="<?=$fecha1?>" onkeypress="return dontKey(Event);">
<script language="JavaScript">
        var A_CALTPL = {
		'months' : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		'weekdays' : ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		'yearscroll': true,
		'weekstart': 1,
		'centyear'  : 70,
		'imgpath' : 'img/'
	}
	new tcal ({
		'controlname': 'fecha1'
	},A_CALTPL );
        
        </script></td>
                                <td>Fecha Hasta:</td>
                                <td><input name="fecha2" id="fecha2" size="12" type="text" value="<?=$fecha2?>" onkeypress="return dontKey(Event);">
<script language="JavaScript">
        var A_CALTPL = {
		'months' : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		'weekdays' : ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		'yearscroll': true,
		'weekstart': 1,
		'centyear'  : 70,
		'imgpath' : 'img/'
	}
	new tcal ({
		'controlname': 'fecha2'
	},A_CALTPL );
        
        </script></td>
                            </tr>                                    
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>Nro.Proyecto:<input type="text" size="5" name="nro_proyecto" value="<?=$nro_proyecto?>"></td>
                    <td>Glosa:<input type="text" size="50" name="glosa" value="<?=$glosa?>"></td>
                    <td>Proyectista:<?=$Aux->SelectArrayBig($losproyectistas,"proyectista","----",$proyectista)?></td>
                    
                </tr>
                <tr><td></td>
                    <td>Jefe:<?=$Aux->SelectArrayBig($losjefes,"jefe","----",$jefe)?></td>
                    <td><input type="button" value="Aplicar Filtro" name="a" onclick="filtrar();"></td>
                    <td><a href="/includes/csv_listado_bitacora_trabajo.php?jefe=<?=$jefe?>&proyectista=<?=$proyectista?>&nro_proyecto=<?=$nro_proyecto?>&glosa=<?=$glosa?>&fecha1=<?=$fecha1?>&fecha2=<?=$fecha2?>&id_item=<?=$id_item?>">Descargar CSV</a></td>
                </tr>
            </table></form>
        </td>
    </tr>
    <tr>
        <td class="celda_bordes">
            <table width="100%">
               <tr class="hnavbg">
                    <td class="tituloblanco12">Fecha</td>
                    <td class="tituloblanco12">Nro.<br>Proy.</td>
                    <td class="tituloblanco12">Nombre Proy.</td>
                    <td class="tituloblanco12">Item</td>
                    <td class="tituloblanco12">Jefe</td>
                    <td class="tituloblanco12">Proy</td>
                    <td class="tituloblanco12">Nro.<br>Horas</td>
                    <td class="tituloblanco12">Glosa</td>
                </tr>
<?php
    $total_horas=0;
    for($i=0;$i<count($labitacora);$i++){
        $tmp = $labitacora[$i];
        $fecha = $tmp['fecha'];
        $id_proy = $tmp['proyectista'];
        $elproyectista = $Aux->ElDato($id_proy,"Usuarios","id","alias");
        $nro_proy = $tmp['nro_proyecto'];
        $item = $Aux->ElDato($tmp['id_item'],"ItemProyecto","id","item_contratado");
        $nombre_proyecto = $Aux->ElDato($nro_proy,"Proyecto","nro_proyecto","nombre_proyecto");
        $nro_horas = $tmp['nro_horas'];$total_horas += $nro_horas;
        $glosa = $tmp['glosa'];
        $id_jefe =$tmp['jefe'];$eljefe = $Aux->ElDato($id_jefe,"Usuarios","id","alias");
        $color = $Aux->flipcolor($color);
        
        ?>
                <tr bgcolor="<?=$color?>">
                    <td><?=$fecha?></td>
                    <td><?=$nro_proy?></td>
                    <td><?=$nombre_proyecto?></td>
                    <td><?=$item?></td>
                    <td><?=$eljefe?></td>
                    <td><?=$elproyectista?></td>
                    <td align="right"><?=$nro_horas?></td>
                    <td><?=$glosa?></td>
                </tr>                
                <?php
    }
?>
                <tr>
                    <td colspan="6">Total Horas</td>
                    <td align="right"><?=$total_horas?></td>
                    <td></td>
                </tr>    
            </table>
            </form>
        </td>
    </tr>
</table>    