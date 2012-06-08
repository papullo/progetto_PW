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
        <style type="text/css">@import "css/jquery.datepick.css";</style>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        <script type="text/javascript" src="javascript/jquery.datepick.js"></script>
        <script type="text/javascript">
        	$(function()
                {
                	$('#popupDatepicker').datepick({dateFormat: 'yyyy-mm-dd'});
                });
        </script>
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
					<h2 class="title">Inserisci nome e cognome del cliente da modificare:</h2>
            	<div style="clear: both;">&nbsp;</div>
						<div class="entry">
        
        <form action="modClienti.php?action=search" method="post">
        Nome :<br />
        <input type="text" name="nomeCli" class="input" /><br />
        Cognome :<br />
        <input type="text" name="cognomeCli" class="input" /><br />
        <br /><br />
        <p class="links">
        <input type="submit" value="Invio" class="form_btn" />
        </p>
        <br /><br />
        </form>
        				</div>
			</div>
        <?php
              	if($_GET['action']=="search" and isset($_SESSION['log'])) //applico la ricerca e stampa del cliente
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
										<h2 class=\"title\">Scegli chi vuoi modificare dall'elenco:</h2>
            							<div style=\"clear: both;\">&nbsp;</div>
												<div class=\"entry\">";
                              	echo "<form action=\"modClienti.php?action=modify\" method=\"post\">";
                               	do
                               	{
                               		echo "<input type=\"checkbox\" name=\"check[]\" value=\"".$dati['id_cliente']."\"/>";
                               		echo $dati['nome']." ".$dati['cognome']." ".$dati['indirizzo']." nato il ".$dati['data_nascita']." n. tessera : ";
                                       	echo $dati['id_cliente']."<br />";
                               	}while ($dati =  mysql_fetch_array($query));
               			//stampo tutti i possibili omonimi e faccio scegliere tramite check box chi vuole eliminare
                               	echo "<br /><br /><p class=\"links\"><input type=\"submit\" value=\"Modifica\" class=\"form_btn\" /></p><br /><br />";
                               	echo "<form />";
                        }
                        else
                        {
                                echo $nomeCli." ".$cognomeCli." non trovato nell'elenco dipendenti";
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
                        echo "<form action=\"modClienti.php?action=update\" method=\"post\">";
                        foreach ($check as $id => $valore)//prendo i valori delle check box segnate
         		{
                        	$query=mysql_query("SELECT * FROM Cliente WHERE id_cliente='$valore'");
                                $dati =  mysql_fetch_array($query);
                                echo "Nome<br />";
                                echo "<input type=\"input\" name=\"nomeCli[]\" value=\"".$dati['nome']."\"/><br />";
                                echo "Cognome<br />";
                                echo "<input type=\"input\" name=\"cognomeCli[]\" value=\"".$dati['cognome']."\"/><br />";
                                echo "Indirizzo<br />";
                                echo "<input type=\"input\" name=\"indirizzo[]\" value=\"".$dati['indirizzo']."\"/><br />";
                                echo "Data di nascita<br />";
                                echo "<input type=\"input\" name=\"data[]\" value=\"".$dati['data_nascita']."\" id=\"popupDatepicker\"/><br />";
                                echo "Telefono<br />";
                                echo "<input type=\"input\" name=\"telefono[]\" value=\"".$dati['telefono']."\"/><br />";
                                echo "Password<br />";
                                echo "<input type=\"input\" name=\"pass[]\" value=\"".$dati['password']."\"/><br />";
                                echo "<input type=\"hidden\" name=\"id_cliente[]\" value=\"".$dati['id_cliente']."\"/><br /><br />";
                        }

                       	if(!$query)
                        {
                                print("<script language='javascript'>alert('non hai selezionato alcun cliente!');</script>");
                                exit;
                        }
                        echo "<br /><br /><p class=\"links\"><input type=\"submit\" value=\"Conferma\" class=\"form_btn\" /></p><br /><br />";
                        echo "<form />";
                        echo "</div>
                        	</div>";
                }
                if($_GET['action']=="update")// imposto le modifiche effettuate precedentemente
                {
                       $nome=$_POST['nomeCli'];
                       $cognome=$_POST['cognomeCli'];
                       $indirizzo=$_POST['indirizzo'];
                       $datan=$_POST['data'];
                       $tel=$_POST['telefono'];
                       $pass=$_POST['pass'];
                       $id_cliente=$_POST['id_cliente'];
                       $ok=0;
                       $i=0;
                       while($newnome=$nome[$i])
                       {        //gestire il controllo della validità del codice fiscale
                                $newcognome=$cognome[$i];
                                $newindirizzo=$indirizzo[$i];
                                $newdatan=$datan[$i];
                                $newtel=$tel[$i];
                                $newpass=$pass[$i];
                                $id=$id_cliente[$i];
                                $querydate=mysql_query("SELECT CURDATE()AS data");
                                $curdaterow=mysql_fetch_array($querydate);
                                $curdate=$curdaterow['data'];
                                if($newdatan<$curdate)
                                {
                                        if (( $_POST['nome'] == "" ) || ( $_POST['cognome'] == "" ) || ( $_POST['indirizzo'] == "" ) || ( $_POST['data_nascita'] == "" ) || ( $_POST['telefono'] == "" ))
                                        	print("<script language='javascript'>alert('hai lasciato almeno un campo obbligatorio vuoto!');</script>");
                                        else
                                        	$ok=mysql_query("UPDATE Cliente SET nome='$newnome',cognome='$newcognome',indirizzo='$newindirizzo',data_nascita='$newdatan',telefono='$newtel',password='$newpass' WHERE id_cliente='$id'");
                                }
                                else
                                {
                                        print("<script language='javascript'>alert('data inserita non valida, non puo\' essere oltre oggi!');</script>");
                                        if($_GET['ref']=="vis")
                       				print("<script language='javascript'>location.href='visClienti.php';</script>");
                                }
                                $i++;
                       }
                       if($ok)
                                print("<script language='javascript'>alert('modifica effettuata!');</script>");
                       else
                                print("<script language='javascript'>alert('errore nella modifica!');</script>");
                       if($_GET['ref']=="vis")
                       	        print("<script language='javascript'>location.href='visClienti.php';</script>");
                }
                if($_GET['action']=="modvis")
                {
                        $id=$_GET['id'];
                        $query=mysql_query("SELECT * FROM Cliente WHERE id_cliente='$id'");
                        $dati =  mysql_fetch_array($query);
                        echo"<div class=\"post\">
            							<div style=\"clear: both;\">&nbsp;</div>
												<div class=\"entry\">";
                        echo "<form action=\"modClienti.php?action=update&ref=vis\" method=\"post\">";
                        echo "Nome<br />";
                        echo "<input type=\"input\" name=\"nomeCli[]\" value=\"".$dati['nome']."\"/><br />";
                        echo "Cognome<br />";
                        echo "<input type=\"input\" name=\"cognomeCli[]\" value=\"".$dati['cognome']."\"/><br />";
                        echo "Indirizzo<br />";
                        echo "<input type=\"input\" name=\"indirizzo[]\" value=\"".$dati['indirizzo']."\"/><br />";
                        echo "Data di nascita<br />";
                        echo "<input type=\"input\" name=\"data[]\" value=\"".$dati['data_nascita']."\" id=\"popupDatepicker\"/><br />";
                        echo "Telefono<br />";
                        echo "<input type=\"input\" name=\"telefono[]\" value=\"".$dati['telefono']."\"/><br />";
                        echo "Password<br />";
                        echo "<input type=\"input\" name=\"pass[]\" value=\"".$dati['password']."\"/><br />";
                        echo "<input type=\"hidden\" name=\"id_cliente[]\" value=\"".$id."\"/><br /><br />";
                        echo "<br /><br /><input type=\"submit\" value=\"Conferma\" class=\"form_btn\" /><br /><br />";
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
       </center>
       </body>
</html>

