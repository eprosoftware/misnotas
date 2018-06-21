<?php
//***********************************************************//
//Clase DBNucleo                                          //
//***********************************************************//
class DBNucleo extends Conexion
{
        // Constructor
        function DBVNucleo(){
		$this->conecta_pdo();
        }

	//funcion que retorna un numero random
	//basado en la funcion microtime
	//tiene un largo de 17 caracteres
	function ticks()
	{
        	$tiempo = microtime();
	        $tiempo = str_replace("0.","",$tiempo);
		$aux = split(" ",$tiempo);
		$stick = $aux[1].$aux[0];
		return $stick;
	}

	// Busca un id de un record por el campo insert_ticks
	// Si no encuentra id retorna -1
	function buscaIdPorTicks($ticks,$tabla)
	{
            $sql = "SELECT id FROM $tabla WHERE insertticks='$ticks'";
            $result=mysql_query($sql);
            if ($view_campo = mysql_fetch_array($result))
            {
                    return $view_campo[id];
            }
            else
            {
                    return -1;
            }
	}
	
	// Busca un campo de un record por el campo Estampilla
	// Si no encuentra  retorna -1
	function buscaPorEstampilla($ticks,$campo,$tabla)
	{
            $sql = "SELECT $campo FROM $tabla WHERE Estampilla='$ticks'";
	    echo "<!-- $sql -->";
	    $result=mysql_query($sql);
            if ($view_campo = mysql_fetch_array($result))
            {
                    return $view_campo[$campo];
            }
            else
            {
                    return -1;
            }
	}

	// funciones comodines...
        //*****************************************************//
        //funciones extras
        //*****************************************************//
        function TraerLosDatos($tabla,$campo1,$campo2, $sqlextra="")
        {
		$this->conecta_pdo();
                $salida = array();
                $sql = "SELECT $campo1,$campo2 from $tabla ";
		if($sqlextra)
			$sql.= $sqlextra;
		//echo "<!--TraerLosDatos: $sql -->";
		$aCampo = explode(" ",$campo2);
		if (count($aCampo)>1) $campo2 = $aCampo[1];

                $res = $this->query_pdo($sql);
                if($res)
                {
                    foreach ($res as $row)
                        {
				$tmp=array();
                                $tmp["id"]          = $row[$campo1];
                                $tmp["valor"]     = $row[$campo1];
                                $tmp["nombre"] = $row[$campo2];
                                $tmp["txt"]	= $row[$campo2];
                                $salida[] = $tmp;
                        }
                }
                return $salida;
        }
/*
        function TraerLosDatos($tabla,$campo1,$campo2, $sqlextra="")
        {
                $salida = array();
                $this->conecta();
                $sql = "SELECT * from $tabla";
		if($sqlextra)
			$sql.= $sqlextra;

		echo "<!--$sql-->";
                $res = mysql_query($sql);
                if($res)
                {
                        while($row = mysql_fetch_array($res))
                        {
                                $tmp["id"] = $row["$campo1"];
                                $tmp["valor"] = $row["$campo1"];
                                $tmp["nombre"] = $row["$campo2"];
                                $tmp["txt"] = $row["$campo2"];
                                $salida[] = $tmp;
                        }
                }
                return $salida;
        }
*/
        function TraerElDato($id,$tabla,$campo1,$campo2)
        {
		$tmp = array();
                $sql = "SELECT * from $tabla WHERE $campo1=$id";
                $res = mysql_query($sql);
                if($res)
                {
                        if($row = mysql_fetch_array($res))
                        {
                                $tmp["id"] = $row["$campo1"];
                                $tmp["valor"] = $row["$campo1"];
                                $tmp["nombre"] = $row["$campo2"];
                                $tmp["txt"] = $row["$campo2"];
                        }
                }
                return $tmp;
       }
	function ElDato($id,$tabla,$campo1,$campo2,$sqlext=""){
                $this->conecta_pdo();
		$tmp = array();
                $sql = "SELECT $campo1,$campo2 from $tabla WHERE $campo1='$id'";
		if ($sqlext) $sql.=" and $sqlext";
		//echo "<p>ElDato SQL:$sql</p>";
                $res = $this->query_pdo($sql);
                if($res)
                {
                    foreach ($res as $row )
                        {
                                $tmp["id"] = $row["$campo1"];
                                $tmp["valor"] = $row["$campo1"];
                                $tmp["nombre"] = $row["$campo2"];
                                $tmp["txt"] = $row["$campo2"];
                        }
                }
                return $tmp["txt"];
	}
       
