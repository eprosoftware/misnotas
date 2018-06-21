<?php
include_once str_replace("/includes","",getcwd()).'/cfgdir.php';

include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd())."/includes/header.php";

$Aux    = new DBUsuario();

$usr    = $_POST['usr'];
$passwd = $_POST['passwd'];
$id     = $_GET['id'];

echo "<p>ID:$id USR: $usr PWD: $passwd</p>";

if(!$passwd)
	$paswd = $Aux->makePass();
$i=0;
if($usr)
{
    $nombre = $_POST['nombre'];
    $alias  = $_POST['alias'];
    
    $email      = $_POST['email'];
    $fono       = $_POST['fono'];
    $celular    = $_POST['celular'];
    $cumpleanos = $_POST['cumpleano'];
    $nivel      = $_POST['nivel'];
    $menu       = $_POST['a_menu'];
    $submenu    = $_POST['submenu'];
    $rut        = $_POST['rut'];
    $tipoU      = $_POST['tipo_usuario'];
    $jefe       = $_POST['jefe'];
    $permisos   = $_POST['permisos'];
    
    $tmp = new Usuario();
    $tmp->setId($id);
    $tmp->setRut($rut);
    $tmp->setNombre($nombre);
    $tmp->setAlias($alias);
    $tmp->setUsuario($usr);
    $tmp->setClave($passwd);
    $tmp->setEmail($email);
    $tmp->setFono($fono);
    $tmp->setCelular($celular);
    $tmp->setFechaCumpleanos($cumpleanos);
    $tmp->setJefe($jefe);
    $tmp->setPermisos(implode(",",$permisos));
    
    $tmp->setMenu(implode(",",$menu));         
    $tmp->setSubMenu(implode(",",$submenu));   
                

    $tmp->setTipoUsuario($tipoU);
            // primero verificar que el usuario no exista
    if ($id){
        $tmp->setId($id);
        $msg = $Aux->ModUsuario($tmp);
    } else{
        $msg = $Aux->AddUsuario($tmp);
    }
    echo "<p>MSG:$msg</p>";
    if ($notificar=="on" && false){
            $Aux->NotificarClave($tmp);
    }
}

?>

