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
							<p class="text1">Cerca Libro</p>
						</div>			<div id="content">
				<div class="post">
					<h2 class="title">Compilare i campi per la ricerca:</h2>            	<div style="clear: both;">&nbsp;</div>					<div class="entry">
				<center>					
        <form name="cercaClienti" action="?action=cercaCli" method="post">
        	Isbn :<br />
        	<input type="text" name="isbn" class="input" /><br />
         Titolo :<br />
         <input type="text" name="titolo" class="input" /><br />
         Cognome autore :<br />
         <input type="text" name="autore" class="input" /><br />
         Editore :<br />
         <input type="text" name="editore" class="input" /><br />    
         Genere :<br />
         <input type="text" name="genere" class="input" /><br />  
         Lingua :<br />
         <input type="text" name="lingua" class="input"  /><br />
         Anno di pubblicazione :<br />
         <input type="text" name="anno" class="input" /><br />  
         
         
         
         <br /><br />
         <p class="links">
         <input type="submit" value="Invio" class="form_btn" />
         </p>
         <br /><br />
        </form>
        </center>
        							</div>					</div>	
        <?php
        	if($_GET['action']=="cercaCli" and isset($_SESSION['log'])) //applico la ricerca e stampa del cliente
                {
                	if(($_POST['isbn']=="") and ($_POST['titolo']=="")and ($_POST['autore']=="") and ($_POST['editore']=="") and ($_POST['genere']=="") and ($_POST['lingua']=="") and ($_POST['anno']=="") )
                  {
                     print("<script language='javascript'>alert('Compilare almeno un campo per continuare!');</script>");
							print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
							exit;
                  }
                  if(!($_POST['anno']=="") and !(is_numeric($_POST['anno'])) ) 
                  {
                  	print("<script language='javascript'>alert('Il campo anno deve essere un numero!');</script>");
							print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");
							exit;
                  }
			$select="SELECT l.titolo, a.cognome, edit.rag_sociale, cat.genere, l.anno_pubb,l.num_copie,l.lingua,l.isbn,l.numero_scaffale,u.sala,u.corridoio";
                  	$from=" FROM Libro AS l";
			$select = $select.$from;
			$select = $select." inner join Autore a on l.autore=a.id_autore";
			$select = $select." inner join Casa_Editrice edit on l.editore=edit.id_editrice";
			$select = $select." inner join Categoria cat on l.genere=cat.id_categoria";
			$select = $select." inner join Ubicazione u on l.numero_scaffale=u.scaffale";
			$and=" and ";
			$where="";
			$orderBy=" order by l.titolo";
			if ($_POST['isbn'] != "")
			{
				$where = " l.isbn = "."\"".$_POST['isbn']."\"";
			}
			if ($_POST['titolo'] != "")
			{
				if (strlen($where) != 0)
				$where = $where.$and." l.titolo = "."\"".$_POST['titolo']."\"";
				else
				$where = " l.titolo ="."\"".$_POST['titolo']."\"";
			}
			if ($_POST['autore'] != "")
			{
				if (strlen($where) != 0)
					$where = $where.$and." a.cognome = "."\"".$_POST['autore']."\"";
				else
					$where = " a.cognome ="."\"".$_POST['autore']."\"";
			}
			if ($_POST['editore'] != "")
			{
				if (strlen($where) != 0)
					$where = $where.$and." edit.rag_sociale = "."\"".$_POST['editore']."\"";
				else
					$where = " edit.rag_sociale = "."\"".$_POST['editore']."\"";
			}
			if ($_POST['genere'] != "")
			{
				if (strlen($where) != 0)
					$where = $where.$and." cat.genere = "."\"".$_POST['genere']."\"";
				else
					$where = " cat.genere = "."\"".$_POST['genere']."\"";
			}
			if ($_POST['lingua'] != "")
			{
				if (strlen($where) != 0)
					$where = $where.$and." l.lingua = "."\"".$_POST['lingua']."\"";
				else
					$where = " l.lingua = "."\"".$_POST['lingua']."\"";
			}
			if ($_POST['anno'] != "")
			{
				if (strlen($where) != 0)
					$where = $where.$and." l.anno_pubb = "."\"".$_POST['anno']."\"";
				else
					$where = " l.anno_pubb = "."\"".$_POST['anno']."\"";
			}
			if (strlen($where) != 0)
				$where=" where ".$where;
		        $query = $select.$where.$orderBy;
			//echo $query;
                        $result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
                        //se ho trovato risultati
			if ($num_rows != 0)
			{
				while($row = mysql_fetch_array($result,MYSQL_BOTH))
	 			{
				echo"		<div class=\"post\">
				<p class=\"meta\"><span class=\"date\">".$row['isbn']."</span></p>
					<div style=\"clear: both;\">&nbsp;</div>
						<div class=\"entry\">
                     <p><strong>Titolo: </strong>".$row['titolo']."</p>
                     <p><strong>Cognome autore: </strong>".$row['cognome']."</p>
							<p><strong>Editore: </strong>".$row['rag_sociale']."</p>	
							<p><strong>Anno di Pubblicazione: </strong>".$row['anno_pubb']."</p>
							<p><strong>Genere: </strong>".$row['genere']."</p>
							<p><strong>Copie Presenti: </strong>".$row['num_copie']."</p>";	

									

									$isbn=$row['isbn'];
									$query=mysql_query("SELECT * FROM Prestito WHERE libro='$isbn' AND rientrato=\"F\"");
									$righe=mysql_num_rows($query);

									
				echo "   <p><strong>Copie in prestito: </strong>".$righe."</p>
							<p><strong>Lingua: </strong>".$row['lingua']."</p>
							<p><strong>Numero Scaffale: </strong>".$row['numero_scaffale']."</p>
							<p><strong>Corridoio: </strong>".$row['corridoio']."</p>
							<p><strong>Sala: </strong>".$row['sala']."</p>
							<p><strong>Opzioni: </strong><p class=\"links\">";
			   echo "<input type=\"button\" value=\"Preleva\" onclick=\"location.href='utilityLib.php?opzione=preleva&isbn=".$row['isbn']."'\"</center>";									
				echo "<input type=\"button\" value=\"Consegna\" onclick=\"location.href='utilityLib.php?opzione=consegna&isbn=".$row['isbn']."'\"</center>";
				echo "<input type=\"button\" value=\"Modifica\" onclick=\"location.href='utilityLib.php?opzione=modifica&isbn=".$row['isbn']."'\"</center>";
				echo "<input type=\"button\" value=\"Rimuovi\" onclick=\"location.href='utilityLib.php?opzione=rimuovi&isbn=".$row['isbn']."'\"</center>";																	
				echo "</p></p>";					
									echo "	</div>
        </div>" ;  
							}	
						}
						else 
						{
							echo "<div class=\"post\"><h2 class=\"title\">Nessun Risultato</h2></div>";
						}					
						
						
						
						
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
        
           
	</body>
</html>
