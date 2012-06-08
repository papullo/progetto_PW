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
    <div id="page" class="container">
						<div id="marketing">
							<p class="text1">Visualizza prestiti</p>
						</div>			<div id="content">
				<div class="post">            	<div style="clear: both;">&nbsp;</div>					<div class="entry">
    <center>
    <form action=?action=attivi method="post">
    <p class="links">
    <input type="submit" value="Visualizza Attivi" class="form_btn">
    </form>

    <form action=?action=storico method="post">
    <input type="submit" value="Visualizza Storico" class="form_btn"></p>
    </form>
    </center>
		</div></div>
   <?php

   if(isset($_SESSION['log']) and !($_GET['action']==""))
   {
   	
   	$select= "SELECT c.nome,c.cognome,l.titolo,p.data_inizio,p.data_consegna,p.multa,p.rientrato ";
   	$from="FROM Prestito AS p ";
   	$select = $select.$from;
   	$select=$select."INNER JOIN Cliente c ON p.cliente=c.id_cliente ";
   	$select=$select."INNER JOIN Libro l ON p.libro=l.isbn ";

   	if($_GET['action']=="attivi")
   	{
   		$select=$select."WHERE rientrato=\"F\" ";
   		$select=$select."ORDER BY p.data_consegna";
   	}
   	if($_GET['action']=="storico")
   	{
   		$select=$select."WHERE rientrato=\"T\" ";
   		$select=$select."ORDER BY c.cognome,c.nome";
   	}
    	$query = mysql_query( $select );
   	$righe=mysql_num_rows($query);
   	$i=0;
   	
   	if($righe != 0)
        {
        	$datequery1=mysql_query("SELECT DATE_FORMAT( data_inizio,'%d/%m/%Y') data_inizio FROM Prestito");
         	$datequery2=mysql_query("SELECT DATE_FORMAT( data_consegna,'%d/%m/%Y') data_consegna FROM Prestito");
		while($row=  mysql_fetch_array($query,MYSQL_BOTH))
	 	{
	 		echo "<div class=\"post\">
				<p class=\"meta\"><span class=\"date\">".$i."</span></p>
					<div style=\"clear: both;\">&nbsp;</div>
						<div class=\"entry\">";
						echo"		
                     <p><strong>Nome: </strong>".$row[0]."</p>
                     <p><strong>Cognome: </strong>".$row[1]."</p>
							<p><strong>Titolo: </strong>".$row[2]."</p>";

                        $date=mysql_fetch_array($datequery1);
                        
                        echo "   <p><strong>Data inizio prestito: </strong>".$date['data_inizio']."</p>";
							
								$date=mysql_fetch_array($datequery2);
								
								echo "   <p><strong>Data fine prestito: </strong>".$date['data_consegna']."</p>";
			

			
			$var= "<p><strong>Multa:</strong> Euro ";
			
			//recupero i dati della multa
                        $idmulta=$row[5];
                        $query2=mysql_query("SELECT * FROM Multa WHERE id_multa='$idmulta'");
                        $riga=mysql_fetch_array($query2);
                        if($riga['sanzione']<>"")
                              	$var=$var."".$riga['sanzione'];
                        else
                		            $var=$var."--";
                        if($riga['descrizione']<>"")
                               	$var=$var." causa ".$riga['descrizione'];
			
			echo $var."</p>";
			echo "   <p><strong>Rientrato: </strong>".$row[6]."</p>";			
			
			$i++;
			echo "	</div>
        </div>" ;
			  
			}
		}
		else
                {
			echo "<div class=\"post\"><h2 class=\"title\">Nessun Risultato</h2></div>";
		}
		
		
	mysql_close($con);

   }
	?>
	<div style="clear: both;">&nbsp;</div>			</div>
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
	</center>
	</body>
</html>
