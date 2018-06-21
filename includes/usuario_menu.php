<?php
include_once str_replace("/includes","",getcwd()).'/cfgdir.php';

include_once str_replace("/includes","",getcwd()).'/class/config.php';
include_once str_replace("/includes","",getcwd())."/includes/header.php";

	$Aux1 = new DBMenu();
	$Aux2 = new DBSubMenu();
        
        $idusr = $_GET['idusr'];
        $idgrp = $_GET['idgrp'];

	if ($idgrp){//Copian menu desde Grupo idgrp
		$menu = $Aux1->ElDato($idgrp,"TipoUsuario","id","menu");
		$submenu = $Aux1->ElDato($idgrp,"TipoUsuario","id","submenu");
	}

	$losusuarios = $Aux1->TraerLosDatos("Usuarios","id","upper(nombre)"," order by nombre");
	$losgrupos = $Aux1->TraerLosDatos("TipoUsuario","id","descripcion"," order by descripcion");

	$elmenu = $Aux1->ElMenu();
	$xmenu = explode(",",$menu);
?>
	<table class="table table-bordered table-striped table-hover">
	<tr>
	<?php
	for ($i=0;$i<count($elmenu);$i++){
		$idmenu = $elmenu[$i]->getId();
		$check = "";
		$j=0;
		$check="";
		while($elmenu[$j]){
			if ($idmenu==$xmenu[$j])
				$check="checked";
			$j++;
		}
	?><td class="titulonegro"><?= utf8_decode($elmenu[$i]->getDescripcion())?><input type="checkbox" <?=$check?> name=a_menu[] value="<?=$elmenu[$i]->getId();?>"></td>
        <?php
	}
	?>
	</tr>
	<tr bgcolor="#FFFFFF" valign="top">
	<?php
	
	for ($i=0;$i<count($elmenu);$i++){
		$idmenu = $elmenu[$i]->getId();
		//$check = ($idmenu==$xmenu[$i])?"checked":"";
	?><td>
	<table class="table table-bordered table-striped table-hover">
	<?php
	$lossubmenus = $Aux1->LosSubMenus($idmenu," 0","3,2");
	$xsubmenu = explode(",",$submenu);
	for($j=0;$j<count($lossubmenus);$j++){
		$tmp = $lossubmenus[$j];
		$descripcion = utf8_decode($tmp->getDescripcion());
		$tipo = $tmp->getTipo();
		$idsubmenu=$tmp->getId();
		$k=0;
		$check="";
		while($xsubmenu[$k]){
			if ($idsubmenu==$xsubmenu[$k]) $check="checked";
			$k++;
		}
		$lasopciones = $Aux1->LosSubMenus($idmenu,$idsubmenu,"2");
?>
	<tr><td align="left"><input type='checkbox' name=submenu[] <?=$check?> value='<?=$idsubmenu?>'><?=$descripcion?></td></tr>
        <?php if(count($lasopciones)>0){?>
	<tr>
            <td align="left">
                            <table class="table table-bordered table-striped table-hover">
<?php		//Las opciones del SubMenu
		
		for($jj=0;$jj<count($lasopciones);$jj++){
			$tmp2 = $lasopciones[$jj];
			$des_opcion = utf8_decode($tmp2->getDescripcion());
			$idopcion = $tmp2->getId();
			$kk=0;
			$check="";
			while($xsubmenu[$kk]){
				if ($idsubmenu==$xsubmenu[$kk]) $check="checked";
				$kk++;
			}
?>
		<tr><td><input type='checkbox' name=submenu[] <?=$check?> value='<?=$idopcion?>'><?=$des_opcion?></td><tr>
<?php			
		}
		?>
                            </table>
            </td>
            </tr>
        <?php }?>
<?php
	}
	?>
	</table>
	</td><?php
	}
	?>
	</tr>
	</table>
