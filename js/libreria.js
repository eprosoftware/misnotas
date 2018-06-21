var aWindow=null;

  var xmlhttp = false;
  try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
    }
  }
  if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
    xmlhttp = new XMLHttpRequest();
  }
function makerequest(serverPage, objID) {
    var obj = document.getElementById(objID);
    xmlhttp.open("GET", serverPage);
    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        obj.innerHTML = xmlhttp.responseText;
      }
    }
    xmlhttp.send(null);
  }
function requestPage(serverPage, objID) {

    
    
    var obj = document.getElementById(objID);

    obj.innerHTML = "<center><img src='/images/img_loading.gif' border=0></center>";

    xmlhttp.open("GET", serverPage);
    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        obj.innerHTML = xmlhttp.responseText;
      }
    }
    xmlhttp.send(null);
  }
function cargando(objID){
    var obj = document.getElementById(objID);
    obj.innerHTML = "<center><img src='/images/img_loading.gif' border='0'></center>" ;
}
function openWin(URL,width,height)
{
	w = screen.width/2;
	h = screen.height/2;
	t = 10;//h -(height/2);
	l = w -(width/2);
	if (aWindow == null)
	{
		aWindow=window.open(URL,"windows","width="+width+",height="+height+",resizable=yes,border=yes,scrollbars=auto, title=yes,top="+t+",left="+l+"");
	}
	else
	{
		if (!document.all && aWindow.closed)
			aWindow=window.open(URL,"windows","width="+width+",height="+height+",resizable=yes,border=yes,title=yes,scrollbars=1,top="+t+",left="+l+"");
		else
		{
			if (!document.all)
			{
				aWindow.focus();
				aWindow.location = URL
			}
			else
			{
				aWindow=window.open(URL,"windows","width="+width+",height="+height+",resizable=yes,border=yes,title=yes,scrollbars=auto,top="+t+",left="+l+"");
			}
		}
	}
}

function openWindow(URL,ventana,width,height)
{
	w = screen.width/2;
	h = screen.height/2;
	t = h -(height/2);
	l = w -(width/2);

	if (aWindow == null)
	{
		aWindow=window.open(URL,ventana,"width="+width+",height="+height+",resizable=yes,scrollbars=1, border=yes, title=yes,top="+t+",left="+l+" ");
	}
	else
	{
		if (!document.all && aWindow.closed)
			aWindow=window.open(URL,ventana,"width="+width+",height="+height+",resizable=yes,title=yes,border=yes,scrollbars=1,top="+t+",left="+l+"");
		else
		{
			if (!document.all)
			{
				aWindow.focus();
				aWindow.location = URL
			}
			else
			{
				aWindow=window.open(URL,ventana,"width="+width+",height="+height+",resizable=yes,title=yes,border=yes,scrollbars=1,top="+t+",left="+l+"");
			}
		}
	}
}

function blink (elId) {
        var html = '';
        if (document.all)
                html += 'var el = document.all.' + elId + ';';
        else if (document.getElementById)
                html += 'var el = document.getElementById("' + elId + '");';
        html += 'el.style.visibility = ' + 'el.style.visibility == "hidden" ? "visible" : "hidden"';
        if (document.all || document.getElementById)
                setInterval(html,500);
}

function MiSubmit(ruta)
{
    if(ruta)
    {
           document.forms[0].action = ruta;
           document.forms[0].submit();
    }
}