        // funcion que envia mail
        // la variable $html indica si el mensaje es html o no... (obvio!!)
        function XSendMail($to,$nombrefrom,$from,$subject,$message,$html="")
        {
                $headers.= "MIME-Version: 1.0\r\n";
                if($html=="1")
                {
                        $headers.= "Content-type: text/html; charset=iso-8859-1\r\n";
                }
                $headers.= "From: ".$nombrefrom."<".$from.">\r\n";
                $headers.= "Reply-To: \r\n";
                $headers.= "X-Priority: 1\r\n";
                $headers.= "X-MSMail-Priority: High\r\n";
                $headers .= "X-Mailer: localhost";
                if(!mail($to, $subject, $message, $headers))
                {
                       $msg = "El Mail No se pudo enviar";
                       return -1;
                }
                $msg = "Enviando Mail a $to\n";
                return $msg;
       }
	// funcion que genera un select con los datos de un arreglo!!
	// el arreglo es un arreglo de arreglo asociativos!!!
	function SelectArray($tmp, $nombre, $msg="", $default="", $valormsg="", $js="",$onblur="",$disabled="")
	{
		$elselect = "<select name='$nombre' id='$nombre' class='form-control' $disabled ";

		
		if ($js) $elselect.= " onchange=\"$js\"  ";
		if ($onblur) $elselect.= " onblur=\"$onblur\" ";
		$elselect.=">\n";

		if($msg)
		{
			if($valormsg=="")
				$elselect.= "<option value='0'>$msg</option>\n";
			else
				$elselect.="<option value='$valormsg'>$msg</option>\n";
		}
		for($i=0;$i<count($tmp);$i++)
		{
			$datos = $tmp[$i];
			$valor = $datos["valor"];
			$txt = $datos["txt"];
			$txt = $this->CortarString($txt,50);
			if($valor == $default)
				$elselect.="<option value='$valor' selected>$txt</option>\n";
			else
				$elselect.="<option value='$valor'>$txt</option>\n";
		}
		$elselect.= "</select>\n";
		echo $elselect;
	}
	function SelectArrayBig($tmp, $nombre, $msg="", $default="", $valormsg="", $js="",$disabled="")
	{
		if($js)
			echo "<select style='font-size:20px' id='$nombre' name='$nombre' onchange=\"$js\" class='contenidonegro' $disabled>\n";
		else
			echo "<select style='font-size:20px' id='$nombre' name='$nombre' class='contenidonegro' $disabled>\n";

		if($msg)
		{
			if($valormsg=="")
				echo "<option value='0'>$msg</option>\n";
			else
				echo "<option value='$valormsg'>$msg</option>\n";
		}
		for($i=0;$i<count($tmp);$i++)
		{
			$datos = $tmp[$i];
			$valor = $datos["valor"];
			$txt = utf8_encode($datos["txt"]);
			$txt = substr($txt,0,50);
			if($valor == $default)
				echo "<option value='$valor' selected>$txt</option>\n";
			else
				echo "<option value='$valor'>$txt</option>\n";
		}
		echo "</select>\n";
	}
        
	function getTipoProyecto($tipo=""){
		$sql="select * from TipoProyecto where id>0";
                if ($tipo) $sql.=" and idtipoproyecto in ($tipo) ";
                $sql.= " order by descripcion";
		echo "<!--$sql-->";
		$rs = mysql_query($sql);
		if($rs){
			$salida=array();
			while($row=mysql_fetch_array($rs)){
			$tmp = array();
			$tmp[ID] = $row[id];
			$tmp[DESCRIPCION] = $row[descripcion];
			$salida[]=$tmp;
			}
			return $salida;
		} else
			return mysql_error();
	}
        function getTipoTrabajo($tipo=""){
		$sql="select * from TipoTrabajo where id>0 ";
                if  ($tipo) $sql.=" and idtipoproyecto in ($tipo) ";
                $sql.= " order by idtipoproyecto,descripcion ";
		//echo "<p>!--$sql--</p>";
		$rs = mysql_query($sql);
		if($rs){
			$salida=array();
			while($row=mysql_fetch_array($rs)){
                            $salida[]=$row;
			}
			return $salida;
		} else
			return mysql_error();
	}
        function flipcolor($c,$estilo=""){
                switch($estilo){
                case 1:$color = ($c == "#f8f8f8")?"ccf4d4":"#f8f8f8";break;
		case 2:$color = ($c == "#f8f8f8")?"c8c8c8":"#f8f8f8";break;
		default: $color = ($c == "#d3d3d3")?"#F2F2F2":"#d3d3d3";break;
                }
                return $color;
        }
        function flipcolor2($c){
                $color  = ($c == "#ffff99")?"#ffffcc":"#ffff99";
                return $color;
        }

