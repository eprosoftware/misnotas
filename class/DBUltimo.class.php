<?
	class DBUltimo extends Conexion {

		function DBUltimo($tabla1,$tabla2){
			$this->setTablaUltimo($tabla1);
			$this->setTablaNro($tabla2);
		}
		
		//Set method
		function setNumero($numero)           { $this->numero = $numero; }
		function setTablaUltimo($tabla_ultimo){ $this->tabla_ultimo = $tabla_ultimo; }
		function setTablaNro($tabla_nro)      { $this->tabla_nro = $tabla_nro; }
		
		//Get method
		function getNumero()     { return $this->numero; }
		function getTablaUltimo(){ return $this->tabla_ultimo; }
		function getTablaNro()   { return $this->tabla_nro; }
		function eliminar(){
			$this->conecta();
			$tabla_nro = $this->getTablaNro();
			$nro = $this->getNumero();
			$sql = "delete from $tabla_nro where NUMERO=$nro";
			$rs = mysql_query($sql);
		}
		
		//General Method
		function genera(){
			$this->conecta();
			$tabla_nro    = $this->getTablaNro();
			$tabla_ultimo = $this->getTablaUltimo();
		        //Existen numeros no usados 	
			$sql = "select min(numero) from $tabla_nro where ocupado = 0";
			//echo "<p>SQL: $sql";
			$rs = mysql_query($sql);
			if ($rs)
				$nro = mysql_fetch_array($rs);
			
			if (!is_null($nro[0])){
			   $sql = "update $tabla_nro set ocupado=1 where numero=$nro[0]";
			   //echo "<p>SQL: $sql";
			   $xs = mysql_query($sql);
			   //echo "<p>Update aplicado";
			   if ($xs)
			   	$this->setNumero($nro[0]);
			   else
			        $this->setNumero(0);

			   $this->setNumero($nro[0]);
			} else {
			   $sql = "select ultnro+1 from $tabla_ultimo";
			   //echo "<p>!-- $sql --</p>";
			   $rs = mysql_query($sql);
			   if($rs){
			   	$nro = mysql_fetch_array($rs);
			   	$this->setNumero($nro[0]);
			   	$sql = "update $tabla_ultimo set ultnro=$nro[0]";
			   	$xs = mysql_query($sql);
			   	$sql = "insert $tabla_nro values($nro[0],1)";
			   	$xs = mysql_query($sql);
			   }
			}
			return $this->getNumero();
		}
		function getNroPerdidos(){
			$this->conecta();
			$tabla_nro    = $this->getTabla_nro();
			$tabla_ultimo = $this->getTabla_ultimo();
		        //Existen numeros perdidos 	
			$sql = "select * from $tabla_nro where OCUPADO = 1";
			$salida=array();
			$rs=mysql_query($sql);
			if ($rs)
				while($campos=mysql_fetch_array($rs)){
					$salida[] = $campos[NUMERO];
				}
			else
				return mysql_error($rs);
			return $salida;
		}
		
		function libera($nro=""){
			$this->conecta();
			$numero = $this->getNumero();
			$sql = "update $this->tabla_nro set OCUPADO=0 ";
			if ($nro) $sql.= "where NUMERO=$nro";
			//echo "<p>SQL: $sql</p>";
			$rs = mysql_query($sql);
			if ($rs)
				return "OK";
			else
				return mysql_error($rs);
		}
		function get(){
			$this->conecta();
			$sql = "select ULTNRO from ".$this->tabla_ultimo;
			$rs = mysql_query($sql);
			if ($rs) {
				$row=mysql_fetch_array($rs);
				return $row[ULTNRO];
			} else 
				return mysql_error($rs);
		}
		function set($ultnro){
			$this->conecta();
			$sql = "update ".$this->tabla_ultimo." set ULTNRO=$ultnro";
			$rs = mysql_query($sql);
			if ($rs)
				return "OK";
			else
				return mysql_error($rs);
		}
        function ObtieneNro($tablaocup, $tablault)
        {
                $this->conecta();
                $nro = 0;
                $sql = "SELECT min(numero) as NRO FROM $tablaocup WHERE ocupado=0";
                $res = mysql_query($sql);
                if($res)
                {
                        if($row = mysql_fetch_array($res))
                        {
                                $nro = $row["NRO"];
                        }
                }
                if($nro)
                {
                        $sql = "UPDATE $tablaocup SET ocupado=1 WHERE numero=$nro";
                        $res = mysql_query($sql);
                }
                else
                {
                        $sql = "SELECT ultnro+1 as NRO FROM $tablault";
                        $res = mysql_query($sql);
                        if($res)
                        {
                                if($row = mysql_fetch_array($res))
                                {
                                        $nro = $row["NRO"];
                                        $sql1 = "INSERT INTO $tablaocup(numero,ocupado)
	                                                        VALUES($nro,1)";
                                        $res1 = mysql_query($sql1);

                                        $sql2 = "UPDATE $tablault SET ultnro=$nro";
                                        $res2 = mysql_query($sql2);
                                }
                        }
                }
                return $nro;
        }
	}
?>
