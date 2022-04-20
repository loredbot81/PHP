<?php  global $user_controller ?>

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
		<?php include ('header.php'); ?>

        <div id="create">
            <h3>Add Product</h3>
            <div class="message">
<?php
                if( isset( $_SESSION[ 'message' ] ) ) {
                    echo $_SESSION[ 'message' ];
                    unset( $_SESSION[ 'message' ] );
                }
?>
            </div> <!-- message -->

            <form method="POST" action=""> <!-- form per l'inserimento del prodotto-->
                <label for="name">Nome:</label><br>
                <input type="text" name="name" id="name" value="<?php echo isset( $product['name'] ) ? $product['name'] : '' ?>"><br>
                <label for="price">Prezzo:</label><br>
                <input type="number" step="0.01" name="price" id="price" value="<?php echo isset( $product['price'] ) ? $product['price'] : '' ?>"><br>
                <label for="category">Categoria:</label><br>
                <input type="text" name="category" id="category" value="<?php echo isset( $product['category'] ) ? $product['category'] : '' ?>"><br>
                <label for="description">Descrizione:</label><br>
                <textarea name="description"><?php echo isset( $product['description'] ) ? $product['description'] : '' ?></textarea><br>
                <input type="submit" value="Save">
            </form>

            <p>
                <a href="./catalog.php">Back to home</a>
            </p>
        </div> <!-- create -->
    </body>
</html>
