<?php
/*
*
*
* @package    controllers
* @author     Loredana Bottino <loredana.bottino@libero.it>
* @copyright  
* @version    
* @link       
*
*
*/
class UserController {
    public $username = '';

    private $_userModel = NULL;         // variabile privata contenente l'istanza dell'USERMODEL
    private $_logged = false;           // variabile privata che permette di stabilire se l'utente è loggato o meno
	private static $_istance = NULL;    // variabile privata statica contenente l'istanza della classe stessa


    /*
     *  Questa funzione consente l'implementazione del pattern Singleton. Crea l'istanza della stessa classe, se non esiste,
     *  e la restituisce
     *
     *  @return     UserController      _istance
     *
    */
    public static function getIstance() {
        if (UserController::$_istance == NULL) {
            UserController::$_istance= new UserController();
        }
        return UserController::$_istance;
    }


    /*
     *  Costruttore
    */
    private function __construct() {
        sec_session_start();
        $this->_userModel = UserModel::getIstance();
	} // end __construct()


    /*
     *  Questa funzione, dopo aver effettuato i controlli sulle richieste provenienti dalla vista che gestisce gi utenti,
     *  richiama i metodi appropriati
     *
    */
    public function login() {

        if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' && isset( $_GET[ 'usaction' ] ) && $_GET[ 'usaction' ] == 'login' ) {
            $username = isset( $_POST[ 'username' ] ) ? $_POST[ 'username' ] : false;
            $password = isset( $_POST[ 'password' ] ) ? $_POST[ 'password' ] : false;
            $this->process_login($username, $password); 
        } // l'utente vuole effettuare il login

        elseif( isset( $_GET[ 'usaction' ] ) && $_GET[ 'usaction' ] == 'logout' ){
            unset( $_SESSION[ 'username' ] );
            unset( $_SESSION[ 'logged' ] );
            $_SESSION[ 'message' ] = 'Logout effettuato correttamente';
        } // l'utente vuole effettuare il logout

