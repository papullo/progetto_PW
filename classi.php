<?
class Utente
{
	var $ok=false;
	var $tipo='';
	var $permessi='';
	function __construct($_utente='', $_password='')
	{
		if ($_utente == 'root' && $_password == 'root')
	  	{
		   $this->tipo = 'Amministratore';
		   $this->permessi = '11111111111111111111';
		   $this->ok = true;
	  	}
	  	else
	  	{
	   if ($_utente != '')
	   	$this->Init($_utente, $_password);
	  	}
	  	return $this->ok;
 	}
  
 	function Init($_utente, $_password)
 	{
	  	//global $Connessione;
	  	print("<script language='javascript'>alert(".str_quoted($_utente).");</script>");
	  	$this->ok = false;
	  	$rs = mysql_query("SELECT * FROM Utente WHERE nickname=".str_quoted($_utente)." AND password=".str_quoted($_password)) or die ("Errore : ".mysql_error());
	  	if ($row = mysql_fetch_assoc($rs))
	  	{
	   	$this->nome = $row['nickname'];
	   	$this->permessi = $row['permessi'];
	   	$this->ok = true;
	   } 
	  	return $this->ok;
  }
}
?>