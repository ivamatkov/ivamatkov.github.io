<?php

session_start();
include_once 'konfiguracijaBP.php';
include_once 'navigacija.php';

$tipKorisnika = isset($_SESSION['tipKorisnika']) ? $_SESSION['tipKorisnika'] : -1;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kreirani korisnici</title>
    <link href="aplikacija.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="zaglavlje">
    <h1>NARUČIVANJE RAČUNALA</h1>
</div>
<div id="navigacija">
    <ul>
        <?php
            prikaziNavigaciju($tipKorisnika);
        ?>
    </ul>
</div>
<section>
    <p><h3 style="text-align: center;">Kreirani korisnici</h3></p>
    <div style="width: 100%;">
        <table>
            <thead><th>Tip korisnika</th><th>Korisničko ime</th><th>Lozinka</th><th>Ime</th><th>Prezime</th><th>Email</th><th>Slika</th></thead>
            <tbody>
                <?php
                    otvoriBP();

                    $upitBP = "select k.*, t.naziv from korisnik k, tip_korisnika t where k.tip_id=t.tip_id";
                    $rezultatBP = izvrsiBP($upitBP);

                    while ($korisnik = mysqli_fetch_array($rezultatBP)){
                        echo "<tr>";
                        echo "<td>".$korisnik['naziv']."</td>";
                        echo "<td><a href='kreiraj_uredi_korisnika.php?korisnik=".$korisnik['korisnik_id']."'>".$korisnik['korisnicko_ime']."</a></td>";
                        echo "<td>".$korisnik['lozinka']."</td>";
                        echo "<td>".$korisnik['ime']."</td>";
                        echo "<td>".$korisnik['prezime']."</td>";
                        echo "<td>".$korisnik['email']."</td>";
                        echo "<td><img src='".$korisnik['slika']."' width='100' height='125'></td>";
                        echo "</tr>";
                    }

                    zatvoriBP();
                ?>
            </tbody>
        </table>
    </div>
</section>
<div id="podnozje">
    <div style="width: 30%; float: left;">
        Matković Ivan<br/>
        IWA 2016<br/>
    </div>
    <div style="width: 30%; float: right;">
        <a href="mailto:ivamatkov@foi.hr">ivamatkov@foi.hr</a><br/>
        Varaždin, srpanj 2018.
    </div>
</div>
</body>
</html>