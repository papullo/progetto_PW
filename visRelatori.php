<?php
	include ("XHTMLfunctions.php");
    <div id="menu">
				<div id="page" class="container">
				<?php
					$query = mysql_query("SELECT * FROM Relatore ORDER BY cognome,nome");
   				if($righe != 0)
               	$border="1";
				 		$cellspacing="1";
				 		$cellpadding="0";
				 		$indici=th("cognome").th("nome").th("cod_fiscale").th("indirizzo").th("telefono").th("e-mail");
				 		$corpo=tr($indici);
							$riga_dati=td($row['cognome']).td($row['nome']).td($row['cod_fiscale']);
							$riga_dati.=td($row['indirizzo']).td($row['telefono']).td($row['mail']);
							if($_SESSION['tipo']=='direttore')
                     	$azioni="<input type=button value=\"Cancella\" onclick=\"location.href='cancRelatori.php?action=cancvis&id=".$row['cod_fiscale']."'\"</center>";
								$azioni.="<input type=button value=\"Modifica\" onclick=\"location.href='modRelatori.php?action=modvis&id=".$row['cod_fiscale']."'\"</center>";
							}
							$corpo.=tr($riga_dati);
						echo table($corpo, $border, $cellspacing, $cellpadding);