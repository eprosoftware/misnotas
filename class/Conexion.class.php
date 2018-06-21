<?php
class Conexion
{
    var $link_id;
    var $pdo;
    
    function Conexion()
    {
        $this->conecta_pdo();
    }

    function conecta($host="",$dbuser="",$dbpass="",$db="")
    {
        return $this->conecta_pdo($host, $dbuser, $dbpass, $db);
        /*
            //echo HOST."-".DB_USER."-".DB_PASS."--".DB;
            if ($hosts && $dbuser && $dbpass && $db){
                    $this->liNk_id = mysql_connect($host, $dbuser, $dbpass, false, 65536);
                    mysql_select_db($db);
            } else {
                    $this->liNk_id = mysql_connect(HOST, DB_USER, DB_PASS, false, 65536);
                    mysql_select_db(DB);
            }
            $link_id = $this->liNk_id;

            //mysql_query("SET CHARACTER SET latin1");
            //mysql_query("SET NAMES latin1");

            return $link_id;
         
         */
    }
    function conecta_pdo($host="",$dbuser="",$dbpass="",$db=""){
        //echo HOST."-".DB_USER."-".DB_PASS."--".DB;
        $dsn = "mysql:host=$host;dbname=$db";
        try {
            if ($host && $dbuser && $dbpass && $db){
                $this->pdo = new PDO($dsn, $dbuser, $dbpass);//, $options);
            } else {
                $dsn = "mysql:host=".HOST.";dbname=".DB;
                $this->pdo = new PDO($dsn, DB_USER, DB_PASS);//, $options);
            }
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "ERROR PDO: " . $e->getMessage();
        }
        
    }

    function Error()
    {
            if (mysql_errno()!=0)
            {
                    echo "<h1><font face='arial, helvetica' color='darkblue'>";
                    echo "Ha ocurrido un error en la operacion realizada</font></h1><br>\n";
                    echo "<H2><font face='arial, helvetica' color='darkred'>Error ".mysql_errno() .":".mysql_error()."</font></H2>\n";
                    RETURN(1);
            }
            else
            {
                    RETURN(0);
            }
    }

    function desconecta($rs)
    {
            mysql_close($rs);
    }
    function query($sql){
        $rs = $this->query_pdo($sql);
            //$rs = mysql_query($sql);
        return $rs;
    }
    function query_pdo($sql){
        $rs = $this->pdo->query($sql);
        //echo "E:".print_r($this->pdo->errorInfo());
        return $rs;
    }
    function close($rs){
            //if(mysql_close($rs)) return 1; else return 0;
    }
    function getRows($rs){
        //$row = mysql_fetch_array($rs);
        $row = $rs;
        return $row;
    }
    function getRows_pdo($rs){
            $row = $rs->fetchAll();
            //echo "<p>".print_r($row)."</p>";
            return $row;
    }    
    function getRow($rs){
            $field = mysql_fetch_field($rs);
            return $field;
    }
    function db_error(){
            return mysql_error();
    }
    function EjecutaSP($nombre,$parametros){
            $procedimiento="call ".$nombre."(".$parametros.");";
            //echo "<br>".$procedimiento;
            $this->ExecuteConsulta($procedimiento);	
            if (!$this->_ConsultaId) 
            {
                    $mensaje  = 'Fallo al ejecutar procedimiento: '.$nombre."<BR>";
                    $mensaje .= 'MySql Error: ' .mysql_error();
                    die($mensaje);
                    }
                    return $this->_ConsultaId;
    }
    
    public static function interpolateQuery($query, $params) {
        $keys = array();

        # build a regular expression for each parameter
        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $keys[] = '/:'.$key.'/';
            } else {
                $keys[] = '/[?]/';
            }
            if (is_string($value))
                $values[$key] = "'" . $value . "'";

            if (is_array($value))
                $values[$key] = "'" . implode("','", $value) . "'";

            if (is_null($value))
                $values[$key] = 'NULL';            
        }

        $query = preg_replace($keys, $params, $query, 1, $count);

        #trigger_error('replaced '.$count.' keys');

        return $query;
    }    
}
// FIN CLASS
?>
