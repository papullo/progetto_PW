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
							<p class="text1">Modifica Password</p>
						</div>
			<div id="content">
				<div class="post">
					<h2 class="title">Inserisci vecchia e nuova password:</h2>
            	<div style="clear: both;">&nbsp;</div>
						<div class="entry">
				<form action="?action=modPwd" method="post">
				Vecchia Password<br />
            <input type="password" name="oldPwd" class="input" /><br />
            Nuova Password<br />
            <input type="password" name="newPwd" class="input" /><br />
            Conferma nuova Password<br />
            <input type="password" name="confPwd" class="input" /><br />
				<p class="links">
            <input type="submit" value="Invio" class="form_btn" />
            </p>
				</form>		
				</div>				</div>					<div style="clear: both;">&nbsp;</div>			</div>
	<!-- end #content -->					<div style="clear: both;">&nbsp;</div>
		</div>
	<!-- end #page -->
	</div>
	<!-- end #wrapper -->	<div id="footer-content" class="container">
		<div id="footer-bg">			<div id="column2">
			
			<p>Mattia Pavoni  73535<br />Pietro Carè  72610</p>						</div>		</div>
</div>
<div id="footer">
	<p>Progetto Basi di Dati 2010/11</p>
</div>
<!-- end #footer -->
<?php
 if ($_GET['action']=="modPwd" and isset($_SESSION['log']))
 {
 	if(($_POST['oldPwd']=="") || ($_POST['newPwd']=="") || ($_POST['confPwd']==""))
   {
   	print("<script language='javascript'>alert('Errore, compilare tutti i campi per continuare!');</script>");
		print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");                               	
      exit;
   }
   $old=$_POST['oldPwd'];
   $codF=$_SESSION['utente'];
   $query = mysql_query("SELECT * FROM Personale WHERE cod_fiscale='$codF' AND password='$old'");
   if(mysql_num_rows($query)==0)
   {
   	print("<script language='javascript'>alert('Errore,(vecchia) password non corretta');</script>");
      exit;
   }
   if($_POST['newPwd']!=$_POST['confPwd']) 
   {
   	print("<script language='javascript'>alert('Errore,conferma nuova password errata!');</script>");
      exit;
   }
   if($_POST['newPwd']==$_POST['oldPwd']) 
   {
   	print("<script language='javascript'>alert('Errore, vecchia password e nuova password coincidono!');</script>");
      exit;
   }
   $new=$_POST['newPwd'];
   $query=mysql_query("UPDATE Personale SET password='$new' WHERE cod_fiscale='$codF'");
   print("<script language='javascript'>alert('modifica effettuata!');</script>");
   print("<script language='javascript'>location.href='home.php';</script>");
   
 }
?>		
						
						
	</body>
</html>