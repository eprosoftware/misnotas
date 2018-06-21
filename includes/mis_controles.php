<?php

/* 
 * Página principal del sistema
 *  Fecha: 20 Abril 2014
 * @author Eduardo P. Román O.
 * Epro Software
 */
    //include_once DIR.'/class/session';
include_once str_replace("/includes","",getcwd()).'/cfgdir.php';
include_once str_replace("/includes","",getcwd()).'/class/session.php';
include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd()).'/includes/header.php';
    
    $Aux = new DBNotas();
    
    $dbuser = new DBUsuario();

    $lasasignaturas = $Aux->TraerLosDatos("Asignatura","id","descripcion");
    
    $id_user        = $dbuser->getUsuarioId($usuario,$clave);
    $eluser         = $dbuser->ElUsuario($id_user);
    $nombre_usuario = $eluser->getNombre();  
    $tipo_usuario   = $eluser->getTipoUsuario();
    
    $ax = $Aux->getControles("", $id_user);
    $lasnotas = $ax['salida'];
    $nrofilas = $ax['nrofilas'];
    
    //echo "<P>!--Tipo:$tipo_usuario ID_U:$id_user--</p>";
  
    ?>
<script>
function formato_numero(numero, decimales, separador_decimal, separador_miles){ // v2007-08-06
    numero=parseFloat(numero);
    if(isNaN(numero)){
        return "";
    }

    if(decimales!==undefined){
        // Redondeamos
        numero=numero.toFixed(decimales);
    }

    // Convertimos el punto en separador_decimal
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if(separador_miles){
        // Añadimos los separadores de miles
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }

    return numero;
}    
    function calculaNota(pos){
        var n=0;
        var suma=0;
        var n1 = document.getElementById("nota1_"+pos).value;
        var n2 = document.getElementById("nota2_"+pos).value;
        var n3 = document.getElementById("nota3_"+pos).value;
        var n4 = document.getElementById("nota4_"+pos).value;
        var n5 = document.getElementById("nota5_"+pos).value;
        var n6 = document.getElementById("nota6_"+pos).value;
        
        if(n1!="") {suma+=parseInt(n1);n++;}
        if(n2!="") {suma+=parseInt(n2);n++;}
        if(n3!="") {suma+=parseInt(n3);n++;}
        if(n4!="") {suma+=parseInt(n4);n++;}
        if(n5!="") {suma+=parseInt(n5);n++;}
        if(n6!="") {suma+=parseInt(n6);n++;}
        if(n>0){
            document.getElementById("notaF_"+pos).value =formato_numero(parseInt(suma) / parseInt(n), 2, ".", ",") ;
        } else {
            document.getElementById("notaF_"+pos).value = 0;
        }
        calculaNotaProm(pos);
    }
function calculaNotaProm(pos){
        var n=0;
        var suma=0;
        var n1 = document.getElementById("notaF_0").value;
        var n2 = document.getElementById("notaF_1").value;
        var n3 = document.getElementById("notaF_2").value;
        var n4 = document.getElementById("notaF_3").value;
        var n5 = document.getElementById("notaF_4").value;
        var n6 = document.getElementById("notaF_5").value;
        var n7 = document.getElementById("notaF_6").value;
        var n8 = document.getElementById("notaF_7").value;
        var n9 = document.getElementById("notaF_8").value;
        var n10 = document.getElementById("notaF_9").value;
        var n11 = document.getElementById("notaF_10").value;
        var n12 = document.getElementById("notaF_11").value;
        
        if(n1!="") {suma+=parseInt(n1);n++;}
        if(n2!="") {suma+=parseInt(n2);n++;}
        if(n3!="") {suma+=parseInt(n3);n++;}
        if(n4!="") {suma+=parseInt(n4);n++;}
        if(n5!="") {suma+=parseInt(n5);n++;}
        if(n6!="") {suma+=parseInt(n6);n++;}
        if(n7!="") {suma+=parseInt(n7);n++;}
        if(n8!="") {suma+=parseInt(n8);n++;}
        if(n9!="") {suma+=parseInt(n9);n++;}
        if(n10!="") {suma+=parseInt(n10);n++;}
        if(n11!="") {suma+=parseInt(n11);n++;}
        if(n12!="") {suma+=parseInt(n12);n++;}
        
        if(n>0){
            document.getElementById("notaFF").value = parseInt(suma) / parseInt(n);
        } else {
            document.getElementById("notaFF").value = 0;
        }
    }    
    function setNota(id,pos,valor){
        requestPage('/includes/setNotaControl.php?id='+id+"&pos="+pos+"&valor="+valor,'sal'+id);
    }
