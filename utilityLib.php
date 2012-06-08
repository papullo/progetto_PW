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
			$('#popupDatepicker1').datepick({dateFormat: 'yyyy-mm-dd'});
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
		if(!$_GET['opzione']=="" and !$_GET['isbn']=="")
		{
			echo "
                	<div id=\"menu\">
							<ul>
							<li class=\"current_page_item\"><a href=\"home.php\">Home</a></li>
							<li><a href=\"logout.php\">logout</a></li>
							</ul>
		   			</div>
		   </div><!-- end #header -->";
        		$isbn=$_GET['isbn'];
        		$query=mysql_query("SELECT * FROM Libro WHERE isbn='$isbn'");
			$data=mysql_fetch_array($query);
			$titolo=$data['titolo'];
                	if($_GET['opzione']=="preleva")
			{
            echo "
		   			 	<div id=\"page\" class=\"container\">
								<div id=\"marketing\">
									<p class=\"text1\">Prelievo libro</p>
								</div>
									<div id=\"content\">
										<div class=\"post\">
											<h2 class=\"title\">Si è scelto di prelevare una copia di : ".$titolo." </h2>
												<div style=\"clear: both;\">&nbsp;</div>
													<div class=\"entry\">";
            
            $query=mysql_query("SELECT * FROM Libro WHERE isbn='$isbn'");
				$data=mysql_fetch_array($query);
				if($data['num_copie']==0)
				{
					print("<script language='javascript'>alert('Nessuna copia presente al momento!');</script>");
					print("<script language='javascript'>location.href='home.php';</script>");
				}
				else
				{//registra prestito
					echo "<form action=?action=prestito method=\"post\">";
                                	echo "Tessera Cliente :<br />";
        				echo "<input type=\"text\" name=\"cliente\" class=\"input\" /><br />";
        				echo "<input type=\"hidden\" name=\"libro\" value=\"".$isbn."\" class=\"input\" /><br />";
         				echo "Data inizio :<br />";
         				echo "<input type=\"text\" name=\"dataI\" class=\"input\" id=\"popupDatepicker\" /><br />";
         				echo "Data fine :<br />";
         				echo "<input type=\"text\" name=\"dataF\" class=\"input\" id=\"popupDatepicker1\" /><br />";
                                	echo "<br /><br />";
         				echo "<p class=\"links\"><input type=\"submit\" value=\"Invio\" class=\"form_btn\" /></p>";
         				echo "<br /><br />";
         				echo "</form>";
				}
				echo "</div>
                        	</div>";
			}
			if($_GET['opzione']=="consegna")
			{
				echo "
		   			 	<div id=\"page\" class=\"container\">
								<div id=\"marketing\">
									<p class=\"text1\">Consegna libro</p>
								</div>
									<div id=\"content\">
										<div class=\"post\">
											<h2 class=\"title\">Si è scelto di consegnare una copia di : ".$titolo." </h2>
												<div style=\"clear: both;\">&nbsp;</div>
													<div class=\"entry\">";
                        	echo "<form action=?action=consegna method=\"post\">";
                                echo "Tessera Cliente :<br />";
        			echo "<input type=\"text\" name=\"cliente\" class=\"input\" /><br />";
        			echo "<input type=\"hidden\" name=\"libro\" value=\"".$isbn."\" class=\"input\" /><br />";
				echo "<br /><br />";
                                echo "Importo multa € <br /><input type=\"text\" name=\"multaImp\"><br />";
                                echo "Causale multa : <br /><input type=\"text\" name=\"multaCau\"><br />";
         			echo "<p class=\"links\"><input type=\"submit\" value=\"Invio\" class=\"form_btn\" /></p>";
         			echo "<br /><br />";
         			echo "</form>";
         			echo "</div>
                        	</div>";
                        }
			if($_GET['opzione']=="modifica")
			{
				echo "
		   			 	<div id=\"page\" class=\"container\">
								<div id=\"marketing\">
									<p class=\"text1\">Modifica libro</p>
								</div>
									<div id=\"content\">
										<div class=\"post\">
											<h2 class=\"title\">Si è scelto di modifica i dati di : ".$titolo." </h2>
												<div style=\"clear: both;\">&nbsp;</div>
													<div class=\"entry\">";
                		$query = mysql_query("SELECT * FROM Libro WHERE isbn='$isbn'");
                		$data =  mysql_fetch_array($query);
                        	echo "<form action=?action=modifica method=\"post\">";
                		echo "Titolo: <br />";
                		echo "<input type=\"input\" name=\"titolo\" value=\"".$data['titolo']."\"/><br />";
                		echo "Lingua: <br />";
                     		echo "<input type=\"input\" name=\"lingua\" value=\"".$data['lingua']."\"/><br />";
                     		echo "Numero Copie: <br />";
                     		echo "<input type=\"input\" name=\"copie\" value=\"".$data['num_copie']."\"/><br />";
                     		echo "<input type=\"hidden\" name=\"isbn\" value=\"".$isbn."\" class=\"input\" /><br />";
           			echo "<input type=\"submit\" value=\"Invio\" class=\"form_btn\" />";
         			echo "<br /><br />";
         			echo "</form>";
         			echo "</div>
                        	</div>";
			}
			if($_GET['opzione']=="rimuovi")
			{//rimuove dalla biblioteca
				$query = mysql_query("DELETE FROM Libro WHERE isbn='$isbn'");
				print("<script language='javascript'>alert('Libro rimosso');</script>");
				print("<script language='javascript'>location.href='home.php';</script>");
         }
        	}
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
        		//tramite post
      	if($_GET['action']=="prestito")
        {
		$isbn = $_POST['libro'];
        	if (( $_POST['cliente'] == "" ) || ( $_POST['dataI'] == "" ) || ( $_POST['dataF'] == "" ))
        	{
        			print("<script language='javascript'>alert('Compilare tutti i campi per continuare!');</script>");
					print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
					exit;
        	}
        	if(($_POST['dataI']>=$_POST['dataF']) || ($_POST['dataF']< mysql_query("SELECT CURDATE()")))
        	{
        			print("<script language='javascript'>alert('Errore nella specifica delle date!');</script>");
					print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
					exit;
        	}
        	$cliente = $_POST['cliente'];
        	$query=mysql_query("SELECT * FROM Cliente WHERE id_cliente='$cliente'");
        	$righe = mysql_num_rows($query);
        	if($righe==0)
        	{
        			print("<script language='javascript'>alert('Tessera sbagliata o cliente non registrato!');</script>");
					print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
					exit;
        	}
		$query=mysql_query("SELECT * FROM Libro WHERE isbn='$isbn'");
        	$data =  mysql_fetch_array($query);
        	$copie=$data['num_copie']-1;
        	$controllo=mysql_query("SELECT * FROM Prestito WHERE cliente='$cliente' AND libro='$isbn' AND rientrato=\"F\"");
        	$righe = mysql_num_rows($controllo);
        	if($righe!=0)
        	{
        		print("<script language='javascript'>alert('Il libro è già in prestito al cliente specificato!');</script>");
        		print("<script language='javascript'>location.href='home.php';</script>");
			exit;
        	}
                $aggCopie=mysql_query("UPDATE Libro SET num_copie='$copie' WHERE isbn='$isbn'");
        	$query="INSERT INTO Prestito (id_pr,cliente,data_inizio,data_consegna,libro,multa,rientrato) VALUES (NULL,\"".$_POST['cliente']."\",\"".$_POST['dataI']."\",\"".$_POST['dataF']."\",\"".$_POST['libro']."\",NULL,\"F\")";
        	mysql_query($query,$con);
		mysql_close($con);
		print("<script language='javascript'>alert('Prestito effettuato');</script>");
		print("<script language='javascript'>location.href='home.php';</script>");
        }
        //tramite post
        if($_GET['action']=="consegna")
        {
        	$isbn = $_POST['libro'];
        	if($_POST['cliente'] == "" )
        	{
        			print("<script language='javascript'>alert('Compilare tutti i campi per continuare!');</script>");
					print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
					exit;
        	}
                if($_POST['multaImp'] == "" and $_POST['multaCau']<>"")
        	{
					print("<script language='javascript'>alert('Errore, è stata compilata la descrizione di una multa senza il relativo importo!');</script>");
					print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
					exit;
        	}
        	$cliente = $_POST['cliente'];
        	$query=mysql_query("SELECT * FROM Cliente WHERE id_cliente='$cliente'");
        	$righe = mysql_num_rows($query);
        	if($righe==0)
        	{
        			print("<script language='javascript'>alert('Tessera cliente sbagliata!');</script>");
					print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
					exit;
        	}
        	$query=mysql_query("SELECT * FROM Libro WHERE isbn='$isbn'");
        	$data =  mysql_fetch_array($query);
        	$copie=$data['num_copie']+1;
        	$controllo=mysql_query("SELECT * FROM Prestito WHERE cliente='$cliente' AND libro='$isbn'");
        	$righe = mysql_num_rows($controllo);
                if($righe==0)
        	{
        		print("<script language='javascript'>alert('Il libro non è in prestito oppure il cliente specificato è sbagliato!');</script>");
        		print("<script language='javascript'>location.href='cercaLibri.php';</script>");
				exit;
        	}
        	$aggCopie=mysql_query("UPDATE Libro SET num_copie='$copie' WHERE isbn='$isbn'");
        	$cancPrestito=mysql_query("UPDATE Prestito SET rientrato=\"T\" WHERE cliente='$cliente' AND libro='$isbn'");
                $righe = mysql_fetch_array($controllo);
                if($_POST['multaImp']<>"")
                {
                       	$importo=$_POST['multaImp'];
                        $descrizione=$_POST['multaCau'];
                       	if(is_numeric($importo))
                        {
                              	$query="INSERT INTO Multa (id_multa,cliente,sanzione,descrizione) VALUES (NULL,\"$cliente\",\"$importo\",\"$descrizione\")";
                                mysql_query($query);
                                $idprestito=$righe['id_pr'];
                                mysql_query("UPDATE Prestito SET multa=(SELECT MAX(id_multa) AS mu FROM Multa) WHERE id_pr='$idprestito'");
                        }
                        else
                        {
                                print("<script language='javascript'>alert('La multa deve essere un specificata numericamente!');</script>");
										  print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
										  exit;
                        }

                }
        	mysql_close($con);
		print("<script language='javascript'>alert('Libro consegnato');</script>");
		print("<script language='javascript'>location.href='home.php';</script>");
        }
        if($_GET['action']=="modifica")
        {
        	$isbn=$_POST['isbn'];
        	$titolo=$_POST['titolo'];
        	$lingua=$_POST['lingua'];
        	$copie=$_POST['copie'];
              	$query=mysql_query("UPDATE Libro SET titolo='$titolo',lingua='$lingua',num_copie='$copie' WHERE isbn='$isbn'");
        	print("<script language='javascript'>alert('modifica effettuata!');</script>");
        	print("<script language='javascript'>location.href='home.php';</script>");
        }
	?>
</body>
</html>
