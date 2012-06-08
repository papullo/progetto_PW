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
					<p class="text1">Azzera contatore stampe e minuti Internet</p>
				</div>
			<div id="content">
                        <center><form name="cancella" action="?action=delete" method="post">
                        <input type="submit" value="Azzera" class="form_btn" />
                        </form></center>
<?php
                if($_GET['action']=='delete')
                {
                	mysql_query("DELETE FROM Stampa");
                        mysql_query("DELETE FROM Internet");
                        print("<script language='javascript'>alert('Azzeramento effettuato!');</script>");
                        print("<script language='javascript'>location.href='home.php';</script>");
                }
		echo "</div><!-- end #content -->
     		</div><!-- end #page -->
     		</div><!-- end #wrapper -->
		<div id=\"footer-content\" class=\"container\">
		 	<div id=\"footer-bg\">
		 		<div id=\"column2\">
		 			<p>Mattia Pavoni  73535<br />Pietro Carè  72610</p>
		 		</div>
		 	</div>
		 </div>
		 <div id=\"footer\">
		 	<p>Progetto Basi di Dati 2010/11</p>
		 </div>";
        ?>
    <center />
	</body>
</html>
