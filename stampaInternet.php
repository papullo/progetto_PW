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
							<p class="text1">Gestione stampa e internet</p>
						</div>			<div id="content">
				<div class="post">            	<div style="clear: both;">&nbsp;</div>						<div class="entry">
    <form action=?action=modifica method="post">
    ID Cliente:
    <br />
    <input type="text" name="id">
    <br />
    Numero di stampe:
    <br />
    <input type="text" name="stampe">
    <br />
    Numero di minuti di utilizzo Internet:
    <br />
    <input type="text" name="internet">
    <br />
    <br />
    <p class="links">
    <input type="submit" value="Invio" class="form_btn">
    </p>
    </form>
    					</div>			</div>
			<div style="clear: both;">&nbsp;</div>			</div>
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
    	if($_GET['action']=='modifica')
        {
    		if($_POST['id']==""){
        		print("<script language='javascript'>alert('inserire un numero di tessera!');</script>");
        		print("<script language='javascript'>location.href='javascript:history.go(-1)';</script>");                               	
            exit;
        		}
        	else
        	{
        		$id=$_POST['id'];
                	$stampe=$_POST['stampe'];
                	$internet=$_POST['internet'];
                        $maxstampe=50;//numero max di stampe concesse
                        $maxint=120;//numero max di minuti concessi
                	$query=mysql_query("SELECT * FROM Cliente WHERE id_cliente='$id'");
                	if(is_numeric($id))
                	{
                		if($riga=mysql_fetch_array($query))
                		{       //gestione stampe
                                        if(is_numeric($stampe) and $stampe>0)
                                        {
                                        	$somma=mysql_query("SELECT SUM(num_copie) AS somma FROM Stampa WHERE cliente='$id'");
                                                $sommastampe=mysql_fetch_array($somma);
                                                $somma=$sommastampe['somma'];
                                                $totstampe=$somma+$stampe;
                                                $rimanenti=$maxstampe-$totstampe;
                                                if($somma<$maxstampe)
                                                {
                                                     	mysql_query("INSERT INTO Stampa (id_stampa,num_copie,cliente) VALUES (NULL,'$stampe','$id')");
                                                        if($totstampe<=$maxstampe)
                                                	{
                                                        	print("<script language='javascript'>alert('puoi fare ancora ".$rimanenti." stampe');</script>");
                                                	}
                                                	else
                                                	{
                                                    	        $minoltre=-$rimanenti;
                                                                print("<script language='javascript'>alert('non hai piu\' stampe disponibili, hai sforato di ".$minoltre." stampe');</script>");
                                                	}
                                                }
                                                else
                                                {
                                                        print("<script language='javascript'>alert('non hai piu\' stampe disponibili!');</script>");
                                                }
                                        }
                                        else
                                        {
                                        	if($stampe<>"")
                                                	print("<script language='javascript'>alert('numero di stampe non corretto!');</script>");
                                        }
                                        //gestione internet
                                        if(is_numeric($internet) and $internet>0)
                                        {
                                        	$min=mysql_query("SELECT SUM(minuti) AS somma FROM Internet WHERE cliente='$id'");
                                                $sommamin=mysql_fetch_array($min);
                                                $minut=$sommamin['somma'];
                                                $totmin=$minut+$internet;
                                                $rimanentimin=$maxint-$totmin;
                                                if($sommamin['somma']<$maxint)
                                                {
                                                	mysql_query("INSERT INTO Internet (id_sessione,minuti,cliente) VALUES (NULL,'$internet','$id')");
                                                        if($totmin<=$maxint)
                                                	{
                                                        	print("<script language='javascript'>alert('puoi usare internet ancora ".$rimanentimin." minuti');</script>");
                                                	}
                                                	else
                                                	{
                                                	        $minoltre=-$rimanentimin;
                                                	        print("<script language='javascript'>alert('non hai piu\' minuti disponibili, hai sforato di ".$minoltre." minuti');</script>");
                                                	}
                                                }
                                                else
                                               		print("<script language='javascript'>alert('non hai piu\' minuti disponibili!');</script>");
                                        }
                                        else
                                        {
                                                if($internet<>"")
                                        		print("<script language='javascript'>alert('numero di minuti non corretto!');</script>");
                                        }
                        	}
                		else
                			print("<script language='javascript'>alert('numero di tessera non presente!');</script>");
                	}
                	else
                        	print("<script language='javascript'>alert('inserire un valore numerico!');</script>");
        	}
         }
    ?>
    </body>
</html>


