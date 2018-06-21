
<script type="text/javascript">
var numero = 0; //Esta es una variable de control para mantener nombres
            //diferentes de cada campo creado dinamicamente.
evento = function (evt) { //esta funcion nos devuelve el tipo de evento disparado
   return (!evt) ? event : evt;
}

//Aqui se hace lamagia... jejeje, esta funcion crea dinamicamente los nuevos campos file
addCampo = function () { 
//Creamos un nuevo div para que contenga el nuevo campo
   nDiv = document.createElement('div');
//con esto se establece la clase de la div
   nDiv.className = 'archivo';
//este es el id de la div, aqui la utilidad de la variable numero
//nos permite darle un id unico
   nDiv.id = 'file' + (++numero);
//creamos el input para el formulario:
   nCampo = document.createElement('input');
   nCampoD = document.createElement('input');
//le damos un nombre, es importante que lo nombren como vector, pues todos los campos
//compartiran el nombre en un arreglo, asi es mas facil procesar posteriormente con php
   nCampo.name = 'archivos[]';
   nCampoD.name = 'descripcion[]';
//Establecemos el tipo de campo
   nCampo.type = 'file';
   nCampoD.type = 'text';
//Ahora creamos un link para poder eliminar un campo que ya no deseemos
   a = document.createElement('a');
//El link debe tener el mismo nombre de la div padre, para efectos de localizarla y eliminarla
   a.name = nDiv.id;
//Este link no debe ir a ningun lado
   a.href = '#';
//Establecemos que dispare esta funcion en click
   a.onclick = elimCamp;
//Con esto ponemos el texto del link
   a.innerHTML = 'Eliminar';
//Bien es el momento de integrar lo que hemos creado al documento,
//primero usamos la función appendChild para adicionar el campo file nuevo
   nDiv.appendChild(nCampo);
   nDiv.appendChild(nCampoD);
//Adicionamos el Link
   nDiv.appendChild(a);
//Ahora si recuerdan, en el html hay una div cuyo id es 'adjuntos', bien
//con esta función obtenemos una referencia a ella para usar de nuevo appendChild
//y adicionar la div que hemos creado, la cual contiene el campo file con su link de eliminación:
   container = document.getElementById('adjuntos');
   container.appendChild(nDiv);
}
//con esta función eliminamos el campo cuyo link de eliminación sea presionado
elimCamp = function (evt){
   evt = evento(evt);
   nCampo = rObj(evt);
   div = document.getElementById(nCampo.name);
   div.parentNode.removeChild(div);
}
//con esta función recuperamos una instancia del objeto que disparo el evento
rObj = function (evt) { 
   return evt.srcElement ?  evt.srcElement : evt.target;
}
</script>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    include_once("class/session.php");
    include_once("class/config.php");
    include_once("header.php");
    
    $Aux = new DBInmueble();
    $a = new FotoInventario();
    $u = new DBUsuario();
    
    $iduser         = $_GET['iduser'];
    $id_inmueble    = $_GET['id_inmueble'];
    
    $id_inventario  = ($_GET['id_inventario'])?$_GET['id_inventario']:$_POST['id_inventario'];
    $id_user        = $u->getUsuarioId($usuario,$clave);
    $descripcion    = $_POST['descripcion'];
    $tipo_archivo   = $_POST['tipo_archivo'];
    $archivo        = $_POST['archivo'];
    $comando        = $_POST['comando'];
    $tipo_foto_inventario = $_POST['tipo_foto_inventario'];
    $temp = $_GET['temp'];
    
    $temporal       = ($temp)?$temp:$_POST['temporal'];
    
    //echo "<p>TEMP:[$temp] TEMPORAL: [$temporal] IDUSER: $id_user IDCARPETA: $id_carpeta</p>";
    if($comando==1){
        
        if (isset ($_FILES["archivos"])) {
            //de se asi, para procesar los archivos subidos al servidor solo debemos recorrerlo
            //obtenemos la cantidad de elementos que tiene el arreglo archivos
            $tot = count($_FILES["archivos"]["name"]);
            //este for recorre el arreglo
            for ($i = 0; $i < $tot; $i++){
            //con el indice $i, poemos obtener la propiedad que desemos de cada archivo
            //para trabajar con este
                $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
                $name = $_FILES["archivos"]["name"][$i];
                echo("<b>Archivo </b> $key ");
                echo("<br />");
                echo("<b>el nombre original:</b> ");
                echo($name);
                echo("<br />");
                echo("<b>el nombre temporal:</b> \n");
                echo($tmp_name);
                echo("<br />"); 

                $iduser         = $_POST['iduser'];
                $id_carpeta     = $_POST['id_carpeta'];   

                $estampa = $Aux->ticks();

                $ruta = "file".$estampa.".".$extension;
                $dir_usuario = "user_".substr("00000$id_user",-4);
                $dir= "../store/$dir_usuario/".$ruta;

                //$eldir = "/home/ruzstore/store/$dir_usuario/"; 
                $eldir  = "/home/eroman/desa/sysarriendos/lib_fotoinventario/"; 

                if (is_uploaded_file($_FILES['archivos']['tmp_name'][$i]))  
                    { 

                    $imgFile = $_FILES['archivos']['name'][$i] ; 
                    $imgFile = str_replace(' ','_',$imgFile); 
                    $tmp_name = $_FILES['archivos']['tmp_name'][$i]; 

                    $tipoarchivo = $_FILES['archivos']['type'][$i];  

                    if (!((strpos($tipoarchivo,"gif")|| 
                        strpos($tipoarchivo,"jpeg")|| 
                        strpos($tipoarchivo,"jpg")|| 
                        strpos($tipoarchivo,"png")||
                        strpos($tipoarchivo,"pdf")|| 
                        strpos($tipoarchivo,"msword")|| 
                        strpos($tipoarchivo,"mp3")|| 
                        strpos($tipoarchivo,"mp4")||                            
                        strpos($tipoarchivo,"ppt")|| 
                        strpos($tipoarchivo,"xls")|| 
                        strpos($tipoarchivo,"jar")||
                        strpos($tipoarchivo,"xls")||
                        strpos($tipoarchivo,"ppt")||
                        strpos($tipoarchivo,"avi")||
                        strpos($tipoarchivo,"txt")) )){  
                        echo "Lo sentimos,no puede subir este tipo de archivo $tipoarchivo."; 
                    }else{ 
                        if(move_uploaded_file($tmp_name, $eldir.$estampa."_".$imgFile)) 
                        { 

                        echo "Se Guardo correctamente sus archivos que ingreso son: <br>"; 
                        echo "Nombre:".$_FILES['archivos']['name'][$i]."<br>"; 
                        echo "Tipo Archivo: <i>".$_FILES['archivos']['type'][$i]."</i><br>"; 
                        echo "Peso: <i>".$_FILES['archivos']['size'][$i]." bytes</i><br>"; 

                            } 
                        } 
                } 

                $file = new FotoInventario();
                $file->setNombreArchivo($_FILES['archivos']['name'][$i]);
                $file->setArchivo($estampa."_".$_FILES['archivos']['name'][$i]);
                $file->setIdInventario($id_inventario);
                $file->setIdInmueble($id_inmueble);
                $file->setFechaCreacion(date("Y-m-d H:i:s"));
                $file->setDescripcion($descripcion[$i]);

                //if (!$tipo_archivo){
                //    $ext = $Aux->extFile($_FILES['archivos']['name'][$i]);
                //    $tipo_archivo = $Aux->ElDato($ext,"TipoArchivo","descripcion","id");
                //}
                $file->setTipoArchivo($tipo_foto_inventario[$i]);
                $Aux->addFotoInventario($file);
            }
        }
        ?><script>
            window.opener.location = window.opener.location;;
            setTimeout(function(){self.close();},100);
        </script><?php
    }
    $lostiposfotos = $Aux->TraerLosDatos("TipoFotoInventario", "id", "descripcion");