	function PaginadorOld($url,$lapag,$nropag,$primero,$limite){
		if ($nropag==0) $nropag=1;
		$sig = $primero - $limite;
		$pag_sig = $lapag -1;
		if ($sig< 0){ $pag_sig = $nropag; $sig= $limite * ($nropag-1); }
		$url_anterior="$url&primero=$sig&lapag=$pag_sig&limite=$limite";
?>
<a href="<?=$url_anterior?>#inicio_tabla" class="titulonegro">Ant.&nbsp;<img src="/images/ar_prev.gif" border=0></a>
<?php
		for($i=0;$i<$nropag;$i++){
			$p = $i + 1;
			$pag = $limite * $i;
			if ($p==$lapag) $pag_mark="<font color='red'>$p</font>"; 
			else $pag_mark="&nbsp;$p&nbsp;";
?>
 <a href="<?="$url&primero=$pag&lapag=$p"?>" class='contenidonegro'><?="$pag_mark"?></a>
<?php
		}
		$sig = $primero + $limite -1;
		$pag_sig = $lapag +1;
		if ($pag_sig > $nropag ){ $pag_sig = 1; $sig=0; }
		$url_siguiente="$url&primero=$sig&lapag=$pag_sig&limite=$limite&filtra_recursos=$filtra_recursos";
?>
<a href="<?=$url_siguiente?>#inicio_tabla" class="titulonegro"><img src="/images/ar_next.gif" border=0>&nbsp;Sig.</a>
<?php
   	}
/*
	function round_up($value){
		list($val,$dummy) = explode(".",$value);
		return $dummy?$val+1:$val;
	}
*/
	function Paginador($url,$seccion,$lapag,$nropag,$primero,$limite,$inicio="",$pag_show="",$prefix=""){
            if (!$inicio) $inicio=0;
		$primero=($primero==0)?1:$primero;
		if ($nropag > $pag_show) $xnext = $pag_show; else $xnext = $nropag;

		if ($primero-$limite>=0){
			$l_lapag = $lapag-1;
			$lprimero =$primero-$limite;
			$linicio = (($lapag-1) == $inicio)?($inicio-$pag_show):$inicio;
		} else {
			$lprimero = $limite*($nropag-1);
			$linicio = $nropag -$xnext;
			$l_lapag = $nropag;
		}
		$url_prev ="$url&primero$prefix=$lprimero&lapag$prefix=$l_lapag&limite$prefix=$limite&inicio$prefix=$linicio&pag_show$prefix=$pag_show";
		$url_primero="$url&primero$prefix=0&lapag$prefix=1&limite$prefix=$limite&inicio$prefix=0&pag_show$prefix=$pag_show";
		if($nropag>1){
?>
<nav aria-label="Page navigation">
  <ul class="pagination">
          <li>
      <a href="javascript:toggleLayer('wait_bar');requestPage('<?=$url_prev?>','<?=$seccion?>');" aria-label="Previous">
        <span aria-hidden="true">Anterior</span>
      </a>
    </li>
<?php
		for($i=$inicio; $i < ($inicio+$xnext);$i++){
			$p = $i+1;
			$pag = $limite * $i;
			if ($p==$lapag)
				$pag_mark="<b>&#171; $p &#187;</b>";
			else
				$pag_mark="&nbsp;$p&nbsp;";
?>
        <li><a href="javascript:toggleLayer('wait_bar');requestPage('<?="$url&primero$prefix=$pag&limite$prefix=$limite&lapag$prefix=$p&inicio$prefix=$inicio"?>','<?=$seccion?>');"><?="$pag_mark"?></a></li>
<?php
		} //Fin for para escribir paginas
		$sig = ($limite*$i)+1;
		$pag_sig = $i+1;
		if ($pag_sig > $nropag ){ $pag_sig = 1; $sig=0; }
		$rinicio=$inicio;
		$inicio=$pag_sig-1;
		$xprimero = $limite*($nropag-1);
		$xinicio = $nropag -$xnext;
		$rprimero = $primero+$limite-1;
		$psig=$lapag+1;
                if ($psig > $nropag || $lapag>$nropag){ $pag_sig=1;$psig=1;$primero=0;$inicio=0;$rprimero=0;$rinicio=0;}
                if (($lapag % $pag_show)==0)
                        $url_next = "$url&primero$prefix=$sig&lapag$prefix=$pag_sig&limite$prefix=$limite&inicio$prefix=$inicio&pag_show$prefix=$pag_show";
                else
                        $url_next = "$url&primero$prefix=$rprimero&lapag$prefix=$psig&limite$prefix=$limite&inicio$prefix=$rinicio&pag_show$prefix=$pag_show";

                $url_siguiente="$url&primero$prefix=$sig&lapag$prefix=$pag_sig&limite$prefix=$limite&inicio$prefix=$inicio&pag_show$prefix=$pag_show";
                $url_ultimo="$url&primero$prefix=$xprimero&lapag$prefix=$nropag&limite$prefix=$limite&inicio$prefix=$xinicio&pag_show$prefix=$pag_show";

		if ($nropag > 10) $inicio = $pag_sig;
?>
    <li>
      <a href="javascript:toggleLayer('wait_bar');requestPage('<?=$url_next?>','<?=$seccion?>');" aria-label="Next">
        <span aria-hidden="true">Siguiente</span>
      </a>
    </li>
  </ul>
</nav> <div id="wait_bar" style="display:none"><img src="/images/bar_wait.gif" border="0"></div>

<?php
		}


   	}	



