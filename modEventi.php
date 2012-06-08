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
		$(function() {
			$('#popupDatepicker').datepick({dateFormat: 'yyyy-mm-dd'});
                        $('#popupDatepicker2').datepick({dateFormat: 'yyyy-mm-dd'});
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
							<p class="text1">Modifica Evento</p>
						</div>
			<div id="content">
				<div class="post">
				<h2 class="title">Inserisci titolo e/o data dell'evento da modificare:</h2>
            	<div style="clear: both;">&nbsp;</div>
						<div class="entry">
        
        <form action="modEventi.php?action=search" method="post">
         Titolo :<br />
         <input type="text" name="titoloEve" class="input" /><br />
         Data :<br />
         <input type="text" name="dataEve" id="popupDatepicker" /><br />
         <br /><br />
         <p class="links">
         <input type="submit" value="Invio" class="form_btn" />
         </p>
         <br /><br />
        </form>

	<?php
                if($_GET['action']=="search" and isset($_SESSION['log'])) //applico la ricerca e stampa dell'evento
                {
                	if($_POST['titoloEve']=="" and $_POST['dataEve']=="")
                       	{
                      		print("<script language='javascript'>alert('Errore, inserire almeno una data e un titolo validi!');</script>");
									print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");                               	
                           exit;
                       	}
                       	$titoloEve = $_POST['titoloEve'];
                        $dataEve = $_POST['dataEve'];
                        if(!($titoloEve=="" or $dataEve==""))
                        	$query = mysql_query("SELECT * FROM Evento WHERE data='$dataEve' AND titolo='$titoloEve'");
                        else
                        {
                        	if($titoloEve=="")
                        		$query = mysql_query("SELECT * FROM Evento WHERE data='$dataEve'");
                        	else
                                	$query = mysql_query("SELECT * FROM Evento WHERE titolo='$titoloEve'");
                        }
                        $dati =  mysql_fetch_array($query);
                        if(mysql_num_rows($query)<>0)
                       	{
                       		echo"<div class=\"post\">
										<h2 class=\"title\">Scegli chi vuoi modificare dall'elenco:</h2>
            							<div style=\"clear: both;\">&nbsp;</div>
												<div class=\"entry\">";
                       		echo "<form action=\"modEventi.php?action=modify\" method=\"post\">";
                       		do
                       		{
	                      		echo "<input type=\"checkbox\" name=\"check[]\" value=\"".$dati['data']."|".$dati['titolo']."\"/>";
                                        //echo "<input type=\"hidden\" name=\"titolo[]\" value=\"".$dati['titolo']."\"/>";
                                        $datequery=mysql_query("SELECT DATE_FORMAT( data,'%d/%m/%Y') data FROM Evento");
                                        $data=mysql_fetch_array($datequery);
                                	echo $dati['titolo']." ".$data['data']." ".$dati['tipo'];
                                        echo "<br />";
                       		}while ($dati =  mysql_fetch_array($query));
            			//stampo tutti i possibili eventi con la stessa data e faccio scegliere tramite check box quale eliminare
                       		echo "<br /><br /><p class=\"links\"><input type=\"submit\" value=\"Modifica\" class=\"form_btn\" /></p><br /><br />";
                       		echo "<form />";
                       	}
                       	else
                       	{
                                if(!$titoloEve=="" and !$dataEve=="")
                        		echo $titoloEve." in data ".$dataEve." non trovato nell'elenco eventi";
                        	else
                        	{
                        		if(!($titoloEve==""))
                        			echo $titoloEve." non trovato nell'elenco eventi";
                        		else
                                		echo "In data ".$dataEve." nessun evento nell'elenco eventi";
                        	}
                       	}
                       	echo "</div>
                        	</div>";
                }
                if($_GET['action']=="cancOsp") 
                {
                	$data=$_GET['data'];
                	$evento=$_GET['evento'];
                	$codF=$_GET['codF'];
                	$ok=mysql_query("DELETE FROM Ospite WHERE data='$data' AND evento='$evento' AND relatore='$codF'");
                	print("<script language='javascript'>alert('Ospite Cancellato!');</script>");
                	print("<script language='javascript'>location.href='visEventi.php';</script>");
                }

               if($_GET['action']=="modify")//applico la stampa dei dati e li preparo per la modifica
               {
                       $check=$_POST['check'];
                       $ok=0;
                       $i=0;
                        echo"<div class=\"post\">
            							<div style=\"clear: both;\">&nbsp;</div>
												<div class=\"entry\">";
                       echo "<form action=\"modEventi.php?action=update\" method=\"post\">";
                       foreach ($check as $id => $valore)//prendo i valori delle check box segnate
                       {
                       		$divide=explode("|",$valore);
                                $query=mysql_query("SELECT * FROM Evento WHERE data='$divide[0]' AND titolo='$divide[1]'");
                                $dati =  mysql_fetch_array($query);
                                echo "Titolo<br />";
                                echo "<input type=\"input\" name=\"titolo[]\" value=\"".$dati['titolo']."\"/><br />";
                                echo "Data<br />";
                                echo "<input type=\"input\" name=\"data[]\" value=\"".$dati['data']."\" id=\"popupDatepicker2\"/><br />";
                                echo "Descrizione<br />";
                                echo "<textarea name=\"descrizione[]\" rows=\"2\" cols=\"30\"/>".$dati['descrizione']."</textarea><br />";
                                echo "<input type=\"hidden\" name=\"oldtitolo[]\" value=\"".$dati['titolo']."\"/><br />";
                                echo "<input type=\"hidden\" name=\"olddata[]\" value=\"".$dati['data']."\"/><br />";
                                $i++;

                       }
                       if(!$query)
                       {
                                print("<script language='javascript'>alert('non hai selezionato alcun evento!');</script>");
                                exit;
                       }
                       echo "<br /><br /><input type=\"submit\" value=\"Conferma\" class=\"form_btn\" /><br /><br />";
                       echo "<form />";
                       echo "</div>
                        	</div>";

                }
                if($_GET['action']=="update")// imposto le modifiche effettuate precedentemente
                {
                       $titolo=$_POST['titolo'];
                       $data=$_POST['data'];
                       $descrizione=$_POST['descrizione'];
                       $oldtitolo=$_POST['oldtitolo'];
                       $olddata=$_POST['olddata'];
                       $ok=0;
                       $i=0;
                       while($newtitolo=$titolo[$i])
                       {
                                //gestire il controllo della validità della coppia data titolo
                       		$newdata=$data[$i];
                                $newdescrizione=$descrizione[$i];
                                $oldt=$oldtitolo[$i];
                                $oldd=$olddata[$i];
                                $query=mysql_query("SELECT * FROM Evento WHERE titolo='$newtitolo' AND data='$newdata' AND titolo<>'$oldt' AND data<>'$oldd'");
                                $numrows=mysql_num_rows($query);
                                if($numrows==0)
                       		     {
                                        if (( $newdata == "" ) || ( $newtitolo == "" ))
                                        	print("<script language='javascript'>alert('hai lasciato almeno un campo obbligatorio vuoto!');</script>");
                                	else
                                            	$ok=mysql_query("UPDATE Evento SET titolo='$newtitolo',data='$newdata',descrizione='$newdescrizione' WHERE titolo='$oldt' AND data='$oldd'");
                                }
                                else
                                        print("<script language='javascript'>alert('Esiste gia\' un evento con stesso titolo e data!');</script>");
                                
                                $i++;

                       }
                       if($ok)
                                print("<script language='javascript'>alert('modifica effettuata!');</script>");
                       else
                                print("<script language='javascript'>alert('errore nella modifica!');</script>");
                       if($_GET['ref']=="vis")
                       	        print("<script language='javascript'>location.href='visEventi.php';</script>");
                }

                if($_GET['action']=="modvis")
                {
                        $iddata=$_GET['iddata'];
                        $idtitolo=$_GET['idtitolo'];
                        $query=mysql_query("SELECT * FROM Evento WHERE data='$iddata' AND titolo='$idtitolo'");
                        $dati =  mysql_fetch_array($query);
                        echo"<div class=\"post\">
            							<div style=\"clear: both;\">&nbsp;</div>
												<div class=\"entry\">";
                        echo "<form action=\"modEventi.php?action=update&ref=vis\" method=\"post\">";
                        echo "Titolo<br />";
                        echo "<input type=\"input\" name=\"titolo[]\" value=\"".$dati['titolo']."\"/><br />";
                        echo "Data<br />";
                        echo "<input type=\"input\" name=\"data[]\" value=\"".$dati['data']."\" id=\"popupDatepicker2\"/><br />";
                        echo "Descrizione<br />";
                        echo "<textarea name=\"descrizione[]\" rows=\"2\" cols=\"30\"/>".$dati['descrizione']."</textarea><br />";
                        echo "<input type=\"hidden\" name=\"oldtitolo[]\" value=\"".$dati['titolo']."\"/><br />";
                        echo "<input type=\"hidden\" name=\"olddata[]\" value=\"".$dati['data']."\"/><br />";
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
