<?php

	session_start();

        include("connettiDb.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>YourLibrary</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
		<style type="text/css">@import "css/jquery.datepick.css";</style>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
		<script type="text/javascript" src="javascript/jquery.datepick.js"></script>
		<script type="text/javascript">
		$(function() {
			$('#popupDatepicker').datepick({dateFormat: 'yyyy-mm-dd'});
		});
		</script></head>

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
							<p class="text1">Rimuovi Evento</p>
						</div>			<div id="content">
				<div class="post">
					<h2 class="title">Inserisci titolo e/o data dell'evento da cancellare:</h2>            	<div style="clear: both;">&nbsp;</div>						<div class="entry">
        <form action="cancEventi.php?action=search" method="post">
        	Titolo :<br />
        	<input type="text" name="titoloEve" class="input" /><br />
                Data :<br />
        	<input type="text" name="dataEve" id="popupDatepicker" /><br />
                <br /><br />
                <p class="links">
                <input type="submit" value="Invio" class="form_btn" />
                </p>
        </form>
        </div>			 </div>
	<?php
        	if($_GET['action']=="search" and isset($_SESSION['log'])) //applico la ricerca e stampa dell'evento
                {
                	if($_POST['titoloEve']=="" and $_POST['dataEve']=="")
                       	{
                           print("<script language='javascript'>alert('Errore, inserire almeno una data o un nome per identificare l'evento!');</script>");
									print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");                               	
                           exit;
                       	}
                       	$titoloEve = $_POST['titoloEve'];
                        $dataDip = $_POST['dataEve'];
                        if(!($titoloEve=="" && $dataEve==""))
                        	$query = mysql_query("SELECT * FROM Evento WHERE data='$dataDip' AND titolo='$titoloEve'");
                        else
                        {
                        	if($titoloEve=="")
                        		$query = mysql_query("SELECT * FROM Evento WHERE data='$dataDip'");
                        	else
                                	$query = mysql_query("SELECT * FROM Evento WHERE titolo='$titoloEve'");
                        }
                        $dati =  mysql_fetch_array($query);
                        if(mysql_num_rows($query)<>0)
                       	{
                       		echo"<div class=\"post\">
										<h2 class=\"title\">Scegli chi vuoi eliminare dall'elenco:</h2>            							<div style=\"clear: both;\">&nbsp;</div>												<div class=\"entry\">";
                       		echo "<form action=\"cancEventi.php?action=delete\" method=\"post\">";
                       		do
                       		{       //possibilità di aggiungere un campo con i relatori se inseriti, dopo aver modificato il database
	                      		echo "<input type=\"checkbox\" name=\"check[]\" value=\"".$dati['data']."|".$dati['titolo']."\"/>";
                                        //echo "<inpu type=\"hidden\" name=\"titolo[]\" value=\"".$dati['titolo']."\"/>";
                                	echo $dati['titolo']." ".$dati['data']." ".$dati['tipo'];
                       		}while ($dati =  mysql_fetch_array($query));
            			//stampo tutti i possibili eventi con la stessa data e faccio scegliere tramite check box quale eliminare
                       		echo "<br /><br /><p class=\"links\"><input type=\"submit\" value=\"Cancella\" class=\"form_btn\" /></p><br /><br />";
                       		echo "<form />";
                       	}
                       	else
                       	{
                               	echo $titoloEve." in data :".$dataEve." non trovato nell'elenco eventi";
                       	}
                       	echo "</div>
                        	</div>";
                }
                if($_GET['action']=="delete")//applico la cancellazione dell'evento selezionato
                {
                       $check=$_POST['check'];
                       $titolo=$_POST['titolo'];
                       $ok=0;
                       $i=0;
                       foreach ($check as $id => $valore)//prendo i valori delle check box segnate, dividendoli per il separatore
                       {
                       		$divide=explode("|",$valore);
                       		$ok=mysql_query("DELETE FROM Evento WHERE data='$divide[0]' AND titolo='$divide[1]'");
                                $i++;
                       }
                       if($ok)
                                print("<script language='javascript'>alert('l\'evento e\' stato cancellato!');</script>");
                       else
                                print("<script language='javascript'>alert('non hai selezionato alcun evento...');</script>");
                }
                if($_GET['action']=="cancvis")
                {
                        $iddata=$_GET['iddata'];
                        $idtitolo=$_GET['idtitolo'];
                        $ok=mysql_query("DELETE FROM Evento WHERE data='$iddata' AND titolo='$idtitolo'");
                        if($ok)
                                print("<script language='javascript'>alert('l\'evento e\' stato cancellato!');</script>");
                        else
                                print("<script language='javascript'>alert('errore nella cancellazione!');</script>");
                	print("<script language='javascript'>location.href='visEventi.php';</script>");
                }
                echo "</div><!-- end #content -->
				</div><!-- end #page -->
	</div><!-- end #wrapper -->
		   			 <div id=\"footer-content\" class=\"container\">
							<div id=\"footer-bg\">								<div id=\"column2\">
									<p>Mattia Pavoni  73535<br />Pietro Care'  72610</p>								</div>							</div>
						</div>
						<div id=\"footer\">
							<p>Progetto Basi di Dati 2010/11</p>
						</div>";
        ?>
    <center />
	</body>
</html>
