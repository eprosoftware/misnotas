<?php
include_once getcwd().'/class/session.php';
include_once getcwd().'/class/config.php';
    
    $m = new DBMenu();
    $u = new DBUsuario();
    $user = $u->ElUsuario($id_user);
?>
<table width="100%">
    <tr>
        <td><?php if(!$w) $m->genCSSMenu($id_user,$menu_usr,$submenu_usr)?></td>
    </tr>
</table>
