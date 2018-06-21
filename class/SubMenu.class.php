<?php
/**
 * class SubMenu
 */
class SubMenu
{
	var $id;
	var $idmenu;
	var $idsubmenu;
	var $nombre;
	var $clase;
	var $descripcion;
	var $ancho;
	var $tipo;
	var $orden;

	function setId( $x ) { $this->id=$x;  } // end of member function setId
	function setIdMenu( $x ) { $this->idmenu=$x; }
	function setIdSubMenu( $x ) { $this->idsubmenu=$x; }
	function setNombre($x) { $this->nombre=$x;}
	function setClase($x) { $this->clase=$x;}
	function setDescripcion( $x ) { $this->descripcion=$x;  } // end of member function setDescripcion
	function setLink($x) { $this->link=$x;}
	function setAncho($x) { $this->ancho=$x; }
	function setTipo($x) { $this->tipo=$x; }
	function setOrden($x) { $this->orden=$x; }
	
	function getId( ) { return $this->id;  } // end of member function setId
	function getIdMenu( ) { return $this->idmenu; }
	function getIdSubMenu( ) { return $this->idsubmenu; }
	function getNombre() { return $this->nombre;}
	function getClase() { return $this->clase;}
	function getDescripcion( ) { return $this->descripcion;  } // end of member function setDescripcion
	function getLink() { return $this->link;}
	function getAncho() { return $this->ancho; }
	function getTipo() { return $this->tipo; }
	function getOrden() { return $this->orden; }
} // end of SubMenu
?>
