<?php
//***********************************************************//
//Clase DBMenu                                               //
//***********************************************************//
// Funciones de esta clase

class DBMenu extends DBVarios
{
    var $dic;

    function DBMenu(){ 
            $this->conecta_pdo();
    }

    function add($tmp){
            $nombre = $tmp->getNombre();
            $clase = $tmp->getClase();
            $descripcion = $tmp->getDescripcion( );
            $imagen = $tmp->getImagen( );
            $imagenOver = $tmp->getImagenOver();
            $link = $tmp->getLink();
            $ancho = $tmp->getAncho();
            $orden = $tmp->getOrden();
            $sql = "insert Menu(nombre,clase,descripcion,link,ancho,orden) values('$nombre','$clase','$descripcion','$link',$ancho,$orden)";
            //echo "<P>SQL: $sql </P>";
            $rs = mysql_query($sql);
            if ($rs)
                    return true;
            else
                    return mysql_error();
    }


    function update($tmp){
            $id=$tmp->getId();
            $nombre     = $tmp->getNombre();
            $clase      = $tmp->getClase();
            $descripcion = $tmp->getDescripcion( );
            $imagen     = $tmp->getImagen( );
            $imagenOver = $tmp->getImagenOver();
            $link       = $tmp->getLink();
            $ancho      = $tmp->getAncho();
            $orden      = $tmp->getOrden();

            $sql = "update Menu set nombre='$nombre',clase='$clase',descripcion='$descripcion',link='$link',ancho=$ancho,orden=$orden where id=$id ";
            //echo "<p>SQL:$sql</p>";
            $rs = mysql_query($sql);
            if ($rs)
                    return true;
            else
                    return mysql_error();
    }

    function del($id){
        $this->conecta();
            $sql="delete from Menu where id=$id";
            //echo "<!-- SQL: $sql -->";
            $rs = $this->query($sql);
    }

    function ElMenu($id="",$menu_usr="")
	{
            $this->conecta_pdo();
		$sql = "select * from Menu where id>0";
		if ($id) $sql.= " and id=$id";
		if ($menu_usr) $sql.= " and find_in_set(id,'$menu_usr')";
		$sql.= " order by orden";
		//echo "<p>$sql</p>";
		$rs = $this->query_pdo($sql);
		if ($rs){
			$salida=array();
			foreach ($rs as $row){
				$tmp=new Menu();
				$tmp->setId($row[id]);
				$tmp->setNombre($row[nombre]);
				$tmp->setClase($row[clase]);
				$tmp->setDescripcion($row[descripcion]);
				$tmp->setImagen($row[imagen]);
				$tmp->setImagenOver($row[imagen_over]);
				$tmp->setAncho($row[ancho]);
				$tmp->setOrden($row[orden]);
				$tmp->setLink($row[link]);
		
				$salida[]=$tmp;
			}
			return $salida;
		}

	}


