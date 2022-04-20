<?php
/*
*
*
* @package    models
* @author     Loredana Bottino <loredana.bottino@libero.it>
* @copyright  
* @version    
* @link       
*
*
*/
class UserModel {
    private $_dbConnector = NULL;       // variabile privata di tipo DB_CONNECTOR che consente l'interazione con il database
	private static $_istance=NULL;      // variabile privata statica che contiene l'istanza della classe stessa


    /*
     *  Questa funzione consente l'implementazione del pattern Singleton. Crea l'istanza della stessa classe, se non esiste,
     *  e la restituisce
     *
     *  @return     UserModel     istance
     *
    */
    public static function getIstance() {
        if (UserModel::$_istance == NULL) {
            UserModel::$_istance = new UserModel();
        }
        return UserModel::$_istance;
    }// end function getIstance()


    /*
     *  Costruttore
    */
    private function __construct(){
        $this->_dbConnector = DbConnector::getIstance();
    }// end __construct()


    /*
     *  Questa funzione inserisce un nuovo utente nel database
     *
     *  @param      string      username
     *  @param      string      email
     *  @param      string      password
     *  @param      string      salt
     *  @param      string      domanda
     *  @param      string      risposta
     *
    */
    public function addUser($username, $email, $password, $salt, $domanda, $risposta) {
        $query = "INSERT INTO users (username, email, password, salt, domanda, risposta) VALUES (?, ?, ?, ?, ?, ?)";
        $param_type = 'ssssss';

        $this->_dbConnector->prepareStatement($query);
        $this->_dbConnector->bindParamsToStatement($param_type, array(&$username, &$email, &$password, &$salt, &$domanda, &$risposta));
        $this->_dbConnector->execStatement();
    }// end function addUser()


    /*
     *  Questa funzione effettua il login di un utente
     *
     *  @param      string      username
     *  @param      string      password
     *
     *  @return     bool
     *
    */
    public function login($username, $password) {
        $user_id=0;
        $db_username='';
        $db_password='';
        $salt='';

        $query = "SELECT id, username, password, salt FROM users WHERE username = ? LIMIT 1";
        $param_type = 's';
        $this->_dbConnector->prepareStatement( $query );

        $this->_dbConnector->bindParamsToStatement( $param_type, array( &$username ) );
            
        $this->_dbConnector->execStatement();

        $this->_dbConnector->storeStatementResult();

        $stmtNumRows = $this->_dbConnector->statementNumRows();

        $this->_dbConnector->bindStatementResult( array(&$user_id, &$db_username, &$db_password, &$salt));

        $this->_dbConnector->fetchStatement();

        $this->_dbConnector->closeStatement();

        $password = hash('sha512', $password.$salt);
        if($stmtNumRows == 1) {
            if($this->checkBrute($user_id) == true) {
                return false;
            }
            else {
                if($db_password == $password) { // Password corretta!
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    $_SESSION['user_id'] = $user_id;
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
                    return true;
                }
                else {
                    $now = time();
                    $query = "INSERT INTO login_attempts (user_id, time) VALUES (?, ?)";
            		$param_type = 'ii';
            		$this->_dbConnector->prepareStatement($query);
            		$this->_dbConnector->bindParamsToStatement($param_type, array(&$user_id, &$now));
            		$this->_dbConnector->execStatement();
                    return false;
                }
            }
        }
        else {
            return false;
        }
    }// end function login()


    /*
     *  Questa funzione conta i tentativi di accesso falliti per un dato utente
     *
     *  @param      int     user_id
     *
     *  @return     bool
     *
    */
    public function checkBrute($user_id) {
        $now = time();
        $valid_attempts = $now - (2 * 60 * 60);
        $query = "SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'";
        $param_type = 'i';
        $this->_dbConnector->prepareStatement($query);
        $this->_dbConnector->bindParamsToStatement($param_type, array( &$user_id ) ); 
        $this->_dbConnector->execStatement();
        $this->_dbConnector->storeStatementResult();
        $stmtNumRows = $this->_dbConnector->statementNumRows();
        $this->_dbConnector->closeStatement();
        if( $stmtNumRows > 5) {
            return true;
        }
        else {
            return false;
        }
    }// end function checkBrute()