	function round_up($value){
		list($val,$dummy) = explode(".",$value);
		return $dummy?$val+1:$val;
	}

	function CortarString($str, $largo)
	{
                $salida = $str;
                if(strlen($str)>$largo)
                        $salida = substr($str,0,$largo) . "...";
                return $salida;
        }
//	function RescatarNros($id="",$proy=""){
//		switch($proy){
//		case 1: $tabla="NroProyMR";break;
//		case 2: $tabla="NroProyPV";break;
//		default:
//			$tabla="NroCotizacion";break;
//		}
//		$sql = "update $tabla set ocupado=0";
//		if ($id) $sql.= " where numero in ($id)";
//		$rs=mysql_query($sql);
//		//echo "<p>$sql</p>";
//		if ($rs)
//			return true;
//		else
//			return mysql_error();
//	}
	function RescatarNros($id="",$proy=""){
		$sql= "update NroProy set ocupado=0";
		if ($id) $sql.= " where numero in ($id)";

		$rs=mysql_query($sql);

		if ($rs)
			return true;
		else
			return mysql_error();		
	}
	function NrosPerdidos(){
		$sql = "select a.*,b.nroproyecto from NroProy a left join Cotizaciones b on a.numero=b.nroproyecto where b.nroproyecto is null";
		$rs = mysql_query($sql);
		if ($rs){
			$salida=array();
			while($row=mysql_fetch_array($rs)){
				$tmp=array();
				$tmp[numero]=$row[numero];
				$tmp[ocupado]=$row[ocupado];
				$tmp[nroproyecto]=$row[nroproyecto];
				$salida[]=$tmp;
			}
			return $salida;
		}
			
	}
	function LiberaNro($id){
		$sql="delete from NroProy where numero=$id";
		$rs = mysql_query($sql);
	}
	function rowEffect($i,$color,$click="",$pointer=""){
		$over  = " onmouseover=\"setPointer(this, 0, 'over', '$color', '#CCFFCC', '#FFCC99');\"";
		$out   = " onmouseout=\"setPointer(this, 0, 'out', '$color', '#CCFFCC', '#FFCC99');\"";
		$row = "$over $out";
		$extra ="";
		if ($click)   $extra.= "$click;";
		if ($pointer) $extra.= "setPointer(this, $i, 'click', '$color', '#CCFFCC', '#FFCC99');";
		
		if ($click || $pointer)
			$row.= " onClick=\"$extra\"";
		return $row;
	}
	function deleteEffect($id_del,$id,$url="",$js=""){
		if (!$js) $js="eliminar";
		
		$html = "<a href=\"javascript:if(confirm('Esta seguro?')) $js('$id_del','$url')\" onmouseover=\"x$id.src='/images/cross_on.gif'\"      onmouseout=\"x$id.src='/images/cross_off.gif'\"><img src=\"/images/cross_off.gif\" name=\"x$id\" border=\"0\"></a>";
		return $html;
	}
	function CargaFechas($file){
		$sql = "delete from tmp_fechas;";$rs = mysql_query($sql);
		$sql="load data infile '$file' into table tmp_fechas fields terminated by ';' ignore 1 lines";
		echo "<p>$SQL</p>";
		$rs = mysql_query($sql);
		$sql ="update Proyecto a,tmp_fechas b set a.fecha_certif=b.fecha where a.nroproyecto=b.nroproyecto";
		echo "<p>$SQL</p>";
		$rs = mysql_query($sql);
	}
	function Ocultar($seccion,$campo_foco="",$img_on="",$img_off="",$texto="",$titulo="",$laclase=""){
		if (!$img_on) { $img_on = "arrow_down.gif";$img_off="arrow.gif"; }
		$tag = "<a href=\"javascript: toggleLayer('$seccion');";
		if ($campo_foco) $tag.=" document.forms[0].$campo_foco.focus();";
		$tag.=" \" onmouseover=\"flecha_$seccion.src='/images/$img_on'\" onmouseout=\"flecha_$seccion.src='/images/$img_off'\" ";
                if ($laclase) $tag.=" class='$laclase'>"; else $tag.= " class='contenidonegro'>";
		if ($texto) $tag.=$texto;
		$st = ($titulo)?"title='$titulo'":"";
		$tag.="<img src=\"/images/$img_off\" name=flecha_$seccion border=\"0\" $st></a>";
		return $tag;
	}
	function FechaFmt($fecha,$lenguaje="",$fmt=""){
		//echo "<!--Fecha:$fecha-->";
		if ($fecha){

			$parte = explode(" ",$fecha);
                        $xfecha = $parte[0];
                        $lahora = $parte[1];
                        $xfecha = explode("-",$parte[0]);
			$f = $xfecha[0]."-".$xfecha[1]."-".$xfecha[2];
			$dia = strftime("%u",strtotime($f));
			$dd= strftime("%d",strtotime($f));
			$anno= substr($xfecha[0],-4);
			$hora = $lahora;
			switch($xfecha[1]){
				case 1:  $mes[1]="Ene";$mes[2]="Jan";break;
				case 2:  $mes[1]="Feb";$mes[2]="Feb";break;
				case 3:  $mes[1]="Mar";$mes[2]="Mar";break;
				case 4:  $mes[1]="Abr";$mes[2]="Apr";break;
				case 5:  $mes[1]="May";$mes[2]="May";break;
				case 6:  $mes[1]="Jun";$mes[2]="Jun";break;
				case 7:  $mes[1]="Jul";$mes[2]="Jul";break;
				case 8:  $mes[1]="Ago";$mes[2]="Aug";break;
				case 9:  $mes[1]="Sep";$mes[2]="Sep";break;
				case 10: $mes[1]="Oct";$mes[2]="Oct";break;
				case 11: $mes[1]="Nov";$mes[2]="Nov";break;
				case 12: $mes[1]="Dic";$mes[2]="Dec";break;
			}
			switch($dia){
				case 1: $eldia[1]="Lun";$eldia[2]="Mon";break;
				case 2: $eldia[1]="Mar";$eldia[2]="Tue";break;
				case 3: $eldia[1]="Mi&eacute;";$eldia[2]="Wed";break;
				case 4: $eldia[1]="Jue";$eldia[2]="Thu";break;
				case 5: $eldia[1]="Vie";$eldia[2]="Fri";break;
				case 6: $eldia[1]="S&aacute;b";$eldia[2]="Sat";break;
				case 7: $eldia[1]="Dom";$eldia[2]="Sun";break;
			}
                        $f_fmt = "$eldia[$lenguaje] $dd, $mes[$lenguaje] $hora";
                        switch($fmt){
                            case 1:
                                $f_fmt = "$eldia[$lenguaje] $dd, $mes[$lenguaje] $anno ($hora)";
                                break;
                            default:
                                $f_fmt = "$eldia[$lenguaje] $dd, $mes[$lenguaje]";
                                break;
                        }
			return $f_fmt;
		} else return "----";
	}
	function fmtFecha($fecha){

		$now = date("Y-m-d");
		$xnow = explode("-",$now);$y_now=$xnow[0];//year now

		$xfecha = explode("-",$fecha);
		$lafecha ="$xfecha[2] $xfecha[1]";
		if ($xfecha[0]!=$y_now) $lafecha .=" $xfecha[0]";
		return ($fecha)?$lafecha:"---";
	}
	function ElMes($id){
		switch($id){
			case 1:$mes="Enero";break;
			case 2:$mes="Febrero";break;
			case 3:$mes="Marzo";break;
			case 4:$mes="Abril";break;
			case 5:$mes="Mayo";break;
			case 6:$mes="Junio";break;
			case 7:$mes="Julio";break;
			case 8:$mes="Agosto";break;
			case 9:$mes="Septiembre";break;
			case 10:$mes="Octubre";break;
			case 11:$mes="Noviembre";break;
			case 12:$mes="Diciembre";break;
		}
		return $mes;
	}
	function valor($x){return ($x)?$x:"<span class='titulorojo'><center>- N/D -</center></span>";}
	function numerotexto ($numero) { 
	// Primero tomamos el numero y le quitamos los caracteres especiales y extras 
	// Dejando solamente el punto "." que separa los decimales 
	// Si encuentra mas de un punto, devuelve error. 
	// NOTA: Para los paises en que el punto y la coma se usan de forma 
	// inversa, solo hay que cambiar la coma por punto en el array de "extras" 
	// y el punto por coma en el explode de $partes 
	
	$extras= array("/[\$]/","/ /","/,/","/-/"); 
	$limpio=preg_replace($extras,"",$numero); 
	$partes=explode(".",$limpio); 
	if (count($partes)>2) { 
		return "Error, el n&uacute;mero no es correcto"; 
		exit(); 
	} 
	
	// Ahora explotamos la parte del numero en elementos de un array que 
	// llamaremos $digitos, y contamos los grupos de tres digitos 
	// resultantes 
	
	$digitos_piezas=chunk_split ($partes[0],1,"#"); 
	$digitos_piezas=substr($digitos_piezas,0,strlen($digitos_piezas)-1); 
	$digitos=explode("#",$digitos_piezas); 
	$todos=count($digitos); 
	$grupos=ceil (count($digitos)/3); 
	
	// comenzamos a dar formato a cada grupo 
	
	$unidad = array   ('un','dos','tres','cuatro','cinco','seis','siete'  ,'ocho','nueve'); 
	$decenas = array ('diez','once','doce', 'trece','catorce','quince'); 
	$decena = array   ('dieci','veinti','treinta','cuarenta','cincuenta'  ,'sesenta','setenta','ochenta','noventa'); 
	$centena = array   ('ciento','doscientos','trescientos','cuatrociento  s','quinientos','seiscientos','setecientos','ochoc  ientos','novecientos'); 
	$resto=$todos; 
	
	for ($i=1; $i<=$grupos; $i++) { 
		
		// Hacemos el grupo 
		if ($resto>=3) { 
		$corte=3; } else { 
		$corte=$resto; 
		} 
		$offset=(($i*3)-3)+$corte; 
		$offset=$offset*(-1); 
		
		// la siguiente seccion es una adaptacion de la contribucion de cofyman y JavierB 
		
		$num=implode("",array_slice ($digitos,$offset,$corte)); 
		$resultado[$i] = ""; 
		$cen = (int) ($num / 100);              //Cifra de las centenas 
		$doble = $num - ($cen*100);             //Cifras de las decenas y unidades 
		$dec = (int)($num / 10) - ($cen*10);    //Cifra de las decenas 
		$uni = $num - ($dec*10) - ($cen*100);   //Cifra de las unidades 
		if ($cen > 0) { 
		if ($num == 100) $resultado[$i] = "cien"; 
		else $resultado[$i] = $centena[$cen-1].' '; 
		}//end if 
		if ($doble>0) { 
		if ($doble == 20) { 
		$resultado[$i] .= " veinte"; 
		}elseif (($doble < 16) and ($doble>9)) { 
		$resultado[$i] .= $decenas[$doble-10]; 
		}else { 
		$resultado[$i] .=' '. $decena[$dec-1]; 
		}//end if 
		if ($dec>2 and $uni<>0) $resultado[$i] .=' y '; 
		if (($uni>0) and ($doble>15) or ($dec==0)) { 
		if ($i==1 && $uni == 1) $resultado[$i].="uno"; 
		elseif ($i==2 && $num == 1) $resultado[$i].=""; 
		else $resultado[$i].=$unidad[$uni-1]; 
		} 
		} 
	
		// Le agregamos la terminacion del grupo 
		switch ($i) { 
		case 2: 
		$resultado[$i].= ($resultado[$i]=="") ? "" : " mil "; 
		break; 
		case 3: 
		$resultado[$i].= ($num==1) ? " mill&oacute;n " : " millones "; 
		break; 
		} 
		$resto-=$corte; 
	} 
	
	// Sacamos el resultado (primero invertimos el array) 
	$resultado_inv= array_reverse($resultado, TRUE); 
	$final=""; 
	foreach ($resultado_inv as $parte){ 
		$final.=$parte; 
	} 
	$final[0]=strtoupper($final[0]);
	return $final; 
	} 

