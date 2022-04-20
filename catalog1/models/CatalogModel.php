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

class CatalogModel{
    private $_dbConnector = NULL;       // variabile privata di tipo DB_CONNECTOR che consente l'interazione con il database
    private static $_istance = NULL;    // variabile privata statica che contiene l'istanza della classe stessa


    /*
     *  Questa funzione consente l'implementazione del pattern Singleton. Crea l'istanza della stessa classe, se non esiste,
     *  e la restituisce
     *
     *  @return     CatalogModel     istance
     *
    */
    public static function getIstance() {
        if (CatalogModel::$_istance == NULL) {
            CatalogModel::$_istance = new CatalogModel();
        }
        return CatalogModel::$_istance;
    }// end function getIstance()


    /*
     *  Costruttore
    */
    public function __construct(){
        $this->_dbConnector = DbConnector::getIstance();
    }// end __construct()


    /*
     *  Questa funzione restituisce tutti i prodotti presenti nel database sotto forma di array multidimensionale
     *
     *  @return     array       products
     *
    */
    public function getProducts(){
        $product_id=0;
        $name='';
        $category='';
        $description='';
        $price=0;

        $query = "SELECT * FROM products";

        $this->_dbConnector->prepareStatement( $query );
        
        $this->_dbConnector->execStatement();

        $this->_dbConnector->storeStatementResult();
        
        $stmtNumRows = $this->_dbConnector->statementNumRows();

        $this->_dbConnector->bindStatementResult( array(&$product_id, &$name, &$category, &$description, &$price));
        
        if( $stmtNumRows != 0 ){
            while( $this->_dbConnector->fetchStatement() ){
                $products[] = array('product_id'=>$product_id, 'name'=>$name, 'category'=>$category, 'description'=>$description, 'price'=>$price);
            }
        }

        $this->_dbConnector->closeStatement();
        
        return $products;
    }// end function getProducts()


    /*
     *  Questa funzione restituisce il prodotto cercato sotto forma di array
     *
     *  @param      int     id
     *  @return     array   product
     *
    */
    public function getProduct( $id ){
        $product_id=0;
        $name='';
        $category='';
        $description='';
        $price=0;
            
        $query= "SELECT * FROM products WHERE id=?";
        $param_type="i";

        $this->_dbConnector->prepareStatement($query);
        
        $this->_dbConnector->bindParamsToStatement($param_type, array(&$id));
        
        $this->_dbConnector->execStatement();
        
        $this->_dbConnector->storeStatementResult();
        
        $stmtNumRows = $this->_dbConnector->statementNumRows();
        
        $this->_dbConnector->bindStatementResult( array(&$product_id, &$name, &$category, &$description, &$price));

        if( $stmtNumRows == 1){
            $this->_dbConnector->fetchStatement();
            $product = array('product_id'=>$product_id, 'name'=>$name, 'category'=>$category, 'description'=>$description, 'price'=>$price);
        }
        
        $this->_dbConnector->closeStatement();
        
        return $product;
    }// end function getProduct()


    /*
     *  Questa funzione inserisce un nuovo prodotto nella tabella products
     *
     *  @param      string      name
     *  @param      double      price
     *  @param      string      descrizione     optional
     *  @param      string      category        optional
     *
    */
    public function addProduct( $name, $price, $desc = false, $category = false ){
        
        $query = "INSERT INTO products (name, category, description, price) VALUES (?, ?, ?, ?)";
        $param_type = 'sssd';

        $this->_dbConnector->prepareStatement($query);
        
        $this->_dbConnector->bindParamsToStatement($param_type, array(&$name, &$category, &$desc, &$price));
        
        $this->_dbConnector->execStatement(); 
    }// end function addProduct()


    /*
     *  Questa funzione effettua l'aggiornamento dei prodotti
     *
     *  @param      array       products
    */
    public function updateProducts( $products ){
        $id = 0;
        $name = '';
        $price = 0;
        $category = '';
        $description = 0;

        $query = "UPDATE products SET name = ?, category = ?, description = ?, price = ? WHERE id = ?";

        $param_type = 'sssdi';

        $this->_dbConnector->prepareStatement( $query );

        $this->_dbConnector->bindParamsToStatement( $param_type, array( &$name, &$category, &$description, &$price, &$id ) );

        foreach ( $products as $key => $product ) { // poichè i prodotti da aggiornare vengono passati attraverso un array
            extract( $product );                    // occorre effettuare prima un extract del singolo prodotto
            $id = $key;
            $this->_dbConnector->execStatement();
        }

        $this->_dbConnector->closeStatement();
    }// end function updateProducts()


    /*
     *  Questa funzione effettua la cancellazione del prodotto selezionato
     *
     *  @param      int     id_product
     *
    */
    public function deleteProduct( $product_id ){
        $query = "DELETE FROM products WHERE id = ?";
        $param_type = 'i';

        $this->_dbConnector->prepareStatement($query);
        
        $this->_dbConnector->bindParamsToStatement($param_type, array(&$product_id));
        
        $this->_dbConnector->execStatement();
        
        $this->_dbConnector->closeStatement();
    } // end function deleteProduct();

}// end class