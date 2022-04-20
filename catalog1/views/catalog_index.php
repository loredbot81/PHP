<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content=".::Corso Front End Back End Developer::.">
		<meta name="Keywords" content="">
		<title>.::Progetto PHP Advanced - Catalogo prodotti::.</title>
		<link type="text/css" href="./css/normalize.css" rel="stylesheet">
		<link type="text/css" href="./css/catalog.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Roboto:100,300,400,500' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		<?php include('header.php'); ?>
        
        <section>
            <div id ="cat">
<?php           if( empty( $products ) ): ?>
                    <h3>Ops... No product Found!</h3>
<?php           else: ?>
                    <div class="message">
<?php                   if( isset( $_SESSION[ 'message' ] ) ){
                            echo $_SESSION[ 'message' ];
                            unset( $_SESSION[ 'message' ] );
                        }
?>
                    </div> <!-- message -->
                    
                    <table>
                        <thead>
                            <tr>
                                <th class="large">Nome</th>
                                <th class="large">Categoria</th>
                                <th class="small">Prezzo</th>
<?php                           if( $_SESSION['username'] == "admin" ): ?>
                                    <th class="small">Azioni</th>
<?php                           endif;?>
                            </tr>
                        </thead>
                        
                        <tbody>
<?php                       foreach( $products as $product ): ?>
                                <tr>
                                    <td>
                                        <a href="?action=detail&product_id=<?php echo $product[ 'product_id' ] ?>">
                                            <?php echo  htmlspecialchars( stripslashes($product[ 'name' ])) ?>
                                        </a>
                                    </td>
                                    <td>
<?php                                   if( ! empty( $product[ 'category' ] ) ) {
                                            echo htmlspecialchars( stripslashes( $product[ 'category' ] ) );
                                        }
                                        else {
                                            echo "n/d";
                                        }
?>                                  </td>
                                    <td>
                                        <?php echo $product[ 'price' ] ?>
                                    </td>
                                    <td>
<?php                                   if( $_SESSION['username'] == "admin"): ?>
                                            <a href="?action=delete&product_id=<?php echo $product['product_id'] ?>">Delete</a>
<?php                                   elseif (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])): ?>
                                            <a href="#"><img src="./img/shopping_cart.png" width="20%"></a>
<?php                                   endif;?>
                                    </td>
                                </tr>
<?php                       endforeach; ?>
                        </tbody>
                    </table>
<?php           endif;
                
                if( $_SESSION['username'] == "admin" ): ?>
                    <p>
                        <a href="?action=create">Add New</a>
                        <a href="?action=edit">Edit Catalog</a>
                    </p>
<?php           endif; ?>
            </div><!-- cat -->
        </section>
    </body>
</html>