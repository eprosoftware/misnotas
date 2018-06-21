<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Nota
 *
 * @author eroman
 */
class Nota {
    function setId($x) {$this->id=$x;}
    function setAsignatura($x) {$this->asignatura=$x;}
    function setIdUsuario($x) {$this->id_usuario=$x;}
    function setAnno($x) {$this->anno=$x;}
    function setSemestre($x) {$this->semestre=$x;}
    function setNota1($x) {$this->nota1=$x;}
    function setNota2($x) {$this->nota2=$x;}
    function setNota3($x) {$this->nota3=$x;}
    function setNota4($x) {$this->nota4=$x;}
    function setNota5($x) {$this->nota5=$x;}
    function setNota6($x) {$this->nota6=$x;}
    
    function getId() {return $this->id;}
    function getAsignatura() {return $this->asignatura;}
    function getIdUsuario() {return $this->id_usuario;}
    function getAnno() {return $this->anno;}
    function getSemestre() {return $this->semestre;}
    function getNota1() {return $this->nota1;}
    function getNota2() {return $this->nota2;}
    function getNota3() {return $this->nota3;}
    function getNota4() {return $this->nota4;}
    function getNota5() {return $this->nota5;}
    function getNota6() {return $this->nota6;}    
}
