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
class CatalogController {
    private $_model = NULL;         // variabile privata contenente l'istanza del CATALOGMODEL
    private static $_istance=NULL;  // varaibile privata statica contenente l'istanza della classe stessa

    /* 
     *  Questa funzione permette l'implementazione del pattern Singleton
     *  @return CatalogController
    */
    public static function getIstance() {
        if ( CatalogController::$_istance == NULL ) {
            CatalogController::$_istance= new CatalogController();
        }
        return CatalogController::$_istance;
    }


    /*
     *   Costruttore
    */
    public function __construct() {
        $this->_model = CatalogModel::getIstance();
    }


    /*
     *   Questa funzione genera la vista del catalogo
    */
    public function index() {
    	global $user_controller;
        $products = $this->_model->getProducts();
        include( './views/catalog_index.php' );
    } // end function index()


    /*
     *   Questa funzione genera la vista con il dettaglio del prodotto selezionato
    */
    public function detail() {
        global $user_controller;
        $id = ( isset( $_GET[ 'product_id' ] ) && intval( $_GET[ 'product_id' ] ) != 0 ) ? $_GET[ 'product_id' ] : false;

        if( $id === false ) {
            $_SESSION['message'] = "Errore nella richiesta; riprovare!";
            return;
        }

        $product = $this->_model->getProduct( $id );

        include( './views/catalog_detail.php' );
    }// end function detail()


    /*
     *   Questa funzione, dopo aver effettuato i dovuti controlli sui campi in ingresso, richiama il metodo
     *   addProduct del CatalogModel per l'inserimento del prodotto
    */
    public function create() {

        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $product['name'] = ( ! empty( $_POST[ 'name' ] ) ) ? $_POST[ 'name' ] : false;
            $product['price'] = ( ! empty( $_POST[ 'price' ] ) ) ? $_POST[ 'price' ] : false;
            $product['description'] = ( ! empty( $_POST[ 'description' ] ) ) ? $_POST[ 'description' ] : false;
            $product['category'] = ( ! empty( $_POST[ 'category' ] ) ) ? $_POST[ 'category' ] : false;

            if ( $product['name'] === false ) {
                $_SESSION['message'] = "Il nome del prodotto è un campo obbligatorio";
                include( './views/catalog_create.php' );
                return;
            }
            elseif ( $product['price'] === false ) {
                $_SESSION['message'] = "Il prezzo del prodotto è un campo obbligatorio";
                include( './views/catalog_create.php' );
                return;
            }
            else {
                $this->_model->addProduct( $product['name'], $product['price'], $product['description'], $product['category'] );
                $_SESSION['message'] = 'Prodotto correttamente inserito';
                header( 'Location: ./catalog.php' );
            }
        }
        else {
            include( './views/catalog_create.php' );
        }
    } // end function create()


    /*
     *   Questa funzione, dopo aver effettuato i controlli sui campi in ingresso, richiama il metodo
     *   updateProducts del CatalogModel per l'aggiornamento dei prodotti
    */
    public function edit() {

        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            if ( ! empty( $_POST['products'] ) ) {
                $products = $_POST['products'];

                foreach ( $products as $id => $product ) {
                    if ( empty( $product['name'] ) ) {
                        $_SESSION['message'] = "Il nome del prodotto " . $id . " è un campo obbligatorio";
                        include ( './views/catalog_edit.php' );
                        return;
                    }
                    elseif ( empty( $product['price'] ) ) {
                        $_SESSION['message'] = "Il prezzo del prodotto " . $id . " è un campo obbligatorio";
                        include ( './views/catalog_edit.php' );
                        return;
                    }
                } // end foreach

                $this->_model->updateProducts( $products );
                $_SESSION['message'] = "Catalogo aggiornato correttamente";
                header( 'Location: ./catalog.php' );
            }
            else {
                $_SESSION['message'] = "No product found!";
                include( './views/catalog_edit.php' );
            }
        }
        else {
            $products = $this->_model->getProducts();
            include( './views/catalog_edit.php' );
        }
    } // end function edit()


    /*
     *   Questa funzione richiama il metodo deleteProduct del CatalogModel per la cancellazione di un prodotto
    */
    public function delete() {
        $id = ( isset( $_GET[ 'product_id' ] ) && intval( $_GET[ 'product_id' ] ) != 0 ) ? (int)$_GET[ 'product_id' ] : false;
        if( $id === false ) {
            $_SESSION['message'] = "Errore nella richiesta; riprovare!";
            return;
        }

        $this->_model->deleteProduct( $id );
        $_SESSION['message'] = 'Prodotto eliminato correttamente';
        header( 'Location: ./catalog.php' );
    }// end function delete)()

} // end class