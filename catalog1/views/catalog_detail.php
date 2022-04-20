<?php  global $user_controller ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content=".::Corso Front End Back End Developer::.">
		<meta name="Keywords" content="">
		<title>.::Corso Front End Back End Developer::.</title>
		<link type="text/css" href="./css/normalize.css" rel="stylesheet">
		<link type="text/css" href="./css/catalog.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Roboto:100,300,400,500' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
        <?php include ('header.php'); ?>
			
        <div id="detail">

<?php       if( empty( $product ) ): ?>
                <h3>Ops... no product found!</h3>
<?php       else: ?>
                <h3><?php echo htmlspecialchars( stripslashes( $product[ 'name' ] ) ) ?></h3>
                <div class="message">
<?php
                    if( isset( $_SESSION[ 'message' ] ) ){
                        echo $_SESSION[ 'message' ];
                        unset( $_SESSION[ 'message' ] );
                    }
?>
                </div> <!-- message -->

<?php           if( ! empty( $product[ 'description' ] ) ): ?>
                    <span class="description">
                        <b>Description:</b>
                        <p><?php echo htmlspecialchars( stripslashes( $product[ 'description' ] ) ) ?></p>
                    </span>
<?php           endif; ?>

<?php           if( ! empty( $product[ 'category' ] ) ): ?>
                    <span class="category">
                        <b>Category:</b> 
                        <p><?php echo htmlspecialchars( stripslashes( $product[ 'category' ] ) ) ?></p>
                    </span>
<?php           endif;?>
                <span class="price">
                    <b>Price:</b> 
                    <?php echo $product[ 'price' ] ?>
                </span>

<?php       endif;?>

            <p>
                <a href="?action=index">Back to home</a>
            </p>
        </div><!-- detail -->
    </body>
</html>