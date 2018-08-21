<?php
session_start();
include_once 'konfiguracijaBP.php';
include_once 'navigacija.php';
                       //uvjet ? if true: if false;
$tipKorisnika = isset($_SESSION['tipKorisnika']) ? $_SESSION['tipKorisnika'] : -1;

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Početna stranica</title>
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
    <p><h3 style="text-align: center;">Početna stranica</h3></p>
    <div style="width: 100%; margin-bottom: 20px;">
        <?php
            otvoriBP();
            $upitBP = "select * from proizvodac";
            $rezultatBP = izvrsiBP($upitBP);

            while ($proizvodac = mysqli_fetch_array($rezultatBP)){
                echo "<a href='index.php?proizvodac=".$proizvodac['proizvodac_id']."'><div class='pocetna_proizvodaci'>".$proizvodac['naziv']."</div></a>";
            }

            zatvoriBP();
        ?>
    </div>

    <div style="width: 100%; clear: both;">
        <?php if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['proizvodac'])): ?>
        <table>
            <caption>Konfiguracije odabranog proizvođača računala</caption>
            <thead><th>Naziv konfiguracije</th><th>Procesor</th><th>Radna memorija</th><th>Tvrdi disk</th><th>Grafička kartica</th><th>Trajanje baterije</th><th>Boja</th><th>Ekran</th></thead>
            <tbody>
                <?php
                    otvoriBP();
                    $upitBP = "select * from konfiguracija where proizvodac_id=".$_GET['proizvodac'];
                    $rezultatBP = izvrsiBP($upitBP);

                    while ($konfiguracija = mysqli_fetch_array($rezultatBP)){
                        echo "<tr>";
                            echo "<td>".$konfiguracija['naziv']."</td>";
                            echo "<td>".$konfiguracija['procesor']."</td>";
                            echo "<td>".$konfiguracija['radna_memorija']."</td>";
                            echo "<td>".$konfiguracija['tvrdi_disk']."</td>";
                            echo "<td>".$konfiguracija['graficka_kartica']."</td>";
                            echo "<td>".$konfiguracija['trajanje_baterije']."</td>";
                            echo "<td>".$konfiguracija['boja']."</td>";
                            echo "<td>".$konfiguracija['ekran']."</td>";
                        echo "</tr>";
                    }

                    zatvoriBP();
                ?>
            </tbody>
        </table>
        <?php endif; ?>
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