function checkRutField(rut,valor_campo)
{
	var tmpstr = "";
	for ( i=0; i < rut.length ; i++ )
		if ( rut.charAt(i) != ' ' && rut.charAt(i) != '.' && rut.charAt(i) != '-' )
			tmpstr = tmpstr + rut.charAt(i);
	rut = tmpstr;
	largo = rut.length;

	elrut = valor_campo.value;
	document.forms[0].rut.value = elrut.substring(0, largo - 1);
	document.forms[0].dig.value = elrut.charAt(largo-1);
// [VARM+]
	tmpstr = "";
	for ( i=0; rut.charAt(i) == '0' ; i++ );
		for (; i < rut.length ; i++ )
			tmpstr = tmpstr + rut.charAt(i);
	rut = tmpstr;
	largo = rut.length;
// [VARM-]
	if ( largo < 2 )
	{
		alert("Debe ingresar el rut completo.");
		valor_campo.focus();
		valor_campo.select();
		return false;
	}
	for (i=0; i < largo ; i++ )
	{
		if ( rut.charAt(i) != "0" && rut.charAt(i) != "1" && rut.charAt(i) !="2" && rut.charAt(i) != "3" && rut.charAt(i) != "4" && rut.charAt(i) !="5" && rut.charAt(i) != "6" && rut.charAt(i) != "7" && rut.charAt(i) !="8" && rut.charAt(i) != "9" && rut.charAt(i) !="k" && rut.charAt(i) != "K" )
		{
			alert("El valor ingresado no corresponde a un R.U.T valido.");
			
			valor_campo.select();
			valor_campo.focus();
			return false;
		}
	}
	var invertido = "";
	for ( i=(largo-1),j=0; i>=0; i--,j++ )
		invertido = invertido + rut.charAt(i);
	var drut = "";
	drut = drut + invertido.charAt(0);
	drut = drut + '-';
	cnt = 0;
	for ( i=1,j=2; i<largo; i++,j++ )
	{
		if ( cnt == 3 )
		{
			drut = drut + '.';
			j++;
			drut = drut + invertido.charAt(i);
			cnt = 1;
		}
		else
		{
			drut = drut + invertido.charAt(i);
			cnt++;
		}
	}
	invertido = "";
	for ( i=(drut.length-1),j=0; i>=0; i--,j++ )
		invertido = invertido + drut.charAt(i);
	valor_campo.value = invertido;
	if ( checkDV(rut,valor_campo) )
		return true;
	this.focus();
	return false;
}
function checkDV( crut ,valor_campo)
{
	largo = crut.length;
	if ( largo < 2 )
	{
		alert("Debe ingresar el rut completo.");
		valor_campo.focus();
		//valor_campo.select();
		return false;
	}
	if ( largo > 2 )
		rut = crut.substring(0, largo - 1);
	else
		rut = crut.charAt(0);
	dv = crut.charAt(largo-1);
	checkCDV( dv,valor_campo );
	if ( rut == null || dv == null )
		return 0;
	var dvr = '0';
	suma = 0;
	mul = 2;
	for (i= rut.length -1 ; i >= 0; i--)
	{
		suma = suma + rut.charAt(i) * mul;
		if (mul == 7)
			mul = 2;
		else
			mul++;
	}
	res = suma % 11;
	if (res==1)
		dvr = 'k';
	else if (res==0)
		dvr = '0';
	else
	{
		dvi = 11-res;
		dvr = dvi + "";
	}
	if ( dvr != dv.toLowerCase() )
	{
		alert("EL rut es incorrecto.");
		valor_campo.value = "";

		return false;
	}
	return true;
}
function checkCDV( dvr,valor_campo )
{
	dv = dvr + "";
	if ( dv != '0' && dv != '1' && dv != '2' && dv != '3' && dv != '4' && dv != '5' && dv != '6' && dv != '7' && dv != '8' && dv != '9' && dv != 'k'  && dv != 'K')
	{
		alert("Debe ingresar un digito verificador valido.");
		valor_campo.focus();
		valor_campo.select();
		return false;
	}
	return true;
}
function esDigito(sChr){
	var sCod = sChr.charCodeAt(0);
	return ((sCod > 47) && (sCod < 58));
}
function valSep(oTxt){
	var bOk = false;
	bOk = bOk || ((oTxt.value.charAt(2) == "-") && (oTxt.value.charAt(5) == "-"));
	bOk = bOk || ((oTxt.value.charAt(2) == "/") && (oTxt.value.charAt(5) == "/"));
	return bOk;
}
function finMes(oTxt){
	var nMes = parseInt(oTxt.value.substr(3, 2), 10);
	var nRes = 0;
	switch (nMes){
		case 1: nRes = 31; break;
		case 2: nRes = 29; break;
		case 3: nRes = 31; break;
		case 4: nRes = 30; break;
		case 5: nRes = 31; break;
		case 6: nRes = 30; break;
		case 7: nRes = 31; break;
		case 8: nRes = 31; break;
		case 9: nRes = 30; break;
		case 10: nRes = 31; break;
		case 11: nRes = 30; break;
		case 12: nRes = 31; break;
	}
	return nRes;
}
function valDia(oTxt){
	var bOk = false;
	var nDia = parseInt(oTxt.value.substr(0, 2), 10);
	bOk = bOk || ((nDia >= 1) && (nDia <= finMes(oTxt)));
	return bOk;
}
function valMes(oTxt){
	var bOk = false;
	var nMes = parseInt(oTxt.value.substr(3, 2), 10);
	bOk = bOk || ((nMes >= 1) && (nMes <= 12));
	return bOk;
}
function valAno(oTxt){
	var bOk = true;
	var nAno = oTxt.value.substr(6);
	bOk = bOk && ((nAno.length == 2) || (nAno.length == 4));
	if (bOk){
		for (var i = 0; i < nAno.length; i++){
			bOk = bOk && esDigito(nAno.charAt(i));
		}
	}
	return bOk;
}
function valFecha(oTxt){
	var bOk = true;
	if (oTxt.value != ""){
		bOk = bOk && (valAno(oTxt));
		bOk = bOk && (valMes(oTxt));
		bOk = bOk && (valDia(oTxt));
		bOk = bOk && (valSep(oTxt));
		if (!bOk){
			alert("Fecha inválida");
			oTxt.value = "";
			oTxt.focus();
		}
	}
}
function ValidarFecha(Cadena){
	var Fecha= new String(Cadena.value)	// Crea un string
	var RealFecha= new Date()	// Para sacar la fecha de hoy
	// Cadena Año
	var Ano= new String(Fecha.substring(0,Fecha.indexOf("-")))
	// Cadena Mes
	var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")))
	// Cadena Día
	var Dia= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length))

	// Valido el año
	if (isNaN(parseInt(Ano)) || Ano.length<4 || parseFloat(Ano)<1900){
        	alert('Invalid Year'+Ano);Cadena.focus();
		return false
	}
	// Valido el Mes
	if (isNaN(parseInt(Mes)) || parseFloat(Mes)<1 || parseFloat(Mes)>12){
		alert('Invalid Month');Cadena.focus();
		return false
	}
	// Valido el Dia
	if (isNaN(parseInt(Dia)) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){
		alert('Invalid Day');Cadena.focus();
		return false
	}
	if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {
		if (Mes==2 && Dia > 28 || Dia>30) {
			alert('Día inválido')
			return false
		}
	}
	
  //para que envie los datos, quitar las  2 lineas siguientes
  //alert("Fecha correcta.")
  return true;
}
function creaFecha(obj_aa,obj_mm,obj_dd,campo){
	var nRes=0;

	aa = obj_aa.value;
	mm = obj_mm.value;
	dd = obj_dd.value;
	lafecha = aa+"-"+mm+"-"+dd;

	switch(mm){
		case "1":  nRes = 31; break;
		case "2":  nRes = 29; break;
		case "3":  nRes = 31; break;
		case "4":  nRes = 30; break;
		case "5":  nRes = 31; break;
		case "6":  nRes = 30; break;
		case "7":  nRes = 31; break;
		case "8":  nRes = 31; break;
		case "9":  nRes = 30; break;
		case "10": nRes = 31; break;
		case "11": nRes = 30; break;
		case "12": nRes = 31; break;
	}

	if ( !EsNumerico(aa) ) { alert("Los valores deben ser numericos AA");obj_aa.focus();return false; }
	if ( !EsNumerico(mm) ) { alert("Los valores deben ser numericos MM");obj_mm.focus();return false; }
	if ( !EsNumerico(dd) ) { alert("Los valores deben ser numericos DD");obj_dd.focus();return false; }
	if ( aa<1900 )        { alert("El ano debe ser mayor que 1900 ");             obj_aa.focus(); return false; }
	if ( mm<0 || mm>12)   { alert("El valor del mes debe estar entre 1 y 12");    obj_mm.focus(); return false;}
	if ( dd<0 || dd>nRes) { alert("El valor del dia debe estar entre 1 y "+nRes); obj_dd.focus(); return false;}

	str_mm = (mm<10)?"0"+mm:mm;
	str_dd = (dd<10)?"0"+dd:dd;
	lafecha = aa+"-"+str_mm+"-"+str_dd;

	//alert("La Fecha "+lafecha);
	campo.value=lafecha;
	return true;
}
function EsNumerico(Dato){
	var CadenaNumeros;
	var EsteCaracter;
	var Contador;
	Contador=0;
	Dato = Dato.toString();
	CadenaNumeros="0123456789";
	for(i=0; i < Dato.length; i++){
		EsteCaracter = Dato.substring(i,i+1);file:///home/eroman/desa/sysgset/js/libreria.js
		if (CadenaNumeros.indexOf(EsteCaracter) !=-1)
			Contador++;
	}
	if (Contador == Dato.length)
		return true;
	else
		return false;
}
function SelectAll(CheckBoxControl)
{
	if (CheckBoxControl.checked == true)
	{
		var i;
		for (i=0; i < document.forms[0].elements.length; i++)
		{
			if ((document.forms[0].elements[i].type == 'checkbox') &&
			(document.forms[0].elements[i].name.indexOf('ids') > -1))
			{
				document.forms[0].elements[i].checked = true;
			}
		}
	}
	else
	{
		var i;
		for (i=0; i < document.forms[0].elements.length; i++)
		{
			if ((document.forms[0].elements[i].type == 'checkbox') &&
			(document.forms[0].elements[i].name.indexOf('ids') > -1))
			{
				document.forms[0].elements[i].checked = false;
			}
		}
	}
}
function toggleLayer( whichLayer )
{
	var elem, vis;
	if( document.getElementById ) // this is the way the standards work
		elem = document.getElementById( whichLayer );
	else if( document.all ) // this is the way old msie versions work
		elem = document.all[whichLayer];
	else if( document.layers ) // this is the way nn4 works
		elem = document.layers[whichLayer];
	vis = elem.style;
	// if the style.display value is blank we try to figure it out here
	if(vis.display=='' && elem.offsetWidth!=undefined && elem.offsetHeight!=undefined)
		vis.display = (elem.offsetWidth!=0 && elem.offsetHeight!=0)?'block':'none';
	vis.display = (vis.display=='' || vis.display=='block')?'none':'block';
}
function showRow(id){
    var fila; 

    if (!document.getElementById)  
        return false; 

    fila = document.getElementById(id); 

    if (fila.style.display != 'none'){ 
        fila.style.display = 'none'; //ocultar fila <br> 
    } else { 
        fila.style.display = ''; //mostrar fila <br> 
    } 

}
function checkLargo(objCampo,largo){
	if (objCampo.value.length > largo) { 
		alert('El largo del codigo excede al establecido, que correspode a '+largo+' caracteres.');
		objCampo.value=""; 
		return true;
	} else 
		return false;
	
}

