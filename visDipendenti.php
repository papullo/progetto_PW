<?php
	include ("XHTMLfunctions.php");
    <div id="menu">
			   <div id="page" class="container">
					$query = mysql_query("SELECT * FROM Personale order by cognome,nome");
               	$border="1";
				 		$cellspacing="1";
				 		$cellpadding="0";
				 		$indici=th("cod_fiscale").th("cognome").th("nome").th("indirizzo").th("orario").th("tipologia").th();
				 		$corpo=tr($indici);
				 			
							$riga_dati.=td($row['orario']);							

							$riga_dati.=td($data['tipologia']);
                     	  	$azioni= "<input type=button value=\"Cancella\" onclick=\"location.href='cancDipendenti.php?action=cancvis&id=".$row['cod_fiscale']."'\"</center>";
                     	  	$azioni.="<br>";
   	                    	$riga_dati.=td($azioni);
						echo table($corpo, $border, $cellspacing, $cellpadding);
				}
				mysql_close($con);