	function getDiaAbr($i){
		switch($i){
			case 1:$dia="Lun";break;
			case 2:$dia="Mar";break;
			case 3:$dia="Mie";break;
			case 4:$dia="Jur";break;
			case 5:$dia="Vie";break;
			case 6:$dia="Sab";break;
			case 7:$dia="Dom";break;
		}
		return $dia;
	}
	function getUltimoDiaMes($i){
		$mes[1] = 31;
		$mes[2] = (strftime("%Y",strtotime(date("Y-m-d")))%4==0)?29:28;
		$mes[3] = 31;
		$mes[4] = 30;
		$mes[5] = 31;
		$mes[6] = 30;
		$mes[7] = 31;
		$mes[8] = 31;
		$mes[9] = 30;
		$mes[10] = 31;
		$mes[11] = 30;
		$mes[12] = 31;
		return $mes[$i];
	}
        	function getMes($i){
		switch($i){
			case 1:$mes="Enero";break;
			case 2:$mes="Febrero";break;
			case 3:$mes="Marzo";break;
			case 4:$mes="Abril";break;
			case 5:$mes="Mayo";break;
			case 6:$mes="Junio";break;
			case 7:$mes="Julio";break;
			case 8:$mes="Agosto";break;
			case 9:$mes="Septiembre";break;
			case 10:$mes="Octubre";break;
			case 11:$mes="Noviembre";break;
			case 12:$mes="Diciembre";break;
		}
		return $mes;
	}
	function getDia($i){
		switch($i){
			case 1:$dia="LUN";break;
			case 2:$dia="MAR";break;
			case 3:$dia="MI&Eacute;";break;
			case 4:$dia="JUE";break;
			case 5:$dia="VIE";break;
			case 6:$dia="S&Aacute;B";break;
			case 7:$dia="DOM";break;
		}
		return $dia;
	}

