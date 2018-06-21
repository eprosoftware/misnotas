<?php
//***********************************************************//
//Clase DBUsuario                                            //
//***********************************************************//
// Funciones de esta clase
class DBUsuario extends DBNucleo
{
	// funcion que trae el id de un usuario
	function getUsuarioId($login,$clave="")
	{
                $this->conecta_pdo();
		$id = 0;
		/*$sql = "SELECT id FROM Usuarios WHERE usuario like '$login' ";
                if ($clave) $sql.= " and clave ='$clave' ";
		$sql.= " AND activo=1";*/
                $sql = "select getLogin('$login','$clave')";
                //echo "<p>SQL: $sql </p>";
		$res = $this->query_pdo($sql);
		if($res)
		{
                    foreach ($res as $row){;}
                    $id = $row[0];
                    if($id>0){
                        $sql = "update Usuarios set ult_acceso=now() where id=:id";
                        $st = $this->pdo->prepare($sql);
                        $st->bindParam(":id",$id);
                        $st->execute();
                    }
		}
		return $id;
	}
	// funcion que trae el objeto usuario dado un ID
	function ElUsuario($id="", $login="")
	{
		$this->conecta_pdo();
		$tmp = new Usuario();
		$sql = "SELECT *,datediff(now(),modClave) nrodias_cambioclave "
                        . "FROM Usuarios WHERE id>0";
		if($id)	    $sql.= " AND id=$id";
		if($login)  $sql.= " AND usuario like '$login'";
		//echo "<p>SQL:$sql</p>";
		$res = $this->query_pdo($sql);
		if($res)
		{
			foreach($res as $row)
			{
				$tmp->setId($row["id"]);
                                $tmp->setRut($row['rut']);
				$tmp->setUsuario($row["usuario"]);
				$tmp->setAlias($row["alias"]);
				$tmp->setClave($row["clave"]);
				$tmp->setNombre($row["nombre"]);
				//$tmp->setTipoProfesional($row["tipo_profesional"]);
				$tmp->setEmail($row["email"]);
				$tmp->setMenu($row["menu"]);
				$tmp->setSubMenu($row["submenu"]);
				$tmp->setActivo($row["activo"]);
				$tmp->setFono($row["fono"]);
				$tmp->setCelular($row["celular"]);
				$tmp->setFechaCumpleanos($row["fecha_cumpleanos"]);
				$tmp->setTipoUsuario($row["tipo_usuario"]);
				$tmp->setFechaModClave($row["modClave"]);
				$tmp->setUltClave($row["ultClave"]);
				$tmp->setNroDiasCambioClave($row["nrodias_cambioclave"]);
                                $tmp->setJefe($row['jefe']);
                                $tmp->setPermisos($row['permisos']);
			}
		}
		return $tmp;
	}
	
	// funcion que trae un arreglo de objeto usuario
	function LosUsuarios($grupo="",$activo="",$jefe="")
	{
		$this->conecta_pdo();
		$tmp = new Usuario();
		$salida = array();
		$sql = "SELECT *,datediff(now(),modClave) nrodias_cambioclave FROM Usuarios WHERE id>0 ";
		if ($activo) $sql.= " and activo=$activo ";
		if ($grupo) $sql.= "and find_in_set($grupo,grupo) ";
                if($jefe) $sql.=" and jefe=$jefe";
		$sql.=" order by usuario ";
		//echo "<p>!--Usuarios: $sql --</p>";
		$res = $this->query_pdo($sql);
		if($res)
		{
			foreach($res as $row)
			{
				$tmp = new Usuario();
				$tmp->setId($row["id"]);
                                $tmp->setRut($row['rut']);
				$tmp->setUsuario($row["usuario"]);
				$tmp->setAlias($row["alias"]);
				$tmp->setClave($row["clave"]);
				$tmp->setNombre($row["nombre"]);
				$tmp->setTipoProfesional($row["tipo_profesional"]);
				$tmp->setEmail($row["email"]);
				$tmp->setMenu($row["menu"]);
				$tmp->setActivo($row["activo"]);
				$tmp->setFono($row["fono"]);
				$tmp->setCelular($row["celular"]);
				$tmp->setFechaCumpleanos($row["fecha_cumpleanos"]);
				$tmp->setTipoUsuario($row["tipo_usuario"]);
				$tmp->setNroDiasCambioClave($row["nrodias_cambioclave"]);			
                                $tmp->setJefe($row['jefe']);
                                $tmp->setPermisos($row['permisos']);
                                $tmp->setUltAcceso($row['ult_acceso']);
				$salida[] = $tmp;
			}
		}
		return $salida;
	}

