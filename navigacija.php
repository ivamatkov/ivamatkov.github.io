<?php

 function prikaziNavigaciju($tipKorisnika){
     switch ($tipKorisnika){
         case -1:
             echo "<li><a href='o_autoru.html'>O autoru</a></li>";
             echo "<li><a href='index.php'>Početna stranica</a></li>";
             echo "<li><a href='prijava.php'>Prijava</a></li>";
             break;
         case 0:
             echo "<li><a href='o_autoru.html'>O autoru</a></li>";
             echo "<li><a href='index.php'>Početna stranica</a></li>";
             echo "<li><a href='kreirane_narudzbe.php'>Kreirane narudžbe</a></li>";
             echo "<li><a href='kreirane_konfiguracije.php'>Kreirane konfiguracije</a></li>";
             echo "<li><a href='kreiraj_uredi_konfiguraciju.php'>Kreiraj konfiguraciju</a></li>";
             echo "<li><a href='prihvati_odbij_narudzbe.php'>Prihvati/odbij kreirane narudžbe</a></li>";
             echo "<li><a href='ukupan_broj_narudzbi.php'>Ukupno narudžbi u periodu</a></li>";
             echo "<li><a href='kreirani_korisnici.php'>Kreirani korisnici</a></li>";
             echo "<li><a href='kreiraj_uredi_korisnika.php'>Kreiraj korisnika</a></li>";
             echo "<li><a href='kreirani_proizvodaci.php'>Kreirani proizvođači</a></li>";
             echo "<li><a href='kreiraj_uredi_proizvodaca.php'>Kreiraj proizvođača</a></li>";
             echo "<li><a href='isporuci_narudzbe.php'>Isporuči prihvaćene narudžbe</a></li>";
             echo "<li><a href='filtriraj_konfiguracije_korisnika.php'>Filtriraj konfiguracije korisnika</a></li>";
             echo "<li><a href='odjava.php'>Odjava</a></li>";
             break;
         case 1:
             echo "<li><a href='o_autoru.html'>O autoru</a></li>";
             echo "<li><a href='index.php'>Početna stranica</a></li>";
             echo "<li><a href='kreirane_narudzbe.php'>Kreirane narudžbe</a></li>";
             echo "<li><a href='kreirane_konfiguracije.php'>Kreirane konfiguracije</a></li>";
             echo "<li><a href='kreiraj_uredi_konfiguraciju.php'>Kreiraj konfiguraciju</a></li>";
             echo "<li><a href='prihvati_odbij_narudzbe.php'>Prihvati/odbij kreirane narudžbe</a></li>";
             echo "<li><a href='ukupan_broj_narudzbi.php'>Ukupno narudžbi u periodu</a></li>";
             echo "<li><a href='odjava.php'>Odjava</a></li>";
             break;
         case 2:
             echo "<li><a href='o_autoru.html'>O autoru</a></li>";
             echo "<li><a href='index.php'>Početna stranica</a></li>";
             echo "<li><a href='kreirane_narudzbe.php'>Kreirane narudžbe</a></li>";
             echo "<li><a href='kreirane_konfiguracije.php'>Kreirane konfiguracije</a></li>";
             echo "<li><a href='kreiraj_uredi_konfiguraciju.php'>Kreiraj konfiguraciju</a></li>";
             echo "<li><a href='odjava.php'>Odjava</a></li>";
             break;
         default:
             break;
     }
 }

?>