	function getFeriado($fecha,$tipo){
		$this->conecta();
		$sql = "select count(*)from Feriados where fecha='$fecha' and tipo=$tipo";
		//echo "<p>SQL:$sql</p>";
		$rs = $this->query($sql);
		if ($rs){
			$row = $this->getRows($rs);
			return $row[0];
		} else return 0;

	}
	function EsHabil($fecha,$tipo_feriado=""){
		$tipoDia = $this->getTipoDia($fecha);
		if ($tipoDia!=6 && $tipoDia!=7){
			if ($tipo_feriado==2){
				if ($this->getFeriado($fecha,1)==0) return true;
				else return false;
			}
			if ($this->getFeriado($fecha,1)==0) return true;
			else return false;
		} else return false;
	}
	function getTipoDia($fecha){
		return strftime("%u",strtotime($fecha));
	}
	function getDiffDate($fecha1,$fecha2){
		$sql = "select datediff('$fecha1','$fecha2')";
                //echo "<p>SQL: $sql </p>";
		$rs = $this->query($sql);
		if ($rs){
			$row = $this->getRows($rs);
			return $row[0];
		}
	}
	function getDiffTime($fecha1,$fecha2){
		$sql = "select timediff('$fecha1','$fecha2')";
                
		$rs = $this->query($sql);
		if ($rs){
			$row = $this->getRows($rs);
			return $row[0];
		}
	}
	function getAddFecha($fecha,$dias){
		$sql = "select date_add('$fecha',interval $dias day)";
		//echo "<p>SQL: $sql </p>";
		$rs=$this->query($sql);
		if ($rs){
			$row = $this->getRows($rs);
			return $row[0];
		}
	}

