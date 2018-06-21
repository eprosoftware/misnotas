<?php

/* 
 * Obtiene indicadires economicos del día en curso
 * Autor: Eduardo P. Román O.
 * Fecha: 16 Marzo 2014
 */
    include_once str_replace("/includes","",getcwd()).'/class/session.php';
    include_once str_replace("/includes","",getcwd()).'/class/config.php';
    
    $m = new DBMenu();
    $u = new DBUsuario();

    $id_user    = $u->getUsuarioId($usuario,$clave);
    $eluser 	= $u->ElUsuario($id_user);
    $menu_usr 	= $eluser->getMenu();//asort($menu_usr);
    $submenu_usr    = $eluser->getSubMenu();//asort($submenu_usr);
    $nombre_usuario = $eluser->getNombre();

    
    $ip= $_SERVER['REMOTE_ADDR'];
    $apiUrl = 'https://mindicador.cl/api';
    if ( ini_get('allow_url_fopen') ) {
        $json = file_get_contents($apiUrl);
    } else {
        //De otra forma utilizamos cURL
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);
    }

    $dailyIndicators = json_decode($json);

?>
<div class="panel panel-primary">
    <div class="panel-heading">Indicadores Econ&oacute;micos</div>
    <div class="panel-body">
<table class="table table-bordered table-striped">
    <tr>
        <td>Dolar Obs</td>
        <td>Euro</td>
        <td>UF HOY</td>
        <td>UTM</td>
        <td>IPC</td>
        <td>IMACEC</td>
    </tr>
    <tr>
        <td align="right"><?=$dailyIndicators->dolar->valor?></td>
        <td align="right"><?=$dailyIndicators->euro->valor?></td>
        <td align="right"><?=$dailyIndicators->uf->valor?></td>
        <td align="right"><?=$dailyIndicators->utm->valor?></td>
        <td align="right"><?=$dailyIndicators->ipc->valor?></td>
        <td align="right"><?=$dailyIndicators->imacec->valor?></td>
    </tr>    
    <tr>
        <td colspan="5"><b>Usuario Conectado:<?="$usuario ($nombre_usuario)"?></b>&nbsp;</td>
        <td><b>IP:</b><?=$ip?>&nbsp;</td>
    </tr>
</table>        
    </div>
</div>


        