</script>
<a href="index.php" class="btn btn-primary">Mis Notas</a>
<form action="" method="POST" name="f">
<table class="table table-bordered table-hover table-striped table-condensed table-responsive">
    <thead>
    <th>Asignatura</th>
    <th>Nota 1</th>
    <th>Nota 2</th>
    <th>Nota 3</th>
    <th>Nota 4</th>
    <th>Nota 5</th>
    <th>Nota 6</th>
    <th>Nota F</th><th></th>
    </thead>
    <?php
    $promedio = 0;$nro_ramos=0;
    for($i=0;$i<count($lasnotas);$i++){
        $tmp = $lasnotas[$i];
        $nro_notas =0;$notaf=0;
        $id = $tmp['id'];
        $idasig = $tmp['id_asignatura'];
        $asig = $Aux->ElDato($idasig,"Asignatura","id","descripcion");
        $nota1 = ($tmp['nota1'])?$tmp['nota1']:"";
        $nota2 = ($tmp['nota2'])?$tmp['nota2']:"";
        $nota3 = ($tmp['nota3'])?$tmp['nota3']:"";
        $nota4 = ($tmp['nota4'])?$tmp['nota4']:"";
        $nota5 = ($tmp['nota5'])?$tmp['nota5']:"";
        $nota6 = ($tmp['nota6'])?$tmp['nota6']:"";
        
        if($nota1){$notaf+=$nota1;$nro_notas++;}
        if($nota2){$notaf+=$nota2;$nro_notas++;}
        if($nota3){$notaf+=$nota3;$nro_notas++;}
        if($nota4){$notaf+=$nota4;$nro_notas++;}
        if($nota5){$notaf+=$nota5;$nro_notas++;}
        if($nota6){$notaf+=$nota6;$nro_notas++;}
        if($nro_notas>0){
            $notaP = $notaf / $nro_notas;
        }
        
        if($notaP>0){$nro_ramos++; $promedio+=$notaP;}
        if($notaP<40){
            $colorP="color:darkred";
        }else{
            $colorP="color:darkblue";
        }
        //$tmp = $Aux->get("",$iduser);
       
        ?>
    <tr>
        <td><?=$asig?></td>
        <td><input type="number" name="nota1_<?=$i?>" id="nota1_<?=$i?>" value="<?=$nota1?>" class="form-control" onblur="calculaNota(<?=$i?>);setNota(<?=$id?>,1,this.value);"></td>
        <td><input type="number" name="nota2_<?=$i?>" id="nota2_<?=$i?>" value="<?=$nota2?>" class="form-control" onblur="calculaNota(<?=$i?>);setNota(<?=$id?>,2,this.value);"></td>
        <td><input type="number" name="nota3_<?=$i?>" id="nota3_<?=$i?>" value="<?=$nota3?>" class="form-control" onblur="calculaNota(<?=$i?>);setNota(<?=$id?>,3,this.value);"></td>
        <td><input type="number" name="nota4_<?=$i?>" id="nota4_<?=$i?>" value="<?=$nota4?>" class="form-control" onblur="calculaNota(<?=$i?>);setNota(<?=$id?>,4,this.value);"></td>
        <td><input type="number" name="nota5_<?=$i?>" id="nota5_<?=$i?>" value="<?=$nota5?>" class="form-control" onblur="calculaNota(<?=$i?>);setNota(<?=$id?>,5,this.value);"></td>
        <td><input type="number" name="nota6_<?=$i?>" id="nota6_<?=$i?>" value="<?=$nota6?>" class="form-control" onblur="calculaNota(<?=$i?>);setNota(<?=$id?>,6,this.value);"></td>
        <td><input type="number" style="<?=$colorP?>" disabled="" name="notaF_<?=$i?>" id="notaF_<?=$i?>" value="<?=$notaP?>" class="form-control" onblur="calculaNotaProm(<?=$i?>)"></td>
        <td><div id="sal<?=$id?>"></div></td>
    </tr>
    <?php
    }
    if($nro_ramos>0){
        $promedio_final = $promedio / $nro_ramos;
    } else {
        $promedio_final =0;
    }
    if($promedio_final<40){
        $color_promedio = "color:darkred;";
    } else {
        $color_promedio = "color:darkblue;";
    }
    ?>
    <tr>
        <td></td><td colspan="6" align="right">Promedio General:</td>
        <td colspan="2"><input style="font-size:24px;<?=$color_promedio?>" type="number" disabled="" name="notaFF" id="notaFF" class="form-control" value="<?=number_format($promedio_final,2,".",",")?>"></td>
    </tr>
</table>
</form>
    