function textoInclinado(){
    var canvas = document.getElementById('giro');
    if (navigator.userAgent.indexOf("Firefox") != -1){
        canvas.width = '180';
        canvas.height = '180';
        var ejemplo = canvas.getContext('2d');
        ejemplo.beginPath();
        ejemplo.moveTo(15,175);
        ejemplo.lineTo(175,15);
        ejemplo.stroke();
        ejemplo.fill();
        ejemplo.fillStyle = 'white';
        ejemplo.mozTextStyle = '30px arial';
        ejemplo.mozTextAlongPath('Foros del web.', false);
        ejemplo.restore();
    }
    else
        alert('Para Firefox.');
}

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


var keylist="abcdefghijklmnopqrstuvwxyz123456789"
var temp=''

function generatepass(plength){
temp=''
for (i=0;i<plength;i++)
temp+=keylist.charAt(Math.floor(Math.random()*keylist.length))
return temp
}

function formateaUsuario(elstr){
    var str = elstr.toLowerCase();
    var str =str.replace(" ","");
    return str;
}
function populateform(enterlength){
document.pgenerate.output.value=generatepass(enterlength)
}

function blinks(hide) {
    if (hide === 1) {
        $('.blink').show();
        hide = 0;
    }
    else {
        $('.blink').hide();
        hide = 1;
    }
    setTimeout("blinks("+hide+")", 400);
}