	// funcion que agrega un usuario
	function AddUsuario($tmp)
	{
		$this->conecta_pdo();
                $rut = $tmp->getRut();
		$nombre = $tmp->getNombre();
		$alias = $tmp->getAlias();
		$usuario = $tmp->getUsuario();
		$clave = $tmp->getClave();
		$email = $tmp->getEmail();
                $menu = $tmp->getMenu();
                $submenu = $tmp->getSubMenu();
                
		$tipo  = $tmp->getTipoProfesional();
		$cumpleanos = $tmp->getFechaCumpleanos();
		$tipo_usuario = $tmp->getTipoUsuario();
                $jefe = $tmp->getJefe();

		$mensaje = "";
		$mensaje.= "Sr(a). $nombre<br>\n";
		$mensaje.= "Su clave en el sistema cotizador es $clave<br><br>\n";
                $mensaje.=" http://proyectos.eprosoft.cl \n";
		$mensaje.= "Atte<br>\n";
		$mensaje.= "Proyectos EproSoftware\n";
		

		$sql = "INSERT INTO Usuarios(rut,nombre, usuario,alias, clave, email, fecha_cumpleanos,activo, fono,celular,menu,submenu,tipo_usuario,jefe) 
				VALUES(:rut,:nombre,:usuario,:alias,:clave,:email,:cumpleanos,1,:fono,:celular,:menu,:submenu,:tipo_usuario,:jefe)";
                $st = $this->pdo->prepare($sql);
                $st->bindParam(":rut",$rut);
                $st->bindParam(":nombre",$nombre);
                $st->bindParam(":usuario",$usuario);
                $st->bindParam(":alias",$alias);
                $st->bindParam(":clave",$clave);
                $st->bindParam(":email",$email);
                $st->bindParam(":cumpleanos",$cumpleanos);
                $st->bindParam(":fono",$fono);
                $st->bindParam(":celular",$celular);
                $st->bindParam(":menu",$menu);
                $st->bindParam(":submenu",$submenu);
                $st->bindParam(":tipo_usuario",$tipo_usuario);
                $st->bindParam(":jefe",$jefe);
                
		//echo "<p>SQL: $sql </p>";
                $st->execute();
                
                $id_usuario = $this->pdo->lastInsertid();
                
                $sql = "insert Configuracion(id_usuario) value ($id_usuario)";
                $res = $this->query_pdo($sql);
                
		if($res)
		{
			$to = $email;
			$nombrefrom = "Epro Software";
			$from = "info@eprosoft.cl";
			$subject = "Notificacion de Clave Sistema Cotizador Epro Software";
			$message = $mensaje;
        		$this->EnviaMail($to,$nombrefrom,$from,$subject,$message);
			$msg = "Operacion Exitosa<br>Su clave sera enviada a la direccion $to";
		}
		else
		{
			$msg = -1;
		}
		return $msg;
	}

