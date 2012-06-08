<?php	session_start();	include ("connettiDb.php");
	include ("XHTMLfunctions.php");?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">	<head>		<meta http-equiv="content-type" content="text/html; charset=UTF-8" ></meta>		<title>Yourlibrary</title>		<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">	</head>	<body>     <div id="wrapper">			<div id="header" class="container">				<div id="logo">					<h1>YourLibrary</h1>           </div>  	<?php         if(!isset($_SESSION['log']))        	{           	           echo "				<div id=\"menu\">				<ul>					<li class=\"current_page_item\"><a href=\"index.php\">Devi identificarti per accedere al sito</a></li>				</ul>				</div>";                             			exit;                    }    ?>    
    <div id="menu">				<ul>					<li class="current_page_item"><a href="home.php">Home</a></li>					<li><a href="logout.php">logout</a></li>				</ul>   			</div>			   </div><!-- end #header -->
				<div id="page" class="container">					<div id="marketing">						<p class="text1">Visualizza Relatori</p>					</div>					<div id="content">
				<?php
					$query = mysql_query("SELECT r.*,cat.genere FROM Rivista AS r INNER JOIN Categoria AS cat ON cat.id_categoria=r.categoria ORDER BY titolo");					$righe=mysql_num_rows($query);					if($righe != 0)					{
						$border="1";
				 		$cellspacing="1";
				 		$cellpadding="0";
				 		$indici=th("titolo").th("genere").th("cadenza").th("azioni(da fare!!)");
				 		$corpo=tr($indici);						while($row=  mysql_fetch_array($query,MYSQL_BOTH))						{							$riga_dati=td($row['titolo']).td($row['genere']).td($row['cadenza']).td();
							if($_SESSION['tipo']=='bibliotecario')           				{
           					
           				}
           				$corpo.=tr($riga_dati);	
						}
						echo table($corpo, $border, $cellspacing, $cellpadding);
        			}					else					{						echo "<div class=\"post\"><h2 class=\"title\">Nessun Risultato</h2></div>";					}
					mysql_close($con);				?>			</div><!-- end #content -->			</div><!-- end #page -->			</div><!-- end #wrapper -->				<div id="footer-content" class="container">					<div id="footer-bg">						<div id="column2">							<p>Mattia Pavoni  73535<br />Pietro Carè  72610</p>						</div>					</div>				</div>				<div id="footer">					<p>Progetto Programmazione web 2011/12</p>				</div>";        	</body></html>
