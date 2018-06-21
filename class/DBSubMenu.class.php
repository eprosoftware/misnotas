<?php
class DBSubMenu extends DBVarios {
	function DBSubMenu() { $this->conecta(); }

	function add($tmp){
		$nombre         = $tmp->getNombre();
		$clase          = $tmp->getClase();
		$descripcion    = $tmp->getDescripcion( );
		$link           = $tmp->getLink();
		$ancho          = $tmp->getAncho();
		$orden          = $tmp->getOrden();
		$tipo           = ($tmp->getTipo())?$tmp->getTipo():2;
		$id_menu        = $tmp->getIdMenu();
		$id_submenu     = $tmp->getIdSubMenu();
		$sql = "insert SubMenu(nombre,clase,descripcion,link,ancho,orden,tipo,id_menu,id_submenu) "
                        . "values('$nombre','$clase','$descripcion','$link',$ancho,$orden,$tipo,$id_menu,$id_submenu)";
		echo "<p>!-- SQL: $sql --</p>";
		$rs = mysql_query($sql);
		if ($rs)
			return true;
		else
			return mysql_error();
	}

	function update($tmp){
		$id=$tmp->getId();
		$nombre = $tmp->getNombre();
		$clase = $tmp->getClase();
		$descripcion = $tmp->getDescripcion( );
		$link = $tmp->getLink();
		$tipo = $tmp->getTipo();
		$ancho = ($tmp->getAncho())?$tmp->getAncho():100;
		$orden = ($tmp->getOrden())?$tmp->getOrden():1;
                $idmenu = $tmp->getIdMenu();
                $idsubmenu = $tmp->getIdSubMenu();
                
		$sql = "update SubMenu set nombre='$nombre',clase='$clase',descripcion='$descripcion',link='$link',ancho=$ancho,orden=$orden,tipo=$tipo,id_menu=$idmenu where id=$id ";
		echo "<p>!--SQL:$sql --</p>";
		$rs = $this->query($sql);
		if ($rs)
			return true;
		else
			return mysql_error();
	}


	function del($id){
		$sql="delete from SubMenu where id=$id";
		//echo "<!-- SQL: $sql -->";
		$rs = mysql_query($sql);
	}

	function ElSubMenu($id){
            $this->conecta_pdo();
            $sql="select * from SubMenu where id=$id";

            $rs=$this->query_pdo($sql);
            foreach($rs as $row){
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
                    return $tmp;
            }
	}

	function LosSubMenus($id_menu="",$id_submenu="",$tipo=""){
		$sql="select * from SubMenu where id>0";
		if ($id_menu)    $sql.= " and id_menu=$id_menu";
		if ($id_submenu) $sql.= " and id_submenu=$id_submenu";
		if ($tipo)       $sql.= " and tipo in ($tipo)";
		//echo "<p>SQL:$sql</p>";
		$sql.= " order by descripcion";

		$rs=mysql_query($sql);
		if($rs){
			$salida=array();
			while($row=mysql_fetch_array($rs)){
				$tmp = new SubMenu();
				$tmp->setId($row[id]);
				$tmp->setNombre($row[nombre]);
				$tmp->setClase($row[clase]);
				$tmp->setIdMenu($row[id_menu]);
				$tmp->setDescripcion($row[descripcion]);
				$tmp->setLink($row[link]);
				$tmp->setAncho($row[ancho]);
				$tmp->setTipo($row[tipo]);
				$salida[]=$tmp;
			}
			return $salida;
		}
	}

}
