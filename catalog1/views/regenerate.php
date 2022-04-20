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
		
        <div id="cat">
            <h3>Regenerate password</h3>

            <div class="message">
<?php           if( isset( $_SESSION[ 'message' ] ) ){
                    echo $_SESSION[ 'message' ];
                    unset( $_SESSION[ 'message' ] );
                }
?>
            </div> <!-- message -->

            <p>
                Inserisci l'username per recuperare la domanda segreta
            </p>
            
            <form method="POST" action="?usaction=regenerate">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $controlli['username'] ?>"><br>

<?php           if ($controlli) :   ?>
                    Rispondi alla domanda segreta<br>
                    <?php echo $controlli['domanda'] ?>
                    <input type="text" id="risposta" name="risposta"><br>
                    <label for="password">Imposta nuova password:</label>
                    <input type="password" name="newpass" id="newpass"><br>
<?php           endif; ?>

                <input type="submit" value="Recupera">
            </form>

            <p>
                <a href="./catalog.php">Back to home</a>
            </p>
        </div> <!-- cat -->
    </body>
</html>