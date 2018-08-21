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
    <title>Kreirani proizvođači</title>
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
    <p><h3 style="text-align: center;">Kreirani proizvođači</h3></p>
    <div style="width: 100%;">
        <table>
            <thead><th>Naziv proizvođača</th><th>Moderator</th></thead>
            <tbody>
            <?php
                otvoriBP();

                $upitBP = "select p.*, k.korisnicko_ime from proizvodac p, korisnik k where p.moderator_id=k.korisnik_id";
                $rezultatBP = izvrsiBP($upitBP);

                while ($proizvodac = mysqli_fetch_array($rezultatBP)){
                    echo "<tr>";
                    echo "<td><a href='kreiraj_uredi_proizvodaca.php?proizvodac=".$proizvodac['proizvodac_id']."'>".$proizvodac['naziv']."</a></td>";
                    echo "<td>".$proizvodac['korisnicko_ime']."</td>";
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