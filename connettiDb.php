<?php 
	// connessione db
	$con = mysql_pconnect( "localhost", "yourlibrary", "cufpifepme70") 
	or die( "Impossibile collegarsi al database"); 
	mysql_select_db("my_yourlibrary", $con) 
	or die( "Impossibile selezionare il database");
?> 
