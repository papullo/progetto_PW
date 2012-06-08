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
	
	
	<script type="text/javascript">
				function seleziona(sel){
  				var cat = sel.options[sel.selectedIndex].text;
  				if (cat=="altro") {
						document.inserimento.password.disabled=true;
						document.inserimento.nuovaTip.disabled=false;
						document.inserimento.stipendio.disabled=false;
					}
					else if ((cat=="bibliotecario")||(cat=="direttore")){
						document.inserimento.password.disabled=false;
						document.inserimento.nuovaTip.disabled=true;
						document.inserimento.stipendio.disabled=true;
					}
					else{
						document.inserimento.password.disabled=true;
						document.inserimento.nuovaTip.disabled=true;
						document.inserimento.stipendio.disabled=true;
					}
		}
	</script>	
	<div id="page" class="container">
						<div id="marketing">
							<p class="text1">Inserisci Dipendente</p>
						</div>			<div id="content">
				<div class="post">            	<div style="clear: both;">&nbsp;</div>					<div class="entry">
	
   <form name="inserimento" action="?action=insDip" method="post">
	Nome:<br />
	<input type="text" name="nome" class="input" /> <br />
	Cognome:<br />
	<input type="text" name="cognome" class="input"> <br />
	Codice Fiscale:<br />
	<input type="text" name="codFiscale" class="input"> <br />
	Indirizzo:<br />
	<input type="text" name="indirizzo" class="input"> <br />	
	
	
	Tipologia: <br />        
			<select name="catPersonale" onchange="seleziona(this)">
				<option value="" selected="selected">-- seleziona --</option>				
				<option value="altro">altro</option>; 
				<?php
					$query  = "SELECT * FROM Categoria_Personale";
					$result = mysql_query($query);	
					while ( $row = mysql_fetch_array($result,MYSQL_NUM))
						echo "<option value=".$row[0].">".$row[1]."</option>";
				?>
          </select> <br /><br />
          
   Nuova Tipologia:<br />
   <input type="text" name="nuovaTip" class="input"> <br />     
	Password:<br />
	<input type="text" name="password" class="input"> <br />
	Orario:<br />
	<input type="text" name="orario" class="input"> <br />
	Stipendio:<br />
	<input type="text" name="stipendio" class="input"> <br />				
	
	
	<p class="links">
	<input type="submit" value="Invio" class="form_btn" /> <br />
	</p>
	</form>
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
			if ($_GET['action'] == "insDip" and isset($_SESSION['log'])) 
			{
				// controllo campi compilati
				if (( $_POST['nome'] == "" ) || ( $_POST['cognome'] == "" ) || ( $_POST['codFiscale'] == "" ) || ( $_POST['indirizzo'] == "" )|| ( $_POST['orario'] == "" )|| ( $_POST['catPersonale'] == "" )) 
				{
					print("<script language='javascript'>alert('Compilare tutti i campi per continuare!');</script>");
					print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
					exit;
				}
				
				$codF = $_POST['codFiscale'];
				$query = mysql_query("SELECT * FROM Personale WHERE cod_fiscale='$codF'");
				$data = mysql_fetch_array($query);
				if ((strtoupper($_POST['codFiscale'])) == (strtoupper($data['cod_fiscale'])))
				{
					//errore
					print("<script language='javascript'>alert('Il dipendente è già registrato!');</script>");
					exit;
				}
				
				
				//controllo che la nuovaTipologia non sia già presente e se affermativo aggiungo la nuova tipologia
				if($_POST['catPersonale']=="altro") 
				{
					if(($_POST['nuovaTip'] == "")|| ( $_POST['stipendio'] == "" )||(!is_numeric($_POST['stipendio']))){
						print("<script language='javascript'>alert('Compilare correttamente tutti i campi per continuare!');</script>");
						print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
						exit;	
					}
						//controllo che non sia una tipologia che esiste già
					else {
						$tip=$_POST['nuovaTip'];
						$query = mysql_query("SELECT * FROM Categoria_Personale WHERE tipologia='$tip'");
						$data = mysql_fetch_array($query);
						if($_POST['nuovaTip']==$data['tipologia'])
						{
							print("<script language='javascript'>alert('La tipologia è già presente nell'elenco!');</script>");
							print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
							exit;
						}else {
							$query="INSERT INTO Categoria_Personale (id_cat_per,tipologia,stipendio) VALUES (NULL,\"".$_POST['nuovaTip']."\",\"".$_POST['stipendio']."\")";
							mysql_query($query,$con);
							//inserimento nuovo Dipendente con categoria nuova
							$query2="INSERT INTO Personale (cod_fiscale,nome,cognome,categoria,indirizzo,password,orario) VALUES (\"".$_POST['codFiscale']."\",\"".$_POST['nome']."\",\"".$_POST['cognome']."\",\"".$_POST['nuovaTip']."\",\"".$_POST['indirizzo']."\",NULL,\"".$_POST['orario']."\")";
							mysql_query($query2,$con);
							mysql_close($con);
							print("<script language='javascript'>alert('Registrazione avvenuta con successo');</script>");
							print("<script language='javascript'>location.href='home.php';</script>"); 	
						}
					}	
				}	
				if($_POST['password']=="" and !($_POST['catPersonale']=="altro")){
					$query = "INSERT INTO Personale (cod_fiscale,nome,cognome,categoria,indirizzo,password,orario) VALUES (\"".$_POST['codFiscale']."\",\"".$_POST['nome']."\",\"".$_POST['cognome']."\",\"".$_POST['catPersonale']."\",\"".$_POST['indirizzo']."\",NULL,\"".$_POST['orario']."\")";
				}
				else if(!($_POST['password']=="") and !($_POST['catPersonale']=="altro")){
					$query = "INSERT INTO Personale (cod_fiscale,nome,cognome,categoria,indirizzo,password,orario) VALUES (\"".$_POST['codFiscale']."\",\"".$_POST['nome']."\",\"".$_POST['cognome']."\",\"".$_POST['catPersonale']."\",\"".$_POST['indirizzo']."\",\"".$_POST['password']."\",\"".$_POST['orario']."\")";	
				}
				else {
					echo "ERRORE";
				}
				mysql_query($query,$con);
				mysql_close($con);
				print("<script language='javascript'>alert('Registrazione avvenuta con successo');</script>");
				print("<script language='javascript'>location.href='home.php';</script>"); 	
   		}
   ?>	
	</body>
	

</html>
