<?php
	session_start();
        include("connettiDb.php");
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
					<h1>Benvenuto in Yourlibrary</h1>
           </div>  
        <?php
                if(isset($_SESSION['log']))
        	{
                	echo "
                	<div id=\"menu\">
							<ul>
							<li class=\"current_page_item\"><a href=\"home.php\">Home</a></li>
							<li><a href=\"logout.php\">logout</a></li>
							</ul>
		   			</div>
		   </div><!-- end #header -->";
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
        <div id="page" class="container">
						<div id="marketing">
							<p class="text1">Modifica dipendente</p>
						</div>
			<div id="content">
				<div class="post">
					<h2 class="title">Inserisci nome e cognome del dipendente da modificare:</h2>
            	<div style="clear: both;">&nbsp;</div>
						<div class="entry">
        
        <form action="modDipendenti.php?action=search" method="post">
        	Nome :<br />
        	<input type="text" name="nomeDip" class="input" /><br />
         Cognome :<br />
         <input type="text" name="cognomeDip" class="input" /><br />  
         <br /><br />
         <p class="links">
         <input type="submit" value="Invio" class="form_btn" />
         </p><br /><br />
        </form>
        				</div>
			</div>

	<?php
        	if($_GET['action']=="search" and isset($_SESSION['log'])) //applico la ricerca e stampa del cliente
                {
                	if(($_POST['nomeDip']=="") || ($_POST['cognomeDip']==""))
                       	{
                      		print("<script language='javascript'>alert('Errore, inserire nome e cognome validi!');</script>");
									print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");                               	
                           exit;
                       	}
                       	$nomeDip = $_POST['nomeDip'];
                        $cognomeDip = $_POST['cognomeDip'];
                      	$query = mysql_query("SELECT * FROM Personale WHERE nome='$nomeDip' AND cognome='$cognomeDip'");
                        $dati =  mysql_fetch_array($query);
                        if(mysql_num_rows($query)<>0)
                        {
                        	echo"<div class=\"post\">
										<h2 class=\"title\">Scegli chi vuoi modificare dall'elenco:</h2>
            							<div style=\"clear: both;\">&nbsp;</div>
												<div class=\"entry\">";
                        	echo "<form action=\"modDipendenti.php?action=modify\" method=\"post\">";
                        	do //stampo tutti i possibili omonimi e faccio scegliere tramite check box chi vuole eliminare
                        	{
                        		echo "<input type=\"checkbox\" name=\"check[]\" value=\"".$dati['cod_fiscale']."\"/>";
                        		echo $dati['nome']." ".$dati['cognome']." ".$dati['indirizzo']." C.F. ";
                                	echo $dati['cod_fiscale']."<br />";
                        	}while ($dati =  mysql_fetch_array($query));
                        	echo "<br /><br /><p class=\"links\"><input type=\"submit\" value=\"Modifica\" class=\"form_btn\" /></p><br /><br />";
                        	echo "<form />";
                        }
                        else
                        {
                                echo $nomeDip." ".$cognomeDip." non trovato nell'elenco dipendenti";
                        }
                         echo "</div>
                        	</div>";
                }
                if($_GET['action']=="modify")//applico la stampa dei dati e li preparo per la modifica
                {
                       $check=$_POST['check'];
                       $ok=0;
                       $i=0;
                       echo"<div class=\"post\">
            							<div style=\"clear: both;\">&nbsp;</div>
												<div class=\"entry\">";
                       echo "<form action=\"modDipendenti.php?action=update\" method=\"post\">";
                       foreach ($check as $id => $valore)//prendo i valori delle check box segnate
                       {
                       		$query=mysql_query("SELECT * FROM Personale WHERE cod_fiscale='$valore'");
                                $dati =  mysql_fetch_array($query);
                                echo "Nome<br />";
                                echo "<input type=\"input\" name=\"nomeDip[]\" value=\"".$dati['nome']."\"/><br />";
                                echo "Cognome<br />";
                                echo "<input type=\"input\" name=\"cognomeDip[]\" value=\"".$dati['cognome']."\"/><br />";
                                echo "Indirizzo<br />";
                                echo "<input type=\"input\" name=\"indirizzo[]\" value=\"".$dati['indirizzo']."\"/><br />";
                                echo "Orario<br />";
                                echo "<input type=\"input\" name=\"orario[]\" value=\"".$dati['orario']."\"/><br />";
                                echo "<input type=\"hidden\" name=\"cod_fiscale[]\" value=\"".$dati['cod_fiscale']."\"/><br /><br />";
                                $i++;

                       }
                       if(!$query)
                       {
                                print("<script language='javascript'>alert('non hai selezionato alcun dipendente!');</script>");
                                exit;
                       }
                       echo "<br /><br /><p class=\"links\"><input type=\"submit\" value=\"Conferma\" class=\"form_btn\" /></p><br /><br />";
                       echo "<form />";
							  echo "</div>
                        	</div>";
                }
                if($_GET['action']=="update")// imposto le modifiche effettuate precedentemente
                {
                       $nome=$_POST['nomeDip'];
                       $cognome=$_POST['cognomeDip'];
                       $indirizzo=$_POST['indirizzo'];
                       $orario=$_POST['orario'];
                       $cod_fiscale=$_POST['cod_fiscale'];
                       $ok=0;
                       $i=0;
                       while($newnome=$nome[$i])
                       {
                                //gestire il controllo della validità del codice fiscale
                       		$cod=$cod_fiscale[$i];
                                //echo "entra";
                                $newcognome=$cognome[$i];
                                $newindirizzo=$indirizzo[$i];
                                $neworario=$orario[$i];
                                if (( $newcognome == "" ) || ( $newnome == "" ) || ( $newindirizzo == "" ) || ( $neworario == "" ))
                                        print("<script language='javascript'>alert('hai lasciato almeno un campo obbligatorio vuoto!');</script>");
                                else
                               		$ok=mysql_query("UPDATE Personale SET nome='$newnome',cognome='$newcognome',indirizzo='$newindirizzo',orario='$neworario' WHERE cod_fiscale='$cod'");
                                $i++;

                       }
                       if($ok)
                                print("<script language='javascript'>alert('modifica effettuata!');</script>");
                       else
                                print("<script language='javascript'>alert('errore nella modifica!');</script>");
                       if($_GET['ref']=="vis")
                       		print("<script language='javascript'>location.href='visDipendenti.php';</script>");
                }
                if($_GET['action']=="modvis")
                {       //modifico da pagina visualizzazione
                       $id=$_GET['id'];
                       $query=mysql_query("SELECT * FROM Personale WHERE cod_fiscale='$id'");
                       $dati =  mysql_fetch_array($query);
                       echo"<div class=\"post\">
            							<div style=\"clear: both;\">&nbsp;</div>
												<div class=\"entry\">";
                       echo "<form action=\"modDipendenti.php?action=update&ref=vis\" method=\"post\">";
                       		echo "Nome<br />";
                       		echo "<input type=\"input\" name=\"nomeDip[]\" value=\"".$dati['nome']."\"/><br />";
                                echo "Cognome<br />";
                                echo "<input type=\"input\" name=\"cognomeDip[]\" value=\"".$dati['cognome']."\"/><br />";
                                echo "Indirizzo<br />";
                                echo "<input type=\"input\" name=\"indirizzo[]\" value=\"".$dati['indirizzo']."\"/><br />";
                                echo "Orario<br />";
                                echo "<input type=\"input\" name=\"orario[]\" value=\"".$dati['orario']."\"/><br />";
                       		echo "<input type=\"hidden\" name=\"cod_fiscale[]\" value=\"".$dati['cod_fiscale']."\"/><br /><br />";
                       		echo "<br /><br /><p class=\"links\"><input type=\"submit\" value=\"Conferma\" class=\"form_btn\" /></p><br /><br />";
                       echo "<form />";
                       echo "</div>
                        	</div>";
                }
                echo "</div><!-- end #content -->
				</div><!-- end #page -->
	</div><!-- end #wrapper -->
		   			 <div id=\"footer-content\" class=\"container\">
							<div id=\"footer-bg\">
								<div id=\"column2\">
									<p>Mattia Pavoni  73535<br />Pietro Care'  72610</p>
								</div>
							</div>
						</div>
						<div id=\"footer\">
							<p>Progetto Basi di Dati 2010/11</p>
						</div>";
        ?>
     
	</body>
</html>
