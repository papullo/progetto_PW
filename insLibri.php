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
				function aut(sel){
  				var scelta = sel.options[sel.selectedIndex].text;
  				if (scelta=="altro")
  				{
  					document.getElementById("nA").style.display="block";
  					document.getElementById("cA").style.display="block";
  					document.getElementById("aN").style.display="block";
  					document.getElementById("n").style.display="block";
  				}
  				else
  				{
  					document.getElementById("nA").style.display="none";
  					document.getElementById("cA").style.display="none";
  					document.getElementById("aN").style.display="none";
  					document.getElementById("n").style.display="none";
  				}
				}
	</script>
	<script type="text/javascript">
				function edi(sel){
  				var scelta = sel.options[sel.selectedIndex].text;
  				if (scelta=="altro")
  				{
  					document.getElementById("nE").style.display="block";
  					document.getElementById("nT").style.display="block";
  					document.getElementById("m").style.display="block";
  				}
  				else
  				{
  					document.getElementById("nE").style.display="none";
  					document.getElementById("nT").style.display="none";
  					document.getElementById("m").style.display="none";
  				}
				}
	</script>
	<script type="text/javascript">
				function gen(sel){
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
        <script type="text/javascript">
				function sca(sel){
  				var scelta = sel.options[sel.selectedIndex].text;
  				if (scelta=="altro")
  				{
  					document.getElementById("corr").style.display="block";
                                        document.getElementById("sala").style.display="block";
                                        document.getElementById("scaf").style.display="block";
  				}
  				else
  				{
                                	document.getElementById("corr").style.display="none";
                                        document.getElementById("sala").style.display="none";
                                        document.getElementById("scaf").style.display="none";
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
							<p class="text1">Inserisci Libro</p>
						</div>
			<div id="content">
				<div class="post">
            	<div style="clear: both;">&nbsp;</div>
					<div class="entry">
	
	<form name="inserimentoLib" action="?action=insLib" method="post">
	<center>
	<table summary="" border="0">
   <tr><td>
	Isbn: <br />
	<input type="text" name="isbn" class="input" /> <br />
	</td></tr>
	
	<tr><td>
	Titolo:<br />
	<input type="text" name="titolo" class="input"> <br />
	</td></tr>
	
	<tr><td>
	Autore: <br />        
			<select name="autore" onchange="aut(this)">
				<option value="" selected="selected">-- seleziona --</option>				
				<option value="altro">altro</option>; 
				<?php
					$query  = "SELECT * FROM Autore ORDER BY cognome";
					$result = mysql_query($query);	
					while ( $row = mysql_fetch_array($result,MYSQL_BOTH))
						echo "<option value=".$row[0].">".$row[1]." ".$row[2]."</option>";
				?>
          </select> <br /><br />
   </td>
   <td id="nA" style="display:none">
   Nome Autore:<br />
	<input type="text" name="nomeAutore" class="input"> <br />
   </td>
   <td id="cA" style="display:none">
   Cognome Autore:<br />
	<input type="text" name="cognomeAutore" class="input"> <br />
   </td>
   <td id="aN" style="display:none">
   Anno Nascita:<br />
	<input type="text" name="annoAutore" class="input"> <br />
   </td>
   <td id="n" style="display:none">
   Nazionalita':<br />
	<input type="text" name="nazioAutore" class="input"> <br />
   </td>
   </tr>
   
   <tr><td>       
   Editore: <br />        
			<select name="editore" onchange="edi(this)">
				<option value="" selected="selected">-- seleziona --</option>				
				<option value="altro">altro</option>; 
				<?php
					$query  = "SELECT * FROM Casa_Editrice ORDER BY rag_sociale";
					$result = mysql_query($query);	
					while ( $row = mysql_fetch_array($result,MYSQL_BOTH))
						echo "<option value=".$row[0].">".$row[1]."</option>";
				?>
          </select> <br /><br />
	</td>
	<td id="nE" style="display:none">
	Nuovo Editore:<br />
	<input type="text" name="nuovoEditore" class="input"> <br />          
   </td>
   <td id="nT" style="display:none">
	Numero Telefono:<br />
	<input type="text" name="numeroEditore" class="input"> <br />
   </td>
   <td id="m" style="display:none">
	E-mail:<br />
	<input type="text" name="mailEditore" class="input"> <br />          
   </td>
   </tr>       
          
   <tr><td>
   Genere: <br />        
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
	Nuovo Genere:<br />
	<input type="text" name="nuovoGenere" class="input"> <br />          
   </td></tr>  
	
	<tr><td>
	Lingua:<br />
	<input type="text" name="lingua" class="input"> <br />
	</td></tr>
	
	<tr><td>
	Anno di Pubblicazione:<br />
	<input type="text" name="annoPubb"> <br />
	</td></tr>
	
	<tr><td>
	Numero Copie:<br />
	<input type="text" name="numCopie" class="input"> <br />
	</td></tr>
 
   <tr><td>
	Scaffale: <br />
			<select name="scaffale" onchange="sca(this)">
				<option value="" selected="selected">-- seleziona --</option>
                                <option value="altro">altro</option>
                                <?php
					$query  = "SELECT * FROM Ubicazione";
					$result = mysql_query($query);
					while ( $row = mysql_fetch_array($result,MYSQL_NUM))
						echo "<option value=".$row[0].">".$row[0]." corridoio ".$row[1]." sala ".$row[2]."</option>";
				?>
          </select> <br /><br />
           </td></tr>
   <td id="scaf" style="display:none">
	Scaffale:<br />
	<input type="text" name="Scaffale" class="input"> <br />
   </td>
   <td id="corr" style="display:none">
	Corridoio:<br />
	<input type="text" name="Corridoio" class="input"> <br />
   </td>
   <td id="sala" style="display:none">
	Sala:<br />
	<input type="text" name="Sala" class="input"> <br />
   </td>

	</table>
	<p class="links">
	<input type="submit" value="Invio" class="form_btn" /> <br />
	</p>	
	</form>
	</center>
	</div>
				</div>
					<div style="clear: both;">&nbsp;</div>
			</div>
	<!-- end #content -->
					<div style="clear: both;">&nbsp;</div>
		</div>
	<!-- end #page -->
	</div>
	<!-- end #wrapper -->
	<div id="footer-content" class="container">
		<div id="footer-bg">
			<div id="column2">
			
			<p>Mattia Pavoni  73535<br />Pietro Carè  72610</p>
			
			</div>
		</div>
</div>
<div id="footer">
	<p>Progetto Basi di Dati 2010/11</p>
</div>
<!-- end #footer -->
	<?php
	function chkEmail($email)
{
	// elimino spazi, "a capo" e altro alle estremità della stringa
	$email = trim($email);

	// se la stringa è vuota sicuramente non è una mail
	if(!$email) {
		return false;
	}

	// controllo che ci sia una sola @ nella stringa
	$num_at = count(explode( '@', $email )) - 1;
	if($num_at != 1) {
		return false;
	}

	// controllo la presenza di ulteriori caratteri "pericolosi":
	if(strpos($email,';') || strpos($email,',') || strpos($email,' ')) {
		return false;
	}

	// la stringa rispetta il formato classico di una mail?
	if(!preg_match( '/^[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}$/', $email)) {
		return false;
	}

	return true;
}
///////////////////////////
			if ($_GET['action'] == "insLib" and isset($_SESSION['log']))
			{
				// controllo campi compilati
				if (( $_POST['isbn'] == "" ) || ( $_POST['titolo'] == "" ) || ( $_POST['autore'] == "" ) || ( $_POST['editore'] == "" )|| ( $_POST['genere'] == "" )|| ( $_POST['lingua'] == "" )|| ( $_POST['annoPubb'] == "" )|| ( $_POST['numCopie'] == "" )|| ( $_POST['scaffale'] == "" ))
				{
					print("<script language='javascript'>alert('Compilare tutti i campi per continuare!');</script>");
					print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
					exit;
				}
				if(!(is_numeric($_POST['isbn'])))
				{
					print("<script language='javascript'>alert('L\'isbn e\' un codice numerico!');</script>");
					print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
					exit;
				}

				$isbn = $_POST['isbn'];
				$query = mysql_query("SELECT * FROM Libro WHERE isbn='$isbn'");
				//$data = mysql_fetch_array($query);
				$righe=mysql_num_rows($query);
				if($righe!=0) {
					//errore
					print("<script language='javascript'>alert('Il libro e\' gia\' registrato!');</script>");
					exit;
				}
				//controllo che il nuovoAutore non sia già presente
				if($_POST['autore']=="altro")
				{
					if($_POST['nomeAutore']==""|| $_POST['cognomeAutore'] == ""|| $_POST['annoAutore'] == ""|| $_POST['nazioAutore'] == ""|| (!is_numeric($_POST['annoAutore'])))
					{
						print("<script language='javascript'>alert('Compilare tutti i campi per continuare!');</script>");
						print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
						exit;
					}
				}
				//controllo che il nuovoEditore non sia già presente
				if($_POST['editore']=="altro")
				{
					if($_POST['nuovoEditore']==""|| $_POST['numeroEditore'] == ""|| $_POST['mailEditore'] == "")
					{
						if(!is_numeric($_POST['numeroEditore']))
						{
							print("<script language='javascript'>alert('Il numero di telefono e\' un dato numerico!');</script>");
							print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
							exit;
						}
						else {
							print("<script language='javascript'>alert('Compilare tutti i campi per continuare!');</script>");
							print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
							exit;
						}
						/*if(!(chkEmail($_POST['mailEditore'])))
						{
							echo "<h3>Errore!</h3><br>Indirizzo e-mail non corretto!<br>
							La preghiamo di <a href=\"javascript:history.go(-1)\">tornare indietro e correggere</a>. Grazie";
							exit;
						}*/
					}
				}
				//controllo che il nuovoGenere non sia già presente
				if($_POST['genere']=="altro")
				{
					if($_POST['nuovoGenere']=="")
					{
						print("<script language='javascript'>alert('Compilare tutti i campi per continuare!');</script>");
						print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
						exit;
					}
				}
                                if($_POST['scaffale']=="altro")
				{
					if($_POST['Corridoio']=="")
					{
						print("<script language='javascript'>alert('Compilare tutti i campi per continuare!');</script>");
						print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
						exit;
					}
                                        if($_POST['Scaffale']=="")
					{
						print("<script language='javascript'>alert('Compilare tutti i campi per continuare!');</script>");
                                                if(!(is_numeric($_POST['Scaffale'])))
                                                        print("<script language='javascript'>alert('lo scaffale deve avere un valore numerico');</script>");
                                                print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
						exit;
					}
                                        if($_POST['Sala']=="")
					{
						print("<script language='javascript'>alert('Compilare tutti i campi per continuare!');</script>");
						print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
						exit;
					}
				}
				//controllo che l'anno sia un dato numerico
				if (!is_numeric($_POST['annoPubb']))
				{
						print("<script language='javascript'>alert('L\'anno e\' un dato numerico!');</script>");
						print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
						exit;
				}
				//////////////////////////////////////////////////////////////////FINE CONTROLLI
				//inserisco nel database il nuovo Autore se non è presente
				if($_POST['autore']=="altro")
				{
						$nomeAut=$_POST['nomeAutore'];
						$cognomeAut=$_POST['cognomeAutore'];
						$query = mysql_query("SELECT * FROM Autore WHERE nome='$nomeAut' AND cognome='$cognomeAut'");
						$righe=mysql_num_rows($query);
						if($righe !=0 )
						{
							print("<script language='javascript'>alert('L\'autore e\' gia\' presente nell\'elenco!');</script>");
							print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
							exit;
						}else {
							$query="INSERT INTO Autore (id_autore,nome,cognome,anno_nascita,nazionalita) VALUES (NULL,\"".$_POST['nomeAutore']."\",\"".$_POST['cognomeAutore']."\",\"".$_POST['annoAutore']."\",\"".$_POST['nazioAutore']."\")";
							mysql_query($query,$con);
						}
				}
				//inserisco nel database il nuovo Editore se non è presente
				if($_POST['editore']=="altro")
				{
						$nomeEdit=$_POST['nuovoEditore'];
						$query = mysql_query("SELECT * FROM Casa_Editrice WHERE rag_sociale='$nomeEdit'");
						$righe=mysql_num_rows($query);
						if($righe!=0)
						{
							print("<script language='javascript'>alert('La casa editrice e\' gia\' presente nell\'elenco!');</script>");
							print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
							exit;
						}
						else
						{
							$query="INSERT INTO Casa_Editrice (id_editrice,rag_sociale,numero_telefono,mail) VALUES (NULL,\"".$_POST['nuovoEditore']."\",\"".$_POST['numeroEditore']."\",\"".$_POST['mailEditore']."\")";
							mysql_query($query,$con);
						}
				}
				//inserisco nel database il nuovo Genere se non è presente
				if($_POST['genere']=="altro")
				{
						$nomeGen=$_POST['nuovoGenere'];
						$query = mysql_query("SELECT * FROM Categoria WHERE genere='$nomeGen'");
						$righe=mysql_num_rows($query);
						if($righe !=0 )
						{
							print("<script language='javascript'>alert('Il genere e\' gia\' presente nell\'elenco!');</script>");
							print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
							exit;
						}else {
							$query="INSERT INTO Categoria (id_categoria,genere) VALUES (NULL,\"".$_POST['nuovoGenere']."\")";
							mysql_query($query,$con);
						}
				}
                                if($_POST['scaffale']=="altro")
				{
						$corr=$_POST['Corridoio'];
                                                $sala=$_POST['Sala'];
                                                $scaf=$_POST['Scaffale'];
						$query = mysql_query("SELECT * FROM Ubicazione WHERE scaffale='$scaf'");
						$righe=mysql_num_rows($query);
						if($righe !=0 )
						{
							print("<script language='javascript'>alert('lo scaffale e\' gia\' presente nell\'elenco!');</script>");
							print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
							exit;
						}else {
							$query="INSERT INTO Ubicazione (scaffale,corridoio,sala) VALUES (\"".$scaf."\",\"".$corr."\",\"".$sala."\")";
							mysql_query($query,$con);
						}
				}
				//compongo i valori per formulare la INSERT
				$val="\"".$_POST['titolo']."\"";
				//autore
				if($_POST['autore']=="altro") 
				{
					$nomeAut=$_POST['nomeAutore'];
					$cognomeAut=$_POST['cognomeAutore'];
					$query = mysql_query("SELECT * FROM Autore WHERE nome='$nomeAut' AND cognome='$cognomeAut'");
					$data = mysql_fetch_array($query);
					$val=$val.","."\"".$data['id_autore']."\"";
				}
				else 
				{
					$val=$val.","."\"".$_POST['autore']."\"";
				}
				//editore
				if($_POST['editore']=="altro") 
				{
					$nomeEdit=$_POST['nuovoEditore'];
					$query = mysql_query("SELECT * FROM Casa_Editrice WHERE rag_sociale='$nomeEdit'");
					$data = mysql_fetch_array($query);
					$val=$val.","."\"".$data['id_editrice']."\"";
				}
				else 
				{
					$val=$val.","."\"".$_POST['editore']."\"";
				}
				//genere
				if($_POST['genere']=="altro") 
				{
					$nomeGen=$_POST['nuovoGenere'];
					$query = mysql_query("SELECT * FROM Categoria WHERE genere='$nomeGen'");
					$data = mysql_fetch_array($query);
					$val=$val.","."\"".$data['id_categoria']."\"";
				}
				else 
				{
					$val=$val.","."\"".$_POST['genere']."\"";
				}
				$val=$val.","."\"".$_POST['annoPubb']."\"".","."\"".$_POST['numCopie']."\"".","."\"".$_POST['lingua']."\"".","."\"".$_POST['isbn']."\"".","."\"".$_POST['scaf']."\"";
								
				$query = "INSERT INTO Libro (titolo,autore,editore,genere,anno_pubb,num_copie,lingua,isbn,numero_scaffale) VALUES (".$val.")";			
				mysql_query($query,$con);
				mysql_close($con);
				print("<script language='javascript'>alert('Registrazione avvenuta con successo');</script>");
				print("<script language='javascript'>location.href='home.php';</script>"); 	
				
			}
	?>	
	
		
	</body>
</html>
