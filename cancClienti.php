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
							<p class="text1">Rimuovi cliente</p>
						</div>			<div id="content">
				<div class="post">
					<h2 class="title">Inserisci nome e cognome del cliente da cancellare:</h2>            	<div style="clear: both;">&nbsp;</div>						<div class="entry">
        <br /><br />
        <form action="cancClienti.php?action=search" method="post">
        	Nome :<br />
        	<input type="text" name="nomeCli" class="input" /><br />
         Cognome :<br />
         <input type="text" name="cognomeCli" class="input" /><br />
        	<br /><br />
        	<p class="links">
         <input type="submit" value="Invio" class="form_btn" />
         </p><br /><br />
        </form>
            </div>			 </div>
	<?php
        	if($_GET['action']=="search") //applico la ricerca e stampa del cliente
                {
                	if(($_POST['nomeCli']=="") || ($_POST['cognomeCli']==""))
                       	{
                      				print("<script language='javascript'>alert('Errore, inserire nome e cognome validi!');</script>");
											print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");                               	
                               	exit;
                       	}
                       	$nomeCli = $_POST['nomeCli'];
                        $cognomeCli = $_POST['cognomeCli'];
                      	$query = mysql_query("SELECT * FROM Cliente WHERE nome='$nomeCli' AND cognome='$cognomeCli'");
                        $dati =  mysql_fetch_array($query);
                        if(mysql_num_rows($query)<>0)
                        {
                        	echo"<div class=\"post\">
										<h2 class=\"title\">Scegli chi vuoi eliminare dall'elenco:</h2>            							<div style=\"clear: both;\">&nbsp;</div>												<div class=\"entry\">";
                        	echo "<form action=\"cancClienti.php?action=delete\" method=\"post\">";
                        	do
                        	{
                        		echo "<input type=\"checkbox\" name=\"check[]\" value=\"".$dati['id_cliente']."\"/>";
                        		echo $dati['nome']." ".$dati['cognome']." ".$dati['indirizzo']."  ".$dati['data_nascita']." n. tessera : ";
                                	echo $dati['id_cliente']."<br />";
                        	}while ($dati =  mysql_fetch_array($query));
             			//stampo tutti i possibili omonimi e faccio scegliere tramite check box chi vuole eliminare
                        	echo "<br /><br /><p class=\"links\"><input type=\"submit\" value=\"Cancella\" class=\"form_btn\" /></p><br /><br />";
                        	echo "<form />";
                        }
                        else
                        {
                                echo $nomeCli." ".$cognomeCli." non trovato nell'elenco clienti";
                        }
                        echo "</div>
                        	</div>";
                }
                if($_GET['action']=="delete")//applico la cancellazione del dipendente selezionato
                {
                       $check=$_POST['check'];
                       $ok=0;
                       foreach ($check as $id => $valore)//prendo i valori delle check box segnate
                       {
                       		$ok=mysql_query("DELETE FROM Cliente WHERE id_cliente='$valore'");
                       }
                       if($ok)
                                print("<script language='javascript'>alert('Il cliente e' stato cancellato!');</script>");
                       else
                                print("<script language='javascript'>alert('non hai selezionato alcun cliente...');</script>");

                }
                if($_GET['action']=="cancvis")
                {
                        $id=$_GET['id'];
                        $ok=mysql_query("DELETE FROM Cliente WHERE id_cliente='$id'");
                        if($ok)
                                print("<script language='javascript'>alert('Il cliente e' stato cancellato!');</script>");
                        else
                                print("<script language='javascript'>alert('errore nella cancellazione!');</script>");
                	print("<script language='javascript'>location.href='visClienti.php';</script>");
                }
                echo "</div><!-- end #content -->
				</div><!-- end #page -->
	</div><!-- end #wrapper -->
		   			 <div id=\"footer-content\" class=\"container\">
							<div id=\"footer-bg\">								<div id=\"column2\">
									<p>Mattia Pavoni  73535<br />Pietro Carè  72610</p>								</div>							</div>
						</div>
						<div id=\"footer\">
							<p>Progetto Basi di Dati 2010/11</p>
						</div>";
        ?>
    <center />
	</body>
</html>
