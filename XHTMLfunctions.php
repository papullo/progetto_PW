<?php
	function p($testo) {
		$risultato = '<p>' . $testo . '</p>';
		return $risultato;
		}
	
	function h($testo, $size) {
		$head = 'h' . $size;
		$risultato = "<$head>" . $testo . "</$head>";
		return $risultato;
		}
		
	function br($n) {
		$codice = '';
		for($i=0; $i<=$n; $i++)
			$codice .= '</br>';
		return $codice;
		}
	function hlink($ref, $label) {
		return "<a href='" . $ref . "'>" . $label . "</a> ";
		}
	function img($src, $width , $alt) {
		return "<img src='$src' width='$width' alt='$alt' />" ;
		}
	function ul($items) {
		return '<ul>' . $items . '</ul>';
		}
	function ol($items) {
		return '<ol>' . $items . '</ol>';
		}
	function li($item) {
		return '<li>' . $item . '</li>';
		}
	function form($action, $corpo) {
		$testo = "<form action='$action' method='post'>";
		$coda = '</form>';
		return $testo . $corpo . $coda;
		}
	function submit($name, $value) {
		return "<input type='submit' name='$name' value='$value'";
		}
	function button($name, $value) {
		return "<input type='button' name='$name' value='$value'";
		}
	//Completare con gli altri campi
	function table($corpo, $border, $cellspacing, $cellpadding) {
		$testa = "<table border='$border' cellspacing='$cellspacing' cellpadding='$cellpadding'";
		$coda = '</table>';
		return $testa . $corpo . $coda;
		}
	function tr($celle) {
		return "<tr>" . $celle . "</tr>";
		}
	function th($dato) {
		return "<th>" . $dato . "</th>";
		}
	function td($dato) {
		return "<td>" . $dato . "</td>";
		}
	function xhtml($titolo, $corpo, $style) {
		return "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 
		'http://www.w3.org/TR/xhtml1/strict.dtd'>
		<html xmlns='http:://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>
		<head>
			<meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1' />
			<title>{$title}</title>
			<link rel='stylesheet' type='text/css' href={$style} />
			</head>" .
			'<body>' . 
			h($titolo, 1) . 
			$corpo . 
			'</body>' .  
			'</html>'; 
	}
?>