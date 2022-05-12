<?php
include_once "model/modelDatos.php";
define('HOST',$db_host);
define('BASE',$db_base);
define('USER',$db_user);
define('PASS',$db_pass);

class Model {

  protected $dbConnection;

  /**
   * Initialize the conenction with the db
   */
  public function __construct(){
    try {
      $this->dbConnection = new PDO('mysql:host='.HOST.';dbname='.BASE.';charset=utf8',USER,PASS); 

    } 
    catch (PDOException $e) {
      $this->createDb();
    } 
    catch (Exception $e) {
      echo "error";
      print "¡Error!: " . $e->getMessage() . "<br/>";
    }
  }

  /**
   * Create DB command
   */
  function createDb(){
    $this->dbConnection = new PDO('mysql:host='.HOST.';dbname=mysql;charset=utf8',USER,PASS); 
    $sentencia = $this->dbConnection->prepare("CREATE DATABASE ".BASE." /*!40100 COLLATE 'latin1_swedish_ci' */;");
    $sentencia->execute();
    try {
      $this->dbConnection = new PDO('mysql:host='.HOST.';dbname='.BASE.';charset=utf8',USER,PASS); 
      $myfile = fopen("model/".BASE.".sql", "r") or die("Error al abrir el archivo!");
      $la_consulta = "";
      while ($line = fgets($myfile)) {
        $posicion = strpos($line,"-- ");
        if($posicion === false){
          $la_consulta .= $line;
          if(strpos($line,";")>0){
            $sentencia = $this->dbConnection->prepare($la_consulta);
            $sentencia->execute();
            $la_consulta = "";    
          }
        }
      }
      
    } 
    catch (PDOException $e) {
      echo "error";      
    } 
    catch (Exception $e) {
      echo "error";
      print "¡Error!: " . $e->getMessage() . "<br/>";
    }
  
    fclose($myfile);
  }

  /**
   * Init transaction
   */
  public function beginTransaction()
  {
      $this->dbConnection->beginTransaction();
  }

  /**
   * Commit transaction
   */
  public function commitTransaction()
  {
      $this->dbConnection->commit();
  }

  /**
   * Reverse transaction
   */
  public function rollBackTransaction(){
      $this->dbConnection->rollBack();
  }
}