function MiSubmit(ruta)
{
        if(ruta)
        {
                document.forms[0].action = ruta;
                document.forms[0].submit();
        }
}
function MiSubmitCond(ruta)
{
	if (confirm("Esta completamente seguro?")){
        	if(ruta)
        	{
                	document.forms[0].action = ruta;
                	document.forms[0].submit();
        	}
	}
}

function Salir(){
	if(confirm("Desea salir del sistema?"))
		document.location="/login.php";
} 

function dontKey(evt)
{
            return false;
}
function genKey(numero_caracteres){
    var caracter="1234567890";
    caracter+="abcdefghijklmnopqrstxyz";


    var total=caracter.length;

    var clave="";
    for(a=0;a<numero_caracteres;a++){
    clave+=caracter.charAt(parseInt(total*Math.random(1)));
    }
    return clave;
}

function buscar_codigo(buscar){
    requestPage('/includes/buscar_codigo.php?campo=item&valor=&buscar='+buscar,'buscarCod');
}
function buscarCodigo(buscar){
    requestPage('/includes/buscar_cod.php?campo=item&valor=&buscar='+buscar,'item_div');
}
function actualiza_por(){
	valor    = f.valor.value*1;
	xanticipo= f.por_anticipo.value*1;
	xentrega = f.por_entrega.value*1;
	tmp = xanticipo+xentrega;
	xaprobado=100-tmp;
	f.por_aprobado.value=xaprobado;
	//xaprobado= formulario.poraprobado.value*1;

	valanticipo = (xanticipo/100)*valor;
	valentrega  = (xentrega/100)*valor;
	valaprobado = (xaprobado/100)*valor;

	if (xanticipo <0 || xanticipo>100){ alert("El % no puede superar el 100 o ser menor de 0");;return false;}
	if (xentrega  <0 || xentrega>100) { alert("El % no puede superar el 100 o ser menor de 0");;return false;}
	if (xaprobado <0 || xaprobado>100){ alert("El % no puede superar el 100 o ser menor de 0");;return false;}
	porcentaje = 100 - (xanticipo + xentrega+ xaprobado);
	
	if (porcentaje > 100 || porcentaje < 0) { alert("Esta sumando mas de 100 !!");return false;}
	f.total_por.value = porcentaje;
	/* f.anticipo.value = formato_numero(valanticipo,3,",",".");
	f.entrega.value = formato_numero(valentrega,3,",",".");
	f.aprobado.value =formato_numero(valaprobado,3,",","."); */
        
	f.anticipo.value = valanticipo;
	f.entrega.value  = valentrega;
	f.aprobado.value = valaprobado;
        
	return true;
}
function actualiza_por_new(n,indice){
	var valor    = document.getElementById("valor");
        var ptotal = 100;
        
        var p = document.getElementById("p"+indice);
        var v = document.getElementById("v"+indice);

        v.value = (p.value/100)*valor.value;
        
        var tot =0;
        for(i=0;i<n;i++){
            j=i+1;
            p = document.getElementById("p"+j);
            var vp = parseInt(p.value);
            
            if(isNaN(vp)){
                ;
            } else {
                tot = tot + parseInt(vp);    
            }
            
        }
        var t =document.getElementById("tot_por");
        t.value=100 - tot;

        /*
	xanticipo= f.por_anticipo.value*1;
	xentrega = f.por_entrega.value*1;
	tmp = xanticipo+xentrega;
	xaprobado=100-tmp;
	f.por_aprobado.value=xaprobado;
	//xaprobado= formulario.poraprobado.value*1;

	valanticipo = (xanticipo/100)*valor;
	valentrega  = (xentrega/100)*valor;
	valaprobado = (xaprobado/100)*valor;

	if (xanticipo <0 || xanticipo>100){ alert("El % no puede superar el 100 o ser menor de 0");;return false;}
	if (xentrega  <0 || xentrega>100) { alert("El % no puede superar el 100 o ser menor de 0");;return false;}
	if (xaprobado <0 || xaprobado>100){ alert("El % no puede superar el 100 o ser menor de 0");;return false;}
	porcentaje = 100 - (xanticipo + xentrega+ xaprobado);
	
	if (porcentaje > 100 || porcentaje < 0) { alert("Esta sumando mas de 100 !!");return false;}
	f.total_por.value = porcentaje;

        
	f.anticipo.value = valanticipo;
	f.entrega.value  = valentrega;
	f.aprobado.value = valaprobado;*/
        
	return true;
}

