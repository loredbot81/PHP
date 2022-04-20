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
<?php           if(isset($_GET['action']) && $_GET['action'] == 'sviluppi') {
                    include('sviluppi.html');
                }
                elseif(isset($_GET['action']) && $_GET['action'] == 'diagram') {
                	include ('diagram.html');
                }
                elseif (isset($_GET['action']) && $_GET['action'] == 'sorgenti') {
                	include ('sorgenti.php');
                }
                elseif (isset($_GET['action']) && $_GET['action'] == 'login') {
                    if( isset( $_POST['username'], $_POST['password'] ) ) {
                        if( $_POST['username'] == 'admin' && $_POST['password'] == 'lb230481' ) {
                            echo '<a href="sorgenti.zip">Clicca qui per scaricare i sorgenti</a>';
                        }
                   }
                }
                else { ?>
                    <article>
   						Questo progetto, svolto durante la parte del PHP Advanced, riguarda un catalogo prodotti.
            			Più precisamente ho optato per prodotti di tecnologia.<br>
                        L'esercizio assegnato dal tutor consisteva nell'integrare all'applicazione CRUD esistente,
                        un sistema di login, che permettesse anche la registrazione di un nuovo utente e che facesse
                        fronte ad attacchi di tipo Brute Force, e un sistema di secure session.
            			Per realizzare il primo obiettivo ho considerato che vi siano due tipi di utenti:
                        <ul>
                            <li>l'admin possiede i privilegi per poter aggiungere, modificare e cancellare i prodotti.
                                É unico e non è possibile creare un altro utente admin.
                            </li>
                            <li>l'utente generico può registrarsi inserendo username, email e password. La password non
                                viene memorizzata in chiaro ma crittografata con algoritmo
                                <a href="https://it.wikipedia.org/wiki/Secure_Hash_Algorithm">sha512</a>.
                                Una volta effettuato il login (non viene effettuato in automatico dopo la registrazione)
                                può solo visualizzare i prodotti ed, eventualmente, inserirli nel carrello (funzionalità
                                da implementare).
                            </li>
                        </ul>
                        Nel caso in cui un utente non ricordi più la password questa può essere rigenerata. Per una maggiore
                        sicurezza questa opportunità non viene concessa all'admin. Viene suggerito, in questo caso, di contattare
                        l'amministratore del sistema.<br>
                        Non è possibile, invece, cancellare un utente.<br>
                        Da un punto di vista implementativo esso è stato sviluppato seguendo due pattern design:
                        il pattern <strong><em><abbr title="Model-View-Controller">MVC</abbr></em></strong>  
                        e il pattern <strong><em>Singleton</em></strong>.<br>
                        Il primo sintetizza l'essenza della suddivisione di ruoli che il pattern suggerisce: separare
                        nettamente la logica dell'applicazione dalla visualizzazione dei dati, lasciando che
                        l'interfaccia utente sia un mero "template", da cui partono le richieste dell'utilizzatore
                        e verso cui arrivano le informazioni riguardanti le modifiche subite dai dati.<br>
                        Lo schema organizzativo prevede tre distinte entità:<br>
                        <ul>
                            <li><u><strong>Modello</strong></u>: responsabile della gestione dei dati. Esso conosce la struttura
                                dei dati dell'applicazione e implementa tutti i metodi necessari alla loro gestione,
                                compresi quelli per modificare, inserire e cancellare nuove entry. Comunica con il database
                                dato che solo lui conosce la struttura fisica dei record.<br></li>
                            <li><u><strong>Controllore</strong></u>: ascoltatore delle richieste dell'utente. Si occupa di tradurre
                                ogni comando proveniente dagli utilizzatori in chiamate ai metodi del modello.<br></li>
                            <li><u><strong>Viste</strong></u>: rappresentazioni grafiche dei modelli. Forniscono un'interfaccia per
                                l'accesso all'applicazione da parte degli utenti. Parte del suo ruolo è anche di ricevere le
                                richieste degli utilizzatori per poterle trasmettere al controllore.<br></li>
                        </ul>
                        Nello specifico, vi sono due controllori, <u>UserController</u> e <u>CatalogController</u>,
                        che si occupano rispettivamente della gestione degli utenti e della gestione del catalogo.<br>
                        Analogamente vi sono due modelli, <u>UserModel</u> e <u>CatalogModel</u>, che interagiscono con
                        le tabelle degli utenti e dei prodotti.<br>
                        I file <u>catalog_index.php</u>, <u>catalog_create.php</u>, <u>catalog_detail.php</u>,
                        <u>catalog_edit.php</u> definiscono le interfacce per la gestione dei prodotti, mentre
                        <u>user_insert.php</u> e <u>regenerate.php</u> forniscono le viste per la gestione degli
                        utenti.<br>
                        Lo scopo del pattern <strong><em>Singleton</em></strong> è assicurare che una classe abbia una
                        sola istanza e fornire un punto d'accesso globale a tale istanza. Per cui ho deciso di
                        implementarlo per le classi <u>UserController</u>, <u>CatalogController</u>, <u>UserModel</u>,
                        <u>CatalogModel</u> e, soprattutto, per la classe <u>DbConnector</u> in modo da garantire una
                        sola connessione al database.<br>
                        I dati degli utenti e dei prodotti sono memorizzati rispettivamente nelle tabelle <u>users</u>
                        e <u>products</u>. Una terza tabella, <u>login_attempts</u>, memorizza i tentativi di accesso
                        falliti ed è d'ausilio per far fronte ad attacchi di tipo
                        <a href="https://en.wikipedia.org/wiki/Brute-force_attack">Brute Force</a>. Dopo il quinto tentativo
                        fallito nell'arco di due ore, l'utente viene disattivato.<br>
        			</article>
<?php           } ?>
            </section><!-- right -->
        </div><!-- contenuto -->
	</body>
</html>