    function LosSubMenus($id_menu="",$id_submenu="",$tipo="",$submenu=""){
            $this->conecta_pdo();
		$sql="select * from SubMenu where id>0";
		if ($id_menu)    $sql.= " and id_menu=$id_menu";
		if ($id_submenu) $sql.= " and id_submenu=$id_submenu";
		if ($tipo)       $sql.= " and tipo in ($tipo)";
		if ($submenu)	 $sql.= " and find_in_set(id,'$submenu')";
		//echo "<p>!--SQL SubMenus :$sql--</p>";
		$sql.= " order by orden";

		$rs=$this->query_pdo($sql);
		if($rs){
			$salida=array();
			foreach ($rs as $row){
				$tmp = new SubMenu();
				$tmp->setId($row[id]);
				$tmp->setNombre($row[nombre]);
				$tmp->setClase($row[clase]);
				$tmp->setIdMenu($row[id_menu]);
				$tmp->setDescripcion($row[descripcion]);
				$tmp->setLink($row[link]);
				$tmp->setAncho($row[ancho]);
				$tmp->setTipo($row[tipo]);
				$tmp->setOrden($row[orden]);
				$salida[]=$tmp;
			}
			return $salida;
		}
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
    
    function genCSSMenu($id_user,$menu_usr,$submenu_usr){
            $elmenu = $this->ElMenu("",$menu_usr);
            $i=0;
?>
<ul id="main-menu" class="sm sm-blue">
    <li><a href="/index.php"><i class="glyphicon glyphicon-home" style="font-size:18px;"></i></a></li>
<?php
            while($tmp = $elmenu[$i]){
                $id_menu    = $tmp->getId();
                $nombre     = $tmp->getNombre();
		$clase      = $tmp->getClase();
		$ancho      = $tmp->getAncho();
		$palabra    = $tmp->getDescripcion();
		$descripcion= trim($palabra);
		$imagen     = $tmp->getImagen();
		$img1       = substr($imagen,0,strlen($imagen)-4);
		$ext        = substr($imagen,-4);
		$imagenOver = $tmp->getImagenOver();
		$link       = $tmp->getLink();
		$link       = ($link)?$link:"#";
                $lossubmenus = $this->LosSubMenus($id_menu," 0","2,3",$submenu_usr);
?>
    
<li><a href="<?=$link?>"><?=$descripcion?></a>
<?php
                if(count($lossubmenus)>0){
?>
<ul>
<?php
                    $j=0;
                    while($sub = $lossubmenus[$j]){
			$desc_submenu = $sub->getDescripcion();
                        $sub_tipo = $sub->getTipo();
                        $clase = $sub->getClase();
                        $id_submenu = $sub->getId();
                        $l = $sub->getLink();
                        if ($sub_tipo==2){

                            if ($desc_submenu=="---"){
?>
    <li><hr></li>
<?php
                                }else {
?>
    <li class="<?=$clase?>"><a href="<?=($l)?$l:"#"?>"><?=$desc_submenu?></a></li>
<?php
                            }
                        }
                        if ($sub_tipo==3){

?>
    <li class="<?=$clase?>"><a href="#" ><?=$desc_submenu?></a>
    <ul>
<?php
                            
                                $op_submenus = $this->LosSubMenus($id_menu,$id_submenu,"2,3",$elsubmenu);
                                if(count($op_submenus)>0){
                                    $jj=0;
                                    while($ss = $op_submenus[$jj]){
                                        $desc_submenu = $ss->getDescripcion();
                                        $ll = $ss->getLink();
                                        if ($desc_submenu=="---"){
?>
    <li><hr></li>
<?php
                                        } else {
?>
        <li ><a href="<?=($ll)?$ll:"#"?>"><?=$desc_submenu?></a></li>
<?php
                                        }
                                        $jj++;
                                    }
                                }
?>
    </ul>
    </li>
<?php
                        }

                        $j++;
                    }
?>
</ul>
<?php
                } else {?></li><?php }
?>
    </li>
<?php



            //$Aux->AddMenuPrincipal($elmenu,$lenguaje);
            //$Aux->AddSubMenu($elmenu,$submenu_usr,$lenguaje);
                $i++;
            }
            
?>
    <li class="pull-right"><a href="javascript:toggleLayer('indicadores_div')"><i class="glyphicon glyphicon-calendar"></i></a><div id="indicadores_div" style="display:none;position:absolute;right: 0;z-index:9999" ><?php include 'includes/indicadores.php';?></div></li>
    <li class="pull-right"><a href="javascript:Salir()" ><i class="glyphicon glyphicon-off"></i>&nbsp;Salir</a></li>
</ul>
            <?php 
        }        

    function genDropMenu($id_user,$menu_usr,$submenu_usr){
                
                $u = new DBUsuario();
                $usr = $u->ElUsuario($id_user);
                $menu_usr = $usr->getMenu();
                $submenu_usr = $usr->getSubMenu();
                
                $elmenu = $this->ElMenu("",$menu_usr);
                //$logo_usuario = $usr->getLogoImagen();
                //$tipo_menu = $usr->getTipoMenuMarkfi();

                if(!$logo_usuario) $ellogo = "logo_eprosoftCL.png";
                else $ellogo = $logo_usuario;
                $i=0;
    ?>
    <nav class="navbar navbar-default navbar-collapse navbar-static-top" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <!--<a class="navbar-brand" href="/index.php"><img src="/images/logo_eprosoft.png" border="0" width="180"></a>-->
        </div>
       <div class="collapse navbar-collapse navbar-ex1-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">    
    <?php
                while($tmp = $elmenu[$i]){
                    $id_menu    = $tmp->getId();
                    $nombre     = $tmp->getNombre();
                    $clase      = $tmp->getClase();
                    $ancho      = $tmp->getAncho();
                    $palabra    = $tmp->getDescripcion();
                    $descripcion= $palabra;
                    $imagen     = $tmp->getImagen();
                    $img1       = substr($imagen,0,strlen($imagen)-4);
                    $ext        = substr($imagen,-4);
                    $imagenOver = $tmp->getImagenOver();
                    $link       = $tmp->getLink();
                    $link       = ($link)?$link:"#";
                    $lossubmenus = $this->LosSubMenus($id_menu," 0","2,3",$submenu_usr);
    ?>
        <?php if($nombre=="navbar_m10"){?>
              <li><a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" href="javascript:;" onclick="<?=$link?>" ><?=$descripcion?>&nbsp;<span class="glyphicon glyphicon-off"></span> </a>
        <?php } else {?>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" id="<?=$nombre?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" ><?=$descripcion?>&nbsp;<span class="caret"></span></a>
        <?php }?>
    <?php
                    if(count($lossubmenus )>0 ) {
    ?>
    <ul class="dropdown-menu" aria-labeledby="<?=$nombre?>">
    <?php
                        $j=0;
                        while($sub = $lossubmenus[$j]){
                            $desc_submenu = $sub->getDescripcion();
                            $sub_tipo = $sub->getTipo();
                            $clase = $sub->getClase();
                            $id_submenu = $sub->getId();
                            $l = $sub->getLink();
                            if ($sub_tipo==2){

                                if ($desc_submenu=="---"){
    ?>
        <li role="separator" class="divider"></li>
    <?php
                                    }else {
    ?>
        <li><a href="<?=($l)?$l:"#"?>"><?=$desc_submenu?></a></li>
    <?php
                                }
                            }
                            if ($sub_tipo==3 ){

    ?>
        <li class="dropdown-submenu"><a href="<?=($l)?$l:"#"?>"><?=$desc_submenu?></a>
        <ul class="dropdown-menu">  
    <?php
                                    $op_submenus = $this->LosSubMenus($id_menu,$id_submenu,"2,3",$elsubmenu);
                                    if(count($op_submenus)>0){
                                        $jj=0;
                                        while($ss = $op_submenus[$jj]){
                                            $desc_submenu = $ss->getDescripcion();
                                            $ll = $ss->getLink();
                                            if ($desc_submenu=="---"){?>
    <li role="separator" class="divider"></li>
    <?php
                                            } else {
    ?><li><a href="<?=($ll)?$ll:"#"?>"><?=$desc_submenu?></a></li><?php
                                            }
                                            $jj++;
                                        }
                                    }
    ?>
        </ul></li>
    <?php
                            }

                            $j++;
                        }
    ?>
    </ul>
    <?php
                    } 
    ?>
    </li>
    <?php
                    $i++;
                }
                ?>
          </ul>
       </div>
    </nav>
                <?php 
    }        
}
