<?php
//***********************************************************//
//Clase Usuario
//***********************************************************//
class Usuario
{
        // Constructor
        function Usuario(){
        }

        // Metodos para setear variables
        function setId($id){$this->id = $id;}
        function setRut($x) {$this->rut=$x;}
        function setUsuario($user){$this->user = $user;}
	function setAlias($x){$this->alias = $x;}
        function setClave($pass){$this->pass = $pass;}
        function setNombre($nombre){$this->nombre = $nombre;}
        function setTipoProfesional($tipo){$this->tipo = $tipo;}
        function setCelular($celular){$this->celular = $celular;}
        function setFono($fono){$this->fono = $fono;}
	function setFax($x){$this->fax = $fax;}
        function setEmail($email){$this->email = $email;}
	function setFechaCumpleanos($x) { $this->cumpleanos = $x; }
	function setMenu($x) { $this->menu = $x; }
	function setSubMenu($x) { $this->submenu = $x; }
        function setActivo($x){$this->activo = $x;}
        function setTipoUsuario($x) {$this->tipo_usuario=$x;}
	function setFechaModClave($x){ $this->fecha_modclave=$x;}
	function setUltClave($x) { $this->ultclave=$x;}
	function setNroDiasCambioClave($x) { $this->nrodias_cambioclave=$x;}
        function setJefe($x) {$this->jefe =$x;}
	function setPermisos($x)	{ $this->permisos=$x;$this->a_permisos=explode(",",$this->permisos);}
        function setUltAcceso($x) {$this->ult_acceso=$x;}

        // Metodos para traer variables
        function getId(){return $this->id;}
        function getRut() {return $this->rut;}
        function getUsuario(){return $this->user;}
	function getAlias(){return $this->alias;}
        function getClave(){return $this->pass;}
        function getNombre(){return $this->nombre;}
        function getTipoProfesional(){return $this->tipo;}
        function getCelular(){return $this->celular;}
        function getFono(){return $this->fono;}
	function getFax(){return $this->fax;}
        function getEmail(){return $this->email;}
	function getFechaCumpleanos() { return $this->cumpleanos; }
        function getActivo(){return $this->activo;}
	function getMenu() { return $this->menu; }
	function getSubMenu() { return $this->submenu; }
        function getTipoUsuario() {return $this->tipo_usuario;}
	function getFechaModClave(){return $this->fecha_modclave;}
	function getUltClave() { return $this->ultclave;}
	function getNroDiasCambioClave() { return $this->nrodias_cambioclave;}
        function getJefe() {return $this->jefe;}
        function getPermisos()		{ return $this->permisos;}
        function getUltAcceso() {return $this->ult_acceso;}
	function getDespachar()	{ return $this->a_permisos[0];}        
        function getEliminarCotizacion()	{ return $this->a_permisos[1];}
        function getEliminarProyecto()	{ return $this->a_permisos[2];}
        function getEliminarItemProyecto()	{ return $this->a_permisos[3];}
        function getEliminarMiBitacora()	{ return $this->a_permisos[4];}
        function getBitacoraHorarioLiberado(){return $this->a_permisos[5];}
        function getEstadosPagoOC_HES() {return $this->a_permisos[6];}
        function getAsignarProyectista() {return $this->a_permisos[7];}
        function getAsignarEstadoProyecto() {return $this->a_permisos[8];}
        function getEditarProyectos() {return $this->a_permisos[9];}
        function getEditarItemProyectos() {return $this->a_permisos[10];}
        
}
?>
