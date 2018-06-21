<?php
include_once '../class/session.php';
include_once '../class/config.php';
include_once 'header.php';

    
    $show = $_GET['show'];
    $c= $_GET['c'];
    $id = $_GET['id'];
    
    $idtipoproyecto=$_GET['idtipoproyecto'];
    $trabajo=$_GET['trabajo'];
    $monedadet=$_GET['monedadet'];
    $glosa=$_GET['glosa'];
    $fecha_glosa= $_GET['fecha_glosa'];
    $valor=$_GET['valor'];
    $anticipo= $_GET['anticipo'];
    $entrega=$_GET['entrega'];
    $aprobado= $_GET['aprobado'];
    $poranticipo=$_GET['poranticipo'];
    $porentrega=$_GET['porentrega'];
    $poraprobado=$_GET['poraprobado'];
    $trabajos_seleccionados=$_GET['trabajos_seleccionados'];
    
    $Aux = new DBCotizacion();
    $fecha_glosa = date("Y-m-d");

    $trabajos_seleccionados = $Aux->ElDato($id,"Cotizacion","id","tipotrabajos");
    $lostrabajos = $Aux->TraerLosDatos("TipoTrabajo","id","descripcion"," where find_in_set(id,'$trabajos_seleccionados')  order by descripcion");

    switch($c){
        case 1:
		$tmp=new ItemCotizacion();
		$tmp->setIdCotizacion($id);
                $tmp->setTipoTrabajo($trabajo);
                $idtipoproyecto=$Aux->ElDato($trabajo,"TipoTrabajo","id","idtipoproyecto");
                $tmp->setTipo($idtipoproyecto);
		
		$tmp->setGlosa($glosa);
		$tmp->setFecha($fecha_glosa);
		$tmp->setValor($valor);
		$tmp->setMoneda($monedadet);
		$tmp->setPagoAnticipo($poranticipo);
		$tmp->setPagoEntrega($porentrega);
		$tmp->setPagoAprobacion($poraprobado);
		$res=$Aux->addItem($tmp);
		$c=0;
                break;
    }
    $arraymonedas   = $Aux->TraerLosDatos("TipoMoneda","id","descripcion"," order by descripcion");
    $lostrabajos    = $Aux->TraerLosDatos("TipoTrabajo","id","descripcion");
?>

<?php if($id && $show==1){?>
<table width="100%" cellpadding="1" cellspacing="0">
<tr class="hnavbg">
	<td class="tituloblanco">Tipo Trabajo</td>
	<td class="tituloblanco">Glosa</td>
	<td class="tituloblanco">Fecha</td>
	<td class="tituloblanco|">Valor</td>
	<td class="tituloblanco">Moneda</td>
	<td class="tituloblanco">Anticipo</td>
	<td class="tituloblanco">Entrega</td>
	<td class="tituloblanco">Aprobado</td>
	<td><input type="text" size=3 name=total_por align="right" STYLE="color: #000000; font-family: Verdana; font-weight: bold; font-size: 12px; background-color: #a8bfdd;"></td>
</tr>
<tr>	
    <td><div id="trabajo_cotiza"><?=$Aux->SelectArray($lostrabajos,"trabajo","----",$trabajo,"","document.forms[0].valor.focus();document.forms[0].valor.select();");?></div></td>
	<td><input type="text" size=30 name=glosa value="<?=$glosa?>"  class="contenidonegro" onchange="this.value=this.value.toUpperCase();document.forms[0].poranticipo.focus();"></td>
	<td><input type="text" name="fecha_glosa" size=10 value="<?=$fecha_glosa?>" <?echo $lectura;?>  class="contenidonegro" >&nbsp;<a href="javascript:cal7.popup();"  class="contenidonegro"><img src="/images/cal.gif" width="16" height="16" border="0" alt="Haga  click para seleccionar una fecha"></a>&nbsp;<?=$fechatermino?>
	<script language="JavaScript">
		var cal7 = new calendar1(document.forms[0].elements['fecha_glosa']);
                cal7.year_scroll = false;
                cal7.time_comp = false;
	</script></td>
	<TD><input type="text" size=7 name=valor value="<?=$valor?>"  class="contenidonegro" onchange="document.forms[0].glosa.focus();"></TD>
	<td><?$Aux->SelectArray($arraymonedas,"monedadet","----",$monedadet)?></td>
	<td><input type="text" size=3 name=poranticipo value="<?=$poranticipo?>" onchange="actualiza_por();"  class="contenidonegro">&nbsp;%</td>
	<td><input type="text" size=3 name=porentrega  value="<?=$porentrega?>" onchange="actualiza_por();"  class="contenidonegro">&nbsp;%</td>
	<td><input type="text" size=3 name=poraprobado value="<?=$poraprobado?>" onchange="actualiza_por();"  class="contenidonegro">&nbsp;%</td>
	<td></td>
</tr>
<tr>
	<td colspan=4 ><a name=det></a>
	<input type="button" name=addDetalle value="Agregar Detalle" onclick="addValor(<?=$id?>,'<?=$idtipoproyecto?>',
                                                                                        f.trabajo.options[f.trabajo.selectedIndex].value,
                                                                                        f.glosa.value,
                                                                                        f.fecha_glosa.value,
                                                                                        f.valor.value,
                                                                                        f.monedadet.options[f.monedadet.selectedIndex].value,
                                                                                        f.anticipo.value,f.entrega.value,f.aprobado.value,
                                                                                        f.poranticipo.value,f.porentrega.value,f.poraprobado.value,
                                                                                        '<?=$trabajos_seleccionados?>')" class="titulonegro">
	</td>
        <td></td>
	<td><input type="text" size=5 name=anticipo ></td>
	<td><input type="text" size=5 name=entrega ></td>
	<td><input type="text" size=5 name=aprobado></td>