    /*
     *  Questa funzione controlla se la password inserita è corretta
     *
     *  @param      string      user_id
     *  @param      string      username
     *  @param      string      login_string
     *  @param      string      user_browser
     *
    */
    public function loginCheck($user_id, $username, $login_string, $user_browser) {
        $db_password='';
        $query = "SELECT password FROM users WHERE id = ? LIMIT 1";
        $param_type='i';
        $this->_dbConnector->prepareStatement($query);
        $this->_dbConnector->bindParamsToStatement($param_type, array( &$user_id ) );
        $this->_dbConnector->execStatement();
        $stmt = $this->_dbConnector->storeStatementResult();
        if($stmt == 1) {
            $this->_dbConnector->bindStatementResult(array(&$db_password));
            $this->_dbConnector->fetchStatement();
            $login_check = hash('sha512', $db_password.$user_browser);
            if($login_check == $login_string) {
                return true;
            }
            else {
                return false; //la password inserita non è corretta
            }
        }
        else {
            return false; //l'id non esiste
        }
    }// end function loginCheck()
    

    /*
     *  Questa funzione verifica l'esistenza dell'username nel database
     *
     *  @param      string      username
     *
     *  @return      bool
     *
    */
    public function check_username ($username) {

        $query = "SELECT username FROM users WHERE username = ? LIMIT 1";
        $param_type = 's';
        $this->_dbConnector->prepareStatement( $query );

        $this->_dbConnector->bindParamsToStatement( $param_type, array( &$username ) );
            
        $this->_dbConnector->execStatement();

        $this->_dbConnector->storeStatementResult();

        $stmtNumRows = $this->_dbConnector->statementNumRows();
        $this->_dbConnector->closeStatement();

        if($stmtNumRows) {
            return true;
        }
        else {
            return false;
        }
    }// end function check_username()
    

    /*
     *  Questa funzione recupara la domanda segreta dal database per poter rigenerare la nuova password
     *
     *  @param      string      username
     *
     *  @return     bool        false       se l'operazione non è andata a buon fine
     *  @return     array       controlli   se l'operazione è andata a buon fine
     *
    */
    public function getQuestion($username) {
        $query="SELECT domanda, risposta FROM users WHERE username=?";
        $param_type='s';
        $domanda='';
        $risposta='';
            
        $this->_dbConnector->prepareStatement($query);
        $this->_dbConnector->bindParamsToStatement($param_type, array(&$username));
        $this->_dbConnector->execStatement();
        $this->_dbConnector->storeStatementResult();
        $this->_dbConnector->bindStatementResult(array(&$domanda, &$risposta));
        $this->_dbConnector->fetchStatement();
        $stmt = $this->_dbConnector->statementNumRows();
        $this->_dbConnector->closeStatement();
        if($stmt == 0) {
            return false;
        }
        else {
            $controlli = array('username'=>$username, 'domanda'=>$domanda, 'risposta'=>$risposta);
            return $controlli;
        }
    }// end function getQuestion()
    

    /*
     *  Questa funzione modifica la password di un utente
     *
     *  @param      string      username
     *  @param      string      newpass
     *  @param      string      salt
     *
    */  
    public function setNewPassword($username, $newpass, $salt) {
       	$query = "UPDATE users SET password = ?, salt = ? WHERE username = ?";
        $param_type = 'sss';

        $this->_dbConnector->prepareStatement( $query );
        $this->_dbConnector->bindParamsToStatement( $param_type, array( &$newpass, &$salt, &$username ) );
        $this->_dbConnector->execStatement();
        $this->_dbConnector->closeStatement();
    }// end function setNewPassword()

}// end class