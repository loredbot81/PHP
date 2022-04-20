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

        <?php include ('header.php') ?>

        <div id="edit">
            <h3>Catalog edit</h3>

            <div class="message">
<?php           if( isset( $_SESSION[ 'message' ] ) ){
                    echo $_SESSION[ 'message' ];
                    unset( $_SESSION[ 'message' ] );
                }
?>
            </div> <!-- message -->

<?php       if( ! empty( $products ) ): ?>
                <form action="" method="POST"> <!-- form per la modifica dei prodotti-->
<?php               foreach( $products as $product ): ?>
                        <?php $id = $product['product_id'] ?>
                        <span>[<?php echo $id ?>]</span>
                        <label for="name_<?php echo $id ?>">Nome:</label>
                        <input type="text" name="products[<?php echo $id?>][name]" id="name_<?php echo $id ?>" value="<?php echo $product['name'] ?>">
                        <label for="price_<?php echo $id ?>">Prezzo:</label>
                        <input type="number" step="0.01" name="products[<?php echo $id?>][price]" id="price_<?php echo $id ?>" value="<?php echo $product['price'] ?>">
                        <label for="category_<?php echo $id ?>">Categoria:</label>
                        <input type="text" name="products[<?php echo $id?>][category]" id="category_<?php echo $id ?>" value="<?php echo $product['category'] ?>">
                        <label for="desc_<?php echo $id ?>">Descrizione:</label>
                        <input type="text" name="products[<?php echo $id?>][description]" id="desc_<?php echo $id ?>" value="<?php echo $product['description'] ?>"><br>
<?php               endforeach; ?>
                    <input type="submit" value="Save">
                </form>
<?php       else: ?>
                <p>No product to edit!</p>
<?php       endif;?>

            <p>
                <a href="./catalog.php">Back to home</a>
            </p>
        </div><!-- edit -->
    </body>
</html>