function nuevo_item(pd){
    nro = document.f.nro_cotizacion.value
    cod = document.f.codigo.value;
    item = document.f.str_item.value;
    m = document.f.tipo_moneda.options[document.f.tipo_moneda.selectedIndex].value;
    valor = document.f.valor.value;
    uf = document.f.valor_uf.value;
    //anti = document.f.anticipo.value;
    //entr = document.f.entrega.value;
    //apro = document.f.aprobado.value;
    nropagos = document.f.nro_pagos.value;
    var lospagos="";
    for(i=0;i<nropagos;i++){
        p = document.getElementById("p"+(i+1));
        lospagos += p.value+",";
    }
    
    if(confirm('Agrega Item ?')){
        //alert('/includes/addItem.php?nro='+nro+'&codigo='+cod+'&item='+item+'&moneda='+m+'&valor='+valor+'&nropagos='+nropagos+"&lospagos="+lospagos);
        makerequest('/includes/addItem.php?nro='+nro+'&codigo='+cod+'&item='+item+'&moneda='+m+'&valor='+valor+'&nropagos='+nropagos+"&lospagos="+lospagos,"salida_cotiza2");
        setTimeout(function() {requestPage('/includes/getItemCotizacion.php?ddel='+pd+'&nropagos='+nropagos+'&nro='+nro+'&lauf='+uf,'det_cotiza');},50);        
    }
}
function eliminar_det(x){
    makerequest("/includes/delItem.php?iddel="+x,"salida"+x);
}



