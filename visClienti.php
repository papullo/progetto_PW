<?php
	include ("XHTMLfunctions.php");
    <div id="menu">
				<div id="page" class="container">
				<?php
				$query = mysql_query("SELECT * FROM Cliente ORDER BY cognome, nome");
				 	$cellspacing="1";
				 	$cellpadding="0";
				 	$indici=th("cognome").th("nome").th("tessera").th("indirizzo").th("data di nascita");
				 	$indici.=th("telefono").th("stampe").th("min internet").th("password");
				 	$corpo=tr($indici);					
					while($row=mysql_fetch_array($query,MYSQL_BOTH))
						$date=mysql_fetch_array($datequery);
						$riga_dati.=td($row['data_nascita']).td($row['telefono']);

              			$azioni.="<input type=button value=\"Modifica\" onclick=\"location.href='modClienti.php?action=modvis&id=".$row['id_cliente']."'\"</center>";
					echo table($corpo, $border, $cellspacing, $cellpadding);
				mysql_close($con);