	function getSubFecha($fecha,$dias){
		$sql = "select date_sub('$fecha',interval $dias day)";
		//echo "<p>SQL: $sql </p>";
		$rs=$this->query($sql);
		if ($rs){
			$row = $this->getRows($rs);
			return $row[0];
		}
	}

	function diasHabiles($fecha){
		$hoy = date('Y-m-d');
		$obs = $this->getAddFecha($fecha,1);

		$fecha_next = $this->diaHabilSiguiente($obs);
		//echo "<p>Fecha Hoy:$hoy Fecha Next:$fecha_next</p>";
		$dias = $this->getDiffDate($fecha_next,$hoy);
		//echo "<p>Dias:$dias</p>";
		return  $dias;
	}
	function diaHabilSiguiente($fecha){//Fixing CHILE
		$next = $this->getAddFecha($fecha,1);
		$tipoDia = $this->getTipoDia($next);

		$feriado_nac = $this->getFeriado($next,1);
			//echo "<p>FN:$feriado_nac FU:$feriado_usa</p>";
		//while ($feriado_nac>0||$feriado_usa>0||$tipoDia==6 || $tipoDia==7){
		while ($feriado_nac>0||$tipoDia==6 || $tipoDia==7){
			switch($tipoDia){
			case 6://Sabado
				$next = $this->getAddFecha($next,2);
				break;
			case 7://Domingo
				$next = $this->getAddFecha($next,1);
				break;
			default:
				$next = $this->getAddFecha($next,1);
				break;
			}
			//echo "<p>NEXT:$next</p>";
			$tipoDia = $this->getTipoDia($next);
			$feriado_nac = $this->getFeriado($next,1);
			}

		return $next;
	}
	function diaHabilSiguiente2($fecha){//Tomando en cuenta Feriados USA
		$next = $this->getAddFecha($fecha,1);
		$tipoDia = $this->getTipoDia($next);

		$feriado_nac = $this->getFeriado($next,1);
		$feriado_usa = $this->getFeriado($next,2);
		//echo "<p>FN:$feriado_nac FU:$feriado_usa</p>";
		//while ($feriado_nac>0||$feriado_usa>0||$tipoDia==6 || $tipoDia==7){
		while ($feriado_nac>0||$feriado_usa>0 || $tipoDia==6 || $tipoDia==7){
			switch($tipoDia){
			case 6://Sabado
				$next = $this->getAddFecha($next,2);
				break;
			case 7://Domingo
				$next = $this->getAddFecha($next,1);
				break;
			default:
				$next = $this->getAddFecha($next,1);
				break;
			}
			//echo "<p>NEXT:$next</p>";
			$tipoDia = $this->getTipoDia($next);
			$feriado_nac = $this->getFeriado($next,1);
			$feriado_usa = $this->getFeriado($next,2);
		}

		return $next;
	}
	function diaHabilAnterior($fecha){
		$next = $this->getSubFecha($fecha,1);
		$tipoDia = $this->getTipoDia($next);

		while (($tipoDia==6 || $tipoDia==7)||$this->getFeriado($next,1)||$this->getFeriado($next,2)){
			switch($tipoDia){
			case 6://Sabado
				$next = $this->getSubFecha($next,1);
				break;
			case 7://Domingo
				$next = $this->getSubFecha($next,2);
				break;
			default:
				$next = $this->getSubFecha($next,1);
				break;
			}

			$tipoDia = $this->getTipoDia($next);
		}
		return $next;
	}
	function getDias($fecha,$fecha_hoy,$fin_mes=""){
		$obs_date 	= $this->diaHabilSiguiente($fecha);//Dia habil siguiente
		$dia_obs  	= strftime("%d",strtotime($obs_date));

		if (($this->getFeriado($obs_date,1)>0) && $dia_obs==$fin_mes){ //Si es Feriado y es Fin de mes
		//Dia Habil Siguiente
			$obs_date = $this->diaHabilSiguiente($fecha);//$this->getAddFecha($fecha,1);
			$obs_date_normal = $this->diaHabilSiguiente($fecha);
			$settle_date = $this->diaHabilSiguiente2($obs_date_normal);
		} else {
			$obs_date = $this->diaHabilSiguiente($fecha);
			if ($this->getFeriado($settle_date,2)>0 ) $settle_date=$settle_date = $this->diaHabilSiguiente($settle_date);
			$settle_date = $this->diaHabilSiguiente2($obs_date);
		}

		//$nrodays = $this->getDiffDate($obs_date,$fecha_hoy);
		$nrodays = $this->getDiffDate($fecha,$fecha_hoy);

		$tmp=array();
		$tmp['fixing']	= $fecha;
		$tmp['obs']	= $obs_date;
		$tmp['settle']	= $settle_date;
		$tmp['dias']	= $nrodays;
		return $tmp;
	}
        function textOneCol($label){
            $st = "";
            for($i=0;$i<strlen($label);$i++)
                $st.=$label[$i]."<br>";

            return $st;
        }
        function getArraySinEspacios($a){
            $tmp = array();
            for($i=0;$i<count($a);$i++)
                if($a[$i]) $tmp[]=$a[$i];
            return array_unique($tmp);
        }
        function RemoveValArray($valor,$a){
            $tmp = array();
            for($i=0;$i<count($a);$i++){
                //echo "<p>$a[$i]==$valor</p>";
                if($a[$i]!=$valor) $tmp[]=$a[$i];
            }
            return array_unique($tmp);
        }
        function getSt($x){ return ($x)?$x:"";}
        function getN($x) { return ($x)?$x:0; }
        function dateDiff($start, $end) { 
            $start_ts = strtotime($start); 
            $end_ts = strtotime($end); 
            $diff = $end_ts - $start_ts; 
            return round($diff / 86400); 
        }
       
