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
	<form name="inserimentoE" action="?action=insEvento" method="post">
	<center>		
	<table summary="" >

	<tr><td>
	<center>	
	
	Titolo Evento:<br />
	<input type="text" name="titolo" class="input" /> <br />
	Data:<br />
	<input type="text" name="data" id="popupDatepicker" /> <br />
	Descrizione:<br />
	<textarea name="descrizione" rows="2" cols="30"></textarea> <br />
	
	</center>
	</td></tr>	
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
	if ($_GET['action'] == "insEvento" and isset($_SESSION['log'])) 
	{
					if (( $_POST['titolo'] == "" ) || ( $_POST['data'] == "" ))
					{
						print("<script language='javascript'>alert('Compilare almeno i campi titolo, data e descrizione per continuare!');</script>");
						print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
						exit;
					}
					
					$giorno=$_POST['data'];
					$titolo=$_POST['titolo'];
					$query = mysql_query("SELECT * FROM Evento WHERE data='$giorno' AND titolo='$titolo'");
               $righe = mysql_num_rows($query);
               if($righe != 0)
               {
               	print("<script language='javascript'>alert('Nella data selezionata è già registrato l'evento specificato!');</script>");
						print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
						exit;
               }
               $query="INSERT INTO Evento (titolo,data,descrizione) VALUES (\"".$_POST['titolo']."\",\"".$_POST['data']."\",\"".$_POST['descrizione']."\")";
               mysql_query($query, $con);
               print("<script language='javascript'>alert('Registrazione avvenuta con successo');</script>");
			      print("<script language='javascript'>location.href='home.php';</script>");
               
	       
               
        }
	?>
	</center>
	</body>
</html>
	
