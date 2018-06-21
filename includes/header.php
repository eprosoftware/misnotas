<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <?php
    include_once str_replace("/includes","",getcwd())."/cfgdir.php";
    ?>
<head>
<!-- Information generated and read by Xara Webstyle. Do not edit this line. [Calibrate (Theme);Default;Theme Color 1;10123616;themecolour1;Theme Color 2;32767;themecolour2;Background Color;16777215;themecolour3;Heading & Logo Text;3684408;themecolour6] -->
<!-- Template design (c) Xara Ltd 2003 -->
<title><?=$titulo_pag?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href='/favicon.ico' rel='shortcut icon' type='image/x-icon'>
<style>
/* ================================================================ 
Copyright (c) 2011 Stu Nicholls - iStu.co.uk. All rights reserved.
This stylesheet and the associated html may be modified in any 
way to fit your requirements.
=================================================================== */
.iStu4 ul {position:absolute;  margin:0; padding:0; list-style:none; white-space:nowrap; background:#5d7ea2; border:1px solid #fff; padding:10px 0; text-align:left;
-o-border-radius: 10px;
-ms-border-radius: 10px;
-moz-border-radius: 10px;
-webkit-border-radius: 10px;
border-radius: 10px;
-o-box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.5);
-ms-box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.5);
-moz-box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.5);
-webkit-box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.5);
box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.8);
}
.iStu4 ul ul {left:90%; margin-top:-36px; margin-left:5px;}
.iStu4 li {margin:0; padding:0; list-style:none; display:inline-block; display:inline;}
.iStu4 a {display:block; font:bold 14px arial,sans-serif; color:#fff; line-height:25px; text-decoration:none; padding:0 20px 0 10px;} 

.iStu4 li a.a-top {background:url('/images/index_hnavbar_l.gif') no-repeat right center;}
.iStu4 li a.a-sub {background:url('/images/index_hnavbar_l.gif') no-repeat right center;}

.iStu4 li.clicked > a {background-color:#8daed4;color:#ffffff;}

.iStu4 {padding:0; margin:0; list-style:none; text-align:left; position:relative; background:#5d7ea2; height:25px;}
.iStu4 > li > a {display:inline-block; margin-right:5px; height:25px;}
.iStu4 > li {position:relative; display:inline-block;}

.iStu4 > li {display:inline;}
.iStu4 > li > ul {top:25px; left:-1px;}

.iStu4 ul {display:none;}
</style>
<link rel="stylesheet" href="<?=$base_site?>/styles/styles.css" type="text/css" media="all" />
<!--<link rel="stylesheet" media="all" type="text/css" href="/styles/iStu3.css" />-->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?=$base_site?>/styles/bootstrap.min.css" >
<link rel="stylesheet" href="<?=$base_site?>/styles/bootstrap-theme.min.css">

<!-- SmartMenus core CSS (required) -->
<link href="/dist/css/sm-core-css.css" rel="stylesheet" type="text/css" />

<!-- "sm-blue" menu theme (optional, you can use your own CSS, too) -->
<link href="/dist/css/sm-blue/sm-blue.css" rel="stylesheet" type="text/css" />
<style>
  body { font-family: Arial; }
  html>body .ie_vert { display: none; }
  html>body .ff_vert { display: block; }
  .ie_vert, .ff_vert { height:80px; width: 25px; font-size: 20px; }

    a:link   
    {   
     text-decoration:none;   
    }   

</style>
<![if IE]>
<style>
  .ff_vert { display: none }
  .ie_vert { writing-mode: tb-rl; filter: flipv fliph; display: block;  }
</style>
<![endif]>
</head>

<script language="javascript" src="<?=$base_site?>/js/modernizr-custom.js"></script>


<!--<script language="JavaScript" src="/tigra/calendar_db.js"></script>
<link rel="stylesheet" href="/tigra/calendar.css"/>
-->

<script src="<?=$base_site?>/js/functions.js" type="text/javascript" language="javascript"></script>
<script src="<?=$base_site?>/js/libreria.js" type="text/javascript" language="javascript"></script>
<script src="<?=$base_site?>/js/calendar1.js" type="text/javascript" language="javascript"></script>

<script type="text/javascript" src="<?=$base_site?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?=$base_site?>/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=$base_site?>/js/stuHover.js"></script>    
<script type="text/javascript" src="<?=$base_site?>/js/iStu4.js"></script>


<script language="JavaScript">
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

</script>
<?php
	function logoHoy(){
		$hoy = date("m");

		switch($hoy){
			case 9: 	$ellogo="/index_files/index_logo_sep.gif";break;
			case 12:	$ellogo="/index_files/index_logo_navidad.gif";break;
			case 1:		$ellogo="/index_files/index_logo_verano.gif";break;
			case 2:		$ellogo="/index_files/index_logo_verano.gif";break;
			default:	$ellogo="/index_files/index_logo_orig.gif";break;
		}
		$ellogo="/images/logo_eprosoftCL.png";
		return $ellogo; 

	}
?>