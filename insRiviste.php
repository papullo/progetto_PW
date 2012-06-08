<?php
	session_start();
	include ("connettiDb.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>YourLibrary</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
                <script type="text/javascript">
			function gen(sel)
                        {
  				var scelta = sel.options[sel.selectedIndex].text;
  				if (scelta=="altro")
  				{
  					document.getElementById("nG").style.display="block";
  				}
  				else
  				{
  					document.getElementById("nG").style.display="none";
  				}
			}
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
							<p class="text1">Inserisci Rivista</p>
						</div>			<div id="content">
				<div class="post">            	<div style="clear: both;">&nbsp;</div>					<div class="entry">
					<center>
	<form name="inserimentoRiv" action="?action=insRiv" method="post">
        <table summary="" border="0">
        <tr><td>
        <center>
        Titolo:<br />
	<input type="text" name="titolo" class="input" /> <br />
        </center>
        </td></tr>
        <tr><td>
        <center>
        Categoria:<br />
        <select name="genere" onchange="gen(this)">
				<option value="" selected="selected">-- seleziona --</option>
				<option value="altro">altro</option>;
				<?php
					$query  = "SELECT * FROM Categoria ORDER BY genere";
					$result = mysql_query($query);
					while ( $row = mysql_fetch_array($result,MYSQL_BOTH))
						echo "<option value=".$row[0].">".$row[1]."</option>";
				?>
        </select> <br /><br />
        </td><td id="nG" style="display:none">
        <center>
        Nuovo Genere:<br />
	<input type="text" name="nuovoGenere" class="input"> <br />
        </center>
        </td></tr>
        <tr><td>
        <center>
	Cadenza:<br />
	<select name="cadenza">
				<option value="" selected="selected">-- seleziona --</option>
				<option value="altro">altro</option>;
				<option value="settimanale">settimanale</option>;
				<option value="quindicinale">quindicinale</option>;
				<option value="mensile">mensile</option>;
				<option value="bimestrale">bimestrale</option>;
				<option value="semestrale">semestrale</option>;
				</select> <br /><br />


        </td></tr>
        </table>
   <p class="links">
	<input type="submit" value="Invio" class="form_btn" /> <br />
	</p>
	</form>
	</center>
</div>				</div>					<div style="clear: both;">&nbsp;</div>			</div>
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

	<?php
		if ($_GET['action'] == "insRiv" and isset($_SESSION['log']) )
		{
			if (( $_POST['titolo'] == "" ) || ( $_POST['genere'] == "" ) || ( $_POST['cadenza'] == "" ))
			{
					print("<script language='javascript'>alert('Compilare tutti i campi per continuare!');</script>");
					print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
					exit;
			}
               		$query = mysql_query("SELECT * FROM Rivista");
               		$data =  mysql_fetch_array($query);
               		$righe = mysql_num_rows($query);
               		if($righe != 0)
              	 	{
               			if($data['titolo']==$_POST['titolo'])
               			{
               			//errore
				print("<script language='javascript'>alert('La rivista è già registrata!');</script>");
				exit;
               			}
               		}

                	$query = "INSERT INTO Rivista (id_abb,titolo,categoria,cadenza) VALUES (NULL,\"".$_POST['titolo']."\",\"".$_POST['genere']."\",\"".$_POST['cadenza']."\")";
             		mysql_query($query,$con);
			mysql_close($con);
			print("<script language='javascript'>alert('Registrazione avvenuta con successo');</script>");
			print("<script language='javascript'>location.href='home.php';</script>");
                        //inserisco nuovo genere
			if($_POST['genere']=="altro")
			{
				$nomeGen=$_POST['nuovoGenere'];
				$query = mysql_query("SELECT * FROM Categoria WHERE genere='$nomeGen'");
				$righe=mysql_num_rows($query);
				if($righe !=0 )
				{
							print("<script language='javascript'>alert('Il genere è già presente nell'elenco!');</script>");
							print("<script language='javascript'>location.href='home.php';</script>"); 	
			       		exit;
				}
                        	else
                        	{
					$query="INSERT INTO Categoria (id_categoria,genere) VALUES (NULL,\"".$_POST['nuovoGenere']."\")";
					mysql_query($query,$con);
				}
			}
		}

	?>

        </center>
	</body>
	

</html>
