<?php /**
 * class Menu
 */
class Menu
{
	var $id;
	var $nombre;
	var $clase;
	var $descripcion;
	var $imagen;
	var $imagenover;
	var $ancho;
	var $link;

	function setId( $x ) { $this->id=$x; } // end of member function setId
	function setNombre($x) { $this->nombre=$x;}
	function setClase($x) { $this->clase=$x;}
	function setDescripcion( $x ) { $this->descripcion=$x;} // end of member function setDescripcion
	function setImagen( $x) { $this->imagen=$x; }
	function setImagenOver($x) { $this->imagenover=$x;}
	function setLink($x) { $this->link=$x;}
	function setAncho($x) { $this->ancho=$x;}
	function setOrden($x) { $this->orden=$x;}

	function getId( ) { return $this->id;} // end of member function getId
	function getNombre() { return $this->nombre;}
	function getClase() { return $this->clase;}
	function getDescripcion( ) { return $this->descripcion; } // end of member function getDescripcion
	function getImagen( ) { return $this->imagen; }
	function getImagenOver() { return $this->imagenover;}
	function getLink() { return $this->link;}	
	function getAncho() { return $this->ancho;}
	function getOrden() { return $this->orden;}
} // end of Menu
?>