	// funcion que modifica un usuario
	function ModUsuario($p)
	{
		$this->conecta_pdo();
                $tmp = new Usuario();
                $tmp = $p;
		$x = new DBVarios();

		$id = $tmp->getId();
                $rut = $tmp->getRut();
		$nombre = $tmp->getNombre();
		$alias = $tmp->getAlias();
		$usuario = $tmp->getUsuario();
		$clave = $tmp->getClave();
		$email = $tmp->getEmail();
		$fono = $tmp->getFono();
		$celular = $tmp->getCelular();
		$tipopro = $tmp->getTipoProfesional();
		$menu = $tmp->getMenu();
                $submenu = $tmp->getSubMenu();
		$activo = $tmp->getActivo();
		$cumpleanos = $tmp->getFechaCumpleanos();
                $tipo_usuario = $tmp->getTipoUsuario();
                $permisos = $tmp->getPermisos();
                $jefe = $tmp->getJefe();

		$sql = "UPDATE Usuarios SET rut=:rut,
                                        nombre=:nombre,
                                        alias=:alias,
					clave=:clave, 
					email=:email,
					fono=:fono,
					celular=:celular,
					activo=1,
					fecha_cumpleanos =:cumpleanos,
                                        menu=:menu,
                                        submenu=:submenu,    
					tipo_usuario = :tipo_usuario,
                                        permisos=:permisos,
                                        jefe =:jefe
					WHERE id=:id ";
                $st = $this->pdo->prepare($sql);
                
                
                $st->bindParam(":rut",$rut);
                $st->bindParam(":nombre",$nombre);
                $st->bindParam(":alias",$alias);
                $st->bindParam(":clave",$clave);
                $st->bindParam(":email",$email);
                $st->bindParam(":fono",$fono);
                $st->bindParam(":celular",$celular);
                $st->bindParam(":cumpleanos",$cumpleanos);
                $st->bindParam(":menu",$menu);
                $st->bindParam(":submenu",$submenu);
                $st->bindParam(":tipo_usuario",$tipo_usuario);
                $st->bindParam(":permisos",$permisos);
                $st->bindParam(":jefe",$jefe);
                $st->bindParam(":id",$id);
                
		//echo "<p>SQL: $sql </p>";
                $st->execute();
                
		if($res)
			$msg = "Operacion Exitosa";
		else
			$msg = -1;
		return $msg;
	}

	//funcion que modica la clave
	function ModificarClave($login, $clave)
	{
		$this->conecta();
		$sql = "UPDATE USUARIOS SET CLAVE='$clave' WHERE USUARIO='$login'";
		echo "<p>$sql</p>";
		$res = mysql_query($sql);
		if($res)
		{
			$msg = "Modificacion Existosa";
		}
		else
		{
			$msg = -1;
		}
		return $msg;
	}

	function DelUsuario($id,$activo="")
	{
		$this->conecta_pdo();
		if ($activo==1)
			$sql = "UPDATE Usuarios SET activo=0,clave=\"!clave.Cancelada\" WHERE id=:id";
		else
			$sql = "UPDATE Usuarios SET activo=1,clave=\"1234\" WHERE id=:id";
		//$sql = "delete FROM Usuarios WHERE id=$id";
		//echo "<p>SQL:$sql</p>";
                $st = $this->pdo->prepare($sql);
                $st->bindParam(":id",$id);
                
		return $st->execute();
	}

	function InsertarFoto($ruta,$id)
        {
                $this->conecta();
                $sql = "UPDATE USUARIOS SET FOTO='$ruta' WHERE ID=$id";
                $res = mysql_query($sql);
                return $res;
        }

