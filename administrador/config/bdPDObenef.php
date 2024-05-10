<?php

class TransactionSCI 
{

private $DB_HOST = 'localhost'; //localhost server 
private $DB_NAME = 'bd_bha_sci'; //database name
private $DB_USER = 'root'; //database username
private $DB_PASSWORD = ''; //database password 

	/**
     * PDO instance
     * @var PDO 
     */
	private $pdo;
	//private $conn;

  	/**
     * Open the database connection
     */
  	public function __construct() {
  		$this->Connect();  	 

  	}

  	public function Connect() {
  	    // open database connection
  		$dsn = 'mysql:host=' . $this->DB_HOST . ';dbname=' . $this->DB_NAME;
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');            
  		//echo "Connected successfully";  		

        try {
           $this->pdo = new PDO($dsn, $this->DB_USER, $this->DB_PASSWORD, $opciones);
       } catch (PDOException $e) {
           die($e->getMessage());
       }
   }

    public function select_beneficiarios($query, $usuario) {
        try {               
            // calling stored procedure command
            //$sql = 'CALL SP_SelectNombresConDigitos()';
            $sql = "CALL " .$query. "('".$usuario."')";
            // prepare for execution of the stored procedure
            $stmt = $this->pdo->prepare($sql);                  
            // execute the stored procedure
            $stmt->execute();
            $data=$stmt->fetchAll();            
            $stmt->closeCursor();
            return $data;
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
        return null;
    }

    public function buscar_beneficiario($query, $codigo) {
        try {               
            // calling stored procedure command
            //$sql = 'CALL SP_SelectNombresConDigitos()';
            $sql = "CALL " .$query. "('".$codigo."')";
            // prepare for execution of the stored procedure
            $stmt = $this->pdo->prepare($sql);                  
            // execute the stored procedure
            $stmt->execute();
            $data=$stmt->fetchAll();            
            $stmt->closeCursor();
            return $data;
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
        return null;
    }
    public function Insert_beneficiario($d_01, $d_02, $d_03, $d_04, $d_05, $d_06, $d_07, $d_08, $d_09, $d_10, $d_11, $d_12, $d_13, $d_14, $d_15, $d_16, $d_17, $d_18, $d_19, $d_20, $d_21, $d_22) {
        try {
            $sql = "CALL SP_Insert_beneficiario('".$d_01."','".$d_02."','".$d_03."','".$d_04."','".$d_05."','".$d_06."','".$d_07."','".$d_08."','".$d_09."','".$d_10."','".$d_11."','".$d_12."','".$d_13."','".$d_14."','".$d_15."','".$d_16."','".$d_17."','".$d_18."','".$d_19."','".$d_20."','".$d_21."','".$d_22."', @total)";
            $row=0;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $row = $this->pdo->query("SELECT @total AS resultado")->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $row["resultado"];
        } catch (PDOException $e) {
            die("Error ocurrido:" . $e->getMessage());
        }
        //echo 'Error <br>';
        return null;
    }

    public function Insert_encuesta($d_01, $d_02, $d_03, $d_04, $d_05, $d_06, $d_07) {
        try {
            $sql = "CALL SP_Insert_encuesta(@total,'".$d_01."','".$d_02."','".$d_03."','".$d_04."','".$d_05."','".$d_06."',".$d_07.")";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (PDOException $e) {
            die("Error ocurrido:" . $e->getMessage());
        }
        //echo 'Error <br>';
        return null;
    }

    public function Insert_comunicacion($d_01, $d_02, $d_03, $d_04, $d_05, $d_06, $d_07, $d_08, $d_09, $d_10, $d_11, $d_12, $d_13, $d_14, $d_15) {
        try {
            $sql = "CALL SP_Insert_comunicacion(@total,'".$d_01."','".$d_02."','".$d_03."','".$d_04."','".$d_05."','".$d_06."','".$d_07."','".$d_08."','".$d_09."','".$d_10."','".$d_11."','".$d_12."','".$d_13."','".$d_14."',".$d_15.")";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (PDOException $e) {
            die("Error ocurrido:" . $e->getMessage());
        }
        //echo 'Error <br>';
        return null;
    }

    public function Insert_nutricion($d_01, $d_02, $d_03, $d_04, $d_05, $d_06, $d_07, $d_08, $d_09) {
        try {
            $sql = "CALL SP_Insert_nutricion(@total,'".$d_01."','".$d_02."','".$d_03."','".$d_04."','".$d_05."','".$d_06."','".$d_07."','".$d_08."',".$d_09.")";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (PDOException $e) {
            die("Error ocurrido:" . $e->getMessage());
        }
        //echo 'Error <br>';
        return null;
    }    

    public function Insert_educacion($d_01, $d_02, $d_03, $d_04, $d_05, $d_06, $d_07, $d_08, $d_09, $d_10, $d_11, $d_12, $d_13) {
        try {
            $sql = "CALL SP_Insert_educacion(@total,'".$d_01."','".$d_02."','".$d_03."','".$d_04."','".$d_05."','".$d_06."','".$d_07."','".$d_08."','".$d_09."','".$d_10."','".$d_11."','".$d_12."',".$d_13.")";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (PDOException $e) {
            die("Error ocurrido:" . $e->getMessage());
        }
        //echo 'Error <br>';
        return null;
    }    

    public function Insert_salud($d_01, $d_02, $d_03, $d_04, $d_05) {
        try {
            $sql = "CALL SP_Insert_salud(@total,'".$d_01."','".$d_02."','".$d_03."','".$d_04."',".$d_05.")";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (PDOException $e) {
            die("Error ocurrido:" . $e->getMessage());
        }
        //echo 'Error <br>';
        return null;
    }    

    public function Insert_derivacion_sectores($d_01, $d_02, $d_03, $d_04, $d_05, $d_06, $d_07) {
        try {
            $sql = "CALL SP_Insert_derivacion_sectores(@total,'".$d_01."','".$d_02."','".$d_03."','".$d_04."','".$d_05."','".$d_06."',".$d_07.")";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (PDOException $e) {
            die("Error ocurrido:" . $e->getMessage());
        }
        //echo 'Error <br>';
        return null;
    }    

    public function Insert_estatus($d_01, $d_02, $d_03) {
        try {
            $sql = "CALL SP_Insert_estatus(@total,'".$d_01."','".$d_02."','".$d_03."')";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (PDOException $e) {
            die("Error ocurrido:" . $e->getMessage());
        }
        //echo 'Error <br>';
        return null;
    }    

    public function Insert_integrantes($d_01, $d_02, $d_03, $d_04, $d_05, $d_06, $d_07, $d_08, $d_09, $d_10, $d_11, $d_12, $d_13, $d_14, $d_15, $d_16, $d_17, $d_18, $d_19, $d_20, $d_21, $d_22, $d_23, $d_24, $d_25, $d_26, $d_27, $d_28, $d_29, $d_30, $d_31, $d_32, $d_33, $d_34, $d_35, $d_36, $d_37, $d_38, $d_39, $d_40, $d_41, $d_42, $d_43, $d_44, $d_45, $d_46, $d_47, $d_48, $d_49, $d_50, $d_51, $d_52, $d_53, $d_54, $d_55, $d_56, $d_57, $d_58, $d_59, $d_60, $d_61, $d_62, $d_63, $d_64, $d_65, $d_66, $d_67, $d_68, $d_69, $d_70, $d_71) {
        try {
            $sql = "CALL SP_Insert_integrantes(@total,'".$d_01."','".$d_02."','".$d_03."','".$d_04."','".$d_05."','".$d_06."','".$d_07."','".$d_08."','".$d_09."','".$d_10."','".$d_11."','".$d_12."','".$d_13."','".$d_14."','".$d_15."','".$d_16."','".$d_17."','".$d_18."','".$d_19."','".$d_20."','".$d_21."','".$d_22."','".$d_23."','".$d_24."','".$d_25."','".$d_26."','".$d_27."','".$d_28."','".$d_29."','".$d_30."','".$d_31."','".$d_32."','".$d_33."','".$d_34."','".$d_35."','".$d_36."','".$d_37."','".$d_38."','".$d_39."','".$d_40."','".$d_41."','".$d_42."','".$d_43."','".$d_44."','".$d_45."','".$d_46."','".$d_47."','".$d_48."','".$d_49."','".$d_50."','".$d_51."','".$d_52."','".$d_53."','".$d_54."','".$d_55."','".$d_56."','".$d_57."','".$d_58."','".$d_59."','".$d_60."','".$d_61."','".$d_62."','".$d_63."','".$d_64."','".$d_65."','".$d_66."','".$d_67."','".$d_68."','".$d_69."','".$d_70."',".$d_71.")";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (PDOException $e) {            
            die("Error ocurrido:" . $e->getMessage());
        }
        //echo 'Error <br>';
        return null;
    }    


    public function Update_General($d_01, $d_02, $d_03, $d_04, $d_05, $d_06, $d_07, $d_08, $d_09, $d_10, $d_11, $d_12, $d_13) {
        try {
            $sql = "CALL SP_Update_General('".$d_01."','".$d_02."','".$d_03."','".$d_04."','".$d_05."','".$d_06."','".$d_07."','".$d_08."','".$d_09."','".$d_10."','".$d_11."','".$d_12."','".$d_13."', @total)";
            $row=0;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $row = $this->pdo->query("SELECT @total AS resultado")->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $row["resultado"];
        } catch (PDOException $e) {
            die("Error ocurrido:" . $e->getMessage());
        }
        //echo 'Error <br>';
        return null;
    }

    public function limpiarTabla($tabla,$usuario) {
        try {
            // calling stored procedure command
            $sql = "CALL " . $tabla . "('".$usuario."',@total)";
            // prepare for execution of the stored procedure
            $stmt = $this->pdo->prepare($sql);
            // execute the stored procedure
            $stmt->execute();
            $stmt->closeCursor();
             // execute the second query to get customer's level
            $row = $this->pdo->query("SELECT @total AS resultado")->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row !== false ? $row['resultado'] : null;
            }
            //echo 'La operación se realizo satisfactoriamente';
            return true;
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
        return null;
    }

    public function validar_fecha_espanol($fecha){
        $valores = explode('-', $fecha);
        if(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])){
            return true;
        }
            return false;
    }


	/**
     * close the database connection
     */
	public function __destruct() {
        // close the database connection
		$this->pdo = null;
	}

}


?>