<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once DIR.'class/session.php';
include_once DIR.'class/config.php';

    $nro_guia = date("is");

?>
<table width="80%">
    <tr>
        <td colspan="2"><img src="/images/logo_aerocom.png" bordeR="0"></td>
    </tr>
    <tr>
        
        <td>Se&ntilde;or (es):</td>
        <td><input type="text" name="empresa" size="60"></td>
        <td colspan="2" rowspan="5" >
            <table>
                <tr>
                    <td class="celda_bordes">
                        <table>
                            <tr >
                                <td class="titulonegro12">RUT</td>
                                <td class="titulonegro12">85.060.900-4</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="titulonegro12">GUIA DE SERVICIO</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="titulonegro12">N&deg; <?=$nro_guia?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="celda_bordes">
                        <table>
                            <tr>
                                <td>Solicita Servicio</td>
                                <td>Orden de Compra</td>
                            </tr>
                            <tr>
                                <td><input type="text" name="sol_serv" size="10"></td>
                                <td><input type="text" name="sol_serv" size="10"></td>
                            </tr>
                            <tr>
                                <td>Nro OT</td>
                                <td>Nro. Contrato</td>
                            </tr>
                            <tr>
                                <td><input type="text" name="sol_serv" size="10"></td>
                                <td><input type="text" name="sol_serv" size="10"></td>
                            </tr>                
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="celda_bordes">
                        <table>
                            <tr>
                                <td>Tipo Servicio</td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="a">Reparaci&oacute;n</td>
                                <td><input type="radio" name="a">Garant&iacute;a</td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="a">Instalaci&oacute;n</td>
                                <td><input type="radio" name="a">Mantenci&oacute;n</td>
                            </tr>                
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="celda_bordes">
                        <table>
                            <tr>
                                <td>Tipo de Sistema</td>
                                <td>T&eacute;cnico</td>
                            </tr>
                            <tr>
                                <td><input type="text" size="10" name="b"></td>
                                <td><input type="text" size="10" name="b"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>RUT:</td>
        <td><input type="text" name="rut" size="10">-<input type="text" name="dig" size="2"></td>                            
    </tr>
    <tr>
        <td>Direcci&oacute;n:</td>
        <td><input type="text" name="direccion" size="60"></td>
    </tr>
    <tr>
        <td>Ciudad:</td>
        <td><input type="text" name="ciudad" size="50"></td>
    </tr>
    <tr>
        <td>Giro:</td>
        <td><input type="text" name="ciudad" size="50"></td>
    </tr>
    <tr>
        <td colspan="4" class="celda_bordes">
            <table width="100%">
                <tr>
                    <td>Descripci&oacute;n de falla:</td>
                    <td align="right"><textarea name="desc_falla" cols="80" rows="5"></textarea></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="4" class="celda_bordes">
            <table  width="100%">
                <tr>
                    <td>Descripci&oacute;n de reparaci&oacute;n:</td>
                    <td align="right"><textarea name="desc_repa" cols="80" rows="5"></textarea></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <table width="100%" border="1">
                <tr>
                    <th>Nro Parte</th>
                    <th>Cantidad</th>
                    <th>Materiales</th>
                    <th>Nro Parte</th>
                    <th>Cantidad</th>
                    <th>Materiales</th>
                </tr>
                <tr>
                    <td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td>
                </tr>                
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <table width="100%" border="1">
                <tr>
                    <th>Dia</th>
                    <th>Fecha</th>
                    <th>Tipo de Viaje</th>
                    <th>Hora Llegada</th>
                    <th>Tiempo de espera</th>
                    <th>Hora Salida</th>
                    <th>Total T. Normal</th>
                    <th>Tiempo extra 25%</th>
                    <th>Tiempo extra 50%</th>
                    <th>Km</th>
                    <th>Instalador adicional</th>
                </tr>
                <tr>
                    <th>Lu</th>
                    <th></th><th></th><th></th><th></th><th></th>
                    <th></th><th></th><th></th><th></th><th></th>
                </tr>
                <tr>
                    <th>Ma</th>
                    <th></th><th></th><th></th><th></th><th></th>
                    <th></th><th></th><th></th><th></th><th></th>                    
                </tr>
                <tr>
                    <th>Mi</th>
                    <th></th><th></th><th></th><th></th><th></th>
                    <th></th><th></th><th></th><th></th><th></th>                    
                </tr>
                <tr>
                    <th>Ju</th>
                    <th></th><th></th><th></th><th></th><th></th>
                    <th></th><th></th><th></th><th></th><th></th>                    
                </tr>
                <tr>
                    <th>Vi</th>
                    <th></th><th></th><th></th><th></th><th></th>
                    <th></th><th></th><th></th><th></th><th></th>                    
                </tr>
                <tr>
                    <th>Sa</th>
                    <th></th><th></th><th></th><th></th><th></th>
                    <th></th><th></th><th></th><th></th><th></th>                    
                </tr>
                <tr>
                    <th>Do</th>
                    <th></th><th></th><th></th><th></th><th></th>
                    <th></th><th></th><th></th><th></th><th></th>                    
                </tr>                
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <table width="100%">
                <tr>
                    <td><input type="radio" name="r1">Horario Lunes a Viernes de 8:00 a 18:00 hrs.</td>
                    <td><input type="radio" name="r1">Horario 50% Lunes a Viernes de 22:00 a 8:00 hrs.</td>
                </tr>
                <tr>
                    <td><input type="radio" name="r1">Horario 25% de 18:00 a 22:00 hrs.</td>
                    <td><input type="radio" name="r1">S&aacute;bado - Domingo y Festivos 50% adicional</td>
                </tr>                
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <table width="100%">
                <tr>
                    <td></td>
                    <td>Fecha </td>
                </tr>
                <tr>
                    <td>Nombre RUT Firma</td>
                    <td></td>
                </tr>                
            </table>
        </td>
    </tr>    
</table>