        // funcion que envia mail
        function EnviaMail($to,$nombrefrom,$from,$subject,$message)
        {
                $headers.= "MIME-Version: 1.0\r\n";
                $headers.= "Content-type: text/html; charset=iso-8859-1\r\n";
                $headers.= "From: ".$nombrefrom."<".$from.">\r\n";
                $headers.= "Reply-To: \r\n";
                $headers.= "X-Priority: 1\r\n";
                $headers.= "X-MSMail-Priority: High\r\n";
                $headers .= "X-Mailer: sun1.e-money.cl";
                if(!mail($to, $subject, $message, $headers))
                {
                       $msg = "El Mail No se pudo enviar";
                       return $msg;
                }
                $msg = "Enviando Mail a $to\n";
                return $msg;
        }
	function NotificarClave($tmp){
		$this->conecta();
		$laclave = $tmp->getClave();
		$mensaje = "Fecha:".date("Y-m-d");
		$mensaje.= "\nSu clave para acceder la Intranet es \"$laclave\"\n";
		$mensaje.= "Atte. \n Intranet RuzVukasovic";
		$to      = $tmp->getEMail();
		$nombre  = $tmp->getNombre();
		$from    = $tmp->getEMail();
		$tema    = "Clave Intranet";
		$this->EnviaMail($to,$nombre,$from,$tema,$mensaje);
	}
        // funcion que genera una Password aleatoria!!!
        function makePass()
        {
                $makepass="";
                $syllables="er,in,tia,wol,fe,pre,vet,jo,nes,al,len,son,cha,ir,ler,bo,ok,tio,nar,sim,ple,bla,ten,toe,cho,co,lat,spe,ak,er,po,co,lor,pen,cil,li,ght,wh,at,the,he,ck,is,mam,bo,no,fi,ve,any,way,pol,iti,cs,ra,dio,sou,rce,sea,rch,pa,per,com,bo,sp,eak,st,fi,rst,gr,oup,boy,ea,gle,tr,ail,bi,ble,brb,pri,dee,kay,en,be,se";
                $syllable_array=explode(",", $syllables);
                srand((double)microtime()*1000000);
                for ($count=1;$count<=4;$count++)
                {
                        if (rand()%10 == 1)
                        {
                                $makepass .= sprintf("%0.0f",(rand()%50)+1);
                        }
                        else
                        {
                                $makepass .= sprintf("%s",$syllable_array[rand()%62]);
                        }
                }
                return($makepass);
        }

	//funcion que retorna un numero random
	//basado en la funcion microtime
	//tiene un largo de 17 caracteres
	function ticks()
	{
        	$tiempo = microtime();
	        $tiempo = str_replace("0.","",$tiempo);
		$aux = split(" ",$tiempo);
		$stick = $aux[1].$aux[0];
		return $stick;
	}

	// Busca un id de un record por el campo insert_ticks
	// Si no encuentra id retorna -1
	function buscaIdPorTicks($ticks,$tabla)
	{
            $sql = "SELECT id FROM $tabla WHERE insertticks='$ticks'";
            $result=mysql_query($sql);
            if ($view_campo = mysql_fetch_array($result))
            {
                    return $view_campo[id];
            }
            else
            {
                    return -1;
            }
	}
	function updateClave($id,$clave_old,$clave_new){
		$u = $this->ElUsuario($id);
		$clave = $u->getClave();
		$clave_vieja = $u->getUltClave();
		if ($clave==$clave_old && $clave_vieja!=$clave_new){
			$sql = "update Usuarios set clave='$clave_new',modClave=now(),ultClave='$clave_old' where id=$id";
			//echo "<p>SQL:$sql</p>";
			$rs = $this->query($sql);
			if ($rs){
				return true;
			} else return false;
		} else {
			return false;
		}
		
	}
        function getMenuNivel($id){
            $sql = " select * from TipoUsuario where id=$id";
            //echo "<p>SQL:$sql</p>";
            $rs = $this->query($sql);
            if($rs){
                $row = $this->getRows($rs);

                $tmp = array();

                $tmp['menu']=$row['menu'];
                $tmp['submenu']=$row['submenu'];
                return $tmp;
            } else return array();
        }
	function uptPerfilMenu($grupo,$menu,$submenu){
		$sql = "update TipoUsuario set menu='$menu',submenu='$submenu' where id = $grupo";
		//echo "<p>SQL: $sql</p>";
		$rs = $this->query($sql);
		if ($rs) return true;
		else return mysql_error();
	}
}
?>
