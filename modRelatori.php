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
							<p class="text1">Modifica relatore</p>
						</div>
			<div id="content">

			</div>

<?php        if($_GET['action']=="update")// imposto le modifiche effettuate precedentemente
                {
                       $nome=$_POST['nomeRel'];
                       $cognome=$_POST['cognomeRel'];
                       $indirizzo=$_POST['indirizzo'];
                       $telefono=$_POST['telefono'];
                       $mail=$_POST['mail'];
                       $cod_fiscale=$_POST['cod_fiscale'];
                       $ok=0;
                       $i=0;
                       while($newnome=$nome[$i])
                       {
                                //gestire il controllo della validità del codice fiscale
                       		$cod=$cod_fiscale[$i];
                                $newcognome=$cognome[$i];
                                $newindirizzo=$indirizzo[$i];
                                $newtelefono=$telefono[$i];
                                $newmail=$mail[$i];
                                if (( $newnome == "" ) || ( $newcognome == "" ) || ( $newindirizzo == "" )|| ( $newtelefono == "" ))
                                        print("<script language='javascript'>alert('hai lasciato almeno un campo obbligatorio vuoto!');</script>");
                                else
                                	$ok=mysql_query("UPDATE Relatore SET nome='$newnome',cognome='$newcognome',indirizzo='$newindirizzo',telefono='$newtelefono',mail='$newmail' WHERE cod_fiscale='$cod'");
                                $i++;

                       }
                       if($ok)
                                print("<script language='javascript'>alert('modifica effettuata!');</script>");
                       else
                                print("<script language='javascript'>alert('errore nella modifica!');</script>");
                       if($_GET['ref']=="vis")
                       		print("<script language='javascript'>location.href='visRelatori.php';</script>");
                }
                if($_GET['action']=="modvis")
                {       //modifico da pagina visualizzazione
                       $id=$_GET['id'];
                       $query=mysql_query("SELECT * FROM Relatore WHERE cod_fiscale='$id'");
                       $dati =  mysql_fetch_array($query);
                       echo"<div class=\"post\">
            							<div style=\"clear: both;\">&nbsp;</div>
												<div class=\"entry\">";
                       echo "<form action=\"modRelatori.php?action=update&ref=vis\" method=\"post\">";
                       		echo "Nome<br />";
                       		echo "<input type=\"input\" name=\"nomeRel[]\" value=\"".$dati['nome']."\"/><br />";
                                echo "Cognome<br />";
                                echo "<input type=\"input\" name=\"cognomeRel[]\" value=\"".$dati['cognome']."\"/><br />";
                                echo "Indirizzo<br />";
                                echo "<input type=\"input\" name=\"indirizzo[]\" value=\"".$dati['indirizzo']."\"/><br />";
                                echo "Telefono<br />";
                                echo "<input type=\"input\" name=\"telefono[]\" value=\"".$dati['telefono']."\"/><br />";
                                echo "E-Mail<br />";
                                echo "<input type=\"input\" name=\"mail[]\" value=\"".$dati['mail']."\"/><br />";
                                echo "<input type=\"hidden\" name=\"cod_fiscale[]\" value=\"".$dati['cod_fiscale']."\"/><br /><br />";
                       		echo "<br /><br /><p class=\"links\"><input type=\"submit\" value=\"Conferma\" class=\"form_btn\" /></p><br /><br />";
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

	</body>
</html>
