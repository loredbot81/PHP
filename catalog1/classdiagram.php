<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content=".::Corso Front End Back End Developer::.">
		<meta name="Keywords" content="">
		<title>.::Progetto PHP Advanced - Catalogo prodotti::.</title>
		<link type="text/css" href="./css/normalize.css" rel="stylesheet">
        <link type="text/css" href="css/catalog.css" rel="stylesheet">
		<link type="text/css" href="css/Style.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Roboto:100,300,400,500' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		<header>
			<div id="topbar">
				<div class="container">
					<nav>
						<ul>
							<li><a href="#">Home</a></li>
							<li><a href="#">Progetto HTML/CSS</a></li>
							<li><a href="#">Progetto PHP Base</a></li>
							<li><a id="pagina_corrente" href="#">Progetto PHP Advanced</a></li>
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
        </header>
        
        <div id="contenuto">
            <section class="left">
                <ul>
            	   <li><a href="?action=sviluppi">Ulteriori sviluppi</a></li>
                    <li><a href="?action=diagram">Class Diagram</a></li>
                    <li><a href="?action=sorgenti">Scarica i sorgenti</a></li>
                    <li><a href="catalog.php">Vai al progetto</a>
                </ul>
            </section> <!-- left -->

            <section class="right">
                <img src="img/controllers.jpg"><br>
                <img src="img/models.jpg"><br>
                <img src="img/dbConnector.jpg"><br>
        
            </section><!-- right -->
        </div><!-- contenuto -->
	</body>
</html>