        function normalizar_acentos($string){
            $str = strtoupper(utf8_encode($string));
            $str = str_replace("'"," ",$str);
            $str = str_replace("Í","i",$str);
            $str = str_replace("Á","a",$str);
            $str = str_replace("É","e",$str);
            $str = str_replace("I","i",$str);
            $str = str_replace("Ó","o",$str);
            $str = str_replace("Ú","u",$str);
            
            $str = str_replace("Ñ","N",$str);
            
            //$string = strtr($string, "áéíóú", "aeiou");
            return $str;
      }        
    function convertir_especiales_html($str){
        if (!isset($GLOBALS["carateres_latinos"])){
           $todas = get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES);
           $etiquetas = get_html_translation_table(HTML_SPECIALCHARS, ENT_NOQUOTES);
           $GLOBALS["carateres_latinos"] = array_diff($todas, $etiquetas);
        }
        $str = strtr($str, $GLOBALS["carateres_latinos"]);
        return $str;
     }      
    function cleanHTMLChar($s) {
        $s = str_replace("á","&aacute;",$s);
        $s = str_replace("é","&eacute;",$s);
        $s = str_replace("í","&iacute;",$s);
        $s = str_replace("ó","&oacute;",$s);
        $s = str_replace("ú","&uacute;",$s);
        $s = str_replace("Á","&Aacute;",$s);
        $s = str_replace("É","&Eacute;",$s);
        $s = str_replace("Í","&Iacute;",$s);
        $s = str_replace("Ó","&Oacute;",$s);
        $s = str_replace("Ú","&Uacute;",$s);        
	return $s;
    }     
}
?>
