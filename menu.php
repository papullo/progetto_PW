
<div id="marketing">
<ul id="menu">
  <li><a href="home.php">Home</a></li>
  <!--gestione dipendenti-->
  <?if(Abilitato(PERM_DIPENDENTI)){?>
  <li><a href="">Gestione Dipendenti</a>
    <ul>
    <li><a href="insDipendenti.php">Inserimento nuovo dipendente</a></li>
    <li><a href="visDipendenti.php">Visualizza dipendente</a></li>   
    </ul>
  </li>
  <?}?>
  <!--gestione vis clienti-->
  <?if(Abilitato(PERM_VISCLIENTI)){?>
  <li><a href="">Gestione Clienti</a>
    <ul>
    <li><a href="visClienti.php">Visualizza elenco clienti</a></li>
    </ul>
    <?}?>
    <!--gestione ins clienti-->
    <?if(Abilitato(PERM_CLIENTI)){?>
    <ul>
    <li><a href="insClienti.php">Inserimento nuovo clienti</a></li>
    </ul>
    <?}?>
  </li>
  <!--gestione eventi-->
  <?if(Abilitato(PERM_EVENTI)){?>
  <li><a href="">Gestione Eventi</a>
    <ul>
    <li><a href="insEventi.php">Inserimento nuovo evento</a></li>
    <li><a href="visEventi.php">Visualizza evento</a></li>
    <li><a href="visRelatori.php">Visualizza relatori</a></li>
    </ul>
  </li>
  <?}?>
  <!--gestione riviste-->
  <?if(Abilitato(PERM_RIVISTE)){?>
  <li><a href="">Gestione Riviste</a>
    <ul>
    <li><a href="insRiviste.php">Inserimento nuova rivista</a></li>
    <li><a href="visRiviste.php">Visualizza riviste</a></li>   
    </ul>
  </li>
  <?}?>
  <!--gestione libri-->
  <?if(Abilitato(PERM_LIBRI)){?>
  <li><a href="">Gestione Libri</a>
    <ul>
    <li><a href="insLibri.php">Inserimento nuovo libro</a></li>
    <li><a href="cercaLibri.php">Ricerca libro</a></li>   
    </ul>
  </li>
  <?}?>
  <!--gestione stampe-internet-->
  <?if(Abilitato(PERM_STAMPE_INTERNET)){?>
  <li><a href="">Gestione stampe/internet</a>
    <ul>
    <li><a href="stampaInternet.php">Inserimento</a></li>
    </ul>
  </li>
  <?}?>
</ul>
</div>
