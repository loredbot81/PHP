<header>
	<div id="topbar">
		<div class="container">
			<nav>
				<ul>
					<li><a href="#">Home</a></li>
					<li><a href="#">Progetto HTML/CSS</a></li>
					<li><a href="#">Progetto PHP Base</a></li>
					<li><a id="pagina_corrente" href="./index.php">Progetto PHP Advanced</a></li>
					<li><a href="../blog">Il mio Blog</a></li>
					<li><a href="#">About Me</a></li>
				</ul>
			</nav>
		</div> <!-- container -->
	</div> <!-- topbar -->
	
	<div class="container">
		<h1>Progetto PHP Advanced</h1>
		<h2>Catalogo prodotti</h2><br>
	</div> <!-- container -->
    
    <div id="login_form">
<?php 	if(!isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) { // se l'utente non è loggato ?> 
            	<form method="POST" action="?usaction=login"> <!-- form per il login -->
                	<label for="username">Username</label>
                	<input type="text" id="username" name="username">
                	<label for="password">Password</label>
                	<input type="password" id="password" name="password">
                	<input type="submit" value="Login">
             	</form>
             	
             	<p> Hai dimenticato la password?<a href="?usaction=regenerate">Clicca qui</a>
              		Non sei registrato? <a href="?usaction=insert">Registrati</a>
              	</p>
<?php	}
        else { // l'utente è loggato
            	echo 'Benvenuto  ' . $_SESSION['username'];
                echo '<a href="?usaction=logout">Logout</a>';
        }
?>
	</div><!-- login_form-->
</header>