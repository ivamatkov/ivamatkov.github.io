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
    <title>Kreirane narudžbe</title>
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
    <p><h3 style="text-align: center;">Kreirane narudžbe</h3></p>
    <div style="width: 100%;">
        <table>
            <thead><th>Proizvođač konfiguracije</th><th>Naziv konfiguracije</th><th>Procesor</th><th>Radna memorija</th><th>Tvrdi disk</th><th>Grafička kartica</th><th>Trajanje baterije</th><th>Boja</th><th>Ekran</th><th>Datum kreiranja</th><th>Status narudžbe</th></thead>
            <tbody>
            <?php
                otvoriBP();
                $upitBP = "select k.*, p.naziv as nazivProizvodaca, n.datum_kreiranja, n.status from konfiguracija k, proizvodac p, narudzba n where k.korisnik_id=".$_SESSION['idKorisnika']." and k.proizvodac_id=p.proizvodac_id and k.narudzba_id=n.narudzba_id and n.status<>''";
                $rezultatBP = izvrsiBP($upitBP);
                zatvoriBP();

                if (mysqli_num_rows($rezultatBP) == 0){
                    echo "<tr>";
                    echo "<td colspan='11'>Nemate niti jednu narudžbu!</td>";
                    echo "</tr>";
                }
                else {
                    while ($konfiguracija = mysqli_fetch_array($rezultatBP)){
                        echo "<tr>";
                        echo "<td>".$konfiguracija['nazivProizvodaca']."</td>";
                        echo "<td>".$konfiguracija['naziv']."</td>";
                        echo "<td>".$konfiguracija['procesor']."</td>";
                        echo "<td>".$konfiguracija['radna_memorija']."</td>";
                        echo "<td>".$konfiguracija['tvrdi_disk']."</td>";
                        echo "<td>".$konfiguracija['graficka_kartica']."</td>";
                        echo "<td>".$konfiguracija['trajanje_baterije']."</td>";
                        echo "<td>".$konfiguracija['boja']."</td>";
                        echo "<td>".$konfiguracija['ekran']."</td>";
                        echo "<td>".date("d.m.Y", strtotime($konfiguracija['datum_kreiranja']))."</td>";
                        echo "<td>".$konfiguracija['status']."</td>";
                        echo "</tr>";
                    }
                }
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