function verificar(n){
    requestPage('/includes/verificar_nro_cotizacion.php?nro_cotizacion='+n,'msg');
    
    setTimeout(function(){makerequest('/includes/getItemCotizacion.php?nro='+document.f.nro_cotizacion.value,'det_cotiza');},100);
}
function eliminar_itemproy(nro,id){
    makerequest('/includes/eliminar_itemproy.php?id_item='+id,'salida_det'+id);
    setTimeout(function() {makerequest('/includes/getItemCotizacion.php?nro='+nro,'det_cotiza');},100);    
}
function filtrar_item_proy(){
    e = document.f.encargado.options[document.f.encargado.selectedIndex].value;
    o = document.f.orden.options[document.f.orden.selectedIndex].value;
    t = document.f.tipo_orden.options[document.f.tipo_orden.selectedIndex].value;
    p = document.f.por_cobrado.options[document.f.por_cobrado.selectedIndex].value;
    document.location='/index.php?p=listado_item_proyectos&encargado='+e+'&orden='+o+'&tipo_orden='+t+'&por_cobrado='+p;
}
function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

function reparo(nc,st){
    r = document.f.raz_reparo.value;

    requestPage('/includes/reparoCot.php?nrocot='+nc+'&anotacion='+st,'rep_div');
}   



function crear_cotiza(id_user){
    nro         = document.f.nro_cotizacion.value;
    nombre_proy = document.f.nombre_proyecto.value;
    e           = document.f.encargado.options[document.f.encargado.selectedIndex].value;
    valor       = document.f.valor_neto.value;
    uf          = document.f.valor_uf.value;
    us          = document.f.valor_us.value;
    c           = document.f.condiciones.value;
    rut         = document.f.vrut.value;
    rz          = document.f.razsoc.value;
    email       = document.f.email.value;
    fono        = document.f.fono.value;
    direccion   = document.f.direccion.value;
    com         = document.f.comuna.options[document.f.comuna.selectedIndex].value;
    np          = document.f.nro_pagos.options[document.f.nro_pagos.selectedIndex].value;
    td          = document.f.tipo_doc.options[document.f.tipo_doc.selectedIndex].value;
    tp          = document.f.tipo_proyecto.options[document.f.tipo_proyecto.selectedIndex].value;
    est         = document.f.estado.options[document.f.estado.selectedIndex].value;
    nd          = document.f.nro_dias_valido.value;

    requestPage('/includes/crear_cotiza.php?valor_uf='+uf+'&valor_us='+us+'&creadopor='+id_user+'&nro_cotizacion='+nro+'&nombre_proy='+nombre_proy+'&valor_total='+valor+'&encargado='+e+'&condiciones='+c+'&rut='+rut+'&razsoc='+rz+'&email='+email+'&fono='+fono+'&direccion='+direccion+'&comuna='+com+'&nropagos='+np+'&tipo_doc='+td+'&tipo_proyecto='+tp+'&nro_dias_valido='+nd+'&estado='+est ,'salida_cotiza');
}


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
        requestPage('/includes/setNota.php?id='+id+"&pos="+pos+"&valor="+valor,'sal'+id);
    }
