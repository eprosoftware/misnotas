<?php
    session_start();
    if (! $_SESSION['is_logged']) {?>
<script>document.location="http://misnotas.xepro.net/login.php"</script>
    <?php }

    $usuario = $_SESSION['USUARIO'];
    $clave   = $_SESSION['CLAVE'];
?>

