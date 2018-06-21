<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<table>
    <tr>
        <td><?=$nombre_cliente?></td>
        <td><?=$email?></td>
    </tr>
    <tr><td colspan="2">Asunto</td></tr>
    <tr>
        <td colspan="2">
            <textarea roww="3" cols="60" name="asunto"></textarea>
        </td>
    </tr>
    <tr>
        <td colspan="2">Mensaje</td>
    </tr>
    <tr>
        <td colspan="2">
            <textarea roww="3" cols="60" name="mensaje"></textarea>
        </td>
    </tr>    
    
</table>