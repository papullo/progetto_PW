<?php
	include ("XHTMLfunctions.php");
	if(!isset($_SESSION['log'])) header("Location:index.php");
	<div id="menu">
		<div id="page" class="container">
			$query = mysql_query("SELECT * FROM Evento ORDER BY data DESC");
				$cellspacing="1";
				$cellpadding="0";
				$indici=th("data").th("titolo").th("ospite").th("descrizione").th();
				$corpo=tr($indici);			
				while($row=mysql_fetch_array($query,MYSQL_BOTH))
		 			$date=mysql_fetch_array($datequery);
               $query2=mysql_query("SELECT * FROM Ospite WHERE evento='$d'");
               $ospiti="";
                  $querynome=mysql_query("SELECT * FROM Relatore WHERE id_relatore='$r'");
                  if($dati['compenso']=="" or $dati['compenso']==0)
                  $ospiti.="<input type=button value=\"Elimina\" onclick=\"location.href='modEventi.php?action=cancOsp&data=".$d."&codF=".$r."&evento=".$t."'\"";
                  $ospiti.="<br>";
					$riga_dati.=td($row['descrizione']);
                	$azioni.="<input type=button value=\"Modifica\" onclick=\"location.href='modEventi.php?action=modvis&iddata=".$row['data']."&idtitolo=".$row['titolo']."'\"</center>";
                  $azioni.="<input type=button value=\"Ospiti\" onclick=\"location.href='insOspiti.php?action=insosp&iddata=".$row['data']."&idtitolo=".$row['titolo']."'\"</center>";
					}
					$corpo.=tr($riga_dati);
			}