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
							<p class="text1">Modifica Editore/Autore/Genere</p>
						</div>			<div id="content">
				<div class="post">            	<div style="clear: both;">&nbsp;</div>						<div class="entry">
        <form name="scegliMod" action="?action=modifica" method="post">
        <select name="selMod" onchange="aut(this)">
				<option value="" selected="selected">-- seleziona --</option>				
				<option value="editore">casa editrice</option>
				<option value="autore">autore</option>
				<option value="genere">genere</option>
			</select>
			<p class="links">
			<input type="submit" value="Invio" class="form_btn" /> <br />
			</p> 
        </form>
        				</div>			</div>
        <?php
        if(isset($_SESSION['log'])) 
        {
        	if($_GET['action']=="modifica") 
        	{
        		echo"<div class=\"post\">
										<h2 class=\"title\">Scegli chi vuoi modificare dall'elenco:</h2>            							<div style=\"clear: both;\">&nbsp;</div>												<div class=\"entry\">";
        		if($_POST['selMod']=="editore") 
        		{
					
					echo "<form action=?action=modEditore method=\"post\">";        			
        			echo "<select name=\"editore\">";
				   echo      "<option value=\"\" selected=\"selected\">-- seleziona --</option>"; 
					$query  = "SELECT * FROM Casa_Editrice ORDER BY rag_sociale";
					$result = mysql_query($query);	
					while ( $row = mysql_fetch_array($result,MYSQL_BOTH))
						echo "<option value=".$row[0].">".$row[1]."</option>";
					echo "</select>";
					echo "<p class=\"links\"><input type=\"submit\" value=\"Invio\" class=\"form_btn\" /></p>";
					echo "</form>";
					
        		}
        		if($_POST['selMod']=="autore") 
        		{
					echo "<br /><br />Seleziona quale Autore modificare<br /><br />";
					echo "<form action=?action=modAutore method=\"post\">";        			
        			echo "<select name=\"autore\">";
				   echo      "<option value=\"\" selected=\"selected\">-- seleziona --</option>"; 
					$query  = "SELECT * FROM Autore ORDER BY cognome";
					$result = mysql_query($query);	
					while ( $row = mysql_fetch_array($result,MYSQL_BOTH))
						echo "<option value=".$row[0].">".$row[1].$row[2]."</option>";
					echo "</select>";
					echo "<p class=\"links\"><input type=\"submit\" value=\"Invio\" class=\"form_btn\" /></p>";
					echo "</form>";
        		}
        		if($_POST['selMod']=="genere") 
        		{
					echo "<br /><br />Seleziona quale Genere modificare<br /><br />";
					echo "<form action=?action=modGenere method=\"post\">";        			
        			echo "<select name=\"genere\">";
				   echo      "<option value=\"\" selected=\"selected\">-- seleziona --</option>"; 
					$query  = "SELECT * FROM Categoria ORDER BY genere";
					$result = mysql_query($query);	
					while ( $row = mysql_fetch_array($result,MYSQL_BOTH))
						echo "<option value=".$row[0].">".$row[1]."</option>";
					echo "</select>";
					echo "<p class=\"links\"><input type=\"submit\" value=\"Invio\" class=\"form_btn\" /></p>";
					echo "</form>";
        		}
        		echo "</div>
                        	</div>";
        		
        	}
        	
        	if($_GET['action']=="modEditore")
        	{
        		echo"<div class=\"post\">            							<div style=\"clear: both;\">&nbsp;</div>												<div class=\"entry\">";
        		$editore=$_POST['editore'];
        		$query=mysql_query("SELECT * FROM Casa_Editrice WHERE id_editrice='$editore'");
            $data =  mysql_fetch_array($query);
            echo "<form action=?action=updateEditore method=\"post\">";
            echo "Ragione Sociale: <br />";
            echo "<input type=\"input\" name=\"ragSociale\" value=\"".$data['rag_sociale']."\"/><br />";
            echo "Numero di telefono: <br />";
            echo "<input type=\"input\" name=\"numeroT\" value=\"".$data['numero_telefono']."\"/><br />";
            echo "Email: <br />";
            echo "<input type=\"input\" name=\"mail\" value=\"".$data['mail']."\"/><br />";
            echo "<input type=\"hidden\" name=\"idEditore\" value=\"".$editore."\" class=\"input\" /><br />";
            echo "<p class=\"links\"><input type=\"submit\" value=\"Invio\" class=\"form_btn\" /></p>";
				echo "</form>";
				echo "</div>
                        	</div>";
         }
         if($_GET['action']=="modAutore")
        	{
        		echo"<div class=\"post\">            							<div style=\"clear: both;\">&nbsp;</div>												<div class=\"entry\">";
        		$autore=$_POST['autore'];
        		$query=mysql_query("SELECT * FROM Autore WHERE id_autore='$autore'");
            $data =  mysql_fetch_array($query);
            echo "<form action=?action=updateAutore method=\"post\">";
            echo "Nome: <br />";
            echo "<input type=\"input\" name=\"nome\" value=\"".$data['nome']."\"/><br />";
            echo "Cognome: <br />";
            echo "<input type=\"input\" name=\"cognome\" value=\"".$data['cognome']."\"/><br />";
            echo "Anno di nascita: <br />";
            echo "<input type=\"input\" name=\"annoN\" value=\"".$data['anno_nascita']."\"/><br />";
            echo "Nazionalità: <br />";
            echo "<input type=\"input\" name=\"nazio\" value=\"".$data['nazionalita']."\"/><br />";
            echo "<input type=\"hidden\" name=\"idAutore\" value=\"".$autore."\" class=\"input\" /><br />";
            echo "<p class=\"links\"><input type=\"submit\" value=\"Invio\" class=\"form_btn\" /></p>";
				echo "</form>";
				echo "</div>
                        	</div>";
         }
         
         if($_GET['action']=="modGenere")
        	{
        		echo"<div class=\"post\">            							<div style=\"clear: both;\">&nbsp;</div>												<div class=\"entry\">";
        		$genere=$_POST['genere'];
        		$query=mysql_query("SELECT * FROM Categoria WHERE id_categoria='$genere'");
            $data =  mysql_fetch_array($query);
            echo "<form action=?action=updateGenere method=\"post\">";
            echo "Genere: <br />";
            echo "<input type=\"input\" name=\"gen\" value=\"".$data['genere']."\"/><br />";
            echo "<input type=\"hidden\" name=\"idGenere\" value=\"".$genere."\" class=\"input\" /><br />";
            echo "<p class=\"links\"><input type=\"submit\" value=\"Invio\" class=\"form_btn\" /></p>";
				echo "</form>";
				echo "</div>
                        	</div>";
         }
         
        	if($_GET['action']=="updateEditore")
        	{
        		$id=$_POST['idEditore'];
        		$ragSoc=$_POST['ragSociale'];
        		$numero=$_POST['numeroT'];
        		$mail=$_POST['mail'];
        		
        		$query=mysql_query("UPDATE Casa_Editrice SET rag_sociale='$ragSoc',numero_telefono='$numero',mail='$mail' WHERE id_editrice='$id'");
        		print("<script language='javascript'>alert('modifica effettuata!');</script>");
        		print("<script language='javascript'>location.href='home.php';</script>");
        		
        	}
        	if($_GET['action']=="updateAutore")
        	{
        		$id=$_POST['idAutore'];
        		$nome=$_POST['nome'];
        		$cognome=$_POST['cognome'];
        		$annoN=$_POST['annoN'];
        		$nazio=$_POST['nazio'];
        		
        		$query=mysql_query("UPDATE Autore SET nome='$nome',cognome='$cognome',anno_nascita='$annoN',nazionalita='$nazio' WHERE id_autore='$id'");
        		print("<script language='javascript'>alert('modifica effettuata!');</script>");
        		print("<script language='javascript'>location.href='home.php';</script>");
        		
        	}
        	
        	if($_GET['action']=="updateGenere")
        	{
        		$id=$_POST['idGenere'];
        		$genere=$_POST['gen'];
        		
        		$query=mysql_query("UPDATE Categoria SET genere='$genere' WHERE id_categoria='$id'");
        		print("<script language='javascript'>alert('modifica effettuata!');</script>");
        		print("<script language='javascript'>location.href='home.php';</script>");
        }
        	
        	
        	
        	
        	
        }
        ?>
	</center>
	<div style="clear: both;">&nbsp;</div>			</div>
	<!-- end #content -->					<div style="clear: both;">&nbsp;</div>
		</div>
	<!-- end #page -->
	</div>
	<!-- end #wrapper -->
	<div id="footer-content" class="container">
		<div id="footer-bg">			<div id="column2">
			
			<p>Mattia Pavoni  73535<br />Pietro Carè  72610</p>						</div>		</div>
</div>
<div id="footer">
	<p>Progetto Basi di Dati 2010/11</p>
</div>
<!-- end #footer -->
	
  </body>
  </html>
