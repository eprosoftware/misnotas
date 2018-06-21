<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EproSoftware EIRL | Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg" onload="f.usuario.focus();">

    <div class="loginColumns animated fadeInDown">
        <div class="row vertical-align">

            <div class="col-md-6">
                <img src="/images/logo_eprosoftCL.png" bordee="0" width="360">
                <h2 class="font-bold">Cotiza/Proyectos</h2>
                

            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    <form class="m-t" role="form" action="valida.php" method="POST" name="f">
                        <div class="form-group">
                            <input name="usuario" type="text" class="form-control" placeholder="Username" required="">
                        </div>
                        <div class="form-group">
                            <input name="clave" type="password" class="form-control" placeholder="Password" required="">
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                        <a href="javascript:alert('Sorry, Contacta al adminsitrador !!')">
                            <small>Olvidaste tu Clave ?</small>
                        </a>

                    </form>

                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Copyright EproSoftware EIRL
            </div>
            <div class="col-md-6 text-right">
               <small>© 2017</small>
            </div>
        </div>
    </div>

</body>

</html>