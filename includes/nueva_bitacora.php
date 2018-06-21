<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../class/session.php';
include_once '../class/config.php';
include_once 'header.php';

    $Aux = new DBBitacoraTrabajo();
    $dbuser = new DBUsuario();

    $id_user    = $dbuser->getUsuarioId($usuario,$clave);
    $user = $dbuser->ElUsuario($id_user);
    $tipo = $user->getTipoUsuario();
    $todo_horario = $user->getBitacoraHorarioLiberado();
    
    
    $fecha = date("Y-m-d H:i:s");
    $losproyectos = $Aux->TraerLosDatos("Proyecto","nro_proyecto","nombre_proyecto"," order by nombre_proyecto");
?>
<script>
function poner_nro(valor){
    requestPage('/includes/lositemproy.php?valor='+valor,'item_proy_div');
}
function buscar_proyecto(valor){
    requestPage('/includes/getNombreProyecto.php?valor='+valor,'elnombre');
    setTimeout(function(){ poner_nro(valor);},200);
}    

function agregar_bit(fec){
    f = fec;
    n = document.f.nro_proyecto.value;
    if(n=="") {alert('Falta Un nro. de proyecto valido');exit;}
    
    i = document.f.id_item_proyecto.options[document.f.id_item_proyecto.selectedIndex].value;
    h = document.f.nro_horas.value;
    g = document.f.glosa.value;
    
    requestPage('/includes/addBitacoraTrabajo.php?id_user=<?=$id_user?>&fecha='+f+'&nro_proyecto='+n+'&nro_horas='+h+'&id_item='+i+'&glosa='+g,'salida');
        
}   
        
</script>

<?php
    $hora = date("H:i:d");
    $xhora = explode(":",$hora);
    if(($xhora[0]>8 && $xhora[0]<20) || $todo_horario==1 ){
    
?>
<table align="center">
    <tr>
        <td class="titulonegro12">Nuevo Ingreso en Bit&aacute;cora de Trabajo</td>
    </tr>
    <tr>
        <td class="celda_bordes">
            <form action="procesar_bitacora_trabajo.php" method="POST" name="f">
            <table width="100%">
               <tr>
                    <td>Fecha:</td>
                    <td><?=$fecha?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>Nombre Proyecto(Descripci&oacute;n):</td>
                                <td><textarea name="descripcion" rows="4" cols="30" onchange="this.value = this.value.toUpperCase();buscar_proyecto(this.value);" ><?=$descripcion?></textarea></td>
                            </tr>
                            
                            <tr>
                                <td colspan="2"><div id="elnombre">
                                    <table width="100%">
                                        <tr>
                                            <td>Nro.Proyecto:</td>
                                            <td><input type="text" name="nro_proyecto" onchange="buscar_proyecto(this.value)" size="6"></td>
                                        </tr>
                                    </table></div>
                                </td>
                            </tr>                            
                        </table>
                    </td>                    
                </tr>
                <tr>
                    <td>Item Proyecto</td>
                    <td><div id="item_proy_div">Seleccione un Proyecto primero</div></td>
                </tr>
                <tr>
                    <td>Nro. Horas</td>
                    <td><input type="text" size="3" name="nro_horas" value="<?=$nro_horas?>" onblur="if(this.value>9){ alert('No puede ingresar un numero mayor a 9 horas, favor vovler a intentarlo'); this.focus();}"></td>                                                    
                </tr>
                <tr>
                    <td>Glosa:</td>
                    <td><textarea rows="4" cols="50" name="glosa" onblur="this.value = this.value.toUpperCase();"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="button" value="Agregar" onclick="agregar_bit('<?=$fecha?>')" class="boton"></td>
                </tr>
                <tr>
                    <td colspan="2"><div id="salida"></div></td>
                </tr>
            </table>
            </form>
        </td>
    </tr>
</table>    
    <?php } else { ?>
<center>
    <font color="darkred">
<h1>Lo sentimos, pero el horario para agregar notas es de 9:00 A.M a 19:00 P.M.</h1>
<h1>Vuelva a intentarlo ma&ntilde;ana.</h1>
<h1>Gracias</h1>
</font>
</center>
    <?php } ?>
