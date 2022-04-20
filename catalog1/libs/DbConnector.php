<?php
/*
*
*
* @package    libs
* @author     Loredana Bottino <loredana.bottino@libero.it>
* @copyright  
* @version    
* @link       
*
*
*/

class DbConnector {

    private $_conn = NULL;              // variabile privata di tipo MYSQLI contenente la connessione al database
    private $_statement = NULL;         // variabile privata di tipo MYSQLI_STMT contenente la prepared statement
	private static $_istance = NULL;    // variabile privata statica contenente l'istanza della classe stessa


     /*
     *  Questa funzione consente l'implementazione del pattern Singleton. Crea l'istanza della stessa classe, se non esiste,
     *  e la restituisce
     *
     *  @return     DbConnector     istance
     *
    */
    public static function getIstance() {
        if (DbConnector::$_istance == NULL) {
            DbConnector::$_istance = new DbConnector();
        }
        return DbConnector::$_istance;
    }
    
    /*
    *   Costruttore. Crea la connessione con il database
    */
    private function __construct(){
        $this->_conn = new mysqli( DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME );
    }

    
    // -- FUNZIONI RELATIVE ALLA PREPARED STATEMENT --

    /*
    *   Questa funzione prepara la statement con la query passata come parametro
    *
    *   @param      string      query   --> la query da eseguire
    *
    */
    public function prepareStatement( $query ){
        $this->_statement = $this->_conn->prepare( $query );
    }


    /*
    *   Questa funzione effettua il bind dei parametri, ovvero associa ad ogni '?' della statement il parametro passato
    *
    *   @param      string       type        --> rappresenta i tipi dei parametri
    *   @param      array        params      --> array contenente i parametri da associare
    *
    */
    public function bindParamsToStatement( $type, $params ){
        call_user_func_array( array( $this->_statement, 'bind_param' ), array_merge( (array) $type, $params ) );
    }


    /*
    *   Questa funzione esegue la statement
    */
    public function execStatement(){
        return $this->_statement->execute();
    }


    /*
    *   Questa funzione effettua il buffer del set risultato dell'esecuzione, così che la successiva funzione di fetch può restituirli
    */
    public function storeStatementResult() {
        return $this->_statement->store_result();   
    }


    /*
    *   Questa funzione effettua il bind dei risultati, ovvero associa i vari campi ad un array di variabili
    *
    *   @param      array       var     --> array contenente i riferimenti alle variabili con cui fare l'associazione
    *
    */
    public function bindStatementResult($var) {
        $bind_result_res=call_user_func_array ( array($this->_statement, 'bind_result'), $var);
        if(!$bind_result_res) {
            echo "Error with binding result";
            die();
        }
    }


    /*
    *   Questa funzione carica il set della statement nelle variabili associate con il bind
    */
    public function fetchStatement() {
        return $this->_statement->fetch();
    }


    /*
    *   Questa funzione restituisce il numero di righe del risultato della statement
    */
    public function statementNumRows() {
        return $this->_statement->num_rows;
    }
    

    /*
    *   Questa funzione chiude la statement e dealloca la statement trattata
    */
    public function closeStatement(){
        $this->_statement->close();
    }

    // -- FINE FUNZIONI PREPARED STATEMENT --

}// end class