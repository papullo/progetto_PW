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
		<style type="text/css">@import "css/jquery.datepick.css";</style> 
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script> 
		<script type="text/javascript" src="javascript/jquery.datepick.js"></script> 
		<script type="text/javascript"> 
		$(function() {
			$('#popupDatepicker').datepick({dateFormat: 'yyyy-mm-dd'});
		});
		</script>
		<script type="text/javascript">
		function rel(sel)
                        {
  				var scelta = sel.options[sel.selectedIndex].text;
  				if (scelta=="altro")
  				{
                                	document.getElementById("nR").style.display="block";
  				}
  				else
  				{
                                	if(scelta!="nessuno")
                                        {

                                        }
                                        else
                                                document.getElementById("nR").style.display="none";
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
							<p class="text1">Inserisci Evento</p>
						</div>
			<div id="content">
				<div class="post">
            	<div style="clear: both;">&nbsp;</div>
					<div class="entry">
					
	<form name="inserimentoOsp" action="?action=insOspiti" method="post">
	<center>
	<table summary="" >
	<tr><td>
	Relatore:<br />
	<select name="relatore" onchange="rel(this)">
				<option value="nessuno" selected="selected">nessuno</option>
				<option value="altro">altro</option>;
				<?php
					$query  = "SELECT * FROM Relatore ORDER BY cognome";
					$result = mysql_query($query);
					while ( $row = mysql_fetch_array($result,MYSQL_BOTH))
						echo "<option value=".$row['cod_fiscale'].">".$row[1]." ".$row[2]."</option>";
				?>
        </select> <br /><br />
        </center>
        </tr></td>
        
        <tr><td id="nR" style="display:none">
        <center>
        Codice Fiscale:<br />
		  <input type="text" name="codF" class="input" /> <br />
        Nome:<br />
		  <input type="text" name="nome" class="input" /> <br />
        Cognome:<br />
        <input type="text" name="cognome" class="input" /> <br />
        Telefono:<br />
	     <input type="text" name="telefono" class="input"> <br />
        Indirizzo:<br />
	     <input type="text" name="indirizzo" class="input"> <br />
        Email:<br />
	     <input type="text" name="mail" class="input"> <br />
        </center>
   	  </td></tr>     
	<tr><td>
	<center>
	Compenso:<br />
	<input type="text" name="compenso" class="input"> <br />
	</td></tr> 
	<?php
	echo "<input type=\"hidden\" name=\"titolo\" value=\"".$_GET['idtitolo']."\" class=\"input\" /><br />";
	echo "<input type=\"hidden\" name=\"data\" value=\"".$_GET['iddata']."\" class=\"input\" /><br />";
	?>
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
		if($_GET['action']=="insOspiti" and $_POST['titolo']!="") {
		
		if(!$_POST['compenso']=="") 
		{
			if(!(is_numeric($_POST['compenso']))) 
					{
						print("<script language='javascript'>alert('Compenso è un dato numerico!');</script>");
						print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
						exit;
					}
		}
					if( $_POST['relatore'] == "altro" )
					{	
						if(( $_POST['codF'] == "" ) || ( $_POST['nome'] == "" ) || ( $_POST['cognome'] == "" ) || ( $_POST['telefono'] == "" )|| ( $_POST['indirizzo'] == "" ))
						{
							print("<script language='javascript'>alert('Compilare tutti i campi per continuare!'(e-mail facoltativa));</script>");
							print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
							exit;
						}	
					}
					
					
					if($_POST['relatore']=="altro")
	       		{
               		$codF=$_POST['codF'];
               		$query = mysql_query("SELECT * FROM Relatore WHERE cod_fiscale='$codF'");
               		$righe = mysql_num_rows($query);
               		if($righe != 0)
               		{
	               		print("<script language='javascript'>alert('Il relatore è già registrato!');</script>");
								print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
								exit;
               		}
               		else
               		{
               			$query = "INSERT INTO Relatore (cod_fiscale,nome,cognome,telefono,indirizzo,mail) VALUES (\"".$_POST['codF']."\",\"".$_POST['nome']."\",\"".$_POST['cognome']."\",\"".$_POST['telefono']."\",\"".$_POST['indirizzo']."\",\"".$_POST['mail']."\")";
	               		mysql_query($query, $con);
							}
               }
               
               if($_POST['relatore']!="nessuno")
               {
               		$codF=$_POST['relatore'];
               		$giorno=$_POST['data'];
               		$titolo=$_POST['titolo'];
               		$query = mysql_query("SELECT * FROM Ospite WHERE data='$giorno' AND evento='$titolo' AND relatore='$codF'");
               		$righe = mysql_num_rows($query);
               		if($righe != 0)
               		{
               			print("<script language='javascript'>alert('L\'ospite è gia\' registrato!');</script>");
				print("<script language='javascript'>location.href='visEventi.php';</script>");
                                exit;
               		}
               		else
               		{
               			if($_POST['relatore']=="altro")
               			{
               				$query = "INSERT INTO Ospite (data,evento,relatore,compenso) VALUES (\"".$_POST['data']."\",\"".$_POST['titolo']."\",\"".$_POST['codF']."\",\"".$_POST['compenso']."\")";
               				print("<script language='javascript'>alert('Registrazione avvenuta con successo');</script>");
									print("<script language='javascript'>location.href='visEventi.php';</script>");
								}
               			else
               			{
	               			$query = "INSERT INTO Ospite (data,evento,relatore,compenso) VALUES (\"".$_POST['data']."\",\"".$_POST['titolo']."\",\"".$_POST['relatore']."\",\"".$_POST['compenso']."\")";
	               			print("<script language='javascript'>alert('Registrazione avvenuta con successo');</script>");
									print("<script language='javascript'>location.href='visEventi.php';</script>");
	               		}
	               		mysql_query($query, $con);
               		}
               		
       }
	}
	?>
	</body>
</html>
