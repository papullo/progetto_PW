<?php
	session_start();
   include("funzioni.php");
   if(!isset($_SESSION['sess_utente'])) header("Location:index.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>YourLibrary</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
	</head>
	<body>
        <div id="wrapper">
			<div id="header" class="container">
				<div id="logo">
					<h1>Yourlibrary</h1>
           	</div>
            <div id=\"menu\">
					<ul>
						<li class="current_page_item"><?$_SESSION['sess_utente']?>."</li>
						<li><a href="modPwd.php">Cambia password</a></li>	
						<li><a href="logout.php">logout</a></li>
					</ul>
		   	</div>
		   </div><!-- end #header -->";
		 			 <?include("menu.php"))?>
		 			 	<div id=\"content\">
										<div class=\"post\">
											<h2 class=\"title\">Gestione Dipendenti: </h2>
												<div style=\"clear: both;\">&nbsp;</div>
													<div class=\"entry\">
														<p><a href=\"insDipendenti.php\">Inserimento nuovo dipendente</a> </p>
														<p><a href=\"visDipendenti.php\">Visualizza dipendente</a></p>
														<p><a href=\"cancDipendenti.php\">Rimuovi un dipendente</a></p>
														<p><a href=\"modDipendenti.php\">Modifica dati di un dipendente</a></p>
													</div>
											</div>
										<div class=\"post\">
											<h2 class=\"title\">Gestione Clienti</h2>
												<div style=\"clear: both;\">&nbsp;</div>
													<div class=\"entry\">
													<p><a href=\"visClienti.php\">Visualizza elenco clienti</a></p>
													</div>
										</div>
										<div class=\"post\">
											<h2 class=\"title\">Gestione Eventi:</h2>
												<div style=\"clear: both;\">&nbsp;</div>
													<div class=\"entry\">
														<p><a href=\"insEventi.php\">Inserimento nuovo evento</a></p>
														<p><a href=\"visEventi.php\">Visualizza evento</a></p>
														<p><a href=\"cancEventi.php\">Rimuovi un evento</a></p>
														<p><a href=\"modEventi.php\">Modifica dati di un evento</a></p>
                                                                                                                <p><a href=\"visRelatori.php\">Visualizza relatori</a></p>
													</div>
												</div>
										<div style=\"clear: both;\">&nbsp;</div>
									</div><!-- end #content -->
							</div><!-- end #page -->";
		   			 }
		   			 if($_SESSION['tipo']=="bibliotecario") 
		   			 {
		   			 	echo "
		   			 	<div id=\"page\" class=\"container\">
								<div id=\"marketing\">
									<p class=\"text1\">Categoria utente: bibliotecario</p><p align =\"right\">".date("d/m/y")."<br />
                                                                        <a href=\"azzera.php\">Azzera stampe</a></p>
								</div>
									<div id=\"content\">
										<div class=\"post\">
											<h2 class=\"title\">Gestione Clienti: </h2>
												<div style=\"clear: both;\">&nbsp;</div>
													<div class=\"entry\">
														<p><a href=\"insClienti.php\">Inserimento nuovo cliente</a> </p>
														<p><a href=\"visClienti.php\">Visualizza elenco clienti</a></p>
														<p><a href=\"cancClienti.php\">Cancella un cliente</a> <br /></p>
														<p><a href=\"modClienti.php\">Modifica dati di un cliente</a></p>
														<p><a href=\"stampaInternet.php\">Stampe e Internet di un cliente</a></p>
													</div>
										</div>
										<div class=\"post\">
											<h2 class=\"title\">Gestione Libri</h2>
												<div style=\"clear: both;\">&nbsp;</div>
													<div class=\"entry\">
													<p><a href=\"insLibri.php\">Inserimento nuovo libro</a></p>
													<p><a href=\"cercaLibri.php\">Cerca libro</a></p>
													<p><a href=\"modLibri.php\">Modifica dati CasaEditrice/Autore/Genere</a></p>
													<p><a href=\"visPrestiti.php\">Visualizza prestiti</a></p>
													</div>
										</div>
										<div class=\"post\">
											<h2 class=\"title\">Gestione Eventi:</h2>
												<div style=\"clear: both;\">&nbsp;</div>
													<div class=\"entry\">
														<p><a href=\"visEventi.php\">Visualizza evento</a></p>
                                                                                                                <p><a href=\"visRelatori.php\">Visualizza relatori</a></p>
													</div>
										</div>
										<div class=\"post\">
											<h2 class=\"title\">Gestione Riviste:</h2>
												<div style=\"clear: both;\">&nbsp;</div>
													<div class=\"entry\">
														<p><a href=\"insRiviste.php\">Inserimento nuova rivista</a></p>
														<p><a href=\"visRiviste.php\">Visualizza riviste</a></p>
													</div>
										</div>
										<div style=\"clear: both;\">&nbsp;</div>
									</div><!-- end #content -->
							</div><!-- end #page -->";
		   			 }
		   			 
                }
                else
                {
								echo "
									<div id=\"menu\">
								<ul>
								<li class=\"current_page_item\"><a href=\"index.php\">Devi identificarti per accedere al sito</a></li>
								</ul>
		   					</div>
		   					";                        
               			exit;
                }
?>        
                </div><!-- end #wrapper -->
		   		<?include("footer.php");?> 
</body>

</html>