        elseif( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_GET[ 'usaction' ] ) && $_GET[ 'usaction' ] == 'insert' ) {
            $this->insert();
        } // l'utente ha inserito i campi per la registrazione

        elseif (isset($_GET['usaction']) && $_GET['usaction'] == 'insert') {
            include( './views/user_insert.php' );
        } // l'utente nuovo vuole registrarsi

        elseif( isset( $_SESSION[ 'username' ] ) && isset( $_SESSION[ 'logged' ] ) && $_SESSION[ 'logged' ] ){
                $this->username = $_SESSION[ 'username' ];
                $this->_logged = true;
        }

        $this->redirectToProperArea();
    }// end function login()


    /*
     *  Questa funzione effettua dei controlli sull'username e password inseriti, richiama il metodo
     *  login dell'UserModel e setta la variabile privata _logged a true se il login va a buon fine
     *
     *  @param      string      username, password
     *
    */
    public function process_login($username, $password) {
        if($username != false && $password != false) {
            if($this->_userModel->login($username, $password)) {
                $this->_logged=true;
            }
            else {
               	$_SESSION['message'] = "Errore nel login";
                header('Location: ./catalog.php');
                exit();
            }
        }
        else {
            $_SESSION['message'] = "Invalid Request";
        }
    }// end function process_login()


    /*
     *  Questa funzione effettua il controllo se l'utente ha effettuato il login
     *
     *  @return     bool
     *
    */
    public function isLogged(){
        if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
            $user_id = $_SESSION['user_id'];
            $username = $_SESSION['username'];
            $login_string = $_SESSION['login_string'];
            $user_browser = $_SERVER['HTTP_USER_AGENT'];
            $this->_logged = $this->_userModel->loginCheck($user_id, $username, $login_string, $user_browser);
        }
        return $this->_logged;
    }// end function isLogged()


    /*
     *  Questa funzione, dopo aver effettuato i controlli sui campi in ingresso, richiama il metodo
     *  addUser dell'UserModel per l'inserimento di un nuovo utente
     *
    */
    public function insert() {
        global $user_controller;
            
        if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

            $username = ( !empty( $_POST[ 'username' ] ) ) ? $_POST[ 'username' ] : false;
            $email = ( !empty( $_POST[ 'email' ] ) ) ? $_POST[ 'email' ] : false;
            $password = ( !empty( $_POST[ 'password' ] ) ) ? $_POST[ 'password' ] : false;
            $domanda = $_POST['domanda'];
            $risposta = $_POST ['risposta'];
                
            if( $username === false ){
                $_SESSION['message'] = "L'username è un campo obbligatorio";
                include( './views/user_insert.php' );
                return;
            }
            elseif( $email === false ){
                $_SESSION['message'] = "L'email è un campo obbligatorio";
                include( './views/user_insert.php' );
                return;
            }
            elseif(!preg_match( "/^[a-z0-9_.]+@[a-z0-9_]+\.[a-z]{2,3}$/", $email)) {
                $_SESSION['message'] = "Email non corretta";
                include( './views/user_insert.php' );
                return;
            }
            elseif( $password === false ){
                $_SESSION['message'] = "La password è un campo obbligatorio";
                include( './views/user_insert.php' );
                return;
            }
            else {
                if (!$this->_userModel->check_username($username)) {
                    $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                    $password = hash('sha512', $password.$random_salt);
                    $this->_userModel->addUser( $username, $email, $password, $random_salt, $domanda, $risposta);
                    $_SESSION['message'] = 'Utente correttamente inserito';
                }
                else {
                    $_SESSION[ 'message' ] = 'Username già esistente!
                    Se hai dimenticato la password <a href="?usaction=regenerate">clicca qui</a> per rigenerarla';
                }
                header( 'Location: ./catalog.php');
            }
        }
        else {
            include( './views/user_insert.php' );
        }
    }// end function insert()


    /*
     *  Questa funzione genera viste diverse le l'utente è loggato o meno
    */
    public function redirectToProperArea(){
        $script_file = basename( $_SERVER[ 'SCRIPT_NAME' ] );

        if( $this->isLogged() && $script_file == 'login.php' ){
            header( 'location: ./catalog.php' );
            die();
        }
        elseif( ! $this->isLogged() && ( $script_file == 'catalog.php' && isset( $_GET['action'] ) && $_GET['action'] != 'index' && $_GET['action'] != 'detail' ) ){
            header( 'location: ./login.php' );
            die();
        }
    } // end function redirectToProperArea()


    /*
    *   Questa funzione effettua il logout 
    */
    public function logout() {
        sec_session_stop();
        header('Location: ./catalog.php');
    }// end function logout()


    /*
     *  Questa funzione, dopo aver effettuato i controlli sui campi in ingresso, richiama il metodo
     *  setNewPassword dell'UserModel per rigenerare la password di un utente
     *
    */
    public function regenerate() {
        if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) ) {	
            $username=$_POST['username'];
            if ($username == false) {
            	$_SESSION['message']= "Inserisci l'username";
            	header('Location: ./regenerate.php');
                exit();
            }
            if ($username == "admin") {
                $_SESSION['message'] = "La password dell'admin non può essere rigenerata. Contatta l'amministratore del sistema";
                header('Location: ./catalog.php');
                exit();
            }
            if (!isset($controlli)) {
                $controlli = $this->_userModel->getQuestion($username); // il metodo getQuestion() dell'userModel recupera la domanda segreta
                if ($controlli == false) {
                    $_SESSION['message'] = "L'username non esiste";
                    header('Location: ./catalog.php');
                    exit();
                }
            }
            if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_POST['risposta'], $_POST['newpass'] ) ) {
                $risposta=$_POST['risposta'];
        		$newpass=$_POST['newpass'];
                if ($risposta == $controlli['risposta']) {
                    $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                    $newpass = hash('sha512', $newpass.$random_salt);
                	$this->_userModel->setNewPassword($username, $newpass, $random_salt);
                    $_SESSION['message']= "Password rigenerata correttamente";
                    header('location: ./catalog.php');
                    exit();
                }
                else {
                    $_SESSION['message'] = 'La risposta non è corretta!';
                    header('Location: ./catalog.php');
                    exit();
                }
            }
        }
        include('./views/regenerate.php');    
    } // end function regenerate()

}// end class
