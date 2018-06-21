<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBNotas
 *
 * @author eroman
 */
class DBNotas extends DBNucleo {
    function get($id="",$id_usuario="",$anno="",$semestre=""){
        $this->conecta_pdo();
        $sql = "select * from Notas where id_usuario=:usuario ";
        if($anno) {$sql.=" and anno=$anno";}
        if($semestre) {$sql.=" and semestre=$semestre";}
        $st = $this->pdo->prepare($sql);
        $st->bindParam(':usuario',$id_usuario);
        if ($st->execute()){
            $salida=array();
            while($row = $st->fetch()){
                $salida[]=$row;
            }   
            $st->closeCursor();
            
            $rx = $this->query_pdo("select @nrofilas");
            foreach ($rx as $rr){
                $nrofilas = $rr[0];
            }
            $t = array();
            $t['salida'] = $salida;
            $t['nrofilas'] = $nrofilas;
            return $t; 
        }        
        
        
    }
    function getControles($id="",$id_usuario="",$anno="",$semestre=""){
        $this->conecta_pdo();
        $sql = "select * from Controles where id_usuario=:usuario ";
        if($anno) {$sql.=" and anno=$anno";}
        if($semestre) {$sql.=" and semestre=$semestre";}
        $st = $this->pdo->prepare($sql);
        $st->bindParam(':usuario',$id_usuario);
        if ($st->execute()){
            $salida=array();
            while($row = $st->fetch()){
                $salida[]=$row;
            }   
            $st->closeCursor();
            
            $rx = $this->query_pdo("select @nrofilas");
            foreach ($rx as $rr){
                $nrofilas = $rr[0];
            }
            $t = array();
            $t['salida'] = $salida;
            $t['nrofilas'] = $nrofilas;
            return $t; 
        }        
        
        
    }
    function update($id,$pos,$valor){
        $this->conecta_pdo();
        $sql = "update Notas set nota$pos=:valor "
                . "where id= :id";
        $st = $this->pdo->prepare($sql);
        $st->bindParam(":id",$id);
        $st->bindParam(":valor",$valor);
        
        if($st->execute()){
            return ".";
        } else {
            return "x";
        }
    }
    function updateControl($id,$pos,$valor){
        $this->conecta_pdo();
        $sql = "update Controles set nota$pos=:valor "
                . "where id= :id";
        $st = $this->pdo->prepare($sql);
        $st->bindParam(":id",$id);
        $st->bindParam(":valor",$valor);
        
        if($st->execute()){
            return ".";
        } else {
            return "x";
        }
    }    
}
