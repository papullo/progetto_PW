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
							<p class="text1">Inserisci Cliente</p>
						</div>			<div id="content">
				<div class="post">            	<div style="clear: both;">&nbsp;</div>					<div class="entry">
	
	<form name="inserimentoCli" action="?action=insCli" method="post">
	Nome:<br />
	<input type="text" name="nome" class="input" /> <br />
	Cognome:<br />
	<input type="text" name="cognome" class="input"> <br />
	Data di Nascita:<br />
	<input type="text" name="dataNascita" id="popupDatepicker"> <br />
	Telefono:<br />
	<input type="text" name="telefono" class="input"> <br />	
	Indirizzo:<br />
	<input type="text" name="indirizzo" class="input"> <br />
	
	
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
			if ($_GET['action'] == "insCli" and isset($_SESSION['log'])) 
			{
					if (( $_POST['nome'] == "" ) || ( $_POST['cognome'] == "" ) || ( $_POST['dataNascita'] == "" ) || ( $_POST['indirizzo'] == "" ))
					{
						print("<script language='javascript'>alert('Compilare tutti i campi per continuare!');</script>");
						print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
						exit;
					}
               $query = mysql_query("SELECT * FROM Cliente");
               $data =  mysql_fetch_array($query);
               $righe = mysql_num_rows($query);
               if($righe != 0) 
               {
               	if($data['cognome']==$_POST['cognome'] and $data['nome']==$_POST['nome'] and $data['data_nascita']==$_POST['dataNascita'] and $data['indirizzo']==$_POST['indirizzo']) 
               	{
               		//errore
							print("<script language='javascript'>alert('Il dipendente è già registrato!');</script>");
							exit;
               	}
               }
               if($_POST['telefono']=="") 
               {
               	$query = "INSERT INTO Cliente (id_cliente,nome,cognome,data_nascita,telefono,indirizzo,password) VALUES (NULL,\"".$_POST['nome']."\",\"".$_POST['cognome']."\",\"".$_POST['dataNascita']."\",NULL,\"".$_POST['indirizzo']."\",NULL)";
               }
               else
               {
               	$query = "INSERT INTO Cliente (id_cliente,nome,cognome,data_nascita,telefono,indirizzo,password) VALUES (NULL,\"".$_POST['nome']."\",\"".$_POST['cognome']."\",\"".$_POST['dataNascita']."\",\"".$_POST['telefono']."\",\"".$_POST['indirizzo']."\",NULL)";
               }
             	mysql_query($query,$con);
					mysql_close($con);
					print("<script language='javascript'>alert('Registrazione avvenuta con successo');</script>");
					print("<script language='javascript'>location.href='home.php';</script>"); 
			}
	?>	
			</center>	
	</body>
	

</html>
