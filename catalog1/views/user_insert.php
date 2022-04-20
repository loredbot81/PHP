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
            <h3>Add User</h3>

            <div class="message">
                
<?php           if( isset( $_SESSION[ 'message' ] ) ){
                    echo $_SESSION[ 'message' ];
                    unset( $_SESSION[ 'message' ] );
                }
?>
            </div> <!-- message -->

            <form method="POST" action="?usaction=insert"> <!-- form per l'inserimento di un nuovo utente -->
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" value="<?php echo isset( $username ) ? $username : '' ?>"><br>
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" value="<?php echo isset( $email ) ? $email : '' ?>"><br>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password"><br>
                <select name="domanda" id="domanda">
                    <option value="Qual è il cognome da nubile di tua madre?">Qual è il cognome da nubile di tua madre?</option>
                    <option value="Qual è il nome del tuo migliore amico?">Qual è il nome del tuo migliore amico?</option>
                    <option value="Qual è il nome del tuo animale domestico?">Qual è il nome del tuo animale domestico?</option>
                </select>
                <label for="risposta">Risposta:</label>
                <input type="text" name="risposta" id="risposta"><br>
                <input type="submit" value="Save">
            </form>

            <p>
                <a href="./catalog.php">Back to home</a>
            </p>
        </div> <!-- cat -->
    </body>
</html>