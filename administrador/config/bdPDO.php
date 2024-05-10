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

    public function prueba(){
    	if (!$pdo) {
    		die("Connection failed: " . mysqli_connect_error());
    	}
    	echo "Connected successfully....";
    }

    public function limpiarStage($sp,$usuario) {
    	try {
            // calling stored procedure command
    		$sql = "CALL " . $sp . "('".$usuario."',@total)";
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

    public function ejecutarstoredprocedure($sp) {
        try {
            // calling stored procedure command
            $sql = "CALL " . $sp . "(@total)";
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




    public function migrar_data_reporte_tarjetas($sp, $usuario) {
        try {               
            $sql = "CALL " . $sp . "('".$usuario."',@total)";
            $stmt = $this->pdo->prepare($sql);                  
            $stmt->execute();
            $stmt->closeCursor();
            $row = $this->pdo->query("SELECT @total AS resultado")->fetch(PDO::FETCH_ASSOC);
            return$row['resultado'];
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
        return 0;
    }

    public function limpiarDataKobo($sp, $usuario) {
        try {               
            $sql = "CALL " . $sp . "('".$usuario."',@total)";
            $stmt = $this->pdo->prepare($sql);                  
            $stmt->execute();
            $stmt->closeCursor();
            $row = $this->pdo->query("SELECT @total AS resultado")->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row !== false ? $row['resultado'] : null;
            } 
            return true;
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
        return null;
    }

    public function validarDataGerencia($sp, $campo) {
        try {               
            // calling stored procedure command
            $sql = "CALL " . $sp . "('".$campo."',@total)";
            // prepare for execution of the stored procedure
            $stmt = $this->pdo->prepare($sql);                  
            // execute the stored procedure
            $stmt->execute();
            $stmt->closeCursor();
             // execute the second query to get customer's level
            $row = $this->pdo->query("SELECT @total AS resultado")->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row['resultado'] == 0 ? 0 : $row['resultado'];
            } 
            //return $row ;
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
        return null;
    }

    public function select_repo($sp,$usuario) {
        try {               
            // calling stored procedure command
            //$sql = 'CALL SP_SelectDocIdentConIncidencias()';
            $sql = "CALL " . $sp . "('".$usuario."')";
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

    public function select_repo_all($sp, $depa) {
        try {               
            // calling stored procedure command
            //$sql = 'CALL SP_SelectDocIdentConIncidencias()';
            $sql = "CALL " . $sp . "('".$depa."')";
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

    public function select_repo_gerencia($sp) {
        try {               
            // calling stored procedure command
            $sql = "CALL " . $sp . "()";
            //$sql = "select * from " .$vista. ";";
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

    public function select_repo_gerencia_gestante($sp, $gestante) {
        try {               
            // calling stored procedure command
            //$sql = "CALL " . $sp . "()";
            $sql = "CALL " . $sp . "(".$gestante.")";
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

    public function select_periodos_data_gerencia() {
        try {               
            //$sql = "select * from vista_periodos_data_proyectos;";
            $sql = "select * from vista_periodo_y_proyecto_migracion_stage_data_proyecto;";
            $stmt = $this->pdo->prepare($sql);                  
            $stmt->execute();
            $data=$stmt->fetchAll();
            $stmt->closeCursor();
            return $data;
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
        return null;
    }

    public function incidencia_Nombres($sp,$usuario) {
        try {               
            // calling stored procedure command
            //$sql = 'CALL SP_SelectNombresConDigitos()';
            $sql = "CALL " . $sp . "('".$usuario."')";
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

// STORED PARA ACTUALIZAR LA INFORMACION DEL STAGE DATA HISTORICA

    public function limpiar_DH($sp,$usuario) {
        try {               
            // calling stored procedure command
            $sql = "CALL " . $sp . "('".$usuario."',@total)";
            // prepare for execution of the stored procedure
            $stmt = $this->pdo->prepare($sql);                  
            // execute the stored procedure
            $stmt->execute();
            $stmt->closeCursor();
             // execute the second query to get customer's level
            $row = $this->pdo->query("SELECT @total AS resultado")->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row['resultado'] == 1 ? 1 : 0;
            } 
            //echo 'La operación se realizo satisfactoriamente';
            return true;
        } catch (PDOException $e) {         
            //die("Error ocurrido: " . $e->getMessage());
            return false;
        }
        return null;
    }

    public function login($usuario, $pass) {
        try {               
            $sql = "CALL SP_Login_validar('".$usuario."','".$pass."',@total)";
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
        return $data;
    }

    public function select_rol($usuario) {
        try {               
            $sql = "CALL SP_user_rol('".$usuario."',@total)";
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
        return $data;
    }

    public function update_observaciones($cod, $comentario) {
        try {               
            // calling stored procedure command
            $sql = "CALL SP_update_observaciones(".$cod.",'".$comentario."',@total)";
            // prepare for execution of the stored procedure
            $stmt = $this->pdo->prepare($sql);                  
            // execute the stored procedure
            $stmt->execute();
            $stmt->closeCursor();
             // execute the second query to get customer's level
            $row = $this->pdo->query("SELECT @total AS resultado")->fetch(PDO::FETCH_ASSOC);
            //echo 'La operación se realizo satisfactoriamente';
            return $row;
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
            return null;
    }

    public function select_usuarios() {
        try {               
            // calling stored procedure command
            //$sql = 'CALL SP_SelectNombresConDigitos()';
            $sql = "CALL SP_Usuarios_Select()";
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

    public function select_usuario($codigo) {
        try {               
            // calling stored procedure command
            $sql = "CALL SP_Usuario_Select(" . $codigo. ")";
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

    public function update_usuario($cod, $nombre, $correo, $idrol, $idestado) {
        try {               
            // calling stored procedure command
            $sql = "CALL SP_Usuario_Update(".$cod.",'".$nombre."','".$correo."',".$idrol.",".$idestado.",@total)";
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

    public function insert_usuario($nombre, $correo, $idrol, $idestado) {
        try {               
            // calling stored procedure command
            $sql = "CALL SP_Usuario_Insert('".$nombre."','".$correo."','123456',".$idrol.",".$idestado.",@total)";
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
            //return true;
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
            return null;
        }

    public function delete_usuario($id) {
        try {               
            // calling stored procedure command
            $sql = "CALL SP_Usuario_Delete(".$id.",@total)";
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
            return true;
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
            return null;
    }

    public function update_password($id,$clave) {
        try {               
            // calling stored procedure command
            $sql = "CALL SP_Usuario_Update_Password(".$id.",".$clave.",@total)";
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

    public function reset_password($usu,$clave) {
        try {               
            // calling stored procedure command
            $sql = "CALL SP_Usuario_Reset_Password('".$usu."','".$clave."',@total)";
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

    public function migrar_data_historica($usuario) {
        try {               
            // calling stored procedure command
            $sql = "CALL SP_Migrar_Data_Historica('".$usuario."',@total)";
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

/*****************
 *  MODULO GERENCIA
 * ***************/
    public function traer_tema() {
        try {               
            // calling stored procedure command
            $sql = "call SP_list_tema();";
            // prepare for execution of the stored procedure
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $arreglo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $arreglo;
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
        return null;
    }

/*****************
 *  REPORTES
 * ***************/
    public function poblar_combobox($sp) {
        try {               
            // calling stored procedure command
            $sql = "CALL " .$sp. "();";
            //$sql = "call SP_reporte_regiones();";
            // prepare for execution of the stored procedure
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $arreglo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $arreglo;
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
        return null;
    }

    public function traer_regiones() {
        try {               
            // calling stored procedure command
            $sql = "call SP_reporte_regiones();";
            // prepare for execution of the stored procedure
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $arreglo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $arreglo;
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
        return null;
    }

    public function traer_datos_reporte() {
        try {               
            // calling stored procedure command
            //$arreglo = array();
            $sql = "call SP_reporte_00()";
            // prepare for execution of the stored procedure
            $stmt = $this->pdo->prepare($sql);
            // execute the stored procedure
            $stmt->execute();
            //$stmt->closeCursor();
            //if ($sql){
            //if ($result = $stmt->execute()){
                //while($rows = $result->fetchAll(\PDO::FETCH_ASSOC)){
                $arreglo = $stmt->fetchAll(PDO::FETCH_ASSOC);
                //}
               return $arreglo;
           //}
            //}
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
        return null;
    }

    public function traer_datos_reporte_sin_parametro($SP, $situacion) {
        try {               
            // calling stored procedure command
            //$arreglo = array();
            $sql = "CALL " .$SP. "('".$situacion."')";
            //$sql = "call SP_reporte_01_beneficiario_x_region_01('".$region."')";
            // prepare for execution of the stored procedure
            $stmt = $this->pdo->prepare($sql);
            // execute the stored procedure
            $stmt->execute();
            $arreglo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $arreglo;
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
        return null;
    }

    public function traer_datos_reporte_parametro($SP, $region, $situacion) {
        try {               
            // calling stored procedure command
            //$arreglo = array();
            $sql = "CALL " .$SP. "('".$region."','".$situacion."')";
            //$sql = "call SP_reporte_01_beneficiario_x_region_01('".$region."')";
            // prepare for execution of the stored procedure
            $stmt = $this->pdo->prepare($sql);
            // execute the stored procedure
            $stmt->execute();
            $arreglo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $arreglo;
        } catch (PDOException $e) {         
            die("Error ocurrido:" . $e->getMessage());
        }
        return null;
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