</tr>
</table>
<?php }?><br>
<?php
	$info=$Aux->getItem("",$id);
	if ($id>0){
?>
<table width="100%" cellpadding="1" cellspacing="1">
<tr class="hnavbg">
    <td colspan="8" class="titulonegro">Detalle Cotizaci&oacute;n <!--(<?=$trabajos_seleccionados?>)--></td>
    <td><a href="javascript:makerequest('/includes/showDetalleCot.php?show=1&id=<?=$id?>','detalle_cot')"><img src="/images/refresh.gif" border="0"/></td>
</tr>

<tr class="hnavbg">
	<td>Tipo Trabajo</td>
	<td>Glosa</td>
	<td>Fecha</td>
	<td align="right">Anticipo</td>
	<td align="right">Entrega</td>
	<td align="right">Aprobado</td>
       	<td align="right">Moneda</td>
       	<td align="right">Valor</td>
        <td>&nbsp;</td>
</tr>
	<?php
	$i=0;$total_anticipo= 0;$total_entregado= 0;$total_aprobado=0;
	while($tmp=$info[$i]){
		$iddet 	= $tmp->getId();
		$t 	= $tmp->getTipoTrabajo();
		$laglo	= $tmp->getGlosa();
		$v 	= $tmp->getValor();
		$m 	= $tmp->getMoneda();
		$pa 	= $tmp->getPorcentajeAnticipo();
		$pe 	= $tmp->getPorcentajeEntregado();
		$pap 	= $tmp->getPorcentajeAprobado();
		$va 	= $tmp->getAnticipo();
		$ve 	= $tmp->getEntregado();
		$vap 	= $tmp->getAprobado();
		$fec	= $tmp->getFecha();

		$lt	= $Aux->ElDato($t,"TipoTrabajo","id","descripcion");
		$lm	= $Aux->ElDato($m,"Moneda","id","descripcion");

		$bgcolor = $Aux->flipcolor($bgcolor);
		?>
<tr bgcolor="<?=$bgcolor?>">
	<td class="contenidonegro"><?=$lt?></td>
	<td class="contenidonegro"><?=$laglo?></td>
	<td class="contenidonegro" width="80"><?=$fec?></td>
        <td class="contenidonegro" align="right"><?=number_format($va,2,",",".")?>&nbsp;(<?=$pa?>&nbsp;%)</td>
	<td class="contenidonegro" align="right"><?=number_format($ve,2,",",".")?>&nbsp;(<?=$pe?>&nbsp;%)</td>
	<td class="contenidonegro" align="right"><?=number_format($vap,2,",",".")?>&nbsp;(<?=$pap?>&nbsp;%)</td>
        <td class="contenidonegro" align="right"><?=$lm?></td>
        <td class="contenidonegro" align="right"><?=$v?></td>
	<td><a href="javascript:eliminar_detalle(<?=$iddet?>);" 

               class="contenidonegro">
             <img src="/images/cross_off.gif" name="x<?=$iddet?>" border="0" alt="Eliminar"></a></td>
        <td><div id="salida<?=$iddet?>"></div></td>      
</tr>
<?php
		$i++;
		$total_anticipo+= $va;
		$total_entregado+= $ve;
		$total_aprobado+=$vap;
	}
	$total_cotizacion = $total_anticipo+$total_entregado+$total_aprobado;
?>
<input type="hidden" name=total value="<?=$total_cotizacion ?>">
<tr class="hnavbg">
	<td class="titulonegro" colspan="2">Total Cotizaci&oacute;n:</td>
	
	</td>
	<td></td>
	<td class="titulonegro12" align="right"><?=number_format($total_anticipo,2,",",".")?></td>
	<td class="titulonegro12" align="right"><?=number_format($total_entregado,2,",",".")?></td>
	<td class="titulonegro12" align="right"><?=number_format($total_aprobado,2,",",".")?></td>
        <td></td>
        <td class="titulonegro12" align="right"><?=number_format($total_cotizacion,2,",",".")?><input type="hidden" name=total value="<?=$total_cotizacion?>">
	<td class="titulonegro12" align="right" colspan="2"></td>
</tr>
</table>
        <?php }?>