?>
        <body onload="document.f.archivo.focus();">
<form action="/includes/upload_file.php?iduser=<?=$iduser?>" method="POST" name="f"  enctype="multipart/form-data">
<input type="hidden" name="comando">
<input type="hidden" name="temporal" value="<?=$temporal?>">
<input type="hidden" name="id_inventario" value="<?=$id_inventario?>">
<input type="hidden" name="iduser" value="<?=$iduser?>">

    <table width="100%">
        <tr class="hnavbg">
            <td colspan="2" class="tituloblanco12"><h2>Archivos a Subir:</h2></td>
        </tr>
            <tr>
    </tr>
        <tr>
            <td colspan="2">
        <!-- Esta div contendrá todos los campos file que creemos -->
            <div id="adjuntos">
                    <!-- Hay que prestar atención a esto, el nombre de este campo debe siempre terminar en []
                    como un vector, y ademas debe coincidir con el nombre que se da a los campos nuevos 
                    en el script -->
            <?=$Aux->SelectArrayBig($lostiposfotos,"tipo_foto_inventario[]","Seleccione Tipo de Foto",$tipo_foto_inventario)?>        
                    <input type="file" name="archivos[]" />&nbsp;<br>
            Observaciones:        
            <textarea cols="40" rows="3" name="descripcion[]"  onblur="this.value = this.value.toUpperCase();"></textarea>

            </div>
        
   

            </td>
        </tr>

    <tr>
        <td colspan="2">
            <input type="submit" value="Enviar" id="envia" name="envia" onClick="document.f.comando.value=1;"/>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h2>No cierre la ventana mientras se esta realizando la subida del archivo.</h2>
        </td>
    </tr>
</table>



</form>
        </body>