<?php

session_start();
include_once 'konfiguracijaBP.php';
include_once 'navigacija.php';

$tipKorisnika = isset($_SESSION['tipKorisnika']) ? $_SESSION['tipKorisnika'] : -1;

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['isporuci'])){
    otvoriBP();

    $upitBP = "select * from konfiguracija where konfiguracija_id=".$_GET['isporuci'];
    $rezultatBP = izvrsiBP($upitBP);
    $konfiguracija = mysqli_fetch_array($rezultatBP);

    $upitBP = "update narudzba set status='I', datum_dostave='".date('Y-m-d')."' where narudzba_id=".$konfiguracija['narudzba_id'];
    $rezultatBP = izvrsiBP($upitBP);
    zatvoriBP();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Isporuči prihvaćene narudžbe</title>
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
    <p><h3 style="text-align: center;">Isporuči prihvaćene narudžbe</h3></p>
    <div style="width: 100%;">
        <table>
            <thead><th>Proizvođač konfiguracije</th><th>Naziv konfiguracije</th><th>Procesor</th><th>Radna memorija</th><th>Tvrdi disk</th><th>Grafička kartica</th><th>Trajanje baterije</th><th>Boja</th><th>Ekran</th><th>Datum kreiranja</th><th>Datum isporuke</th><th>Vrijeme isporuke</th><th>Isporuči narudžbu</th></thead>
            <tbody>
            <?php
            otvoriBP();
            $upitBP = "SELECT k.*, n.*, p.naziv as nazivProizvodaca FROM konfiguracija k, narudzba n, proizvodac p WHERE k.proizvodac_id=p.proizvodac_id and k.narudzba_id = n.narudzba_id AND n.status = 'P' ORDER BY n.datum_isporuke ASC";
            $rezultatBP = izvrsiBP($upitBP);
            zatvoriBP();

            if (mysqli_num_rows($rezultatBP) == 0){
                echo "<tr>";
                echo "<td colspan='13'>Nemate niti jednu narudžbu koju možete isporučiti!</td>";
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
                    echo "<td>".date("d.m.Y", strtotime($konfiguracija['datum_isporuke']))."</td>";
                    echo "<td>".date("H:i:s", strtotime($konfiguracija['vrijeme_isporuke']))."</td>";
                    echo "<td>";
                    echo "<a href='isporuci_narudzbe.php?isporuci=".$konfiguracija['konfiguracija_id']."'>Isporuči narudžbu</a>";
                    echo "</td>";
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
